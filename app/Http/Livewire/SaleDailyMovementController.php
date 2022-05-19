<?php

namespace App\Http\Livewire;

use App\Models\CarteraMov;
use Livewire\Component;
use Livewire\WithPagination;

class SaleDailyMovementController extends Component
{
    use WithPagination;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function render()
    {

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
