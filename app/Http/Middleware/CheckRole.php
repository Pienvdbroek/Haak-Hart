<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $userRole = $user->role ? $user->role->name : null;

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        abort(403, 'Geen toegang.');
    }
}
