@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>📅 Schedule Appointment</h2>
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf

            @include('components.form-select', [
                'name' => 'patient_id',
                'label' => 'Patient',
                'options' => $patients->pluck('name', 'id')->toArray(),
                'value' => old('patient_id'),
                'required' => true,
                'emptyText' => '-- Select Patient --',
            ])

            @include('components.simple-slot-selector', [
                'doctors' => $doctors,
                'selectedDate' => old('appointment_date_date', ''),
                'selectedDoctor' => old('doctor_id', ''),
                'appointmentId' => null,
            ])

            @include('components.form-select', [
                'name' => 'status',
                'label' => 'Status',
                'options' => [
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'completed' => 'Completed',
                    'cancelled' => 'Cancelled',
                ],
                'value' => old('status', 'pending'),
                'required' => true,
            ])

            @include('components.form-textarea', [
                'name' => 'notes',
                'label' => 'Notes',
                'value' => old('notes'),
                'placeholder' => 'Enter any appointment notes or special requirements',
                'rows' => 3,
            ])

            <button type="submit" class="btn btn-success">
                <i class="fas fa-calendar-plus"></i> Schedule Appointment
            </button>
            <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </form>
    </div>
@endsection
