<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();

        Role::create([
            'id' => 1,
            'name' => 'Admin',
        ]);

        Role::create([
            'id' => 2,
            'name' => 'ServiceProvider',
        ]);

        Role::create([
            'id' => 3,
            'name' => 'Client',
        ]);
    }
}
