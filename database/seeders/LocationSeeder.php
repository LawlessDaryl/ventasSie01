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
            
            'codigo' => '0001',
            'descripcion' => 'Almacen de todos los Productos',
            'tipo' => 'ESTANTE',
            'destino_id' => '1'
        ]);
        Location::create([
            
            'codigo' => '0002',
            'descripcion' => 'Tv Box, Cables, Dispositivos de Almacenamiento',
            
            'tipo' => 'VITRINA',
            'destino_id' => '1'
        ]);
        Location::create([
            
            'codigo' => '0003',
            'descripcion' => 'Vidrios Templados y Fundas',
            
            'tipo' => 'Mostrador',
            'destino_id' => '1'
        ]);
        Location::create([
         
            'codigo' => '0004',
            'descripcion' => 'Repuestos varios',
          
            'tipo' => 'ESTANTE',
            'destino_id' => '2'
        ]);
    }
}
