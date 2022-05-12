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
<<<<<<< HEAD
        for ($x = 1; $x < 38; $x++) {
=======
        for ($x = 1; $x < 39; $x++) {
>>>>>>> origin/pruebaschio
            RoleHasPermissions::create([
                'permission_id' => $x,
                'role_id' => 1
            ]);
        }
<<<<<<< HEAD
            RoleHasPermissions::create([
                'permission_id'=>37,
                'role_id' =>5
            ]);
=======

        // //Ventas=> Dando Permisos a un Cajero de Ejemplo:Corte de Caja
        // RoleHasPermissions::create([
        //     'permission_id' => 12,
        //     'role_id' => 6,
        // ]);
        // //Ventas=> Dando Permisos a un Cajero de Ejemplo:Corte de Caja
        // RoleHasPermissions::create([
        //     'permission_id' => 12,
        //     'role_id' => 6,
        // ]);
>>>>>>> origin/pruebaschio
    }
}
