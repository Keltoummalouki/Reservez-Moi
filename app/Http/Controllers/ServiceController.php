<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreServiceRequest;
use App\Repositories\ServiceRepositoryInterface;
use App\Models\Category;

class ServiceController extends Controller
{
    protected $serviceRepository;

    public function __construct(ServiceRepositoryInterface $serviceRepository)
    {
        $this->middleware('auth');
        $this->serviceRepository = $serviceRepository;
    }

    public function index()
    {
        $user = auth()->user();
        if ($user->hasRole('Admin')) {
            $services = Service::paginate(10);
            return view('admin.services', compact('services'));
        } else if ($user->hasRole('ServiceProvider')) {
            $services = Service::where('provider_id', $user->id)->paginate(10);
            return view('provider.services.services', compact('services'));
        } else {
            abort(403, "Vous n'avez pas les droits nécessaires.");
        }
    }

    public function create()
    {
        $user = auth()->user();
        if (!$user->hasRole('ServiceProvider')) {
            abort(403, "Vous n'avez pas les droits nécessaires.");
        }
        $categories = Category::orderBy('name')->get();
        if ($categories->isEmpty()) {
            return redirect()->back()->with('error', 'Aucune catégorie disponible. Veuillez contacter l\'administrateur.');
        }
        return view('provider.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user->hasRole('ServiceProvider')) {
            abort(403, "Vous n'avez pas les droits nécessaires.");
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_available' => 'boolean',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120', // 5MB max
        ]);
        try {
            $validated['is_available'] = $request->boolean('is_available');
            $service = new Service($validated);
            $service->provider_id = $user->id;
            $service->save();
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $photo) {
                    $filename = time() . '_' . $index . '.' . $photo->getClientOriginalExtension();
                    $photo->storeAs('public/service-photos', $filename);
                    $service->photos()->create([
                        'filename' => $filename,
                        'is_primary' => $index === 0,
                        'order' => $index
                    ]);
                }
            }
            return redirect()->route('provider.services.index')
                ->with('success', 'Service créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création du service.');
        }
    }

    public function edit(Service $service)
    {
        $user = auth()->user();
        if (!$user->hasRole('ServiceProvider') || $service->provider_id !== $user->id) {
            abort(403, "Vous n'avez pas les droits nécessaires.");
        }
        $categories = Category::all();
        return view('provider.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $user = auth()->user();
        if (!$user->hasRole('ServiceProvider') || $service->provider_id !== $user->id) {
            abort(403, "Vous n'avez pas les droits nécessaires.");
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_available' => 'boolean',
        ]);
        $validated['is_available'] = $request->boolean('is_available');
        $service->update($validated);
        return redirect()->route('provider.services.index')
            ->with('success', 'Service mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $service = Service::where('id', $id)->where('provider_id', $user->id)->firstOrFail();
        if (!$user->hasRole('ServiceProvider')) {
            abort(403, "Vous n'avez pas les droits nécessaires.");
        }
        $service->delete();
        return redirect()->route('provider.services.index')->with('success', 'Service supprimé avec succès.');
    }

    public function show(Service $service)
    {
        $user = auth()->user();
        if ($user->hasRole('Admin')) {
            return view('admin.services.show', compact('service'));
        } else if ($user->hasRole('ServiceProvider') && $service->provider_id === $user->id) {
            return view('provider.services.show', compact('service'));
        } else {
            abort(403, "Vous n'avez pas les droits nécessaires.");
        }
    }

    // Méthode pour l'admin : suspendre un service
    public function suspend(Service $service)
    {
        $user = auth()->user();
        if (!$user->hasRole('Admin')) {
            abort(403, "Vous n'avez pas les droits nécessaires.");
        }
        $service->is_available = false;
        $service->save();
        return redirect()->route('admin.services')->with('success', 'Service suspendu avec succès.');
    }
}