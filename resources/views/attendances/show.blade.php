@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Attendance Details</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Patient: {{ $attendance->patient->name }}</h5>

                <p><strong>Appointment:</strong>
                    {{ $attendance->appointment ? $attendance->appointment->appointment_date->format('Y-m-d H:i') : 'N/A' }}
                </p>

                <p><strong>Check-in Time:</strong>
                    {{ $attendance->checkin_at ? $attendance->checkin_at->format('Y-m-d H:i') : '-' }}
                </p>

                <p><strong>Check-out Time:</strong>
                    {{ $attendance->checkout_at ? $attendance->checkout_at->format('Y-m-d H:i') : '-' }}
                </p>

                <p><strong>Status:</strong>
                    <span
                        class="badge
                    @if ($attendance->status == 'present') bg-success
                    @elseif($attendance->status == 'absent') bg-danger
                    @else bg-warning @endif">
                        {{ ucfirst($attendance->status) }}
                    </span>
                </p>

                <a href="{{ route('attendances.edit', $attendance->id) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
