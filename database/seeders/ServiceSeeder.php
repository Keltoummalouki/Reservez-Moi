<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\User;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        // Find a user with the ServiceProvider role
        $provider = User::whereHas('roles', function ($query) {
            $query->where('name', 'ServiceProvider');
        })->first();

        if (!$provider) {
            // Create a ServiceProvider user if none exists
            $provider = User::create([
                'name' => 'Service Provider',
                'email' => 'provider@example.com',
                'password' => bcrypt('password'),
            ]);
            $provider->roles()->attach(\App\Models\Role::where('name', 'ServiceProvider')->first());
        }

        // Create sample services for the provider
        Service::create([
            'provider_id' => $provider->id,
            'name' => 'Coiffure',
            'description' => 'Coupe de cheveux professionnelle pour hommes et femmes.',
            'price' => 30.00,
            'category' => 'Beauté',
            'is_available' => true,
        ]);

        Service::create([
            'provider_id' => $provider->id,
            'name' => 'Massage Relaxant',
            'description' => 'Un massage d\'une heure pour détente et bien-être.',
            'price' => 50.00,
            'category' => 'Bien-être',
            'is_available' => true,
        ]);

        Service::create([
            'provider_id' => $provider->id,
            'name' => 'Manucure',
            'description' => 'Soin des ongles avec pose de vernis.',
            'price' => 25.00,
            'category' => 'Beauté',
            'is_available' => false,
        ]);
    }
}