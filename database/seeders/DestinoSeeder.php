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

            'sucursal_id'=>'1',
            'nombre'=>'TIENDA',
            'observaciones'=>'ninguna'
        ]);
        Destino::create([

            'sucursal_id'=>'1',
            'nombre'=>'ALMACEN',
            'observaciones'=>'ninguna'
        ]);
        Destino::create([

            'sucursal_id'=>'1',
            'nombre'=>'DEPOSITO',
            'observaciones'=>'ninguna'
        ]);

        Destino::create([

            'sucursal_id'=>'2',
            'nombre'=>'TIENDA',
            'observaciones'=>'ninguna'
        ]);
    }
}

