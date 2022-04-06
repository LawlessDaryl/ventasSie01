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
        Role::create([
            'name' => 'ADMIN',
            'guard_name' => 'web'
        ]);
        Role::create([
            'name' => 'EMPLOYEE',
            'guard_name' => 'web'
        ]);
        Role::create([
            'name' => 'TECNICO',
            'guard_name' => 'web'
        ]);
        Role::create([
            'name' => 'SUPERVISOR',
            'guard_name' => 'web'
        ]);
        Role::create([
            'name' => 'CAJERO',
            'guard_name' => 'web'
        ]);
        Role::create([
            'name' => 'STREAMING_ADMIN',
            'guard_name' => 'web'
        ]);
        Role::create([
            'name' => 'STREAMING_SUPERVISOR',
            'guard_name' => 'web'
        ]);
        Role::create([
            'name' => 'STREAMING_TIGOMONEY_VENDEDOR',
            'guard_name' => 'web'
        ]);
    }
}
