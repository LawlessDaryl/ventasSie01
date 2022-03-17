<?php

namespace Database\Seeders;

use App\Models\RoleHasPermissions;
use Illuminate\Database\Seeder;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($x = 1; $x <= 44; $x++) {
            RoleHasPermissions::create([
                'permission_id' => $x,
                'role_id' => 1,
            ]);
        }

        RoleHasPermissions::create([    /* PERMISO DE CORTE DE CAJA */
            'permission_id' => 11,
            'role_id' => 2,
        ]);
        for ($x = 17; $x <= 22; $x++) {     /* PERMISOS TIGO MONEY */
            RoleHasPermissions::create([
                'permission_id' => $x,
                'role_id' => 2,
            ]);
        }

        for ($x = 23; $x <= 31; $x++) {     /* PERMISOS STREAMING */
            RoleHasPermissions::create([
                'permission_id' => $x,
                'role_id' => 2,
            ]);
        }

        for ($x = 35; $x <= 40; $x++) {     /* PERMISOS SERVICIOS */
            RoleHasPermissions::create([
                'permission_id' => $x,
                'role_id' => 2,
            ]);
        }
        
        
    }
}
