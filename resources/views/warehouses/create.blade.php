@extends('layouts.app')

@section('content')
    <h1>Create Warehouse</h1>

    <form method="POST" action="{{ route('warehouses.store') }}">
        @csrf
        <label for="name">Warehouse Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" rows="4">{{ old('description') }}</textarea>

        <button type="submit">Create Warehouse</button>
    </form>
@endsection
