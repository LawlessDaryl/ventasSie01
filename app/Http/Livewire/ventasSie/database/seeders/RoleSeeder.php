<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([  //1
            'name' => 'ADMIN',
            'guard_name' => 'web'
        ]);
        Role::create([  //2
            'name' => 'EMPLOYEE',
            'guard_name' => 'web'
        ]);
        Role::create([  //3
            'name' => 'TECNICO',
            'guard_name' => 'web'
        ]);
        Role::create([  //4
            'name' => 'SUPERVISOR_TECNICO',
            'guard_name' => 'web'
        ]);
        Role::create([  //5
            'name' => 'CAJERO',
            'guard_name' => 'web'
        ]);
        Role::create([  //6
            'name' => 'CAJA_ADMIN',
            'guard_name' => 'web'
        ]);
        Role::create([  //7
            'name' => 'STREAMING_SUPERVISOR',
            'guard_name' => 'web'
        ]);
        Role::create([  //8
            'name' => 'STREAMING_TIGOMONEY_VENDEDOR',
            'guard_name' => 'web'
        ]);
    }
}
