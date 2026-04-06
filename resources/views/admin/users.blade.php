@extends('layouts.app')

@section('content')
    <h1>User Management</h1>

    <form method="GET" action="{{ route('admin.users') }}" style="margin-bottom: 20px; display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
        <input type="text" name="search" value="{{ old('search', $search ?? '') }}" placeholder="Search user by ID or email" style="flex:1; min-width:220px; padding:10px 12px; border:1px solid #d1d5db; border-radius:8px;" />
        <button type="submit" class="button-pill" style="margin:0;">Search</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->is_banned ? 'Banned' : 'Active' }}</td>
                        <td style="display:flex; gap:8px; flex-wrap: wrap;">
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.ban', $user) }}" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="is_banned" value="{{ $user->is_banned ? 0 : 1 }}">
                                <button type="submit" class="button-secondary">{{ $user->is_banned ? 'Unban' : 'Ban' }}</button>
                            </form>
                        @endif
                        @if(!$user->isAdmin())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button-alert" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.users.reset-password', $user) }}" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <input type="password" name="password" placeholder="New password" required style="width:auto; min-width:180px;">
                            <input type="password" name="password_confirmation" placeholder="Confirm password" required style="width:auto; min-width:180px; margin-top:8px;">
                            <button type="submit" class="button-secondary">Reset Password</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
