<?php
namespace App\Services;

use App\Repositories\ReservationRepositoryInterface;
use App\Repositories\ServiceRepositoryInterface;
use App\Notifications\ReservationCreated;
use Illuminate\Support\Facades\Auth;

class ReservationService
{
    protected $reservationRepository;
    protected $serviceRepository;

    public function __construct(
        ReservationRepositoryInterface $reservationRepository,
        ServiceRepositoryInterface $serviceRepository
    ) {
        $this->reservationRepository = $reservationRepository;
        $this->serviceRepository = $serviceRepository;
    }

    public function makeReservation($serviceId, array $data)
    {
        $service = $this->serviceRepository->find($serviceId);
        
        // Utiliser la date actuelle si aucune date n'est fournie
        $reservationDate = $data['reservation_date'] ?? now();
        
        // Créer la réservation sans vérifier les conflits
        $reservationData = [
            'user_id' => Auth::id(),
            'service_id' => $serviceId,
            'reservation_date' => $reservationDate,
            'status' => 'pending',
            'notes' => $data['notes'] ?? null,
            'amount' => $service->price,
            'payment_status' => 'pending',
        ];
        
        $reservation = $this->reservationRepository->create($reservationData);
        
        // Envoyer notification
        try {
            $service->provider->notify(new ReservationCreated($reservation));
        } catch (\Exception $e) {
            \Log::error('Failed to send reservation notification: ' . $e->getMessage());
        }
        
        return $reservation;
    }
}