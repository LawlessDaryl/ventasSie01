<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\CarteraMov;
use App\Models\Sale;
use App\Models\Sucursal;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

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
        $this->sucursal='Todos';
        $this->caja='Todos';
    }


    public function render()
    {

        if ($this->reportType == 0) {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        } else {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d')     . ' 23:59:59';
        }
        if ($this->reportType == 1 && ($this->dateFrom == '' || $this->dateTo == '')) {
            $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
            $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
            $this->emit('item', 'Hiciste algo incorrecto, la fecha se actualizó');
        }

        if ($this->dateFrom == "" || $this->dateTo == "") {
            $this->reportType = 0;
        }




        if($this->sucursal != 'Todos')
        {

        }






        $sucursales = Sucursal::select('sucursals.id as idsucursal','sucursals.name as nombresucursal','sucursals.adress as direccionsucursal')->get();
        

        




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
                ->orderBy('cartera_movs.created_at', 'asc')
                ->get();
            }
            else
            {
                //Consulta para listar todas las cajas
                $cajas = Caja::select('cajas.id as idcaja','cajas.nombre as nombrecaja')->get();
                //
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
                ->get();
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



    //Buscar caja 
    public function verificar_caja_sucursal()
    {

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



}
