@extends('layouts.app')

@section('content')
    <h2>Appointment Details</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Patient: {{ $appointment->patient->name }}</h5>
            <p><strong>Date & Time:</strong> {{ $appointment->appointment_date->format('Y-m-d H:i') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
            <p><strong>Notes:</strong> {{ $appointment->notes ?? '-' }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-secondary">Edit</a>
        <a href="{{ route('appointments.index') }}" class="btn btn-primary">Back to List</a>
    </div>
@endsection
