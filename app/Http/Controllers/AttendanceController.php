<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Patient;
use App\Models\Appointment;
use App\Http\Requests\AttendanceRequest;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with(['patient', 'appointment'])->latest()->paginate(10);
        return view('attendances.index', compact('attendances'));
    }

    public function create()
    {
        $patients = Patient::all();
        return view('attendances.create', compact('patients'));
    }

    public function selectPatient(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
        ]);

        $patient = Patient::findOrFail($request->patient_id);
        $appointments = Appointment::where('patient_id', $patient->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        if ($appointments->isEmpty()) {
            return redirect()->route('appointments.create')
                ->with('warning', "This patient has no appointments, please book one first.");
        }

        return view('attendances.createStep2', compact('patient', 'appointments'));
    }


    public function store(AttendanceRequest $request)
    {
        $data = $request->validated();
        
        // Format datetime fields properly
        if ($data['checkin_at']) {
            $data['checkin_at'] = str_replace('T', ' ', $data['checkin_at']);
        }
        if ($data['checkout_at']) {
            $data['checkout_at'] = str_replace('T', ' ', $data['checkout_at']);
        }
        
        Attendance::create($data);
        return redirect()->route('attendances.index')->with('success', 'Attendance recorded successfully.');
    }

    public function show(Attendance $attendance)
    {
        return view('attendances.show', compact('attendance'));
    }

    public function edit(\App\Models\Attendance $attendance)
    {
        $patient = \App\Models\Patient::findOrFail($attendance->patient_id);

        $appointments = \App\Models\Appointment::where('patient_id', $patient->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date')
            ->get();

        return view('attendances.edit', compact('attendance', 'patient', 'appointments'));
    }

    public function update(AttendanceRequest $request, Attendance $attendance)
    {
        $data = $request->validated();
        $attendance->update($data);
        return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendances.index')->with('success', 'Attendance deleted successfully.');
    }
}
