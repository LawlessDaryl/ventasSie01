<?php

namespace Database\Seeders;

use App\Models\Comision;
use Illuminate\Database\Seeder;

class ComisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comision::create([
            'nombre' => 'de 10 a 100 bs',
            'tipo' => 'Cliente',
            'monto_inicial' => '10',
            'monto_final' => '100',
            'comision' => '4',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'de 101 a 200 bs',
            'tipo' => 'Cliente',
            'monto_inicial' => '101',
            'monto_final' => '200',
            'comision' => '7',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'de 201 a 250 bs',
            'tipo' => 'Cliente',
            'monto_inicial' => '201',
            'monto_final' => '250',
            'comision' => '10',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'de 251 a 400 bs',
            'tipo' => 'Cliente',
            'monto_inicial' => '251',
            'monto_final' => '400',
            'comision' => '13',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'de 401 a 600 bs',
            'tipo' => 'Cliente',
            'monto_inicial' => '401',
            'monto_final' => '600',
            'comision' => '20',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'de 601 a 800 bs',
            'tipo' => 'Cliente',
            'monto_inicial' => '601',
            'monto_final' => '800',
            'comision' => '30',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'de 801 a 1000 bs',
            'tipo' => 'Cliente',
            'monto_inicial' => '801',
            'monto_final' => '1000',
            'comision' => '35',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'de 1001 a 1200 bs',
            'tipo' => 'Cliente',
            'monto_inicial' => '1001',
            'monto_final' => '1200',
            'comision' => '40',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'de 1201 a 1400 bs',
            'tipo' => 'Cliente',
            'monto_inicial' => '1201',
            'monto_final' => '1400',
            'comision' => '45',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'de 1401 a 1600 bs',
            'tipo' => 'Cliente',
            'monto_inicial' => '1401',
            'monto_final' => '1600',
            'comision' => '50',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'de 1601 a 1800 bs',
            'tipo' => 'Cliente',
            'monto_inicial' => '1601',
            'monto_final' => '1800',
            'comision' => '55',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'de 1801 a 2000 bs',
            'tipo' => 'Cliente',
            'monto_inicial' => '1801',
            'monto_final' => '2000',
            'comision' => '60',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'de 2001 a 4512 bs',
            'tipo' => 'Cliente',
            'monto_inicial' => '2001',
            'monto_final' => '4512',
            'comision' => '3',
            'porcentaje' => 'Activo'
        ]);
        Comision::create([
            'nombre' => 'Comision 6% de Abono CI',
            'tipo' => 'Cliente',
            'monto_inicial' => '10',
            'monto_final' => '5000',
            'comision' => '6',
            'porcentaje' => 'Activo'
        ]);
        Comision::create([
            'nombre' => 'Comision ganancia 6% de Abono CI',
            'tipo' => 'Propia',
            'monto_inicial' => '10',
            'monto_final' => '5000',
            'comision' => '6',
            'porcentaje' => 'Activo'
        ]);
        Comision::create([
            'nombre' => 'Comision ganancia 8% de Recarga',
            'tipo' => 'Propia',
            'monto_inicial' => '1',
            'monto_final' => '5000',
            'comision' => '8',
            'porcentaje' => 'Activo'
        ]);
        Comision::create([
            'nombre' => 'Ganancia de 10 a 100 bs',
            'tipo' => 'Propia',
            'monto_inicial' => '10',
            'monto_final' => '100',
            'comision' => '4',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'Ganancia de 101 a 200 bs',
            'tipo' => 'Propia',
            'monto_inicial' => '101',
            'monto_final' => '200',
            'comision' => '7',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'Ganancia de 201 a 250 bs',
            'tipo' => 'Propia',
            'monto_inicial' => '201',
            'monto_final' => '250',
            'comision' => '10',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'Ganancia de 251 a 400 bs',
            'tipo' => 'Propia',
            'monto_inicial' => '251',
            'monto_final' => '400',
            'comision' => '13',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'Ganancia de 401 a 600 bs',
            'tipo' => 'Propia',
            'monto_inicial' => '401',
            'monto_final' => '600',
            'comision' => '20',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'Ganancia de 601 a 800 bs',
            'tipo' => 'Propia',
            'monto_inicial' => '601',
            'monto_final' => '800',
            'comision' => '30',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'Ganancia de 801 a 1000 bs',
            'tipo' => 'Propia',
            'monto_inicial' => '801',
            'monto_final' => '1000',
            'comision' => '35',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'Ganancia de 1001 a 1200 bs',
            'tipo' => 'Propia',
            'monto_inicial' => '1001',
            'monto_final' => '1200',
            'comision' => '40',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'Ganancia de 1201 a 1400 bs',
            'tipo' => 'Propia',
            'monto_inicial' => '1201',
            'monto_final' => '1400',
            'comision' => '45',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'Ganancia de 1401 a 1600 bs',
            'tipo' => 'Propia',
            'monto_inicial' => '1401',
            'monto_final' => '1600',
            'comision' => '50',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'Ganancia de 1601 a 1800 bs',
            'tipo' => 'Propia',
            'monto_inicial' => '1601',
            'monto_final' => '1800',
            'comision' => '55',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'Ganancia de 1801 a 2000 bs',
            'tipo' => 'Propia',
            'monto_inicial' => '1801',
            'monto_final' => '2000',
            'comision' => '60',
            'porcentaje' => 'Desactivo'
        ]);
        Comision::create([
            'nombre' => 'Ganancia de 2001 a 4512 bs',
            'tipo' => 'Propia',
            'monto_inicial' => '2001',
            'monto_final' => '4512',
            'comision' => '3',
            'porcentaje' => 'Activo'
        ]);
    }
}
