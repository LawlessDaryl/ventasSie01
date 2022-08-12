<?php

namespace Database\Seeders;

use App\Models\Cartera;
use Illuminate\Database\Seeder;

class CarteraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* CAJA GENERAL */
        Cartera::create([
            'nombre' => 'BANCO',
            'descripcion' => 'CUENTA BANCARIA',
            'tipo' => 'Banco',
            'telefonoNum' => null,
            'caja_id' => '1',
        ]);

        /* CAJA SECUNDARIA */
        Cartera::create([
            'nombre' => 'Caja fisica',
            'descripcion' => 'Caja fisica de caja Principal',
            'tipo' => 'CajaFisica',
            'telefonoNum' => null,
            'caja_id' => '1',
        ]);
     
   
    }
}
