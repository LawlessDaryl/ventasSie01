<?php

namespace App\Http\Livewire;

use App\Models\Denomination;
use App\Models\Product;
use App\Models\ProductosDestino;
use App\Models\Sale;
use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\SaleDetail;
use App\Models\Movimiento;
use App\Models\ClienteMov;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
//Modulo para buscar clientes en las ventas
use App\Models\Cliente;

use Darryldecode\Cart\Facades\CartFacade as Cart;
use Exception;
use Illuminate\Support\Facades\Redirect;

class PosController extends Component
{
    public $total, $itemsQuantity, $efectivo, $change, 
    $nit, $clienteanonimo="true", $tipopago ,$anonimo, $factura, $facturasino, $nombreproducto;

    //Variables para la venta desde almacen, moviendo productos de almacen a la tienda
    public  $stockalmacen, $nombrestockproducto, $cantidadToTienda = 1, $idproductoalmacen;



    public function mount()
    {
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->ClienteSelectnit = 1;
        $this->ProductSelectNombre = 1;
        $this->tipopago = 'EFECTIVO';
        $this->anonimo = 0;
        $this->facturasino = 'No';

    }
    public function render()
    {
        /* BUSCAR CLIENTE POR NIT*/
        $datosnit = [];
        if (strlen($this->nit) > 0)
        {
            $datosnit = Cliente::where('nit', 'like', '%' . $this->nit . '%')->orderBy('nit', 'desc')->get();
            if ($datosnit->count() > 0)
            {
                $this->BuscarClienteNit = 1;
            }
            else
            {
                $this->BuscarClienteNit = 0;
            }
            if ($this->ClienteSelectnit == 0)
            {
                $this->BuscarClienteNit = 0;
            }
        }
        else
        {
            //Para cerrar el cuadro de clientes encontrados por Nit cuando se borre todos los caracteres del input
            $this->BuscarClienteNit = 0;
            //---------------------------------------------------------------------------------------------------
            if ($this->ClienteSelectnit == 0)
            {
                $this->ClienteSelectnit = 1;
            }
        }


        /* Buscar Productos por el Nombre*/
        $datosnombreproducto = [];
        if (strlen($this->nombreproducto) > 0)
        {
            $datosnombreproducto = ProductosDestino::join("products as p", "p.id", "productos_destinos.product-id")
            ->join('locations as d', 'd.id', 'productos_destinos.destino-id')
            ->select("p.id as id","p.nombre as nombre", "p.image as image", "p.precio_venta as precio_venta",
            "productos_destinos.stock as stock")
            ->where("d.ubicacion", 'TIENDA')
            ->where('nombre', 'like', '%' . $this->nombreproducto . '%')->orderBy('nombre', 'desc')->get();
            if ($datosnombreproducto->count() > 0)
            {
                $this->BuscarProductoNombre = 1;
            }
            else
            {
                $this->BuscarProductoNombre = 0;
            }
            if ($this->ProductSelectNombre == 0)
            {
                $this->BuscarProductoNombre = 0;
            }
            
        }
        else
        {
            //Para cerrar la tabla de Productos encontrados por Nombre cuando se borre todos los caracteres del input
            $this->BuscarProductoNombre = 0;
            //---------------------------------------------------------------------------------------------------
            if ($this->ProductSelectNombre == 0)
            {
                $this->ProductSelectNombre = 1;
            }
        }





        return view('livewire.pos.component', [
            'denominations' => Denomination::orderBy('id', 'asc')->get(),
            'cart' => Cart::getContent()->sortBy('name'),
            'datosnit' => $datosnit,
            'datosnombreproducto' => $datosnombreproducto
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }


    public function ventafactura()
    {
        if($this->factura == 'true')
        {
            $this->facturasino = 'Si';
        }
        else
        {
            $this->facturasino = 'No';
        }
    }


    public function clienteanonimo()
    {
        if($this->clienteanonimo == 'true')
        {
            $this->anonimo = 0;
        }
        else
        {
            $this->anonimo = 1;
        }
    }


    /* Cargar los datos seleccionados de la tabla a los label */
    public function llenardatoscliente($id)
    {
        $dcliente = Cliente::where('id', $id)->first();
        
        $this->nit = $dcliente->nit;
        $this->razonsocial = $dcliente->razon_social;
        $this->celular = $dcliente->celular;
        $this->ClienteSelectnit = 0;
        $this->idcliente = $id;
        $this->resetUI();
    }
    public function ACash($value)
    {
        $this->efectivo += ($value == 0 ? $this->total : $value);
        $this->change = ($this->efectivo - $this->total);
    }

    protected $listeners = [
        'scan-code' => 'ScanCode',
        'removeItem' => 'removeItem',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale'
    ];
    public function ScanCode($barcode, $cant = 1)
    {
        $product = Product::join("productos_destinos as pd", "pd.product-id", "products.id")
        ->join('locations as d', 'd.id', 'pd.destino-id')
        ->select("products.id as id","products.image as image","products.nombre as name",
        "products.precio_venta as price","products.barcode", "pd.stock as stock")
        ->where("products.barcode", $barcode)
        ->where("d.ubicacion", 'TIENDA')
        ->get()->first();
        //$product = Product::where('barcode', $barcode)->first();
        if ($product == null || empty($product))
        {
            $this->emit('scan-notfound', 'El producto no esta registrado');
        }
        else
        {
            if ($this->inCart($product->id))
            {
                $this->increaseQty($product->id);
                return;
            }
            if ($product->stock < 1)
            {
                $this->emit('no-stock', 'stock insuficiente :/');
                return;
            }
            Cart::add(
                $product->id,
                $product->name,
                $product->price,
                $cant,
                $product->image
            );
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', 'Producto agregado');
        }
    }
    public function InCart($productId)
    {
        $exist = Cart::get($productId);
        if ($exist)
            return true;
        else
            return false;
    }


    public function increaseQty($productId, $cant = 1)
    {
        $title = 'aaaaaaaaaaa';
        $product = Product::join("productos_destinos as pd", "pd.product-id", "products.id")
        ->join('locations as d', 'd.id', 'pd.destino-id')
        ->select("products.id as id","products.image as image","products.nombre as name",
        "products.precio_venta as price","products.barcode", "pd.stock as stock")
        ->where("products.id", $productId)
        ->where("d.ubicacion", 'TIENDA')
        ->get()->first();
        $exist = Cart::get($productId);
        if ($exist)
        {
            $title = 'Cantidad actualizada';
        }
        else
        {
            $title = "Producto agregado";
        }
        if ($exist)
        {
            if ($product->stock < ($cant + $exist->quantity))
            {
                //Buscar Productos en Almacen
                $productoalmacen = Product::join("productos_destinos as pd", "pd.product-id", "products.id")
                ->join('locations as d', 'd.id', 'pd.destino-id')
                ->select("products.id as id","products.image as image","products.nombre as name",
                "products.precio_venta as price","products.barcode", "pd.stock as stock")
                ->where("products.id", $productId)
                ->where("d.ubicacion", 'ALMACEN')
                ->get()->first();
                if($productoalmacen->stock > 0)
                {
                    $this->stockalmacen = $productoalmacen->stock;
                    $this->nombrestockproducto = $productoalmacen->name;
                    $this->idproductoalmacen = $productoalmacen->id;
                    //$this->mostrarmodal = 1;
                    //$this->emit('no-stock', 'Stock Insuficiente en Tienda, Se encontraro Productos Disponibles en Almacen');
                    $this->emit('no-stocktienda');
                    return;
                }
                else
                {
                    $this->emit('no-stock', 'stock insuficiente en TIENDA y ALMACEN');
                    return;
                }
            }
        }
        Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', $title);
    }

    public function UpdateQty($productId, $cant = 1)
    {
        $title = '';
        $product = Product::join("productos_destinos as pd", "pd.product-id", "products.id")
        ->join('locations as d', 'd.id', 'pd.destino-id')
        ->select("products.id as id","products.image as image","products.nombre as name",
        "products.precio_venta as price","products.barcode", "pd.stock as stock")
        ->where("products.id", $productId)
        ->where("d.ubicacion", 'TIENDA')
        ->get()->first();
        //$product = Product::find($productId);
        $exist = Cart::get($productId);
        if ($exist) {
            $title = "cantidad actualizada";
        } else {
            $title = "producto agregado";
        }
        if ($exist) {
            if ($product->stock < $cant) {
                $this->emit('no-stock', 'stock insuficiente :/');
                return;
            }
        }
        $this->removeItem($productId);
        if ($cant > 0) {
            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', $title);
        }

        
    }
    public function removeItem($productId)
    {
        Cart::remove($productId);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Producto eliminado');
    }
    public function decreaseQty($productId)
    {
        $item = Cart::get($productId);
        Cart::remove($productId);
        $product = Product::find($productId);

        $newQty = ($item->quantity) - 1;
        if ($newQty > 0) {
            Cart::add($item->id, $item->name, $item->price, $newQty, $product->image);
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', 'Cantidad actualizada');
        }
        if($newQty==0 && Cart::getTotalQuantity()==0)
        {
            $this->total = 0;
            $this->change = 0;
        }
        $this->itemsQuantity = Cart::getTotalQuantity();

    }

    public function clearCart()
    {
        Cart::clear();
        $this->efectivo = 0;
        $this->change = 0;

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Carrito vacio');
    }

    public function saveSale()
    {

        if ($this->total <= 0) {
            $this->emit('sale-error', 'Agrega productos a la venta');

            return;
        }
        if ($this->efectivo <= 0) {
            $this->emit('sale-error', 'Ingrese efectivo');

            return;
        }
        if ($this->total > $this->efectivo) {
            $this->emit('sale-error', 'El efectivo debe ser mayor o igual al total');

            return;
        }
        DB::beginTransaction();

        try {
            // Creando Movimiento
            $Movimiento = Movimiento::create([
                'type' => "VENTAS",
                'import' => $this->total,
                'user_id' => Auth()->user()->id,
            ]);
            // Creando Cliente_Movimiento 
            //Dependiendo si es o no un Cliente Anònimo
            if($this->clienteanonimo == 'true')
            {
                ClienteMov::create([
                    'movimiento_id' => $Movimiento->id,
                    'cliente_id' => 1,
                ]);
            }
            else
            {
                ClienteMov::create([
                    'movimiento_id' => $Movimiento->id,
                    'cliente_id' => $this->idcliente,
                ]);
            }

            /* Caja en la cual se encuentra el usuario */
            $cajausuario = Caja::join('sucursals as s', 's.id', 'cajas.sucursal_id')
            ->join('sucursal_users as su', 'su.sucursal_id', 's.id')
            ->join('carteras as car', 'cajas.id', 'car.caja_id')
            ->join('cartera_movs as cartmovs', 'car.id', 'cartmovs.cartera_id')
            ->join('movimientos as mov', 'mov.id', 'cartmovs.movimiento_id')
            ->where('mov.user_id', Auth()->user()->id)
            ->where('mov.status', 'ACTIVO')
            ->where('mov.type', 'APERTURA')
            ->select('cajas.id as id')
            ->get()->first();



            // $cajafisica = Cartera::
            // where('caja_id',$cajausuario->id)
            // ->where('tipo','CajaFisica')->get()->first();

            //Topo de Pago en la Venta
            if ($this->tipopago == 'EFECTIVO')
            {
                $cartera = Cartera::where('tipo', 'cajafisica')
                    ->where('caja_id', $cajausuario->id)
                    ->get()->first();
            }
            else
            {
                $cartera = Cartera::where('tipo', $this->tipopago)
                    ->where('caja_id', $cajausuario->id)->get()->first();
            }
            //Creando Venta
            $sale = Sale::create([
                'total' => $this->total,
                'items' => $this->itemsQuantity,
                'cash' => $this->efectivo,
                'change' => $this->change,

                'tipopago' => $this->tipopago,
                'factura' => $this->facturasino,


                'movimiento_id' => $Movimiento->id,
                'user_id' => Auth()->user()->id
            ]);
            //Creando Detalle de Venta
            if ($sale)
            {
                $items = Cart::getContent();
                //dd($items);
                foreach ($items as $item) {
                    SaleDetail::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'product_id' => $item->id,
                        'sale_id' => $sale->id,
                    ]);

                    $product = ProductosDestino::find($item->id);
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
            $this->clienteanonimo = 'true';
            
            

            



            // Creando Cartera Movimiento
            CarteraMov::create([
                'type' => "INGRESO",
                'comentario' => "",
                'cartera_id' => $cartera->id,
                'movimiento_id' => $Movimiento->id,
            ]);

            //Dejando la variable Cliente Anònimo ($anonimo) en True=0
            $this->anonimo = 0;
            //Dejando la variable Factura en False
            $this->factura = 'false';
            $this->facturasino = 'No';
            $this->emit('save-ok', 'venta registrada con exito');

            return Redirect::to('salelist');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('sale-error', $e->getMessage());
        }
    }
    public function printTicket($sale)
    {
        return Redirect::to('print://$sale->id');
    }

    //Mètodo para mover productos de la tabbla ALM
    public function almacenToTienda()
    {
        //Eliminando la cantidad de productos de ALMACEN para pasar a TIENDA
        $productoalmacenid = ProductosDestino::join("products as p", "p.id", "productos_destinos.product-id")
                ->join('locations as d', 'd.id', 'productos_destinos.destino-id')
                ->select("productos_destinos.id as id","p.nombre as name",
                "productos_destinos.stock as stock")
                ->where("p.id", $this->idproductoalmacen)
                ->where("d.ubicacion", 'ALMACEN')
                ->get()->first();


        $productoalmacenid->update([
            'stock' => $productoalmacenid->stock - $this->cantidadToTienda
        ]);
        //Incrementando la cantidad de productos en TIENDA que vienen de ALMACEN
        $productotiendaid = ProductosDestino::join("products as p", "p.id", "productos_destinos.product-id")
                ->join('locations as d', 'd.id', 'productos_destinos.destino-id')
                ->select("productos_destinos.id as id","p.nombre as name",
                "productos_destinos.stock as stock")
                ->where("p.id", $this->idproductoalmacen)
                ->where("d.ubicacion", 'TIENDA')
                ->get()->first();


        $productotiendaid->update([
            'stock' => $productotiendaid->stock + $this->cantidadToTienda
        ]);


        //Añadimos al Carrito
        $this->increaseQty($this->idproductoalmacen, $this->cantidadToTienda);
    }

    // Llamar al Modal de Monedas Para Finalizar las Ventas
    public function FinalizarVenta()
    {
        $this->emit('finalizarventa');
    }

    
    // Quitar los valores de la ventana Modal
    public function resetUI()
    {
        $this->name = '';
        $this->barcode = '';
        $this->cost = '';
        $this->price = '';
        $this->stock = '';
        $this->alerts = '';
        $this->search = '';
        $this->categoryid = 'Elegir';
        $this->image = null;
        $this->selected_id = 0;

        $this->resetValidation();
    }
    public function hola()
    {
        dd("Hola");
    }

}
