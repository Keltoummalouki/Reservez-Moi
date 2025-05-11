<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Doctors & Hospitals',
                'slug' => 'doctors-hospitals',
                'description' => 'Réservation de consultations médicales et hospitalières.'
            ],
            [
                'name' => 'Services juridiques',
                'slug' => 'services-juridiques',
                'description' => 'Prise de rendez-vous avec des avocats ou notaires.'
            ],
            [
                'name' => 'Beauty Salon & Spas',
                'slug' => 'beauty-salon-spas',
                'description' => 'Planification de soins de beauté et de bien-être.'
            ],
            [
                'name' => 'Services à domicile',
                'slug' => 'services-a-domicile',
                'description' => 'Réservation de services à domicile.'
            ],
            [
                'name' => 'Conseils et coaching',
                'slug' => 'conseils-coaching',
                'description' => 'Rendez-vous avec coachs ou conseillers.'
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate([
                'name' => $category['name'],
            ], $category);
        }
    }
} 