<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

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

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // Redirection selon le rôle
            return $this->authenticated($request, Auth::user());
        }

        
        return back()->withErrors([
            'email' => 'Les informations sont incorrectes',
        ])->withInput($request->only('email', 'remember'));
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

// App\Http\Controllers\Auth\RegisterController.php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['nullable', 'string', 'in:Client,ServiceProvider'],
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $roleName = $request->role ?? 'Client';
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            $user->delete();
            return redirect()->back()->withErrors(['role' => 'Le rôle sélectionné n\'existe pas. Veuillez contacter l\'administrateur.']);
        }

        $user->roles()->attach($role);

        // Déclencher l'événement de vérification d'email si l'utilisateur doit vérifier son email
        event(new Registered($user));

        Auth::login($user);

        // Redirection selon le rôle
        return $this->registered($request, $user);
    }

    protected function registered(Request $request, $user)
    {
        $role = $user->roles->first();

        if (!$role) {
            Auth::logout();
            return redirect('/login')->withErrors('Erreur : aucun rôle attribué à cet utilisateur.');
        }

        if ($user->hasVerifiedEmail()) {
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
        } else {
            return redirect()->route('verification.notice');
        }
    }
}

// App\Http\Controllers\Auth\LogoutController.php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}