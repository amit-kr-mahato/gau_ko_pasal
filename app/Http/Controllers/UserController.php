<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    // Show login page
    public function login()
    {
        return view('login');
    }

    // Handle login POST
    public function loginPost(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return match (Auth::user()->role) {
                'admin'  => redirect()->route('admin.dashboard'),
                'seller' => redirect()->route('seller.dashboard'),
                default  => redirect()->route('user.dashboard'),
            };
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Show registration page
    public function register()
    {
        return view('register');
    }

    // Handle registration POST
    public function registerPost(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:admin,seller,user',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => $request->role,
        ]);

        Auth::login($user);

        return match ($user->role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'seller' => redirect()->route('seller.dashboard'),
            default  => redirect()->route('user.dashboard'),
        };
    }

    // User dashboard
    public function index() { return view('user.index'); }
    public function history() { return view('user.order-history'); }
    public function detail() { return view('user.detail'); }
    public function settings() { return view('user.settings'); }
}
