<?php

namespace App\Http\Livewire;

use App\Models\MovTransac;
use App\Models\Transaccion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Monolog\Handler\IFTTTHandler;

class ArqueosTigoController extends Component
{
    public $fromDate, $toDate, $userid, $total, $transaccions, $details, $importe, $tipot, $origenfiltro;

    public function mount()
    {
        $this->fromDate = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->toDate = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->userid = 0;
        $this->total = 0;
        $this->tipotr = 0;
        $this->origenfiltro = 0;
        $this->transaccions = [];
        $this->details = [];
    }

    public function render()
    {
        if ($this->userid > 0 && $this->fromDate != null && $this->toDate != null) {
            $this->Consultar();
        }
        return view('livewire.arqueos_tigo.component', [
            'users' => User::orderBy('name', 'asc')->get()
        ])->extends('layouts.theme.app')
            ->section('content');
    }

    public function Consultar()
    {
        $from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';

        if ($this->tipotr == '0') {
            if ($this->origenfiltro == '0') {
                $this->transaccions  = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
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
                $this->transaccions  = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
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
                    ->where('ori.nombre', $this->origenfiltro)
                    ->orderBy('transaccions.id', 'desc')
                    ->get();
            }
        } else {
            if ($this->origenfiltro == '0') {
                $this->transaccions  = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
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
                    ->where('mot.tipo', $this->tipotr)
                    ->orderBy('transaccions.id', 'desc')
                    ->get();
            } else {
                $this->transaccions  = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
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
                    ->where('mot.tipo', $this->tipotr)
                    ->where('ori.nombre', $this->origenfiltro)
                    ->orderBy('transaccions.id', 'desc')
                    ->get();
            }
        }
        if ($this->transaccions) {
            foreach ($this->transaccions as $tr) {
                if ($tr->estadomovimiendo != 'INACTIVO') {
                    $this->total += $tr->importe;
                }
            }
        } else {
            $this->total = 0;
        }
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
