<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // If not logged in → redirect
        if (!Auth::check()) {
            return redirect('/login');
        }

        // If user is blocked → logout & redirect
        if (Auth::user()->is_blocked) {
            Auth::logout();

            return redirect('/login')
                ->withErrors(['email' => 'Your account has been blocked by admin.']);
        }

        // If user is not admin → redirect
        if (Auth::user()->role !== 'admin') {
            return redirect('/login')
                ->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
