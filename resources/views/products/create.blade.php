@extends('layouts.app')

@section('content')
    <h1>Create Product</h1>

    <form method="POST" action="{{ route('products.store') }}">
        @csrf

        <label for="warehouse_id">Warehouse</label>
        <select name="warehouse_id" id="warehouse_id" required>
            @foreach($warehouses as $warehouse)
                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
            @endforeach
        </select>

        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <label for="supplier_id">Supplier</label>
        <select name="supplier_id" id="supplier_id" required>
            @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
            @endforeach
        </select>

        <label for="name">Product Name</label>
        <input type="text" name="name" id="name" required>

        <label for="sku">SKU</label>
        <input type="text" name="sku" id="sku" required>

        <label for="price">Price</label>
        <input type="number" name="price" id="price" step="0.01" min="0" required>

        <label for="quantity">Initial Quantity</label>
        <input type="number" name="quantity" id="quantity" min="0" required>

        <label for="min_stock_level">Minimum Stock Level</label>
        <input type="number" name="min_stock_level" id="min_stock_level" min="0" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" rows="4"></textarea>

        <button type="submit">Create Product</button>
    </form>
@endsection
