@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Patient</h1>
        @include('profile.partials.flash-messages')

        <form action="{{ route('patients.store') }}" method="POST">
            @csrf
            @include('profile.partials.patient-form', ['buttonText' => 'Create Patient'])
        </form>
    </div>
@endsection
