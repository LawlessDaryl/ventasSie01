<?php

namespace Database\Seeders;

use App\Models\ModelHasRoles;
use Illuminate\Database\Seeder;

class ModelHasRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelHasRoles::create([
            'role_id' => 1,
            'model_type' => 'App\Models\User',
            'model_id' => 1,
        ]);
        ModelHasRoles::create([
            'role_id' => 2,
            'model_type' => 'App\Models\User',
            'model_id' => 2,
        ]);
        ModelHasRoles::create([
            'role_id' => 2,
            'model_type' => 'App\Models\User',
            'model_id' => 3,
        ]);
        ModelHasRoles::create([
            'role_id' => 2,
            'model_type' => 'App\Models\User',
            'model_id' => 4,
        ]);
    }
}