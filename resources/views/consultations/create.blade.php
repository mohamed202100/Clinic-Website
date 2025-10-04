@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Consultation</h2>

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
                <label for="attendance_id" class="form-label">Attendance (optional)</label>
                <select name="attendance_id" id="attendance_id" class="form-control">
                    <option value="">-- Select Attendance --</option>
                    @foreach ($attendances as $attendance)
                        <option value="{{ $attendance->id }}">
                            {{ $attendance->checkin_at->format('Y-m-d H:i') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="doctor_id" class="form-label">Doctor</label>
                <select name="doctor_id" id="doctor_id" class="form-control" required>
                    <option value="">-- Select Doctor --</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="diagnosis" class="form-label">Diagnosis</label>
                <textarea name="diagnosis" id="diagnosis" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="treatment" class="form-label">Treatment</label>
                <textarea name="treatment" id="treatment" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="next_visit" class="form-label">Next Visit</label>
                <input type="date" name="next_visit" id="next_visit" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Save Consultation</button>
        </form>
    </div>


@endsection
