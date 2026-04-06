<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warehouse;
use App\Models\WarehouseInvitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    protected function currentUser()
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
        $invitations = $user->receivedInvitations()->with('warehouse', 'inviter')->where('status', 'pending')->get();

        return view('invitations.index', [
            'invitations' => $invitations,
        ]);
    }

    public function accept(WarehouseInvitation $invitation): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        if ($invitation->invitee_id !== $user->id || $invitation->status !== 'pending') {
            abort(403);
        }

        $invitation->update(['status' => 'accepted']);
        $invitation->warehouse->members()->attach($user->id);

        return redirect()->route('invitations.index')->with('status', 'Invitation accepted.');
    }

    public function decline(WarehouseInvitation $invitation): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        if ($invitation->invitee_id !== $user->id || $invitation->status !== 'pending') {
            abort(403);
        }

        $invitation->update(['status' => 'declined']);

        return redirect()->route('invitations.index')->with('status', 'Invitation declined.');
    }
}
