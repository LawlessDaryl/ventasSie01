<?php

namespace Database\Seeders;

use App\Models\Motivo;
use Illuminate\Database\Seeder;

class MotivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Motivo::create([
            'nombre' => 'Abono',
            'tipo' => 'Abono'
        ]);
        Motivo::create([
            'nombre' => 'Abono por CI',
            'tipo' => 'Abono'
        ]);
        Motivo::create([
            'nombre' => 'Recarga',
            'tipo' => 'Abono'
        ]);
        Motivo::create([
            'nombre' => 'Retiro',
            'tipo' => 'Retiro'
        ]);
        Motivo::create([
            'nombre' => 'Retiro por CI',
            'tipo' => 'Retiro'
        ]);
    }
}
