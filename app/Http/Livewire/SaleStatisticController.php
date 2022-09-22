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
    //Guarda el id del usuario seleccionada
    public $usuario_id;
    //Guarda el año seleccionado donde se mostrara las ventas
    public $year;

    //Meses en donde se almacenará el total de ventas de ese mes
    public $enero, $febrero, $marzo, $abril, $mayo, $junio, $julio, $agosto, $septiembre, $octubre, $noviembre, $diciembre;


    public function mount()
    {
        $this->year = 2022;
        $this->sucursal_id = $this->idsucursal();
    }
    public function render()
    {
        //Cargando los graficos cada que carga el render
        $this->emit('cargar-grafico');
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

        //CALCULANDO EL TOTAL BS EN LAS VENTAS POR CADA MES


        $this->enero = Sale::whereYear('sales.created_at', $this->year)
        ->whereMonth('sales.created_at', '01')
        ->sum('total');
        $this->febrero = Sale::whereYear('sales.created_at', $this->year)
        ->whereMonth('sales.created_at', '02')
        ->sum('total');
        $this->marzo = Sale::whereYear('sales.created_at', $this->year)
        ->whereMonth('sales.created_at', '03')
        ->sum('total');
        $this->abril = Sale::whereYear('sales.created_at', $this->year)
        ->whereMonth('sales.created_at', '04')
        ->sum('total');
        $this->mayo = Sale::whereYear('sales.created_at', $this->year)
        ->whereMonth('sales.created_at', '05')
        ->sum('total');
        $this->junio = Sale::whereYear('sales.created_at', $this->year)
        ->whereMonth('sales.created_at', '06')
        ->sum('total');
        $this->julio = Sale::whereYear('sales.created_at', $this->year)
        ->whereMonth('sales.created_at', '07')
        ->sum('total');
        $this->agosto = Sale::whereYear('sales.created_at', $this->year)
        ->whereMonth('sales.created_at', '08')
        ->sum('total');
        $this->septiembre = Sale::whereYear('sales.created_at', $this->year)
        ->whereMonth('sales.created_at', '09')
        ->sum('total');
        $this->octubre = Sale::whereYear('sales.created_at', $this->year)
        ->whereMonth('sales.created_at', '10')
        ->sum('total');
        $this->noviembre = Sale::whereYear('sales.created_at', $this->year)
        ->whereMonth('sales.created_at', '11')
        ->sum('total');
        $this->diciembre = Sale::whereYear('sales.created_at', $this->year)
        ->whereMonth('sales.created_at', '12')
        ->sum('total');



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

}
