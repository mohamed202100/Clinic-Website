@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>User Details</h1>
        <div class="card p-3">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
            <p><strong>Specialization:</strong> {{ $user->specialization ?? '-' }}</p>
            <p><strong>Phone:</strong> {{ $user->phone ?? '-' }}</p>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
@endsection
