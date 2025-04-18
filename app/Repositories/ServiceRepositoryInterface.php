<?php

namespace App\Repositories;

use App\Models\Service;

interface ServiceRepositoryInterface
{
    /**
     * Get all services
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Find a service by ID
     *
     * @param int $id
     * @return Service
     */
    public function find($id);

    /**
     * Create a new service
     *
     * @param array $data
     * @return Service
     */
    public function create(array $data);

    /**
     * Update a service
     *
     * @param int $id
     * @param array $data
     * @return Service
     */
    public function update($id, array $data);

    /**
     * Delete a service
     *
     * @param int $id
     * @return bool
     */
    public function delete($id);
}