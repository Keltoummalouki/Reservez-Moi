<?php

namespace App\Repositories;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReservationRepository implements ReservationRepositoryInterface
{
    protected $model;

    public function __construct(Reservation $model)
    {
        $this->model = $model;
    }

    /**
     * Get all reservations
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Find a reservation by ID
     *
     * @param int $id
     * @return Reservation
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new reservation
     *
     * @param array $data
     * @return Reservation
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a reservation
     *
     * @param int $id
     * @param array $data
     * @return Reservation
     */
    public function update($id, array $data)
    {
        $reservation = $this->find($id);
        $reservation->update($data);
        return $reservation;
    }

    /**
     * Delete a reservation
     *
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    /**
     * Check if there's a conflicting reservation for the same service at the same time
     *
     * @param int $serviceId
     * @param string|Carbon $reservationDate
     * @return Reservation|null
     */
    public function checkConflictingReservation($serviceId, $reservationDate)
    {
        if (!$reservationDate instanceof Carbon) {
            $reservationDate = Carbon::parse($reservationDate);
        }

        return $this->model
            ->where('service_id', $serviceId)
            ->where('reservation_date', $reservationDate)
            ->whereIn('status', [Reservation::STATUS_PENDING, Reservation::STATUS_CONFIRMED])
            ->first();
    }

    /**
     * Get upcoming reservations for a service
     *
     * @param int $serviceId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUpcomingForService($serviceId)
    {
        return $this->model
            ->where('service_id', $serviceId)
            ->where('reservation_date', '>=', now())
            ->whereIn('status', [Reservation::STATUS_PENDING, Reservation::STATUS_CONFIRMED])
            ->orderBy('reservation_date')
            ->get();
    }

    /**
     * Get reservations for a user
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getForUser($userId)
    {
        return $this->model
            ->where('user_id', $userId)
            ->orderBy('reservation_date', 'desc')
            ->get();
    }
}