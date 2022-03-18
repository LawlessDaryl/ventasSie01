<?php

namespace App\Http\Livewire;

use App\Models\Compra;
use App\Models\Product;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class ComprasController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public  $nro_compra,$search,$provider,$fecha,
<<<<<<< HEAD
    $usuario,$metodo_pago,$pago_parcial,$tipo_documento,$nro_documento,$observacion,$selected_id,$total;
=======
    $usuario,$metodo_pago,$pago_parcial,$tipo_documento,$nro_documento,$observacion
    ,$selected_id,$total_compra;
>>>>>>> 03c9f08cad82694829a88b97b7e306ec8f841cf2

    private $pagination = 5;
    public function mount()
    {
        $this->nro_compra = 00200;
        $this->provider = "NO DEFINIDO";
        $this->fecha = Carbon::now();
        $this->usuario = Auth()->user()->name;
        $this->impuestos = false;
        $this->selected_id = 0;
<<<<<<< HEAD
        $this->total=Cart::getTotal();
        

       



       

     
=======
        $this->total_compra = Cart::getTotal();
  
>>>>>>> 03c9f08cad82694829a88b97b7e306ec8f841cf2
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
    
        return view('livewire.compras.component',['data_prod' => $prod,'data_p', 
        'cart' => Cart::getContent()->sortBy('name')
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
    public function Store()
    {
        $rules = [
            'nombre' => 'required|unique:unidads'
        ];
        $messages = [
            'nombre.required' => 'El nombre de la unidad es requerido.',
            'nombre.unique' => 'Ya existe una unidad con ese nombre.',
        ];
        $this->validate($rules, $messages);

        Unidad::create([
            'nombre' => $this->nombre
        ]);

        $this->resetUI();
        $this->emit('unidad-added', 'Unidad Registrada');
    }

    public function resetUI()
    {
        $this->nombre = '';
        $this->selected_id=0;
       
    }

  

}
