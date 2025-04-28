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
        $this->middleware(['auth', 'role:ServiceProvider']);
        $this->serviceRepository = $serviceRepository;
    }

    public function index()
    {
        $services = $this->serviceRepository->all();
        return view('provider.services.services', compact('services'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        if ($categories->isEmpty()) {
            return redirect()->back()->with('error', 'Aucune catégorie disponible. Veuillez contacter l\'administrateur.');
        }
        return view('provider.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_available' => 'boolean',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120', // 5MB max
        ]);

        try {
            // Ensure is_available is properly handled
            $validated['is_available'] = $request->boolean('is_available');
            
            $service = new Service($validated);
            $service->provider_id = auth()->id();
            $service->save();

            // Handle photo uploads
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $photo) {
                    $filename = time() . '_' . $index . '.' . $photo->getClientOriginalExtension();
                    $photo->storeAs('public/service-photos', $filename);

                    $service->photos()->create([
                        'filename' => $filename,
                        'is_primary' => $index === 0, // First photo is primary
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
        $categories = Category::all();
        return view('provider.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_available' => 'boolean',
        ]);

        // Ensure is_available is properly handled
        $validated['is_available'] = $request->boolean('is_available');

        $service->update($validated);

        return redirect()->route('provider.services.index')
            ->with('success', 'Service mis à jour avec succès.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('provider.services.index')->with('success', 'Service supprimé avec succès !');
    }
}