<?php

namespace App\Services;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class AppointmentSlotService
{
    protected $workingHours;
    protected $slotDuration;
    protected $appointmentDuration;

    public function __construct()
    {
        $this->workingHours = Config::get('clinic.working_hours');
        $this->slotDuration = Config::get('clinic.slot_duration');
        $this->appointmentDuration = Config::get('clinic.appointment_duration');
    }

    /**
     * Get available time slots for a specific date and doctor
     */
    public function getAvailableSlots(Carbon $date, $doctorId, $appointmentId = null)
    {
        // Check if date is in working days
        if (!$this->isWorkingDay($date)) {
            return [];
        }

        $existingAppointments = $this->getExistingAppointments($date, $doctorId, $appointmentId);
        $timeSlots = $this->generateTimeSlots($date);
        
        return $this->filterAvailableSlots($timeSlots, $existingAppointments);
    }

    /**
     * Check if a specific datetime slot is available
     */
    public function isSlotAvailable(Carbon $datetime, $doctorId, $appointmentId = null)
    {
        $existingAppointments = $this->getExistingAppointments($datetime->copy()->startOfDay(), $doctorId, $appointmentId);
        
        foreach ($existingAppointments as $appointment) {
            $appointmentStart = Carbon::parse($appointment->appointment_date);
            $appointmentEnd = $appointmentStart->copy()->addMinutes($this->appointmentDuration);
            
            if ($datetime->between($appointmentStart, $appointmentEnd->subMinute())) {
                return false;
            }
        }
        
        return true;
    }

    /**
                 * Check if date is within working days
                 */
    private function isWorkingDay(Carbon $date)
    {
        return in_array($date->dayOfWeekIso, $this->workingHours['working_days']);
    }

    /**
                 * Generate all possible time slots for a date
                 */
    private function generateTimeSlots(Carbon $date)
    {
        $startTime = Carbon::parse($date->format('Y-m-d') . ' ' . $this->workingHours['start_time']);
        $endTime = Carbon::parse($date->format('Y-m-d') . ' ' . $this->workingHours['end_time']);
        $breakStart = Carbon::parse($date->format('Y-m-d') . ' ' . $this->workingHours['break_start']);
        $breakEnd = Carbon::parse($date->format('Y-m-d') . ' ' . $this->workingHours['break_end']);
        
        $slots = [];
        $current = $startTime->copy();
        
        while ($current < $endTime) {
            // Skip break time
            if (!$this->isDuringBreak($current, $breakStart, $breakEnd)) {
                // Don't allow booking in the past
                if ($current->greaterThan(Carbon::now())) {
                    $slots[] = [
                        'datetime' => $current->copy(),
                        'formatted' => $current->format('H:i'),
                        'available' => true
                    ];
                }
            }
            
            $current->addMinutes($this->slotDuration);
        }
        
        return $slots;
    }

    /**
                 * Check if time is during break
                 */
    private function isDuringBreak(Carbon $time, Carbon $breakStart, Carbon $breakEnd)
    {
        return $time->between($breakStart, $breakEnd->subMinute());
    }

    /**
                 * Get existing appointments for a date and doctor
                 */
    private function getExistingAppointments(Carbon $date, $doctorId, $appointmentId = null)
    {
        $query = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $date);
            
        if ($appointmentId) {
            $query->where('id', '!=', $appointmentId);
        }
        
        return $query->get();
    }

                /**
     * Filter out occupied slots
     */
    private function filterAvailableSlots(array $slots, $existingAppointments)
    {
        foreach ($slots as &$slot) {
            foreach ($existingAppointments as $appointment) {
                $appointmentStart = Carbon::parse($appointment->appointment_date);
                $appointmentEnd = $appointmentStart->copy()->addMinutes($this->appointmentDuration);
                
                if ($slot['datetime']->between($appointmentStart, $appointmentEnd->subMinute())) {
                    $slot['available'] = false;
                    break;
                }
            }
        }
        
        return array_values(array_filter($slots, fn($slot) => $slot['available']));
    }

    /**
     * Get next available slot after a given time
     */
    public function getNextAvailableSlot(Carbon $afterTime, $doctorId, $appointmentId = null)
    {
        // Parse slots data correctly
        $currentDate = $afterTime->copy()->startOfDay();
        $maxDate = $afterTime->copy()->addDays(Config::get('clinic.max_advance_booking'));
        
        while ($currentDate <= $maxDate) {
            if ($this->isWorkingDay($currentDate)) {
                $slots = $this->getAvailableSlots($currentDate, $doctorId, $appointmentId);
                
                foreach ($slots as $slot) {
                    if ($slot['datetime']->greaterThan($afterTime)) {
                        return $slot['datetime'];
                    }
                }
            }
            
            $currentDate->addDay();
        }
        
        return null; // No available slots found
    }

    /**
     * Format time slot for display
     */
    public function formatSlotForDisplay($slots)
    {
        return array_map(function($slot) {
            return [
                'value' => $slot['datetime']->format('Y-m-d\TH:i'),
                'label' => $slot['datetime']->format('g:i A'),
                'datetime' => $slot['datetime']
            ];
        }, $slots);
    }
}