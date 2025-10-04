<?php

namespace App\Http\Requests;

use App\Services\AppointmentSlotService;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 'doctor');
                }),
            ],
            'appointment_date' => [
                'required', 
                'date', 
                'after:now',
                function ($attribute, $value, $fail) {
                    $appointmentId = $this->route('appointment')?->id;
                    $datetime = Carbon::createFromFormat('Y-m-d\TH:i', $value);
                    
                    if (!$this->isSlotAvailable($datetime, $this->doctor_id, $appointmentId)) {
                        $fail('This time slot is already booked. Please choose another time.');
                    }
                }
            ],
            
            // Validate appointment_time separately if provided
            'appointment_time' => ['nullable', 'string', 'in:08:00,08:30,09:00,09:30,10:00,10:30,11:00,11:30,13:00,13:30,14:00,14:30,15:00,15:30,16:00,16:30,17:00'],
            'status' => ['required', 'in:pending,confirmed,completed,cancelled'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Check if a time slot is available
     */
    private function isSlotAvailable(Carbon $datetime, $doctorId, $appointmentId = null)
    {
        $query = \App\Models\Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $datetime->format('Y-m-d'))
            ->whereTime('appointment_date', $datetime->format('H:i'));

        if ($appointmentId) {
            $query->where('id', '!=', $appointmentId);
        }

        return !$query->exists();
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'patient_id.required' => 'Please select a patient.',
            'patient_id.exists' => 'Selected patient does not exist.',
            'doctor_id.required' => 'Please select a doctor.',
            'doctor_id.exists' => 'Selected doctor does not exist.',
            'appointment_date.required' => 'Appointment date is required.',
            'appointment_date.date' => 'Please enter a valid date.',
            'appointment_date.after' => 'Appointment date must be in the future.',
            'status.required' => 'Please select appointment status.',
            'status.in' => 'Invalid appointment status.',
            'notes.max' => 'Notes cannot exceed 500 characters.',
        ];
    }
}
