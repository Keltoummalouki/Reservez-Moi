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
        'specific_date',
        'day_of_week',
        'start_time',
        'end_time',
        'is_available',
        'max_reservations',
        'recurrence_type',
        'recurrence_config',
        'valid_from',
        'valid_until',
        'is_template',
        'template_name',
        'preparation_time',
        'slot_duration',
        'breaks',
        'external_calendar_id',
        'external_event_id',
        'priority'
    ];

    protected $casts = [
        'specific_date' => 'date',
        'is_available' => 'boolean',
        'recurrence_config' => 'array',
        'breaks' => 'array',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_template' => 'boolean'
    ];

    /**
     * Relation avec le service
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
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
                ->whereRaw("TIME(reservation_date) >= ?", [$specificAvailability->start_time])
                ->whereRaw("TIME(reservation_date) <= ?", [$specificAvailability->end_time])
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
            ->whereRaw("TIME(reservation_date) >= ?", [$weeklyAvailability->start_time])
            ->whereRaw("TIME(reservation_date) <= ?", [$weeklyAvailability->end_time])
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
        $service = Service::findOrFail($serviceId);
        $date = Carbon::parse($date);
        $dayOfWeek = $date->dayOfWeek;
        
        // Récupérer les disponibilités spécifiques pour cette date
        $specificAvailabilities = self::where('service_id', $serviceId)
            ->where('specific_date', $date->format('Y-m-d'))
            ->where('is_available', true)
            ->get();
            
        // Récupérer les disponibilités hebdomadaires
        $weeklyAvailabilities = self::where('service_id', $serviceId)
            ->whereNull('specific_date')
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->where(function ($query) use ($date) {
                $query->whereNull('valid_until')
                      ->orWhere('valid_until', '>=', $date);
            })
            ->where(function ($query) use ($date) {
                $query->whereNull('valid_from')
                      ->orWhere('valid_from', '<=', $date);
            })
            ->get();
            
        $availabilities = $specificAvailabilities->count() > 0 ? $specificAvailabilities : $weeklyAvailabilities;
        
        $slots = collect();
        
        foreach ($availabilities as $availability) {
            // Générer les créneaux en fonction de la durée du service et du temps de préparation
            $startTime = Carbon::parse($availability->start_time);
            $endTime = Carbon::parse($availability->end_time);
            $slotDuration = $availability->slot_duration ?? $service->duration;
            $preparationTime = $availability->preparation_time ?? 0;
            
            // Gérer les pauses
            $breaks = $availability->breaks ?? [];
            
            while ($startTime->copy()->addMinutes($slotDuration) <= $endTime) {
                $slotEndTime = $startTime->copy()->addMinutes($slotDuration);
                
                // Vérifier si le créneau chevauche une pause
                $isInBreak = false;
                foreach ($breaks as $break) {
                    $breakStart = Carbon::parse($break['start']);
                    $breakEnd = Carbon::parse($break['end']);
                    
                    if ($startTime->between($breakStart, $breakEnd) || 
                        $slotEndTime->between($breakStart, $breakEnd)) {
                        $isInBreak = true;
                        break;
                    }
                }
                
                if (!$isInBreak) {
                    // Compter les réservations existantes
                    $reservations = Reservation::where('service_id', $serviceId)
                        ->whereDate('reservation_date', $date)
                        ->whereTime('reservation_date', '>=', $startTime->format('H:i:s'))
                        ->whereTime('reservation_date', '<', $slotEndTime->format('H:i:s'))
                        ->whereIn('status', [Reservation::STATUS_PENDING, Reservation::STATUS_CONFIRMED])
                        ->count();
                        
                    if ($reservations < $availability->max_reservations) {
                        $slots->push([
                            'start_time' => $startTime->format('H:i:s'),
                            'end_time' => $slotEndTime->format('H:i:s'),
                            'available_spots' => $availability->max_reservations - $reservations
                        ]);
                    }
                }
                
                // Ajouter le temps de préparation pour le prochain créneau
                $startTime->addMinutes($slotDuration + $preparationTime);
            }
        }
        
        return $slots;
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

    public function isAvailableForReservation()
    {
        if (!$this->is_available) {
            return false;
        }

        $reservationsCount = $this->reservations()
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        return $reservationsCount < $this->max_reservations;
    }

    /**
     * Vérifier les chevauchements avec d'autres disponibilités
     */
    public function hasOverlap()
    {
        $query = self::where('service_id', $this->service_id)
            ->where('id', '!=', $this->id);
            
        if ($this->specific_date) {
            $query->where('specific_date', $this->specific_date);
        } else {
            $query->whereNull('specific_date')
                  ->where('day_of_week', $this->day_of_week);
        }
        
        return $query->where(function ($q) {
            $q->where(function ($q2) {
                $q2->where('start_time', '<', $this->end_time)
                   ->where('end_time', '>', $this->start_time);
            });
        })->exists();
    }

    /**
     * Fusionner avec une autre disponibilité
     */
    public function mergeWith(Availability $other)
    {
        $this->start_time = min($this->start_time, $other->start_time);
        $this->end_time = max($this->end_time, $other->end_time);
        $this->max_reservations = max($this->max_reservations, $other->max_reservations);
        $this->save();
        
        $other->delete();
        
        return $this;
    }

    /**
     * Diviser une disponibilité en deux
     */
    public function splitAt($time)
    {
        $newAvailability = $this->replicate();
        
        $this->end_time = $time;
        $this->save();
        
        $newAvailability->start_time = $time;
        $newAvailability->save();
        
        return [$this, $newAvailability];
    }
}