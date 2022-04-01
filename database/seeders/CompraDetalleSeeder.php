<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompraDetalle;
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
        CompraDetalle::create([
            'precio' => 'Soluciones informaticas Emanuel',
            'cantidad' => 'Av. America casi G.Rene Moreno',
            'product_id' => '4408080',
            'compra_id' => '76564512',
            'location_id' => '1'
        ]);
    }
}
