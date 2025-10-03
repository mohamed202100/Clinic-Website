@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add User</h1>
        @include('profile.partials.flash-messages')

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            @include('profile.partials.user-form', ['buttonText' => 'Create User'])
        </form>
    </div>
@endsection
