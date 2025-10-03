@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add Consultation</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('consultations.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="patient_id" class="form-label">Patient</label>
                <select name="patient_id" id="patient_id" class="form-control" required>
                    <option value="">-- Select Patient --</option>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="appointment_id" class="form-label">Appointment (optional)</label>
                <select name="appointment_id" id="appointment_id" class="form-control">
                    <option value="">-- None --</option>
                    @foreach ($appointments as $appointment)
                        <option value="{{ $appointment->id }}">Appointment #{{ $appointment->id }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="doctor_id" class="form-label">Doctor (optional)</label>
                <input type="number" name="doctor_id" id="doctor_id" class="form-control" placeholder="Doctor ID">
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea name="notes" id="notes" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label for="diagnosis" class="form-label">Diagnosis</label>
                <textarea name="diagnosis" id="diagnosis" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label for="treatment" class="form-label">Treatment</label>
                <textarea name="treatment" id="treatment" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label for="next_visit" class="form-label">Next Visit</label>
                <input type="date" name="next_visit" id="next_visit" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Save Consultation</button>
        </form>
    </div>
@endsection
