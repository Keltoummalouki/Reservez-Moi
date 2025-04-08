<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return;
        }

        return back()->withErrors(['email' => 'Les informations sont incorrectes']);
    }

    protected function authenticated(Request $request, $user)
    {
        $role = $user->roles->first();

        if (!$role) {
            Auth::logout();
            return redirect('/login')->withErrors('Erreur : aucun rôle attribué à cet utilisateur.');
        }

        switch ($role->name) {
            case 'Admin':
                return redirect()->route('admin.dashboard');
            case 'ServiceProvider':
                return redirect()->route('provider.dashboard');
            case 'Client':
                return redirect()->route('client.services');
            default:
                Auth::logout();
                return redirect('/login')->withErrors('Erreur : rôle utilisateur inconnu.');
        }
    }
}