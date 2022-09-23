<?php

namespace App\Http\Livewire;

use App\Models\Sale;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\Component;

class SaleStatisticController extends Component
{
    //Guarda el id de una sucursal seleccionada
    public $sucursal_id;
    //Guarda el id del usuario seleccionado
    public $usuario_id;
    //Guarda el año seleccionado donde se mostrara las ventas
    public $year;
    //Array en donde se guardaran el total Bs de las ventas por cada mes
    public $meses;



    public function mount()
    {
        $this->year = 2022;
        $this->sucursal_id = $this->idsucursal();
        $this->usuario_id = "Todos";
        $this->meses = [];


    }
    public function render()
    {
        //Obteniendo todos los años en los que se haya realizado ventas
        $years_sales = Sale::select(
        // DB::raw("DATE_FORMAT(created_at,'%M %Y') as months"))
        DB::raw("DATE_FORMAT(created_at,'%Y') as year"))
        ->groupBy('year')
        ->get();




        //Listando los usuarios para ser seleccinados
        $listausuarios = User::select("users.*")
        ->where("users.status","ACTIVE")
        ->get();


        
        if($this->usuario_id != "Todos")
        {
            dd($this->sucursal_id);
        }

        
        return view('livewire.sales.salestatistic', [
            'listasucursales' => Sucursal::all(),
            'listausuarios' => $listausuarios,
            'years_sales' => $years_sales
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
    //Obtener el Id de la Sucursal donde esta el Usuario
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
    //Devuelve el total Bs de un mes en las ventas
    public function calcular_mes($month)
    {
        $mes_bs = Sale::join("carteras as c","c.id","sales.cartera_id")
        ->join("cajas as cj","cj.id","c.caja_id")
        ->where("cj.sucursal_id", $this->sucursal_id)
        ->whereYear('sales.created_at', $this->year)
        ->whereMonth('sales.created_at', $month)
        ->sum('total');
        return $mes_bs;
    }
    //
    public function aplicar_filtros()
    {
        for ($i=1; $i < 13; $i++)
        { 
            array_push($this->meses, $this->calcular_mes($i));
        }
        //Cargando los graficos cada que carga el render
        $this->emit('cargar-grafico');
    }


}
