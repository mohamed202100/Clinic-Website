@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Patient Details</h1>
        <div class="card p-3">
            <p><strong>Name:</strong> {{ $patient->name }}</p>
            <p><strong>DOB:</strong> {{ $patient->dob ? $patient->dob->format('Y-m-d') : '-' }}</p>
            <p><strong>Gender:</strong> {{ ucfirst($patient->gender) }}</p>
            <p><strong>Phone:</strong> {{ $patient->phone ?? '-' }}</p>
            <p><strong>Address:</strong> {{ $patient->address ?? '-' }}</p>
        </div>
        <a href="{{ route('patients.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
@endsection
