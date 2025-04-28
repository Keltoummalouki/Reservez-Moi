<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\AvailabilityTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AvailabilityTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:ServiceProvider']);
    }

    /**
     * Liste des modèles de disponibilité
     */
    public function index(Service $service)
    {
        $templates = AvailabilityTemplate::where('service_id', $service->id)
            ->orWhere('created_by', Auth::id())
            ->get();

        return view('provider.availability.templates.index', compact('service', 'templates'));
    }

    /**
     * Formulaire de création d'un modèle
     */
    public function create(Service $service)
    {
        return view('provider.availability.templates.create', compact('service'));
    }

    /**
     * Enregistrer un nouveau modèle
     */
    public function store(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'is_seasonal' => 'boolean',
            'season_start' => 'required_if:is_seasonal,true|nullable|date',
            'season_end' => 'required_if:is_seasonal,true|nullable|date|after:season_start',
            'config' => 'required|array',
            'config.availabilities' => 'required|array',
            'config.availabilities.*.day_of_week' => 'required|integer|between:0,6',
            'config.availabilities.*.start_time' => 'required|date_format:H:i',
            'config.availabilities.*.end_time' => 'required|date_format:H:i|after:config.availabilities.*.start_time',
            'config.availabilities.*.max_reservations' => 'required|integer|min:1',
            'config.availabilities.*.preparation_time' => 'nullable|integer|min:0',
            'config.availabilities.*.slot_duration' => 'nullable|integer|min:1',
            'config.breaks' => 'nullable|array',
            'config.breaks.*.start' => 'required|date_format:H:i',
            'config.breaks.*.end' => 'required|date_format:H:i|after:config.breaks.*.start',
        ]);

        $template = AvailabilityTemplate::create([
            'name' => $validated['name'],
            'service_id' => $service->id,
            'created_by' => Auth::id(),
            'is_seasonal' => $validated['is_seasonal'] ?? false,
            'season_start' => $validated['season_start'] ?? null,
            'season_end' => $validated['season_end'] ?? null,
            'config' => $validated['config'],
        ]);

        return redirect()->route('provider.availability.templates.index', $service)
            ->with('success', 'Modèle de disponibilité créé avec succès.');
    }

    /**
     * Appliquer un modèle
     */
    public function apply(Request $request, Service $service, AvailabilityTemplate $template)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'override_existing' => 'boolean'
        ]);

        // Si on doit écraser les disponibilités existantes
        if ($validated['override_existing']) {
            $service->availabilities()
                ->whereBetween('specific_date', [$validated['start_date'], $validated['end_date']])
                ->delete();
        }

        // Appliquer le modèle
        $template->applyToService(
            $service,
            Carbon::parse($validated['start_date']),
            Carbon::parse($validated['end_date'])
        );

        return redirect()->route('provider.availability.index', $service)
            ->with('success', 'Modèle de disponibilité appliqué avec succès.');
    }

    /**
     * Formulaire de modification d'un modèle
     */
    public function edit(Service $service, AvailabilityTemplate $template)
    {
        $this->authorize('update', $template);

        return view('provider.availability.templates.edit', compact('service', 'template'));
    }

    /**
     * Mettre à jour un modèle
     */
    public function update(Request $request, Service $service, AvailabilityTemplate $template)
    {
        $this->authorize('update', $template);

        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'is_seasonal' => 'boolean',
            'season_start' => 'required_if:is_seasonal,true|nullable|date',
            'season_end' => 'required_if:is_seasonal,true|nullable|date|after:season_start',
            'config' => 'required|array',
            'config.availabilities' => 'required|array',
            'config.availabilities.*.day_of_week' => 'required|integer|between:0,6',
            'config.availabilities.*.start_time' => 'required|date_format:H:i',
            'config.availabilities.*.end_time' => 'required|date_format:H:i|after:config.availabilities.*.start_time',
            'config.availabilities.*.max_reservations' => 'required|integer|min:1',
            'config.availabilities.*.preparation_time' => 'nullable|integer|min:0',
            'config.availabilities.*.slot_duration' => 'nullable|integer|min:1',
            'config.breaks' => 'nullable|array',
            'config.breaks.*.start' => 'required|date_format:H:i',
            'config.breaks.*.end' => 'required|date_format:H:i|after:config.breaks.*.start',
        ]);

        $template->update([
            'name' => $validated['name'],
            'is_seasonal' => $validated['is_seasonal'] ?? false,
            'season_start' => $validated['season_start'] ?? null,
            'season_end' => $validated['season_end'] ?? null,
            'config' => $validated['config'],
        ]);

        return redirect()->route('provider.availability.templates.index', $service)
            ->with('success', 'Modèle de disponibilité mis à jour avec succès.');
    }

    /**
     * Supprimer un modèle
     */
    public function destroy(Service $service, AvailabilityTemplate $template)
    {
        $this->authorize('delete', $template);

        $template->delete();

        return redirect()->route('provider.availability.templates.index', $service)
            ->with('success', 'Modèle de disponibilité supprimé avec succès.');
    }

    /**
     * Dupliquer un modèle
     */
    public function duplicate(Service $service, AvailabilityTemplate $template)
    {
        $newTemplate = $template->replicate();
        $newTemplate->name = $template->name . ' (copie)';
        $newTemplate->created_by = Auth::id();
        $newTemplate->save();

        return redirect()->route('provider.availability.templates.edit', [$service, $newTemplate])
            ->with('success', 'Modèle dupliqué avec succès. Vous pouvez maintenant le modifier.');
    }
}