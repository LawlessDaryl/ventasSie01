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
            'descripcion' => 'ESTANTE DE MADERA',
            'ubicacion' => 'ALMACEN',
            'tipo' => 'ESTANTE'
          
        ]);
        Location::create([
            'sucursal_id' => '1',
            'codigo' => '41214',
            'descripcion' => 'VITRINA NUEVA METALICA',
            'ubicacion' => 'TIENDA',
            'tipo' => 'VITRINA'
          
        ]);
    }
}
