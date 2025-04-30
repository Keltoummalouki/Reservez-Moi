<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $roleId = 3; // Default to Client
        if ($request->role === 'ServiceProvider') {
            $roleId = 2;
        }
        $role = Role::find($roleId);

        if (!$role) {
            $user->delete();
            return redirect()->back()->withErrors(['role' => 'Le rôle sélectionné n\'existe pas. Veuillez contacter l\'administrateur.']);
        }

        $user->roles()->attach($role);

        event(new Registered($user));
        Auth::login($user);
        return $this->registered($request, $user);
    }

    protected function validator(array $data)
    {
        return \Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['nullable', 'string', 'in:Client,ServiceProvider'],
        ]);
    }

    protected function registered(Request $request, $user)
    {
        $role = $user->roles->first();

        if (!$role) {
            \Auth::logout();
            return redirect('/login')->withErrors('Erreur : aucun rôle attribué à cet utilisateur.');
        }

        if (method_exists($user, 'hasVerifiedEmail') && !$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        switch ($role->name) {
            case 'Admin':
                return redirect()->route('admin.dashboard');
            case 'ServiceProvider':
                return redirect()->route('provider.dashboard');
            case 'Client':
        return redirect()->route('client.services');
            default:
                \Auth::logout();
                return redirect('/login')->withErrors('Erreur : rôle utilisateur inconnu.');
        }
    }
}