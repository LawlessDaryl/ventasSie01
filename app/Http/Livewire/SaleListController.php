<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use App\Models\Sale;
use App\Models\SaleDetail;

class SaleListController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $componentName, $data, $idventa;

    public function mount()
    {
        $this->data = [];
        $this->listadetalles = [];
        $this->componentName = 'Lista de Ventas';
        $this->listarventas();
        $this->listardetalleventas();
        $this->idventa = 1;
    }


    public function render()
    {
        return view('livewire.sales.salelist')
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function listarventas()
    {
        $this->data = Sale::join('users as u', 'u.id', 'sales.user_id')
        ->join("movimientos as m", "m.id", "sales.movimiento_id")
        ->join("cliente_movs as cm", "cm.movimiento_id", "m.id")
        ->join("clientes as c", "c.id", "cm.cliente_id")
        ->select('sales.id as id','sales.cash as totalbs','sales.created_at as fecha',
        'sales.tipopago as tipopago','sales.change as cambio',
        'u.name as user','c.razon_social as rz','c.cedula as ci','c.celular as celular')
        ->where('u.id',Auth()->user()->id)
        ->orderBy('sales.id', 'desc')
        ->get();
    }
    public function listardetalleventas()
    {
        $this->listadetalles = SaleDetail::join('sales as s', 's.id', 'sale_details.sale_id')
        ->join("products as p", "p.id", "sale_details.product_id")
        ->select('p.image as image','p.nombre as nombre','p.precio_venta as po',
        'sale_details.price as pv','sale_details.quantity as cantidad')
        ->where('sale_details.sale_id', $this->idventa)
        ->orderBy('sale_details.id', 'asc')
        ->get();
        //dd($this->listadetalles);
    }
    public function cambiaridventa($id)
    {
        $this->idventa = $id;
        $this->listardetalleventas();
        $this->listarventas();
        $this->emit('show-modal', 'show modal!');
    }
}
