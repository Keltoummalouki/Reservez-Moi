<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SocialAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Si l'utilisateur vient de s'authentifier via un réseau social
        if (Session::has('social_auth')) {
            // On récupère le réseau social utilisé
            $provider = Session::get('social_auth');
            
            // On peut effectuer des actions spécifiques selon le provider
            switch ($provider) {
                case 'google':
                    // Actions spécifiques pour Google
                    break;
                case 'facebook':
                    // Actions spécifiques pour Facebook
                    break;
            }
            
            Session::forget('social_auth');
            
            if (Session::has('social_auth_redirect')) {
                $redirect = Session::get('social_auth_redirect');
                Session::forget('social_auth_redirect');
                return redirect($redirect);
            }
        }
        
        return $next($request);
    }
}