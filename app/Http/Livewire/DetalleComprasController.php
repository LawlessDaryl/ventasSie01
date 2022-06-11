<?php

namespace App\Http\Livewire;

use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\Destino;
use App\Http\Livewire\ProvidersController as Prov;
use App\Http\Livewire\ProductsController as Products;
use App\Models\Category;
use App\Models\Marca;
use App\Models\Movimiento;
use App\Models\MovimientoCompra;
use App\Models\Product;
use App\Models\ProductosDestino;
use App\Models\Provider;
use App\Models\Sucursal;
use App\Models\Unidad;
use Carbon\Carbon;
use Livewire\Component;

use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;


use Darryldecode\Cart\Facades\ComprasFacade as Compras;
use Exception;
use Illuminate\Support\Facades\Auth;

class DetalleComprasController extends Component
{

    
    use WithPagination;
    use WithFileUploads;
    public  $nro_compra,$search,$provider,$fecha_compra,$vs=[],
    $usuario,$metodo_pago,$pago_parcial=0,$tipo_documento,$nro_documento,$observacion
    ,$selected_id,$descuento=0,$saldo=0,$subtotal,$cantidad_minima,
    $estado_compra,$total_compra,$itemsQuantity,$price,$status,$tipo_transaccion,$destino,$porcentaje,$importe,$dscto=0,$aplicar=false, $lote_compra;

    public $nombre_prov, $apellido_prov, $direccion_prov, $correo_prov,
    $telefono_prov;

    public $nombre,$costo, $precio_venta,$barcode,$codigo,$caracteristicas,$lote,$unidad, $marca, $garantia,$industria,
    $categoryid,$component,$selected_categoria,$image,$selected_id2;

    private $pagination = 5;
   
    public function mount()
    {
        $this->componentName= "Compras";
        $this->fecha_compra = Carbon::now()->format('Y-m-d');
        $this->usuario = Auth()->user()->name;
        $this->estado_compra = "finalizada";
        $this->selected_id = 0;
        $this->pago_parcial = 0;
        $this->destino = 'Elegir';
        $this->tipo_transaccion = "CONTADO";
        $this->tipo_documento = "FACTURA";
        $this->status = "ACTIVO";
        
        $this->subtotal = Compras::getTotal();
        $this->total_compra= $this->subtotal-$this->dscto;
        $this->porcentaje=0;
        $this->verPermisos();
      
  
    }
    public function render()
    {
        if (strlen($this->search) > 0)
        $prod = Product::select('products.*')
        ->where('nombre', 'like', '%' . $this->search . '%')
        ->orWhere('codigo','like','%'.$this->search.'%')
        ->orWhere('marca','like','%'.$this->search.'%')
        ->orWhere('id','like','%'.$this->search.'%')
        ->get();
        else
        $prod = "cero";
//---------------Select destino de la compra----------------------//
       $data_destino= Sucursal::join('destinos as dest','sucursals.id','dest.sucursal_id')
       ->whereIn('dest.id',$this->vs)
       ->select('dest.*','dest.id as destino_id','sucursals.*')
       ->get();

//--------------------Select proveedor---------------------------//
       $data_provider= Provider::select('providers.*')->get();
        return view('livewire.compras.detalle_compra',['data_prod' => $prod,
        'cart' => Compras::getContent()->sortBy('name'),
        'data_suc'=>$data_destino,
        'data_prov'=>$data_provider,
        'categories'=>Category::where('categories.categoria_padre',0)->orderBy('name', 'asc')->get(),
        'unidades'=>Unidad::orderBy('nombre','asc')->get(),
        'marcas'=>Marca::select('nombre')->orderBy('nombre','asc')->get(),
        'subcat'=>Category::where('categories.categoria_padre',$this->selected_id2)->where('categories.categoria_padre','!=','Elegir')->get()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
     }
  
     public function verPermisos(){
       
        $ss= Destino::select('destinos.id','destinos.nombre')->get();
        $arr=[];
        foreach ($ss as $item){
            $arr[$item->nombre.'_'.$item->id]=($item->id);
            
        }

       foreach ($arr as $key => $value) {
        if (Auth::user()->hasPermissionTo($key)) {
            array_push($this->vs,$value);
        }
       }

    }

    public function increaseQty($productId, $cant = 1,$precio_compra = 0)
    {  
       
        $product = Product::select('products.*')
        ->where('products.id',$productId)->first();
       
        $exist = Compras::get($product->id);
        $attributos=[
            'precio'=>$product->precio_venta,
            'codigo'=>$product->codigo,
            'fecha_compra'=>$this->fecha_compra
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
         $this->subtotal = Compras::getTotal();
         $this->total_compra= $this->subtotal-$this->dscto;

    }
    public function addProvider(){
        $obj= new Prov;
        $obj->nombre_prov = $this->nombre_prov;
        $obj->apellido = $this->apellido_prov;
        $obj->direccion = $this->direccion_prov;
        $obj->correo = $this->correo_prov;
        $obj->telefono = $this->telefono_prov;

        $obj->Store();
        $this->resetProv();
        $this->emit('prov_added', 'Proveedor Registrado');

    }
    public function GenerateCode(){
        
        $min=10000;
        $max= 99999;
        $this->codigo= Carbon::now()->format('ymd').mt_rand($min,$max);
    }

    public function Store(){
        
        $prod = new Products;
        $prod->selected_id2=$this->selected_id2;
        $prod->nombre= $this->nombre;
        $prod->costo=$this->costo;
        $prod->precio_venta=$this->precio_venta;
        $prod->barcode=$this->barcode;
        $prod->codigo =$this->codigo;
        $prod->caracteristicas=$this->caracteristicas;
        $prod->lote =$this->lote;
        $prod->unidad=$this->unidad;
        $prod->marca=$this->marca;
        $prod->cantidad_minima=$this->cantidad_minima;
        $prod->garantia =$this->garantia;
        $prod->industria=$this->industria;
        $prod->categoryid=$this->categoryid;
        $prod->Store();
        $this->resetUI();
        $this->emit('products_added','ahola');

    }

    public function UpdateQty($productId, $cant = 3)
    {
      
        $product = Product::select('products.*')
        ->where('products.id',$productId)->first();
       
        $exist = Compras::get($productId);
        $prices=$exist->price;
        $precio_venta=$exist->attributes->precio;
        $codigo=$exist->attributes->codigo;
     
       
        $this->removeItem($productId);
       
        if ($cant > 0) {

          
            //Compras::add($product->id, $product->name,$prices, $cant);
            $attributos=[
                'precio'=>$precio_venta,
                'codigo'=>$codigo,
                'fecha_compra'=>$this->fecha_compra
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
            $this->subtotal = Compras::getTotal();
            $this->total_compra= $this->subtotal-$this->dscto;

        }
    }

    public function UpdatePrice($productId, $price = 20)
    {
        $product = Product::select('products.*')
        ->where('products.id',$productId)->first();
        $exist = Compras::get($productId);
        $quantitys=$exist->quantity;
        $precio_venta=$exist->attributes->precio;
        $codigo=$exist->attributes->codigo;
        $this->removeItem($productId);
       
        if ($price > 0) 
        {
            
            $attributos=[
                'precio'=>$precio_venta,
                'codigo'=>$codigo,
                'fecha_compra'=>$this->fecha_compra
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
            $this->total_compra= $this->subtotal-$this->dscto;
        }
    }

    public function aplicarDescto(){
        $this->dscto=$this->descuento;
        $this->emit('dscto_added','Descuento aplicado satisfactoriamente');
        $this->total_compra=$this->subtotal-$this->dscto;
    }

    public function cancelDscto(){
        $this->descuento=null;
        $this->porcentaje=0;
    }

    public function UpdatePrecioVenta($productId, $price = 20)
    {
      
        $product = Product::select('products.*')
        ->where('products.id',$productId)->first();
       
        $exist = Compras::get($productId);
        $quantitys=$exist->quantity;
        $precio_compra=$exist->price;
        $codigo=$exist->attributes->codigo;
       
        

        $this->removeItem($productId);
       
        if ($price > 0) 
        {
            
            $attributos=[
                'precio'=>$price,
                'codigo'=>$codigo,
                'fecha_compra'=>$this->fecha_compra
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
            $this->total_compra= $this->subtotal-$this->dscto;
    }
    }


    public function removeItem($productId)
    {
        Compras::remove($productId);

        $this->subtotal = Compras::getTotal();
        $this->itemsQuantity = Compras::getTotalQuantity();
      
        if ($this->itemsQuantity <=0) 
        {
            $this->dscto=0;
        }

        $this->total_compra= $this->subtotal-$this->dscto;
        $this->descuento_change();
        if ( $this->descuento>0) 
        {
            
            $this->porcentaje= (round($this->descuento/$this->subtotal,2))*100;
        }

    }

    public function exit(){
        Compras::clear();
        $this->resetUI();
        redirect('/compras');
    }

    public function resetUI()
    {
        $this->costo = '';
        $this->nombre = '';
        $this->precio_venta='';
        $this->caracteristicas='';
        $this->codigo ='';
        $this->lote = '';
        $this->unidad = '';
        $this->marca = null;
        $this->industria = '';
        $this->garantia = null;
        $this->cantidad_minima = null;
        $this->categoryid = 'Elegir';
        $this->image = null;

        $this->resetValidation();
       
    }
    public function resetProv()
    {
        $this->nombre_prov='';
        $this->apellido_prov='';
        $this->direccion_prov='';
        $this->correo_prov='';
        $this->telefono_prov='';
        $this->resetValidation();
    }
 

    public function descuento_change(){
        if ($this->subtotal>0 && $this->descuento>0 && $this->descuento<$this->subtotal) {
            
            //$this->total_compra= $this->subtotal-$this->descuento;
            $this->porcentaje= (round($this->descuento/$this->subtotal,2))*100;
        }
        else{
            $this->descuento =0;
        }
    }
    public function validateCarrito(){
        if (Compras::getTotalQuantity() == 0) {
            $this->emit('empty_cart', 'No tiene productos en el detalle de compra');
            return false;
        }
        else{
            return true;
        }
    }

    public function guardarCompra()
    {

        $rules = [
            'provider'=>'required|exists:providers,nombre_prov',
            'destino'=>'required|not_in:Elegir',
            'lote_compra'=>'required'
        ];
        $messages = [
            'provider.required' => 'El nombre del proveedor es requerido.',
            'provider.exists' => 'El proveedor es inexistente.',
            'destino.required'=>'Elige un destino',
            'destino.not_in'=>'Elija un destino del producto',
            'lote_compra.required'=>'El lote de compra es requerido'
        ];

        $this->validate($rules, $messages);
        $this->validateCarrito();

        /*if ($this->subtotal<= 0) 
        {
            $this->emit('sale-error', 'Agrega productos a la compra');
            return;
        }*/

        if ($this->tipo_transaccion == "Credito") {
            $this->saldo =$this->total_compra-$this->pago_parcial;
            $this->importe=$this->pago_parcial;
        }
        else{
            $this->importe=$this->total_compra;
        }
       
if ($this->validateCarrito()) {
    DB::beginTransaction();

    try {
        


        $Compra_encabezado = Compra::create([

            'importe_total'=>$this->total_compra,
            'descuento'=>$this->descuento,
            'fecha_compra'=>$this->fecha_compra,
            'transaccion'=>$this->tipo_transaccion,
            'saldo'=>$this->saldo,
            'tipo_doc'=>$this->tipo_documento,
            'nro_documento'=>$this->nro_documento,
            'observacion'=>$this->observacion,
            'proveedor_id'=>Provider::select('providers.id')->where('nombre_prov',$this->provider)->value('providers.id'),
            'estado_compra'=>$this->estado_compra,
            'status'=>$this->status,
            'destino_id'=>$this->destino,
            'user_id'=> Auth()->user()->id,
            'lote_compra'=> $this->lote_compra 
        ]);

        if ($this->tipo_transaccion === 'Contado' || $this->pago_parcial>0) {

            $Movimiento= Movimiento::create([
                
                'type'=>"COMPRAS",
                'status'=>"ACTIVO",
                'saldo'=>$this->saldo,
                'on_account'=>$this->pago_parcial,
                'import'=>$this->importe,
                'user_id' => Auth()->user()->id
            ]);

            $ss = MovimientoCompra::create([
                'compra_id'=>$Compra_encabezado->id,
                'movimiento_id' => $Movimiento->id
            ]);
        }
       
        
        if ($Compra_encabezado)
        {
         
            $items = Compras::getContent();
            if ($this->tipo_documento == 'FACTURA') {
                foreach ($items as $item) {
                    CompraDetalle::create([
                        'precio' => $item->price*0.87,
                        'cantidad' => $item->quantity,
                        'product_id' => $item->id,
                        'compra_id' => $Compra_encabezado->id,
                        
                        
                    ]);
                    
                    /*DB::table('productos_destinos')
                    ->updateOrInsert(['stock'],$item->quantity, ['product_id' => $item->id, 'destino_id'=>$this->destino]);*/
                    
                    $q=ProductosDestino::where('product_id',$item->id)
                    ->where('destino_id',$this->destino)->value('stock');

                    ProductosDestino::updateOrCreate(['product_id' => $item->id, 'destino_id'=>$this->destino],['stock'=>$q+$item->quantity]);

                }
            }
            else{
                foreach ($items as $item) {
                    CompraDetalle::create([
                        'precio' => $item->price,
                        'cantidad' => $item->quantity,
                        'product_id' => $item->id,
                        'compra_id' => $Compra_encabezado->id
                    ]);
                    
                    /*DB::table('productos_destinos')
                    ->updateOrInsert(['stock'],$item->quantity, ['product_id' => $item->id, 'destino_id'=>$this->destino]);*/
                    
                    $q=ProductosDestino::where('product_id',$item->id)
                    ->where('destino_id',$this->destino)->value('stock');

                    ProductosDestino::updateOrCreate(['product_id' => $item->id, 'destino_id'=>$this->destino],['stock'=>$q+$item->quantity]);

                }
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

        redirect('/compras');
        //$this->emit('print-ticket', $sale->id);
    } catch (Exception $e) {
        DB::rollback();
        dd($e->getMessage());
        
    }
}
      
    }

    public function EditCompra($id){
        $cp=Compra::find($id);
        
        foreach ($cp->compradetalle as $data) 
        {
            
        }

    }



  

}
