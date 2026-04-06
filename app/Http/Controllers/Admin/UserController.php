<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected function ensureAdmin(): void
    {
        $user = Auth::user();

        if (! $user instanceof User || ! $user->isAdmin()) {
            abort(403);
        }
    }

    public function index(Request $request)
    {
        $this->ensureAdmin();

        $query = User::query()->where('id', '!=', auth()->id());

        if ($search = $request->query('search')) {
            $query->where(function ($query) use ($search) {
                $query->where('id', $search)
                      ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        return view('admin.users', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    public function ban(Request $request, User $user): RedirectResponse
    {
        $this->ensureAdmin();

        if ($user->isAdmin()) {
            return back()->withErrors(['error' => 'Cannot ban another admin.']);
        }

        $user->update(['is_banned' => $request->boolean('is_banned')]);

        return back();
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->ensureAdmin();

        if ($user->isAdmin()) {
            return back()->withErrors(['error' => 'Cannot delete another admin.']);
        }

        $user->delete();

        return back()->with('status', 'User deleted successfully.');
    }
}