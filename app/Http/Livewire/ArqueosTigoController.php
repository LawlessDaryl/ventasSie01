<?php

namespace App\Http\Livewire;

use App\Models\MovTransac;
use App\Models\Transaccion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ArqueosTigoController extends Component
{
    public $fromDate, $toDate, $userid, $total, $transaccions, $details, $importe;

    public function mount()
    {
        $this->fromDate = null;
        $this->toDate = null;
        $this->userid = 0;
        $this->total = 0;
        $this->transaccions = [];
        $this->details = [];
    }

    public function render()
    {
        return view('livewire.arqueos_tigo.component', [
            'users' => User::orderBy('name', 'asc')->get()
        ])->extends('layouts.theme.app')
            ->section('content');
    }

    public function Consultar()
    {
        $fi = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
        $ff = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';

        $this->transaccions = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
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
            ->whereBetween('transaccions.created_at', [$fi, $ff])
            ->where('m.user_id', $this->userid)
            
            ->orderBy('transaccions.id', 'desc')
            ->get();

        $this->total = $this->transaccions ? $this->transaccions->sum('importe') : 0;
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
                'transaccions.importe as importe',
                'c.nombre as nombreCartera',
            )
            ->where('transaccions.id', $transaccion->id)
            ->get();
        $this->emit('show-modal', 'open modal');
    }

    
}
