@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit User</h1>
        @include('profile.partials.flash-messages')

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf @method('PUT')
            @include('profile.partials.form', ['buttonText' => 'Update User'])
        </form>
    </div>
@endsection
