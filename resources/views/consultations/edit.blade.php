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
                <label for="attendance_id" class="form-label">Attendance (optional)</label>
                <select name="attendance_id" id="attendance_id" class="form-control">
                    <option value="">-- None --</option>
                    @foreach ($attendances as $attendance)
                        <option value="{{ $attendance->id }}"
                            {{ $consultation->attendance_id == $attendance->id ? 'selected' : '' }}>
                            {{ $attendance->checkin_at ? $attendance->checkin_at->format('Y-m-d H:i') : 'No Check-in' }}
                            — {{ $attendance->patient->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="doctor_id" class="form-label">Doctor</label>
                <select name="doctor_id" id="doctor_id" class="form-control" required>
                    <option value="">-- Select Doctor --</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}"
                            {{ $consultation->doctor_id == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="diagnosis" class="form-label">Diagnosis</label>
                <textarea name="diagnosis" id="diagnosis" class="form-control">{{ old('diagnosis', $consultation->diagnosis) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="treatment" class="form-label">Treatment</label>
                <textarea name="treatment" id="treatment" class="form-control">{{ old('treatment', $consultation->treatment) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea name="notes" id="notes" class="form-control">{{ old('notes', $consultation->notes) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="next_visit" class="form-label">Next Visit</label>
                <input type="date" name="next_visit" id="next_visit" class="form-control"
                    value="{{ old('next_visit', $consultation->next_visit ? $consultation->next_visit : '') }}">
            </div>

            <button type="submit" class="btn btn-success">Update Consultation</button>
            <a href="{{ route('consultations.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
