<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Availability;

class AvailabilitySeeder extends Seeder
{
    public function run()
    {
        Availability::create([
            'service_id' => 1,
            'specific_date' => null,
            'day_of_week' => 1,
            'is_available' => true,
        ]);
    }
}