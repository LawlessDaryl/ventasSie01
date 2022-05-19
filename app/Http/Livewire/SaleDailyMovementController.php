<?php

namespace App\Http\Livewire;

use App\Models\CarteraMov;
use Livewire\Component;

class SaleDailyMovementController extends Component
{
    public function render()
    {

        $data = CarteraMov::join('movimientos as m', 'm.id', 'cartera_movs.movimiento_id')
            ->join("carteras as c", "c.id", "cartera_movs.cartera_id")
            ->join("cajas as ca", "ca.id", "c.caja_id")
            ->select('cartera_movs.id as id','cartera_movs.type as tipo','c.nombre as nombrecartera')
            ->where('m.type', '<>','APERTURA')
            ->orderBy('cartera_movs.created_at', 'desc')
            ->paginate(5);

        return view('livewire.sales.saledailymovement', [
            'data' => $data,
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
