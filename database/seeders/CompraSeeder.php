<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Compra;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
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
            'fecha_compra' => 'Av. America casi G.Rene Moreno',
            'impuestos' => '2',
            'pago' => 'pagado',
            'saldo_por_pagar' => 'pagado',
            'tipo_doc' => 'FACTURA',
            'nro_doc' => '12012',
            'observacion' => 'ninguna',
            'proveedor_id' => '1'
        ]);
    }
}
