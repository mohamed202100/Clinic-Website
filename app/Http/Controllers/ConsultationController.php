<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Attendance;
use App\Models\User;
use App\Http\Requests\ConsultationRequest;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::with(['patient', 'doctor', 'attendance'])
            ->latest()
            ->paginate(10);

        return view('consultations.index', compact('consultations'));
    }

    public function create()
    {
        $patients = Patient::all();
        $attendances = Attendance::all();
        $doctors =  User::where('role', '=', 'doctor')->get();

        return view('consultations.create', compact('patients', 'attendances', 'doctors'));
    }

    public function store(ConsultationRequest $request)
    {
        Consultation::create($request->validated());
        return redirect()->route('consultations.index')->with('success', 'Consultation created successfully.');
    }

    public function show(Consultation $consultation)
    {
        $consultation->load(['patient', 'doctor', 'appointment']);
        return view('consultations.show', compact('consultation'));
    }

    public function edit(Consultation $consultation)
    {
        $patients = Patient::all();
        $doctors = User::where('role', 'doctor')->get();
        $attendances = Attendance::where('patient_id', $consultation->patient_id)->get();

        return view('consultations.edit', compact('consultation', 'patients', 'doctors', 'attendances'));
    }

    public function update(Request $request, Consultation $consultation)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'attendance_id' => 'nullable|exists:attendances,id',
            'doctor_id' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'next_visit' => 'nullable|date',
        ]);

        $consultation->update($validated);

        return redirect()->route('consultations.index')->with('success', 'Consultation updated successfully.');
    }

    public function destroy(Consultation $consultation)
    {
        $consultation->delete();
        return redirect()->route('consultations.index')->with('success', 'Consultation deleted successfully.');
    }
}
