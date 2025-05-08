<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check() || !$request->user()->roles()->where('name', $role)->exists()) {
            abort(403, 'Vous n\'avez pas les droits nécessaires. Rôle requis: ' . $role);
        }
        $user = $request->user();
        if ($user->hasRole('ServiceProvider') && isset($user->is_active) && !$user->is_active) {
            if (!$request->routeIs('suspended') && !$request->routeIs('logout')) {
                return redirect()->route('suspended');
            }
        }
        return $next($request);
    }
}