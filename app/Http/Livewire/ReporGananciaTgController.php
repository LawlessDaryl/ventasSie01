<?php

namespace App\Http\Livewire;

use App\Models\Transaccion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReporGananciaTgController extends Component
{
    public $componentName, $data, $details, $sumDetails, $countDetails, $reportType,
        $userId, $dateFrom, $dateTo, $transaccionId;

    public function mount()
    {
        $this->componentName = 'Reportes Ganancias de Tigo Money';
        $this->data = [];
        $this->details = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->reportType = 0;
        $this->userId = 0;
        $this->transaccionId = 0;

        $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
    }

    public function render()
    {
        $this->trsbydate();

        return view('livewire.reportGananciaTg.component', [
            'users' => User::orderBy('name', 'asc')->get()
        ])->extends('layouts.theme.app')
            ->section('content');
    }

    public function trsbydate()
    {
        if ($this->reportType == 0) {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
            $this->dateFrom = '';
            $this->dateTo = '';
        } else {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d')     . ' 23:59:59';
        }

        if ($this->reportType == 1 && ($this->dateFrom == '' || $this->dateTo == '')) {
            $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
            $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
            $this->emit('item', 'Reportes de Hoy');
        }

        if ($this->userId == 0) {
            $this->data = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
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
                    'mot.nombre as motivo_nombre'
                )
                ->whereBetween('transaccions.created_at', [$from, $to])

                ->orderBy('transaccions.id', 'desc')
                ->get();
        } else {
            $this->data = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
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
                ->where('m.user_id', $this->userId)
                ->orderBy('transaccions.id', 'desc')
                ->get();
            foreach ($this->data as $d) {
                $d->ganancia = ($d->importe * 1) / 100;
            }
        }
    }
}
