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
    public $sucursal_id;


    public $dateFrom, $dateTo;

    public function mount()
    {
        $this->sucursal_id = $this->idsucursal();
        
        $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
    }
    public function render()
    {
        //Listar las sucursales
        $listasucursales = Sucursal::all();

        $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($this->dateTo)->format('Y-m-d')     . ' 23:59:59';


        $listausuarios = User::join('sales as s', 's.user_id', 'users.id')
        ->join('sucursal_users as su', 'su.user_id', 'users.id')
        ->select('users.id as idusuario','users.name as nombreusuario', DB::raw('0 as totalbs'), DB::raw('0 as totaldescuento'))
        ->whereBetween('s.created_at', [$from, $to])
        ->where('su.sucursal_id',$this->sucursal_id)
        ->where('su.estado', 'ACTIVO')
        ->where('users.status', 'ACTIVE')
        ->groupBy('users.id')
        ->get();


        foreach ($listausuarios as $ser)
        {
            $ser->totalbs = $this->totalventabs($ser->idusuario, $from, $to);
            $ser->totaldescuento = $this->totaldescuento($ser->idusuario, $from, $to);
        }



        return view('livewire.salereports.reporteusuariosventascantidad', [
            'listausuarios' => $listausuarios,
            'listasucursales' => $listasucursales,
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }


    public function totaldescuento($idusuario, $from, $to)
    {
        $data = Sale::join('users as u', 'u.id', 'sales.user_id')
        ->select('sales.id as idventa')
        ->where('u.id', $idusuario)
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
        $descuento = SaleDetail::join('sales as s', 's.id', 'sale_details.sale_id')
        ->join("products as p", "p.id", "sale_details.product_id")
        ->select('p.image as image','p.nombre as nombre','p.precio_venta as po',
        'sale_details.price as pv','sale_details.quantity as cantidad')
        ->where('sale_details.sale_id', $idventa)
        ->orderBy('sale_details.id', 'asc')
        ->get();

        $totaldescuento = 0;
        foreach($descuento as $d)
        {
            $totaldescuento = (($d->pv - $d->po)*$d->cantidad) + $totaldescuento;
        }
        $a = $totaldescuento * -1;
        return $a;
    }



    //Obtener el Id de la Sucursal Donde esta el Usuario
    public function totalventabs($idusuario, $from, $to)
    {
        $data = Sale::join('users as u', 'u.id', 'sales.user_id')
            ->join("movimientos as m", "m.id", "sales.movimiento_id")
            ->join("cliente_movs as cm", "cm.movimiento_id", "m.id")
            ->join("clientes as c", "c.id", "cm.cliente_id")
            ->join("carteras as carts", "carts.id", "sales.cartera_id")
            ->select('sales.cash as totalbs')
            ->where('u.id', $idusuario)
            ->whereBetween('sales.created_at', [$from, $to])
            ->get();

         $asd =  $data->sum('totalbs');


        return $asd;
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
