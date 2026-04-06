@extends('layouts.app')

@section('content')
    <h1>Items in {{ $warehouse->name }}</h1>

    <p><a href="{{ route('warehouses.show', $warehouse) }}">Back to Warehouse</a></p>

    @if($warehouse->isOwnedBy(auth()->user()) || $warehouse->hasMember(auth()->user()))
        <p><a href="{{ route('warehouses.items.create', $warehouse) }}">Add New Item</a></p>
    @endif

    @if($items->isEmpty())
        <p>No items in this warehouse.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->total_price, 2) }}</td>
                        <td>
                            @if($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" style="max-width: 80px; max-height: 80px; border-radius: 8px; border:1px solid #e5e7eb;" />
                            @else
                                —
                            @endif
                        </td>
                        <td style="display:flex; justify-content:center; gap:8px; flex-wrap:wrap; align-items:center;">
                            @if($warehouse->isOwnedBy(auth()->user()) || $warehouse->hasMember(auth()->user()))
                                <a href="{{ route('warehouses.items.edit', [$warehouse, $item]) }}" class="button-secondary">Edit</a>
                                <form method="POST" action="{{ route('warehouses.items.destroy', [$warehouse, $item]) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button-alert" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
