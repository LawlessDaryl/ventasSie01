<?php

namespace App\Http\Livewire;

use App\Models\Compra;
use App\Models\Product;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Darryldecode\Cart\Facades\ComprasFacade as Compras;

class DetalleComprasController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public  $nro_compra,$search,$provider,$fecha,
    $usuario,$metodo_pago,$pago_parcial,$tipo_documento,$nro_documento,$observacion
    ,$selected_id,$total_compra,$itemsQuantity,$price,$prueba=true,$tipo_transaccion;

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
        $this->tipo_transaccion = "CONTADO";

        $this->total_compra = Compras::getTotal();
        $this->itemsQuantity = Compras::getTotalQuantity();
  
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


        return view('livewire.compras.detalle_compra',['data_prod' => $prod,
        'cart' => Compras::getContent()->sortBy('name')
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
  

    public function increaseQty($productId, $cant = 1,$precio_compra = 2)
    {
       
        $title = 'aaa';
        $product = Product::select('products.id','products.nombre as name')
        ->where('products.id',$productId)->first();
       
        $exist = Compras::get($product->id);
        if ($exist) {
            $title = 'Cantidad actualizada';
        } else {
            $title = "Producto agregado";
        }

        Compras::add($product->id, $product->name, $precio_compra, $cant);

        
        $this->total = Compras::getTotal();
        $this->itemsQuantity = Compras::getTotalQuantity();
        $this->emit('scan-ok', $title);
         $this->total_compra = Compras::getTotal();

    }

    public function UpdateQty($productId, $cant = 3)
    {
        $title = '';
        $product = Product::select('products.id','products.nombre as name')
        ->where('products.id',$productId)->first();
       
        $exist = Compras::get($productId);
        $prices=$exist->price;
       
        if ($exist) {
            $title = "cantidad actualizada";
        } else {
            $title = "producto agregado";
        }
       
        $this->removeItem($productId);
       
        if ($cant > 0) {

          
            Compras::add($product->id, $product->name,$prices, $cant);
          
            $this->total = Compras::getTotal();
            $this->itemsQuantity = Compras::getTotalQuantity();
            $this->emit('scan-ok', $title);
            $this->total_compra = Compras::getTotal();



        }
    }

    public function UpdatePrice($productId, $price = 20)
    {
        $title = '';
        $product = Product::select('products.id','products.nombre as name')
        ->where('products.id',$productId)->first();
       
        $exist = Compras::get($productId);
        $quantitys=$exist->quantity;
       
        if ($exist) {
            $title = "cantidad actualizada";
        } else {
            $title = "producto agregado";
        }

     
       
        $this->removeItem($productId);
       
        if ($price > 0) {


          
            Compras::add($product->id, $product->name, $price, $quantitys);
          
            $this->total = Compras::getTotal();
            $this->itemsQuantity = Compras::getTotalQuantity();
            $this->emit('scan-ok', $title);
            $this->total_compra = Compras::getTotal();



        }
        
    
    }
    public function removeItem($productId)
    {
        Compras::remove($productId);

        $this->total = Compras::getTotal();
        $this->itemsQuantity = Compras::getTotalQuantity();
        $this->emit('scan-ok', 'Producto eliminado');
        $this->total_compra = Compras::getTotal();
    }

    public function resetUI()
    {
        $this->nombre = '';
        $this->selected_id=0;
       
    }

  

}
