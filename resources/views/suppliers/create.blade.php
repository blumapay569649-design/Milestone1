@extends('layouts.app')

@section('content')
    <h1>Create Supplier</h1>

    <form method="POST" action="{{ route('suppliers.store') }}">
        @csrf

        <label for="name">Supplier Name</label>
        <input type="text" name="name" id="name" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email">

        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone">

        <label for="address">Address</label>
        <textarea name="address" id="address" rows="4"></textarea>

        <button type="submit">Create Supplier</button>
    </form>
@endsection
