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
            'descripcion' => 'Almacen de todos los Productos',
            'ubicacion' => 'ALMACEN',
            'tipo' => 'ESTANTE'
        ]);
        Location::create([
            'sucursal_id' => '1',
            'codigo' => '41213',
            'descripcion' => 'Tv Box, Cables, Dispositivos de Almacenamiento',
            'ubicacion' => 'TIENDA',
            'tipo' => 'VITRINA'
        ]);
        Location::create([
            'sucursal_id' => '1',
            'codigo' => '41213',
            'descripcion' => 'Vidrios Templados y Fundas',
            'ubicacion' => 'TIENDA',
            'tipo' => 'Mostrador'
        ]);
    }
}
