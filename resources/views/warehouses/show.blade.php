@extends('layouts.app')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:24px; flex-wrap:wrap; margin-bottom:24px;">
        <div>
            <h1>{{ $warehouse->name }}</h1>
            <p>{{ $warehouse->description }}</p>
            <p><strong>Owner:</strong> {{ $warehouse->owner->name }}</p>
        </div>
    </div>

    <div class="toolbar">
        <button type="button" onclick="showSection('inventory')" class="button-pill">Inventory</button>
        <button type="button" onclick="showSection('management')" class="button-pill">Management</button>
        <button type="button" onclick="toggleDropdown('others-menu')" class="button-pill">Others ▾</button>
    </div>

    <div id="others-menu" class="drawer hidden">
        @if($warehouse->isOwnedBy($user))
            <button type="button" onclick="toggleDrawer('invite-drawer')">Invite</button>
            <button type="button" onclick="toggleDrawer('transfer-drawer')">Transfer Ownership</button>
            <button type="button" onclick="toggleDrawer('delete-drawer')">Delete Warehouse</button>
        @else
            <button type="button" onclick="toggleDrawer('leave-drawer')">Leave Warehouse</button>
        @endif
    </div>

    <div id="inventory" class="section-tab active">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:16px;">
            <h2>Inventory</h2>
            @if($user->canAccessWarehouse($warehouse))
                <a href="{{ route('warehouses.items.create', $warehouse) }}" class="button-pill">Add Item</a>
            @endif
        </div>

        @if($warehouse->items->isEmpty())
            <p>No items yet. Use the Add Item button to create inventory.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($warehouse->items as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>${{ number_format($item->total_price, 2) }}</td>
                            <td>
                                @if($item->image_path)
                                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}" style="max-width:60px; max-height:60px; border-radius:8px;">
                                @else
                                    —
                                @endif
                            </td>
                            <td style="display:flex; justify-content:center; gap:8px; flex-wrap:wrap;">
                                @if($user->canAccessWarehouse($warehouse))
                                    <a href="{{ route('warehouses.items.edit', [$warehouse, $item]) }}" class="button-secondary" style="padding:8px 12px;">Edit</a>
                                    <form method="POST" action="{{ route('warehouses.items.destroy', [$warehouse, $item]) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button-alert" style="padding:8px 12px;" onclick="return confirm('Delete this item?')">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div id="management" class="section-tab">
        <h2>Members</h2>
        <ul>
            @foreach($warehouse->members as $member)
                <li>{{ $member->name }} ({{ $member->email }})</li>
            @endforeach
        </ul>

        <h2 style="margin-top:24px;">Notifications</h2>
        @if($warehouse->comments->isEmpty())
            <p>No notifications yet.</p>
        @else
            <ul>
                @foreach($warehouse->comments as $comment)
                    <li><strong>{{ $comment->user->name }}:</strong> {{ $comment->comment }} <small>({{ $comment->created_at->diffForHumans() }})</small></li>
                @endforeach
            </ul>
        @endif

        <div style="margin-top:24px;">
            <h2>Add Comment</h2>
            <form method="POST" action="{{ route('warehouses.comments.store', $warehouse) }}">
                @csrf
                <textarea name="comment" rows="3" required></textarea>
                <button type="submit" class="button-pill">Post Comment</button>
            </form>
        </div>
    </div>

    <div id="invite-drawer" class="drawer hidden">
        <h3>Invite Member</h3>
        <form method="POST" action="{{ route('warehouses.invite', $warehouse) }}">
            @csrf
            <label for="email">User Email</label>
            <input type="email" name="email" id="email" required>
            <button type="submit">Send Invitation</button>
        </form>
    </div>

    <div id="transfer-drawer" class="drawer hidden">
        <h3>Transfer Ownership</h3>
        <form method="POST" action="{{ route('warehouses.transfer-ownership', $warehouse) }}">
            @csrf
            @method('PATCH')
            <label for="new_owner_email">New owner email</label>
            <input type="email" name="new_owner_email" id="new_owner_email" required>
            <button type="submit">Transfer Ownership</button>
        </form>
    </div>

    <div id="delete-drawer" class="drawer hidden">
        <h3>Delete Warehouse</h3>
        <p>Are you sure you want to delete this warehouse? This action cannot be undone.</p>
        <form method="POST" action="{{ route('warehouses.destroy', $warehouse) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="button-alert">Delete Warehouse</button>
        </form>
    </div>

    <div id="leave-drawer" class="drawer hidden">
        <h3>Leave Warehouse</h3>
        <p>Do you want to leave this warehouse as staff?</p>
        <form method="POST" action="{{ route('warehouses.leave', $warehouse) }}">
            @csrf
            <button type="submit" class="button-alert">Leave Warehouse</button>
        </form>
    </div>

    <script>
        function showSection(section) {
            document.querySelectorAll('.section-tab').forEach(el => el.classList.remove('active'));
            document.getElementById(section).classList.add('active');
        }

        function toggleDropdown(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.toggle('hidden');
            document.querySelectorAll('.drawer').forEach(drawer => {
                if (drawer.id !== id) drawer.classList.add('hidden');
            });
        }

        function toggleDrawer(id) {
            document.querySelectorAll('.drawer').forEach(drawer => {
                if (drawer.id === id) {
                    drawer.classList.toggle('hidden');
                } else {
                    drawer.classList.add('hidden');
                }
            });
        }
    </script>
@endsection
