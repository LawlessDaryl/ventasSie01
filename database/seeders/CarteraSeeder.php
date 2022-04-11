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
            'nombre' => 'BANCO STREAMING',
            'descripcion' => 'CUENTA BANCARIA STREAMING',
            'tipo' => 'Banco',
            'telefonoNum' => null,
            'caja_id' => '1',
        ]);
        Cartera::create([
            'nombre' => 'TIGO MY STRM D.ROSA',
            'descripcion' => 'TIGO MONEY STREAMING',
            'tipo' => 'TigoStreaming',
            'telefonoNum' => '72794633',
            'caja_id' => '1',
        ]);

        /* CAJA PRINCIPAL */
        Cartera::create([
            'nombre' => 'Sistema 75006327',
            'descripcion' => 'Sistema tigo Money',
            'tipo' => 'Sistema',
            'telefonoNum' => 75006327,
            'caja_id' => '2',
        ]);
        Cartera::create([
            'nombre' => 'Caja fisica',
            'descripcion' => 'Caja fisica de caja Principal',
            'tipo' => 'CajaFisica',
            'telefonoNum' => null,
            'caja_id' => '2',
        ]);
        Cartera::create([
            'nombre' => 'Telefono 75997054',
            'descripcion' => 'Telefono tigo money',
            'tipo' => 'Telefono',
            'telefonoNum' => 75997054,
            'caja_id' => '2',
        ]);

        /* CAJA SECUNDARIA */
        Cartera::create([
            'nombre' => 'Caja fisica',
            'descripcion' => 'Caja fisica de caja Secundaria',
            'tipo' => 'CajaFisica',
            'telefonoNum' => null,
            'caja_id' => '3',
        ]);
        Cartera::create([
            'nombre' => 'Telefono 62229011',
            'descripcion' => 'Telefono tigo money',
            'tipo' => 'Telefono',
            'telefonoNum' => '62229011',
            'caja_id' => '3',
        ]);
        Cartera::create([
            'nombre' => 'Sistema',
            'descripcion' => 'Sistema tigo Money',
            'tipo' => 'Sistema',
            'telefonoNum' => null,
            'caja_id' => '3',
        ]);

        /* CAJA FERRUFINO */
        Cartera::create([
            'nombre' => 'Caja fisica',
            'descripcion' => 'Caja fisica de caja Ferrufino',
            'tipo' => 'CajaFisica',
            'telefonoNum' => null,
            'caja_id' => '4',
        ]);
        Cartera::create([
            'nombre' => 'Telefono 76444657',
            'descripcion' => 'Telefono tigo money',
            'tipo' => 'Telefono',
            'telefonoNum' => '76444657',
            'caja_id' => '4',
        ]);
        Cartera::create([
            'nombre' => 'Sistema',
            'descripcion' => 'Sistema tigo Money',
            'tipo' => 'Sistema',
            'telefonoNum' => null,
            'caja_id' => '4',
        ]);
    }
}
