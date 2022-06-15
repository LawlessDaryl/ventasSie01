<?php

namespace App\Http\Livewire;
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
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Darryldecode\Cart\Facades\EditarTransferenciaFacade as EditarTransferencia;
use Exception;



class EditTransferenceController extends Component
{
    
    use WithPagination;
    public $selected_id,$search,
    $itemsQuantity,$selected_3,$selected_origen,$selected_destino,$observacion,$tipo_tr,$estado,$ide,$datalist_destino;
    private $pagination = 10;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount(){

        $this->ide=session('id_transferencia');
        EditarTransferencia::clear();
        $rm=Transference::where('transferences.id',$this->ide)->value('id_origen');
        $this->selected_origen= $rm;
        $this->cargarCarrito();
    }
  
    public function render()
    {
        $this->itemsQuantity = EditarTransferencia::getTotalQuantity();
        if($this->selected_origen !== null && strlen($this->search) > 0){
                                        $almacen= ProductosDestino::join('products as prod','prod.id','productos_destinos.product_id')
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
                                         $almacen=null;
                                        }
                                    

                                                                             
        return view('livewire.transferencia.editartransferencia',['destinos_almacen'=>$almacen,
        'cart' => EditarTransferencia::getContent()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function cargarCarrito()
    {
        $this->datalist_destino=DetalleTransferencia::join('products','detalle_transferencias.product_id','products.id')
        ->join('estado_trans_detalles','detalle_transferencias.id','estado_trans_detalles.detalle_id')
        ->join('estado_transferencias','estado_trans_detalles.estado_id','estado_transferencias.id')
        ->join('transferences','estado_transferencias.id_transferencia','transferences.id')
        ->select('detalle_transferencias.*','transferences.id as tr','estado_transferencias.estado as esty')
        ->where('transferences.id',$this->ide)
        ->where('estado_transferencias.op','Activo')
      
        ->get();
        //$bn =EditarTransferencia::getContent();

        foreach ($this->datalist_destino as $value) 
        {
            
            $product = Product::select('products.*')
            ->where('products.id',$value->product_id)->first();
     
             EditarTransferencia::add($product->id, $product->nombre,0, $value->cantidad);

        }

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
      $auxi=[];
        $carrito= EditarTransferencia::getContent();
        $keyed = $this->datalist_destino->map(function ($item) {
            return ['id'=>$item->product_id,'cantidad'=>$item->cantidad];
        })->keyBy('id');
        

        $keyed2=$carrito->map(function ($item) use($keyed) {
            if ($keyed->contains('id',$item->id)) {
                return [
                    'id'=>$item->id,
                    'cantidad'=>$item->quantity-$keyed[$item->id]['cantidad']
                ];
            }
            else{
                return [
                    'id'=>$item->id,
                    'cantidad'=>$item->quantity
                ];
            }
        });

      
       
        DB::beginTransaction();
        try {

            foreach ($this->datalist_destino as $data) {
                EstadoTransDetalle::where('detalle_id',$data->id)->delete();
                $data->delete();
            }
            foreach ($carrito as $value) {
                $ss=DetalleTransferencia::create([
                    'product_id' => $value->id,
                    'cantidad' => $value->quantity,
                    'estado'=>1//***tiene que depender de modificar la transferencia, esta pendiente
                ]);

                $cc[]=$ss->id;
            }

            foreach ($keyed2 as $item) 
            {
                   // dd($this->selected_origen);
                    $q=ProductosDestino::where('product_id',$item['id'])
                    ->where('destino_id',$this->selected_origen)->value('stock');

                    ProductosDestino::where('product_id',$item['id'])
                    ->where('destino_id',$this->selected_origen)
                    ->update(['stock'=>($q+$item['cantidad'])]);
            }

            $kl=EstadoTransferencia::where('id_transferencia',$this->ide)->pluck('id');
            
            
            foreach ($cc as $item) {
                EstadoTransDetalle::create([
                    'estado_id'=>$kl[0],
                    'detalle_id'=>$item
                ]);
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
