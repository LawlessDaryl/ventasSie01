<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Transaccion;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;


class ExportStreamingPdfController extends Controller
{
    public function reporteStrPDF($userId, $tipo, $reportType, $dateFrom = null, $dateTo = null)
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

        if ($tipo == 0) {
            if ($userId == 0) {
                $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                    ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                    ->join('accounts as acc', 'acc.id', 'pa.account_id')
                    ->join('account_profiles as ap', 'acc.id', 'ap.account_id')
                    ->join('profiles as prof', 'prof.id', 'ap.profile_id')
                    ->join('emails as e', 'e.id', 'acc.email_id')
                    ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                    ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                    ->join('cartera_movs as cmvs', 'm.id', 'cmvs.movimiento_id')
                    ->join('carteras as cart', 'cart.id', 'cmvs.cartera_id')
                    ->join('cajas as ca', 'ca.id', 'cart.caja_id')
                    ->select(
                        'plat.nombre as plataforma',
                        'acc.expiration_account as accexp',
                        'c.nombre as cliente',
                        'c.celular as celular',
                        'e.content as correo',
                        'acc.password_account as password_account',
                        'prof.nameprofile as nameprofile',
                        'prof.pin as pin',
                        'plans.id as id',
                        'plans.created_at as planinicio',
                        'plans.expiration_plan as planfin',
                        'plans.observations as obs',
                        'plans.importe as importe',
                        'plans.status as estado'
                    )
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('acc.whole_account', 'DIVIDIDA')
                    ->where('prof.availability', 'OCUPADO')
                    ->where('prof.status', 'ACTIVO')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')
                    ->orderBy('plans.created_at', 'desc')
                    ->get();
            } else {
                $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                    ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                    ->join('accounts as acc', 'acc.id', 'pa.account_id')
                    ->join('account_profiles as ap', 'acc.id', 'ap.account_id')
                    ->join('profiles as prof', 'prof.id', 'ap.profile_id')
                    ->join('emails as e', 'e.id', 'acc.email_id')
                    ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                    ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                    ->join('cartera_movs as cmvs', 'm.id', 'cmvs.movimiento_id')
                    ->join('carteras as cart', 'cart.id', 'cmvs.cartera_id')
                    ->join('cajas as ca', 'ca.id', 'cart.caja_id')
                    ->select(
                        'plat.nombre as plataforma',
                        'acc.expiration_account as accexp',
                        'c.nombre as cliente',
                        'c.celular as celular',
                        'e.content as correo',
                        'acc.password_account as password_account',
                        'prof.nameprofile as nameprofile',
                        'prof.pin as pin',
                        'plans.id as id',
                        'plans.created_at as planinicio',
                        'plans.expiration_plan as planfin',
                        'plans.observations as obs',
                        'plans.importe as importe',
                        'plans.status as estado'
                    )
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $userId)
                    ->where('acc.whole_account', 'DIVIDIDA')
                    ->where('prof.availability', 'OCUPADO')
                    ->where('prof.status', 'ACTIVO')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')
                    ->orderBy('plans.created_at', 'desc')
                    ->get();
            }
        } else {
            if ($userId == 0) {
                $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                    ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                    ->join('accounts as acc', 'acc.id', 'pa.account_id')
                    ->join('emails as e', 'e.id', 'acc.email_id')
                    ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                    ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                    ->join('cartera_movs as cmvs', 'm.id', 'cmvs.movimiento_id')
                    ->join('carteras as cart', 'cart.id', 'cmvs.cartera_id')
                    ->join('cajas as ca', 'ca.id', 'cart.caja_id')
                    ->select(
                        'plat.nombre as plataforma',
                        'acc.expiration_account as accexp',
                        'c.nombre as cliente',
                        'c.celular as celular',
                        'e.content as correo',
                        'plans.importe as importe',
                        'acc.password_account as password_account',
                        'acc.status as accstatus',
                        'plans.id as id',
                        'plans.created_at as planinicio',
                        'plans.expiration_plan as planfin',
                        'plans.observations as obs',
                        'plans.status as estado'
                    )
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('acc.whole_account', 'ENTERA')
                    ->where('acc.availability', 'OCUPADO')
                    ->orderBy('plans.created_at', 'desc')
                    ->get();
            } else {
                $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                    ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                    ->join('accounts as acc', 'acc.id', 'pa.account_id')
                    ->join('emails as e', 'e.id', 'acc.email_id')
                    ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                    ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                    ->join('cartera_movs as cmvs', 'm.id', 'cmvs.movimiento_id')
                    ->join('carteras as cart', 'cart.id', 'cmvs.cartera_id')
                    ->join('cajas as ca', 'ca.id', 'cart.caja_id')
                    ->select(
                        'plat.nombre as plataforma',
                        'acc.expiration_account as accexp',
                        'c.nombre as cliente',
                        'c.celular as celular',
                        'e.content as correo',
                        'plans.importe as importe',
                        'acc.password_account as password_account',
                        'acc.status as accstatus',
                        'plans.id as id',
                        'plans.created_at as planinicio',
                        'plans.expiration_plan as planfin',
                        'plans.observations as obs',
                        'plans.status as estado'
                    )
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $userId)
                    ->where('acc.whole_account', 'ENTERA')
                    ->where('acc.availability', 'OCUPADO')
                    ->orderBy('plans.created_at', 'desc')
                    ->get();
            }
        }

        $user = $userId == 0 ? 'Todos' : User::find($userId)->name;
        $pdf = PDF::loadView('livewire.pdf.reporteStreaming', compact('data', 'tipo', 'reportType', 'user', 'dateFrom', 'dateTo'));

        return $pdf->setPaper('letter', 'landscape')->stream('StreamingReport.pdf');  //visualizar
        /* return $pdf->download('salesReport.pdf');  //descargar  */
    }
}
