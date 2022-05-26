<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Sucursal;
use Illuminate\Support\Facades\Auth;

class ExportSaleMovDiaController extends Controller
{
    public function reportPDFMovDiaVenta($num1, $num2)
    {
        $value = session('asd');
        //dd($value);

        $num2=$this->verificarpermiso();

        $pdf = PDF::loadView('livewire.pdf.reportemovdiaventas', compact('value','num2'));
        return $pdf->stream('Reporte_Movimiento_Diario.pdf'); 
    }
    //Buscar la utilidad de una venta mediante el idventa
    public function buscarutilidad($idventa)
    {
        $utilidadventa = Sale::join('sale_details as sd', 'sd.sale_id', 'sales.id')
        ->join('products as p', 'p.id', 'sd.product_id')
        ->select('sd.quantity as cantidad','sd.price as precio','p.costo as costoproducto')
        ->where('sales.id', $idventa)
        ->get();

        $utilidad = 0;

        foreach ($utilidadventa as $item)
        {
            $utilidad = $utilidad + ($item->cantidad * $item->precio) - ($item->cantidad * $item->costoproducto);
        }

        return $utilidad;
    }
    //Buscar Ventas por Id Movimiento
    public function buscarventa($idmovimiento)
    {
        $venta = Sale::join('movimientos as m', 'm.id', 'sales.movimiento_id')
                ->select('sales.id as idventa')
                ->where('sales.movimiento_id',$idmovimiento)
                ->get();
        return $venta;
    }
     //Metodo para Verificar si el usuario tiene el Permiso para filtrar por Sucursal y ver por utilidad
     public function verificarpermiso()
     {
         if(Auth::user()->hasPermissionTo('VentasMovDiaSucursalUtilidad'))
         {
             return true;
         }
         return false;
     }
}
