@extends('layouts.app')

@section('content')
    <h1>Edit Supplier</h1>

    <form method="POST" action="{{ route('suppliers.update', $supplier) }}">
        @csrf
        @method('PATCH')

        <label for="name">Supplier Name</label>
        <input type="text" name="name" id="name" value="{{ $supplier->name }}" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ $supplier->email }}">

        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" value="{{ $supplier->phone }}">

        <label for="address">Address</label>
        <textarea name="address" id="address" rows="4">{{ $supplier->address }}</textarea>

        <button type="submit">Update Supplier</button>
    </form>
@endsection
