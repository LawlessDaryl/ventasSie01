<?php

namespace Database\Seeders;

use App\Models\Origen;
use Illuminate\Database\Seeder;

class OrigenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Origen::create([
            'nombre' => 'Telefono'
        ]);
        Origen::create([
            'nombre' => 'Sistema'
        ]);
    }
}
