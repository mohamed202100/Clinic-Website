@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Attendances</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('attendances.create') }}" class="btn btn-primary">Add Attendance</a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient</th>
                    <th>Appointment</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->id }}</td>
                        <td>{{ $attendance->patient->name ?? '-' }}</td>
                        <td>{{ $attendance->appointment ? $attendance->appointment->appointment_date->format('Y-m-d H:i') : '-' }}
                        </td>
                        <td>{{ $attendance->checkin_at ? $attendance->checkin_at->format('Y-m-d H:i') : '-' }}</td>
                        <td>{{ $attendance->checkout_at ? $attendance->checkout_at->format('Y-m-d H:i') : '-' }}</td>
                        <td>{{ ucfirst($attendance->status) }}</td>
                        <td>{{ $attendance->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('attendances.show', $attendance) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('attendances.edit', $attendance) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('attendances.destroy', $attendance) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No attendance records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div>
            {{ $attendances->links() }}
        </div>
    </div>
@endsection
