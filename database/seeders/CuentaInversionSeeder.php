<?php

namespace Database\Seeders;

use App\Models\CuentaInversion;
use Illuminate\Database\Seeder;

class CuentaInversionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CuentaInversion::create([   /* cuenta netflix dividida */
            'tipo' => 'EGRESO',
            'cantidad' => '90',
            'tipoTransac' => 'COMPRA',
            'num_meses' => '1',
            'fecha_realizacion' => '2022-03-22',
            'account_id' => '1'
        ]);
        CuentaInversion::create([   /* cuenta disney dividida */
            'tipo' => 'EGRESO',
            'cantidad' => '35',
            'tipoTransac' => 'COMPRA',
            'num_meses' => '1',
            'fecha_realizacion' => '2022-03-15',
            'account_id' => '2'
        ]);
        CuentaInversion::create([   /* cuenta prime video dividida */
            'tipo' => 'EGRESO',
            'cantidad' => '35',
            'tipoTransac' => 'COMPRA',
            'num_meses' => '1',
            'fecha_realizacion' => '2022-03-11',
            'account_id' => '3'
        ]);
        CuentaInversion::create([   /* cuenta star plus dividida */
            'tipo' => 'EGRESO',
            'cantidad' => '35',
            'tipoTransac' => 'COMPRA',
            'num_meses' => '1',
            'fecha_realizacion' => '2022-03-02',
            'account_id' => '4'
        ]);
        CuentaInversion::create([   /* cuenta HBO MAX dividida */
            'tipo' => 'EGRESO',
            'cantidad' => '35',
            'tipoTransac' => 'COMPRA',
            'num_meses' => '1',
            'fecha_realizacion' => '2022-03-01',
            'account_id' => '5'
        ]);
        CuentaInversion::create([   /* Cuenta magis tv */
            'tipo' => 'EGRESO',
            'cantidad' => '55',
            'tipoTransac' => 'COMPRA',
            'num_meses' => '1',
            'fecha_realizacion' => '2022-03-25',
            'account_id' => '6'
        ]);
        CuentaInversion::create([   /* CUENTA DE NETFLIX ENTERA */
            'tipo' => 'EGRESO',
            'cantidad' => '90',
            'tipoTransac' => 'COMPRA',
            'num_meses' => '1',
            'fecha_realizacion' => '2022-03-25',
            'account_id' => '7'
        ]);
        CuentaInversion::create([   /* CUENTA DE DISNEY ENTERA */
            'tipo' => 'EGRESO',
            'cantidad' => '35',
            'tipoTransac' => 'COMPRA',
            'num_meses' => '1',
            'fecha_realizacion' => '2022-03-25',
            'account_id' => '8'
        ]);
    }
}
