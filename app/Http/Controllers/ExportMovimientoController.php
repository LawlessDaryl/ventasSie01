<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Cliente;
use App\Models\DetalleTransferencia;
use App\Models\EstadoTransferencia;
use App\Models\Movimiento;
use App\Models\Service;
use App\Models\Sucursal;
use App\Models\Transference;
use Maatwebsite\Excel\Facades\Excel;


class ExportMovimientoController extends Controller
{
    public $utilidadtotal;
    public function printPdf()
    {
     
        $fecha_inicio=session('fecha_movimiento_inicio');
        $fecha_fin=session('fecha_movimiento_fin');

        $this->utilidadtotal=0;
    $vertotales=1;
    $totalesIngresos = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
    ->join('carteras as c', 'c.id', 'crms.cartera_id')
    ->join('cajas as ca', 'ca.id', 'c.caja_id')
    ->join('users as u', 'u.id', 'movimientos.user_id')
    ->select(
        'movimientos.type as movimientotype',
        'movimientos.import as mimpor',
        'crms.type as carteramovtype',
        'crms.tipoDeMovimiento',
        'crms.comentario',
        'c.nombre',
        'c.descripcion',
        'c.tipo as ctipo',
        'c.telefonoNum',
        'ca.nombre as cajaNombre',
        'u.name as usuarioNombre',
        'movimientos.created_at as movimientoCreacion',
        'movimientos.id as movid'
    )
    ->where('movimientos.status', 'ACTIVO')
    ->where('crms.type', 'INGRESO')
    ->where('crms.tipoDeMovimiento', '!=' , 'TIGOMONEY')
    ->where('crms.tipoDeMovimiento', '!=' , 'STREAMING')
    ->whereBetween('movimientos.created_at',[ $fecha_inicio,$fecha_fin])
    ->orderBy('crms.tipoDeMovimiento', 'asc')
  
    
    ->get();

    $importetotalingresos= $totalesIngresos->sum('mimpor');
    $operacionefectivoing= $totalesIngresos->where('ctipo','CajaFisica')->sum('mimpor');
    $noefectivoing=$totalesIngresos->where('ctipo','!=','CajaFisica')->sum('mimpor');


    $totalesEgresos = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
    ->join('carteras as c', 'c.id', 'crms.cartera_id')
    ->join('cajas as ca', 'ca.id', 'c.caja_id')
    ->join('users as u', 'u.id', 'movimientos.user_id')
    ->select(
        'movimientos.type as movimientotype',
        'movimientos.import as mimpor',
        'crms.type as carteramovtype',
        'crms.tipoDeMovimiento',
        'crms.comentario',
        'c.nombre',
        'c.descripcion',
        'c.tipo as ctipo',
        'c.telefonoNum',
        'ca.nombre as cajaNombre',
        'u.name as usuarioNombre',
        'movimientos.created_at as movimientoCreacion',
    )
    ->where('movimientos.status', 'ACTIVO')
    ->where('crms.type', 'EGRESO')
    ->where('crms.tipoDeMovimiento', '!=' , 'TIGOMONEY')
    ->where('crms.tipoDeMovimiento', '!=' , 'STREAMING')
    ->whereBetween('movimientos.created_at',[ $fecha_inicio,$fecha_fin])
    ->orderBy('crms.tipoDeMovimiento', 'asc')
  
    
    ->get();

    foreach ($totalesIngresos as $var) {
        if($var->tipoDeMovimiento == 'VENTA')
         $this->utilidadtotal= $this->utilidadtotal+($this->buscarutilidad($this->buscarventa($var->movid)->first()->idventa)) ;
        elseif($var->tipoDeMovimiento == 'SERVICIOS')
        $this->utilidadtotal= $this->utilidadtotal+ ($this->buscarservicio($var->movid));


    }


    $importetotalegresos= $totalesEgresos->sum('mimpor');
    $operacionefectivoeg= $totalesEgresos->where('ctipo','CajaFisica')->sum('mimpor');
    $noefectivoeg=  $totalesEgresos->where('ctipo','!=','CajaFisica')->sum('mimpor');
    $subtotalcaja= $importetotalingresos-$importetotalegresos;
   // $this->utilidadtotal=$this->utilidadtotal+0;





       
      
        $pdf = PDF::loadView('livewire.pdf.reportemovimientopdf', compact('totalesIngresos','operacionefectivoeg',$this->utilidadtotal,'subtotalcaja','noefectivoeg','totalesEgresos','importetotalingresos','importetotalegresos','operacionefectivoing','noefectivoing'));

        return $pdf->stream('movimiento.pdf');  
    }

    public function buscarutilidad($idventa)
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

        $this->utilidadtotal=$this->utilidadtotal+$utilidad;
        return $utilidad;
    }
    public function buscarventa($idmovimiento)
    {
        $venta = Sale::join('movimientos as m', 'm.id', 'sales.movimiento_id')
                ->select('sales.id as idventa')
                ->where('sales.movimiento_id',$idmovimiento)
                ->get();
        return $venta;
    }

    public function buscarservicio($idmovimiento)
    {
       
        $serv = Service::join('mov_services as m', 'm.service_id', 'services.id')
                ->join('movimientos','movimientos.id','m.movimiento_id')
                ->where('movimientos.id',$idmovimiento)
                ->select('movimientos.import as ms','services.costo as mc')
                ->get();

        $utilidad2=$serv[0]->ms- $serv[0]->mc;
        $this->utilidadtotal=$this->utilidadtotal+$utilidad2;
        
       return $utilidad2;
    }

}
