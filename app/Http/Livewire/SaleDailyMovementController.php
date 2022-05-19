<?php

namespace App\Http\Livewire;

use App\Models\CarteraMov;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class SaleDailyMovementController extends Component
{
    public $dateFrom, $dateTo, $reportType;
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





        $data = CarteraMov::join('movimientos as m', 'm.id', 'cartera_movs.movimiento_id')
            ->join("carteras as c", "c.id", "cartera_movs.cartera_id")
            ->join("users as u", "u.id", "m.user_id")
            ->join("cajas as ca", "ca.id", "c.caja_id")
            ->join("sucursals as s", "s.id", "ca.sucursal_id")
            ->select('cartera_movs.created_at as fecha','u.name as nombreusuario',
            'cartera_movs.comentario as motivo','m.import as importe','ca.nombre as nombrecaja',
            'cartera_movs.type as tipo','c.nombre as nombrecartera','s.name as nombresucursal')
            ->where('m.type', '<>','APERTURA')
            ->orWhere('m.type','VENTAS')
            ->orWhere('m.type','ANULARVENTA')
            ->orWhere('m.type','DEVOLUCIONVENTA')
            ->orderBy('cartera_movs.created_at', 'asc')
            ->paginate(100);

        return view('livewire.sales.saledailymovement', [
            'data' => $data,
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
