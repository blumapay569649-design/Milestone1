@extends('layouts.app')

@section('content')
    <h1>{{ $product->name }}</h1>

    <p><strong>SKU:</strong> {{ $product->sku }}</p>
    <p><strong>Warehouse:</strong> {{ $product->warehouse->name }}</p>
    <p><strong>Category:</strong> {{ $product->category->name }}</p>
    <p><strong>Supplier:</strong> {{ $product->supplier->name }}</p>
    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
    <p><strong>Description:</strong> {{ $product->description ?: 'N/A' }}</p>

    <h2>Inventory</h2>
    @if($product->inventories->isEmpty())
        <p>No inventory records.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Warehouse</th>
                    <th>Quantity</th>
                    <th>Min Stock Level</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($product->inventories as $inventory)
                    <tr>
                        <td>{{ $inventory->warehouse->name }}</td>
                        <td>{{ $inventory->quantity }}</td>
                        <td>{{ $inventory->min_stock_level }}</td>
                        <td>{{ $inventory->isLowStock() ? 'Low Stock' : 'OK' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div style="margin-top: 20px;">
        <a href="{{ route('products.edit', $product) }}">Edit Product</a>
        <form method="POST" action="{{ route('products.destroy', $product) }}" style="display:inline; margin-left:10px;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Are you sure?')">Delete Product</button>
        </form>
    </div>
@endsection
