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

class ExportMovDiaGenController extends Controller
{
    public function reportPDFMovDiaGeneral()
    {
        //$value = session('tablareporte');
        //dd($value);

        //$permiso = $this->verificarpermiso();

        $totalesIngresos = session('totalesIngresos');
        $totalesEgresos = session('totalesEgresos');

        $values = session('variablesmovidia');
       
        

        $importetotalingresos = $values[0];
        $operacionefectivoing = $values[1];
        $noefectivoing = $values[2];
        $importetotalegresos = $values[3];
        $subtotalcaja = $values[4];
        $utilidadtotal = $values[5];
        $noefectivoing = $values[6];
        $noefectivoeg = $values[7];



        //dd($values[0]);
        $pdf = PDF::loadView('livewire.pdf.reportemovdiageneral', compact('totalesIngresos','totalesEgresos','importetotalingresos','operacionefectivoing','noefectivoing','importetotalegresos','subtotalcaja','utilidadtotal','noefectivoing','noefectivoeg'));
        return $pdf->stream('Reporte_Movimiento_Diario_General.pdf'); 
    }


    //Crear array donde sereeemplazan los id de las movimientos por las utilidades
    public function creararray()
    {
        $tabla = session('tablamovdiageneral');
        return $tabla;
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


     public function totalingresos()
     {
        $totalingreso = 0;
        $tabla = session('tablareporte');
        foreach ($tabla as $item)
        {
            if($item['tipo'] == 'INGRESO' )
            {
                $totalingreso = $totalingreso + $item['importe'];
            }
        }
        return $totalingreso;

     }
     public function totalegresos()
     {
        $totalegreso = 0;
        $tabla = session('tablareporte');
        foreach ($tabla as $item)
        {
            if($item['tipo'] == 'EGRESO' )
            {
                $totalegreso = $totalegreso + $item['importe'];
            }
        }
        return $totalegreso;
     }

    //Sumar las carteras de la Consulta Principal $DATA 
    public function totalcarteras()
    {
        $tabla = session('tablareporte');
        $carteras = Cartera::select('*', DB::raw('0 as totales'))
        ->get();

        foreach($tabla as $item)
        {
            foreach($carteras as $item2)
            {
                if($item['idcartera'] == $item2['id'])
                {

                    if($item['tipo'] == 'INGRESO')
                    {
                        $item2['totales'] = $item2['totales'] + $item['importe'];
                    }
                    else
                    {
                        $item2['totales'] = $item2['totales'] - $item['importe'];
                    }
                    break;
                }
            }
       
        }


        return $carteras;

        
    }


}
