@extends('layouts.app')

@section('content')
    <h1>Suppliers</h1>

    <p><a href="{{ route('suppliers.create') }}">Add New Supplier</a></p>

    @if($suppliers->isEmpty())
        <p>No suppliers found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Products</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->email ?: 'N/A' }}</td>
                        <td>{{ $supplier->phone ?: 'N/A' }}</td>
                        <td>{{ $supplier->products_count }}</td>
                        <td>
                            <a href="{{ route('suppliers.edit', $supplier) }}">Edit</a>
                            <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" style="display:inline; margin-left:10px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
