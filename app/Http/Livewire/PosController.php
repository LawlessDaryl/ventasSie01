<?php

namespace App\Http\Livewire;

use App\Models\Denomination;
use App\Models\Product;
use Livewire\Component;
use App\Models\Cliente;
use App\Models\Company;
use App\Models\Destino;
use App\Models\User;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Livewire\WithPagination;

class PosController extends Component
{
    //VARIABLES PARA LOS ELEMENTOS QUE ESTAN EN LA PARTE SUPERIOR DE LA VISTA DE UNA VENTA
    //Total Bs en una Venta
    public $total_bs;
    //Cantidad Total de Productos en una Venta
    public $total_items;





    //Variable para Buscar por el Nombre o Código de uno o mas Productos
    public $buscarproducto;
    //Variable para mostrar en un Mensaje Toast (Mensaje Emergente Arriba a la derecha en la Pantalla)
    public $mensaje_toast;
    //Variable para guardar la cantidad de dinero y cambio que se debe dar al cliente en una venta
    public $dinero_recibido, $cambio; 

    use WithPagination;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->total_bs = Cart::getTotal();
        $this->total_items = Cart::getTotalQuantity();
    }
    public function render()
    {
        //Variable para guardar todos los productos encontrados que contengan el nombre o código en $buscarproducto
        $listaproductos = [];
        if($this->buscarproducto != "")
        {
            $listaproductos = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
            ->join('destinos as des', 'des.id', 'pd.destino_id')
            ->select("products.id as id","products.nombre as nombre", "products.image as image", "products.precio_venta as precio_venta",
            "pd.stock as stock", "products.codigo as barcode")
            ->where("des.nombre", 'TIENDA')
            ->where("des.sucursal_id", $this->idsucursal())
            ->where('products.nombre', 'like', '%' . $this->buscarproducto . '%')
            ->orWhere('products.codigo', 'like', '%' . $this->buscarproducto . '%')
            ->groupBy('products.id')
            ->paginate(10);
        }






        //Modulo para Calcular el Cambio
        if($this->dinero_recibido < 0 || $this->dinero_recibido == "-")
        {
            $this->dinero_recibido = 0;
        }
        if($this->dinero_recibido != "")
        {
            $this->cambio = $this->dinero_recibido - $this->total_bs;
        }
        //---------------------------------------------------------------
        return view('livewire.pos.component', [
            'denominations' => Denomination::orderBy('id', 'asc')->get(),
            'listaproductos' => $listaproductos,
            'cart' => Cart::getContent(),
            'logoempresa' => Company::find(1)->image

        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    //Obtener el Id de la Sucursal donde esta el Usuario
    public function idsucursal()
    {
        $idsucursal = User::join("sucursal_users as su","su.user_id","users.id")
        ->select("su.sucursal_id as id","users.name as n")
        ->where("users.id",Auth()->user()->id)
        ->where("su.estado","ACTIVO")
        ->get()
        ->first();
        return $idsucursal->id;
    }
     //Incrementar Items en el Carrito
    public function increase(Product $producto)
    {
        //Para saber si el Producto ya esta en el carrrito para cambiar el Mensaje Toast de Producto Agregado a Cantidad Actualizada
        $exist = Cart::get($producto->id);
        if ($exist)
        {
            $this->mensaje_toast = 'Cantidad Actualizada';
        }
        else
        {
            $this->mensaje_toast = "Producto Agregado";
        }
        
        if($producto->image == null)
        {
            Cart::add($producto->id, $producto->nombre, $producto->precio_venta, 1 , '56');
            $this->mensaje_toast = "¡'" . $producto->nombre . "' agregado correctamente!";
            $this->emit('scan-ok');
        }
        else
        {
            Cart::add($producto->id, $producto->nombre, $producto->precio_venta, 1 , $producto->image);
            $this->mensaje_toast = "¡'" . $producto->nombre . "' agregado correctamente!";
            $this->emit('scan-ok');
        }
        $this->actualizarvalores();
    }
    //Llama al modal para calcular cambio y finalizar una venta
    public function modalfinalizarventa()
    {
        $this->emit('show-finalizarventa');
    }
    protected $listeners = [
        'scan-code' => 'ScanCode',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale'
    ];
    public function ScanCode($barcode, $cant = 1)
    {
        //Buscando Stock del Producto en Tienda
        $product = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
        ->join('destinos as des', 'des.id', 'pd.destino_id')
        ->select("products.id as id","products.image as image","des.sucursal_id as sucursal_id","products.nombre as name",
        "products.precio_venta as price","products.codigo", "pd.stock as stock")
        ->where("products.codigo", $barcode)
        ->where("des.nombre", 'TIENDA')
        ->where("des.sucursal_id", $this->idsucursal())
        ->get()->first();
        
        
        if ($product == null || empty($product))
        {
            $this->emit('scan-notfound', 'El producto no esta registrado o no existe en esta Sucursal');
        }
        else
        {
        //Añadiendo al Carrrito los Productos
        Cart::add(
            $product->id,
            $product->name,
            $product->price,
            $cant,
            $product->image
        );
        $this->actualizarvalores();
        $this->mensaje_toast = "¡Producto: '" . $product->name . "' escaneado correctamente!";
        $this->emit('scan-ok');
            
        }
    }
    //Vaciar todos los Items en el Carrito
    public function clearcart()
    {
        Cart::clear();
        // $this->efectivo = 0;
        // $this->change = 0;

        $this->actualizarvalores();
        //$this->emit('scan-ok', 'Carrito vacio');
    }
    //Actualizar los valores de Total Bs y Total Artículos en una Venta
    public function actualizarvalores()
    {
        $this->total_bs = Cart::getTotal();
        $this->total_items = Cart::getTotalQuantity();
    }
    //Sumar Denominaciones de Monedas y Billetes a la variable $dinero_recibido
    public function sumar($value)
    {
        if($value == 0)
        {
            $this->dinero_recibido = $this->total_bs;
        }
        else
        {
            if($this->dinero_recibido == "")
            {
                $this->dinero_recibido = 0;
            }
            $this->dinero_recibido = $this->dinero_recibido + $value;
        }
    }
}
