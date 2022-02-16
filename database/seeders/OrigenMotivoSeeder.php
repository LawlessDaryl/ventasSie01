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
        OrigenMotivo::create([      /* Sistema Abono */
            'comision_si_no' => 'si',
            'afectadoSi' => 'ambos',
            'afectadoNo' => 'ambos',
            'suma_resta_si' => 'suma',
            'suma_resta_no' => 'mantiene',
            'CIdeCliente' => 'SI',
            'telefSolicitante' => 'SI',
            'telefDestino_codigo' => 'SI',
            'origen_id' => '2',
            'motivo_id' => '1',
        ]);
        OrigenMotivo::create([      /* Sistema Retiro */
            'comision_si_no' => 'si',
            'afectadoSi' => 'ambos',
            'afectadoNo' => 'ambos',
            'suma_resta_si' => 'mantiene',
            'suma_resta_no' => 'resta',
            'CIdeCliente' => 'SI',
            'telefSolicitante' => 'SI',
            'telefDestino_codigo' => 'NO',
            'origen_id' => '2',
            'motivo_id' => '4',
        ]);
        OrigenMotivo::create([      /* Sistema Retiro por CI */
            'comision_si_no' => 'nopreguntar',
            'afectadoSi' => 'ambos',
            'afectadoNo' => 'ambos',
            'suma_resta_si' => 'mantiene',
            'suma_resta_no' => 'mantiene',
            'CIdeCliente' => 'SI',
            'telefSolicitante' => 'SI',
            'telefDestino_codigo' => 'SI',
            'origen_id' => '2',
            'motivo_id' => '5',
        ]);
        OrigenMotivo::create([      /* Telefono Abono */
            'comision_si_no' => 'si',
            'afectadoSi' => 'ambos',
            'afectadoNo' => 'ambos',
            'suma_resta_si' => 'suma',
            'suma_resta_no' => 'mantiene',            
            'CIdeCliente' => 'NO',
            'telefSolicitante' => 'NO',
            'telefDestino_codigo' => 'SI',
            'origen_id' => '1',
            'motivo_id' => '1',
        ]);
        OrigenMotivo::create([      /* Telefono Abono por CI */
            'comision_si_no' => 'nopreguntar',
            'afectadoSi' => 'montoC',
            'afectadoNo' => 'montoC',
            'suma_resta_si' => 'suma',
            'suma_resta_no' => 'suma',            
            'CIdeCliente' => 'SI',
            'telefSolicitante' => 'SI',
            'telefDestino_codigo' => 'SI',
            'origen_id' => '1',
            'motivo_id' => '2',
        ]);
        OrigenMotivo::create([      /* Telefono Retiro */
            'comision_si_no' => 'si',
            'afectadoSi' => 'montoR',
            'afectadoNo' => 'montoC',
            'suma_resta_si' => 'suma',
            'suma_resta_no' => 'resta',            
            'CIdeCliente' => 'SI',
            'telefSolicitante' => 'SI',
            'telefDestino_codigo' => 'NO',
            'origen_id' => '1',
            'motivo_id' => '4',
        ]);
        OrigenMotivo::create([      /* Telefono Recarga */
            'comision_si_no' => 'nopreguntar',
            'afectadoSi' => 'ambos',
            'afectadoNo' => 'ambos',
            'suma_resta_si' => 'mantiene',
            'suma_resta_no' => 'mantiene',            
            'CIdeCliente' => 'NO',
            'telefSolicitante' => 'SI',
            'telefDestino_codigo' => 'NO',
            'origen_id' => '1',
            'motivo_id' => '3',
        ]);
    }
}
