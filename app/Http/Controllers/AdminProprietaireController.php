<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminProprietaireController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin']);
    }

    public function index()
    {
        $proprietaires = User::whereHas('roles', function ($query) {
            $query->where('name', 'Proprietaire');
        })->get();

        return view('admin.proprietaires.index', compact('proprietaires'));
    }

    public function create()
    {
        return view('admin.proprietaires.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'company_name' => 'nullable|string|max:255',
            'siret' => 'nullable|string|max:14',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'company_name' => $request->company_name,
            'siret' => $request->siret,
        ]);

        $role = Role::where('name', 'Proprietaire')->first();
        if ($role) {
            $user->roles()->attach($role);
        }

        return redirect()->route('admin.proprietaires.index')->with('success', 'Propriétaire créé avec succès.');
    }

    public function show(User $proprietaire)
    {
        return view('admin.proprietaires.show', compact('proprietaire'));
    }

    public function edit(User $proprietaire)
    {
        return view('admin.proprietaires.edit', compact('proprietaire'));
    }

    public function update(Request $request, User $proprietaire)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($proprietaire->id)],
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'company_name' => 'nullable|string|max:255',
            'siret' => 'nullable|string|max:14',
            'is_active' => 'boolean',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'company_name' => $request->company_name,
            'siret' => $request->siret,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $proprietaire->update($data);

        return redirect()->route('admin.proprietaires.index')->with('success', 'Propriétaire mis à jour avec succès.');
    }

    public function destroy(User $proprietaire)
    {
        $proprietaire->delete();

        return redirect()->route('admin.proprietaires.index')->with('success', 'Propriétaire supprimé avec succès.');
    }
} 