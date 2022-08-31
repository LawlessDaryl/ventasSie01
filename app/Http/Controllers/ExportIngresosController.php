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

class ExportIngresosController extends Controller
{
    public function reportPDFIngresos()
    {
        //Variables para la tbody
        $Ingresos = session('Ingresos');
        
        


        //Variables para la tfoot
        $ingresossumatotal = session('ingresossumatotal');//
    
        $caracteristicas = session('caracteristicas');

        $sucursal = $caracteristicas[0];
        $caja = $caracteristicas[1];
        $fromDate = $caracteristicas[2];
        $toDate = $caracteristicas[3];

        
        
        // if($caja != 'TODAS')
        // {
        //     $caja = Caja::find($caja)->nombre;
        // }


        $nombreempresa = Company::find(1)->name;
        $logoempresa = Company::find(1)->image;

        $pdf = PDF::loadView('livewire.pdf.reporteingresos',
        compact('Ingresos','ingresossumatotal',
                'sucursal',
                'caja',
                'fromDate',
                'toDate',
                'nombreempresa',
                'logoempresa'
            
            ));



        return $pdf->stream('Reporte_Ingresos.pdf'); 
    }
}
