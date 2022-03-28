<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\User;


class ExportStreamingPdfController extends Controller
{
    public function reporteStrPDF($userId, $cuenPerf, $vigVenc, $reportType, $dateFrom = null, $dateTo = null)
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

        if ($cuenPerf == 0) {
            if ($userId == 0) {
                if ($vigVenc == 0) {    /* perfiles vigentes de todos los usuarios */
                    $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                        ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                        ->join('accounts as acc', 'acc.id', 'pa.account_id')
                        ->join('account_profiles as ap', 'acc.id', 'ap.account_id')
                        ->join('profiles as prof', 'prof.id', 'ap.profile_id')
                        ->join('emails as e', 'e.id', 'acc.email_id')
                        ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                        ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                        ->select(
                            'plat.nombre as plataforma',
                            'acc.expiration_account as accexp',
                            'c.nombre as cliente',
                            'c.celular as celular',
                            'e.content as correo',
                            'e.pass as passCorreo',
                            'acc.password_account as password_account',
                            'prof.nameprofile as nameprofile',
                            'prof.pin as pin',
                            'plans.id as id',
                            'plans.created_at as planinicio',
                            'plans.expiration_plan as planfin',
                            'plans.observations as obs',
                            'plans.importe as importe',
                            'plans.status as estado',
                            'plans.ready as ready',
                        )
                        ->whereBetween('plans.created_at', [$from, $to])
                        ->whereColumn('plans.id', '=', 'ap.plan_id')
                        ->where('plans.ready', 'SI')
                        ->where('plans.done', 'SI')
                        ->where('plans.type_plan', 'PERFIL')
                        ->where('plans.status', 'VIGENTE')
                        ->orderBy('plans.created_at', 'desc')
                        ->get();
                } else {   /* perfiles vencidos de todos los usuarios */
                    $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                        ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                        ->join('accounts as acc', 'acc.id', 'pa.account_id')
                        ->join('account_profiles as ap', 'acc.id', 'ap.account_id')
                        ->join('profiles as prof', 'prof.id', 'ap.profile_id')
                        ->join('emails as e', 'e.id', 'acc.email_id')
                        ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                        ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                        ->select(
                            'plat.nombre as plataforma',
                            'acc.expiration_account as accexp',
                            'c.nombre as cliente',
                            'c.celular as celular',
                            'e.content as correo',
                            'e.pass as passCorreo',
                            'acc.password_account as password_account',
                            'prof.nameprofile as nameprofile',
                            'prof.pin as pin',
                            'plans.id as id',
                            'plans.created_at as planinicio',
                            'plans.expiration_plan as planfin',
                            'plans.observations as obs',
                            'plans.importe as importe',
                            'plans.status as estado',
                            'plans.ready as ready',
                        )
                        ->whereBetween('plans.created_at', [$from, $to])
                        ->whereColumn('plans.id', '=', 'ap.plan_id')
                        ->where('plans.ready', 'SI')
                        ->where('plans.done', 'SI')
                        ->where('plans.type_plan', 'PERFIL')
                        ->where('plans.status', 'VENCIDO')
                        ->orderBy('plans.created_at', 'desc')
                        ->get();
                }
            } else {
                if ($vigVenc == 0) {    /* perfiles vigentes de un usuario */
                    $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                        ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                        ->join('accounts as acc', 'acc.id', 'pa.account_id')
                        ->join('account_profiles as ap', 'acc.id', 'ap.account_id')
                        ->join('profiles as prof', 'prof.id', 'ap.profile_id')
                        ->join('emails as e', 'e.id', 'acc.email_id')
                        ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                        ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                        ->select(
                            'plat.nombre as plataforma',
                            'acc.expiration_account as accexp',
                            'c.nombre as cliente',
                            'c.celular as celular',
                            'e.content as correo',
                            'e.pass as passCorreo',
                            'acc.password_account as password_account',
                            'prof.nameprofile as nameprofile',
                            'prof.pin as pin',
                            'plans.id as id',
                            'plans.created_at as planinicio',
                            'plans.expiration_plan as planfin',
                            'plans.observations as obs',
                            'plans.importe as importe',
                            'plans.status as estado',
                            'plans.ready as ready',
                        )
                        ->whereBetween('plans.created_at', [$from, $to])
                        ->whereColumn('plans.id', '=', 'ap.plan_id')
                        ->where('plans.ready', 'SI')
                        ->where('plans.done', 'SI')
                        ->where('plans.type_plan', 'PERFIL')
                        ->where('plans.status', 'VIGENTE')
                        ->where('m.user_id', $userId)
                        ->orderBy('plans.created_at', 'desc')
                        ->get();
                } else {    /* perfiles vencidos de un usuario */
                    $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                        ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                        ->join('accounts as acc', 'acc.id', 'pa.account_id')
                        ->join('account_profiles as ap', 'acc.id', 'ap.account_id')
                        ->join('profiles as prof', 'prof.id', 'ap.profile_id')
                        ->join('emails as e', 'e.id', 'acc.email_id')
                        ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                        ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                        ->select(
                            'plat.nombre as plataforma',
                            'acc.expiration_account as accexp',
                            'c.nombre as cliente',
                            'c.celular as celular',
                            'e.content as correo',
                            'e.pass as passCorreo',
                            'acc.password_account as password_account',
                            'prof.nameprofile as nameprofile',
                            'prof.pin as pin',
                            'plans.id as id',
                            'plans.created_at as planinicio',
                            'plans.expiration_plan as planfin',
                            'plans.observations as obs',
                            'plans.importe as importe',
                            'plans.status as estado',
                            'plans.ready as ready',
                        )
                        ->whereBetween('plans.created_at', [$from, $to])
                        ->whereColumn('plans.id', '=', 'ap.plan_id')
                        ->where('plans.ready', 'SI')
                        ->where('plans.done', 'SI')
                        ->where('plans.type_plan', 'PERFIL')
                        ->where('plans.status', 'VENCIDO')
                        ->where('m.user_id', $userId)
                        ->orderBy('plans.created_at', 'desc')
                        ->get();
                }
            }
        } else {
            if ($userId == 0) {
                if ($vigVenc == 0) { /* cuentas vigentes de todos los usuarios */
                    $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                        ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                        ->join('accounts as acc', 'acc.id', 'pa.account_id')
                        ->join('emails as e', 'e.id', 'acc.email_id')
                        ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                        ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                        ->select(
                            'plat.nombre as plataforma',
                            'acc.expiration_account as accexp',
                            'c.nombre as cliente',
                            'c.celular as celular',
                            'e.content as correo',
                            'e.pass as passCorreo',
                            'plans.importe as importe',
                            'acc.password_account as password_account',
                            'acc.status as accstatus',
                            'plans.id as id',
                            'plans.created_at as planinicio',
                            'plans.expiration_plan as planfin',
                            'plans.observations as obs',
                            'plans.status as estado',
                            'plans.ready as ready',
                        )
                        ->whereBetween('plans.created_at', [$from, $to])
                        ->where('plans.ready', 'SI')
                        ->where('plans.done', 'SI')
                        ->where('plans.type_plan', 'CUENTA')
                        ->where('plans.status', 'VIGENTE')
                        ->orderBy('plans.created_at', 'desc')
                        ->get();
                } else {    /* cuentas vencidas de todos los usuarios */
                    $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                        ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                        ->join('accounts as acc', 'acc.id', 'pa.account_id')
                        ->join('emails as e', 'e.id', 'acc.email_id')
                        ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                        ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                        ->select(
                            'plat.nombre as plataforma',
                            'acc.expiration_account as accexp',
                            'c.nombre as cliente',
                            'c.celular as celular',
                            'e.content as correo',
                            'e.pass as passCorreo',
                            'plans.importe as importe',
                            'acc.password_account as password_account',
                            'acc.status as accstatus',
                            'plans.id as id',
                            'plans.created_at as planinicio',
                            'plans.expiration_plan as planfin',
                            'plans.observations as obs',
                            'plans.status as estado',
                            'plans.ready as ready',
                        )
                        ->whereBetween('plans.created_at', [$from, $to])
                        ->where('plans.ready', 'SI')
                        ->where('plans.done', 'SI')
                        ->where('plans.type_plan', 'CUENTA')
                        ->where('plans.status', 'VENCIDO')
                        ->orderBy('plans.created_at', 'desc')
                        ->get();
                }
            } else {
                if ($vigVenc == 0) {    /* cuentas vigentes de usuario especifico */
                    $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                        ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                        ->join('accounts as acc', 'acc.id', 'pa.account_id')
                        ->join('emails as e', 'e.id', 'acc.email_id')
                        ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                        ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                        ->select(
                            'plat.nombre as plataforma',
                            'acc.expiration_account as accexp',
                            'c.nombre as cliente',
                            'c.celular as celular',
                            'e.content as correo',
                            'e.pass as passCorreo',
                            'plans.importe as importe',
                            'acc.password_account as password_account',
                            'acc.status as accstatus',
                            'plans.id as id',
                            'plans.created_at as planinicio',
                            'plans.expiration_plan as planfin',
                            'plans.observations as obs',
                            'plans.status as estado',
                            'plans.ready as ready',
                        )
                        ->whereBetween('plans.created_at', [$from, $to])
                        ->where('m.user_id', $userId)
                        ->where('plans.type_plan', 'CUENTA')
                        ->where('plans.status', 'VIGENTE')
                        ->where('plans.ready', 'SI')
                        ->where('plans.done', 'SI')
                        ->orderBy('plans.created_at', 'desc')
                        ->get();
                } else {    /* cuentas vencidas de usuario especifico */
                    $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                        ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                        ->join('accounts as acc', 'acc.id', 'pa.account_id')
                        ->join('emails as e', 'e.id', 'acc.email_id')
                        ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                        ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                        ->select(
                            'plat.nombre as plataforma',
                            'acc.expiration_account as accexp',
                            'c.nombre as cliente',
                            'c.celular as celular',
                            'e.content as correo',
                            'e.pass as passCorreo',
                            'plans.importe as importe',
                            'acc.password_account as password_account',
                            'acc.status as accstatus',
                            'plans.id as id',
                            'plans.created_at as planinicio',
                            'plans.expiration_plan as planfin',
                            'plans.observations as obs',
                            'plans.status as estado',
                            'plans.ready as ready',
                        )
                        ->whereBetween('plans.created_at', [$from, $to])
                        ->where('m.user_id', $userId)
                        ->where('plans.ready', 'SI')
                        ->where('plans.done', 'SI')
                        ->where('plans.status', 'VENCIDO')
                        ->where('plans.type_plan', 'CUENTA')
                        ->orderBy('plans.created_at', 'desc')
                        ->get();
                }
            }
        }

        

        $user = $userId == 0 ? 'Todos' : User::find($userId)->name;
        $pdf = PDF::loadView('livewire.pdf.reporteStreaming', compact('data', 'cuenPerf','vigVenc', 'reportType', 'user', 'dateFrom', 'dateTo'));

        return $pdf->setPaper('letter', 'landscape')->stream('StreamingReport.pdf');  //visualizar
        /* return $pdf->download('salesReport.pdf');  //descargar  */
    }
}
