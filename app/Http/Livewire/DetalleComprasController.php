<?php

namespace App\Http\Livewire;

use App\Models\Compra;
use App\Models\Destino;
use App\Models\Movimiento;
use App\Models\Movimiento_Compra;
use App\Models\Product;
use App\Models\Sucursal;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

use Darryldecode\Cart\Facades\ComprasFacade as Compras;

class DetalleComprasController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public  $nro_compra,$search,$provider,$fecha_compra,
    $usuario,$metodo_pago,$pago_parcial,$tipo_documento,$nro_documento,$observacion
    ,$selected_id,$descuento=0,$impuestos,$selected_transaccion,$saldo_por_pagar,$selected_proveedor,$subtotal,
    $estado_compra,$total_compra,$itemsQuantity,$price,$status,$tipo_transaccion,$destino,
    $alicuota=0.13;

    private $pagination = 5;
    public function mount()
    {
        $this->nro_compra = 00200;
        $this->provider = "NO DEFINIDO";
        $this->fecha = Carbon::now();
        $this->usuario = Auth()->user()->name;
        $this->estado_compra = "finalizada";
        $this->selected_id = 0;
        $this->price = 9;
        $this->tipo_transaccion = "CONTADO";
        $this->status = "ACTIVO";

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

       $data_destino= Sucursal::join('destinos as dest','sucursals.id','dest.sucursal_id')
       ->select('dest.*','sucursals.*')->get();


        return view('livewire.compras.detalle_compra',['data_prod' => $prod,
        'cart' => Compras::getContent()->sortBy('name'),
        'data_suc'=>$data_destino
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

    public function guardarCompra()
    {

        calcularImpuestos();

        if ($this->total_compra <= 0) {
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
            // Creando Cliente_Movimiento


            $Movimiento= Movimiento::create([
                
                
            ]);

            Movimiento_Compra::create([
                'compra_id'=>$Compra_encabezado->id,
                'movimiento_id' => $Movimiento->id
            ]);



            $sale = Sale::create([
                'total' => $this->total,
                'items' => $this->itemsQuantity,
                'cash' => $this->efectivo,
                'change' => $this->change,
                'movimiento_id' => $Movimiento->id,
                'user_id' => Auth()->user()->id
            ]);

            if ($sale) {
                $items = Cart::getContent();
                foreach ($items as $item) {
                    SaleDetail::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'product_id' => $item->id,
                        'sale_id' => $sale->id,
                    ]);

                    $product = Product::find($item->id);
                    $product->stock = $product->stock - $item->quantity;
                    $product->save();
                }
            }

            DB::commit();

            Cart::clear();
            $this->efectivo = 0;
            $this->change = 0;
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('save-ok', 'venta registrada con exito');
            //$this->emit('print-ticket', $sale->id);
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('sale-error', $e->getMessage());
        }
    }



  

}
