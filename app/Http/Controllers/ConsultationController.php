<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::with(['patient', 'doctor', 'appointment'])
            ->latest()
            ->paginate(10);

        return view('consultations.index', compact('consultations'));
    }

    public function create()
    {
        $patients = Patient::all();
        $appointments = Appointment::all();

        return view('consultations.create', compact('patients', 'appointments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'doctor_id' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'next_visit' => 'nullable|date',
        ]);

        Consultation::create($validated);

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
        $appointments = Appointment::all();
        return view('consultations.edit', compact('consultation', 'patients', 'appointments'));
    }

    public function update(Request $request, Consultation $consultation)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
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
