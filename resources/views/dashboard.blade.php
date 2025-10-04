@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">🏥 Clinic Dashboard</h1>
        @auth
            <div class="text-muted">
                Welcome back, {{ Auth::user()->name }}
                @if(Auth::user()->role === 'doctor' && Auth::user()->specialization)
                    <br><small>{{ Auth::user()->specialization }}</small>
                @endif
            </div>
        @endauth
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                        <div class="d-flex align-items-center">
                        <div>
                            <h5 class="card-title">Total Patients</h5>
                            <h2 class="mb-0">{{ \App\Models\Patient::count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h5 class="card-title">Today's Appointments</h5>
                            <h2 class="mb-0">{{ \App\Models\Appointment::whereDate('appointment_date', today())->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h5 class="card-title">Doctors</h5>
                            <h2 class="mb-0">{{ \App\Models\User::where('role', 'doctor')->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h5 class="card-title">Recent Consultations</h5>
                            <h2 class="mb-0">{{ \App\Models\Consultation::whereDate('created_at', '>=', now()->subDays(7))->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Cards -->
    <div class="row g-4">
        <!-- Patients -->
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('patients.index') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm p-4 h-100 border-0" style="border-left: 4px solid #28a745 !important;">
                    <div class="card-body">
                        <i class="fas fa-user-injured fa-3x text-success mb-3"></i>
                        <h4 class="card-title">Patients</h4>
                        <p class="card-text text-muted">Manage patient records and medical information</p>
                        <small class="text-success">View & Add Patients</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Appointments -->
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('appointments.index') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm p-4 h-100 border-0" style="border-left: 4px solid #007bff !important;">
                    <div class="card-body">
                        <i class="fas fa-calendar-alt fa-3x text-primary mb-3"></i>
                        <h4 class="card-title">Appointments</h4>
                        <p class="card-text text-muted">Schedule and manage appointment bookings</p>
                        <small class="text-primary">Schedule Appointments</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Attendance -->
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('attendances.index') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm p-4 h-100 border-0" style="border-left: 4px solid #ffc107 !important;">
                    <div class="card-body">
                        <i class="fas fa-user-check fa-3x text-warning mb-3"></i>
                        <h4 class="card-title">Attendance</h4>
                        <p class="card-text text-muted">Track patient check-ins and visits</p>
                        <small class="text-warning">Record Attendance</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Consultations -->
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('consultations.index') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm p-4 h-100 border-0" style="border-left: 4px solid #6f42c1 !important;">
                    <div class="card-body">
                        <i class="fas fa-stethoscope fa-3x text-purple mb-3"></i>
                        <h4 class="card-title">Consultations</h4>
                        <p class="card-text text-muted">Manage consultation records and treatments</p>
                        <small class="text-purple">New Consultation</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Users (Admin only) -->
        @if(auth()->check() && auth()->user()->role === 'admin')
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('users.index') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm p-4 h-100 border-0" style="border-left: 4px solid #dc3545 !important;">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x text-danger mb-3"></i>
                        <h4 class="card-title">Users</h4>
                        <p class="card-text text-muted">Manage staff and user accounts</p>
                        <small class="text-danger">User Management</small>
                    </div>
                </div>
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
