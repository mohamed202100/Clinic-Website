<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clinic Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .text-purple { color: #6f42c1 !important; }
        .border-purple { border-color: #6f42c1 !important; }
        .bg-purple { background-color: #6f42c1 !important; }
        .navbar-brand { font-weight: bold; }
        .nav-link { padding: 0.75rem 1rem !important; }
        .nav-link i { margin-right: 0.5rem; }
        .card { transition: transform 0.2s ease-in-out; }
        .card:hover { transform: translateY(-2px); }
        .stats-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .form-control:focus { border-color: #6f42c1; box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.25); }
        .btn-primary { background-color: #6f42c1; border-color: #6f42c1; }
        .btn-primary:hover { background-color: #5a2b8a; border-color: #5a2b8a; }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-hospital"></i> Clinic Management
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('patients.index') }}"><i class="fas fa-user-injured"></i> Patients</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('appointments.index') }}"><i class="fas fa-calendar-alt"></i> Appointments</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('attendances.index') }}"><i class="fas fa-user-check"></i> Attendance</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('consultations.index') }}"><i class="fas fa-stethoscope"></i> Consultations</a></li>
                    @if(auth()->check() && auth()->user()->role === 'admin')
                    <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-users"></i> Users</a></li>
                    @endif
                </ul>
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @include('profile.partials.alerts')
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
