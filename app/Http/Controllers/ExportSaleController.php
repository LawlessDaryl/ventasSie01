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
    public function reportPDFVenta($total, $podructsshoopingcart,$usuario)
    {
        //dd($podructsshoopingcart);

        $idventa = Sale::join("sale_details as sd", "sd.sale_id", "sales.id")
        ->select("sales.id as id","sd.price as price")
        ->where("sales.id", $podructsshoopingcart)
        ->get();


        $pdf = PDF::loadView('livewire.pdf.reciboventa', compact('total','idventa','usuario'));

        return $pdf->stream('comprobante.pdf');  //visualizar
        /* return $pdf->download('salesReport.pdf');  //descargar  */
    }
}
