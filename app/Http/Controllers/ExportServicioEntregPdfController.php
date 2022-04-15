<?php

namespace App\Http\Controllers;

use App\Models\Cartera;
use App\Models\OrderService;
use App\Models\Service;
use App\Models\Sucursal;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\User;


class ExportServicioEntregPdfController extends Controller
{
    public function reporteServPDF($reportType, $dateFrom = null, $dateTo = null, $sucursal, $sumaEfectivo, $sumaBanco)
    {
        $data = [];

        if ($reportType == 0) //ventas del dia
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        } else {
            $from = Carbon::parse($dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($dateTo)->format('Y-m-d')     . ' 23:59:59';
        }


        $data = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                ->join('mov_services as ms', 'services.id', 'ms.service_id')
                ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                ->join('users as u', 'u.id', 'mov.user_id')
                ->where('mov.status', 'like', 'ACTIVO')
                ->where('mov.type', 'like', 'ENTREGADO')
                ->select(
                    'services.*'
                )
                ->whereBetween('os.created_at', [$from, $to])
                ->orderBy('services.id', 'desc')
                ->distinct()
                ->get();


        $totalEfectivo = Cartera::join('cajas as caj','caj.id','carteras.caja_id')
        ->join('sucursals as s', 's.id', 'caj.sucursal_id')
        ->join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
        ->join('movimientos as m', 'm.id','cm.movimiento_id')
        ->join('mov_services as ms', 'ms.movimiento_id', 'm.id')
        ->join('services as serv', 'serv.id','ms.service_id')
        ->select('m.*')
        ->whereBetween('serv.created_at', [$from, $to])
        ->where('m.status', 'ACTIVO')
        ->where('m.type', 'like', 'ENTREGADO')
        ->where('cm.comentario', 'SERVICIOS')
        ->where('carteras.tipo', 'CajaFisica')
        ->where('s.id',$sucursal)
        ->get();
        $sumaEfectivo = $totalEfectivo->sum('import');

        $totalBanco = Cartera::join('cajas as caj','caj.id','carteras.caja_id')
        ->join('sucursals as s', 's.id', 'caj.sucursal_id')
        ->join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
        ->join('movimientos as m', 'm.id','cm.movimiento_id')
        ->join('mov_services as ms', 'ms.movimiento_id', 'm.id')
        ->join('services as serv', 'serv.id','ms.service_id')
        ->select('m.*')
        ->whereBetween('serv.created_at', [$from, $to])
        ->where('m.status', 'ACTIVO')
        ->where('m.type', 'like', 'ENTREGADO')
        ->where('cm.comentario', 'SERVICIOS')
        ->where('carteras.tipo', 'Banco')
        ->where('s.id',$sucursal)
        ->get();
        $sumaBanco = $totalBanco->sum('import');


        $sucursal = Sucursal::find($sucursal);
        $pdf = PDF::loadView('livewire.pdf.reporteServiciosEntregados', compact('data', 'reportType', 'dateFrom', 'dateTo', 'sucursal', 'sumaEfectivo', 'sumaBanco'));

        return $pdf->setPaper('letter')->stream('ServiciosReport.pdf');  //visualizar
        /* return $pdf->download('salesReport.pdf');  //descargar  */
    }
}
