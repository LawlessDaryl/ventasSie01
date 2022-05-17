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
        for ($x = 1; $x < 41; $x++) {
            RoleHasPermissions::create([
                'permission_id' => $x,
                'role_id' => 1
            ]);
        }
            RoleHasPermissions::create([
                'permission_id'=>37,
                'role_id' =>5
            ]);
    }
}
