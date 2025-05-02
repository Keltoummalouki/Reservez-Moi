<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckProviderActive
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user && $user->hasRole('ServiceProvider') && !$user->is_active) {
            if ($request->route()->getName() !== 'provider.suspended' && $request->route()->getName() !== 'logout') {
                return redirect()->route('provider.suspended');
            }
        }
        return $next($request);
    }
} 