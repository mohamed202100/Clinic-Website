@extends('layouts.app')

@section('content')
<div class="container">
    <h2><i class="fas fa-edit"></i> Edit Appointment</h2>
    @include('profile.partials.flash-messages')

    <form action="{{ route('appointments.update', $appointment) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Patient Selection -->
        @include('components.form-select', [
            'name' => 'patient_id',
            'label' => 'Patient',
            'options' => $patients->pluck('name', 'id')->toArray(),
            'value' => old('patient_id', $appointment->patient_id),
            'required' => true,
            'emptyText' => '-- Select Patient --'
        ])

        <!-- Doctor and Time Slot Selection -->
        @include('components.simple-slot-selector', [
            'doctors' => $doctors,
            'selectedDate' => old('appointment_date_date', $appointment->appointment_date->format('Y-m-d')),
            'selectedDoctor' => old('doctor_id', $appointment->doctor_id),
            'appointmentId' => $appointment->id,
            'currentTime' => old('appointment_time', $appointment->appointment_date->format('H:i'))
        ])

        <!-- Pre-select current appointment time -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Set the current appointment time in the time slot selector
                setTimeout(function() {
                    const currentTime = "{{ $appointment->appointment_date->format('Y-m-d\TH:i') }}";
                    const timeSlotSelect = document.getElementById('time_slot_selector');
                    const hiddenDateTime = document.getElementById('appointment_date');
                    
                    if (timeSlotSelect && hiddenDateTime) {
                        // Add current appointment option if not already loaded
                        const currentOption = timeSlotSelect.querySelector(`option[value="${currentTime}"]`);
                        if (!currentOption) {
                            const option = document.createElement('option');
                            option.value = currentTime;
                            option.textContent = "{{ $appointment->appointment_date->format('g:i A') }}";
                            option.selected = true;
                            timeSlotSelect.appendChild(option);
                            timeSlotSelect.disabled = false;
                        } else {
                            currentOption.selected = true;
                        }
                        hiddenDateTime.value = currentTime;
                    }
                }, 1000);
            });
        </script>

        <!-- Status -->
        @include('components.form-select', [
            'name' => 'status',
            'label' => 'Status',
            'options' => [
                'pending' => 'Pending',
                'confirmed' => 'Confirmed',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled'
            ],
            'value' => old('status', $appointment->status),
            'required' => true
        ])

        <!-- Notes -->
        @include('components.form-textarea', [
            'name' => 'notes',
            'label' => 'Notes',
            'value' => old('notes', $appointment->notes),
            'placeholder' => 'Enter any appointment notes or special requirements',
            'rows' => 3
        ])

        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Update Appointment
        </button>
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Cancel
        </a>
    </form>
</div>

@section('slot-script')
@include('components.slot-selector')
@endsection
@endsection