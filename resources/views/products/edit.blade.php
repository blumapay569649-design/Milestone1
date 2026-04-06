@extends('layouts.app')

@section('content')
    <h1>Edit Product</h1>

    <form method="POST" action="{{ route('products.update', $product) }}">
        @csrf
        @method('PATCH')

        <label for="warehouse_id">Warehouse</label>
        <select name="warehouse_id" id="warehouse_id" required>
            @foreach($warehouses as $warehouse)
                <option value="{{ $warehouse->id }}"{{ $product->warehouse_id == $warehouse->id ? ' selected' : '' }}>{{ $warehouse->name }}</option>
            @endforeach
        </select>

        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"{{ $product->category_id == $category->id ? ' selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>

        <label for="supplier_id">Supplier</label>
        <select name="supplier_id" id="supplier_id" required>
            @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}"{{ $product->supplier_id == $supplier->id ? ' selected' : '' }}>{{ $supplier->name }}</option>
            @endforeach
        </select>

        <label for="name">Product Name</label>
        <input type="text" name="name" id="name" value="{{ $product->name }}" required>

        <label for="sku">SKU</label>
        <input type="text" name="sku" id="sku" value="{{ $product->sku }}" required>

        <label for="price">Price</label>
        <input type="number" name="price" id="price" step="0.01" min="0" value="{{ $product->price }}" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" rows="4">{{ $product->description }}</textarea>

        <button type="submit">Update Product</button>
    </form>
@endsection
