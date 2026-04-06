<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warehouse;
use App\Models\WarehouseComment;
use App\Models\WarehouseInvitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    protected function currentUser(): ?\App\Models\User
    {
        return Auth::user();
    }

    protected function requireAuth(): ?RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();

        return view('warehouses.index', [
            'ownedWarehouses' => $user->ownedWarehouses()->withCount('members')->get(),
            'sharedWarehouses' => $user->sharedWarehouses()->where('warehouses.owner_id', '!=', $user->id)->withCount('members')->get(),
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        if ($user->isAdmin()) {
            return redirect()->route('dashboard')->withErrors(['error' => 'Admins cannot create warehouses.']);
        }

        return view('warehouses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        if ($user->isAdmin()) {
            return redirect()->route('dashboard')->withErrors(['error' => 'Admins cannot create warehouses.']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $warehouse = Warehouse::create([
            'owner_id' => $user->id,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $warehouse->members()->attach($user->id);

        return redirect()->route('warehouses.show', $warehouse);
    }

    public function show(Warehouse $warehouse)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        if (!$user instanceof User || !$user->canAccessWarehouse($warehouse)) {
            abort(403);
        }

        return view('warehouses.show', [
            'warehouse' => $warehouse->load('members', 'owner'),
            'user' => $user,
        ]);
    }

    public function join(Warehouse $warehouse): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();

        if ($warehouse->isOwnedBy($user) || $warehouse->hasMember($user)) {
            return back()->with('status', 'You already have access to this warehouse.');
        }

        $warehouse->members()->attach($user->id);

        return redirect()->route('warehouses.show', $warehouse)->with('status', 'Joined warehouse successfully.');
    }

    public function invite(Request $request, Warehouse $warehouse): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        if (!$warehouse->isOwnedBy($user)) {
            abort(403);
        }

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $invitee = User::where('email', $request->email)->firstOrFail();

        if ($warehouse->hasMember($invitee) || $warehouse->isOwnedBy($invitee)) {
            return back()->with('status', 'User is already a member.');
        }

        WarehouseInvitation::firstOrCreate([
            'warehouse_id' => $warehouse->id,
            'invitee_id' => $invitee->id,
        ], [
            'inviter_id' => $user->id,
            'status' => 'pending',
        ]);

        return back()->with('status', 'Invitation sent.');
    }

    public function transferOwnership(Request $request, Warehouse $warehouse): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        if (!$user instanceof User || !$warehouse->isOwnedBy($user)) {
            abort(403);
        }

        $request->validate([
            'new_owner_email' => 'required|email|exists:users,email',
        ]);

        $newOwner = User::where('email', $request->new_owner_email)->firstOrFail();

        if (!$warehouse->hasMember($newOwner) && !$warehouse->isOwnedBy($newOwner)) {
            $warehouse->members()->attach($newOwner->id);
        }

        $warehouse->owner_id = $newOwner->id;
        $warehouse->save();

        return back()->with('status', 'Warehouse ownership transferred to '.$newOwner->email.'.');
    }

    public function leave(Warehouse $warehouse): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        if ($warehouse->isOwnedBy($user)) {
            return back()->withErrors(['error' => 'Owners cannot leave their warehouse. Transfer ownership first.']);
        }

        if (!$warehouse->hasMember($user)) {
            abort(403);
        }

        $warehouse->members()->detach($user->id);

        // Add a comment about leaving
        WarehouseComment::create([
            'warehouse_id' => $warehouse->id,
            'user_id' => $user->id,
            'comment' => $user->name . ' left the warehouse.',
        ]);

        return redirect()->route('warehouses.index')->with('status', 'Left warehouse successfully.');
    }

    public function destroy(Warehouse $warehouse): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        if (!$warehouse->isOwnedBy($user)) {
            abort(403);
        }

        $warehouse->delete();

        return redirect()->route('warehouses.index')->with('status', 'Warehouse deleted.');
    }

    public function addComment(Request $request, Warehouse $warehouse): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        if (!$user->canAccessWarehouse($warehouse)) {
            abort(403);
        }

        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        WarehouseComment::create([
            'warehouse_id' => $warehouse->id,
            'user_id' => $user->id,
            'comment' => $request->comment,
        ]);

        return back();
    }
}
