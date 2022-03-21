<?php

namespace Database\Seeders;

use App\Models\Caja;
use Illuminate\Database\Seeder;

class CajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Caja::create([
            'nombre' => 'Caja Este',
            'estado' => 'Cerrado',
            'sucursal_id' => '1',
        ]);
        Caja::create([
            'nombre' => 'Caja Oeste',
            'estado' => 'Cerrado',
            'sucursal_id' => '1',
        ]);
        Caja::create([
            'nombre' => 'Caja Ferrufino',
            'estado' => 'Cerrado',
            'sucursal_id' => '2',
        ]);
    }
}
