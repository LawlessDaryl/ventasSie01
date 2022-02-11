<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sucursal::create([
            'name' => 'sucursal america',
            'adress' => 'America 542',
            'telefono' => '4545562',
            'celular' => '78787533',
            'nit_id' => '95656555',
            'company_id' => '1',
          
        ]);
    }
}
