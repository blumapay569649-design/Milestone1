@extends('layouts.app')

@section('content')
    <h1>Login</h1>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <label>
            <input type="checkbox" name="remember"> Remember me
        </label>

        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
@endsection
