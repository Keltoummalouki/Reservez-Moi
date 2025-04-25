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
                'name' => 'Médical',
                'slug' => 'medical',
                'description' => 'Services médicaux et paramédicaux'
            ],
            [
                'name' => 'Beauté',
                'slug' => 'beaute',
                'description' => 'Services de beauté et de bien-être'
            ],
            [
                'name' => 'Coiffure',
                'slug' => 'coiffure',
                'description' => 'Services de coiffure et de soin capillaire'
            ],
            [
                'name' => 'Massage',
                'slug' => 'massage',
                'description' => 'Services de massage et de relaxation'
            ],
            [
                'name' => 'Domicile',
                'slug' => 'domicile',
                'description' => 'Services à domicile'
            ],
            [
                'name' => 'Sport',
                'slug' => 'sport',
                'description' => 'Services sportifs et activités physiques'
            ],
            [
                'name' => 'Éducation',
                'slug' => 'education',
                'description' => 'Services éducatifs et de formation'
            ],
            [
                'name' => 'Technique',
                'slug' => 'technique',
                'description' => 'Services techniques et réparation'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 