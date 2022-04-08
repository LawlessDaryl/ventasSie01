<?php

namespace App\Http\Livewire;

use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\Destino;
use App\Models\Movimiento;
use App\Models\Movimiento_Compra;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Sucursal;
use Carbon\Carbon;
use Livewire\Component;

use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;


use Darryldecode\Cart\Facades\ComprasFacade as Compras;
use Exception;

class DetalleComprasController extends Component
{

    
    use WithPagination;
    use WithFileUploads;
    public  $nro_compra,$search,$provider,$fecha_compra,
    $usuario,$metodo_pago,$pago_parcial,$tipo_documento,$nro_documento,$observacion
    ,$selected_id,$descuento=0,$impuestos,$selected_transaccion,$saldo_por_pagar,$selected_proveedor,$subtotal,
    $estado_compra,$total_compra,$itemsQuantity,$price,$status,$tipo_transaccion,$destino,$porcentaje,
    $alicuota=0.13;

    private $pagination = 5;
    public function mount()
    {
        $this->nro_compra = 00200;
      
        $this->fecha = Carbon::now();
        $this->usuario = Auth()->user()->name;
        $this->estado_compra = "finalizada";
        $this->selected_id = 0;
        $this->price = 9;
        $this->tipo_transaccion = "CONTADO";
        $this->status = "ACTIVO";
        $this->total_compra= $this->subtotal-$this->descuento;
        $this->subtotal = Compras::getTotal();
        $this->itemsQuantity = Compras::getTotalQuantity();
        $this->porcentaje=0;
  
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

       $data_destino= Sucursal::join('destinos as dest','sucursals.id','dest.sucursal_id')
       ->select('dest.*','sucursals.*')->get();

       $data_provider= Provider::select('providers.*')->get();
  

        return view('livewire.compras.detalle_compra',['data_prod' => $prod,
        'cart' => Compras::getContent()->sortBy('name'),
        'data_suc'=>$data_destino,
        'data_prov'=>$data_provider
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
  

    public function increaseQty($productId, $cant = 1,$precio_compra = 0)
    {  
        $title = 'aaa';
        $product = Product::select('products.*')
        ->where('products.id',$productId)->first();
       
        $exist = Compras::get($product->id);
        if ($exist) {
            $title = 'Cantidad actualizada';
        } else {
            $title = "Producto agregado";
        }

        $attributos=[
            'precio'=>$product->precio_venta,
            'codigo'=>$product->codigo
        ];

        $products = array(
            'id'=>$product->id,
            'name'=>$product->nombre,
            'price'=>$precio_compra,
            'quantity'=>$cant,
            'attributes'=>$attributos
        );

        
        
        Compras::add($products);
        // Compras::add($product->id, $product->name, $precio_compra, $cant);
        
        $this->total = Compras::getTotal();
        $this->itemsQuantity = Compras::getTotalQuantity();
        $this->emit('scan-ok', $title);
         $this->subtotal = Compras::getTotal();
         $this->total_compra= $this->subtotal-$this->descuento;

    }

    public function UpdateQty($productId, $cant = 3)
    {
        $title = '';
        $product = Product::select('products.*')
        ->where('products.id',$productId)->first();
       
        $exist = Compras::get($productId);
        $prices=$exist->price;
        $precio_venta=$exist->attributes->precio;
        $codigo=$exist->attributes->codigo;
       
        if ($exist) {
            $title = "cantidad actualizada";
        } else {
            $title = "producto agregado";
        }
       
        $this->removeItem($productId);
       
        if ($cant > 0) {

          
            //Compras::add($product->id, $product->name,$prices, $cant);
            $attributos=[
                'precio'=>$precio_venta,
                'codigo'=>$codigo
            ];
    
            $products = array(
                'id'=>$product->id,
                'name'=>$product->nombre,
                'price'=>$prices,
                'quantity'=>$cant,
                'attributes'=>$attributos
            );
    
            
            
            Compras::add($products);
            $this->subtotal = Compras::getTotal();
            $this->itemsQuantity = Compras::getTotalQuantity();
            $this->emit('scan-ok', $title);
            $this->subtotal = Compras::getTotal();
            $this->total_compra= $this->subtotal-$this->descuento;



        }
    }

    public function UpdatePrice($productId, $price = 20)
    {
        $title = '';
        $product = Product::select('products.*')
        ->where('products.id',$productId)->first();
       
        $exist = Compras::get($productId);
        $quantitys=$exist->quantity;
        $precio_venta=$exist->attributes->precio;
        $codigo=$exist->attributes->codigo;
       
        if ($exist) {
            $title = "cantidad actualizada";
        } else {
            $title = "producto agregado";
        }

     
       
        $this->removeItem($productId);
       
        if ($price > 0) 
        {
            
            $attributos=[
                'precio'=>$precio_venta,
                'codigo'=>$codigo
            ];
    
            $products = array(
                'id'=>$product->id,
                'name'=>$product->nombre,
                'price'=>$price,
                'quantity'=>$quantitys,
                'attributes'=>$attributos
            );
    
            
            
            Compras::add($products);

            $this->subtotal = Compras::getTotal();
            $this->itemsQuantity = Compras::getTotalQuantity();
            $this->emit('scan-ok', $title);
            $this->subtotal = Compras::getTotal();
            $this->total_compra= $this->subtotal-$this->descuento;
        }
    }

    public function UpdatePrecioVenta($productId, $price = 20)
    {
        $title = '';
        $product = Product::select('products.*')
        ->where('products.id',$productId)->first();
       
        $exist = Compras::get($productId);
        $quantitys=$exist->quantity;
        $precio_compra=$exist->price;
        $codigo=$exist->attributes->codigo;
       
        if ($exist) {
            $title = "cantidad actualizada";
        } else {
            $title = "producto agregado";
        }

     
       
        $this->removeItem($productId);
       
        if ($price > 0) 
        {
            
            $attributos=[
                'precio'=>$price,
                'codigo'=>$codigo
            ];

            $new_price=Product::find($productId);
            $new_price->update([
                'precio_venta'=>$price
            ]);
            $new_price->save();
    
            $products = array(
                'id'=>$product->id,
                'name'=>$product->nombre,
                'price'=>$precio_compra,
                'quantity'=>$quantitys,
                'attributes'=>$attributos
            );
    
            
            
            Compras::add($products);

            $this->subtotal = Compras::getTotal();
            $this->itemsQuantity = Compras::getTotalQuantity();
            $this->emit('scan-ok', $title);
            $this->subtotal = Compras::getTotal();
            $this->total_compra= $this->subtotal-$this->descuento;
    }
    }


    public function removeItem($productId)
    {
        Compras::remove($productId);

        $this->subtotal = Compras::getTotal();
        $this->itemsQuantity = Compras::getTotalQuantity();
        $this->emit('scan-ok', 'Producto eliminado');
        $this->subtotal = Compras::getTotal();
        $this->total_compra= $this->subtotal-$this->descuento;
        $this->descuento_change();
        if ($this->descuento!=0 && $this->descuento>0) {
            
            $this->porcentaje= (round($this->descuento/$this->subtotal,2))*100;
        }

    }

    public function resetUI()
    {
        $this->nombre = '';
        $this->selected_id=0;
       
    }

    public function calcularImpuestos()
    {
        if ($this->tipo_documento == "FACTURA")
        {
            
            $this->impuestos= $this->total_compra*$this->alicuota;

        }
        else
        {
            $this->impuestos= 0;
        }

    }
    public function descuento_change(){
        if ($this->descuento !=0 && $this->subtotal>0 && $this->descuento>0 && $this->descuento<$this->subtotal) {
            
            $this->total_compra= $this->subtotal-$this->descuento;
            $this->porcentaje= (round($this->descuento/$this->subtotal,2))*100;
        }
        else{
            $this->descuento =0;
        }
    }

    public function guardarCompra()
    {

        $this->calcularImpuestos();

        if ($this->subtotal<= 0) 
        {
            $this->emit('sale-error', 'Agrega productos a la compra');
            return;
        }
       
      
        DB::beginTransaction();

        try {
            // Creando Movimiento
            $Compra_encabezado = Compra::create([

                'importe_total'=>$this->total_compra,
                'descuento'=>$this->descuento,
                'fecha_compra'=>$this->fecha_compra,
                'impuestos'=>$this->impuestos,
                'transaccion'=>$this->selected_transaccion,
                'saldo_por_pagar'=>$this->total_compra-$this->pago_parcial,
                'tipo_doc'=>$this->tipo_documento,
                'nro_documento'=>$this->nro_documento,
                'observacion'=>$this->observacion,
                'proveedor_id'=>$this->selected_proveedor,
                'estado_compra'=>$this->estado_compra,
                'status'=>$this->status
            ]);
           
            dd($Compra_encabezado);


            $Movimiento= Movimiento::create([
                
                'type'=>"COMPRAS",
                'status'=>"ACTIVO",
                'saldo'=>$this->total_compra- $this->pago_parcial,
                'on_account'=>$this->pago_parcial,
                'import'=>$this->pago_parcial,
                'user_id' => Auth()->user()->id

            ]);

            Movimiento_Compra::create([
                'compra_id'=>$Compra_encabezado->id,
                'movimiento_id' => $Movimiento->id
            ]);

            if ($Compra_encabezado)
            {
                $items = Compras::getContent();
                foreach ($items as $item) {
                    CompraDetalle::create([
                        'precio' => $item->price,
                        'cantidad' => $item->quantity,
                        'product_id' => $item->id,
                        'compra_id' => $Compra_encabezado->id,
                        
                    ]);

                    $product = Product::find($item->id);
                    $product->stock = $product->stock + $item->quantity;
                    $product->save();
                }
            }

            DB::commit();

            Compras::clear();
            $this->total_compra = 0;
            $this->subtotal = 0;
            $this->provider="";
            $this-> destino ="";
            $this-> descuento =0;
            $this-> porcentaje =0;
            $this->  tipo_transaccion ="Contado";
            $this->  pago_parcial ="";
            $this-> tipo_documento = "Factura" ;
            $this-> nro_documento = "" ;
            $this-> observacion = "" ;

            $this->total = Compras::getTotal();
            $this->itemsQuantity = Compras::getTotalQuantity();
            $this->emit('save-ok', 'venta registrada con exito');
            //$this->emit('print-ticket', $sale->id);
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('sale-error', $e->getMessage());
        }
    }



  

}
