<?php

namespace App\Repositories;

use App\Models\Reservation;
use Carbon\Carbon;

interface ReservationRepositoryInterface
{
    /**
     * Get all reservations
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Find a reservation by ID
     *
     * @param int $id
     * @return Reservation
     */
    public function find($id);

    /**
     * Create a new reservation
     *
     * @param array $data
     * @return Reservation
     */
    public function create(array $data);

    /**
     * Update a reservation
     *
     * @param int $id
     * @param array $data
     * @return Reservation
     */
    public function update($id, array $data);

    /**
     * Delete a reservation
     *
     * @param int $id
     * @return bool
     */
    public function delete($id);

    /**
     * Check if there's a conflicting reservation for the same service at the same time
     *
     * @param int $serviceId
     * @param string|Carbon $reservationDate
     * @return Reservation|null
     */
    public function checkConflictingReservation($serviceId, $reservationDate);

    /**
     * Get upcoming reservations for a service
     *
     * @param int $serviceId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUpcomingForService($serviceId);

    /**
     * Get reservations for a user
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getForUser($userId);
}