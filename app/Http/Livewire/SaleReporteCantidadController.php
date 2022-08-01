<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Sucursal;
use Carbon\Carbon;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use App\Models\SaleDetail;

class SaleReporteCantidadController extends Component
{
    public $sucursal_id, $user_id, $nombreusuario;


    public $dateFrom, $dateTo;


    //Lista de productos con descuento de un usuario determinado
    public $lista_productos_con_descuentos;

    public function mount()
    {
        $this->sucursal_id = 'Todos';
        $this->user_id = null;
        //$this->sucursal_id = $this->idsucursal();
        $this->lista_productos_con_descuentos = null;
        $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');


    }
    public function render()
    {





        //Listar las sucursales
        $listasucursales = Sucursal::all();

        $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($this->dateTo)->format('Y-m-d')     . ' 23:59:59';


       if($this->sucursal_id == 'Todos')
       {
            $listausuarios = User::join('sales as s', 's.user_id', 'users.id')
            ->join('sucursal_users as su', 'su.user_id', 'users.id')
            ->select('users.id as idusuario','users.name as nombreusuario', DB::raw('0 as totalbs'), DB::raw('0 as totaldescuento'), DB::raw('0 as totalrecargo')
            , DB::raw('0 as totalutilidad'))
            ->whereBetween('s.created_at', [$from, $to])
            ->where('su.estado', 'ACTIVO')
            ->where('users.status', 'ACTIVE')
            ->groupBy('users.id')
            ->get();
       }
       else
       {
            $listausuarios = User::join('sales as s', 's.user_id', 'users.id')
            ->join('sucursal_users as su', 'su.user_id', 'users.id')
            ->select('users.id as idusuario','users.name as nombreusuario', DB::raw('0 as totalbs'), DB::raw('0 as totaldescuento'), DB::raw('0 as totalrecargo')
            , DB::raw('0 as totalutilidad'))
            ->whereBetween('s.created_at', [$from, $to])
            ->where('su.sucursal_id',$this->sucursal_id)
            ->where('su.estado', 'ACTIVO')
            ->where('users.status', 'ACTIVE')
            ->groupBy('users.id')
            ->get();
       }


        foreach ($listausuarios as $ser)
        {
            $ser->totalbs = $this->totalventabs($ser->idusuario, $from, $to);
            $ser->totaldescuento = $this->totaldescuento($ser->idusuario, $from, $to);
            $ser->totalrecargo = $this->totalrecargo($ser->idusuario, $from, $to);
            $ser->totalutilidad = $this->totalutilidad($ser->idusuario, $from, $to);
        }


        if($this->user_id != null)
        {
            $this->buscar_productos_descuentos($this->user_id);
        }


        return view('livewire.salereports.reporteusuariosventascantidad', [
            'listausuarios' => $listausuarios,
            'listasucursales' => $listasucursales,
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    //Total descuento la variable $listausuarios en el render
    public function totaldescuento($idusuario, $from, $to)
    {
        $data = Sale::select('sales.id as idventa')
        ->where('sales.status','PAID')
        ->where('sales.user_id', $idusuario)
        ->whereBetween('sales.created_at', [$from, $to])
        ->get();


        $td = 0;

        foreach($data as $d)
        {
            $td = $this->obtenertotaldescuento($d->idventa) + $td;
        }
        return $td;
    }

    //Obtener el total descuento de una venta
    public function obtenertotaldescuento($idventa)
    {
        $descuento = SaleDetail::join("products as p", "p.id", "sale_details.product_id")
        ->select('p.nombre as nombre','p.precio_venta as po',
        'sale_details.price as pv','sale_details.quantity as cantidad')
        ->where('sale_details.sale_id', $idventa)
        ->get();

        $totaldescuento = 0;
        foreach($descuento as $d)
        {
            if((($d->pv - $d->po) * $d->cantidad) < 0)
            {
                $totaldescuento = (($d->pv - $d->po) * $d->cantidad) + $totaldescuento;
            }
        }
        return $totaldescuento;
    }


    //Total descuento la variable $listausuarios en el render
    public function totalrecargo($idusuario, $from, $to)
    {
        $data = Sale::join('users as u', 'u.id', 'sales.user_id')
        ->select('sales.id as idventa')
        ->where('sales.status','PAID')
        ->where('u.id', $idusuario)
        ->whereBetween('sales.created_at', [$from, $to])
        ->get();


        $dt = 0;

        foreach($data as $d)
        {
            $dt = $this->obtenertotalrecargo($d->idventa) + $dt;
        }



        return $dt;
    }

    //Obtener el total recargo de una venta
    public function obtenertotalrecargo($idventa)
    {
        $recargo = SaleDetail::join('sales as s', 's.id', 'sale_details.sale_id')
        ->join("products as p", "p.id", "sale_details.product_id")
        ->select('p.image as image','p.nombre as nombre','p.precio_venta as po',
        'sale_details.price as pv','sale_details.quantity as cantidad')
        ->where('sale_details.sale_id', $idventa)
        ->orderBy('sale_details.id', 'asc')
        ->get();

        $totalrecargo = 0;
        foreach($recargo as $d)
        {
            if((($d->pv - $d->po)*$d->cantidad) > 0)
            {
                $totalrecargo = (($d->pv - $d->po)*$d->cantidad) + $totalrecargo;
            }

        }
        return $totalrecargo;
    }



    //Total Bs de una Venta a travez de el id del usuario
    public function totalventabs($idusuario, $from, $to)
    {
        $data = Sale::join('users as u', 'u.id', 'sales.user_id')
            ->join("movimientos as m", "m.id", "sales.movimiento_id")
            ->join("cliente_movs as cm", "cm.movimiento_id", "m.id")
            ->join("clientes as c", "c.id", "cm.cliente_id")
            ->join("carteras as carts", "carts.id", "sales.cartera_id")
            ->select('sales.cash as totalbs')
            ->where('sales.status','PAID')
            ->where('u.id', $idusuario)
            ->whereBetween('sales.created_at', [$from, $to])
            ->get();

         $asd =  $data->sum('totalbs');


        return $asd;
    }


    public function totalutilidad($idusuario, $from, $to)
    {
        $data = Sale::join('users as u', 'u.id', 'sales.user_id')
        ->select('sales.id as idventa')
        ->where('sales.status','PAID')
        ->where('u.id', $idusuario)
        ->whereBetween('sales.created_at', [$from, $to])
        ->get();


        $td = 0;

        foreach($data as $d)
        {
            $td = $this->buscarutilidad($d->idventa) + $td;
        }



        return $td;
    }



    //Buscar la utilidad de una venta mediante el idventa
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

        return $utilidad;
    }


    //listar los productos con descuentos o recargos
    public function buscar_productos_descuentos($idusuario)
    {
        $this->user_id = $idusuario;

        if($this->user_id > 0)
        {
            $this->nombreusuario = User::find($this->user_id)->name;
        

            $a = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $b = Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59';

            $data = Sale::select('sales.id as idventa')
                ->where('sales.status','PAID')
                ->where('sales.user_id', $this->user_id)
                ->whereBetween('sales.created_at', [$a, $b])
                ->orderBy('sales.id','desc')
                ->get();

            $dsa[] = null;

            foreach ($data as $item)
            {
                $detalleventas = SaleDetail::select('sale_details.id as iddetalleventa')
                ->where('sale_details.sale_id', $item->idventa)
                ->get();
                foreach($detalleventas as $i)
                {
                    array_push($dsa, $this->listardetalleventas($i->iddetalleventa));
                }
            }


            $this->lista_productos_con_descuentos = $dsa;
        }
    }


    //Listar los detalles de una venta
    public function listardetalleventas($iddetalleventa)
    {
        $listadetalles = SaleDetail::join("sales as s", "s.id", "sale_details.sale_id")
        ->join("products as p", "p.id", "sale_details.product_id")
        ->select('p.id as idproducto','p.nombre as nombreproducto','p.precio_venta as po','sale_details.quantity as cantidad',
        'sale_details.price as pv','s.created_at as fecha','sale_details.quantity as cantidad','sale_details.sale_id as idventa')
        ->where('sale_details.id', $iddetalleventa)
        ->orderBy('sale_details.created_at', 'desc')
        ->get()
        ->first();
        //dd($listadetalles);
        
        return $listadetalles;
    }




    

    //Obtener el Id de la Sucursal Donde esta el Usuario
    public function idsucursal()
    {
        $idsucursal = User::join("sucursal_users as su","su.user_id","users.id")
        ->select("su.sucursal_id as id","users.name as n")
        ->where("users.id",Auth()->user()->id)
        ->where("su.estado","ACTIVO")
        ->get()
        ->first();
        return $idsucursal->id;
    }
}
