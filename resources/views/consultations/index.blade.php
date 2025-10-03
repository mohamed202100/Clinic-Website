@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Consultations</h2>

        <a href="{{ route('consultations.create') }}" class="btn btn-primary mb-3">Add Consultation</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Diagnosis</th>
                    <th>Treatment</th>
                    <th>Next Visit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($consultations as $consultation)
                    <tr>
                        <td>{{ $consultation->id }}</td>
                        <td>{{ $consultation->patient->name ?? '-' }}</td>
                        <td>{{ $consultation->doctor->name ?? '-' }}</td>
                        <td>{{ $consultation->diagnosis ?? '-' }}</td>
                        <td>{{ $consultation->treatment ?? '-' }}</td>
                        <td>{{ $consultation->next_visit ?? '-' }}</td>
                        <td>
                            <a href="{{ route('consultations.show', $consultation) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('consultations.edit', $consultation) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('consultations.destroy', $consultation) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $consultations->links() }}
    </div>
@endsection
