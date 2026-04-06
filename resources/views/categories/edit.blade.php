@extends('layouts.app')

@section('content')
    <h1>Edit Category</h1>

    <form method="POST" action="{{ route('categories.update', $category) }}">
        @csrf
        @method('PATCH')

        <label for="name">Category Name</label>
        <input type="text" name="name" id="name" value="{{ $category->name }}" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" rows="4">{{ $category->description }}</textarea>

        <button type="submit">Update Category</button>
    </form>
@endsection
