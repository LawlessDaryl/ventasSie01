<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use App\Models\Sale;

class SaleListController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $componentName, $data;

    public function mount()
    {
        $this->data = [];
        $this->componentName = 'Lista de Ventas';
        $this->listarventas();
    }


    public function render()
    {
        return view('livewire.pos.partials.salelist')
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function listarventas()
    {
        $this->data = Sale::join('users as u', 'u.id', 'sales.user_id')
        ->join("movimientos as m", "m.id", "sales.movimiento_id")
        ->join("cliente_movs as cm", "cm.movimiento_id", "m.id")
        ->join("clientes as c", "c.id", "cm.cliente_id")
        ->select('sales.*', 'u.name as user','c.razon_social as rz')
        ->where('u.id',Auth()->user()->id)
        ->orderBy('sales.id', 'desc')
        ->get();


    }

    public function devolucionventa($idventa)
    {
        dd("Modulo para Devoluciòn");
    }
}
