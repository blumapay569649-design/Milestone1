@extends('layouts.app')

@section('content')
    <h1>Welcome, {{ $user->name }}</h1>

    <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
    <p><strong>Status:</strong> {{ $user->is_banned ? 'Banned' : 'Active' }}</p>

    @if($user->isAdmin())
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); margin-top: 24px;">
            <div style="background:#f3f4f6; padding:18px; border-radius:12px;">
                <h2>User Management</h2>
                <p>Manage users, ban accounts, reset passwords, and delete users.</p>
                <a href="{{ route('admin.users') }}">Manage users</a>
            </div>
        </div>
    @else
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); margin-top: 24px;">
            <div style="background:#f3f4f6; padding:18px; border-radius:12px;">
                <h2>Create Warehouse</h2>
                <p>Create a new warehouse to manage your inventory.</p>
                <a href="{{ route('warehouses.create') }}">Create Warehouse</a>
            </div>
            <div style="background:#f3f4f6; padding:18px; border-radius:12px;">
                <h2>My Warehouses</h2>
                <p>View and manage your warehouses.</p>
                <a href="{{ route('warehouses.index') }}">View Warehouses</a>
            </div>
            <div style="background:#f3f4f6; padding:18px; border-radius:12px;">
                <h2>Invitations</h2>
                <p>Check pending warehouse invitations.</p>
                <a href="{{ route('invitations.index') }}">View Invitations</a>
            </div>
        </div>
    @endif
@endsection
