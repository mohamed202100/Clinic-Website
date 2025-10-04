@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Patient</h1>
        @include('profile.partials.flash-messages')

        <form action="{{ route('patients.update', $patient) }}" method="POST">
            @csrf
            @if (isset($patient))
                @method('PUT')
            @endif

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $patient->name ?? '') }}" required>
            </div>

            <!-- Phone -->
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control"
                    value="{{ old('phone', $patient->phone ?? '') }}">
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                    value="{{ old('email', $patient->email ?? '') }}">
            </div>

            <!-- Date of Birth -->
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" name="dob" id="dob" class="form-control"
                    value="{{ old('dob', isset($patient->dob) ? $patient->dob->format('Y-m-d') : '') }}">
            </div>

            <!-- Address -->
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea name="address" id="address" class="form-control">{{ old('address', $patient->address ?? '') }}</textarea>
            </div>

            <!-- Notes -->
            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea name="notes" id="notes" class="form-control">{{ old('notes', $patient->notes ?? '') }}</textarea>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-success">{{ $buttonText ?? 'Save' }}</button>
            <a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancel</a>
        </form>

    </div>
@endsection
