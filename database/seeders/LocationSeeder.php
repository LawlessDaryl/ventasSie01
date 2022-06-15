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
        
        // Location::create([
        //     'sucursal_id' => '1',
        //     'codigo' => '41213',
        //     'descripcion' => 'Almacen de todos los Productos',
        //     'ubicacion' => 'ALMACEN',
        //     'tipo' => 'ESTANTE'
        // ]);
        // Location::create([
        //     'sucursal_id' => '1',
        //     'codigo' => '41213',
        //     'descripcion' => 'Tv Box, Cables, Dispositivos de Almacenamiento',
        //     'ubicacion' => 'TIENDA',
        //     'tipo' => 'VITRINA'
        // ]);
        // Location::create([
        //     'sucursal_id' => '1',
        //     'codigo' => '41213',
        //     'descripcion' => 'Vidrios Templados y Fundas',
        //     'ubicacion' => 'TIENDA',
        //     'tipo' => 'Mostrador',
            
           
        //     'descripcion' => 'Almacen de todos los Productos',
        //     'tipo' => 'ESTANTE',
        //     'destino_id' => '1'
        // ]);//

        //Almacén Sucursal 1
        Location::create([
            
            'codigo' => '0001',
            'descripcion' => 'Lugar de Almacenamiento de Productos Sucursal: Av. América',
            'tipo' => 'ESTANTE',
            'destino_id' => '1'
        ]);
        //Tienda Sucursal 1
        Location::create([
            'codigo' => '0002',
            'descripcion' => 'Lugar de Ventas Sucursal: Av. América',
            'tipo' => 'VITRINA',
            'destino_id' => '2'
        ]);
        //Almacen Devoluciones Sucursal 1
        Location::create([
            'codigo' => '0002',
            'descripcion' => 'Lugar de Devolución Ventas Sucursal: Av. América',
            'tipo' => 'VITRINA',
            'destino_id' => '3'
        ]);



        //Sucursal Tienda Sucursal 2
        Location::create([
            'codigo' => '0003',
            'descripcion' => 'Lugar de Ventas Sucursal: Av. Pando',
            'tipo' => 'ESTANTE',
            'destino_id' => '4'
        ]);
        //Almacen Devoluciones Sucursal 2
        Location::create([
            'codigo' => '0002',
            'descripcion' => 'Lugar de Devolución Ventas Sucursal: Av. Pando',
            'tipo' => 'VITRINA',
            'destino_id' => '5'
        ]);
    }
}
