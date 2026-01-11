<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function block(User $user)
    {
        $user->update(['is_blocked' => true]);
        return back()->with('success', 'User blocked successfully');
    }

    public function unblock(User $user)
    {
        $user->update(['is_blocked' => false]);
        return back()->with('success', 'User unblocked successfully');
    }
}
