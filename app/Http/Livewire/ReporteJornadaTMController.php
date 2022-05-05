<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Sucursal;
use App\Models\Transaccion;
use Carbon\Carbon;
use Livewire\Component;

class ReporteJornadaTMController extends Component
{
    public $componentName, $dateFrom, $sistema, $telefono, $total, $sucursal, $sucursales, $cajasSucursal, $caja,
        $condicionalCaja;

    public function mount()
    {
        $this->componentName = 'Reportes Jornada Tigo Money';


        $this->sistema = 0;
        $this->telefono = 0;
        $this->total = 0;

        $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');

        $this->sucursales = [];
        $this->cajasSucursal = [];
        /* Caja en la cual se encuentra el usuario */
        $cajausuario = Caja::join('sucursals as s', 's.id', 'cajas.sucursal_id')
            ->join('sucursal_users as su', 'su.sucursal_id', 's.id')
            ->join('carteras as car', 'cajas.id', 'car.caja_id')
            ->join('cartera_movs as cartmovs', 'car.id', 'cartmovs.cartera_id')
            ->join('movimientos as mov', 'mov.id', 'cartmovs.movimiento_id')
            ->where('mov.user_id', Auth()->user()->id)
            ->where('mov.status', 'ACTIVO')
            ->where('mov.type', 'APERTURA')
            ->select('cajas.id as cajaid', 's.id as sucursalid')
            ->get()->first();
        if ($cajausuario) {
            $this->sucursal = $cajausuario->sucursalid;
            $this->caja = $cajausuario->cajaid;
            $this->condicionalCaja = $this->sucursal;
        } else {
            $this->sucursal = 'Elegir';
            $this->caja = 'Elegir';
            $this->condicionalCaja = $this->sucursal;
        }
    }

    public function render()
    {
        $this->trsbydate();

        $this->sucursales = Sucursal::orderBy('id')->get();

        $this->cajasSucursal = Caja::where('sucursal_id', $this->sucursal)
            ->where('nombre', '!=', 'Caja General')->get();

        //revisar el cabmio de cajas y sucursales
        if ($this->sucursal != $this->condicionalCaja) {
            $this->condicionalCaja = $this->sucursal;
            $this->caja = 'Elegir';
        }


        return view('livewire.reporteJornalTigoMoney.component', [
            'sucursales' =>  $this->sucursales,
            'cajas' =>  $this->cajasSucursal
        ])->extends('layouts.theme.app')
            ->section('content');
    }

    public function trsbydate()
    {
        $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($this->dateFrom)->format('Y-m-d')     . ' 23:59:59';

        $ingresosTelefono = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
            ->join('movimientos as m', 'm.id', 'mt.movimiento_id')
            ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'm.id')
            ->join('carteras as c', 'c.id', 'cmv.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('origen_motivos as om', 'transaccions.origen_motivo_id', 'om.id')
            ->join('origens as ori', 'ori.id', 'om.origen_id')
            ->join('motivos as mot', 'mot.id', 'om.motivo_id')
            ->join('sucursals as s', 's.id', 'ca.sucursal_id')
            ->where('cmv.tipoDeMovimiento', 'TIGOMONEY')
            ->where('cmv.type', 'INGRESO')
            ->where('ori.nombre', 'Telefono')
            ->where('mot.tipo', 'Abono')
            ->where('m.status', 'Activo')
            ->where('s.id', $this->sucursal)
            ->where('ca.id', $this->caja)
            ->whereBetween('transaccions.created_at', [$from, $to])
            ->orderBy('transaccions.id', 'desc')
            ->sum('m.import');

        $egresosTelefono = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
            ->join('movimientos as m', 'm.id', 'mt.movimiento_id')
            ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'm.id')
            ->join('carteras as c', 'c.id', 'cmv.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('origen_motivos as om', 'transaccions.origen_motivo_id', 'om.id')
            ->join('origens as ori', 'ori.id', 'om.origen_id')
            ->join('motivos as mot', 'mot.id', 'om.motivo_id')
            ->join('sucursals as s', 's.id', 'ca.sucursal_id')
            ->where('cmv.tipoDeMovimiento', 'TIGOMONEY')
            ->where('cmv.type', 'EGRESO')
            ->where('ori.nombre', 'Telefono')
            ->where('mot.tipo', 'Retiro')
            ->where('m.status', 'Activo')
            ->where('s.id', $this->sucursal)
            ->where('ca.id', $this->caja)
            ->whereBetween('transaccions.created_at', [$from, $to])
            ->orderBy('transaccions.id', 'desc')
            ->sum('m.import');

        $this->telefono = $ingresosTelefono - $egresosTelefono;

        $ingresosSistema = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
            ->join('movimientos as m', 'm.id', 'mt.movimiento_id')
            ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'm.id')
            ->join('carteras as c', 'c.id', 'cmv.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('origen_motivos as om', 'transaccions.origen_motivo_id', 'om.id')
            ->join('origens as ori', 'ori.id', 'om.origen_id')
            ->join('motivos as mot', 'mot.id', 'om.motivo_id')
            ->join('sucursals as s', 's.id', 'ca.sucursal_id')
            ->where('cmv.tipoDeMovimiento', 'TIGOMONEY')
            ->where('cmv.type', 'INGRESO')
            ->where('ori.nombre', 'Sistema')
            ->where('mot.tipo', 'Abono')
            ->where('m.status', 'Activo')
            ->where('s.id', $this->sucursal)
            ->where('ca.id', $this->caja)
            ->whereBetween('transaccions.created_at', [$from, $to])
            ->orderBy('transaccions.id', 'desc')
            ->sum('m.import');

        $egresosSistema = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
            ->join('movimientos as m', 'm.id', 'mt.movimiento_id')
            ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'm.id')
            ->join('carteras as c', 'c.id', 'cmv.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('origen_motivos as om', 'transaccions.origen_motivo_id', 'om.id')
            ->join('origens as ori', 'ori.id', 'om.origen_id')
            ->join('motivos as mot', 'mot.id', 'om.motivo_id')
            ->join('sucursals as s', 's.id', 'ca.sucursal_id')
            ->where('cmv.tipoDeMovimiento', 'TIGOMONEY')
            ->where('cmv.type', 'EGRESO')
            ->where('ori.nombre', 'Sistema')
            ->where('mot.tipo', 'Retiro')
            ->where('m.status', 'Activo')
            ->where('s.id', $this->sucursal)
            ->where('ca.id', $this->caja)
            ->whereBetween('transaccions.created_at', [$from, $to])
            ->orderBy('transaccions.id', 'desc')
            ->sum('m.import');

        $this->sistema = $ingresosSistema - $egresosSistema;

        if ($this->sistema > $this->telefono) {
            $this->total = $this->sistema + $this->telefono;
        } else {
            $this->total = $this->telefono + $this->sistema;
        }
    }
}
