<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ServiceRepositoryInterface;
use App\Repositories\ServiceRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->bind(ReservationRepositoryInterface::class, ReservationRepository::class);
    }
}