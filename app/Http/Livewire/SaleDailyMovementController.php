<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\CarteraMov;
use App\Models\Sale;
use App\Models\Sucursal;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SaleDailyMovementController extends Component
{
    //Variables para fecha inicio = $dateFrom
    //Variables para fecha fin = $dateTo
    //Variable para poder activar o desactivar las fechas de inicio y fin dependiendo del valor de $reportType
    public $dateFrom, $dateTo, $reportType;

    //Variable donde se almacenara la sucursal de donde se sacaran los reportes
    public $sucursal;
    //Variable donde se almacenara las ids de las cajas de las sucursales
    public $caja;

    use WithPagination;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->reportType = 0;
        $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');


        if($this->verificarpermiso())
        {
            $this->sucursal ='Todos';
        }
        else
        {
            $this->sucursal = $this->idsucursal();
        }
        $this->caja='Todos';



    }


    public function render()
    {

        if ($this->reportType == 0)
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        }
        else
        {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d')     . ' 23:59:59';
        }
        if ($this->reportType == 1 && ($this->dateFrom == '' || $this->dateTo == ''))
        {
            $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
            $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
            $this->emit('item', 'Hiciste algo incorrecto, la fecha se actualizó');
        }

        if ($this->dateFrom == "" || $this->dateTo == "")
        {
            $this->reportType = 0;
        }









        //Listar todas las sucursales de la empresa
        $sucursales = Sucursal::select('sucursals.id as idsucursal','sucursals.name as nombresucursal','sucursals.adress as direccionsucursal')->get();
        

        



        //Si el tipo de Reporte esta en Reportes del Dia, todas las consultas dentro de este IF estaran con la fecha de hoy
        //Caso contrario todas las consultas del ELSE estarán por un rango de fechas
        if ($this->reportType == 0)
        {
            if($this->sucursal=='Todos')
            {
                if($this->sucursal=='Todos' && $this->caja=='Todos')
                {
                    //Consulta para listar todas las cajas
                    $cajas = Caja::select('cajas.id as idcaja','cajas.nombre as nombrecaja')->get();
                    //Consulta para el reporte de movimiento diario con todas las sucursales
                    $data = CarteraMov::join('movimientos as m', 'm.id', 'cartera_movs.movimiento_id')
                    ->join("carteras as c", "c.id", "cartera_movs.cartera_id")
                    ->join("users as u", "u.id", "m.user_id")
                    ->join("cajas as ca", "ca.id", "c.caja_id")
                    ->join("sucursals as s", "s.id", "ca.sucursal_id")
                    ->select('cartera_movs.created_at as fecha','u.name as nombreusuario',
                    'cartera_movs.comentario as motivo','m.import as importe','ca.nombre as nombrecaja',
                    'cartera_movs.type as tipo','c.nombre as nombrecartera','s.name as nombresucursal','m.id as idmovimiento')
                    ->whereIn('cartera_movs.comentario', ['Venta', 'Devolución Venta','Por Venta Anulada'])
                    ->whereDate('cartera_movs.created_at', date('Y/m/d'))
                    ->orderBy('cartera_movs.created_at', 'asc')
                    ->get();
                }
                else
                {
                    //Consulta para listar todas las cajas
                    $cajas = Caja::select('cajas.id as idcaja','cajas.nombre as nombrecaja')->get();
                    //Consulta para listar el movimiento diario de una caja en específico
                    $data = CarteraMov::join('movimientos as m', 'm.id', 'cartera_movs.movimiento_id')
                    ->join("carteras as c", "c.id", "cartera_movs.cartera_id")
                    ->join("users as u", "u.id", "m.user_id")
                    ->join("cajas as ca", "ca.id", "c.caja_id")
                    ->join("sucursals as s", "s.id", "ca.sucursal_id")
                    ->select('cartera_movs.created_at as fecha','u.name as nombreusuario',
                    'cartera_movs.comentario as motivo','m.import as importe','ca.nombre as nombrecaja',
                    'cartera_movs.type as tipo','c.nombre as nombrecartera','s.name as nombresucursal','m.id as idmovimiento')
                    ->where('ca.id',$this->caja)
                    ->whereIn('cartera_movs.comentario', ['Venta', 'Devolución Venta','Por Venta Anulada'])
                    ->whereDate('cartera_movs.created_at', date('Y/m/d'))
                    ->orderBy('cartera_movs.created_at', 'asc')
                    ->get();
                }
            }
            else
            {
                if($this->caja=='Todos')
                {
                    //Consulta para listar todas las cajas de una determinada sucursal
                    $cajas = Caja::select('cajas.id as idcaja','cajas.nombre as nombrecaja')
                    ->where('cajas.sucursal_id',$this->sucursal,)
                    ->get();
                    //Consulta para filtrar por sucursal
                    $data = CarteraMov::join('movimientos as m', 'm.id', 'cartera_movs.movimiento_id')
                    ->join("carteras as c", "c.id", "cartera_movs.cartera_id")
                    ->join("users as u", "u.id", "m.user_id")
                    ->join("cajas as ca", "ca.id", "c.caja_id")
                    ->join("sucursals as s", "s.id", "ca.sucursal_id")
                    ->select('cartera_movs.created_at as fecha','u.name as nombreusuario',
                    'cartera_movs.comentario as motivo','m.import as importe','ca.nombre as nombrecaja',
                    'cartera_movs.type as tipo','c.nombre as nombrecartera','s.name as nombresucursal','m.id as idmovimiento')
                    ->where('s.id',$this->sucursal,)
                    ->whereIn('cartera_movs.comentario', ['Venta', 'Devolución Venta','Por Venta Anulada'])
                    ->whereDate('cartera_movs.created_at', date('Y/m/d'))
                    ->get();
                }
                else
                {
                    //Consulta para listar todas las cajas de una determinada sucursal
                    $cajas = Caja::select('cajas.id as idcaja','cajas.nombre as nombrecaja')
                    ->where('cajas.sucursal_id',$this->sucursal,)
                    ->get();
                    //Consulta para filtrar por sucursal y caja
                    $data = CarteraMov::join('movimientos as m', 'm.id', 'cartera_movs.movimiento_id')
                    ->join("carteras as c", "c.id", "cartera_movs.cartera_id")
                    ->join("users as u", "u.id", "m.user_id")
                    ->join("cajas as ca", "ca.id", "c.caja_id")
                    ->join("sucursals as s", "s.id", "ca.sucursal_id")
                    ->select('cartera_movs.created_at as fecha','u.name as nombreusuario',
                    'cartera_movs.comentario as motivo','m.import as importe','ca.nombre as nombrecaja',
                    'cartera_movs.type as tipo','c.nombre as nombrecartera','s.name as nombresucursal','m.id as idmovimiento')
                    ->where('s.id',$this->sucursal,)
                    ->where('ca.id',$this->caja)
                    ->whereIn('cartera_movs.comentario', ['Venta', 'Devolución Venta','Por Venta Anulada'])
                    ->whereDate('cartera_movs.created_at', date('Y/m/d'))
                    ->get();
                }
            }
            //Si se selecciona una caja y despues una sucursal que no le corresponde
            //Se listarán todas las cajas de esa sucursal
            if($this->sucursal != 'Todos' && $this->caja != 'Todos')
            {
                if($this->verificar_caja_sucursal($this->caja, $this->sucursal)->count() == 0)
                {
                    
                    $this->caja == 'Todos';
    
                    $data = CarteraMov::join('movimientos as m', 'm.id', 'cartera_movs.movimiento_id')
                    ->join("carteras as c", "c.id", "cartera_movs.cartera_id")
                    ->join("users as u", "u.id", "m.user_id")
                    ->join("cajas as ca", "ca.id", "c.caja_id")
                    ->join("sucursals as s", "s.id", "ca.sucursal_id")
                    ->select('cartera_movs.created_at as fecha','u.name as nombreusuario',
                    'cartera_movs.comentario as motivo','m.import as importe','ca.nombre as nombrecaja',
                    'cartera_movs.type as tipo','c.nombre as nombrecartera','s.name as nombresucursal','m.id as idmovimiento')
                    ->where('s.id',$this->sucursal,)
                    ->whereIn('cartera_movs.comentario', ['Venta', 'Devolución Venta','Por Venta Anulada'])
                    ->whereDate('cartera_movs.created_at', date('Y/m/d'))
                    ->get();
                }
            }

        }
        else
        {
            if($this->sucursal=='Todos')
            {
                if($this->sucursal=='Todos' && $this->caja=='Todos')
                {
                    
                    //Consulta para listar todas las cajas
                    $cajas = Caja::select('cajas.id as idcaja','cajas.nombre as nombrecaja')->get();
                    //Consulta para el reporte de movimiento diario con todas las sucursales
                    $data = CarteraMov::join('movimientos as m', 'm.id', 'cartera_movs.movimiento_id')
                    ->join("carteras as c", "c.id", "cartera_movs.cartera_id")
                    ->join("users as u", "u.id", "m.user_id")
                    ->join("cajas as ca", "ca.id", "c.caja_id")
                    ->join("sucursals as s", "s.id", "ca.sucursal_id")
                    ->select('cartera_movs.created_at as fecha','u.name as nombreusuario',
                    'cartera_movs.comentario as motivo','m.import as importe','ca.nombre as nombrecaja',
                    'cartera_movs.type as tipo','c.nombre as nombrecartera','s.name as nombresucursal','m.id as idmovimiento')
                    ->whereIn('cartera_movs.comentario', ['Venta', 'Devolución Venta','Por Venta Anulada'])
                    
                    ->whereYear('cartera_movs.created_at','>=' , date("Y", strtotime($this->dateFrom)))
                    ->whereMonth('cartera_movs.created_at','>=' , date("m", strtotime($this->dateFrom)))
                    ->whereDay('cartera_movs.created_at','>=', date("d", strtotime($this->dateFrom)))
                    
                    ->whereYear('cartera_movs.created_at','<=' , date("Y", strtotime($this->dateTo)))
                    ->whereMonth('cartera_movs.created_at','<=' , date("m", strtotime($this->dateTo)))
                    ->whereDay('cartera_movs.created_at','<=', date("d", strtotime($this->dateTo)))


                    ->orderBy('cartera_movs.created_at', 'asc')
                    ->get();
                }
                else
                {
                    //Consulta para listar todas las cajas
                    $cajas = Caja::select('cajas.id as idcaja','cajas.nombre as nombrecaja')->get();
                    //Consulta para listar el movimiento diario de una caja en específico
                    $data = CarteraMov::join('movimientos as m', 'm.id', 'cartera_movs.movimiento_id')
                    ->join("carteras as c", "c.id", "cartera_movs.cartera_id")
                    ->join("users as u", "u.id", "m.user_id")
                    ->join("cajas as ca", "ca.id", "c.caja_id")
                    ->join("sucursals as s", "s.id", "ca.sucursal_id")
                    ->select('cartera_movs.created_at as fecha','u.name as nombreusuario',
                    'cartera_movs.comentario as motivo','m.import as importe','ca.nombre as nombrecaja',
                    'cartera_movs.type as tipo','c.nombre as nombrecartera','s.name as nombresucursal','m.id as idmovimiento')
                    ->where('ca.id',$this->caja)
                    ->whereIn('cartera_movs.comentario', ['Venta', 'Devolución Venta','Por Venta Anulada'])
                    
                    ->whereYear('cartera_movs.created_at','>=' , date("Y", strtotime($this->dateFrom)))
                    ->whereMonth('cartera_movs.created_at','>=' , date("m", strtotime($this->dateFrom)))
                    ->whereDay('cartera_movs.created_at','>=', date("d", strtotime($this->dateFrom)))
                    
                    ->whereYear('cartera_movs.created_at','<=' , date("Y", strtotime($this->dateTo)))
                    ->whereMonth('cartera_movs.created_at','<=' , date("m", strtotime($this->dateTo)))
                    ->whereDay('cartera_movs.created_at','<=', date("d", strtotime($this->dateTo)))


                    
                    ->orderBy('cartera_movs.created_at', 'asc')
                    ->get();
                }
            }
            else
            {
                if($this->caja=='Todos')
                {
                    //Consulta para listar todas las cajas de una determinada sucursal
                    $cajas = Caja::select('cajas.id as idcaja','cajas.nombre as nombrecaja')
                    ->where('cajas.sucursal_id',$this->sucursal,)
                    ->get();
                    //Consulta para filtrar por sucursal
                    $data = CarteraMov::join('movimientos as m', 'm.id', 'cartera_movs.movimiento_id')
                    ->join("carteras as c", "c.id", "cartera_movs.cartera_id")
                    ->join("users as u", "u.id", "m.user_id")
                    ->join("cajas as ca", "ca.id", "c.caja_id")
                    ->join("sucursals as s", "s.id", "ca.sucursal_id")
                    ->select('cartera_movs.created_at as fecha','u.name as nombreusuario',
                    'cartera_movs.comentario as motivo','m.import as importe','ca.nombre as nombrecaja',
                    'cartera_movs.type as tipo','c.nombre as nombrecartera','s.name as nombresucursal','m.id as idmovimiento')
                    ->where('s.id',$this->sucursal,)
                    ->whereIn('cartera_movs.comentario', ['Venta', 'Devolución Venta','Por Venta Anulada'])
                    
                    ->whereYear('cartera_movs.created_at','>=' , date("Y", strtotime($this->dateFrom)))
                    ->whereMonth('cartera_movs.created_at','>=' , date("m", strtotime($this->dateFrom)))
                    ->whereDay('cartera_movs.created_at','>=', date("d", strtotime($this->dateFrom)))
                    
                    ->whereYear('cartera_movs.created_at','<=' , date("Y", strtotime($this->dateTo)))
                    ->whereMonth('cartera_movs.created_at','<=' , date("m", strtotime($this->dateTo)))
                    ->whereDay('cartera_movs.created_at','<=', date("d", strtotime($this->dateTo)))


                    
                    ->get();
                }
                else
                {
                    //Consulta para listar todas las cajas de una determinada sucursal
                    $cajas = Caja::select('cajas.id as idcaja','cajas.nombre as nombrecaja')
                    ->where('cajas.sucursal_id',$this->sucursal,)
                    ->get();
                    //Consulta para filtrar por sucursal y caja
                    $data = CarteraMov::join('movimientos as m', 'm.id', 'cartera_movs.movimiento_id')
                    ->join("carteras as c", "c.id", "cartera_movs.cartera_id")
                    ->join("users as u", "u.id", "m.user_id")
                    ->join("cajas as ca", "ca.id", "c.caja_id")
                    ->join("sucursals as s", "s.id", "ca.sucursal_id")
                    ->select('cartera_movs.created_at as fecha','u.name as nombreusuario',
                    'cartera_movs.comentario as motivo','m.import as importe','ca.nombre as nombrecaja',
                    'cartera_movs.type as tipo','c.nombre as nombrecartera','s.name as nombresucursal','m.id as idmovimiento')
                    ->where('s.id',$this->sucursal,)
                    ->where('ca.id',$this->caja)
                    ->whereIn('cartera_movs.comentario', ['Venta', 'Devolución Venta','Por Venta Anulada'])
                    
                    ->whereYear('cartera_movs.created_at','>=' , date("Y", strtotime($this->dateFrom)))
                    ->whereMonth('cartera_movs.created_at','>=' , date("m", strtotime($this->dateFrom)))
                    ->whereDay('cartera_movs.created_at','>=', date("d", strtotime($this->dateFrom)))
                    
                    ->whereYear('cartera_movs.created_at','<=' , date("Y", strtotime($this->dateTo)))
                    ->whereMonth('cartera_movs.created_at','<=' , date("m", strtotime($this->dateTo)))
                    ->whereDay('cartera_movs.created_at','<=', date("d", strtotime($this->dateTo)))


                    
                    ->get();
                }
            }
            //Si se selecciona una caja y despues una sucursal que no le corresponde
            //Se listarán todas las cajas de esa sucursal
            if($this->sucursal != 'Todos' && $this->caja != 'Todos')
            {
                if($this->verificar_caja_sucursal($this->caja, $this->sucursal)->count() == 0)
                {
                    
                    $this->caja == 'Todos';
    
                    $data = CarteraMov::join('movimientos as m', 'm.id', 'cartera_movs.movimiento_id')
                    ->join("carteras as c", "c.id", "cartera_movs.cartera_id")
                    ->join("users as u", "u.id", "m.user_id")
                    ->join("cajas as ca", "ca.id", "c.caja_id")
                    ->join("sucursals as s", "s.id", "ca.sucursal_id")
                    ->select('cartera_movs.created_at as fecha','u.name as nombreusuario',
                    'cartera_movs.comentario as motivo','m.import as importe','ca.nombre as nombrecaja',
                    'cartera_movs.type as tipo','c.nombre as nombrecartera','s.name as nombresucursal','m.id as idmovimiento')
                    ->where('s.id',$this->sucursal,)
                    ->whereIn('cartera_movs.comentario', ['Venta', 'Devolución Venta','Por Venta Anulada'])
                    
                    ->whereYear('cartera_movs.created_at','>=' , date("Y", strtotime($this->dateFrom)))
                    ->whereMonth('cartera_movs.created_at','>=' , date("m", strtotime($this->dateFrom)))
                    ->whereDay('cartera_movs.created_at','>=', date("d", strtotime($this->dateFrom)))
                    
                    ->whereYear('cartera_movs.created_at','<=' , date("Y", strtotime($this->dateTo)))
                    ->whereMonth('cartera_movs.created_at','<=' , date("m", strtotime($this->dateTo)))
                    ->whereDay('cartera_movs.created_at','<=', date("d", strtotime($this->dateTo)))


                    
                    ->get();
                }
            }

















        }


        


        

        return view('livewire.sales.saledailymovement', [
            'data' => $data,
            'sucursales' => $sucursales,
            'cajas' => $cajas,
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }



    


    //Buscar Ventas por Id Movimiento
    public function buscarventa($idmovimiento)
    {
        $venta = Sale::join('movimientos as m', 'm.id', 'sales.movimiento_id')
                ->select('sales.id as idventa')
                ->where('sales.movimiento_id',$idmovimiento)
                ->get();
        return $venta;
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

    //Buscar caja 
    public function verificar_caja_sucursal($idcaja, $idsucursal)
    {
        $resultado = Caja::join('sucursals as s', 's.id', 'cajas.sucursal_id')
        ->select('s.id as id','cajas.id as idcaja')
        ->where('cajas.id', $idcaja)
        ->where('s.id', $idsucursal)
        ->get();

        return $resultado;
    }

    //Metodo para Verificar si el usuario tiene el Permiso para filtrar por Sucursal y ver por utilidad
    public function verificarpermiso()
    {
        if(Auth::user()->hasPermissionTo('VentasMovDiaSucursalUtilidad'))
        {
            return true;
        }
        return false;
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
