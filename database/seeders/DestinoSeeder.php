<?php

namespace Database\Seeders;

use App\Models\Destino;
use Illuminate\Database\Seeder;

class DestinoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Destino::create([
            'nombre'=>'Almacen',
            'observacion'=>'ninguna',
            'sucursal_id'=>'1'           
        ]);
        Destino::create([
            'nombre'=>'Tienda',
            'observacion'=>'ninguna',
            'sucursal_id'=>'1'           
        ]);
        Destino::create([
            'nombre'=>'Deposito',
            'observacion'=>'ninguna',
            'sucursal_id'=>'1'
        ]);
        Destino::create([
            'nombre'=>'Tienda',
            'observacion'=>'ninguna',
            'sucursal_id'=>'2'           
        ]);
    }
}
