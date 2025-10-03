@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Consultation Details</h2>

        <div class="card">
            <div class="card-body">
                <p><strong>Patient:</strong> {{ $consultation->patient->name ?? '-' }}</p>
                <p><strong>Doctor:</strong> {{ $consultation->doctor->name ?? '-' }}</p>
                <p><strong>Appointment:</strong>
                    {{ $consultation->appointment ? 'Appointment #' . $consultation->appointment->id : '-' }}</p>
                <p><strong>Notes:</strong> {{ $consultation->notes ?? '-' }}</p>
                <p><strong>Diagnosis:</strong> {{ $consultation->diagnosis ?? '-' }}</p>
                <p><strong>Treatment:</strong> {{ $consultation->treatment ?? '-' }}</p>
                <p><strong>Next Visit:</strong> {{ $consultation->next_visit ?? '-' }}</p>
            </div>
        </div>

        <a href="{{ route('consultations.index') }}" class="btn btn-secondary mt-3">Back to List</a>
        <a href="{{ route('consultations.edit', $consultation) }}" class="btn btn-warning mt-3">Edit</a>
    </div>
@endsection
