<?php

namespace App\Http\Livewire;

use App\Models\Plan;
use App\Models\Transaccion;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class ArqueosStreamingController extends Component
{
    public $fromDate, $toDate, $userid, $total, $transaccions, $details, $importe,
        $condicional, $data;

    public function mount()
    {
        $this->fromDate = null;
        $this->toDate = null;
        $this->userid = 0;
        $this->total = 0;
        $this->condicional = 0;
        $this->transaccions = [];
        $this->details = [];
        $this->data = [];
    }

    public function render()
    {
        if ($this->userid > 0 && $this->fromDate != null && $this->toDate != null) {
            $this->Consultar();
        }
        return view('livewire.arqueos_streaming.component', [
            'users' => User::orderBy('name', 'asc')->get()
        ])->extends('layouts.theme.app')
            ->section('content');
    }

    public function Consultar()
    {
        $from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';

        if ($this->condicional == 0) {
            $this->data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
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
                ->where('m.user_id', $this->userid)
                ->where('acc.whole_account', 'DIVIDIDA')
                ->where('prof.availability', 'OCUPADO')
                ->where('prof.status', 'ACTIVO')
                ->whereColumn('plans.id', '=', 'ap.plan_id')
                ->orderBy('plans.created_at', 'desc')
                ->get();
        } else {
            $this->data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
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
                ->where('m.user_id', $this->userid)
                ->where('acc.whole_account', 'ENTERA')
                ->where('acc.availability', 'OCUPADO')
                ->orderBy('plans.created_at', 'desc')
                ->get();
        }

        $this->total = $this->data ? $this->data->sum('importe') : 0;
    }

    public function viewDetails(Transaccion $transaccion)
    {
        $this->Consultar();
        $this->details = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
            ->join('movimientos as m', 'm.id', 'mt.movimiento_id')

            ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'm.id')
            ->join('carteras as c', 'cmv.cartera_id', 'c.id')

            ->select(
                'cmv.type as tipo',
                'm.import as importe',
                'transaccions.observaciones as observaciones',
                'c.nombre as nombreCartera',
            )
            ->where('transaccions.id', $transaccion->id)
            ->get();
        /* dd($this->details); */
        $this->emit('show-modal', 'open modal');
    }
}
