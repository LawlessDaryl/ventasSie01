<?php

namespace Database\Seeders;

use App\Models\Permission;
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
        for ($x = 32; $x <= 43; $x++) {     /* PERMISOS SERVICIOS ROL SUPERVISOR*/
            if($x != 39 && $x != 40){
                RoleHasPermissions::create([
                    'permission_id' => $x,
                    'role_id' => 4,
                ]);
            }
        }
        for ($x = 35; $x <= 43; $x++) {     /* PERMISOS SERVICIOS ROL TECNICO*/
            if($x != 39 && $x != 40 && $x != 41 && $x != 42 && $x != 43){
                RoleHasPermissions::create([
                    'permission_id' => $x,
                    'role_id' => 3,
                ]);
            }
        }
        /* RoleHasPermissions::create([
            'permission_id' =>Permission::where('name','Inicio_Index')->get()->id
            ,
            'role_id' => 3,
        ]); */
       


    }
}
