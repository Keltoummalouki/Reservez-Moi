<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreServiceRequest;
use App\Repositories\ServiceRepositoryInterface;

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
        return view('provider.services.create');
    }

    public function store(StoreServiceRequest $request)
    {
        // Les données sont déjà validées
        $validated = $request->validated();
        
        Auth::user()->services()->create($validated);
    
        return redirect()->route('provider.services')->with('success', 'Service créé avec succès !');
    }

    public function edit(Service $service)
    {
        return view('provider.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'is_available' => 'boolean',
        ]);

        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'is_available' => $request->boolean('is_available', true),
        ]);

        return redirect()->route('provider.services')->with('success', 'Service mis à jour avec succès !');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('provider.services')->with('success', 'Service supprimé avec succès !');
    }
}