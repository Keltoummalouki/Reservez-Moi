<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class AdminServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin']);
    }

    public function index()
    {
        $services = Service::with(['provider', 'reservations'])->get();
        
        // Statistiques des services
        $totalServices = $services->count();
        $activeServices = $services->where('is_available', true)->count();
        $totalReservations = DB::table('reservations')->count();
        $totalRevenue = DB::table('reservations')->where('payment_status', 'completed')->sum('amount');
        
        // Services les plus réservés
        $topServices = Service::withCount('reservations')
            ->orderByDesc('reservations_count')
            ->take(5)
            ->get();
        
        // Suppression de la référence à Category
        $categories = []; // Tableau vide à la place des catégories
        
        return view('admin.services', compact(
            'services', 
            'totalServices', 
            'activeServices', 
            'totalReservations', 
            'totalRevenue', 
            'topServices', 
            'categories'
        ));
    }

    public function create()
    {
        $providers = User::whereHas('roles', function ($query) {
            $query->where('name', 'ServiceProvider');
        })->get();
        
        $categories = Category::all();
        
        return view('admin.services.create', compact('providers', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:15',
            'provider_id' => 'required|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
        ]);

        Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
            'provider_id' => $request->provider_id,
            'category_id' => $request->category_id,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.services')->with('success', 'Service créé avec succès !');
    }

    public function edit(Service $service)
    {
        $providers = User::whereHas('roles', function ($query) {
            $query->where('name', 'ServiceProvider');
        })->get();
        
        $categories = Category::all();
        
        return view('admin.services.edit', compact('service', 'providers', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:15',
            'provider_id' => 'required|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
        ]);

        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
            'provider_id' => $request->provider_id,
            'category_id' => $request->category_id,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.services')->with('success', 'Service mis à jour avec succès !');
    }

    public function destroy(Service $service)
    {
        // Vérifier s'il y a des réservations associées
        if ($service->reservations()->count() > 0) {
            return redirect()->route('admin.services')->with('error', 'Impossible de supprimer ce service car il a des réservations associées.');
        }
        
        $service->delete();
        
        return redirect()->route('admin.services')->with('success', 'Service supprimé avec succès !');
    }

    // Suspendre un service (désactiver)
    public function suspend(Service $service)
    {
        $service->is_available = false;
        $service->save();
        return redirect()->route('admin.services')->with('success', 'Service suspendu avec succès !');
    }

    // Reprendre un service (réactiver)
    public function resume(Service $service)
    {
        $service->is_available = true;
        $service->save();
        return redirect()->route('admin.services')->with('success', 'Service réactivé avec succès !');
    }
}
