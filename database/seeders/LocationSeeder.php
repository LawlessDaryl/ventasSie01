<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Location::create([
            'sucursal_id' => '1',
            'codigo' => '41213',
            'descripcion' => 'jam',
            'ubicacion' => 'ALMACEN',
            'tipo' => 'VITRINA'
          
        ]);
    }
}
