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
        for ($x = 1; $x < 38; $x++) {
            RoleHasPermissions::create([
                'permission_id' => $x,
                'role_id' => 1,
            ]);
        }
        RoleHasPermissions::create([
            'permission_id' => 12,
            'role_id' => 2,
        ]);
        RoleHasPermissions::create([
            'permission_id' => 23,
            'role_id' => 2,
        ]);
        RoleHasPermissions::create([
            'permission_id' => 26,
            'role_id' => 2,
        ]);
        RoleHasPermissions::create([
            'permission_id' => 30,
            'role_id' => 2,
        ]);
        RoleHasPermissions::create([
            'permission_id' => 31,
            'role_id' => 2,
        ]);
        RoleHasPermissions::create([
            'permission_id' => 33,
            'role_id' => 2,
        ]);
        RoleHasPermissions::create([
            'permission_id' => 34,
            'role_id' => 2,
        ]);
    }
}
