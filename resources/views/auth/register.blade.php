@extends('layouts.app')

@section('content')
    <h1>Register</h1>
    <form action="{{ route('register') }}" method="POST">
        @csrf

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>

        <input type="hidden" name="role" value="user">

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
@endsection
