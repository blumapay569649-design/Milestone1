@extends('layouts.app')

@section('content')
    <h1>{{ $item->name }}</h1>

    <p><strong>Warehouse:</strong> {{ $warehouse->name }}</p>
    <p><strong>Quantity:</strong> {{ $item->qty }}</p>
    <p><strong>Price:</strong> ${{ number_format($item->price, 2) }}</p>
    <p><strong>Total Price:</strong> ${{ number_format($item->total_price, 2) }}</p>

    @if($item->image_path)
        <p><strong>Image:</strong></p>
        <img src="{{ $item->image_url }}" alt="{{ $item->name }}" style="max-width: 300px;">
    @endif

    <div style="margin-top: 20px;">
        <a href="{{ route('warehouses.items.edit', [$warehouse, $item]) }}">Edit Item</a>
        <form method="POST" action="{{ route('warehouses.items.destroy', [$warehouse, $item]) }}" style="display:inline; margin-left:10px;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Are you sure?')">Delete Item</button>
        </form>
    </div>
@endsection
