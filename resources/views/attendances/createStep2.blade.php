@extends('layouts.app')

@section('content')
    <h2>Add Attendance for {{ $patient->name }}</h2>

    <form action="{{ route('attendances.store') }}" method="POST">
        @csrf
        <input type="hidden" name="patient_id" value="{{ $patient->id }}">

        <div class="mb-3">
            <label for="appointment_id" class="form-label">Appointment</label>
            <select name="appointment_id" id="appointment_id" class="form-control" required>
                @foreach ($appointments as $appointment)
                    <option value="{{ $appointment->id }}">
                        {{ $appointment->appointment_date->format('Y-m-d H:i') }} - {{ $patient->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="checkin_at" class="form-label">Check-in</label>
            <input type="datetime-local" name="checkin_at" class="form-control">
        </div>

        <div class="mb-3">
            <label for="checkout_at" class="form-label">Check-out</label>
            <input type="datetime-local" name="checkout_at" class="form-control">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="present">Present</option>
                <option value="absent">Absent</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save Attendance</button>
    </form>
@endsection
