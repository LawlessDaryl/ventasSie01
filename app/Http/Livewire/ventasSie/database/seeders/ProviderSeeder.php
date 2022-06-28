<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\StrSupplier;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Provider::create([
            'nombre_prov'=>'Gustavo',
            'apellido'=>'Quisberth',
            'direccion'=>'Av.America nro.150',
            'telefono'=>'78444562',
            'compañia'=>'ASUSTEC',
            'correo'=>null,
            'status'=>'ACTIVO'
        ]);

        Provider::create([
            'nombre_prov'=>'Alejandro',
            'apellido'=>'Ramirez',
            'direccion'=>'C/Colombia nro.365',
            'telefono'=>'4741213',
            'compañia'=>'SAMSUNG',
            'correo'=>null,
            'status'=>'ACTIVO'
        ]);  
    }
}
