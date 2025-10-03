@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Clinic Dashboard</h1>

        <div class="row g-4">
            <!-- Patients -->
            <div class="col-md-4">
                <a href="{{ route('patients.index') }}" class="text-decoration-none">
                    <div class="card text-center shadow-sm p-4 h-100">
                        <h4>Patients</h4>
                    </div>
                </a>
            </div>

            <!-- Users -->
            <div class="col-md-4">
                <a href="{{ route('users.index') }}" class="text-decoration-none">
                    <div class="card text-center shadow-sm p-4 h-100">
                        <h4>Users</h4>
                    </div>
                </a>
            </div>

            <!-- Appointments -->
            <div class="col-md-4">
                <a href="{{ route('appointments.index') }}" class="text-decoration-none">
                    <div class="card text-center shadow-sm p-4 h-100">
                        <h4>Appointments</h4>
                    </div>
                </a>
            </div>

            <!-- Attendances -->
            <div class="col-md-4">
                <a href="{{ route('attendances.index') }}" class="text-decoration-none">
                    <div class="card text-center shadow-sm p-4 h-100">
                        <h4>Attendances</h4>
                    </div>
                </a>
            </div>

            <!-- Consultations -->
            <div class="col-md-4">
                <a href="{{ route('consultations.index') }}" class="text-decoration-none">
                    <div class="card text-center shadow-sm p-4 h-100">
                        <h4>Consultations</h4>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
