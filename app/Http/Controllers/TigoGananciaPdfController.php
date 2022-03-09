<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Transaccion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class TigoGananciaPdfController extends Controller
{
    public function reporte($userId, $reportType, $dateFrom = null, $dateTo = null)
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

        if ($userId == 0) {
            $data = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
                ->join('movimientos as m', 'm.id', 'mt.movimiento_id')
                ->join('users as u', 'm.user_id', 'u.id')
                ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'm.id')
                ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                ->join('origen_motivos as om', 'transaccions.origen_motivo_id', 'om.id')
                ->join('origens as ori', 'ori.id', 'om.origen_id')
                ->join('motivos as mot', 'mot.id', 'om.motivo_id')
                ->select(
                    'c.cedula as cedula',
                    'transaccions.*',
                    'ori.nombre as origen_nombre',
                    'mot.nombre as motivo_nombre',
                    DB::raw('0 as ganancia')
                )
                ->whereBetween('transaccions.created_at', [$from, $to])

                ->orderBy('transaccions.id', 'desc')
                ->get();
            foreach ($data as $d) {
                $d->ganancia = ($d->importe * 1) / 100;
            }
        } else {
            $data = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
                ->join('movimientos as m', 'm.id', 'mt.movimiento_id')
                ->join('users as u', 'm.user_id', 'u.id')
                ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'm.id')
                ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                ->join('origen_motivos as om', 'transaccions.origen_motivo_id', 'om.id')
                ->join('origens as ori', 'ori.id', 'om.origen_id')
                ->join('motivos as mot', 'mot.id', 'om.motivo_id')
                ->select(
                    'c.cedula as cedula',
                    'transaccions.*',
                    'ori.nombre as origen_nombre',
                    'mot.nombre as motivo_nombre',
                )
                ->whereBetween('transaccions.created_at', [$from, $to])
                ->where('m.user_id', $userId)
                ->orderBy('transaccions.id', 'desc')
                ->get();
            foreach ($data as $d) {
                $d->ganancia = ($d->importe * 1) / 100;
            }
        }

        $user = $userId == 0 ? 'Todos' : User::find($userId)->name;
        $pdf = PDF::loadView('livewire.pdf.reporteGananciaTigo', compact('data', 'reportType', 'user', 'dateFrom', 'dateTo'));

        return $pdf->stream('TigoMoneyGananciasReport.pdf');  //visualizar
        /* return $pdf->download('salesReport.pdf');  //descargar  */
    }
}
