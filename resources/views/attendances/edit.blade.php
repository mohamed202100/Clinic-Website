@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Attendance</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('attendances.update', $attendance->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="patient_id" class="form-label">Patient</label>
                <select name="patient_id" id="patient_id" class="form-control" required>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}" {{ $attendance->patient_id == $patient->id ? 'selected' : '' }}>
                            {{ $patient->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="appointment_id" class="form-label">Appointment</label>
                <select name="appointment_id" id="appointment_id" class="form-control">
                    <option value="">-- Optional --</option>
                    @foreach ($appointments as $appointment)
                        <option value="{{ $appointment->id }}"
                            {{ $attendance->appointment_id == $appointment->id ? 'selected' : '' }}>
                            {{ $appointment->appointment_date->format('Y-m-d H:i') }} - {{ $appointment->patient->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="checkin_at" class="form-label">Check-in Time</label>
                <input type="datetime-local" name="checkin_at" id="checkin_at" class="form-control"
                    value="{{ $attendance->checkin_at ? $attendance->checkin_at->format('Y-m-d\TH:i') : '' }}">
            </div>

            <div class="mb-3">
                <label for="checkout_at" class="form-label">Check-out Time</label>
                <input type="datetime-local" name="checkout_at" id="checkout_at" class="form-control"
                    value="{{ $attendance->checkout_at ? $attendance->checkout_at->format('Y-m-d\TH:i') : '' }}">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="present" {{ $attendance->status == 'present' ? 'selected' : '' }}>Present</option>
                    <option value="absent" {{ $attendance->status == 'absent' ? 'selected' : '' }}>Absent</option>
                    <option value="late" {{ $attendance->status == 'late' ? 'selected' : '' }}>Late</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
