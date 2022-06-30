<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Movimiento;
use App\Models\SaleDetail;
use App\Models\Sucursal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReporteMovimientoResumenController extends Component
{
    public $idsucursal,$totalesIngresos,$totalesEgresos,$fromDate,$toDate,$cartera_id, $type, $cantidad, $comentario,$vertotales=0,$importetotalingresos,$importetotalegresos,
    $operacionefectivoing,$noefectivo,$operacionefectivoeg,$noefectivoeg,$subtotalcaja,$utilidadtotal=5,$caja,$ops,$sucursal;
    public function mount()
    {
        $this->idsucursal = $this->idsucursal();
        $this->fromDate= Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->toDate=  Carbon::parse(Carbon::now())->format('Y-m-d');

    }
    public function render()
    {
        
       
        $carterasSucursal=0;
        $this->viewTotales();
        return view('livewire.reportemovimientoresumen.reportemovimientoresumen', [
            'carterasSucursal' => $carterasSucursal,
            'sucursales'=>Sucursal::all(),
            'cajas'=>Caja::where('cajas.sucursal_id',$this->sucursal)->get()

        ])
            ->extends('layouts.theme.app')
            ->section('content');
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
    public function viewTotales()
    {
        //
         $this->utilidadtotal=0;
      
         if ($this->idsucursal == 'TODAS')
         {


            $this->totalesIngresosV = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
            ->join('carteras as c', 'c.id', 'crms.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('users as u', 'u.id', 'movimientos.user_id')
            ->join('sales as s','s.movimiento_id','movimientos.id')
            ->join('sale_details as sd','sales.id','sd.sale_id')
            ->join("products as p", "p.id", "sd.product_id")
            ->select('s.id as idventa','p.id as idproducto','p.nombre as nombreproducto','sd.price as precioventa','sd.quantity as cantidad',
            'movimientos.import as importe',
            'crms.type as carteramovtype',
            'crms.tipoDeMovimiento',
            'c.nombre',
            'c.descripcion',
            'c.tipo as ctipo',
            'movimientos.updated_at as movcreacion',
            'movimientos.id as idmov')
            ->where('movimientos.status', 'ACTIVO')
            ->where('crms.type', 'INGRESO')
            ->where('crms.tipoDeMovimiento', 'VENTA')
            ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
            ->orderBy('crms.tipoDeMovimiento', 'asc')
           ->get();


           $this->totalesIngresosSIE = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
           ->join('carteras as c', 'c.id', 'crms.cartera_id')
           ->join('cajas as ca', 'ca.id', 'c.caja_id')
           ->join('users as u', 'u.id', 'movimientos.user_id')
           ->join('sales as s','s.movimiento_id','movimientos.id')
           ->join('sale_details as sd','sales.id','sd.sale_id')
           ->join("products as p", "p.id", "sd.product_id")
           ->select(
               'movimientos.import as importe',
               'crms.type as carteramovtype',
               'crms.tipoDeMovimiento',
               'c.nombre',
               'c.descripcion',
               'c.tipo as ctipo',
               'c.telefonoNum',
               'movimientos.updated_at as movcreacion',
               'movimientos.id as idmov'
           )
           ->where('movimientos.status', 'ACTIVO')
           ->where('crms.type', 'INGRESO')
           ->where('crms.tipoDeMovimiento', '!=' , 'TIGOMONEY')
           ->where('crms.tipoDeMovimiento', '!=' , 'STREAMING')
           ->where('crms.tipoDeMovimiento', '!=' , 'VENTA')
           ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
           ->orderBy('crms.tipoDeMovimiento', 'asc')
        ->get();



























 
            //  $this->totalesEgresos = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
            //  ->join('carteras as c', 'c.id', 'crms.cartera_id')
            //  ->join('cajas as ca', 'ca.id', 'c.caja_id')
            //  ->join('users as u', 'u.id', 'movimientos.user_id')
            //  ->join('sales as s','s.movimiento_id','movimientos.id')
            //  ->join('sale_details as sd','sales.id','sd.sale_id')
            //  ->join("products as p", "p.id", "sd.product_id")
            //  ->select('s.id as idventa','p.id as idproducto','p.nombre as nombreproducto','sd.price as precioventa','sd.quantity as cantidad')
            //  ->select(
            //      'movimientos.import as importe',
            //      'crms.type as carteramovtype',
            //      'crms.tipoDeMovimiento',
            //      'c.nombre',
            //      'c.descripcion',
            //      'c.tipo as ctipo',
            //      'c.telefonoNum',
            //      'movimientos.updated_at as movcreacion',
            //      'movimientos.id as idmov'
            //  )
            //  ->where('movimientos.status', 'ACTIVO')
            //  ->where('crms.type', 'INGRESO')
            //  ->where('crms.tipoDeMovimiento', '!=' , 'TIGOMONEY')
            //  ->where('crms.tipoDeMovimiento', '!=' , 'STREAMING')
            //  ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
            //  ->orderBy('crms.tipoDeMovimiento', 'asc')
         
             
            //  ->get();
         }
         else
         {
            
        //     $this->totalesIngresosV = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
        //     ->join('carteras as c', 'c.id', 'crms.cartera_id')
        //     ->join('cajas as ca', 'ca.id', 'c.caja_id')
        //     ->join('users as u', 'u.id', 'movimientos.user_id')
        //     ->join('sales as s','s.movimiento_id','movimientos.id')
        //     ->join('sale_details as sd','sales.id','sd.sale_id')
        //     ->join("products as p", "p.id", "sd.product_id")
        //     ->select('s.id as idventa','p.id as idproducto','p.nombre as nombreproducto','sd.price as precioventa','sd.quantity as cantidad',
        //     'movimientos.import as importe',
        //     'crms.type as carteramovtype',
        //     'crms.tipoDeMovimiento',
        //     'c.nombre',
        //     'c.descripcion',
        //     'c.tipo as ctipo',
        //     'movimientos.updated_at as movcreacion',
        //     'movimientos.id as idmov')
        //     ->where('movimientos.status', 'ACTIVO')
        //     ->where('crms.type', 'INGRESO')
        //     ->where('crms.tipoDeMovimiento', 'VENTA')
        //     ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
        //     ->orderBy('crms.tipoDeMovimiento', 'asc')
        //    ->get();
            
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
           'movimientos.id as idmov',DB::raw('0 as detalle'))
           ->where('movimientos.status', 'ACTIVO')
           ->where('crms.type', 'INGRESO')
           ->where('crms.tipoDeMovimiento', 'VENTA')
           ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
           ->orderBy('movimientos.updated_at', 'asc')
          ->get();
          $var="";
          $bn=0;
          foreach ($this->totalesIngresosV as $val) {
             $vs=$this->listardetalleventas($val->idventa);
             foreach ($vs as $hj) {
                 $var=$var.++$bn." ".$hj->nombre." ".$hj->pv. " ". $hj->cant;
                 $var=$var.'<br>';
             } 
             $val->detalle=$var;
             $var="";
             $bn=0;
          }


           $this->totalesIngresosSIE = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
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
               'movimientos.id as idmov'
           )
           ->where('movimientos.status', 'ACTIVO')
           ->where('crms.type', 'INGRESO')
           ->where('crms.tipoDeMovimiento', '!=' , 'TIGOMONEY')
           ->where('crms.tipoDeMovimiento', '!=' , 'STREAMING')
           ->where('crms.tipoDeMovimiento', '!=' , 'VENTA')
           ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
           ->orderBy('movimientos.updated_at', 'asc')
        ->get();

            // $this->totalesEgresos = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
            // ->join('carteras as c', 'c.id', 'crms.cartera_id')
            // ->join('cajas as ca', 'ca.id', 'c.caja_id')
            // ->join('users as u', 'u.id', 'movimientos.user_id')
            // ->join('sales as s','s.movimiento_id','movimientos.id')
            // ->join('sale_details as sd','sales.id','sd.sale_id')
            // ->join("products as p", "p.id", "sd.product_id")
            // ->select('s.id as idventa','p.id as idproducto','p.nombre as nombreproducto','sd.price as precioventa','sd.quantity as cantidad')
            // ->select(
            //     'movimientos.import as importe',
            //     'crms.type as carteramovtype',
            //     'crms.tipoDeMovimiento',
            //     'c.nombre',
            //     'c.descripcion',
            //     'c.tipo as ctipo',
            //     'c.telefonoNum',
            //     'movimientos.updated_at as movcreacion',
            //     'movimientos.id as idmov'
            // )
            // ->where('movimientos.status', 'ACTIVO')
            // ->where('crms.type', 'INGRESO')
            // ->where('crms.tipoDeMovimiento', '!=' , 'TIGOMONEY')
            // ->where('crms.tipoDeMovimiento', '!=' , 'STREAMING')
            // ->whereBetween('movimientos.updated_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
            // ->orderBy('crms.tipoDeMovimiento', 'asc')
        
            
            // ->get();
        }
        
       
        //  $this->allop(Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',$this->caja);
        //  $this->importetotalingresos= $this->totalesIngresos->sum('mimpor');
        //  $this->operacionefectivoing= $this->totalesIngresos->where('ctipo','CajaFisica')->sum('mimpor');
        //  $this->noefectivoing=$this->totalesIngresos->where('ctipo','!=','CajaFisica')->sum('mimpor');
 
 
        
        //  foreach ($this->totalesIngresos as $var) {
             
        //      if($var->tipoDeMovimiento == 'VENTA')
        //      $this->utilidadtotal= $this->utilidadtotal+($this->buscarutilidad($this->buscarventa($var->movid)->first()->idventa)) ;
        //      elseif($var->tipoDeMovimiento == 'SERVICIOS')
        //      $this->utilidadtotal= $this->utilidadtotal+ ($this->buscarservicio($var->movid));
 
        //  }
 
 
        //  $this->importetotalegresos= $this->totalesEgresos->sum('mimpor');
        //  $this->operacionefectivoeg= $this->totalesEgresos->where('ctipo','CajaFisica')->sum('mimpor');
        //  $this->noefectivoeg=  $this->totalesEgresos->where('ctipo','!=','CajaFisica')->sum('mimpor');
        //  $this->subtotalcaja= $this->importetotalingresos-$this->importetotalegresos;
     // $this->utilidadtotal=$this->utilidadtotal+0;
 
 
     }
     public function listardetalleventas($idventa)
     {
         $listadetalles = SaleDetail::join('sales as s', 's.id', 'sale_details.sale_id')
         ->join("products as p", "p.id", "sale_details.product_id")
         ->select('p.id as idproducto','p.image as image','p.nombre as nombre','p.precio_venta as pv',
         'sale_details.price as pv','sale_details.quantity as cant')
         ->where('sale_details.sale_id', $idventa)
         ->orderBy('sale_details.id', 'asc')
         ->get();

         return $listadetalles;
         //dd($this->listadetalles);
     }
 
}
