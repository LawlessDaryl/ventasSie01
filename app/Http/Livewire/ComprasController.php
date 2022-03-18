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
    $usuario,$metodo_pago,$pago_parcial,$tipo_documento,$nro_documento,$observacion
    ,$selected_id,$total_compra,$itemsQuantity;

    private $pagination = 5;
    public function mount()
    {
        $this->nro_compra = 00200;
        $this->provider = "NO DEFINIDO";
        $this->fecha = Carbon::now();
        $this->usuario = Auth()->user()->name;
        $this->impuestos = false;
        $this->selected_id = 0;
        $this->total_compra = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
  
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
    
        return view('livewire.compras.component',['data_prod' => $prod,
        'cart' => Cart::getContent()->sortBy('name')
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
  

    public function increaseQty($productId, $cant = 1,$precio_compra = 0)
    {
       
        $title = 'aaa';
        $product = Product::select('products.id','products.nombre as name')
        ->where('products.id',$productId)->first();
       
        $exist = Cart::get($product->id);
        if ($exist) {
            $title = 'Cantidad actualizada';
        } else {
            $title = "Producto agregado";
        }

        Cart::add($product->id, $product->name, $precio_compra, $cant);

        
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', $title);
    }

    public function UpdateQty($productId, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if ($exist) {
            $title = "cantidad actualizada";
        } else {
            $title = "producto agregado";
        }
        if ($exist) {
            if ($product->stock < $cant) {
                $this->emit('no-stock', 'stock insuficiente :/');
                return;
            }
        }
        $this->removeItem($productId);
        if ($cant > 0) {
            Cart::add($product->id, $product->name, $product->price, $cant);
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', $title);
        }

        
    }


    public function resetUI()
    {
        $this->nombre = '';
        $this->selected_id=0;
       
    }

  

}
