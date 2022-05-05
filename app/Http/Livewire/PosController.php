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
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\User;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Exception;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\TryCatch;

class PosController extends Component
{
    public $total, $itemsQuantity, $efectivo, $change, 
    $nit, $clienteanonimo="true", $tipopago ,$anonimo, $factura, $observacion, $facturasino, $nombreproducto, $clienteseleccionado;
    public $razonsocial, $celular="";

    //Variables para la venta desde almacen, moviendo productos de almacen a la tienda
    public  $stockalmacen, $nombrestockproducto, $cantidadToTienda = 1, $idproductoalmacen;

    //Variables para el comprobantes...
    public $idventa, $totalbs, $totalitems;
    //Variables para Calcular el Descuento en Ventas...
    public $descuento, $totalBsBd;

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
        $this->descuento = 0;
        $this->totalBsBd = 0;
        $this->actualizardescuento();

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
            //Buscando Stock del Producto en Tienda
            $datosnombreproducto = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
            ->join('locations as d', 'd.id', 'pd.location_id')
            ->join('destinos as des', 'des.id', 'd.destino_id')
            ->select("products.id as id","products.nombre as nombre", "products.image as image", "products.precio_venta as precio_venta",
            "pd.stock as stock")
            ->where("des.nombre", 'TIENDA')
            ->where("des.sucursal_id", $this->idsucursal())
            ->where('products.nombre', 'like', '%' . $this->nombreproducto . '%')->orderBy('products.nombre', 'desc')
            ->get();

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
            'datosnombreproducto' => $datosnombreproducto,

            'nit' =>$this->nit,
            'razonsocial' =>$this->razonsocial,
            'celular' =>$this->celular
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    //Para Cambiar el valor de facturasino segùn el usuario lo requiera
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

    //Para Saber si se registrara la venta con un Cliente Anònimo
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
        //Para saber si se selecciono un cliente existente
        //Y crear un nuevo cliente al realizar la venta si el valor de $clienteseleccionado es null
        $this->clienteseleccionado = 1;
        //-------------------------------------------------
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
    public function calcularCambio($value)
    {
        $this->change = $value - $this->total;
    }

    protected $listeners = [
        'scan-code' => 'ScanCode',
        'removeItem' => 'removeItem',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale'
    ];
    public function ScanCode($barcode, $cant = 1)
    {
        //Buscando Stock del Producto en Tienda
        $product = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
        ->join('locations as d', 'd.id', 'pd.location_id')
        ->join('destinos as des', 'des.id', 'd.destino_id')
        ->select("products.id as id","products.image as image","des.sucursal_id as sucursal_id","products.nombre as name",
        "products.precio_venta as price","products.barcode", "pd.stock as stock")
        ->where("products.barcode", $barcode)
        ->where("des.nombre", 'TIENDA')
        ->where("des.sucursal_id", $this->idsucursal())
        ->get()->first();
        
        
        if ($product == null || empty($product))
        {
            $this->emit('scan-notfound', 'El producto no esta registrado o no existe en esta Sucursal');
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
                //Buscar Productos en Almacen
                $productoalmacen = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
                ->join('locations as d', 'd.id', 'pd.location_id')
                ->join('destinos as des', 'des.id', 'd.destino_id')
                ->select("products.id as id","products.image as image","des.sucursal_id as sucursal_id","products.nombre as name",
                "products.precio_venta as price","products.barcode", "pd.stock as stock")
                ->where("products.id", $product->id)
                ->where("des.nombre", 'ALMACEN')
                ->where("des.sucursal_id", $this->idsucursal())
                ->get()->first();

                if($productoalmacen->stock > 0)
                {
                    $this->stockalmacen = $productoalmacen->stock;
                    $this->nombrestockproducto = $productoalmacen->name;
                    $this->idproductoalmacen = $productoalmacen->id;
                    //Llamando al modal para Agregar mas Productos
                    $this->emit('no-stocktienda');
                    return;
                }
                else
                {
                    $this->emit('no-stock', 'Stock Insuficiente en TIENDA y ALMACEN');
                    return;
                }
            }
            //Añadiendo al Carrrito los Productos
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

    //Pasar los productos encontrados de la busqueda por palabras al carrito de compras
    public function pasaralcarrito($idproducto,$cant=1)
    {
        //Buscando Stock del Producto en Tienda
        $product = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
        ->join('locations as d', 'd.id', 'pd.location_id')
        ->join('destinos as des', 'des.id', 'd.destino_id')
        ->select("products.id as id","products.image as image","des.sucursal_id as sucursal_id","products.nombre as name",
        "products.precio_venta as price","products.barcode", "pd.stock as stock")
        ->where("products.id", $idproducto)
        ->where("des.nombre", 'TIENDA')
        ->where("des.sucursal_id", $this->idsucursal())
        ->get()->first();
        
        if ($this->inCart($product->id))
            {
                $this->increaseQty($product->id);
                return;
            }
            if ($product->stock < 1)
            {
                //Buscar Productos en Almacen
                $productoalmacen = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
                ->join('locations as d', 'd.id', 'pd.location_id')
                ->join('destinos as des', 'des.id', 'd.destino_id')
                ->select("products.id as id","des.sucursal_id as sucursal_id","products.nombre as name",
                "products.precio_venta as price","products.barcode", "pd.stock as stock")
                ->where("products.id", $product->id)
                ->where("des.nombre", 'ALMACEN')
                ->where("des.sucursal_id", $this->idsucursal())
                ->get()->first();


                if($productoalmacen->stock > 0)
                {
                    $this->stockalmacen = $productoalmacen->stock;
                    $this->nombrestockproducto = $productoalmacen->name;
                    $this->idproductoalmacen = $productoalmacen->id;
                    $this->emit('no-stocktienda');
                    return;
                }
                else
                {
                    $this->emit('no-stock', 'stock insuficiente en TIENDA y ALMACEN');
                    return;
                }
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
            //Para Actualizar el Total Descuento
            $this->actualizardescuento();
    }

    public function increaseQty($productId, $cant = 1)
    {
        //Consulta para saber el Stock de los Productos en Tienda
        $product = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
        ->join('locations as d', 'd.id', 'pd.location_id')
        ->join('destinos as des', 'des.id', 'd.destino_id')
        ->select("products.id as id","products.image as image","des.sucursal_id as sucursal_id","products.nombre as name",
        "products.precio_venta as price","products.barcode", "pd.stock as stock")
        ->where("products.id", $productId)
        ->where("des.nombre", 'TIENDA')
        ->where("des.sucursal_id", $this->idsucursal())
        ->get()->first();
        //---------------------------------------------------------
        //Para saber si el Producto ya esta en carrrito para cambiar el mensaje de Producto Agregado a Cantidad Actualizada
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
                $productoalmacen = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
                ->join('locations as d', 'd.id', 'pd.location_id')
                ->join('destinos as des', 'des.id', 'd.destino_id')
                ->select("products.id as id","products.image as image","des.sucursal_id as sucursal_id","products.nombre as name",
                "products.precio_venta as price","products.barcode", "pd.stock as stock")
                ->where("products.id", $product->id)
                ->where("des.nombre", 'ALMACEN')
                ->where("des.sucursal_id", $this->idsucursal())
                ->get()->first();
                try
                {
                    if($productoalmacen->stock > 0)
                    {
                        $this->stockalmacen = $productoalmacen->stock;
                        $this->nombrestockproducto = $productoalmacen->name;
                        $this->idproductoalmacen = $productoalmacen->id;
                        $this->emit('no-stocktienda');
                        return;
                    }
                    else
                    {
                        $this->emit('no-stock', 'stock insuficiente en TIENDA y ALMACEN');
                        return;
                    }
                }
                catch (Exception $e)
                {
                    $this->emit('no-stock', 'Stock en 0, ¡Insuficiente!');
                    return;
                }
            }
        }

        //DESC
        //Obtenemos los datos ('Precio') del producto del Carrito
        $precioCarrito = Cart::get($productId);
        //Obtenemos los datos ('Precio') del producto de la Base de la Datos
        $precioBD = Product::select("products.id as id","products.nombre as name","products.precio_venta as price")
        ->where("products.id", $productId)
        ->get()->first();
        //Comparamos si hay Alguna diferencia en el Precio del Producto
        //Precio carrito - Precio Base de Datos

        try
        {
            $diferencia = $precioCarrito['price'] - $precioBD['price'];
        }
        catch(Exception $e)
        {
            $diferencia = 0;
        }


        if($diferencia == 0)
        {
            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
        }
        else
        {
            Cart::add($product->id, $product->name, $precioCarrito['price'], $cant, $product->image);
        }



        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        //Actualizamos el Total Descuento
        $this->actualizardescuento();
        $this->emit('scan-ok', $title);
    }

    public function UpdateQty($productId, $cant = 1)
    {
        $title = '';
        //Consulta para saber el Stock de los Productos en Tienda
        $product = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
        ->join('locations as d', 'd.id', 'pd.location_id')
        ->join('destinos as des', 'des.id', 'd.destino_id')
        ->select("products.id as id","products.image as image","des.sucursal_id as sucursal_id","products.nombre as name",
        "products.precio_venta as price","products.barcode", "pd.stock as stock")
        ->where("products.id", $productId)
        ->where("des.nombre", 'TIENDA')
        ->where("des.sucursal_id", $this->idsucursal())
        ->get()->first();
        //------------------------------------------------------
        
        $exist = Cart::get($productId);
        if ($exist)
        {
            $title = "Cantidad Actualizada";
        }
        else
        {
            $title = "Producto Agregado";
        }
        if ($exist)
        {
            if ($product->stock < $cant)
            {
                //Buscar Productos en Almacen
                $productoalmacen = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
                ->join('locations as d', 'd.id', 'pd.location_id')
                ->join('destinos as des', 'des.id', 'd.destino_id')
                ->select("products.id as id","products.image as image","des.sucursal_id as sucursal_id","products.nombre as name",
                "products.precio_venta as price","products.barcode", "pd.stock as stock")
                ->where("products.id", $product->id)
                ->where("des.nombre", 'ALMACEN')
                ->where("des.sucursal_id", $this->idsucursal())
                ->get()->first();
                if($productoalmacen->stock > 0)
                {
                    $this->stockalmacen = $productoalmacen->stock;
                    $this->nombrestockproducto = $productoalmacen->name;
                    $this->idproductoalmacen = $productoalmacen->id;
                    $this->emit('no-stocktienda');
                    return;
                }
                else
                {
                    $this->emit('no-stock', 'stock insuficiente en TIENDA y ALMACEN');
                    return;
                }



        }




        //DESCUENTOS
        //Obtenemos los datos ('Precio') del producto del Carrito
        $precioCarrito = Cart::get($productId);
        //Obtenemos los datos ('Precio') del producto de la Base de la Datos
        $precioBD = Product::select("products.id as id","products.nombre as name","products.precio_venta as price")
        ->where("products.id", $productId)
        ->get()->first();
        //Comparamos si hay Alguna diferencia en el Precio del Producto
        //Precio carrito - Precio Base de Datos
        $diferencia = $precioCarrito['price'] - $precioBD['price'];


        $this->removeItem($productId);
            if ($cant > 0)
            {
                if($diferencia != 0)
                {
                    //Si hay Diferencia en el Precio Procedemos con Precio Actualizado
                    Cart::add($product->id, $product->name, $precioCarrito['price'], $cant, $product->image);
                    $this->total = Cart::getTotal();
                    $this->itemsQuantity = Cart::getTotalQuantity();
                    $this->emit('scan-ok', $title);
                }
                else
                {
                    //Si no hay Diferencia en el Precio Procedemos Normalmente
                    Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
                    $this->total = Cart::getTotal();
                    $this->itemsQuantity = Cart::getTotalQuantity();
                    $this->emit('scan-ok', $title);
                }
                
            }

        }
        
        //Actualizamos el Total Descuento
        $this->actualizardescuento();
        
    }
    public function removeItem($productId)
    {
        Cart::remove($productId);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Producto eliminado');

        //Actualizamos el Total Descuento
        $this->actualizardescuento();
        
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
        
        //Actualizamos el Total Descuento
        $this->actualizardescuento();

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
        if($this->anonimo == 1)
        {
            
            $rules = [ /* Reglas de validacion */
                'nit' => 'required',
            ];
            $messages = [ /* mensajes de validaciones */
                'nit.required' => 'Ingrese el Nit de un Cliente'
            ];

            $this->validate($rules, $messages);
        }

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
                //Si selecciono un cliente de la lista
                if($this->clienteseleccionado == 1)
                {
                    ClienteMov::create([
                        'movimiento_id' => $Movimiento->id,
                        'cliente_id' => $this->idcliente,
                    ]);
                }
                else
                {
                   // Creando Cliente
                    $clientenuevo = Cliente::create([
                        'nit' => $this->nit,
                        'razon_social' => $this->razonsocial,
                        'celular' => $this->celular,
                        'procedencia_cliente_id'=> 1,
                    ]);


                    ClienteMov::create([
                        'movimiento_id' => $Movimiento->id,
                        'cliente_id' => $clientenuevo->id,
                    ]);

                }
                
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

            //Tipo de Pago en la Venta
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
            //Cambiando valor de $facturasino dependiendo del valor de $factura
            $this->ventafactura();
            //Guardando total Bs para crear comprobante en PDF
            $this->totalbs = $this->total;
            $this->totalitems = $this->itemsQuantity;
            //Creando Venta
            if($this->observacion=="")
            {
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
            }
            else
            {
                $sale = Sale::create([
                    'total' => $this->total,
                    'items' => $this->itemsQuantity,
                    'cash' => $this->efectivo,
                    'change' => $this->change,
                    'tipopago' => $this->tipopago,
                    'factura' => $this->facturasino,
                    'movimiento_id' => $Movimiento->id,
                    'observacion' => $this->observacion,
                    'user_id' => Auth()->user()->id
                ]);
            }
            //Creando Detalle de Venta
            if ($sale)
            {
                $items = Cart::getContent();
                foreach ($items as $item) {

                    SaleDetail::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'product_id' => $item->id,
                        'sale_id' => $sale->id,
                    ]);

                    //Decrementando el stock en tienda
                    $tiendaproducto = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
                    ->join('locations as d', 'd.id', 'productos_destinos.location_id')
                    ->join('destinos as des', 'des.id', 'd.destino_id')
                    ->select("productos_destinos.id as id","p.nombre as name",
                    "productos_destinos.stock as stock")
                    ->where("p.id", $item->id)
                    ->where("des.nombre", 'TIENDA')
                    ->where("des.sucursal_id", $this->idsucursal())
                    ->get()->first();


                    $tiendaproducto->update([
                        'stock' => $tiendaproducto->stock - $item->quantity
                    ]);
                }
            }

            DB::commit();




            $this->idventa = $sale->id;



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
            // $this->factura = "false";
            // $this->facturasino="No";


            $this->emit('save-ok', 'venta registrada con exito');

            
            //Llamar al Modal de Espera
            $this->emit('modalespera');
            //Redireccionando para crear el comprobante con sus respectvas variables
            return redirect::to('report/pdf' . '/' . $this->totalbs. '/' . $this->idventa . '/' . $this->totalitems);

            //return Redirect::to('pos');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('sale-error', $e->getMessage());
        }
    }
    public function printTicket($sale)
    {
        return Redirect::to('print://$sale->id');
    }

    //Mètodo para mover productos de la tabla ALM
    public function almacenToTienda()
    {
        //Encontrando el Id de la Tabla ProductosDestino  a actualizar (para Decrementar Stock Almacen)
        $almacen = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
        ->join('locations as d', 'd.id', 'productos_destinos.location_id')
        ->join('destinos as des', 'des.id', 'd.destino_id')
        ->select("productos_destinos.product_id as id","p.nombre as name","p.precio_venta as price","p.image as image", "productos_destinos.stock as cantidad_disponible_almacen"
        , "productos_destinos.id as id_pd")
        ->where("productos_destinos.product_id", $this->idproductoalmacen)
        ->where("des.nombre", 'ALMACEN')
        ->where("des.sucursal_id", $this->idsucursal())
        ->get()->first();




        $rules = [ 
            'cantidadToTienda' => 'required|integer|min:1|not_in:0|max:'.$almacen->cantidad_disponible_almacen,
        ];
        $messages = [
            'cantidadToTienda.required' => 'Ingrese un monto válido',
            'cantidadToTienda.min' => 'Ingrese un monto mayor a 0',
            'cantidadToTienda.not_in' => 'Ingrese un monto válido',
            'cantidadToTienda.integer' => 'El monto debe ser un número',
            'cantidadToTienda.max' => 'El monto máximo debe ser '.$almacen->cantidad_disponible_almacen
        ];

        $this->validate($rules, $messages);


        $idproductodestinoalmacen = ProductosDestino::find($almacen->id_pd);
        //Decrementando el Stock del Id que corresponde al Almacen
        $idproductodestinoalmacen->update([
            'stock' => $almacen->cantidad_disponible_almacen - $this->cantidadToTienda
        ]);

        //dd($productoalmacenid->name ." - Cantidad en Almacen:". $productoalmacenid->cantidad_disponible_almacen);
        //Encontrando el Id de la Tabla ProductosDestino  a actualizar (para Incrementar Stock Tienda)
        $tienda = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
        ->join('locations as d', 'd.id', 'productos_destinos.location_id')
        ->join('destinos as des', 'des.id', 'd.destino_id')
        ->select("productos_destinos.product_id as id","p.nombre as name","p.precio_venta as price","p.image as image", "productos_destinos.stock as cantidad_disponible_tienda"
        , "productos_destinos.id as id_pd")
        ->where("productos_destinos.product_id", $this->idproductoalmacen)
        ->where("des.nombre", 'TIENDA')
        ->where("des.sucursal_id", $this->idsucursal())
        ->get()->first();


        $idproductodestinotienda = ProductosDestino::find($tienda->id_pd);
        //Incrementando el Stock del Id que corresponde a la Tienda
        $idproductodestinotienda->update([
            'stock' => $tienda->cantidad_disponible_tienda + $this->cantidadToTienda
        ]);

        //NOTIFICACIONES
        //Obteniendo el nombre del Usuario
        $nombreusuario = User::select("users.id as id","users.name as nombre","users.profile as rol")
        ->where("users.id", Auth()->user()->id)
        ->get()
        ->first();
        //Notificando al Administrador el Movimiento del Inventario
        
        //Creando Notificacion
        $idNotificacion = Notification::create([

            'nombrenotificacion' => "MOVIMIENTO DE INVENTARIO",

            'mensaje' => 'El usuario: '.$nombreusuario->nombre.' movio '.$this->cantidadToTienda.' unidade(s) del producto '.
            $almacen->name." del Almacen a la Tienda",

            'user_id' => Auth()->user()->id,
            'sucursal_id' => $this->idsucursal(),
        ]);

        //dd($idNotificacion->id);


        //Obteniendo los Ids de los Administradores para Notificarlos
        $idUsuarios[] = User::select("users.id as id","users.name as nombre","users.profile as rol")
        ->where("users.profile", 'ADMIN')->get()->first();
        
        //Notificando a todos los Administradores
        foreach ($idUsuarios as $item)
        {
            NotificationUser::create([
                'user_id' => $item->id,
                'notification_id' => $idNotificacion->id
            ]);
        }





        //Añadimos al Carrito

        $this->increaseQty($almacen->id, $this->cantidadToTienda);

        // Cart::add($almacen->id, $almacen->name, $almacen->price, $this->cantidadToTienda, $almacen->image);
        // $this->total = Cart::getTotal();
        // $this->itemsQuantity = Cart::getTotalQuantity();
        // $this->emit('scan-ok', "Cantidad Actualizada");
    }

    // Llamar al Modal de Monedas Para Finalizar las Ventas
    public function FinalizarVenta()
    {

        //Poner Cambio en 0
        //$this->calcularCambio($this->total);
        $this->efectivo = 0;
        //Llamar al Modal
        $this->emit('finalizarventa');
    }
    //Obtener el Id de la Sucursal Donde esta el Usuario
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
    //Aplicar descuento o recargo Dependiendo del valor que se modifique en el Precio de Venta
    public function precioventa(Product $producto, $precioactualizado, $cantidad)
    {
        //Eliminamos el Producto del Carrito de Compras
        $this->removeItem($producto->id);
        //Lo volvemos a añadir al Carrito con el Precio de Venta Actualizado
        $this->priceUpdate($producto->id,$cantidad, $precioactualizado);
        //Actualizamos el Total Descuento
        $this->actualizardescuento();
    }


    

    //Buscar el Precio Original de un Producto
    public function actualizardescuento()
    {
        $precio = 0;
        $items = Cart::getContent();
        foreach ($items as $item)
        {
            $precio = ($this->buscarprecio($item->id) * $item->quantity) + $precio;
        }
        $this->totalBsBd = $precio;
        //$this->totalBsBd = $asd;
        $this->descuento = $this->totalBsBd - $this->total;
        
    }
    

    //Buscar el Precio Original de un Producto
    public function buscarprecio($id)
    {
        $tiendaproducto = Product::select("products.id as id","products.precio_venta as precio")
        ->where("products.id", $id)
        ->get()->first();
        return $tiendaproducto->precio;
    }



    //Para Actualizar el Precio de un Producto en el Carrito de Compras
    public function priceUpdate($productId, $cant = 1, $precioactualizado)
    {
        //Consulta para saber el Stock de los Productos en Tienda
        $product = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
        ->join('locations as d', 'd.id', 'pd.location_id')
        ->join('destinos as des', 'des.id', 'd.destino_id')
        ->select("products.id as id","products.image as image","des.sucursal_id as sucursal_id","products.nombre as name",
        "products.precio_venta as price","products.barcode", "pd.stock as stock")
        ->where("products.id", $productId)
        ->where("des.nombre", 'TIENDA')
        ->where("des.sucursal_id", $this->idsucursal())
        ->get()->first();
        //---------------------------------------------------------
        //Para saber si el Producto ya esta en carrrito para cambiar el mensaje de Producto Agregado a Cantidad Actualizada
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
                $productoalmacen = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
                ->join('locations as d', 'd.id', 'pd.location_id')
                ->join('destinos as des', 'des.id', 'd.destino_id')
                ->select("products.id as id","products.image as image","des.sucursal_id as sucursal_id","products.nombre as name",
                "products.precio_venta as price","products.barcode", "pd.stock as stock")
                ->where("products.id", $product->id)
                ->where("des.nombre", 'ALMACEN')
                ->where("des.sucursal_id", $this->idsucursal())
                ->get()->first();
                try
                {
                    if($productoalmacen->stock > 0)
                    {
                        $this->stockalmacen = $productoalmacen->stock;
                        $this->nombrestockproducto = $productoalmacen->name;
                        $this->idproductoalmacen = $productoalmacen->id;
                        $this->emit('no-stocktienda');
                        return;
                    }
                    else
                    {
                        $this->emit('no-stock', 'stock insuficiente en TIENDA y ALMACEN');
                        return;
                    }
                }
                catch (Exception $e)
                {
                    $this->emit('no-stock', 'Stock en 0, ¡Insuficiente!');
                    return;
                }
            }
        }



        Cart::add($product->id, $product->name, $precioactualizado, $cant, $product->image);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', $title);
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

}
