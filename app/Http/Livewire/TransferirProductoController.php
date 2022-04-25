<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Compra as ModelsCompra;
use App\Models\Destino;
use App\Models\DetalleTransferencia;
use App\Models\Estado_Transferencia;
use App\Models\EstadoTrans_Detalle;
use App\Models\EstadoTransDetalle;
use App\Models\EstadoTransferencia;
use App\Models\Location;
use App\Models\Product;
use App\Models\ProductosDestino;
use App\Models\Sucursal;
use App\Models\Transference;
use App\Models\transferencia_detalle;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;


use Darryldecode\Cart\Facades\TransferenciasFacade as Transferencia;
use Exception;
use Illuminate\Support\Facades\Auth;

class TransferirProductoController extends Component
{
    
    use WithPagination;

    public $selected_id,$search,
    $itemsQuantity,$selected_3,$selected_origen=0,$selected_destino,$observacion;
    private $pagination = 10;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    
    public function mount()
    {
        
    
        //$this->itemsQuantity = Cart::getTotalQuantity();
       // $quantity= Transferencia::getTotalQuantity();
      
    }

    public function render()
    {
   
        $this->itemsQuantity = Transferencia::getTotalQuantity();
      
        if($this->selected_origen !== 0){

            $almacen= ProductosDestino::join('products as prod','prod.id','productos_destinos.product_id')
                                        ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                                        ->select('prod.nombre as name','dest.nombre as nombre_destino','dest.id as dest_id','prod.id as prod_id')
                                        ->where('dest.id',$this->selected_origen)
                                        ->orderBy('prod.nombre','desc')
                                        ->paginate($this->pagination);
                                   
                                        }

                                        else{
                                            $almacen=null;
                                        }
            
         
                 $sucursal_ubicacion=Destino::join('sucursals as suc','suc.id','destinos.sucursal_id')
                                        ->select ('suc.name as sucursal','destinos.nombre as destino','destinos.id as destino_id')
                                        ->orderBy('suc.name','asc');

                                    

        return view('livewire.destino_producto.destino-controller',['destinos_almacen'=>$almacen,'data_suc' =>  $sucursal_ubicacion->get(),
        'cart' => Transferencia::getContent(),'data_cat'=>Category::select('categories.name')->where('categories.categoria_padre','0')->get()
        ])  
        ->extends('layouts.theme.app')
        ->section('content');
    }
    public function increaseQty($productId)

    {
        $product = Product::select('products.id','products.nombre as name')
        ->where('products.id',$productId)->first();
       
        $exist = Transferencia::get($product->id);
       
        if ($exist) {
            $title = 'Cantidad actualizada';
        } else {
            $title = "Producto agregado";
        }

        Transferencia::add($product->id, $product->name,0, 1);

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
        Transferencia::clear();
        $this->selected_destino = "Elegir Destino";
        $this->selected_origen = "Elegir Destino";

    }

    public function exit(){
        $this->resetUI();
        redirect('/destino_prod');
    }
    public function verificarStock(){

    }
    public function verificarDestino(){
    if ($this->selected_destino === $this->selected_origen) {
        $this->emit('empty_destino', 'El destino de la transferencia debe ser diferente al origen');
    }
    if($this->selected_destino == 0 || $this->selected_origen== null)
    $this->emit('empty_destino_origen', 'No ha seleccionado el destino u origen para la transferencia.');
    }

   

    public function finalizar_tr()
    {
       
       $this->verificarDestino();

        DB::beginTransaction();

        try {
            $Transferencia_encabezado = Transference::create([
                'observacion'=>$this->observacion,
                'estado'=>1,//***tiene que depender de modificar la transferencia, esta pendiente
                'id_origen'=>$this->selected_origen,
                'id_destino'=>$this->selected_destino,
            ]);

            if ($Transferencia_encabezado)
            {
                $items = Transferencia::getContent();
                foreach ($items as $item) 
                {
                   $ss=DetalleTransferencia::create([
                        'product_id' => $item->id,
                        'cantidad' => $item->quantity,
                        'estado'=>1//***tiene que depender de modificar la transferencia, esta pendiente
                    ]);
                    $cc[]=$ss->id;

                    $q=ProductosDestino::where('product_id',$item->id)
                    ->where('destino_id',$this->selected_origen)->value('stock');
                    
                  
                    ProductosDestino::where('product_id',$item->id)
                    ->where('destino_id',$this->selected_origen)
                    ->update(['stock'=>($q-$item->quantity)]);
                    

                    $r=ProductosDestino::where('product_id',$item->id)
                    ->where('destino_id',$this->selected_destino)->value('stock');
                    
                  
                    ProductosDestino::where('product_id',$item->id)
                    ->where('destino_id',$this->selected_destino)
                    ->update(['stock'=>($r+$item->quantity)]);

                    /*DB::table('productos_destinos')
                    ->updateOrInsert(['stock'],$item->quantity, ['product_id' => $item->id, 'destino_id'=>$this->destino]);*/
                    
                }
                
                   $mm= EstadoTransferencia::create([
                        'estado'=>1,
                        'op'=>1,
                        'id_transferencia'=>$Transferencia_encabezado->id,
                        'id_usuario'=>Auth()->user()->id
                    ]);

                    foreach ($cc as $item) {
                        EstadoTransDetalle::create([
                            'estado_id'=>$mm->id,
                            'detalle_id'=>$item
                        ]);
                    }    
            }
            DB::commit();
            $this->resetUI();
           
            $this->itemsQuantity = Transferencia::getTotalQuantity();
            redirect('/transferencias');
        
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

}