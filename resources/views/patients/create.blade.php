@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Patient</h1>
        @include('profile.partials.flash-messages')
        <form action="{{ route('patients.store') }}" method="POST">
            @csrf
            @if (isset($patient))
                @method('PUT')
            @endif

            <!-- Medical Record -->
            @include('components.form-input', [
                'name' => 'medical_record',
                'label' => 'Medical Record Number',
                'value' => old('medical_record', $patient->medical_record ?? ''),
                'required' => true,
                'placeholder' => 'Enter unique medical record number'
            ])

            <!-- Name -->
            @include('components.form-input', [
                'name' => 'name',
                'label' => 'Patient Name',
                'value' => old('name', $patient->name ?? ''),
                'required' => true,
                'placeholder' => 'Enter full name'
            ])

            <!-- Phone -->
            @include('components.form-input', [
                'name' => 'phone',
                'label' => 'Phone Number',
                'type' => 'tel',
                'value' => old('phone', $patient->phone ?? ''),
                'placeholder' => 'Enter phone number'
            ])

            <!-- Email -->
            @include('components.form-input', [
                'name' => 'email',
                'label' => 'Email Address',
                'type' => 'email',
                'value' => old('email', $patient->email ?? ''),
                'placeholder' => 'Enter email address'
            ])

            <!-- Date of Birth -->
            @include('components.form-input', [
                'name' => 'dob',
                'label' => 'Date of Birth',
                'type' => 'date',
                'value' => old('dob', isset($patient->dob) ? $patient->dob->format('Y-m-d') : '')
            ])

            <!-- Address -->
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" 
                    placeholder="Enter patient address">{{ old('address', $patient->address ?? '') }}</textarea>
                @error('address')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Notes -->
            <div class="mb-3">
                <label for="notes" class="form-label">Medical Notes</label>
                <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" 
                    placeholder="Enter any medical notes or comments">{{ old('notes', $patient->notes ?? '') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-success">{{ $buttonText ?? 'Save' }}</button>
            <a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancel</a>
        </form>

    </div>
@endsection
