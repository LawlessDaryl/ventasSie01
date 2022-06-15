<?php

namespace Database\Seeders;

use App\Http\Livewire\PermisosController;
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
        for ($x = 1; $x <= 64; $x++) {  /* TODOS LOS PERMISOS PARA EL ROL ADMIN */
            RoleHasPermissions::create([
                'permission_id' => $x,
                'role_id' => 1
            ]);
        }

        for ($x = 17; $x <= 22; $x++) {     /* PERMISOS TIGO MONEY */
            RoleHasPermissions::create([
                'permission_id' => $x,
                'role_id' => 5,
            ]);
        }

        RoleHasPermissions::create([    // PERMITIR VER JORNADA AL CAJERO
            'permission_id' => 56,
            'role_id' => 5,
        ]);

        for ($x = 23; $x <= 31; $x++) {     /* PERMISOS STREAMING */
            RoleHasPermissions::create([
                'permission_id' => $x,
                'role_id' => 5,
            ]);
        }

        for ($x = 35; $x <= 40; $x++) {     /* PERMISOS SERVICIOS */
            RoleHasPermissions::create([
                'permission_id' => $x,
                'role_id' => 2,
            ]);
        }
        for ($x = 32; $x <= 44; $x++) {     /* PERMISOS SERVICIOS ROL SUPERVISOR_TECNICO*/
            if ($x != 39 && $x != 40 && $x != 42) {
                RoleHasPermissions::create([
                    'permission_id' => $x,
                    'role_id' => 4,
                ]);
            }
        }
        RoleHasPermissions::create([    /* PERMISOS SERVICIOS ROL SUPERVISOR_TECNICO */
            'permission_id' => 61,
            'role_id' => 4,
        ]);
        for ($x = 35; $x <= 43; $x++) {     /* PERMISOS SERVICIOS ROL TECNICO*/
            if ($x != 39 && $x != 40 && $x != 41 && $x != 42 && $x != 43) {
                RoleHasPermissions::create([
                    'permission_id' => $x,
                    'role_id' => 3,
                ]);
            }
        }
        RoleHasPermissions::create([    /* PERMISOS SERVICIOS ROL TECNICO */
            'permission_id' => 61,
            'role_id' => 3,
        ]);
        for ($x = 35; $x <= 43; $x++) {     /* PERMISOS SERVICIOS ROL CAJERO*/
            if ($x != 39 && $x != 40 && $x != 41 && $x != 43) {
                RoleHasPermissions::create([
                    'permission_id' => $x,
                    'role_id' => 5,
                ]);
            }
        }
        for ($x = 9; $x <= 11; $x++) {     /* PERMISOS SERVICIOS ROL CAJERO*/
            RoleHasPermissions::create([
                'permission_id' => $x,
                'role_id' => 5,
            ]);
        }


        for ($x = 17; $x <= 22; $x++) {     /* PERMISOS TIGO MONEY */
            RoleHasPermissions::create([
                'permission_id' => $x,
                'role_id' => 6,
            ]);
        }
        /* PERMISOS CORTE CAJA */
        RoleHasPermissions::create([
            'permission_id' => 11,
            'role_id' => 6,
        ]);


        for ($x = 23; $x <= 31; $x++) {     /* PERMISOS STREAMING */
            RoleHasPermissions::create([
                'permission_id' => $x,
                'role_id' => 6,
            ]);
        }

        RoleHasPermissions::create([    // PERMITIR MODIFICAR CAJA Y SUCURSAL AL ADMIN
            'permission_id' => 57,
            'role_id' => 6,
        ]);
        RoleHasPermissions::create([    // VER GANANCIAS TIGO MONEY CAJERO
            'permission_id' => 58,
            'role_id' => 6,
        ]);
        RoleHasPermissions::create([    // VER GENERAR INGRESO EGRESO ADMIN
            'permission_id' => 59,
            'role_id' => 6,
        ]);
        RoleHasPermissions::create([    // VER BOTON ANULAR TRANSACCION TIGO MONEY ADMINISTRADOR
            'permission_id' => 60,
            'role_id' => 6,
        ]);
    }
}
