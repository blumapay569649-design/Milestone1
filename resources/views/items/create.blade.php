@extends('layouts.app')

@section('content')
    <h1>Create Item in {{ $warehouse->name }}</h1>

    <form method="POST" action="{{ route('warehouses.items.store', $warehouse) }}" enctype="multipart/form-data">
        @csrf

        <label for="name">Item Name</label>
        <input type="text" name="name" id="name" required>

        <label for="qty">Quantity</label>
        <input type="number" name="qty" id="qty" min="1" required>

        <label for="price">Price</label>
        <input type="number" name="price" id="price" step="0.01" min="0" required>

        <label for="image">Image (optional, max 50MB)</label>
        <input type="file" name="image" id="image" accept="image/*">

        <button type="submit">Create Item</button>
    </form>
@endsection
