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
        ModelHasRoles::create([     /* EMANUEL - ROL ADMIN */
            'role_id' => 1, 
            'model_type' => 'App\Models\User',
            'model_id' => 1,
        ]);
        ModelHasRoles::create([     /* GUSTAVO - ROL EMPLEADO */
            'role_id' => 2,
            'model_type' => 'App\Models\User',
            'model_id' => 2,
        ]);
        ModelHasRoles::create([     /* ARMANDO - ROL EMPLEADO */
            'role_id' => 6,
            'model_type' => 'App\Models\User',
            'model_id' => 3,
        ]);
        ModelHasRoles::create([     /* SAMUEL - ROL EMPLEADO */
            'role_id' => 2,
            'model_type' => 'App\Models\User',
            'model_id' => 4,
        ]);
        ModelHasRoles::create([     /* LUIS - ROL EMPLEADO */
            'role_id' => 5,
            'model_type' => 'App\Models\User',
            'model_id' => 5,
        ]);
        ModelHasRoles::create([     /* PEDRO - ROL TECNICO */
            'role_id' => 3,
            'model_type' => 'App\Models\User',
            'model_id' => 6,
        ]);
        ModelHasRoles::create([     /* ANDRES - ROL SUPERVISOR */
            'role_id' => 4,
            'model_type' => 'App\Models\User',
            'model_id' => 7,
        ]);
        ModelHasRoles::create([     /* SERGIO - ROL CAJERO */
            'role_id' => 5,
            'model_type' => 'App\Models\User',
            'model_id' => 8,
        ]);
        ModelHasRoles::create([     /* CAJA1 - ROL CAJERO */
            'role_id' => 5,
            'model_type' => 'App\Models\User',
            'model_id' => 9,
        ]);
    }
}