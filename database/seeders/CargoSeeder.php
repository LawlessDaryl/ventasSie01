<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cargo;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cargo::create([
            //1
            'name' => 'Gerente',
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //2
            'name' => 'Contador',
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //3
            'name' => 'Encargado de Ventas',
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //4
            'name' => 'Cajero Sucursal',
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //5
            'name' => 'Encargada de Plataformas',
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //6
            'name' => 'Cajero',
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);

        Cargo::create([
            //7
            'name' => 'Supervisor',
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //8
            'name' => 'Tecnico',
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //9
            'name' => 'Encargado de Area de Impresoras',
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //10
            'name' => 'Tecnico en Electronica',
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //11
            'name' => 'Desarrollador de Sistemas',
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //12
            'name' => 'Mensajeria',
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //13
            'name' => 'Programador',
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
        Cargo::create([
            //14
            'name' => 'No Definido',
            //'nrovacantes' => 'No definido',
            'estado' => 'Disponible',
        ]);
    }
}
