<?php

namespace App\Repositories;

use App\Models\Service;

class ServiceRepository implements ServiceRepositoryInterface
{
    protected $model;

    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    /**
     * Get all services
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->where('provider_id', auth()->id())->get();
    }

    /**
     * Find a service by ID
     *
     * @param int $id
     * @return Service
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new service
     *
     * @param array $data
     * @return Service
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a service
     *
     * @param int $id
     * @param array $data
     * @return Service
     */
    public function update($id, array $data)
    {
        $service = $this->find($id);
        $service->update($data);
        return $service;
    }

    /**
     * Delete a service
     *
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}