@extends('layouts.app')

@section('content')
    <h1>Create Category</h1>

    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <label for="name">Category Name</label>
        <input type="text" name="name" id="name" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" rows="4"></textarea>

        <button type="submit">Create Category</button>
    </form>
@endsection
