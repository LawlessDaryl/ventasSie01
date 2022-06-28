<?php

namespace App\Http\Livewire;

use App\Models\Plan;
use App\Models\Transaccion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReportStreamingController extends Component
{
    public $componentName, $data, $details, $sumDetails, $countDetails, $reportType,
        $userId, $dateFrom, $dateTo, $planId, $Perf_Cuenta, $Vencid_Vigent;

    public function mount()
    {
        $this->componentName = 'Reportes Streaming';
        $this->data = [];
        $this->details = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->reportType = 0;
        $this->userId = 0;
        $this->planId = 0;
        $this->Perf_Cuenta = 0;
        $this->Vencid_Vigent = 0;
        $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
    }

    public function render()
    {
        $this->trsbydate();

        return view('livewire.reportes_streaming.component', [
            'users' => User::orderBy('name', 'asc')->get()
        ])->extends('layouts.theme.app')
            ->section('content');
    }

    public function trsbydate()
    {
        if ($this->reportType == 0) {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        } else {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d')     . ' 23:59:59';
        }

        if ($this->reportType == 1 && ($this->dateFrom == '' || $this->dateTo == '')) {
            $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
            $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
            $this->emit('item', 'Reportes de Hoy');
        }

        if ($this->dateFrom == "" || $this->dateTo == "") {
            $this->reportType = 0;
        }

        if ($this->Perf_Cuenta == 0) {
            if ($this->userId == 0) {
                if ($this->Vencid_Vigent == 0) {    /* perfiles vigentes de todos los usuarios */
                    $this->data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
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
                            'plans.plan_start as planinicio',
                            'plans.expiration_plan as planfin',
                            'plans.observations as obs',
                            'plans.importe as importe',
                            'plans.status as estado',
                            'plans.ready as ready',
                            'acc.price as precioCuenta',
                            'acc.price as number_profiles',
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
                    $this->data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
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
                            'plans.plan_start as planinicio',
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
                if ($this->Vencid_Vigent == 0) {    /* perfiles vigentes de un usuario */
                    $this->data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
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
                            'plans.plan_start as planinicio',
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
                        ->where('m.user_id', $this->userId)
                        ->orderBy('plans.created_at', 'desc')
                        ->get();
                } else {    /* perfiles vencidos de un usuario */
                    $this->data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
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
                            'plans.plan_start as planinicio',
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
                        ->where('m.user_id', $this->userId)
                        ->orderBy('plans.created_at', 'desc')
                        ->get();
                }
            }
        } elseif ($this->Perf_Cuenta == 1) {
            if ($this->userId == 0) {
                if ($this->Vencid_Vigent == 0) { /* cuentas vigentes de todos los usuarios */
                    $this->data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
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
                            'plans.plan_start as planinicio',
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
                    $this->data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
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
                            'plans.plan_start as planinicio',
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
                if ($this->Vencid_Vigent == 0) {    /* cuentas vigentes de usuario especifico */
                    $this->data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
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
                            'plans.plan_start as planinicio',
                            'plans.expiration_plan as planfin',
                            'plans.observations as obs',
                            'plans.status as estado',
                            'plans.ready as ready',
                        )
                        ->whereBetween('plans.created_at', [$from, $to])
                        ->where('m.user_id', $this->userId)
                        ->where('plans.type_plan', 'CUENTA')
                        ->where('plans.status', 'VIGENTE')
                        ->where('plans.ready', 'SI')
                        ->where('plans.done', 'SI')
                        ->orderBy('plans.created_at', 'desc')
                        ->get();
                } else {    /* cuentas vencidas de usuario especifico */
                    $this->data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
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
                            'plans.plan_start as planinicio',
                            'plans.expiration_plan as planfin',
                            'plans.observations as obs',
                            'plans.status as estado',
                            'plans.ready as ready',
                        )
                        ->whereBetween('plans.created_at', [$from, $to])
                        ->where('m.user_id', $this->userId)
                        ->where('plans.ready', 'SI')
                        ->where('plans.done', 'SI')
                        ->where('plans.status', 'VENCIDO')
                        ->where('plans.type_plan', 'CUENTA')
                        ->orderBy('plans.created_at', 'desc')
                        ->get();
                }
            }
        } elseif ($this->Perf_Cuenta == 2) {
            if ($this->userId == 0) {
                if ($this->Vencid_Vigent == 0) { /* combos vigentes de todos los usuarios */
                    $this->data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                        ->select(
                            'plans.*'
                        )
                        ->whereBetween('plans.created_at', [$from, $to])
                        ->where('plans.type_plan', 'COMBO')
                        ->where('plans.ready', 'SI')
                        ->where('plans.done', 'SI')
                        ->where('plans.status', 'VIGENTE')
                        ->orderBy('plans.created_at', 'desc')
                        ->get();
                } else {    /* combos vencidos de todos los usuarios */
                    $this->data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                        ->select(
                            'plans.*'
                        )
                        ->whereBetween('plans.created_at', [$from, $to])
                        ->where('plans.type_plan', 'COMBO')
                        ->where('plans.ready', 'SI')
                        ->where('plans.done', 'SI')
                        ->where('plans.status', 'VENCIDO')
                        ->orderBy('plans.created_at', 'desc')
                        ->get();
                }
            } else {
                if ($this->Vencid_Vigent == 0) {    /* cuentas vigentes de usuario especifico */
                    $this->data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                        ->select(
                            'plans.*'
                        )
                        ->whereBetween('plans.created_at', [$from, $to])
                        ->where('plans.type_plan', 'COMBO')
                        ->where('plans.ready', 'SI')
                        ->where('plans.done', 'SI')
                        ->where('plans.status', 'VIGENTE')
                        ->where('m.user_id', $this->userId)
                        ->orderBy('plans.created_at', 'desc')
                        ->get();
                } else {    /* cuentas vencidas de usuario especifico */
                    $this->data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                        ->select(
                            'plans.*'
                        )
                        ->whereBetween('plans.created_at', [$from, $to])
                        ->where('plans.type_plan', 'COMBO')
                        ->where('plans.ready', 'SI')
                        ->where('plans.done', 'SI')
                        ->where('plans.status', 'VENCIDO')
                        ->where('m.user_id', $this->userId)
                        ->orderBy('plans.created_at', 'desc')
                        ->get();
                }
            }
        }
        /* $gananciaCuentasTotal = Plan::join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
            ->join('accounts as acc', 'acc.id', 'pa.account_id')
            ->select('acc.price', 'plans.importe', DB::raw('0 as ganancia'))
            ->where('plans.type_plan', 'CUENTA')
            ->where('plans.status', '!=', 'ANULADO')->get();
        foreach ($gananciaCuentasTotal as  $value) {
            $value->ganancia = $value->importe - $value->price;
        }
        $total = $gananciaCuentasTotal ? $gananciaCuentasTotal->sum('ganancia') : 0;
        $gananciaPerfilesTotal = Plan::join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
            ->join('accounts as acc', 'acc.id', 'pa.account_id')
            ->select('acc.price', 'acc.number_profiles', 'plans.importe', DB::raw('0 as ganancia'))
            ->where('plans.type_plan', 'PERFIL')
            ->where('plans.status', '!=', 'ANULADO')
            ->get();
        foreach ($gananciaPerfilesTotal as  $value) {
            $value->ganancia = ($value->price / $value->number_profiles) - $value->importe;
        }
        $total2 = $gananciaPerfilesTotal ? $gananciaPerfilesTotal->sum('ganancia') : 0;
        
        $gananciaTotal = $total + $total2; */
    }

    public function getDetails($idplan)
    {
        $this->details = Plan::select('plans.observations')
            ->where('plans.id', $idplan)
            ->get()->first();

        $this->planId = $idplan;

        $this->emit('show-modal', 'details loaded');
    }
}
