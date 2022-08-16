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
            'name' => 'Nombre Sucursal',
            'adress' => 'Av. XXX',
            'telefono' => '0000000',
            'celular' => '0000000',
            'nit_id' => '111111',
            'company_id' => '1'
        ]);
        // Sucursal::create([
        //     'name' => 'Sucursal Ferrufino',
        //     'adress' => 'Av. America y Andres Ferrufino',
        //     'telefono' => '470080',
        //     'celular' => '7108080',
        //     'nit_id' => '908877',
        //     'company_id' => '1'
        // ]);
        // Sucursal::create([
        //     'name' => 'Sucursal Perú',
        //     'adress' => 'Av. Perú casi Plazuela Vicuna',
        //     'telefono' => '470080',
        //     'celular' => '7108080',
        //     'nit_id' => '908877',
        //     'company_id' => '1'
        // ]);
    }
}
