@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Patient</h1>
        @include('profile.partials.flash-messages')

        <form action="{{ route('patients.update', $patient) }}" method="POST">
            @csrf @method('PUT')
            @include('profile.partials.form', ['buttonText' => 'Update Patient'])
        </form>
    </div>
@endsection
