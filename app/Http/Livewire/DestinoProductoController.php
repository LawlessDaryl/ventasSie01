<?php

namespace App\Http\Livewire;

use App\Models\Destino;
use App\Models\Location;
use App\Models\ProductosDestino;
use App\Models\Sucursal;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class DestinoProductoController extends Component
{
    use WithPagination;

    public $selected_id,$selected_ubicacion,$componentName,$title,$itemsQuantity;
    private $pagination = 10;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->selected_id=0;
        $this->componentName='crear';
        $this->title='ssss';

        $this->itemsQuantity = Cart::getTotalQuantity();



    }


  

    public function render()
    {
        if($this->selected_id !== null){

            if($this->selected_id == 'General')
            
              
            $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                                        ->join('locations as loc','loc.id','productos_destinos.location_id')
                                        ->join('destinos as dest','dest.id','loc.destino_id')
                                        
                                        ->select(DB::raw('SUM(productos_destinos.stock) as stock_s'),'p.nombre as name','p.cantidad_minima as cant_min')
                                        ->groupBy('productos_destinos.product_id')
                                      
                                        ->paginate($this->pagination);
            
         else
            $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                                        ->join('locations as loc','loc.id','productos_destinos.location_id')
                                        ->join('destinos as dest','dest.id','loc.destino_id')
                                        
                                        ->select('productos_destinos.*','loc.*','p.nombre as name','loc.tipo as type','dest.nombre as nombre_destino')
                                    
                                        ->where('dest.id',$this->selected_id)
                                        ->orderBy('p.nombre','desc')
                                        ->paginate($this->pagination);
                                        
        }
            
            else{
               
                $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                ->join('locations as loc','loc.id','productos_destinos.location_id')
                ->join('destinos as dest','dest.id','loc.destino_id')
                
                ->select(DB::raw('SUM(productos_destinos.stock) as stock_s'),'p.nombre as name','p.cantidad_minima as cant_min')
                ->groupBy('productos_destinos.product_id')
              
                ->paginate($this->pagination);
            }
            $sucursal_ubicacion=Destino::join('sucursals as suc','suc.id','destinos.sucursal_id')
                                        ->select ('suc.name as sucursal','destinos.nombre as destino','destinos.id')
                                       
                                        ->orderBy('suc.name','asc');

                                    

        return view('livewire.destino_producto.destino-controller',['destinos_almacen'=>$almacen,'data_suc' =>  $sucursal_ubicacion->get(),'cart' => Cart::getContent()])  
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
