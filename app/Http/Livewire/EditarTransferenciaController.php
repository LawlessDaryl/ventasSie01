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
use Darryldecode\Cart\Facades\EditarFacade;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;


use Darryldecode\Cart\Facades\EditarTransferenciaFacade as EditarTransferencia;
use Exception;
use Illuminate\Support\Facades\Auth;

class EditarTransferenciaController extends Component
{
    
    use WithPagination;

    public $selected_id,$search,
    $itemsQuantity,$selected_3,$selected_origen=0,$selected_destino,$observacion,$tipo_tr,$almacen;
    private $pagination = 10;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    
  
    public function render()
    {
        if($this->selected_origen !== 0 && strlen($this->search) > 0){
                                        $this->almacen= ProductosDestino::join('products as prod','prod.id','productos_destinos.product_id')
                                        ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                                        ->where('dest.id',$this->selected_origen)
                                        ->where('productos_destinos.stock','>',0)
                                        ->where(function($query){
                                            $query->where('prod.nombre', 'like', '%' . $this->search . '%')
                                            ->orWhere('prod.codigo','like','%'.$this->search.'%')
                                            ->orWhere('prod.marca','like','%'.$this->search.'%')
                                            ->orWhere('prod.id','like','%'.$this->search.'%');
                                        })
                                        ->select('prod.nombre as name','dest.nombre as nombre_destino','dest.id as dest_id','prod.id as prod_id','productos_destinos.stock as stock')
                                        ->orderBy('prod.nombre','desc')
                                        ->paginate($this->pagination);
                                        }
                                        else{
                                         $this->almacen=null;
                                        }
                                      

                                    

        return view('livewire.destinoproducto.editartransferencia',['destinos_almacen'=>$this->almacen,
        'cart' => EditarTransferencia::getContent()
        ])  
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function EditTransferencia($id){
        $this->selected_destino="vivalo";
        return view('livewire.destinoproducto.editartransferencia',['destinos_almacen'=>$this->almacen,
        'cart' => EditarTransferencia::getContent()
        ])->extends('layouts.theme.app')
        ->section('content');
    }

    public function increaseQty($productId)

    {
       
        $product = Product::select('products.id','products.nombre as name')
        ->where('products.id',$productId)->first();
       
        $exist = EditarTransferencia::get($product->id);

        $stock=ProductosDestino::where('productos_destinos.product_id',$product->id)
        ->where('productos_destinos.destino_id',$this->selected_origen)->select('productos_destinos.stock')->value('productos_destinos.stock');

      if ($exist) {
        if ($stock>=(1+$exist->quantity))
        {
            EditarTransferencia::add($product->id, $product->name,0, 1);
        }
        else{
           
            $this->emit('no-stock','Sin stock disponible');
        }
      }
      else{
        EditarTransferencia::add($product->id, $product->name,0, 1);
      }
       
    }
    public function UpdateQty($productId, $cant =1)
    {
        
        $product = Product::select('products.id','products.nombre as name')
        ->where('products.id',$productId)->first();
       
        $exist = EditarTransferencia::get($productId);
        

       
        $this->removeItem($productId);
       
        if ($cant > 0) 
        {
            EditarTransferencia::add($product->id, $product->name,0, $cant);
            $this->itemsQuantity = EditarTransferencia::getTotalQuantity();
            $this->emit('scan-ok');
        }
    }
    public function removeItem($productId)
    {
        EditarTransferencia::remove($productId);
        $this->itemsQuantity = EditarTransferencia::getTotalQuantity();
        $this->emit('scan-ok', 'Producto eliminado');
        $this->tipo_tr ='Elegir operacion';
  
    }

    public function resetUI()
    {
        EditarTransferencia::clear();

    }

    public function exit(){
        $this->resetUI();
        redirect('/destino_prod');
    }


    public function finalizar_tr()
    {
        DB::beginTransaction();

        try {

            
            $Transferencia_encabezado = Transference::create([
                'observacion'=>$this->observacion,
                'estado'=>1,//***tiene que depender de modificar la transferencia, esta pendiente
                'id_origen'=>$this->selected_origen,
                'id_destino'=>$this->selected_destino
            ]);

            if ($Transferencia_encabezado)
            {
                $items = EditarTransferencia::getContent();
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
                    
                  
                    /*ProductosDestino::where('product_id',$item->id)
                    ->where('destino_id',$this->selected_destino)
                    ->update(['stock'=>($r+$item->quantity)]);

                    /*DB::table('productos_destinos')
                    ->updateOrInsert(['stock'],$item->quantity, ['product_id' => $item->id, 'destino_id'=>$this->destino]);*/
  
                }

                   $mm= EstadoTransferencia::create([
                        'estado'=>$this->estado,
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
           
            $this->itemsQuantity = EditarTransferencia::getTotalQuantity();
            redirect('/transferencias');
        
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

}