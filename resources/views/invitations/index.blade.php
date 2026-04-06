@extends('layouts.app')

@section('content')
    <h1>Invitations</h1>

    @if($invitations->isEmpty())
        <p>No pending invitations.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Warehouse</th>
                    <th>Invited By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invitations as $invitation)
                    <tr>
                        <td>{{ $invitation->warehouse->name }}</td>
                        <td>{{ $invitation->inviter->name }}</td>
                        <td>
                            <form method="POST" action="{{ route('invitations.accept', $invitation) }}" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit">Accept</button>
                            </form>
                            <form method="POST" action="{{ route('invitations.decline', $invitation) }}" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit">Decline</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
