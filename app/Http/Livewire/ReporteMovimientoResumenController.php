<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\Movimiento;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Service;
use App\Models\Sucursal;
use App\Models\Transaccion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Redirect;

class ReporteMovimientoResumenController extends Component
{
    public $idsucursal,$totalesIngresos,$totalesEgresos,$fromDate,$toDate,$cartera_id, $type, $cantidad, $comentario,$vertotales=0,$importetotalingresos,$importetotalegresos,
    $operacionefectivoing,$noefectivo,$operacionefectivoeg,$noefectivoeg,$subtotalcaja,$utilidadtotal=5,$caja,$ops=0,$sucursal,$total;
    
    public function mount()
    {
        $this->sucursal = $this->idsucursal();
        $this->fromDate= Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->toDate=  Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->caja='TODAS';
    }
    public function render()
    {

        /* Caja en la cual se encuentra el usuario */
        $SucursalUsuario = User::join('sucursal_users as su', 'su.user_id', 'users.id')
        ->join('sucursals as s', 's.id', 'su.sucursal_id')
        ->where('users.id', Auth()->user()->id)
        ->where('su.estado', 'ACTIVO')
        ->select('s.*')
        ->get()->first();

        if ($this->sucursal == 'TODAS')
        {
            $cajab=Caja::where('cajas.nombre','!=','Caja General')->get();
        }
        else
        {
            $cajab=Caja::where('cajas.sucursal_id',$this->sucursal)->where('cajas.nombre','!=','Caja General')->get();
        }

        $carterasSucursal = Cartera::join('cajas as c', 'carteras.caja_id', 'c.id')
            ->join('sucursals as s', 's.id', 'c.sucursal_id')
            ->where('s.id', $SucursalUsuario->id)
            ->select('carteras.id', 'carteras.nombre as carteraNombre', 'c.nombre as cajaNombre', 'carteras.tipo as tipo', DB::raw('0 as monto'))->get();
        

        $this->viewTotales();

        $this->allop(Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',$this->sucursal,$this->caja);

        return view('livewire.reportemovimientoresumen.reportemovimientoresumen', [
            'carterasSucursal' => $carterasSucursal,
            'sucursales'=>Sucursal::all(),
            'cajas'=>$cajab

        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }


    public function viewTotales()
    {
         $this->utilidadtotal = 0;
         if ($this->caja != 'TODAS')
         {
            //Totales Ingresos Ventas
            $this->totalesIngresosV = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
            ->join('carteras as c', 'c.id', 'crms.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('users as u', 'u.id', 'movimientos.user_id')
            ->join('sales as s','s.movimiento_id','movimientos.id')
            ->select('s.id as idventa',
            'movimientos.import as importe',
            'crms.type as carteramovtype',
            'crms.tipoDeMovimiento',
            'c.nombre as nombrecartera',
            'c.descripcion',
            'c.tipo as ctipo',
            'movimientos.updated_at as movcreacion',
            'movimientos.id as idmov',DB::raw('0 as detalle'),DB::raw('0 as utilidadventa'))
            ->where('movimientos.status', 'ACTIVO')
            ->where('crms.type', 'INGRESO')
            ->where('crms.comentario','<>', 'RECAUDO DEL DIA')
            ->where('crms.tipoDeMovimiento', 'VENTA')
            ->where('ca.id',$this->caja)
            ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
            ->orderBy('movimientos.updated_at', 'asc')
            ->get();
    
            foreach ($this->totalesIngresosV as $val)
            {
                $vs=$this->listardetalleventas($val->idventa);
            
                $val->detalle=$vs;
                
            }
    
            foreach ($this->totalesIngresosV as $var) 
            {
               $var->utilidadventa = $this->utilidadventa($var->idventa);
    
            }
    
    
    
    
            //Totales Ingresos Servicios
            $this->totalesIngresosS = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
            ->join('carteras as c', 'c.id', 'crms.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('users as u', 'u.id', 'movimientos.user_id')
            ->select(
                'movimientos.import as importe',
                'crms.type as carteramovtype',
                'crms.tipoDeMovimiento',
                'c.nombre as nombrecartera',
                'c.descripcion',
                'c.tipo as ctipo',
                'c.telefonoNum',
                'movimientos.updated_at as movcreacion',
                'movimientos.id as idmov',
                DB::raw('0 as utilidadservicios'))
            ->where('movimientos.status', 'ACTIVO')
            ->where('crms.type', 'INGRESO')
            ->where('crms.comentario','<>', 'RECAUDO DEL DIA')
            ->where('crms.tipoDeMovimiento', '!=' , 'TIGOMONEY')
            ->where('crms.tipoDeMovimiento', '!=' , 'STREAMING')
            ->where('crms.tipoDeMovimiento', '!=' , 'VENTA')
            ->where('crms.tipoDeMovimiento', '!=' , 'EGRESO/INGRESO')
            ->where('ca.id',$this->caja)
            ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
            ->orderBy('movimientos.updated_at', 'asc')
            ->get();
    
            foreach ($this->totalesIngresosS as $var1) 
            {
               $var1->utilidadservicios = $this->utilidadservicio($var1->idmov);
    
            }
            
    
    
    
            //Totales Ingresos (EGRESOS/INGRESOS)
            $this->totalesIngresosIE = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
            ->join('carteras as c', 'c.id', 'crms.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('users as u', 'u.id', 'movimientos.user_id')
            ->select(
                'movimientos.import as importe',
                'crms.type as carteramovtype',
                'crms.tipoDeMovimiento',
                'c.nombre as nombrecartera',
                'c.descripcion',
                'c.tipo as ctipo',
                'c.telefonoNum',
                'movimientos.updated_at as movcreacion',
                'movimientos.id as idmov')
            ->where('movimientos.status', 'ACTIVO')
            ->where('crms.type', 'INGRESO')
            ->where('crms.comentario','<>', 'RECAUDO DEL DIA')
            ->where('crms.tipoDeMovimiento' , 'EGRESO/INGRESO')
            ->where('ca.id',$this->caja)
            ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
            ->orderBy('movimientos.updated_at', 'asc')
            ->get();
    
    
    
            //TOTALES EGRESOS
            
            //Totales Egresos Ventas
            $this->totalesEgresosV = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
            ->join('carteras as c', 'c.id', 'crms.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('users as u', 'u.id', 'movimientos.user_id')
            ->join('devolution_sales as ds','ds.movimiento_id','movimientos.id')
            ->select('ds.id as idds',
            'movimientos.import as importe',
            'crms.type as carteramovtype',
            'crms.tipoDeMovimiento',
            'c.nombre as nombrecartera',
            'c.descripcion',
            'c.tipo as ctipo',
            'movimientos.updated_at as movcreacion',
            'movimientos.id as idmov')
            ->where('movimientos.status', 'ACTIVO')
            ->where('crms.type', 'EGRESO')
            ->where('crms.comentario','<>', 'RECAUDO DEL DIA')
            ->where('crms.tipoDeMovimiento', 'VENTA')
            ->where('ca.id',$this->caja)
            ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
            ->orderBy('movimientos.updated_at', 'asc')
           ->get();
    
           
    
    
           
            //Totales Egresos (EGRESOS/INGRESOS)
           $this->totalesEgresosIE = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
           ->join('carteras as c', 'c.id', 'crms.cartera_id')
           ->join('cajas as ca', 'ca.id', 'c.caja_id')
           ->join('users as u', 'u.id', 'movimientos.user_id')
           ->select(
               'movimientos.import as importe',
               'crms.type as carteramovtype',
               'crms.tipoDeMovimiento',
               'c.nombre as nombrecartera',
               'c.descripcion',
               'c.tipo as ctipo',
               'c.telefonoNum',
               'movimientos.updated_at as movcreacion',
               'movimientos.id as idmov')
           ->where('movimientos.status', 'ACTIVO')
           ->where('crms.type', 'EGRESO')
           ->where('crms.comentario','<>', 'RECAUDO DEL DIA')
           ->where('crms.tipoDeMovimiento' , 'EGRESO/INGRESO')
           ->where('ca.id',$this->caja)
           ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
           ->orderBy('movimientos.updated_at', 'asc')
           ->get();


           $this->trsbydatecaja();
           $this->operaciones();

            //operacion auxiliar para deducion de tigo money







         }
         else
         {
            if ($this->sucursal != 'TODAS')
            {
                //Totales Ingresos Ventas
            $this->totalesIngresosV = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
            ->join('carteras as c', 'c.id', 'crms.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('users as u', 'u.id', 'movimientos.user_id')
            ->join('sales as s','s.movimiento_id','movimientos.id')
            ->select('s.id as idventa',
            'movimientos.import as importe',
            'crms.type as carteramovtype',
            'crms.tipoDeMovimiento',
            'c.nombre as nombrecartera',
            'c.descripcion',
            'c.tipo as ctipo',
            'movimientos.updated_at as movcreacion',
            'movimientos.id as idmov',DB::raw('0 as detalle'),DB::raw('0 as utilidadventa'))
            ->where('movimientos.status', 'ACTIVO')
            ->where('crms.type', 'INGRESO')
            ->where('crms.comentario','<>', 'RECAUDO DEL DIA')
            ->where('crms.tipoDeMovimiento', 'VENTA')
            ->where('ca.sucursal_id',$this->sucursal)
            ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
            ->orderBy('movimientos.updated_at', 'asc')
            ->get();

            foreach ($this->totalesIngresosV as $val)
            {
                $vs=$this->listardetalleventas($val->idventa);
            
                $val->detalle=$vs;
                
            }
    
            foreach ($this->totalesIngresosV as $var) 
            {
               $var->utilidadventa = $this->utilidadventa($var->idventa);
    
            }
    
    
    
    
            //Totales Ingresos Servicios
            $this->totalesIngresosS = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
            ->join('carteras as c', 'c.id', 'crms.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('users as u', 'u.id', 'movimientos.user_id')
            ->select(
                'movimientos.import as importe',
                'crms.type as carteramovtype',
                'crms.tipoDeMovimiento',
                'c.nombre as nombrecartera',
                'c.descripcion',
                'c.tipo as ctipo',
                'c.telefonoNum',
                'movimientos.updated_at as movcreacion',
                'movimientos.id as idmov',
                DB::raw('0 as utilidadservicios'))
            ->where('movimientos.status', 'ACTIVO')
            ->where('crms.type', 'INGRESO')
            ->where('crms.comentario','<>', 'RECAUDO DEL DIA')
            ->where('crms.tipoDeMovimiento', '!=' , 'TIGOMONEY')
            ->where('crms.tipoDeMovimiento', '!=' , 'STREAMING')
            ->where('crms.tipoDeMovimiento', '!=' , 'VENTA')
            ->where('crms.tipoDeMovimiento', '!=' , 'EGRESO/INGRESO')
            ->where('ca.sucursal_id',$this->sucursal)
            ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
            ->orderBy('movimientos.updated_at', 'asc')
            ->get();
    
            foreach ($this->totalesIngresosS as $var1) 
            {
               $var1->utilidadservicios = $this->utilidadservicio($var1->idmov);
    
            }
            
    
    
    
            //Totales Ingresos (EGRESOS/INGRESOS)
            $this->totalesIngresosIE = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
            ->join('carteras as c', 'c.id', 'crms.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('users as u', 'u.id', 'movimientos.user_id')
            ->select(
                'movimientos.import as importe',
                'crms.type as carteramovtype',
                'crms.tipoDeMovimiento',
                'c.nombre as nombrecartera',
                'c.descripcion',
                'c.tipo as ctipo',
                'c.telefonoNum',
                'movimientos.updated_at as movcreacion',
                'movimientos.id as idmov')
            ->where('movimientos.status', 'ACTIVO')
            ->where('crms.type', 'INGRESO')
            ->where('crms.comentario','<>', 'RECAUDO DEL DIA')
            ->where('crms.tipoDeMovimiento' , 'EGRESO/INGRESO')
            ->where('ca.sucursal_id',$this->sucursal)
            ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
            ->orderBy('movimientos.updated_at', 'asc')
            ->get();
    
    
    
            //TOTALES EGRESOS
            
            //Totales Egresos Ventas
            $this->totalesEgresosV = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
            ->join('carteras as c', 'c.id', 'crms.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('users as u', 'u.id', 'movimientos.user_id')
            ->join('devolution_sales as ds','ds.movimiento_id','movimientos.id')
            ->select('ds.id as idds',
            'movimientos.import as importe',
            'crms.type as carteramovtype',
            'crms.tipoDeMovimiento',
            'c.nombre as nombrecartera',
            'c.descripcion',
            'c.tipo as ctipo',
            'movimientos.updated_at as movcreacion',
            'movimientos.id as idmov')
            ->where('movimientos.status', 'ACTIVO')
            ->where('crms.type', 'EGRESO')
            ->where('crms.comentario','<>', 'RECAUDO DEL DIA')
            ->where('crms.tipoDeMovimiento', 'VENTA')
            ->where('ca.sucursal_id',$this->sucursal)
            ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
            ->orderBy('movimientos.updated_at', 'asc')
           ->get();
    
           
    
    
           
            //Totales Egresos (EGRESOS/INGRESOS)
           $this->totalesEgresosIE = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
           ->join('carteras as c', 'c.id', 'crms.cartera_id')
           ->join('cajas as ca', 'ca.id', 'c.caja_id')
           ->join('users as u', 'u.id', 'movimientos.user_id')
           ->select(
               'movimientos.import as importe',
               'crms.type as carteramovtype',
               'crms.tipoDeMovimiento',
               'c.nombre as nombrecartera',
               'c.descripcion',
               'c.tipo as ctipo',
               'c.telefonoNum',
               'movimientos.updated_at as movcreacion',
               'movimientos.id as idmov')
           ->where('movimientos.status', 'ACTIVO')
           ->where('crms.type', 'EGRESO')
           ->where('crms.comentario','<>', 'RECAUDO DEL DIA')
           ->where('crms.tipoDeMovimiento' , 'EGRESO/INGRESO')
           ->where('ca.sucursal_id',$this->sucursal)
           ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
           ->orderBy('movimientos.updated_at', 'asc')
           ->get();
           $this->trsbydatesucursal();
           $this->operaciones();
            }
            else
            {
                   //Totales Ingresos Ventas
            $this->totalesIngresosV = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
            ->join('carteras as c', 'c.id', 'crms.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('users as u', 'u.id', 'movimientos.user_id')
            ->join('sales as s','s.movimiento_id','movimientos.id')
            ->select('s.id as idventa',
            'movimientos.import as importe',
            'crms.type as carteramovtype',
            'crms.tipoDeMovimiento',
            'c.nombre as nombrecartera',
            'c.descripcion',
            'c.tipo as ctipo',
            'movimientos.updated_at as movcreacion',
            'movimientos.id as idmov',DB::raw('0 as detalle'),DB::raw('0 as utilidadventa'))
            ->where('movimientos.status', 'ACTIVO')
            ->where('crms.type', 'INGRESO')
            ->where('crms.comentario','<>', 'RECAUDO DEL DIA')
            ->where('crms.tipoDeMovimiento', 'VENTA')
            ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
            ->orderBy('movimientos.updated_at', 'asc')
            ->get();
        foreach ($this->totalesIngresosV as $val)
            {
                $vs=$this->listardetalleventas($val->idventa);
            
                $val->detalle=$vs;
                
            }
    
            foreach ($this->totalesIngresosV as $var) 
            {
               $var->utilidadventa = $this->utilidadventa($var->idventa);
    
            }
    
    
    
    
            //Totales Ingresos Servicios
            $this->totalesIngresosS = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
            ->join('carteras as c', 'c.id', 'crms.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('users as u', 'u.id', 'movimientos.user_id')
            ->select(
                'movimientos.import as importe',
                'crms.type as carteramovtype',
                'crms.tipoDeMovimiento',
                'c.nombre as nombrecartera',
                'c.descripcion',
                'c.tipo as ctipo',
                'c.telefonoNum',
                'movimientos.updated_at as movcreacion',
                'movimientos.id as idmov',
                DB::raw('0 as utilidadservicios'))
            ->where('movimientos.status', 'ACTIVO')
            ->where('crms.type', 'INGRESO')
            ->where('crms.comentario','<>', 'RECAUDO DEL DIA')
            ->where('crms.tipoDeMovimiento', '!=' , 'TIGOMONEY')
            ->where('crms.tipoDeMovimiento', '!=' , 'STREAMING')
            ->where('crms.tipoDeMovimiento', '!=' , 'VENTA')
            ->where('crms.tipoDeMovimiento', '!=' , 'EGRESO/INGRESO')
            ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
            ->orderBy('movimientos.updated_at', 'asc')
            ->get();
    
            foreach ($this->totalesIngresosS as $var1) 
            {
               $var1->utilidadservicios = $this->utilidadservicio($var1->idmov);
    
            }
            
    
    
    
            //Totales Ingresos (EGRESOS/INGRESOS)
            $this->totalesIngresosIE = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
            ->join('carteras as c', 'c.id', 'crms.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('users as u', 'u.id', 'movimientos.user_id')
            ->select(
                'movimientos.import as importe',
                'crms.type as carteramovtype',
                'crms.tipoDeMovimiento',
                'c.nombre as nombrecartera',
                'c.descripcion',
                'c.tipo as ctipo',
                'c.telefonoNum',
                'movimientos.updated_at as movcreacion',
                'movimientos.id as idmov')
            ->where('movimientos.status', 'ACTIVO')
            ->where('crms.type', 'INGRESO')
            ->where('crms.comentario','<>', 'RECAUDO DEL DIA')
            ->where('crms.tipoDeMovimiento' , 'EGRESO/INGRESO')
            ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
            ->orderBy('movimientos.updated_at', 'asc')
            ->get();
    
    
    
            //TOTALES EGRESOS
            
            //Totales Egresos Ventas
            $this->totalesEgresosV = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
            ->join('carteras as c', 'c.id', 'crms.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('users as u', 'u.id', 'movimientos.user_id')
            ->join('devolution_sales as ds','ds.movimiento_id','movimientos.id')
            ->select('ds.id as idds',
            'movimientos.import as importe',
            'crms.type as carteramovtype',
            'crms.tipoDeMovimiento',
            'c.nombre as nombrecartera',
            'c.descripcion',
            'c.tipo as ctipo',
            'movimientos.updated_at as movcreacion',
            'movimientos.id as idmov')
            ->where('movimientos.status', 'ACTIVO')
            ->where('crms.type', 'EGRESO')
            ->where('crms.comentario','<>', 'RECAUDO DEL DIA')
            ->where('crms.tipoDeMovimiento', 'VENTA')
            ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
            ->orderBy('movimientos.updated_at', 'asc')
           ->get();
    
           
    
    
           
            //Totales Egresos (EGRESOS/INGRESOS)
           $this->totalesEgresosIE = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
           ->join('carteras as c', 'c.id', 'crms.cartera_id')
           ->join('cajas as ca', 'ca.id', 'c.caja_id')
           ->join('users as u', 'u.id', 'movimientos.user_id')
           ->select(
               'movimientos.import as importe',
               'crms.type as carteramovtype',
               'crms.tipoDeMovimiento',
               'c.nombre as nombrecartera',
               'c.descripcion',
               'c.tipo as ctipo',
               'c.telefonoNum',
               'movimientos.updated_at as movcreacion',
               'movimientos.id as idmov')
           ->where('movimientos.status', 'ACTIVO')
           ->where('crms.type', 'EGRESO')
           ->where('crms.comentario','<>', 'RECAUDO DEL DIA')
           ->where('crms.tipoDeMovimiento' , 'EGRESO/INGRESO')
           ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
           ->orderBy('movimientos.updated_at', 'asc')
           ->get();
           $this->trsbydatetodos();
           $this->operaciones();
            }
         }
 
     }
     public function listardetalleventas($idventa)
     {
         $listadetalles = SaleDetail::join('sales as s', 's.id', 'sale_details.sale_id')
         ->join("products as p", "p.id", "sale_details.product_id")
         ->select('p.nombre as nombre','sale_details.price as pv',
         'p.precio_venta as precioventa','sale_details.quantity as cant')
         ->where('sale_details.sale_id', $idventa)
         ->orderBy('sale_details.id', 'asc')
         ->get();

         return $listadetalles;
         //dd($this->listadetalles);
     }
     public function utilidadventa($idventa)
     {
         $utilidadventa = Sale::join('sale_details as sd', 'sd.sale_id', 'sales.id')
         ->join('products as p', 'p.id', 'sd.product_id')
         ->select('sd.quantity as cantidad','sd.price as precio','p.costo as costoproducto')
         ->where('sales.id', $idventa)
         ->get();
 
         $utilidad = 0;
 
         foreach ($utilidadventa as $item)
         {
             $utilidad = $utilidad + ($item->cantidad * $item->precio) - ($item->cantidad * $item->costoproducto);
         }
 
  
         return $utilidad;
     }
     public function utilidadservicio($idmovimiento)
     {
        
         $serv = Service::join('mov_services as m', 'm.service_id', 'services.id')
                 ->join('movimientos','movimientos.id','m.movimiento_id')
                 ->where('movimientos.id',$idmovimiento)
                 ->select('movimientos.import as ms','services.costo as mc')
                 ->get();
 
         $utilidad2=$serv[0]->ms- $serv[0]->mc;
       
         
        return $utilidad2;
     }

     public function operaciones()
     {
        //Totales carteras
        
        $this->ingresosTotales = $this->totalesIngresosV->sum('importe') + $this->totalesIngresosS->sum('importe') + $this->totalesIngresosIE->sum('importe')+ $this->total;

        //Totales carteras tipo Caja Fisica
        $this->ingresosTotalesCF = $this->totalesIngresosV->where('ctipo','CajaFisica')->sum('importe') + $this->totalesIngresosS->where('ctipo','CajaFisica')->sum('importe') + $this->totalesIngresosIE->where('ctipo','CajaFisica')->sum('importe');
        
        //Totales carteras tipo No Caja Fisica SIN BANCOS
        $this->ingresosTotalesNoCFNoBancos = $this->totalesIngresosV->where('ctipo','!=','CajaFisica')->where('ctipo','!=','Banco')->sum('importe') + $this->totalesIngresosS->where('ctipo','!=','CajaFisica')->where('ctipo','!=','Banco')->sum('importe') + $this->totalesIngresosIE->where('ctipo','!=','CajaFisica')->where('ctipo','!=','Banco')->sum('importe');

        //Totales carteras tipo No Caja Fisica CON BANCOS

        $this->ingresosTotalesNoCFBancos = $this->totalesIngresosV->where('ctipo','=','Banco')->sum('importe') + $this->totalesIngresosS->where('ctipo','=','Banco')->sum('importe') + $this->totalesIngresosIE->where('ctipo','=','Banco')->sum('importe');
      



        //Total Utilidad Ventas y Servicios
        $this->totalutilidadSV = $this->totalesIngresosV->sum('utilidadventa') + $this->totalesIngresosS->sum('utilidadservicios');




        //Total Egresos
        $this->EgresosTotales = $this->totalesEgresosV->sum('importe') + $this->totalesEgresosIE->sum('importe');
        // egresos totales por caja fisica
        $this->EgresosTotalesCF = $this->totalesEgresosV->where('ctipo','CajaFisica')->sum('importe') + $this->totalesEgresosIE->where('ctipo','CajaFisica')->sum('importe');

         // egresos totales por bancos
         $this->EgresosTotalesNoCFNoBancos = $this->totalesEgresosV->where('ctipo','!=','CajaFisica')->where('ctipo','!=','Banco')->sum('importe') + $this->totalesEgresosIE->where('ctipo','!=','CajaFisica')->where('ctipo','!=','Banco')->sum('importe');

      // egresos totales por bancos

         $this->EgresosTotalesNoCFBancos = $this->totalesEgresosV->where('ctipo','=','Banco')->sum('importe') + $this->totalesEgresosIE->where('ctipo','=','Banco')->sum('importe');
        //Total Transacciones Banco, Tigo, Sistema, Streaming
        //$this->TotalTransccioneSistema=  $this->totalesEgresos->where('ctipo','!=','CajaFisica')->sum('importe');





        //$this->operacionefectivoeg= $this->totalesEgresos->where('ctipo','CajaFisica')->sum('importe');

        //Ingresos - Egresos
        $this->subtotalcaja= $this->ingresosTotales - $this->EgresosTotales;
        $this->operacionesefectivas= $this->ingresosTotalesCF + $this->total-$this->EgresosTotalesCF;
        $this->operacionesW= $this->operacionesefectivas + $this->ops;

     }

     public function allop($fecha,$sucursal,$caja){


         $fechainicial= Carbon::parse('2015-01-01')->format('Y-m-d') . ' 00:00:00';

         if ($caja != 'TODAS') {
            $carteras = Cartera::where('carteras.tipo','CajaFisica')
            ->where('caja_id', $caja)
            ->where('carteras.tipo','CajaFisica')
            ->select('id', 'nombre', 'descripcion', DB::raw('0 as monto'))->get();
         }

         else{
            if ($sucursal != 'TODAS') {
                $carteras = Cartera::join('cajas','cajas.id','carteras.caja_id')
                ->where('carteras.tipo','CajaFisica')
                ->where('cajas.sucursal_id',$sucursal)
                ->select('carteras.id as id', DB::raw('0 as monto'))->get();
            }
            else{
                $carteras = Cartera::where('carteras.tipo','CajaFisica')->select('id', 'nombre', 'descripcion', DB::raw('0 as monto'))->get();
            }
         }


     
        foreach ($carteras as $c) {
            /* SUMAR TODO LOS INGRESOS DE LA CARTERA */
            $MONTO = Cartera::join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
                ->join('movimientos as m', 'm.id', 'cm.movimiento_id')
                ->where('cm.type', 'INGRESO')
                ->where('m.status', 'ACTIVO')
                ->whereBetween('m.created_at',[$fechainicial,$fecha])
                ->where('carteras.id', $c->id)->sum('m.import');
            /* SUMAR TODO LOS EGRESOS DE LA CARTERA */
            $MONTO2 = Cartera::join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
                ->join('movimientos as m', 'm.id', 'cm.movimiento_id')
                ->where('cm.type', 'EGRESO')
                ->where('m.status', 'ACTIVO')
                ->whereBetween('m.created_at',[$fechainicial,$fecha])
                ->where('carteras.id', $c->id)->sum('m.import');
            /* REALIZAR CALCULO DE INGRESOS - EGRESOS */
            $c->monto = $MONTO - $MONTO2;
        } 

        $this->ops= $carteras->sum('monto');
        
    
      
       


    }
   
    //Obtener el Id de la Sucursal Donde esta el Usuario
    public function idsucursal()
    {
        $this->idsucursal = User::join("sucursal_users as su","su.user_id","users.id")
        ->select("su.sucursal_id as id","users.name as n")
        ->where("users.id",Auth()->user()->id)
        ->where("su.estado","ACTIVO")
        ->get()
        ->first();
        return $this->idsucursal->id;
    }

    public function GenerarR()
    {
        $rules = [ /* Reglas de validacion */
          
            'cartera_id' => 'required|not_in:Elegir',
            'cantidad' => 'required|not_in:0',
         
        ];
        $messages = [ /* mensajes de validaciones */
           
            'cartera_id.not_in' => 'Seleccione un valor distinto a Elegir',
            'cartera_id.not_in' => 'Seleccione un valor distinto a Elegir',
            'cantidad.required' => 'Ingrese un monto válido',
            'cantidad.not_in' => 'Ingrese un monto válido',
           
        ];

        $this->validate($rules, $messages);

        $mvt = Movimiento::create([
            'type' => 'TERMINADO',
            'status' => 'ACTIVO',
            'import' => $this->cantidad,
            'user_id' => Auth()->user()->id,
        ]);

        CarteraMov::create([
            'type' => 'EGRESO',
            'tipoDeMovimiento' => 'EGRESO/INGRESO',
            'comentario' => 'RECAUDO DEL DIA',
            'cartera_id' => $this->cartera_id,
            'movimiento_id' => $mvt->id
        ]);

        $this->emit('hide-modalR', 'SE GENERO EL RECAUDO');
        $this->resetUI();
    }
    public function viewDetailsR()
    {
        $this->emit('show-modalR', 'open modal');
    }
    public function resetUI()
    {
        $this->cartera_id = 'Elegir';
        $this->type = 'Elegir';
        $this->cantidad = '';
        $this->comentario = '';
    }

    public function trsbydatecaja()
    {
        $from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($this->toDate)->format('Y-m-d')     . ' 23:59:59';

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
    public function trsbydatesucursal()
    {
        $from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($this->toDate)->format('Y-m-d')     . ' 23:59:59';

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

    public function trsbydatetodos()
    {
        $from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($this->toDate)->format('Y-m-d')     . ' 23:59:59';

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

    public function generarpdf($totalesIngresosV, $totalesIngresosS, $totalesIngresosIE, $totalesEgresosV, $totalesEgresosIE)
    {
        session(['totalIngresosV' => $totalesIngresosV]);
        session(['totalIngresosS' => $totalesIngresosS]);
        session(['totalIngresosIE' => $totalesIngresosIE]);
        session(['totalEgresosV' => $totalesEgresosV]);
        session(['totalEgresosIE' => $totalesEgresosIE]);



        
        session(['ingresosTotales' => $this->ingresosTotales]);
        session(['ingresosTotalesCF' => $this->ingresosTotalesCF]);
        session(['ingresosTotalesNoCFNoBancos' => $this->ingresosTotalesNoCFNoBancos]);
        session(['ingresosTotalesNoCFBancos' => $this->ingresosTotalesNoCFBancos]);
        session(['total' => $this->total]);
        session(['EgresosTotales' => $this->EgresosTotales]);
        session(['EgresosTotalesCF' => $this->EgresosTotalesCF]);
        session(['EgresosTotalesNoCFNoBancos' => $this->EgresosTotalesNoCFNoBancos]);
        session(['EgresosTotalesNoCFBancos' => $this->EgresosTotalesNoCFBancos]);
        session(['subtotalcaja' => $this->subtotalcaja]);
        session(['operacionesefectivas' => $this->operacionesefectivas]);
        session(['ops' => $this->ops]);
        session(['operacionesW' => $this->operacionesW]);


        //Redireccionando para crear el comprobante con sus respectvas variables
        return redirect::to('report/pdfmovdiaresumen');
    }
}
