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
        Cartera::create([
            'nombre' => 'Sistema',
            'descripcion' => 'Sistema tigo Money',
            'tipo' => 'Sistema',
            'telefonoNum' => 75006327,
            'caja_id' => '1',
        ]);
        Cartera::create([
            'nombre' => 'Caja fisica',
            'descripcion' => 'Caja fisica de caja Este',
            'tipo' => 'CajaFisica',
            'telefonoNum' => null,
            'caja_id' => '1',
        ]);
        Cartera::create([
            'nombre' => 'Telefono 61879011',
            'descripcion' => 'Telefono tigo money',
            'tipo' => 'Telefono',
            'telefonoNum' => '61879011',
            'caja_id' => '1',
        ]);
        Cartera::create([
            'nombre' => 'Caja fisica',
            'descripcion' => 'Caja fisica de caja Oeste',
            'tipo' => 'CajaFisica',
            'telefonoNum' => null,
            'caja_id' => '2',
        ]);
        Cartera::create([
            'nombre' => 'Telefono 62229011',
            'descripcion' => 'Telefono tigo money',
            'tipo' => 'Telefono',
            'telefonoNum' => '62229011',
            'caja_id' => '2',
        ]);
        Cartera::create([
            'nombre' => 'Sistema',
            'descripcion' => 'Sistema tigo Money',
            'tipo' => 'Sistema',
            'telefonoNum' => null,
            'caja_id' => '2',
        ]);        
        Cartera::create([
            'nombre' => 'BANCO',
            'descripcion' => 'CUENTA BANCARIA',
            'tipo' => 'Banco',
            'telefonoNum' => null,
            'caja_id' => '1',
        ]);
        Cartera::create([
            'nombre' => 'CUENTA TIGO MONEY',
            'descripcion' => 'TIGO MONEY STREAMING',
            'tipo' => 'TigoStreaming',
            'telefonoNum' => null,
            'caja_id' => '1',
        ]);
        Cartera::create([
            'nombre' => 'Caja fisica',
            'descripcion' => 'Caja fisica de caja Oeste',
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
        Cartera::create([
            'nombre' => 'BANCO',
            'descripcion' => 'CUENTA BANCARIA',
            'tipo' => 'Banco',
            'telefonoNum' => null,
            'caja_id' => '3',
        ]);
        Cartera::create([
            'nombre' => 'CUENTA TIGO MONEY',
            'descripcion' => 'TIGO MONEY STREAMING',
            'tipo' => 'TigoStreaming',
            'telefonoNum' => null,
            'caja_id' => '3',
        ]);
    }
}
