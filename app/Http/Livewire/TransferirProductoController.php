<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Compra as ModelsCompra;
use App\Models\Destino;
use App\Models\DetalleTransferencia;
use App\Models\Location;
use App\Models\Product;
use App\Models\ProductosDestino;
use App\Models\Sucursal;
use App\Models\Transference;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;


use Darryldecode\Cart\Facades\TransferenciasFacade as Transferencia;
use Exception;

class TransferirProductoController extends Component
{
    
    use WithPagination;

    public $selected_id,$search,
    $itemsQuantity,$selected_3,$selected_origen,$selected_destino;
    private $pagination = 10;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    
    public function mount()
    {
    $this->selected_origen="Elegir Origen";
        //$this->itemsQuantity = Cart::getTotalQuantity();
        $quantity= Transferencia::getTotalQuantity();
      
    }

    public function render()
    {
        if($this->selected_origen != null){

            $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                                        ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                                        ->select('productos_destinos.*','p.nombre as name','dest.nombre as nombre_destino','dest.id as dest_id','p.id as id_prod')
                                        ->where('dest.id',$this->selected_origen)
                                        ->orderBy('p.nombre','desc')
                                        ->paginate($this->pagination);
                                        
        }
            
            else{
               
                $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                                            ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                                            ->select(DB::raw('SUM(productos_destinos.stock) as stock_s'),'p.nombre as name','p.cantidad_minima as cant_min')
                                            ->groupBy('productos_destinos.product_id')
                                            ->paginate($this->pagination);
            }
            $sucursal_ubicacion=Destino::join('sucursals as suc','suc.id','destinos.sucursal_id')
                                        ->select ('suc.name as sucursal','destinos.nombre as destino','destinos.id')
                                        ->orderBy('suc.name','asc');

                                    

        return view('livewire.destino_producto.destino-controller',['destinos_almacen'=>$almacen,'data_suc' =>  $sucursal_ubicacion->get(),
        'cart' => Transferencia::getContent(),'data_cat'=>Category::select('categories.name')->where('categories.categoria_padre','0')->get()
        ])  
        ->extends('layouts.theme.app')
        ->section('content');
    }
    public function increaseQty($productId,$cant=1)
    {
       
        $product = Product::select('products.id','products.nombre as name')
        ->where('products.id',$productId)->first();
        
        $exist = Transferencia::get($product->id);
       
        if ($exist) {
            $title = 'Cantidad actualizada';
        } else {
            $title = "Producto agregado";
        }

       

     

        Transferencia::add($product->id, $product->name,0, $cant);

        $this->itemsQuantity = Transferencia::getTotalQuantity();
        $this->emit('scan-ok', $title);
       

    }

    public function UpdateQty($productId, $cant =1)
    {
        
        $product = Product::select('products.id','products.nombre as name')
        ->where('products.id',$productId)->first();
       
        $exist = Transferencia::get($productId);
        
       
        if ($exist) {
            $title = "cantidad actualizada";
        } else {
            $title = "producto agregado";
        }
       
        $this->removeItem($productId);
       
        if ($cant > 0) {

          
            Transferencia::add($product->id, $product->name,0, $cant);
          
          
            $this->itemsQuantity = Transferencia::getTotalQuantity();
            $this->emit('scan-ok', $title);
          



        }
    }
    public function removeItem($productId)
    {
        Transferencia::remove($productId);
        $this->itemsQuantity = Transferencia::getTotalQuantity();
        $this->emit('scan-ok', 'Producto eliminado');
  
    }

    public function resetUI()
    {
        
        $this->selected_origen='Elegir Origen';
        $this->selected_destino='Elegir Destino';
       
    }
    public function verificarStock(){

    }
    public function finalizar_tr()
    {
        
        DB::beginTransaction();

        try {
            $Transferencia_encabezado = Transference::create([
               
                'status'=>2,
                'estado'=>1,
                'id_usuario'=>Auth()->user()->id
            ]);

            if ($Transferencia_encabezado)
            {
                $items = Transferencia::getContent();
                foreach ($items as $item) {
                    DetalleTransferencia::create([
                        
                        'product_id' => $item->id,
                        'cantidad' => $item->quantity,
                        'destino_id'=>$this->selected_destino
                    ]);
                    /*DB::table('productos_destinos')
                    ->updateOrInsert(['stock'],$item->quantity, ['product_id' => $item->id, 'destino_id'=>$this->destino]);*/
                }
            }

            DB::commit();

            Transferencia::clear();
            $this->selected_destino = "Elegir Destino";
            $this->selected_origen = "Elegir Destino";
            $this->itemsQuantity = Transferencia::getTotalQuantity();
            redirect('/transferencias');
        
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            
        }
    }

}