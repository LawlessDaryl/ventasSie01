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
    ,$selected_id,$total_compra,$itemsQuantity,$price;

    private $pagination = 5;
    public function mount()
    {
        $this->nro_compra = 00200;
        $this->provider = "NO DEFINIDO";
        $this->fecha = Carbon::now();
        $this->usuario = Auth()->user()->name;
        $this->impuestos = false;
        $this->selected_id = 0;
        $this->price = 9;

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
        $prod = "cero";


        return view('livewire.compras.component',['data_prod' => $prod,
        'cart' => Cart::getContent()->sortBy('name')
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
  

    public function increaseQty($productId, $cant = 1,$precio_compra = 2)
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
         $this->total_compra = Cart::getTotal();

    }

    public function UpdateQty($productId, $cant = 3)
    {
        $title = '';
        $product = Product::select('products.id','products.nombre as name')
        ->where('products.id',$productId)->first();
       
        $exist = Cart::get($productId);
        $prices=$exist->price;
       
        if ($exist) {
            $title = "cantidad actualizada";
        } else {
            $title = "producto agregado";
        }
       
        $this->removeItem($productId);
       
        if ($cant > 0) {

          
            Cart::add($product->id, $product->name,$prices, $cant);
          
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', $title);
            $this->total_compra = Cart::getTotal();



        }
    }

    public function UpdatePrice($productId, $price = 20)
    {
        $title = '';
        $product = Product::select('products.id','products.nombre as name')
        ->where('products.id',$productId)->first();
       
        $exist = Cart::get($productId);
        $quantitys=$exist->quantity;
       
        if ($exist) {
            $title = "cantidad actualizada";
        } else {
            $title = "producto agregado";
        }

     
       
        $this->removeItem($productId);
       
        if ($price > 0) {


          
            Cart::add($product->id, $product->name, $price, $quantitys);
          
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', $title);
            $this->total_compra = Cart::getTotal();



        }
        
    
    }
    public function removeItem($productId)
    {
        Cart::remove($productId);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Producto eliminado');
        $this->total_compra = Cart::getTotal();
    }

    public function resetUI()
    {
        $this->nombre = '';
        $this->selected_id=0;
       
    }

  

}
