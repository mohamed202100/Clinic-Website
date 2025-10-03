<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Patient;
use App\Models\Appointment;
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
        $appointments = Appointment::where('status', 'scheduled')->get();
        return view('attendances.create', compact('patients', 'appointments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'checkin_at' => 'nullable|date',
            'checkout_at' => 'nullable|date',
            'status' => 'required|in:present,absent',
        ]);

        Attendance::create($data);

        return redirect()->route('attendances.index')->with('success', 'Attendance recorded successfully.');
    }

    public function show(Attendance $attendance)
    {
        return view('attendances.show', compact('attendance'));
    }

    public function edit(Attendance $attendance)
    {
        $patients = Patient::all();
        $appointments = Appointment::all();
        return view('attendances.edit', compact('attendance', 'patients', 'appointments'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'checkin_at' => 'nullable|date',
            'checkout_at' => 'nullable|date',
            'status' => 'required|in:present,absent',
        ]);

        $attendance->update($data);

        return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendances.index')->with('success', 'Attendance deleted successfully.');
    }
}
