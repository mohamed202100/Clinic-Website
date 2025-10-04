<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Http\Requests\AppointmentRequest;
use App\Services\AppointmentSlotService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    protected $slotService;

    public function __construct(AppointmentSlotService $slotService)
    {
        $this->slotService = $slotService;
    }
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'asc')->paginate(15);
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = User::where('role', '=', 'doctor')->get();
        return view('appointments.create', compact('patients', 'doctors'));
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today'
        ]);

        $date = \Carbon\Carbon::parse($request->date);
        $slots = $this->slotService->getAvailableSlots($date, $request->doctor_id);

        return response()->json([
            'available_slots' => $this->slotService->formatSlotForDisplay($slots)
        ]);
    }

    public function getConflicts(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date'
        ]);

        $fromTime = $request->date . ' 00:00:00';
        $toTime = $request->date . ' 23:59:59';

        $query = Appointment::where('doctor_id', $request->doctor_id)
            ->whereBetween('appointment_date', [$fromTime, $toTime]);

        if ($request->appointment_id) {
            $query->where('id', '!=', $request->appointment_id);
        }

        $appointments = $query->get();

        $conflicts = $appointments->map(function ($appointment) {
            return \Carbon\Carbon::parse($appointment->appointment_date)->format('H:i');
        });

        return response()->json([
            'conflicts' => $conflicts->toArray()
        ]);
    }

    public function store(AppointmentRequest $request)
    {
        $data = $request->validated();
        $data['appointment_date'] = str_replace('T', ' ', $data['appointment_date']);
        Appointment::create($data);
        return redirect()->route('appointments.index')->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();
        $doctors = User::where('role', '=', 'doctor')->get();

        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(AppointmentRequest $request, Appointment $appointment)
    {
        $data = $request->validated();
        $data['appointment_date'] = str_replace('T', ' ', $data['appointment_date']);
        $appointment->update($data);
        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment deleted.');
    }
}
