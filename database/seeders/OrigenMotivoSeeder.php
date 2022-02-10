<?php

namespace Database\Seeders;

use App\Models\OrigenMotivo;
use Illuminate\Database\Seeder;

class OrigenMotivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrigenMotivo::create([
            'comision_si_no' => 'si',
            'afectadoSi' => 'ambos',
            'afectadoNo' => 'ambos',
            'suma_resta_si' => 'suma',
            'suma_resta_no' => 'mantiene',
            'origen_id' => '2',
            'motivo_id' => '1',
        ]);
        OrigenMotivo::create([
            'comision_si_no' => 'si',
            'afectadoSi' => 'ambos',
            'afectadoNo' => 'ambos',
            'suma_resta_si' => 'mantiene',
            'suma_resta_no' => 'resta',
            'origen_id' => '2',
            'motivo_id' => '4',
        ]);
        OrigenMotivo::create([
            'comision_si_no' => 'nopreguntar',
            'afectadoSi' => 'ambos',
            'afectadoNo' => 'ambos',
            'suma_resta_si' => 'mantiene',
            'suma_resta_no' => 'mantiene',
            'origen_id' => '2',
            'motivo_id' => '5',
        ]);
        OrigenMotivo::create([
            'comision_si_no' => 'si',
            'afectadoSi' => 'ambos',
            'afectadoNo' => 'ambos',
            'suma_resta_si' => 'suma',
            'suma_resta_no' => 'mantiene',
            'origen_id' => '1',
            'motivo_id' => '1',
        ]);
        OrigenMotivo::create([
            'comision_si_no' => 'nopreguntar',
            'afectadoSi' => 'montoC',
            'afectadoNo' => 'montoC',
            'suma_resta_si' => 'suma',
            'suma_resta_no' => 'suma',
            'origen_id' => '1',
            'motivo_id' => '2',
        ]);
        OrigenMotivo::create([
            'comision_si_no' => 'si',
            'afectadoSi' => 'montoR',
            'afectadoNo' => 'montoC',
            'suma_resta_si' => 'suma',
            'suma_resta_no' => 'resta',
            'origen_id' => '1',
            'motivo_id' => '4',
        ]);
        OrigenMotivo::create([
            'comision_si_no' => 'nopreguntar',
            'afectadoSi' => 'ambos',
            'afectadoNo' => 'ambos',
            'suma_resta_si' => 'mantiene',
            'suma_resta_no' => 'mantiene',
            'origen_id' => '1',
            'motivo_id' => '3',
        ]);
    }
}
