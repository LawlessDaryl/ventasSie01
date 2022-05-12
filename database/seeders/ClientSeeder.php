<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cliente::create([
            'nombre'=> 'Cliente Anónimo',
            'cedula' => '',
            'celular' => '',
            'razon_social' => 'Cliente Anónimo',
            'nit' => '0',
            'procedencia_cliente_id' => 1
        ]);
        Cliente::create([
            'nombre'=> 'Juan Gabriel Gonzales Colque',
            'cedula' => '8693545',
            'celular' => '71787966',
            'razon_social' => 'Juan Gabriel',
            'nit' => 118575,
            'procedencia_cliente_id' => 1
        ]);
        Cliente::create([
            'nombre'=> 'Manuel Meneses Lupa',
            'cedula' => '874516',
            'celular' => '7845188',
            'razon_social' => 'Manuel',
            'nit' => 116575,
            'procedencia_cliente_id' => 1
        ]);
        Cliente::create([
            'nombre'=> 'Gonzalo Quiroga Antezana',
            'cedula' => '8693545',
            'celular' => '7564945',
            'razon_social' => 'Gonzalo',
            'nit' => 1118745,
            'procedencia_cliente_id' => 1
        ]);
        Cliente::create([
            'nombre'=> 'Sofia Espinoza Alegre',
            'cedula' => '8796265',
            'celular' => '7124587',
            'razon_social' => 'Sofia',
            'nit' => 112458,
            'procedencia_cliente_id' => 1
        ]);
        Cliente::create([
            'nombre'=> 'Mirta Condori Alvarez',
            'cedula' => '854126',
            'celular' => '7412589',
            'razon_social' => 'Mirta',
            'nit' => 114812,
            'procedencia_cliente_id' => 1
        ]);
        Cliente::create([
            'nombre'=> 'Miguel Villca Vereda',
            'cedula' => '4784123',
            'celular' => '6548752',
            'razon_social' => 'Miguel',
            'nit' => 112854,
            'procedencia_cliente_id' => 1
        ]);
        Cliente::create([
            'nombre'=> 'Raul Villanueva Mejia',
            'cedula' => '484658',
            'celular' => '6315565',
            'razon_social' => 'Raul',
            'nit' => 1118746,
            'procedencia_cliente_id' => 1
        ]);
    }
}
