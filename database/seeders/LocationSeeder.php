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
            'codigo' => '0001',
            'descripcion' => 'Almacen de todos los Productos',
            'ubicacion' => 'ALMACEN',
            'tipo' => 'ESTANTE'
        ]);
        Location::create([
            'sucursal_id' => '1',
            'codigo' => '0002',
            'descripcion' => 'Tv Box, Cables, Dispositivos de Almacenamiento',
            'ubicacion' => 'TIENDA',
            'tipo' => 'VITRINA'
        ]);
        Location::create([
            'sucursal_id' => '1',
            'codigo' => '0003',
            'descripcion' => 'Vidrios Templados y Fundas',
            'ubicacion' => 'TIENDA',
            'tipo' => 'Mostrador'
        ]);
        Location::create([
            'sucursal_id' => '2',
            'codigo' => '0004',
            'descripcion' => 'Repuestos varios',
            'ubicacion' => 'ALMACEN',
            'tipo' => 'ESTANTE'
        ]);
    }
}
