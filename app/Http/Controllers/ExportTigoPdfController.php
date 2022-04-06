<?php

namespace App\Http\Controllers;

use App\Models\Motivo;
use App\Models\Origen;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Transaccion;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;


class ExportTigoPdfController extends Controller
{
    public function reporteTigoPDF($userId, $reportType, $origenfiltro, $tipotr, $dateFrom = null, $dateTo = null)
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
            if ($tipotr == '0') {
                if ($origenfiltro == '0') {
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
                            'm.status as estadomovimiendo',
                        )
                        ->whereBetween('transaccions.created_at', [$from, $to])

                        ->orderBy('transaccions.id', 'desc')
                        ->get();
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
                            'm.status as estadomovimiendo',
                        )
                        ->whereBetween('transaccions.created_at', [$from, $to])
                        ->where('ori.nombre', $origenfiltro)
                        ->orderBy('transaccions.id', 'desc')
                        ->get();
                }
            } else {
                if ($origenfiltro == '0') {
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
                            'm.status as estadomovimiendo',
                        )
                        ->whereBetween('transaccions.created_at', [$from, $to])
                        ->where('mot.tipo', $tipotr)
                        ->orderBy('transaccions.id', 'desc')
                        ->get();
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
                            'm.status as estadomovimiendo',
                        )
                        ->whereBetween('transaccions.created_at', [$from, $to])
                        ->where('mot.tipo', $tipotr)
                        ->where('ori.nombre', $origenfiltro)
                        ->orderBy('transaccions.id', 'desc')
                        ->get();
                }
            }
        } else {
            if ($tipotr == '0') {
                if ($origenfiltro == '0') {
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
                            'm.status as estadomovimiendo',
                        )
                        ->whereBetween('transaccions.created_at', [$from, $to])
                        ->where('m.user_id', $userId)
                        ->orderBy('transaccions.id', 'desc')
                        ->get();
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
                            'm.status as estadomovimiendo',
                        )
                        ->whereBetween('transaccions.created_at', [$from, $to])
                        ->where('m.user_id', $userId)
                        ->where('ori.nombre', $origenfiltro)
                        ->orderBy('transaccions.id', 'desc')
                        ->get();
                }
            } else {
                if ($origenfiltro == '0') {
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
                            'm.status as estadomovimiendo',
                        )
                        ->whereBetween('transaccions.created_at', [$from, $to])
                        ->where('m.user_id', $userId)
                        ->where('mot.tipo', $tipotr)
                        ->orderBy('transaccions.id', 'desc')
                        ->get();
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
                            'm.status as estadomovimiendo',
                        )
                        ->whereBetween('transaccions.created_at', [$from, $to])
                        ->where('m.user_id', $userId)
                        ->where('mot.tipo', $tipotr)
                        ->where('ori.nombre', $origenfiltro)
                        ->orderBy('transaccions.id', 'desc')
                        ->get();
                }
            }
        }

        $total = 0;
        if ($data) {
            foreach ($data as $tr) {
                if ($tr->estadomovimiendo != 'INACTIVO') {
                    $total += $tr->importe;
                }
            }
        } else {
            $total = 0;
        }

        $user = $userId == 0 ? 'Todos' : User::find($userId)->name;


        $pdf = PDF::loadView('livewire.pdf.reporteTigo', compact('data', 'reportType', 'origenfiltro', 'tipotr', 'user', 'dateFrom', 'dateTo', 'total'));

        return $pdf->stream('TigoMoneyReport.pdf');  //visualizar
        /* return $pdf->download('salesReport.pdf');  //descargar  */
    }
}
