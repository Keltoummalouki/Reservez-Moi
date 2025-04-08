<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminServiceProviderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin']);
    }

    public function index()
    {
        $serviceProviders = User::whereHas('roles', function ($query) {
            $query->where('name', 'ServiceProvider');
        })->with('services')->get();

        return view('admin.dashboard', compact('serviceProviders'));
    }

    public function create()
    {
        return view('admin.service_providers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::where('name', 'ServiceProvider')->first();
        if ($role) {
            $user->roles()->attach($role);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Service Provider créé avec succès !');
    }

    public function edit(User $user)
    {
        if (!$user->roles->contains('name', 'ServiceProvider')) {
            abort(403, 'Unauthorized: This user is not a ServiceProvider.');
        }

        return view('admin.service_providers.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!$user->roles->contains('name', 'ServiceProvider')) {
            abort(403, 'Unauthorized: This user is not a ServiceProvider.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Service Provider mis à jour avec succès !');
    }

    public function destroy(User $user)
    {
        if (!$user->roles->contains('name', 'ServiceProvider')) {
            abort(403, 'Unauthorized: This user is not a ServiceProvider.');
        }

        $user->services()->delete();
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Service Provider supprimé avec succès !');
    }
}