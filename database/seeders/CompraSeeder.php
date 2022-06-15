<?php

namespace Database\Seeders;

use App\Models\Compra;
use Illuminate\Database\Seeder;

class CompraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Compra::create([
            'importe_total' => '850',
            'descuento'=>'120',
            'fecha_compra' => '2022-02-10',
            'impuestos' => '2',
            'transaccion' => 'contado',
            'saldo_por_pagar' => '0',
            'tipo_doc' => 'FACTURA',
            'nro_documento' => '12012',
            'observacion' => 'ninguna',
            'proveedor_id' => '1',
            'estado_compra'=>'finalizada',
            'status'=>'ACTIVO'
        ]);
    }
}
