<?php

namespace App\Http\Controllers;

use App\Models\OrderService;
use App\Models\Service;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\User;


class ExportServicioPdfController extends Controller
{
    public function reporteServPDF($userId, $estado, $reportType, $dateFrom = null, $dateTo = null)
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

        if ($estado == 'Todos') {
            if ($userId == 0) {
                
                $data = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                    ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                    ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                    ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                    ->join('users as u', 'u.id', 'mov.user_id')
                    ->where('mov.status', 'like', 'ACTIVO')
                    ->select(
                        'services.*'
                    )
                    ->whereBetween('os.created_at', [$from, $to])
                    ->orderBy('services.id', 'desc')
                    ->distinct()
                    ->get();
                
            } else {

                $data = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                ->join('mov_services as ms', 'services.id', 'ms.service_id')
                ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                ->join('users as u', 'u.id', 'mov.user_id')
                ->where('mov.status', 'like', 'ACTIVO')
                ->select(
                    'services.*'
                )
                    ->whereBetween('os.created_at', [$from, $to])
                    ->where('mov.user_id', $userId)
                    ->orderBy('services.id', 'desc')
                    ->distinct()
                    ->get();
            }
        } else {
            if ($userId == 0) {
                $data = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                ->join('mov_services as ms', 'services.id', 'ms.service_id')
                ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                ->join('users as u', 'u.id', 'mov.user_id')
                ->where('mov.status', 'like', 'ACTIVO')
                ->select(
                    'services.*'
                )
                    ->whereBetween('os.created_at', [$from, $to])
                    ->where('mov.type', $estado)
                    ->orderBy('services.id', 'desc')
                    ->distinct()
                    ->get();
            } else {
                $data = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                ->join('mov_services as ms', 'services.id', 'ms.service_id')
                ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                ->join('users as u', 'u.id', 'mov.user_id')
                ->where('mov.status', 'like', 'ACTIVO')
                ->select(
                    'services.*'
                )
                    ->whereBetween('os.created_at', [$from, $to])
                    ->where('mov.user_id', $userId)
                    ->where('mov.type', $estado)
                    ->orderBy('services.id', 'desc')
                    ->distinct()
                    ->get();
            }
        }

        $user = $userId == 0 ? 'Todos' : User::find($userId)->name;
        $pdf = PDF::loadView('livewire.pdf.reporteServicios', compact('data', 'reportType', 'user','estado', 'dateFrom', 'dateTo'));

        return $pdf->setPaper('letter', 'landscape')->stream('ServiciosReport.pdf');  //visualizar
        /* return $pdf->download('salesReport.pdf');  //descargar  */
    }
}
