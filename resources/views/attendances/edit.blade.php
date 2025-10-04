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
                <label class="form-label">Patient</label>
                <input type="text" class="form-control" value="{{ $patient->name }}" disabled>
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
            </div>

            <div class="mb-3">
                <label for="appointment_id" class="form-label">Appointment</label>
                <select name="appointment_id" id="appointment_id" class="form-control @error('appointment_id') is-invalid @enderror">
                    <option value="">-- No Appointment --</option>
                    @foreach ($appointments as $app)
                        <option value="{{ $app->id }}" {{ $attendance->appointment_id == $app->id ? 'selected' : '' }}>
                            {{ $app->appointment_date->format('M d, Y g:i A') }} - {{ ucfirst($app->status) }}
                        </option>
                    @endforeach
                </select>
                @error('appointment_id')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
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
                </select>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
