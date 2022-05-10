<?php

namespace App\Http\Livewire;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\Component;

class SaleStatisticController extends Component
{
    public $numero;

    //Meses de las Ventas
    public $enero, $febrero, $marzo, $abril, $mayo, $junio, $julio, $agosto, $septiembre, $octubre, $noviembre, $diciembre;

    public $usuarioseleccionado;

    public function mount()
    {
        //$this->enero = 1000;
    }
    public function render()
    {

        $this->enero = $this->obtener_bs_mes(1);
        $this->febrero = $this->obtener_bs_mes(2);
        $this->marzo = $this->obtener_bs_mes(3);
        $this->abril = $this->obtener_bs_mes(4);
        $this->mayo = $this->obtener_bs_mes(5);
        $this->junio = $this->obtener_bs_mes(6);
        $this->julio = $this->obtener_bs_mes(7);
        $this->agosto = $this->obtener_bs_mes(8);
        $this->septiembre = $this->obtener_bs_mes(9);
        $this->octubre = $this->obtener_bs_mes(10);
        $this->noviembre = $this->obtener_bs_mes(11);
        $this->diciembre = $this->obtener_bs_mes(12);
        


        //Listando Todos los Usuarios
        $listausuarios = User::select("users.id as id","users.name as nombreusuario")
        ->get();



        return view('livewire.sales.salestatistic', [
            'listausuarios' => $listausuarios,
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
    //Obtener el total Ventas de un mes especifico
    public function obtener_bs_mes($mes_elegido)
    {
        $mes = 0;
        $consulta = Sale::select('sales.total as total','sales.created_at as fecha')
        ->where('sales.status', 'PAID')
        ->whereMonth('sales.created_at', $mes_elegido)
        ->whereYear('created_at', '2022')
        ->get();

        foreach($consulta as $item)
        {
            $mes = $item->total + $mes;
        }
        return $mes;
    }

    //Saber si el usuario tiene los permisos basicos para las ventas
    public function verificarpermisosventa($usuario)
    {
        $asd = User::find($usuario);
        //dd($usuario);
        if($asd->hasPermissionTo('Sales_Index'))
        {
            return true;
        }
        return false;
    }




}
