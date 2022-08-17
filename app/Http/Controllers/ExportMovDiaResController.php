<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Caja;
use App\Models\Cartera;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Company;
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
        $ingresosTotalesCF = session('ingresosTotalesCF');//
        $subtotalesIngresos = session('subtotalesIngresos');//
        $op_recaudo = session('op_recaudo');//
        $ingresosTotalesNoCFBancos = session('ingresosTotalesNoCFBancos');
        $total = session('total');
        $subtotalcaja = session('subtotalcaja');
        $operacionesefectivas = session('operacionesefectivas');
        $ops = session('ops');
        $operacionesW = session('operacionesW');
        $EgresosTotales = session('EgresosTotales');
        $totalutilidadSV = session('totalutilidadSV');
        $EgresosTotalesCF = session('EgresosTotalesCF');

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


        $nombreempresa = Company::find(1)->name;
        $logoempresa = Company::find(1)->image;

        $pdf = PDF::loadView('livewire.pdf.reportemovdiaresumen',
        compact('totalesIngresosV','totalesIngresosS','totalesIngresosIE','totalesEgresosV','totalesEgresosIE',
                'ingresosTotalesCF',
                'ingresosTotalesNoCFBancos',
                'subtotalesIngresos',
                'EgresosTotales',
                'EgresosTotalesCF',
                'totalutilidadSV',
                'op_recaudo',
                'total',
                'subtotalcaja',
                'operacionesefectivas',
                'ops',
                'operacionesW',
                'sucursal',
                'caja',
                'fromDate',
                'toDate',
                'nombreempresa',
                'logoempresa',
            
            ));



        return $pdf->stream('Reporte_Movimiento_Diario_Resumen.pdf'); 
    }
}
