@extends('layouts.app')

@section('content')
    <h1>Products</h1>

    <p><a href="{{ route('products.create') }}">Add New Product</a></p>

    <form method="GET" action="{{ route('products.index') }}" style="margin-bottom: 20px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; align-items: end;">
            <div>
                <label for="warehouse_id">Warehouse</label>
                <select name="warehouse_id" id="warehouse_id">
                    <option value="">All Warehouses</option>
                    @foreach($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}"{{ $filters['warehouse_id'] ?? '' == $warehouse->id ? ' selected' : '' }}>{{ $warehouse->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"{{ $filters['category_id'] ?? '' == $category->id ? ' selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="search">Search</label>
                <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}">
            </div>
            <div>
                <button type="submit">Filter</button>
            </div>
        </div>
    </form>

    @if($products->isEmpty())
        <p>No products found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Warehouse</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->warehouse->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->supplier->name }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td><a href="{{ route('products.show', $product) }}">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $products->appends($filters)->links() }}
    @endif
@endsection
