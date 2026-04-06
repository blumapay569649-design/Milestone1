@extends('layouts.app')

@section('content')
    <h1>Categories</h1>

    <p><a href="{{ route('categories.create') }}">Add New Category</a></p>

    @if($categories->isEmpty())
        <p>No categories found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Products</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description ?: 'N/A' }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td>
                            <a href="{{ route('categories.edit', $category) }}">Edit</a>
                            <form method="POST" action="{{ route('categories.destroy', $category) }}" style="display:inline; margin-left:10px;">
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
