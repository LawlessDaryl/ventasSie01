<?php

namespace App\Http\Livewire;

use App\Models\Account;
use Carbon\Carbon;
use Livewire\Component;

class ReporteGananciaStrController extends Component
{
    public $componentName, $tipoPlan, $tipoTr, $totalIngresos, $totalEgresos,
        $ganancia, $totalCantidad, $reportType, $dateFrom, $dateTo;

    public function mount()
    {
        $this->data = [];
        $this->tipoPlan = 'TODOS';
        $this->tipoTr = 'TODOS';
        $this->totalIngresos = 0;
        $this->totalEgresos = 0;
        $this->ganancia = 0;
        $this->totalCantidad = 0;
        $this->reportType = 0;
        $this->dateFrom = '2022-01-01';
        $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
    }

    public function render()
    {
        $this->trsbydate();

        return view('livewire.reporte_ganancia_streaming.component', [
            /* 'users' => User::orderBy('name', 'asc')->get() */])->extends('layouts.theme.app')
            ->section('content');
    }
    public function trsbydate()
    {
        $this->totalIngresos = 0;
        $this->totalEgresos = 0;
        $this->ganancia = 0;

        if ($this->reportType == 0) {
            $from = $this->dateFrom;
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        } else {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d');
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

        if ($this->tipoPlan == 'TODOS') {
            if ($this->tipoTr == 'TODOS') {
                $this->data = Account::join('cuenta_inversions as ci', 'accounts.id', 'ci.account_id')
                    ->join('platforms as p', 'p.id', 'accounts.platform_id')
                    ->select(
                        'ci.*',
                        'accounts.account_name',
                        'p.nombre'
                    )
                    ->whereBetween('ci.created_at', [$from, $to])
                    ->orderBy('ci.created_at', 'desc')
                    ->get();
            } elseif ($this->tipoTr != 'TODOS') {
                $this->data = Account::join('cuenta_inversions as ci', 'accounts.id', 'ci.account_id')
                    ->join('platforms as p', 'p.id', 'accounts.platform_id')
                    ->select(
                        'ci.*',
                        'accounts.account_name',
                        'p.nombre'
                    )
                    ->whereBetween('ci.created_at', [$from, $to])
                    ->where('ci.tipoTransac', $this->tipoTr)
                    ->orderBy('ci.created_at', 'desc')
                    ->get();
            }
        } elseif ($this->tipoPlan != 'TODOS') {
            if ($this->tipoTr == 'TODOS') {
                $this->data = Account::join('cuenta_inversions as ci', 'accounts.id', 'ci.account_id')
                    ->join('platforms as p', 'p.id', 'accounts.platform_id')
                    ->select(
                        'ci.*',
                        'accounts.account_name',
                        'p.nombre'
                    )
                    ->whereBetween('ci.created_at', [$from, $to])
                    ->where('ci.tipoPlan', $this->tipoPlan)
                    ->orderBy('ci.created_at', 'desc')
                    ->get();
            } elseif ($this->tipoTr != 'TODOS') {
                $this->data = Account::join('cuenta_inversions as ci', 'accounts.id', 'ci.account_id')
                    ->join('platforms as p', 'p.id', 'accounts.platform_id')
                    ->select(
                        'ci.*',
                        'accounts.account_name',
                        'p.nombre'
                    )
                    ->whereBetween('ci.created_at', [$from, $to])
                    ->where('ci.tipoPlan', $this->tipoPlan)
                    ->where('ci.tipoTransac', $this->tipoTr)
                    ->orderBy('ci.created_at', 'desc')
                    ->get();
            }
        }


        $this->totalCantidad = $this->data ? $this->data->sum('cantidad') : 0;

        if ($this->data) {
            foreach ($this->data as $value) {
                if ($value->tipo == 'INGRESO') {
                    $this->totalIngresos += $value->cantidad;
                }
                if ($value->tipo == 'EGRESO') {
                    $this->totalEgresos += $value->cantidad;
                }
            }
            $this->ganancia = $this->totalIngresos - $this->totalEgresos;
        }
    }
}
