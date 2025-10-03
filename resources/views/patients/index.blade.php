@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Patients</h1>
        @include('profile.partials.alerts')


        <a href="{{ route('patients.create') }}" class="btn btn-primary mb-3">Add Patient</a>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>DOB</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                    <tr>
                        <td>{{ $patient->id }}</td>
                        <td><a href="{{ route('patients.show', $patient) }}">{{ $patient->name }}</a></td>
                        <td>{{ $patient->dob ? $patient->dob->format('Y-m-d') : '-' }}</td>
                        <td>{{ ucfirst($patient->gender) }}</td>
                        <td>{{ $patient->phone ?? '-' }}</td>
                        <td>{{ $patient->address ?? '-' }}</td>
                        <td>
                            <a href="{{ route('patients.edit', $patient) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this patient?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No patients found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
