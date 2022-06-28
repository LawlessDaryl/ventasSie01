<?php

namespace Database\Seeders;

use App\Models\ProcedenciaCliente;
use Illuminate\Database\Seeder;

class ProcedenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProcedenciaCliente::create([
            'procedencia' => 'Nuevo',
            'estado' => 'Activo'
        ]);
    }
}
