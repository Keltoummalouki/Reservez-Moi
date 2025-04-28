<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Availability;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Reservation;

class ProviderAvailabilityController extends Controller
{
    /**
     * Constructeur du contrôleur
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:ServiceProvider']);
    }

    /**
     * Afficher la page de gestion des disponibilités
     *
     * @param int $serviceId
     * @return \Illuminate\View\View
     */
    public function index(Service $service)
    {
        $availabilities = collect();
        
        // Récupérer toutes les disponibilités du service
        $serviceAvailabilities = $service->availabilities()
            ->where(function($query) {
                $query->whereNotNull('specific_date')
                      ->orWhereNotNull('day_of_week');
            })
            ->get();
        
        $today = now()->startOfWeek();
        
        foreach ($serviceAvailabilities as $availability) {
            if ($availability->specific_date) {
                // Pour les disponibilités spécifiques
                $availabilities->push([
                    'id' => $availability->id,
                    'title' => $this->formatAvailabilityTitle($availability),
                    'start' => $availability->specific_date . ' ' . $availability->start_time,
                    'end' => $availability->specific_date . ' ' . $availability->end_time,
                    'className' => $availability->is_available ? 'available' : 'unavailable',
                    'max_reservations' => $availability->max_reservations,
                    'type' => 'specific'
                ]);
            } else {
                // Pour les disponibilités hebdomadaires
                // Générer les 4 prochaines semaines
                for ($week = 0; $week < 4; $week++) {
                    $date = $today->copy()->addWeeks($week);
                    $dayOfWeek = $availability->day_of_week;
                    
                    // Ajuster au bon jour de la semaine
                    $date = $date->copy()->startOfWeek();
                    if ($dayOfWeek == 0) {
                        $date->endOfWeek(); // Dimanche
                    } else {
                        $date->addDays($dayOfWeek);
                    }
                    
                    // Vérifier s'il n'y a pas de disponibilité spécifique qui override
                    $hasSpecificOverride = $service->availabilities()
                        ->whereDate('specific_date', $date->format('Y-m-d'))
                        ->exists();
                        
                    if (!$hasSpecificOverride) {
                        $availabilities->push([
                            'id' => $availability->id,
                            'title' => $this->formatAvailabilityTitle($availability),
                            'start' => $date->format('Y-m-d') . ' ' . $availability->start_time,
                            'end' => $date->format('Y-m-d') . ' ' . $availability->end_time,
                            'className' => 'available recurring',
                            'max_reservations' => $availability->max_reservations,
                            'type' => 'weekly'
                        ]);
                    }
                }
            }
        }

        return view('provider.availability.index', compact('service', 'availabilities'));
    }

    /**
     * Formater le titre de la disponibilité
     */
    private function formatAvailabilityTitle($availability)
    {
        if (!$availability->is_available) {
            return 'Indisponible';
        }

        $maxReservations = $availability->max_reservations;
        $startTime = Carbon::parse($availability->start_time)->format('H:i');
        $endTime = Carbon::parse($availability->end_time)->format('H:i');
        
        return sprintf(
            'Disponible (%d place%s) %s-%s',
            $maxReservations,
            $maxReservations > 1 ? 's' : '',
            $startTime,
            $endTime
        );
    }

    /**
     * Afficher le formulaire pour ajouter une disponibilité hebdomadaire
     *
     * @param int $serviceId
     * @return \Illuminate\View\View
     */
    public function createWeekly($serviceId)
    {
        // Vérifier que le service appartient au prestataire connecté
        $service = Service::where('id', $serviceId)
            ->where('provider_id', Auth::id())
            ->firstOrFail();
            
        // Récupérer tous les services du prestataire
        $services = Service::where('provider_id', Auth::id())->get();
            
        return view('provider.availability.create_weekly', compact('service', 'services'));
    }

    /**
     * Enregistrer une nouvelle disponibilité hebdomadaire
     *
     * @param Request $request
     * @param int $serviceId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeWeekly(Request $request, $serviceId)
    {
        // Vérifier que le service appartient au prestataire connecté
        $service = Service::where('id', $serviceId)
            ->where('provider_id', Auth::id())
            ->firstOrFail();
            
        // Valider les données du formulaire
        $validated = $request->validate([
            'days_of_week' => 'required|array',
            'days_of_week.*' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_reservations' => 'required|integer|min:1',
        ]);
        
        // Convertir les heures au format H:i:s
        $startTime = $validated['start_time'] . ':00';
        $endTime = $validated['end_time'] . ':00';
        
        $successCount = 0;
        $errorCount = 0;
        
        foreach ($validated['days_of_week'] as $dayOfWeek) {
            // Vérifier s'il y a un chevauchement avec une disponibilité existante
            $overlap = Availability::where('service_id', $serviceId)
                ->whereNull('specific_date')
                ->where('day_of_week', $dayOfWeek)
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->where(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<', $endTime)
                          ->where('end_time', '>', $startTime);
                    });
                })
                ->exists();
                
            if (!$overlap) {
                // Créer la nouvelle disponibilité
                Availability::create([
                    'service_id' => $serviceId,
                    'day_of_week' => $dayOfWeek,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'is_available' => true,
                    'max_reservations' => $validated['max_reservations'],
                ]);
                $successCount++;
            } else {
                $errorCount++;
            }
        }
        
        if ($errorCount > 0) {
            $message = $successCount > 0 
                ? "Certaines disponibilités ont été ajoutées, mais {$errorCount} créneau(x) n'ont pas pu être ajoutés car ils chevauchent des disponibilités existantes."
                : "Aucune disponibilité n'a pu être ajoutée car tous les créneaux chevauchent des disponibilités existantes.";
            return redirect()->route('provider.availability.index', $serviceId)
                           ->with('warning', $message);
        }
        
        return redirect()->route('provider.availability.index', $serviceId)
                        ->with('success', 'Les disponibilités hebdomadaires ont été ajoutées avec succès.');
    }

    /**
     * Afficher le formulaire pour ajouter une disponibilité spécifique
     *
     * @param int $serviceId
     * @return \Illuminate\View\View
     */
    public function createSpecific($serviceId)
    {
        // Vérifier que le service appartient au prestataire connecté
        $service = Service::where('id', $serviceId)
            ->where('provider_id', Auth::id())
            ->firstOrFail();
            
        return view('provider.availability.create_specific', compact('service'));
    }

    /**
     * Enregistrer une nouvelle disponibilité spécifique
     *
     * @param Request $request
     * @param int $serviceId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeSpecific(Request $request, $serviceId)
    {
        // Vérifier que le service appartient au prestataire connecté
        $service = Service::where('id', $serviceId)
            ->where('provider_id', Auth::id())
            ->firstOrFail();
            
        // Valider les données du formulaire
        $validated = $request->validate([
            'specific_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_available' => 'required|boolean',
            'max_reservations' => 'required_if:is_available,1|integer|min:1|nullable',
        ]);
        
        // Convertir les heures au format H:i:s
        $validated['start_time'] = $validated['start_time'] . ':00';
        $validated['end_time'] = $validated['end_time'] . ':00';
        
        // Si c'est une indisponibilité, on n'a pas besoin de max_reservations
        if (!$validated['is_available']) {
            $validated['max_reservations'] = 0;
        }
        
        // Vérifier s'il y a un chevauchement avec une disponibilité existante pour la même date
        $overlap = Availability::where('service_id', $serviceId)
            ->where('specific_date', $validated['specific_date'])
            ->where(function ($query) use ($validated) {
                $query->where(function ($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>', $validated['start_time']);
                });
            })
            ->exists();
            
        if ($overlap) {
            return back()->withErrors(['overlap' => 'Ce créneau chevauche une disponibilité existante pour cette date.'])
                         ->withInput();
        }
        
        // Vérifier s'il existe déjà des réservations pour ce créneau
        if (!$validated['is_available']) {
            $reservations = Reservation::where('service_id', $serviceId)
                ->whereDate('reservation_date', $validated['specific_date'])
                ->whereTime('reservation_date', '>=', $validated['start_time'])
                ->whereTime('reservation_date', '<=', $validated['end_time'])
                ->whereIn('status', [Reservation::STATUS_PENDING, Reservation::STATUS_CONFIRMED])
                ->count();
                
            if ($reservations > 0) {
                return back()->withErrors(['reservations' => 'Il existe déjà des réservations pour ce créneau. Vous ne pouvez pas le marquer comme indisponible.'])
                             ->withInput();
            }
        }
        
        // Créer la nouvelle disponibilité spécifique
        Availability::create([
            'service_id' => $serviceId,
            'specific_date' => $validated['specific_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_available' => $validated['is_available'],
            'max_reservations' => $validated['max_reservations'] ?? 0,
        ]);
        
        return redirect()->route('provider.availability.index', $serviceId)
                        ->with('success', 'Disponibilité spécifique ajoutée avec succès.');
    }

    /**
     * Supprimer une disponibilité
     *
     * @param int $serviceId
     * @param int $availabilityId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($serviceId, $availabilityId)
    {
        // Vérifier que le service appartient au prestataire connecté
        $service = Service::where('id', $serviceId)
            ->where('provider_id', Auth::id())
            ->firstOrFail();
            
        // Récupérer la disponibilité
        $availability = Availability::where('id', $availabilityId)
            ->where('service_id', $serviceId)
            ->firstOrFail();
            
        // Vérifier s'il existe déjà des réservations pour ce créneau
        if ($availability->specific_date) {
            $reservations = Reservation::where('service_id', $serviceId)
                ->whereDate('reservation_date', $availability->specific_date)
                ->whereTime('reservation_date', '>=', $availability->start_time)
                ->whereTime('reservation_date', '<=', $availability->end_time)
                ->whereIn('status', [Reservation::STATUS_PENDING, Reservation::STATUS_CONFIRMED])
                ->count();
                
            if ($reservations > 0) {
                return back()->withErrors(['reservations' => 'Il existe déjà des réservations pour ce créneau. Vous ne pouvez pas le supprimer.']);
            }
        } else {
            // Pour les disponibilités hebdomadaires, vérifier les réservations futures
            $dayOfWeek = $availability->day_of_week;
            $startTime = $availability->start_time;
            $endTime = $availability->end_time;
            
            $reservations = Reservation::where('service_id', $serviceId)
                ->where('reservation_date', '>=', now())
                ->whereRaw("DAYOFWEEK(reservation_date) = ?", [$dayOfWeek === 0 ? 1 : $dayOfWeek + 1]) // MySQL utilise 1-7 (dimanche à samedi), PHP utilise 0-6
                ->whereTime('reservation_date', '>=', $startTime)
                ->whereTime('reservation_date', '<=', $endTime)
                ->whereIn('status', [Reservation::STATUS_PENDING, Reservation::STATUS_CONFIRMED])
                ->count();
                
            if ($reservations > 0) {
                return back()->withErrors(['reservations' => 'Il existe déjà des réservations futures pour ce créneau. Vous ne pouvez pas le supprimer.']);
            }
        }
        
        // Supprimer la disponibilité
        $availability->delete();
        
        return redirect()->route('provider.availability.index', $serviceId)
                        ->with('success', 'Disponibilité supprimée avec succès.');
    }

    /**
     * Obtenir les créneaux disponibles pour un service à une date donnée (API)
     *
     * @param Request $request
     * @param int $serviceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableSlots(Request $request, $serviceId)
    {
        // Valider les données de la requête
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);
        
        // Récupérer le service
        $service = Service::findOrFail($serviceId);
        
        // Obtenir les créneaux disponibles
        $slots = Availability::getAvailableSlots($serviceId, $validated['date']);
        
        // Formatter les créneaux pour l'affichage
        $formattedSlots = [];
        foreach ($slots as $slot) {
            $startTime = Carbon::parse($slot['start_time'])->format('H:i');
            $endTime = Carbon::parse($slot['end_time'])->format('H:i');
            
            $formattedSlots[] = [
                'start_time' => $startTime,
                'end_time' => $endTime,
                'formatted' => $startTime . ' - ' . $endTime,
                'available_spots' => $slot['available_spots'],
            ];
        }
        
        return response()->json([
            'date' => $validated['date'],
            'service_name' => $service->name,
            'slots' => $formattedSlots,
            'has_slots' => count($formattedSlots) > 0,
        ]);
    }

    /**
     * Afficher le formulaire pour modifier une disponibilité hebdomadaire
     * 
     * @param int $serviceId
     * @param int $availabilityId
     * @return \Illuminate\View\View
     */
    public function editWeekly($serviceId, $availabilityId)
    {
        // Vérifiez que le service appartient au prestataire connecté
        $service = Service::where('id', $serviceId)
            ->where('provider_id', Auth::id())
            ->firstOrFail();
    
        // Récupérez la disponibilité hebdomadaire
        $availability = Availability::where('id', $availabilityId)
            ->where('service_id', $serviceId)
            ->whereNull('specific_date')
            ->firstOrFail();
    
        return view('provider.availability.edit_weekly', compact('service', 'availability'));
    }

    /**
     * Mettre à jour une disponibilité hebdomadaire
     * 
     * @param Request $request
     * @param int $serviceId
     * @param int $availabilityId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateWeekly(Request $request, $serviceId, $availabilityId)
    {
        // Vérifiez que le service appartient au prestataire connecté
        $service = Service::where('id', $serviceId)
            ->where('provider_id', Auth::id())
            ->firstOrFail();

        // Récupérez la disponibilité hebdomadaire
        $availability = Availability::where('id', $availabilityId)
            ->where('service_id', $serviceId)
            ->whereNull('specific_date')
            ->firstOrFail();

        // Validez les données
        $validated = $request->validate([
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_reservations' => 'required|integer|min:1',
        ]);
        
        // Convertir les heures au format H:i:s
        $validated['start_time'] = $validated['start_time'] . ':00';
        $validated['end_time'] = $validated['end_time'] . ':00';
        
        // Vérifier s'il y a un chevauchement avec une autre disponibilité existante
        $overlap = Availability::where('service_id', $serviceId)
            ->whereNull('specific_date')
            ->where('day_of_week', $validated['day_of_week'])
            ->where('id', '!=', $availabilityId) // Exclure la disponibilité actuelle
            ->where(function ($query) use ($validated) {
                $query->where(function ($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>', $validated['start_time']);
                });
            })
            ->exists();
            
        if ($overlap) {
            return back()->withErrors(['overlap' => 'Ce créneau chevauche une disponibilité existante.'])
                         ->withInput();
        }
        
        // Vérifier les réservations existantes si on change le jour ou les horaires
        if ($availability->day_of_week != $validated['day_of_week'] || 
            $availability->start_time != $validated['start_time'] || 
            $availability->end_time != $validated['end_time']) {
            
            // Pour les disponibilités hebdomadaires, vérifier les réservations futures
            $dayOfWeek = $availability->day_of_week;
            $startTime = $availability->start_time;
            $endTime = $availability->end_time;
            
            $reservations = Reservation::where('service_id', $serviceId)
                ->where('reservation_date', '>=', now())
                ->whereRaw("DAYOFWEEK(reservation_date) = ?", [$dayOfWeek === 0 ? 1 : $dayOfWeek + 1])
                ->whereTime('reservation_date', '>=', $startTime)
                ->whereTime('reservation_date', '<=', $endTime)
                ->whereIn('status', [Reservation::STATUS_PENDING, Reservation::STATUS_CONFIRMED])
                ->count();
                
            if ($reservations > 0) {
                return back()->withErrors(['reservations' => 'Il existe déjà des réservations futures pour ce créneau. Vous ne pouvez pas le modifier.'])
                            ->withInput();
            }
        }

        // Mettez à jour la disponibilité
        $availability->update([
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'max_reservations' => $validated['max_reservations'],
        ]);

        return redirect()->route('provider.availability.index', $serviceId)
            ->with('success', 'Disponibilité mise à jour avec succès.');
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'date' => 'required|date',
            'is_available' => 'required|boolean'
        ]);

        $date = Carbon::parse($request->date);
        
        // Si c'est une disponibilité spécifique
        if ($request->has('specific_date')) {
            $availability = $service->availabilities()->updateOrCreate(
                [
                    'specific_date' => $date->format('Y-m-d'),
                    'start_time' => $date->copy()->startOfDay()->format('H:i:s'),
                    'end_time' => $date->copy()->endOfDay()->format('H:i:s'),
                ],
                [
                    'is_available' => $request->is_available,
                    'max_reservations' => $request->is_available ? 1 : 0,
                    'day_of_week' => null // Explicitement null pour les dates spécifiques
                ]
            );
        } else {
            // Pour les disponibilités hebdomadaires
            $availability = $service->availabilities()->updateOrCreate(
                [
                    'day_of_week' => $date->dayOfWeek,
                    'start_time' => $date->copy()->startOfDay()->format('H:i:s'),
                    'end_time' => $date->copy()->endOfDay()->format('H:i:s'),
                ],
                [
                    'is_available' => $request->is_available,
                    'max_reservations' => $request->is_available ? 1 : 0,
                    'specific_date' => null // Explicitement null pour les disponibilités hebdomadaires
                ]
            );
        }

        return response()->json([
            'success' => true,
            'availability' => $availability
        ]);
    }
}