<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;


class ExportSaleController extends Controller
{
    public function reportPDFVenta($total, $idventa,$usuario)
    {
        //Buscar Nokmbre del Usuario
        $nombreusuario = User::select("name as name")
        ->where("id", Auth()->user()->id)
        ->get()
        ->first();
        //Obtener datos de la Venta
        $venta = Sale::join("sale_details as sd", "sd.sale_id", "sales.id")
        ->join("products as p", "p.id", "sd.product_id")
        ->select("sales.id as id", "p.nombre as nombre", "p.precio_venta as precio","sd.quantity as cantidad"
        )
        ->where("sales.id", $idventa)
        ->get();

        $fecha = Carbon::parse(Carbon::now());


        $pdf = PDF::loadView('livewire.pdf.reciboventa', compact('total','venta','nombreusuario','fecha'));

        return $pdf->stream('comprobante.pdf');  //visualizar
        /* return $pdf->download('salesReport.pdf');  //descargar  */
    }
}
