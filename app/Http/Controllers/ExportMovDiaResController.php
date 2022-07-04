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
        $totalesIngresosV = session('totalIngresosV');
       
        //dd($totalesIngresosV);

        $pdf = PDF::loadView('livewire.pdf.reportemovdiaresumen', compact('totalesIngresosV'));
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
