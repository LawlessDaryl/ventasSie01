<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cartera;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Sucursal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExportMovDiaResController extends Controller
{
    public function reportPDFMovDiaResumen()
    {
        //Variables para la tbody
        $totalesIngresosV = session('totalIngresosV');
        $totalesIngresosS = session('totalIngresosS');
        $totalesIngresosIE = session('totalIngresosIE');
        $totalesEgresosV = session('totalEgresosV');
        $totalesEgresosIE = session('totalEgresosIE');


        //Variables para la tfoot
        $ingresosTotales = session('ingresosTotales');
        $ingresosTotalesCF = session('ingresosTotalesCF');
        $ingresosTotalesNoCFNoBancos = session('ingresosTotalesNoCFNoBancos');
        $ingresosTotalesNoCFBancos = session('ingresosTotalesNoCFBancos');
        $total = session('total');
        $EgresosTotales = session('EgresosTotales');
        $EgresosTotalesCF = session('EgresosTotalesCF');
        $EgresosTotalesNoCFNoBancos = session('EgresosTotalesNoCFNoBancos');
        $EgresosTotalesNoCFBancos = session('EgresosTotalesNoCFBancos');
        $subtotalcaja = session('subtotalcaja');
        $operacionesefectivas = session('operacionesefectivas');
        $ops = session('ops');
        $operacionesW = session('operacionesW');

        $pdf = PDF::loadView('livewire.pdf.reportemovdiaresumen',
        compact('totalesIngresosV','totalesIngresosS','totalesIngresosIE','totalesEgresosV','totalesEgresosIE',
                'ingresosTotales',
                'ingresosTotalesCF',
                'ingresosTotalesNoCFNoBancos',
                'ingresosTotalesNoCFBancos',
                'total',
                'EgresosTotales',
                'EgresosTotalesCF',
                'EgresosTotalesNoCFNoBancos',
                'EgresosTotalesNoCFBancos',
                'subtotalcaja',
                'operacionesefectivas',
                'ops',
                'operacionesW'));



        return $pdf->stream('Reporte_Movimiento_Diario_Resumen.pdf'); 
        // $totalesIngresos = session('totalesIngresos');
        // $totalesEgresos = session('totalesEgresos');

        // $values = session('variablesmovidia');
       
        

        // $importetotalingresos = $values[0];
        // $operacionefectivoing = $values[1];
        // $noefectivoing = $values[2];
        // $importetotalegresos = $values[3];
        // $subtotalcaja = $values[4];
        // $utilidadtotal = $values[5];
        // $noefectivoing = $values[6];
        // $noefectivoeg = $values[7];

    }
}
