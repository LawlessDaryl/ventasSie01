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
            'destino_id' => '1',
            'codigo' => '0001',
            'descripcion' => 'Almacen de todos los Productos',
            
            'tipo' => 'ESTANTE'
        ]);
        Location::create([
            'destino_id' => '1',
            'codigo' => '0002',
            'descripcion' => 'Tv Box, Cables, Dispositivos de Almacenamiento',
          
            'tipo' => 'VITRINA'
        ]);
        Location::create([
            'destino_id' => '1',
            'codigo' => '0003',
            'descripcion' => 'Vidrios Templados y Fundas',
          
            'tipo' => 'Mostrador'
        ]);
        Location::create([
            'destino_id' => '2',
            'codigo' => '0004',
            'descripcion' => 'Repuestos varios',
         
            'tipo' => 'ESTANTE'
        ]);
    }
}
