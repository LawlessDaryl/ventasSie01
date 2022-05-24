<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Sucursal;

class ExportSaleMovDiaController extends Controller
{
    public function reportPDFMovDiaVenta($num1, $num2)
    {
        $value = session('asd');
        //dd($value);


        $pdf = PDF::loadView('livewire.pdf.reportemovdiaventas', compact('value','num2'));
        return $pdf->stream('Reporte_Movimiento_Diario.pdf'); 
    }
}
