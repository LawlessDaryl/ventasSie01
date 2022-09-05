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
use App\Models\Destino;
use App\Models\Lote;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\SaleLote;
use App\Models\Sucursal;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Exception;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\TryCatch;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PosController extends Component
{
    public $total, $itemsQuantity, $efectivo, $change, 
    $nit, $clienteanonimo="true", $tipopago ,$anonimo, $factura,$qq,$lotecantidad, $observacion, $facturasino, $nombreproducto, $clienteseleccionado;
    public $razonsocial, $celular="",$tipodestino;

    //Variables para mover inventario a la tienda
    public  $stockalmacen, $nombrestockproducto, $cantidadToTienda = 1, $idproductoalmacen, $iddestinoseleccionado, $nombredestinoseleccionado, $listasucursales;

    //Variables para el comprobantes...
    public $idventa, $totalbs, $totalitems;
    //Variables para Calcular el Descuento en Ventas...
    public $descuento, $totalBsBd;

    //Variable para el swich de crear pdf
    public $crearpdf;

    

    public function mount()
    {
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->ClienteSelectnit = 1;
        $this->ProductSelectNombre = 1;
        $this->anonimo = 0;
        $this->facturasino = 'No';
        $this->descuento = 0;
        $this->totalBsBd = 0;
        $this->crearpdf = false;
        $listac = $this->listarcarteras();
        $this->tipopago = 'Elegir';


        if(session('sesionidventa') > 0)
        {
            $venta = Sale::find(session('sesionidventa'));
            $this->tipopago = $venta->cartera_id;
        }
        else
        {
            foreach($listac as $list)
            {
                if($list->tipo == 'CajaFisica')
                {
                    $this->tipopago = $list->idcartera;
                    break;
                }
                
            }
        }



        $this->actualizardescuento();
        $this->listadestinos = $this->buscarxproducto(1);
        $this->listasucursales = $this->buscarxproductosucursal(1);

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
            ->join('destinos as des', 'des.id', 'pd.destino_id')
            ->select("products.id as id","products.nombre as nombre", "products.image as image", "products.precio_venta as precio_venta",
            "pd.stock as stock", "products.codigo as barcode")
            ->where("des.nombre", 'TIENDA')
            ->where("products.status", 'ACTIVO')
            ->where("des.sucursal_id", $this->idsucursal())
            ->where(function($query){
                $query->where('products.nombre', 'like', '%' . $this->nombreproducto . '%')
                      ->orWhere('products.codigo', 'like', '%' . $this->nombreproducto . '%');  
                          
            })
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

        //Cuando no exista stock en Tienda para vender y se procede a buscar en otros destinos(Depósito, almacen, almacen 2, etc...)
        //Listar los destinos donde aun queden stock de un determinado producto
        $listardestinos = Destino::join("productos_destinos as pd", "pd.destino_id", "destinos.id")
        ->select("destinos.id as id","destinos.nombre as nombredestino","pd.product_id as idproducto","pd.stock as stock")
        ->where("destinos.sucursal_id", $this->idsucursal())
        ->where('destinos.nombre', '<>', 'TIENDA')
        ->where('destinos.nombre', '<>', 'Almacen Devoluciones')
        ->where('pd.product_id', $this->idproductoalmacen)
        ->where('pd.stock','>', 0)
        ->orderBy('pd.stock', 'desc')
        ->get();




        return view('livewire.pos.component', [
            'denominations' => Denomination::orderBy('id', 'asc')->get(),
            'cart' => Cart::getContent()->sortBy('name'),
            'datosnit' => $datosnit,
            'datosnombreproducto' => $datosnombreproducto,
            'listdestinos' =>$listardestinos,
            'listacarteras' => $this->listarcarteras(),
            'listacarterasg' => $this->listarcarterasg()

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
        if($this->efectivo == "")
        {
            $this->efectivo = 0;
        }

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
            if ($this->inCart($product->id))
            {
                $this->increaseQty($product->id);
                return;
            }
            if ($product->stock < 1)
            {
                //Buscar Productos en Almacen
                $productoalmacen = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
                ->join('destinos as des', 'des.id', 'pd.destino_id')
                ->select("products.id as id","products.image as image","des.sucursal_id as sucursal_id","products.nombre as name",
                "products.precio_venta as price","products.codigo", "pd.stock as stock")
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
        ->join('destinos as des', 'des.id', 'pd.destino_id')
        ->select("products.id as id","des.sucursal_id as sucursal_id","products.nombre as name","products.image as image",
        "products.precio_venta as price", "pd.stock as stock")
        ->where("pd.product_id", $idproducto)
        ->where("des.nombre", 'TIENDA')
        ->where("des.sucursal_id", $this->idsucursal())
        ->get()->first();

        
        //Si ya existe en el carrito incart devolvera true
        if ($this->inCart($product->id))
        {
            $this->increaseQty($product->id);
            return;
        }

        //Si el producto no existe, lo añadimos en el carrito de compras 
        //pero antes verificamos si queda stock disponible en la tienda
        if ($product->stock < 1)
        {
            //Buscamos el Producto en la sucursal menos en la Tienda
            if($this->buscarxproducto($idproducto)->count() > 0)
            {
                //Si se encontraron productos en la sucursal se llamara al modal
                //donde se podra descontar stock de un destino seleccionado

                //Actualizando la tabla $listadestinos donde se listan todos los destinos 
                //dentro de la sucursal en donde aun queden stock disponibles
                $this->listadestinos = $this->buscarxproducto($idproducto);

                //Actualizamos el id del producto que se planea realizar un movimiento de tienda a otro destino
                $this->idproductoalmacen = $idproducto;

                //Obteniendo el nombre del producto que se mostrara en el modal
                $this->nombrestockproducto = $product->name;

                //Llamando al modal
                $this->emit('no-stocktienda');
                return;






            }
            else
            {

                //Si no hay stock del producto en la sucursal se buscara en todas las demas sucursales
                if($this->buscarxproductosucursal($idproducto)->count() > 0)
                {
                    $this->listasucursales = $this->buscarxproductosucursal($idproducto);

                    $this->nombrestockproducto = $product->name;


                    
                    //Poner el Id del producto con 0 stock en la variable global $idproductoalmacen
                    //Para que sea usada por el metodo buscarstocksucursal($idsucursal)
                    $this->idproductoalmacen = $idproducto;


                    //Llamamos al modal donde se listarán todas las sucursales
                    //en donde aún quedan stock disponibles
                    $this->emit('modal-stocksucursales');
                    return;
                }
                else
                {
                    //Si no hay stock en la propia sucursal y en otras sucursales se mostrará el siguiente mensaje
                    $this->emit('no-stock', 'stock insuficiente en TIENDA y TODOS LAS SUCURSALES DISPONIBLESS');
                    return;
                } 
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
        //$this->emit('scan-ok', 'Producto agregado');
        //Para Actualizar el Total Descuento
        $this->actualizardescuento();
    }
    //Incrementar Items Carrito
    public function increaseQty($productId, $cant = 1)
    {
        //Consulta para saber el Stock de los Productos en Tienda
        $product = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
        ->join('destinos as des', 'des.id', 'pd.destino_id')
        ->select("products.id as id","products.image as image","des.sucursal_id as sucursal_id","products.nombre as name",
        "products.precio_venta as price","products.codigo", "pd.stock as stock")
        ->where("products.id", $productId)
        ->where("des.nombre", 'TIENDA')
        ->where("des.sucursal_id", $this->idsucursal())
        ->get()->first();
        //---------------------------------------------------------
        //Para saber si el Producto ya esta en carrrito para cambiar el mensaje de Producto Agregado a Cantidad Actualizada
        $exist = Cart::get($productId);
        if ($exist)
        {
            $title = 'Cantidad Actualizada';
        }
        else
        {
            $title = "Producto Agregado";
        }
        
        
        if ($exist)
        {
            //Si no hay stock de un Producto en Tienda
            if ($product->stock < ($cant + $exist->quantity))
            {
                //Buscamos el Producto en la sucursal menos en la Tienda
                if($this->buscarxproducto($productId)->count() > 0)
                {
                    //Si se encontraron productos en la sucursal se llamara al modal
                    //donde se podra descontar stock de un destino seleccionado

                    //Actualizando la tabla $listadestinos donde se listan todos los destinos 
                    //dentro de la sucursal en donde aun queden stock disponibles
                    $this->listadestinos = $this->buscarxproducto($productId);

                    //Actualizamos el id del producto que se planea realizar un movimiento de tienda a otro destino
                    $this->idproductoalmacen = $productId;

                    //Obteniendo el nombre del producto que se mostrara en el modal
                    $this->nombrestockproducto = $product->name;


                    //$this->tipodestino = $this->buscarxproducto($productId)->first()->id;

                    //$this->stockalmacen = $this->numstock($productId, $this->tipodestino);





                    //Llamando al modal
                    $this->emit('no-stocktienda');
                    return;








                }
                else
                {
                    //Si no hay stock del producto en la sucursal se buscara en todas las demas sucursales
                    if($this->buscarxproductosucursal($productId)->count() > 0)
                    {
                        $this->listasucursales = $this->buscarxproductosucursal($productId);

                        $this->nombrestockproducto = $product->name;


                        
                        //Poner el Id del producto con 0 stock en la variable global $idproductoalmacen
                        //Para que sea usada por el metodo buscarstocksucursal($idsucursal)
                        $this->idproductoalmacen = $productId;


                        //Llamamos al modal donde se listarán todas las sucursales
                        //en donde aún quedan stock disponibles
                        $this->emit('modal-stocksucursales');
                        return;

                    }
                    else
                    {
                        //Si no hay stock en la propia sucursal y en otras sucursales se mostrará el siguiente mensaje
                        $this->emit('no-stock', 'stock insuficiente en TIENDA y TODOS LAS SUCURSALES EXISTENTES');
                        return;
                    }
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

    
    //Para Buscar un Producto en todos los destinos de la propia sucursal del usuario (excepto en Tienda)
    public function buscarxproducto($idproducto)
    {
        //Primero Buscamos el Producto en todos los destinos(Almacén, Depósito, Almacen2, etc) de la Sucursal
        $listadestinosproductos = Destino::join("productos_destinos as pd", "pd.destino_id", "destinos.id")
        ->select("destinos.id as id","destinos.nombre as nombredestino","pd.product_id as idproducto","pd.stock as stock")
        ->where("destinos.sucursal_id", $this->idsucursal())
        ->where('destinos.nombre', '<>', 'TIENDA')
        ->where('destinos.nombre', '<>', 'Almacen Devoluciones')
        ->where('pd.product_id', $idproducto)
        ->where('pd.stock','>', 0)
        ->orderBy('pd.stock', 'desc')
        ->get();

        
        return $listadestinosproductos;

    }

    //Para Buscar un Producto en todos los destinos de diferentes sucursales (excepto en la sucursal actual)
    public function buscarxproductosucursal($idproducto)
    {
        //En esta variable se guardaran todos los Ids de las Sucursales en donde aun queden Stocks Disponibles
        $listadestinosproductossucursal = Destino::join("productos_destinos as pd", "pd.destino_id", "destinos.id")
        ->select("destinos.sucursal_id as idsucursal")
        ->where('destinos.sucursal_id', '<>', $this->idsucursal())
        ->where('pd.product_id', $idproducto)
        ->where('pd.stock','>', 0)
        ->groupBy('destinos.sucursal_id')
        ->get();
        return $listadestinosproductossucursal;
    }

    //Para Buscar un Producto en todos los destinos de una sucursal diferente a la Actual en Uso
    public function buscarstocksucursal($idsucursal)
    {
        //Primero Buscamos el Producto en todos los destinos(Almacén, Depósito, Almacen2, etc) de una determinada Sucursal
        $listproducts = Destino::join("productos_destinos as pd", "pd.destino_id", "destinos.id")
        ->select("destinos.id as id","destinos.nombre as nombredestino","pd.product_id as idproducto","pd.stock as stock")
        ->where("destinos.sucursal_id", $idsucursal)
        ->where('destinos.nombre', '<>', 'Almacen Devoluciones')
        ->where('pd.product_id', $this->idproductoalmacen)
        ->where('pd.stock','>', 0)
        ->orderBy('pd.stock', 'desc')
        ->get();
        return $listproducts;
    }



    //Buscar el Stock Disponible de un Producto dependiendo el destino que se seleccione
    //en la ventana modal de Stock Insuficiente
    public function numstock($idproducto, $iddestino)
    {
        $productstock = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
        ->join('destinos as des', 'des.id', 'pd.destino_id')
        ->select("products.nombre as name",
        "pd.destino_id as destino_id", "pd.product_id as product_id","pd.stock as stock")
        ->where("pd.product_id", $idproducto)
        ->where("pd.destino_id", $iddestino)
        ->where("des.sucursal_id", $this->idsucursal())
        ->get()->first();

        return $productstock->stock;
    }

    //Actualizar el stock en el carrito de compras
    public function UpdateQty($productId, $cant = 1)
    {
        $title = '';
        //Consulta para saber el Stock de los Productos en Tienda
        $product = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
        ->join('destinos as des', 'des.id', 'pd.destino_id')
        ->select("products.id as id","products.image as image","des.sucursal_id as sucursal_id","products.nombre as name",
        "products.precio_venta as price","products.codigo", "pd.stock as stock")
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

            if($cant > $exist->quantity)
            {
                //Si no hay stock de un Producto en Tienda
            if ($product->stock < $cant)
            {
                //Buscamos el Producto en la sucursal menos en la Tienda
                if($this->buscarxproducto($productId)->count() > 0)
                {
                    //Si se encontraron productos en la sucursal se llamara al modal
                    //donde se podra descontar stock de un destino seleccionado

                    //Actualizando la tabla $listadestinos donde se listan todos los destinos 
                    //dentro de la sucursal en donde aun queden stock disponibles
                    $this->listadestinos = $this->buscarxproducto($productId);

                    //Actualizamos el id del producto que se planea realizar un movimiento de tienda a otro destino
                    $this->idproductoalmacen = $productId;

                    //Obteniendo el nombre del producto que se mostrara en el modal
                    $this->nombrestockproducto = $product->name;


                    //$this->tipodestino = $this->buscarxproducto($productId)->first()->id;

                    //$this->stockalmacen = $this->numstock($productId, $this->tipodestino);





                    //Llamando al modal
                    $this->emit('no-stocktienda');
                    return;








                }
                else
                {
                    //Si no hay stock del producto en la sucursal se buscara en todas las demas sucursales
                    if($this->buscarxproductosucursal($productId)->count() > 0)
                    {
                        $this->listasucursales = $this->buscarxproductosucursal($productId);

                        $this->nombrestockproducto = $product->name;


                        
                        //Poner el Id del producto con 0 stock en la variable global $idproductoalmacen
                        //Para que sea usada por el metodo buscarstocksucursal($idsucursal)
                        $this->idproductoalmacen = $productId;


                        //Llamamos al modal donde se listarán todas las sucursales
                        //en donde aún quedan stock disponibles
                        $this->emit('modal-stocksucursales');
                        return;

                    }
                    else
                    {
                        //Si no hay stock en la propia sucursal y en otras sucursales se mostrará el siguiente mensaje
                        $this->emit('no-stock', 'stock insuficiente en TIENDA y TODOS LAS SUCURSALES EXISTENTES');
                        return;
                    }
                }
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

    //Eliminar un producto del carrito de compras
    public function removeItem($productId)
    {
        Cart::remove($productId);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Producto eliminado');

        //Actualizamos el Total Descuento
        $this->actualizardescuento();
        
    }
    //Decrementar Carrito de Compras
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
    //Eliminar todos los Productos del Carrito
    public function clearCart()
    {
        Cart::clear();
        $this->efectivo = 0;
        $this->change = 0;

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Carrito vacio');
    }
    //Guardar Venta
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

        if ($this->total <= 0) 
        {
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
            // Dependiendo si es o no un Cliente Anònimo
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
            $cartera = Cartera::where('id', $this->tipopago)->get()->first();
                    
            //Cambiando valor de $facturasino dependiendo del valor de $factura
            $this->ventafactura();
            //Guardando total Bs para crear comprobante en PDF
            $this->totalbs = $this->total;
            $this->totalitems = $this->itemsQuantity;

            $tipopago = Cartera::find($this->tipopago);


            //Creando Venta
            if($this->observacion=="")
            {
                $sale = Sale::create([
                    'total' => $this->total,
                    'items' => $this->itemsQuantity,
                    'cash' => $this->efectivo,
                    'change' => $this->change,
                    'tipopago' => $tipopago->nombre,
                    'factura' => $this->facturasino,
                    'cartera_id' => $cartera->id,
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
                    'tipopago' => $tipopago->nombre,
                    'factura' => $this->facturasino,
                    'movimiento_id' => $Movimiento->id,
                    'cartera_id' => $cartera->id,
                    'observacion' => $this->observacion,
                    'user_id' => Auth()->user()->id
                ]);
            }
            //Creando Detalle de Venta
            if ($sale)
            {
                $items = Cart::getContent();
                foreach ($items as $item) {

                    $sd=SaleDetail::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'product_id' => $item->id,
                        'sale_id' => $sale->id,
                    ]);


                    $lot=Lote::where('product_id',$item->id)->where('status','Activo')->get();

                    //obtener la cantidad del detalle de la venta 
                    $this->qq=$item->quantity;//q=8
                    foreach ($lot as $val) { //lote1= 3 Lote2=3 Lote3=3
                      $this->lotecantidad = $val->existencia;
                      //dd($this->lotecantidad);
                       if($this->qq>0){
                        //true//5//2
                           //dd($val);
                           if ($this->qq > $this->lotecantidad) {
        
                               $ss=SaleLote::create([
                                   'sale_detail_id'=>$sd->id,
                                   'lote_id'=>$val->id,
                                   'cantidad'=>$val->existencia
                                   
                               ]);
                              
        
                               $val->update([
                                   'existencia'=>0,
                                   'status'=>'Inactivo'
                                ]);
                                $val->save();
                                $this->qq=$this->qq-$this->lotecantidad;
                                //dump("dam",$this->qq);
                           }
                           else{
                            //dd($this->lotecantidad);
                               $dd=SaleLote::create([
                                   'sale_detail_id'=>$sd->id,
                                   'lote_id'=>$val->id,
                                   'cantidad'=>$this->qq
                               ]);
                             
        
                               $val->update([ 
                                   'existencia'=>$this->lotecantidad-$this->qq
                               ]);
                               $val->save();
                               $this->qq=0;
                               //dd("yumi",$this->qq);
                           }
                       }
                   }


                    //Decrementando el stock en tienda
                    $tiendaproducto = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
                    ->join('destinos as des', 'des.id', 'productos_destinos.destino_id')
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
                'tipoDeMovimiento' => "VENTA",
                'comentario' => "Venta",
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
            //$this->emit('modalespera');
            //sleep(2);
            //Redireccionando para crear el comprobante con sus respectivas variables
            //return redirect::to('report/pdf' . '/' . $this->totalbs. '/' . $this->idventa . '/' . $this->totalitems);


            //$pdf = PDF::loadView('report/pdf' . '/' . $this->totalbs. '/' . $this->idventa . '/' . $this->totalitems);

            //return $pdf->stream('comprobante.pdf');  //visualizar
            /* return $pdf->download('salesReport.pdf');  //descargar  */



            if($this->crearpdf == true)
            {
                $this->emit('opentap');
            }
            return Redirect::to('pos');
        }
        catch (Exception $e) {
            DB::rollback();
            $this->emit('sale-error', $e->getMessage());
        }
    }

    public function tbs()
    {
        return $this->totalbs;
    }
    public function iventa()
    {
        return $this->idventa;
    }
    public function titems()
    {
        return $this->totalitems;
    }



    public function printTicket($sale)
    {
        return Redirect::to('print://$sale->id');
    }

    //Mètodo para mover productos a la tienda desde otro destino dentro de la misma sucursal
    public function almacenToTienda()
    {
        //Consulta para saber el stock maximo a sacar del destino seleccionado para mover a la tienda
        $destino_seleccionado = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
        ->join('destinos as des', 'des.id', 'productos_destinos.destino_id')
        ->select("productos_destinos.product_id as id","p.nombre as name",
        "p.precio_venta as price","p.image as image", "productos_destinos.stock as cantidad_disponible_almacen"
        , "productos_destinos.id as id_pd","des.id as iddestino", "des.nombre as nombredestino")
        ->where("productos_destinos.product_id", $this->idproductoalmacen)
        ->where("des.id", $this->iddestinoseleccionado)
        ->where("des.sucursal_id", $this->idsucursal())
        ->get()->first();


        //Reglas de Validación
        $rules = [ 
            'cantidadToTienda' => 'required|integer|min:1|not_in:0|max:'.$destino_seleccionado->cantidad_disponible_almacen,
        ];
        $messages = [
            'cantidadToTienda.required' => 'Ingrese un monto válido',
            'cantidadToTienda.min' => 'Ingrese un monto mayor a 0',
            'cantidadToTienda.not_in' => 'Ingrese un monto válido',
            'cantidadToTienda.integer' => 'El monto debe ser un número',
            'cantidadToTienda.max' => 'El monto máximo debe ser '.$destino_seleccionado->cantidad_disponible_almacen
        ];
        //Validando las reglas mencionadas
        $this->validate($rules, $messages);

        


        //Encontrando el Id de la Tabla ProductosDestino  a actualizar (para Decrementar Stock del Destino Seleccionado)
        $id_pd = ProductosDestino::find($destino_seleccionado->id_pd);
        //Decrementando el Stock del Id que corresponde al Destino Seleccionado
        $id_pd->update([
            'stock' => $destino_seleccionado->cantidad_disponible_almacen - $this->cantidadToTienda
        ]);

        //Encontrando el Id de la Tabla ProductosDestino  a actualizar (para Incrementar Stock Tienda)
        $tienda = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
        ->join('destinos as des', 'des.id', 'productos_destinos.destino_id')
        ->select("productos_destinos.product_id as id","p.nombre as name","p.precio_venta as price","p.image as image",
         "productos_destinos.stock as cantidad_disponible_tienda"
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
            $destino_seleccionado->name." de ".$destino_seleccionado->nombredestino." a la Tienda",

            'user_id' => Auth()->user()->id,
            'sucursal_id' => $this->idsucursal(),
        ]);


        //Obteniendo los Ids de todos los usuarios que tengan los
        //permisos para recibir notificaciones de Movimiento de Inventario

        

        //Listando todos los usuarios
        $id_users = User::select("users.id as id","users.name as nombre","users.profile as rol")->get();

        //Variable donde se almacenarán los ids de los usuarios donde tengan los permisos para
        //recibir las notificaciones de movimiento de inventarios
        $ids = array();
        
        foreach($id_users as $id)
        {
            if($id->hasPermissionTo('VentasNotificacionesMovInv'))
            {
                $ids[] = $id->id;
            }
        }
        
        
        //Notificando a todos los usuarios donde tengan los permisos para
        //recibir las notificaciones de movimiento de inventarios
        foreach ($ids as $item)
        {
            NotificationUser::create([
                'user_id' => $item,
                'notification_id' => $idNotificacion->id
            ]);
        }

        //Añadimos al Carrito

        $this->increaseQty($destino_seleccionado->id, $this->cantidadToTienda);

        
        //Cerramos la ventana modal
        $this->emit('no-stocktiendacerrar');
        return;

    }

    // Llamar al Modal de Monedas Para Finalizar las Ventas
    public function FinalizarVenta()
    {

        //Poner Cambio en 0
        //$this->calcularCambio($this->total);
        $this->efectivo = 0;

        if($this->tipopago == 'Elegir')
        {
            $this->emit('seleccionarcartera');
        }
        else
        {
            //Llamar al Modal
            $this->emit('finalizarventa');
        }


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
        ->join('destinos as des', 'des.id', 'pd.destino_id')
        ->select("products.id as id","products.image as image","des.sucursal_id as sucursal_id","products.nombre as name",
        "products.precio_venta as price","products.codigo", "pd.stock as stock")
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
                //Buscamos el Producto en la sucursal menos en la Tienda
                if($this->buscarxproducto($productId)->count() > 0)
                {
                    //Si se encontraron productos en la sucursal se llamara al modal
                    //donde se podra descontar stock de un destino seleccionado

                    //Actualizando la tabla $listadestinos donde se listan todos los destinos 
                    //dentro de la sucursal en donde aun queden stock disponibles
                    $this->listadestinos = $this->buscarxproducto($productId);

                    //Actualizamos el id del producto que se planea realizar un movimiento de tienda a otro destino
                    $this->idproductoalmacen = $productId;

                    //Obteniendo el nombre del producto que se mostrara en el modal
                    $this->nombrestockproducto = $product->name;


                    //$this->tipodestino = $this->buscarxproducto($productId)->first()->id;

                    //$this->stockalmacen = $this->numstock($productId, $this->tipodestino);





                    //Llamando al modal
                    $this->emit('no-stocktienda');
                    return;





                }
                else
                {
                    //Si no hay stock del producto en la sucursal se buscara en todas las demas sucursales
                    if($this->buscarxproductosucursal($productId)->count() > 0)
                    {
                        $this->listasucursales = $this->buscarxproductosucursal($productId);

                        $this->nombrestockproducto = $product->name;


                        
                        //Poner el Id del producto con 0 stock en la variable global $idproductoalmacen
                        //Para que sea usada por el metodo buscarstocksucursal($idsucursal)
                        $this->idproductoalmacen = $productId;


                        //Llamamos al modal donde se listarán todas las sucursales
                        //en donde aún quedan stock disponibles
                        $this->emit('modal-stocksucursales');
                        return;

                    }
                    else
                    {
                        //Si no hay stock en la propia sucursal y en otras sucursales se mostrará el siguiente mensaje
                        $this->emit('no-stock', 'stock insuficiente en TIENDA y TODOS LAS SUCURSALES EXISTENTES');
                        return;
                    }
                }
            }
        }



        Cart::add($product->id, $product->name, $precioactualizado, $cant, $product->image);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', $title);
    }


    //Ocultar la pagina de ventas si no tiene una caja abierta
    public function verificarcajaabierta()
    {
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
        ->get();
        return $cajausuario->count();
    }

    //Seleccionar destino
    public function seleccionardestino(Destino $iddestino)
    {
        $this->nombredestinoseleccionado = $iddestino->nombre;
        $this->iddestinoseleccionado = $iddestino->id;
    }
    //Buscar el nombre de una sucursal con el Id
    public function nombresucursal($id)
    {
        try
        {
            $sucursal = Sucursal::find($id);
            return $sucursal->name." ".$sucursal->adress;
        }
        catch (Exception $s)
        {
            return "";
        }
    }


    //Listar todas las carteras que correspondan a la sucursal y a la caja
    // public function listarcarteras()
    // {
    //     $carteras = Caja::join('carteras as car', 'cajas.id', 'car.caja_id')
    //     ->join('cartera_movs as cartmovs', 'car.id', 'cartmovs.cartera_id')
    //     ->join('movimientos as mov', 'mov.id', 'cartmovs.movimiento_id')
    //     ->where('cajas.estado', 'Abierto')
    //     ->where('mov.user_id', Auth()->user()->id)
    //     ->where('mov.status', 'ACTIVO')
    //     ->where('mov.type', 'APERTURA')
    //     ->where(function($query){
    //         $query->where('cajas.sucursal_id', $this->idsucursal())
    //               ->orWhere('cajas.nombre', 'Caja General');  
                      
    //     })
    //     ->select('car.id as idcartera', 'car.nombre as nombrecartera', 'car.descripcion as dc','car.tipo as tipo')
    //     ->get();
    //     return $carteras;
    // }

    public function listarcarteras()
    {
        $carteras = Caja::join('carteras as car', 'cajas.id', 'car.caja_id')
        ->join('cartera_movs as cartmovs', 'car.id', 'cartmovs.cartera_id')
        ->join('movimientos as mov', 'mov.id', 'cartmovs.movimiento_id')
        ->where('cajas.estado', 'Abierto')
        ->where('mov.user_id', Auth()->user()->id)
        ->where('mov.status', 'ACTIVO')
        ->where('mov.type', 'APERTURA')
        ->where('cajas.sucursal_id', $this->idsucursal())
        ->select('car.id as idcartera', 'car.nombre as nombrecartera', 'car.descripcion as dc','car.tipo as tipo')
        ->get();
        return $carteras;
    }
    //Listar las carteras generales
    public function listarcarterasg()
    {
        $carteras = Caja::join('carteras as car', 'cajas.id', 'car.caja_id')
        ->where('cajas.id', 1)
        ->select('car.id as idcartera', 'car.nombre as nombrecartera', 'car.descripcion as dc','car.tipo as tipo')
        ->get();
        return $carteras;
    }

    //Editar una venta ya existente
    public function actualizarventa()
    {
        //Obtenemos detalles de la venta a travéz de una variable de sesión
        $detalles = SaleDetail::join('sales as s', 's.id', 'sale_details.sale_id')
        ->select('sale_details.id as iddetalleventa','sale_details.sale_id as idsale','sale_details.product_id as idproduct','sale_details.quantity as cantidad','sale_details.price as precio')
        ->where('sale_details.sale_id', session('sesionidventa'))
        ->orderBy('sale_details.id', 'asc')
        ->get();




        //ELIMINAMOS TODOS LOS REGISTROS CORRESPONDIENTES A LA VENTA

        //Eliminamos todos los detalles de la venta
        foreach ($detalles as $item)
        {
            //Eliminando los productos de Detalle Venta
            SaleDetail::where('id', $item->iddetalleventa)->delete();

            //Incrementando los stocks en la Tienda de la Venta a Editar
            $tiendaproducto = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
            ->join('destinos as des', 'des.id', 'productos_destinos.destino_id')
            ->select("productos_destinos.id as id","p.nombre as name",
            "productos_destinos.stock as stock")
            ->where("p.id", $item->idproduct)
            ->where("des.nombre", 'TIENDA')
            ->where("des.sucursal_id", $this->idsucursal())
            ->get()->first();

            $tiendaproducto->update([
                'stock' => $tiendaproducto->stock + $item->cantidad
                ]);
        }

        //Pasamos el contenido del carrito en una variable
        $items = Cart::getContent();
        //Volvemos a llenar los detalles de la venta con el id de la Venta
        foreach ($items as $item) {
            $sd=SaleDetail::create([
                'price' => $item->price,
                'quantity' => $item->quantity,
                'product_id' => $item->id,
                'sale_id' => session('sesionidventa'),
            ]);

        //trabajamos con lotes

            $lot=Lote::where('product_id',$item->id)->where('status','Activo')->get();

            //obtener la cantidad del detalle de la venta 
           $qq=$item->quantity;//q=8
           foreach ($lot as $val) { //lote1= 3 Lote2=3 Lote3=3
              
               if($qq>0){            //true//5//2
                   
                   if ($qq > $val->existencia) {

                       $ss=SaleLote::create([
                           'sale_detail_id'=>$sd->id,
                           'lote_id'=>$val->id,
                           'cantidad'=>$val->existencia
                           
                       ]);
                      

                       $val->update([
                           
                           'existencia'=>0,
                           'status'=>'Inactivo'

                       ]);
                       $val->save();
                       $qq=$qq-$val->existencia;
                   }
                   else{
                       $dd=SaleLote::create([
                           'sale_detail_id'=>$sd->id,
                           'lote_id'=>$val->id,
                           'cantidad'=>$qq
                       ]);
                      


                       $val->update([ 
                           'existencia'=>$val->existencia-$qq
                       ]);
                       $val->save();
                     
                   }

                
               }
           }





            //Decrementando el stock en tienda
            $tiendaproducto = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
            ->join('destinos as des', 'des.id', 'productos_destinos.destino_id')
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

        //Obtenemos los datos del tipo de pago escogido $this->tipopago=idcartera
        $cartera = Cartera::find($this->tipopago);

        //Cambiando valor de $facturasino dependiendo del valor de $factura
        $this->ventafactura();

        //Buscamos la venta para actualizar sus parámetros
        $venta = Sale::find(session('sesionidventa'));

        $venta->update([
            'total' => Cart::getTotal(),
            'items' => $this->itemsQuantity,
            'tipopago' => $cartera->nombre,
            'factura' => $this->facturasino,
            'cartera_id' => $cartera->id,
            'observacion' => $this->observacion,
            ]);
        $venta->save();


        //Modificamos el importe del movimiento generado de la venta
        $row_movimiento = Movimiento::find($venta->movimiento_id);
        $row_movimiento->update([
            'import' => $venta->total,
            ]);
        $row_movimiento->save();



        //Obtenemos el idcarteramovimiento de la venta
        $idcarteramovimiento = Movimiento::join("cartera_movs as cm", "cm.movimiento_id", "movimientos.id")
            ->select("cm.id as cartera_mov_id")
            ->where("movimientos.id", $venta->movimiento_id)
            ->get()->first();

        //Cambiamos el idcartera del movimiento  (cuando se cambie el tipo de pago de la venta)
        $row_carteramov = CarteraMov::find($idcarteramovimiento->cartera_mov_id);
        $row_carteramov->update([
            'cartera_id' => $cartera->id,
            ]);
        $row_carteramov->save();

        //Vaciamos todas las variables
        $this->cancelaractualizarventa();
    }
    public function cancelaractualizarventa()
    {
        //Limpiamos el carrito de compras
        Cart::clear();
        //Limpiamos la variable de sesión
        session(['sesionidventa' => null]);
        return redirect('salelist');
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


    //Cambiar el valor del importe de un producto en el Carrito de Ventas
    public function cambiarimporte($id, $importe)
    {
        //Obtenemos detalles del producto en el Carrito de Ventas
        $product_cart = Cart::get($id);
        //Eliminamos el producto en el Carrito de Ventas
        Cart::remove($id);
        //Obtenemos el nuevo precio del producto de acuerdo al importe (Importe = Precio * Cantidad) recibido
        $new_price = $importe / $product_cart->quantity;

        Cart::add($product_cart->id, $product_cart->name, $new_price, $product_cart->quantity, $product_cart->image);

        
        $this->actualizardescuento();
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();



    }





}
