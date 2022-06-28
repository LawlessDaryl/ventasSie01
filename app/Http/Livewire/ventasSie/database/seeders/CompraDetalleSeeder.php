<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompraDetalle;
use Illuminate\Database\Seeder;

class CompraDetalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompraDetalle::create([
            'precio' => '45',
            'cantidad' => '20',
            'product_id' => '1',
            'compra_id' => '1',
            'destino_id' => '1'
        ]);
        CompraDetalle::create([
            'precio' => '100',
            'cantidad' => '35',
            'product_id' => '2',
            'compra_id' => '1',
            'destino_id' => '1'
        ]);
        CompraDetalle::create([
            'precio' => '150',
            'cantidad' => '120',
            'product_id' => '3',
            'compra_id' => '1',
            'destino_id' => '1'
        ]);
        CompraDetalle::create([
            'precio' => '80',
            'cantidad' => '85',
            'product_id' => '4',
            'compra_id' => '1',
            'destino_id' => '1'
        ]);
    }
}
