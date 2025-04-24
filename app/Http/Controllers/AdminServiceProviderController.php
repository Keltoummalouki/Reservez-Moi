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

        // Récupérer les statistiques pour les prestataires
        $totalServices = 0;
        $newProviders = User::whereHas('roles', function ($query) {
            $query->where('name', 'ServiceProvider');
        })->where('created_at', '>=', now()->subDays(30))->count();

        $totalRevenue = 0;

        // Calculer le nombre total de services et le revenu total
        foreach ($serviceProviders as $provider) {
            $totalServices += $provider->services->count();
            foreach ($provider->services as $service) {
                $totalRevenue += $service->reservations()->where('payment_status', 'completed')->sum('amount');
            }
        }

        // Récupérer les prestataires les plus performants
        $topProviders = User::whereHas('roles', function ($query) {
            $query->where('name', 'ServiceProvider');
        })
        ->withCount('services')
        ->with(['services.reservations' => function($query) {
            $query->where('payment_status', 'completed');
        }])
        ->get()
        ->map(function($provider) {
            $totalRevenue = 0;
            foreach ($provider->services as $service) {
                $totalRevenue += $service->reservations->sum('amount');
            }
            $provider->total_revenue = $totalRevenue;
            return $provider;
        })
        ->sortByDesc('total_revenue')
        ->take(6);

        return view('admin.service_providers', compact('serviceProviders', 'totalServices', 'newProviders', 'totalRevenue', 'topProviders'));
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
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $role = Role::where('name', 'ServiceProvider')->first();
        if ($role) {
            $user->roles()->attach($role);
        }

        return redirect()->route('admin.service_providers')->with('success', 'Prestataire créé avec succès !');
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
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        // Mettre à jour le mot de passe uniquement s'il est fourni
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('admin.service_providers')->with('success', 'Prestataire mis à jour avec succès !');
    }

    public function destroy(User $user)
    {
        if (!$user->roles->contains('name', 'ServiceProvider')) {
            abort(403, 'Unauthorized: This user is not a ServiceProvider.');
        }

        // Supprimer les services associés
        $user->services()->delete();
        
        // Supprimer l'utilisateur
        $user->delete();

        return redirect()->route('admin.service_providers')->with('success', 'Prestataire supprimé avec succès !');
    }
}
