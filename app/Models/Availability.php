<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'day_of_week',         // 0 (dimanche) à 6 (samedi)
        'start_time',          // Format H:i:s
        'end_time',            // Format H:i:s
        'is_available',        // true = disponible, false = indisponible (exception)
        'specific_date',       // Date spécifique (nullable)
        'max_reservations',    // Nombre max de réservations pour ce créneau
    ];

    protected $casts = [
        'specific_date' => 'date',
        'is_available' => 'boolean',
        'max_reservations' => 'integer',
        'day_of_week' => 'integer',
    ];

    /**
     * Relation avec le service
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Scope: disponibilités hebdomadaires (récurrentes)
     */
    public function scopeWeekly($query)
    {
        return $query->whereNull('specific_date');
    }

    /**
     * Scope: disponibilités spécifiques (dates exceptionnelles)
     */
    public function scopeSpecific($query)
    {
        return $query->whereNotNull('specific_date');
    }

    /**
     * Scope: disponibilités disponibles (is_available = true)
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope: indisponibilités (is_available = false)
     */
    public function scopeUnavailable($query)
    {
        return $query->where('is_available', false);
    }

    /**
     * Vérifier si un créneau spécifique est disponible pour un service
     *
     * @param int $serviceId
     * @param \DateTime|string $dateTime
     * @return bool
     */
    public static function isAvailable($serviceId, $dateTime)
    {
        // Convertir en Carbon si ce n'est pas déjà le cas
        if (!($dateTime instanceof Carbon)) {
            $dateTime = Carbon::parse($dateTime);
        }

        // Vérifier d'abord s'il y a une exception pour cette date spécifique
        $specificAvailability = self::where('service_id', $serviceId)
            ->where('specific_date', $dateTime->toDateString())
            ->where(function ($query) use ($dateTime) {
                $timeStr = $dateTime->format('H:i:s');
                return $query->whereRaw("? BETWEEN start_time AND end_time", [$timeStr]);
            })
            ->first();

        if ($specificAvailability) {
            // Si c'est marqué comme indisponible explicitement pour cette date
            if (!$specificAvailability->is_available) {
                return false;
            }

            // Vérifier le nombre de réservations déjà effectuées pour ce créneau
            if ($specificAvailability->max_reservations > 0) {
                $reservationCount = Reservation::where('service_id', $serviceId)
                    ->whereDate('reservation_date', $dateTime->toDateString())
                    ->whereTime('reservation_date', '>=', $specificAvailability->start_time)
                    ->whereTime('reservation_date', '<=', $specificAvailability->end_time)
                    ->whereIn('status', [Reservation::STATUS_PENDING, Reservation::STATUS_CONFIRMED])
                    ->count();

                if ($reservationCount >= $specificAvailability->max_reservations) {
                    return false;
                }
            }

            return true;
        }

        // Vérifier ensuite les disponibilités hebdomadaires récurrentes
        $dayOfWeek = $dateTime->dayOfWeek; // 0 (dimanche) à 6 (samedi)
        $weeklyAvailability = self::where('service_id', $serviceId)
            ->whereNull('specific_date')
            ->where('day_of_week', $dayOfWeek)
            ->where(function ($query) use ($dateTime) {
                $timeStr = $dateTime->format('H:i:s');
                return $query->whereRaw("? BETWEEN start_time AND end_time", [$timeStr]);
            })
            ->first();

        if (!$weeklyAvailability || !$weeklyAvailability->is_available) {
            return false;
        }

        // Vérifier le nombre de réservations déjà effectuées pour ce créneau
        if ($weeklyAvailability->max_reservations > 0) {
            $reservationCount = Reservation::where('service_id', $serviceId)
                ->whereDate('reservation_date', $dateTime->toDateString())
                ->whereTime('reservation_date', '>=', $weeklyAvailability->start_time)
                ->whereTime('reservation_date', '<=', $weeklyAvailability->end_time)
                ->whereIn('status', [Reservation::STATUS_PENDING, Reservation::STATUS_CONFIRMED])
                ->count();

            if ($reservationCount >= $weeklyAvailability->max_reservations) {
                return false;
            }
        }

        return true;
    }

    /**
     * Obtenir les créneaux disponibles pour un service à une date donnée
     *
     * @param int $serviceId
     * @param string $date Format Y-m-d
     * @return array
     */
    public static function getAvailableSlots($serviceId, $date)
    {
        $dateObj = Carbon::parse($date);
        $dayOfWeek = $dateObj->dayOfWeek;
        
        // Obtenir les disponibilités hebdomadaires pour ce jour de la semaine
        $weeklySlots = self::where('service_id', $serviceId)
            ->whereNull('specific_date')
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->get();
            
        // Obtenir les disponibilités/indisponibilités spécifiques pour cette date
        $specificSlots = self::where('service_id', $serviceId)
            ->where('specific_date', $date)
            ->get();
            
        $availableSlots = [];
        
        // Traiter les créneaux hebdomadaires
        foreach ($weeklySlots as $slot) {
            // Vérifier si ce créneau n'est pas annulé par une exception spécifique
            $isOverridden = $specificSlots->contains(function ($specificSlot) use ($slot) {
                return !$specificSlot->is_available && 
                       self::timesOverlap($slot->start_time, $slot->end_time, 
                                         $specificSlot->start_time, $specificSlot->end_time);
            });
            
            if (!$isOverridden) {
                // Vérifier le nombre de réservations existantes
                $reservationCount = Reservation::where('service_id', $serviceId)
                    ->whereDate('reservation_date', $date)
                    ->whereTime('reservation_date', '>=', $slot->start_time)
                    ->whereTime('reservation_date', '<=', $slot->end_time)
                    ->whereIn('status', [Reservation::STATUS_PENDING, Reservation::STATUS_CONFIRMED])
                    ->count();
                
                if ($reservationCount < $slot->max_reservations) {
                    $availableSlots[] = [
                        'start_time' => $slot->start_time,
                        'end_time' => $slot->end_time,
                        'available_spots' => $slot->max_reservations - $reservationCount
                    ];
                }
            }
        }
        
        // Ajouter les créneaux spécifiques disponibles à cette date
        foreach ($specificSlots as $slot) {
            if ($slot->is_available) {
                // Vérifier le nombre de réservations existantes
                $reservationCount = Reservation::where('service_id', $serviceId)
                    ->whereDate('reservation_date', $date)
                    ->whereTime('reservation_date', '>=', $slot->start_time)
                    ->whereTime('reservation_date', '<=', $slot->end_time)
                    ->whereIn('status', [Reservation::STATUS_PENDING, Reservation::STATUS_CONFIRMED])
                    ->count();
                
                if ($reservationCount < $slot->max_reservations) {
                    $availableSlots[] = [
                        'start_time' => $slot->start_time,
                        'end_time' => $slot->end_time,
                        'available_spots' => $slot->max_reservations - $reservationCount
                    ];
                }
            }
        }
        
        // Trier les créneaux par heure de début
        usort($availableSlots, function ($a, $b) {
            return strcmp($a['start_time'], $b['start_time']);
        });
        
        return $availableSlots;
    }
    
    /**
     * Vérifier si deux plages horaires se chevauchent
     *
     * @param string $start1 Format H:i:s
     * @param string $end1 Format H:i:s
     * @param string $start2 Format H:i:s
     * @param string $end2 Format H:i:s
     * @return bool
     */
    private static function timesOverlap($start1, $end1, $start2, $end2)
    {
        return $start1 < $end2 && $start2 < $end1;
    }
}