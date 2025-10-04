@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-calendar-alt"></i> Appointments</h2>
            <a href="{{ route('appointments.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Schedule Appointment
            </a>
        </div>

        @if ($appointments->count())
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th><i class="fas fa-hashtag"></i> ID</th>
                            <th><i class="fas fa-user-injured"></i> Patient</th>
                            <th><i class="fas fa-user-md"></i> Doctor</th>
                            <th><i class="fas fa-clock"></i> Time Slot</th>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                            <th><i class="fas fa-sticky-note"></i> Notes</th>
                            <th><i class="fas fa-cogs"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr>
                                <td><span class="badge bg-primary">{{ $appointment->id }}</span></td>
                                <td>
                                    <strong>{{ $appointment->patient->name }}</strong><br>
                                    <small class="text-muted">{{ $appointment->patient->phone }}</small>
                                </td>
                                <td>
                                    <strong>{{ $appointment->doctor->name }}</strong><br>
                                    <small
                                        class="text-muted">{{ $appointment->doctor->specialization ?? 'General Medicine' }}</small>
                                </td>
                                <td>
                                    <strong>{{ $appointment->appointment_date->format('M d, Y') }}</strong><br>
                                    <span class="badge bg-info">
                                        {{ $appointment->appointment_date->format('g:i A') }} -
                                        {{ $appointment->appointment_date->addMinutes(25)->format('g:i A') }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'confirmed' => 'info',
                                            'completed' => 'success',
                                            'cancelled' => 'danger',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$appointment->status] ?? 'secondary' }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($appointment->notes)
                                        <small>{{ Str::limit($appointment->notes, 50) }}</small>
                                    @else
                                        <small class="text-muted">No notes</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('appointments.show', $appointment) }}"
                                            class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('appointments.edit', $appointment) }}"
                                            class="btn btn-sm btn-outline-secondary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('appointments.destroy', $appointment) }}" method="POST"
                                            style="display:inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit"
                                                onclick="return confirm('Are you sure you want to delete this appointment?')"
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                </table>
            </div>

            {{ $appointments->links() }}
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-calendar-times fa-3x mb-3"></i>
                <h4>No appointments found</h4>
                <p class="mb-0">There are no appointments scheduled yet. Click the button above to schedule your first
                    appointment!</p>
            </div>
        @endif
    </div>
@endsection
