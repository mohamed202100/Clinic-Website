@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Appointments</h2>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary">Add Appointment</a>
    </div>

    @if ($appointments->count())
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ $appointment->patient->name }}</td>
                        <td>{{ $appointment->appointment_date->format('Y-m-d H:i') }}</td>
                        <td>{{ ucfirst($appointment->status) }}</td>
                        <td>{{ $appointment->notes }}</td>
                        <td>
                            <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('appointments.destroy', $appointment) }}" method="POST"
                                style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $appointments->links() }}
    @else
        <p>No appointments found.</p>
    @endif
@endsection
