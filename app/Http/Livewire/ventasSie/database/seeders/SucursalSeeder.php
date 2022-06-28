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
            'name' => 'Central',
            'adress' => 'Av. America casi G.Rene Moreno',
            'telefono' => '4408080',
            'celular' => '6908080',
            'nit_id' => '765645',
            'company_id' => '1'
        ]);
        Sucursal::create([
            'name' => 'Sucursal Ferrufino',
            'adress' => 'Av. America y Andres Ferrufino',
            'telefono' => '470080',
            'celular' => '7108080',
            'nit_id' => '908877',
            'company_id' => '1'
        ]);
        Sucursal::create([
            'name' => 'Sucursal Perú',
            'adress' => 'Av. Perú casi Plazuela Vicuna',
            'telefono' => '470080',
            'celular' => '7108080',
            'nit_id' => '908877',
            'company_id' => '1'
        ]);
    }
}
