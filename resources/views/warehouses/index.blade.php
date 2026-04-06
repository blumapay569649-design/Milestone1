@extends('layouts.app')

@section('content')
    <h1>Warehouses</h1>

    <p><a href="{{ route('warehouses.create') }}">Create a new warehouse</a></p>

    <h2>Your Owned Warehouses</h2>
    @if($ownedWarehouses->isEmpty())
        <p>No warehouses created yet.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Members</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ownedWarehouses as $warehouse)
                    <tr>
                        <td>{{ $warehouse->name }}</td>
                        <td>{{ $warehouse->description }}</td>
                        <td>{{ $warehouse->members_count }}</td>
                        <td>{{ $warehouse->created_at->format('M d, Y') }}</td>
                        <td><a href="{{ route('warehouses.show', $warehouse) }}">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h2>Warehouses Shared With You (STAFF)</h2>
    @if($sharedWarehouses->isEmpty())
        <p>No shared warehouses yet.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Owner</th>
                    <th>Members</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sharedWarehouses as $warehouse)
                    <tr>
                        <td>{{ $warehouse->name }} <strong>(STAFF)</strong></td>
                        <td>{{ $warehouse->description }}</td>
                        <td>{{ $warehouse->owner->name }}</td>
                        <td>{{ $warehouse->members_count }}</td>
                        <td><a href="{{ route('warehouses.show', $warehouse) }}">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
