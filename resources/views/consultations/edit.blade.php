@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Consultation</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('consultations.update', $consultation) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="patient_id" class="form-label">Patient</label>
                <select name="patient_id" id="patient_id" class="form-control" required>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}"
                            {{ $consultation->patient_id == $patient->id ? 'selected' : '' }}>
                            {{ $patient->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="appointment_id" class="form-label">Appointment (optional)</label>
                <select name="appointment_id" id="appointment_id" class="form-control">
                    <option value="">-- None --</option>
                    @foreach ($appointments as $appointment)
