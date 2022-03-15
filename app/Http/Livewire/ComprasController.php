<?php

namespace App\Http\Livewire;

use App\Models\Compra;
use App\Models\Product;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ComprasController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public  $nro_compra,$search,$provider,$fecha,
    $usuario,$impuestos,$pago_parcial,$tipo_documento,$nro_docuemnto,$observacion;

    private $pagination = 5;
    public function mount()
    {
        $this->nro_compra = 00200;
        $this->provider = "NO DEFINIDO";
        $this->fecha = Carbon::now();
        $this->usuario = Auth()->user()->name;
        $this->impuestos = false;
        $this->pago_parcial = 0;
        $this->impuestos = false;
        $this->nro_docuemnto = 0;



       

     
    }
    public function render()
    {
        if (strlen($this->search) > 0)
        $prod = Product::select('products.*')
        ->where('nombre', 'like', '%' . $this->search . '%')
        ->orWhere('barcode','like','%'.$this->search.'%')
        ->orWhere('marca','like','%'.$this->search.'%')
        ->orWhere('id','like','%'.$this->search.'%')
        ->paginate($this->pagination);
        else
        $prod = Product::select('products.*')
        ->paginate($this->pagination);
        $prod1 = Product::select('products.*')
        ->paginate($this->pagination);
    
        return view('livewire.compras.component',['data_prod' => $prod,'data_p'])
        ->extends('layouts.theme.app')
        ->section('content');
    }

}
