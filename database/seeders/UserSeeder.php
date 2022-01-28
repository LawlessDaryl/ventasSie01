<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Emanuel',
            'phone' => '6187236',
            'email' => 'emanuel@gmail.com',
            'profile' => 'ADMIN',
            'status' => 'ACTIVE',
            'password' => bcrypt('123')
        ]);
        User::create([
            'name' => 'Ramiro',
            'phone' => '7187235',
            'email' => 'ramiro123@gmail.com',
            'profile' => 'Empleado',
            'status' => 'ACTIVE',
            'password' => bcrypt('123')
        ]);
    }
}
