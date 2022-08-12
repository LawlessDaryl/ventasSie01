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
            'name' => 'Principal',
            'adress' => 'Av.XXXXXX',
            'telefono' => '44444444',
            'celular' => '77777777',
            'nit_id' => '0',
            'company_id' => '1'
        ]);
   
    }
}
