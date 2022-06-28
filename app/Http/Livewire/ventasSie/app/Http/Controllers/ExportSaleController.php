<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Sucursal;
use Maatwebsite\Excel\Facades\Excel;


class ExportSaleController extends Controller
{
    public function reportPDFVenta($total, $idventa,$totalitems)
    {
        //Buscar Nombre del Usuario
        $nombreusuario = User::select("name as name")
        ->where("id", Auth()->user()->id)
        ->get()
        ->first();
        //Obtener datos de la Venta
        $venta = Sale::join("sale_details as sd", "sd.sale_id", "sales.id")
        ->join("products as p", "p.id", "sd.product_id")
        ->select("sales.created_at as fechaventa", "p.nombre as nombre", "sd.price as precio","sd.quantity as cantidad")
        ->where("sales.id", $idventa)
        ->get();

        //Obtener Datos del cliente
        $datoscliente = Cliente::join("cliente_movs as cm", "cm.cliente_id", "clientes.id")
        ->join("movimientos as m", "m.id", "cm.movimiento_id")
        ->join("sales as s", "s.movimiento_id", "m.id")
        ->select("s.id as id", "clientes.razon_social as razonsocial", "clientes.nit as nit", "clientes.celular as celular")
        ->where("s.id", $idventa)
        ->get()
        ->first();

        //Obtener datos de la sucursal
        $datossucursal = Sucursal::join("sucursal_users as su", "su.sucursal_id", "sucursals.id")
        ->select("sucursals.name as nombresucursal","sucursals.adress as direccionsucursal", "su.user_id")
        ->where("su.user_id", Auth()->user()->id)
        ->get()
        ->first();

        // SELECT s.name as nombresucursal,s.adress as direccionsucursal, su.user_id
        // FROM sucursals s
        // INNER JOIN sucursal_users su ON su.sucursal_id = s.id
        // where su.user_id=2

        $row_venta = Sale::find($idventa);
        $total = $row_venta->total;

        $fecha = Carbon::parse(Carbon::now());


        $pdf = PDF::loadView('livewire.pdf.reciboventa', compact('datoscliente','venta','nombreusuario','fecha','total','totalitems','datossucursal'));

        return $pdf->stream('comprobante.pdf');  //visualizar
        /* return $pdf->download('salesReport.pdf');  //descargar  */
    }
}
