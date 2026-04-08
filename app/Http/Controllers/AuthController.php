<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'birthdate' => 'required|date|before:today',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $birthdate = \Carbon\Carbon::parse($request->birthdate);
        $age = $birthdate->diffInYears(\Carbon\Carbon::now());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'birthdate' => $birthdate,
            'age' => $age,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_USER,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
        }

        $request->session()->regenerate();

        $user = Auth::user();
        if (! $user instanceof User) {
            Auth::logout();
            return back()->withErrors(['email' => 'Authentication failed.']);
        }

        if ($user->isBanned()) {
            Auth::logout();
            return back()->withErrors(['email' => 'This account has been banned.']);
        }

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function dashboard()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        return view('dashboard', [
            'user' => $user,
        ]);
    }
}
