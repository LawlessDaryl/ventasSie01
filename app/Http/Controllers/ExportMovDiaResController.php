<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Caja;
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

        $caracteristicas = session('caracteristicas');

        $sucursal = $caracteristicas[0];
        $caja = $caracteristicas[1];
        $fromDate = $caracteristicas[2];
        $toDate = $caracteristicas[3];

        
        if($sucursal != 'TODAS')
        {
            //$sucursal = Sucursal::find($sucursal)->name." - ".Sucursal::find($sucursal)->adress;
            $sucursal = Sucursal::find($sucursal)->name;
        }
        
        if($caja != 'TODAS')
        {
            $caja = Caja::find($caja)->nombre;
        }

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
                'operacionesW',
                'sucursal',
                'caja',
                'fromDate',
                'toDate',
            
            ));



        return $pdf->stream('Reporte_Movimiento_Diario_Resumen.pdf'); 
    }
}
