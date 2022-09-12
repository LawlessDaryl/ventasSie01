<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\Denomination;
use App\Models\Product;
use Livewire\Component;
use App\Models\Cliente;
use App\Models\ClienteMov;
use App\Models\Company;
use App\Models\Destino;
use App\Models\Lote;
use App\Models\Movimiento;
use App\Models\ProcedenciaCliente;
use App\Models\ProductosDestino;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\SaleLote;
use App\Models\Sucursal;
use App\Models\User;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Livewire\WithPagination;

class PosController extends Component
{
    //VARIABLES PARA LOS ELEMENTOS QUE ESTAN EN LA PARTE SUPERIOR DE LA VISTA DE UNA VENTA

    //Variable para guardar true o false para tenor o no un cliente anónimo
    public $clienteanonimo;
    //Variable para guardar el id del cliente
    public $cliente_id;
    //Total Bs en una Venta
    public $total_bs;
    //Cantidad Total de Productos en una Venta
    public $total_items;
    //id de la cartera seleccionada
    public $cartera_id;
    //Variables para saber si la venta es o no con factura
    public $factura, $invoice;
    //Variables para crear o no comprobante pdf de la venta
    public $pdf, $a;
    //Para guardar alguna observación en la venta
    public $observacion;
    //id de una venta
    public $venta_id;
    //Variable para poner la cantidad de filas en las tablas
    public $paginacion;
    //Variable para Buscar por el Nombre o Código los Productos
    public $buscarproducto;
    //Variable para Buscar por el Nombre o Código a los Clientes
    public $buscarcliente;
    //Variable para mostrar en un Mensaje Toast (Mensaje Emergente Arriba a la derecha en la Pantalla)
    public $mensaje_toast;
    //Variable para guardar la cantidad de dinero y cambio que se debe dar al cliente en una venta
    public $dinero_recibido, $cambio; 
    //Lista de destinos dentro de la sucursal (menos tienda) para mostrar en la ventana nodal stock insuficiente
    public $listadestinos;
    //Para guardar el nombre de un producto
    public $nombreproducto;
    //Para guardar el nombre de una sucursal
    public $nombresucursal;
    // Para guardar una lista de todas  las sucursales menos en la que esta el usuario
    public $listasucursales;
    // Para no mostrar la ventana modal finalizar venta en caso de que algun producto se quiera
    // vender con un stock mayor al que se tenga disponible en tienda
    public $stock_disponible;
    //Variables para el Descuento o Recargo en Venta...
    public $descuento_recargo;
    //Variables para crear un cliente
    public $cliente_nombre, $cliente_ci, $cliente_celular;
    //Para verificar que tenga un corte de caja
    public $corte_caja;
    //Guardar el id de un producto
    public $producto_id;

    use WithPagination;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->paginacion = 10;
        $this->descuento_recargo = 0;
        // $this->total_bs = Cart::getTotal();
        $this->total_bs = $this->gettotalcart();
        $this->total_items = Cart::getTotalQuantity();
        $this->factura = false;
        $this->clienteanonimo = true;
        $this->cartera_id = 'Elegir';
        $this->observacion = "";
        foreach($this->listarcarteras() as $list)
        {
            if($list->tipo == 'CajaFisica')
            {
                $this->cartera_id = $list->idcartera;
                break;
            }
            
        }
        $this->cliente_id = $this->clienteanonimo_id();
        $this->listadestinos = [];
        $this->listasucursales = [];
        $this->nombresucursal = "";
        $this->pdf = false;
        $this->stock_disponible = true;
    }
    public function render()
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

        if($cajausuario->count() > 0)
        {
            $this->corte_caja = true;
        }
        else
        {
            $this->corte_caja = false;
        }


        //Variable para guardar todos los productos encontrados que contengan el nombre o código en $buscarproducto
        $listaproductos = [];
        if($this->buscarproducto != "")
        {
            $listaproductos = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
            ->join('destinos as des', 'des.id', 'pd.destino_id')
            ->select("products.id as id","products.nombre as nombre", "products.image as image", "products.precio_venta as precio_venta",
            "pd.stock as stock", "products.codigo as barcode")
            ->where('products.nombre', 'like', '%' . $this->buscarproducto . '%')
            ->orWhere('products.codigo', 'like', '%' . $this->buscarproducto . '%')
            ->groupBy('products.id')
            ->paginate($this->paginacion);
        }
        //---------------------------------------------------------------------------------------------------------
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
        //Modulo para cambiar a si o no la variable $invoice (Factura)
        if($this->factura)
        {
            $this->invoice = "Si";
        }
        else
        {
            $this->invoice = "No";
        }
        //---------------------------------------------------------------
        //Lista a todos los clientes que tengan el nombre de la variable $this->buscarcliente
        $listaclientes = [];
        if(strlen($this->buscarcliente) > 0)
        {
            $listaclientes = Cliente::select("clientes.*")
            ->where('clientes.nombre', 'like', '%' . $this->buscarcliente . '%')
            ->orderBy("clientes.created_at","desc")
            ->get();
        }



        //Actualizar los valores de Total Bs y Total Artículos en una Venta
        $this->actualizarvalores();

        return view('livewire.pos.component', [
            'denominations' => Denomination::orderBy('id', 'asc')->get(),
            'listaproductos' => $listaproductos,
            'cart' => Cart::getContent()->sortBy('name'),
            'carteras' => $this->listarcarteras(),
            'carterasg' => $this->listarcarterasg(),
            'listaclientes' => $listaclientes,
            'nombrecliente' => Cliente::find($this->cliente_id)->nombre,
            'nombrecartera' => $this->nombrecartera()

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
    //Poner la variable $clienteanonimo en true o false dependiendo el caso
    public function clienteanonimo()
    {
        if($this->clienteanonimo)
        {
            $this->clienteanonimo = false;
            $this->mensaje_toast = "Por favor cree o seleccione a un cliente, si no lo hace, se usará a un cliente anónimo";
            $this->emit('clienteanonimo-false');
        }
        else
        {
            $this->clienteanonimo = true;
            $this->cliente_id = $this->clienteanonimo_id();
            $this->mensaje_toast = "Se usará a un Cliente Anónimo para esta venta";
            $this->emit('clienteanonimo-true');
        }
    }
    //Obtener el id de un cliente anónimo, si no existe creará uno
    public function clienteanonimo_id()
    {
        $client = Cliente::select('clientes.nombre as nombrecliente','clientes.id as idcliente')
        ->where('clientes.nombre','Cliente Anónimo')
        ->get();
        
        if($client->count() > 0)
        {
            return $client->first()->idcliente;
        }
        else
        {
            $procedencia = ProcedenciaCliente::select('procedencia_clientes.procedencia as procedencia')
            ->where('procedencia_clientes.procedencia','VENTA DE PRODUCTOS')
            ->get();
            if($procedencia->count() > 0)
            {
                $cliente_anonimo = Cliente::create([
                    'nombre' => "Cliente Anónimo",
                    'procedencia_cliente_id' => $procedencia->first()->id
                ]);
                return $cliente_anonimo->id;
            }
            else
            {
                $procedencia = ProcedenciaCliente::create([
                    'procedencia' => "Venta de Productos"
                ]);
                $cliente_anonimo = Cliente::create([
                    'nombre' => "Cliente Anónimo",
                    'procedencia_cliente_id' => $procedencia->id
                ]);
                return $cliente_anonimo->id;
            }
        }
    }
    //Cierra la ventana modal Buscar Cliente y Cambiar el id de la variable $cliente_id
    public function seleccionarcliente($idcliente)
    {
        $this->cliente_id = $idcliente;
        $nombrecliente = Cliente::find($idcliente)->nombre;
        $this->mensaje_toast = "Se seleccionó al cliente: '" . ucwords(strtolower($nombrecliente)) . "' para esta venta";
        $this->emit('hide-buscarcliente');
    }
    //Incrementar Items en el Carrito de Ventas
    public function increase(Product $producto)
    {
        $product_cart = Cart::get($producto->id);
        //Verificamos que exista stock en la TIENDA de la sucursal
        if($this->stocktienda($producto->id, 1))
        {
            //Para saber si el Producto ya esta en el carrrito para cambiar el Mensaje Toast de Producto Agregado a Cantidad Actualizada
            if ($product_cart)
            {
                $this->mensaje_toast = "¡Cantidad Actualizada: '" . strtolower($producto->nombre)."'!";
                if($producto->image == null)
                {
                    Cart::add($product_cart->id, $product_cart->name, $product_cart->price, 1 , 'noimgproduct.png');
                    $this->emit('increase-ok');
                }
                else
                {
                    Cart::add($product_cart->id, $product_cart->name, $product_cart->price, 1 , $producto->image);
                    $this->emit('increase-ok');
                }
            }
            else
            {
                $this->mensaje_toast = "¡Agregado correctamente: '" . $producto->nombre . "'!";
                if($producto->image == null)
                {
                    Cart::add($producto->id, $producto->nombre, $producto->precio_venta, 1 , 'noimgproduct.png');
                    $this->emit('increase-ok');
                }
                else
                {
                    Cart::add($producto->id, $producto->nombre, $producto->precio_venta, 1 , $producto->image);
                    $this->emit('increase-ok');
                }
            }
            //Actualizar los valores de Total Bs y Total Artículos en una Venta
            $this->actualizarvalores();
        }
        else
        {
            $this->modalstockinsuficiente($producto->id);
        }
    }
    //Decrementar Items en el Carrito de Ventas
    public function decrease(Product $producto)
    {
        //Guardamos los datos del producto en Carrito de Ventas
        $product_cart = Cart::get($producto->id);
        //Elimnamos el producto del Carrito de Ventas
        Cart::remove($producto->id);
        //Obtenmos la cantidad que existia del producto en el Carrito de Ventas
        $cant = $product_cart->quantity - 1;
        //Volvemos a añadir el produto al Carrito de Ventas pero con la cantidad actualizada
        if ($cant > 0)
        {
            Cart::add($product_cart->id, $product_cart->name, $product_cart->price, $cant, $product_cart->image);
            // $this->total = Cart::getTotal();
            $this->total = $this->gettotalcart();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', 'Cantidad actualizada');
        }
        //Actualizamos Valores (Unidades y Bs de la Venta)
        $this->actualizarvalores();
    }
    //Para verificar que quede stock disponible en la TIENDA para la venta
    public function stocktienda($idproducto, $cantidad)
    {
        //Primero buscamos stock dispnible del producto en el destino TIENDA
        $producto = Destino::join("productos_destinos as pd", "pd.destino_id", "destinos.id")
        ->join("products as p", "p.id", "pd.product_id")
        ->select("destinos.id as id","destinos.nombre as nombredestino","pd.product_id as idproducto","pd.stock as stock")
        ->where("destinos.sucursal_id", $this->idsucursal())
        ->where('destinos.nombre', 'TIENDA')
        ->where('pd.product_id', $idproducto)
        ->where('p.status', 'ACTIVO')
        ->where('pd.stock','>=', $cantidad)
        ->get();


        if($producto->count() > 0)
        {
            //Variable donde se guardará el stock del producto del Carrito de Ventas
            $stock_cart = 0;
            //Para saber si el Producto ya esta en el carrrito
            $exist = Cart::get($idproducto);
            //Si el producto existe en el Carrito de Ventas actualizamos la variable $stock_cart
            if($exist)
            {
                $stock_cart = Cart::get($idproducto)->quantity;
            }
            //Restamos el stock de la tienda con el stock del Carrito de Ventas
            $stock = $producto->first()->stock - $stock_cart;
            if($stock > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }


        
    }
    //Llama al modal para calcular cambio y finalizar una venta
    public function modalfinalizarventa()
    {
        // Solo si la variable $this->stock_disponible es true e mostrara la ventana modal
        if($this->stock_disponible)
        {
            if($this->cartera_id != "Elegir")
            {
                if($this->stock_disponible)
                {
                    $this->emit('show-finalizarventa');
                }
            }
            else
            {
                $this->emit('show-elegircartera');
            }
            
        }
        else
        {
            $this->stock_disponible = true;
        }
    }
    protected $listeners = [
        'scan-code' => 'ScanCode',
        'clear-Cart' => 'clearcart',
        'clear-Product' => 'clearproduct',
        'saveSale' => 'savesale'
    ];
    //Recibe el codigo del producto para ponerlo en el Carrito de Ventas (Carrito de Ventas)
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
            $this->mensaje_toast = "El producto con el código '". $barcode ."' no existe o no esta registrado";
            $this->emit('increase-notfound');
        }
        else
        {
            if($this->stocktienda($product->id, $cant))
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
                $this->emit('increase-ok');
            }
            else
            {
                $this->modalstockinsuficiente($product->id);
            }
            
        }
    }
    //Vaciar todos los Items en el Carrito
    public function clearcart()
    {
        Cart::clear();
        $this->actualizarvalores();
        $this->emit('cart-clear');
    }
    //Eliminar un producto del Carrito de Ventas
    public function clearproduct(Product $producto)
    {
        //Eliminamos el producto del Carrito de Ventas
        Cart::remove($producto->id);
        $this->mensaje_toast = "Eliminado: '" . $producto->nombre . "'";
        //mostrando mensaje toast
        $this->emit('mensaje-ok');
    }
    //Actualizar los valores de Total Bs y Total Artículos en una Venta
    public function actualizarvalores()
    {
        // $this->total_bs = Cart::getTotal();
        $this->total_bs = $this->gettotalcart();
        $this->total_items = Cart::getTotalQuantity();
        $this->actualizar_desc_recar();
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
    //Guardar una venta
    public function savesale()
    {
        DB::beginTransaction();
        try
        {
            //Creando Movimiento
            $Movimiento = Movimiento::create([
                'type' => "VENTAS",
                'import' => $this->total_bs,
                'user_id' => Auth()->user()->id,
            ]);
            //Creando Cliente Movimiento
            ClienteMov::create([
                'movimiento_id' => $Movimiento->id,
                'cliente_id' => $this->cliente_id,
            ]);
            //Para saber toda la informacionde del id de la cartera seleccionada
            $cartera = Cartera::find($this->cartera_id);
            //Creando la venta
            $sale = Sale::create([
                'total' => $this->total_bs,
                'items' => $this->total_items,
                'cash' => $this->dinero_recibido,
                'change' => $this->cambio,
                'tipopago' => $cartera->nombre,
                'factura' => $this->invoice,
                'cartera_id' => $cartera->id,
                'observacion' => $this->observacion,
                'movimiento_id' => $Movimiento->id,
                'user_id' => Auth()->user()->id
            ]);
            //Actualizando la variable $this->venta_id para poder crear un comprobante de venta
            $this->venta_id = $sale->id;


            //Obteniendo todos los productos del Carrito de Ventas (Carrito de Ventas)
            $productos = Cart::getContent();

            foreach($productos as $p)
            {
                $sd = SaleDetail::create([
                    'price' => $p->price,
                    'quantity' => $p->quantity,
                    'product_id' => $p->id,
                    'sale_id' => $sale->id,
                ]);

                //Para obtener la cantidad del producto que se va a vender
                $cantidad_producto_venta = $p->quantity;

                //Buscamos todos los lotes que tengan ese producto
                $lotes = Lote::where('product_id', $p->id)->where('status','Activo')->get();

                //Recorremos todos los lotes que tengan ese producto
                foreach($lotes as $l)
                {
                    //Obtenemos la cantidad de existencia que tenga ese lote de ese producto
                    $cantidad_producto_lote = $l->existencia;

                    //Si la cantidad del producto para la venta supera la existencia en el lote
                    //Vaciamos toda la existencia de ese lote y lo inactivamos
                    if($cantidad_producto_venta > $cantidad_producto_lote)
                    {
                        //Creamos un registro en la tabla SaleLote con la cantidad total del producto en el lote
                        $sale_lote = SaleLote::create([
                            'sale_detail_id' => $sd->id,
                            'lote_id' => $l->id,
                            'cantidad' => $cantidad_producto_lote
                        ]);
                        //Dismunuimos la cantidad del producto para la venta por el total cantidad del producto en el lote
                        $cantidad_producto_venta = $cantidad_producto_venta - $cantidad_producto_lote;


                        //Actualizamos el lote
                        $l->update([
                            'existencia' => 0,
                            'status' => 'Inactivo'
                            ]);
                        $l->save();
                    }
                    else
                    {
                        //Si la cantidad del producto para la venta no supera la existencia en el lote
                        //Reducimos la existencia de ese lote por la cantidad del producto para la venta
                        SaleLote::create([
                            'sale_detail_id' => $sd->id,
                            'lote_id' => $l->id,
                            'cantidad' => $cantidad_producto_venta
                        ]);

                        $l->update([ 
                            'existencia'=> $cantidad_producto_lote - $cantidad_producto_venta
                        ]);
                        $l->save();
                    }
                }






                //Decrementando el stock en tienda
                $tiendaproducto = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
                ->join('destinos as des', 'des.id', 'productos_destinos.destino_id')
                ->select("productos_destinos.id as id","p.nombre as name",
                "productos_destinos.stock as stock")
                ->where("p.id", $p->id)
                ->where("des.nombre", 'TIENDA')
                ->where("des.sucursal_id", $this->idsucursal())
                ->get()->first();


                $tiendaproducto->update([
                    'stock' => $tiendaproducto->stock - $p->quantity
                ]);






            }

            //Creando Cartera Movimiento
            CarteraMov::create([
                'type' => "INGRESO",
                'tipoDeMovimiento' => "VENTA",
                'comentario' => "Venta",
                'cartera_id' => $cartera->id,
                'movimiento_id' => $Movimiento->id,
            ]);


            $this->resetUI();
            $this->clearcart();
            $this->mensaje_toast = "¡Venta con el código: '" . $sale->id . "' realizada exitosamente!";
            $this->emit('sale-ok');

            DB::commit();

            //Verificando la variable $this->pdf para crear o no un comprobante pdf
            if($this->pdf)
            {
                $this->emit('opentap');
            }


            return Redirect::to('pos');
        }
        catch (Exception $e)
        {
            DB::rollback();
            $this->mensaje_toast = ": ".$e->getMessage();
            $this->emit('sale-error');
        }
    }
    //Listar las Carteras disponibles en su corte de caja
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
    //Volver a los valores por defecto
    public function resetUI()
    {
        $this->total_bs = $this->gettotalcart();
        $this->total_items = Cart::getTotalQuantity();
        $this->factura = false;
        $this->buscarproducto = "";
        $this->cartera_id = 'Elegir';
        $this->cliente_id = $this->clienteanonimo_id();
        $this->clienteanonimo = true;
        $this->observacion = "";
        $this->dinero_recibido = "";
        foreach($this->listarcarteras() as $list)
        {
            if($list->tipo == 'CajaFisica')
            {
                $this->cartera_id = $list->idcartera;
                break;
            }
            
        }
    }
    //llama al modal buscarcliente
    public function modalbuscarcliente()
    {
        $this->emit('show-buscarcliente');
    }
    //llama al modal crearcliente
    public function modalcrearcliente()
    {
        $this->emit('show-crearcliente');
    }
    //Devuelve el nombre de la cartera seleccionada y su tipo
    public function nombrecartera()
    {
        $nombrecartera = Cartera::select('carteras.*')
        ->where('carteras.id' , $this->cartera_id)
        ->get();
        if($nombrecartera->count() > 0)
        {
            return $nombrecartera->first()->nombre . " - " . $nombrecartera->first()->tipo;
        }
        else
        {
            return "Tipo de Pago no selecccionado";
        }
        
    }
    //Método para guardar SI o NO en la variable $invoice para saber si una venta es con factura
    public function facturasino()
    {
        if($this->factura)
        {
            $this->invoice = "No";
            $this->factura = false;
            $this->mensaje_toast = "Venta con factura desactivada";
            $this->emit('mensaje-ok');
        }
        else
        {
            $this->invoice = "Si";
            $this->factura = true;
            $this->mensaje_toast = "Venta con factura activada";
            $this->emit('mensaje-ok');
        }
    }
    //Método para guardar true o false para la variable $this->pdf crear o no comprobante de venta
    public function pdfsino()
    {
        if($this->pdf)
        {
            $this->pdf = false;
        }
        else
        {
            $this->pdf = true;
        }
    }
    //Cambiar el precio de un producto del Carrito de Ventas
    public function cambiarprecio($idproducto, $precio_nuevo)
    {
        //Guardamos los datos del producto del Carrito de Ventas
        $product_cart = Cart::get($idproducto);
        if($precio_nuevo >= 0 && $precio_nuevo != "")
        {
            //Eliminamos el producto del Carrito de Ventas
            Cart::remove($idproducto);
            //Volvemos a añadir el producto con el precio actualizado
            Cart::add($product_cart->id, $product_cart->name, $precio_nuevo, $product_cart->quantity, $product_cart->image);
            //Actualizamos Valores (Unidades y Bs de la Venta)
            $this->actualizarvalores();
            //mensaje a Mostrar
            $this->mensaje_toast = "Precio: '" . $precio_nuevo . " Bs' Actualizado";
            $this->emit('mensaje-ok');
        }
        else
        {
            $this->mensaje_toast = "El precio dado no esta admitido, se usará el precio de '" . $product_cart->price . " Bs'";
            //Eliminamos el producto del Carrito de Ventas
            Cart::remove($idproducto);
            
            //Volvemos a añadir el producto con el precio que tenia en el Carrito de Ventas
            
            Cart::add($product_cart->id, $product_cart->name, $product_cart->price, $product_cart->quantity, $product_cart->image);
            $this->actualizarvalores();
            $this->emit('mensaje-advertencia');
        }
    }
    //Cambiar la cantidad de un producto del Carrito de Ventas
    public function cambiarcantidad($idproducto, $cantidad_nueva)
    {
        //Guardamos los datos del producto del Carrito de Ventas
        $product_cart = Cart::get($idproducto);
        if($this->stocktienda($idproducto, $cantidad_nueva))
        {
            if($cantidad_nueva > 0 && $cantidad_nueva != "")
            {
                //Eliminamos el producto del Carrito de Ventas
                Cart::remove($idproducto);
                //Volvemos a añadir el producto con el precio actualizado
                Cart::add($product_cart->id, $product_cart->name, $product_cart->price, $cantidad_nueva, $product_cart->image);
                //Actualizamos Valores (Unidades y Bs de la Venta)
                $this->actualizarvalores();
                //mensaje a Mostrar
                $this->mensaje_toast = "Cantidad: '" . $cantidad_nueva . " Unidades' Actualizada";
                $this->emit('mensaje-ok');
            }
            else
            {
                $this->mensaje_toast = "La cantidad dada no esta admitida, se usará la cantidad de '" . $product_cart->quantity . " unidades'";
                //Eliminamos el producto del Carrito de Ventas
                Cart::remove($idproducto);
                
                //Volvemos a añadir el producto con el precio que tenia en el Carrito de Ventas
                
                Cart::add($product_cart->id, $product_cart->name, $product_cart->price, $product_cart->quantity, $product_cart->image);
                //Actualizamos Valores (Unidades y Bs de la Venta)
                $this->actualizarvalores();
                $this->emit('mensaje-advertencia');
            }
        }
        else
        {   
            $this->modalstockinsuficiente($idproducto);
        }

        
    }
    //Devolver nombredestino y stock de una sucursal diferente a la que se fue asignado
    public function buscarstocksucursal($idsucursal)
    {
        $destinos = Destino::join("productos_destinos as pd", "pd.destino_id", "destinos.id")
                ->join("products as p", "p.id", "pd.product_id")
                ->select("destinos.id as id","destinos.nombre as nombredestino","pd.product_id as idproducto","pd.stock as stock")
                ->where("destinos.sucursal_id", $idsucursal)
                ->where('pd.product_id', $this->producto_id)
                ->where('p.status', 'ACTIVO')
                ->where('pd.stock','>', 0)
                ->get();
        return $destinos;
    }
    //Actualizar la variable descuento_recargo
    public function actualizar_desc_recar()
    {
        $bs_total_original = 0;
        $items = Cart::getContent();
        foreach ($items as $item)
        {
            $bs_total_original = ($this->buscarprecio($item->id) * $item->quantity) + $bs_total_original;
        }
        $this->descuento_recargo = $bs_total_original - $this->gettotalcart();
    }
    //Devuelve el precio total Bs del Carrito de Ventas
    public function gettotalcart()
    {
        $bs_total_cart = 0;
        $items = Cart::getContent();

        foreach ($items as $item)
        
        {
            $bs_total_cart = ($item->price * $item->quantity) + $bs_total_cart;
        }

        return  $bs_total_cart;
    }
    //Buscar el Precio Original de un Producto
    public function buscarprecio($id)
    {
        $tiendaproducto = Product::select("products.id as id","products.precio_venta as precio")
        ->where("products.id", $id)
        ->get()->first();
        return $tiendaproducto->precio;
    }
    //Crear cliente
    public function crearcliente()
    {
        //Reglas de Validación
        $rules = [
            'cliente_nombre' => 'required',
        ];
        $messages = [
            'cliente_nombre.required' => 'Información Requerida',
        ];
        $this->validate($rules, $messages);
        if($this->cliente_celular == null)
        {
            $newclient = Cliente::create([
                'nombre' => $this->cliente_nombre,
                'cedula' => $this->cliente_ci,
                'celular' => 0,
                // 'telefono' => $this->telefono,
                // 'email' => $this->email,
                // 'nit' => $this->nit,
                // 'razon_social' => $this->razon_social,
                'procedencia_cliente_id' => 1,
            ]);
        }
        else
        {
            $newclient = Cliente::create([
                'nombre' => $this->cliente_nombre,
                'cedula' => $this->cliente_ci,
                'celular' => $this->cliente_celular,
                // 'telefono' => $this->telefono,
                // 'email' => $this->email,
                // 'nit' => $this->nit,
                // 'razon_social' => $this->razon_social,
                'procedencia_cliente_id' => 1,
        ]);
        }
        $this->cliente_id = $newclient->id;
        $this->mensaje_toast = "Se selecciono al cliente creado: '" . $newclient->nombre . "'";
        //Ocultando ventana modal
        $this->emit('hide-crearcliente');
    }
    //Método para mostrar una ventana modal cuando no hay stock en Tiena de un producto
    public function modalstockinsuficiente($idproducto)
    {
        $this->producto_id = $idproducto;

        // Cambiando la variable $this->stock_disponible a false para que no se pueda mostrar la ventana modal finalizar venta
        $this->stock_disponible = false;
        //Buscamos stock disponible del producto en toda la sucursal menos en el destino TIENDA
        //Y actualizando la variable $this->listadestinos para guardar todos los destinos
        //de la sucursal (Menos Tienda) en los que existan stocks disponibles
        $this->listadestinos = Destino::join("productos_destinos as pd", "pd.destino_id", "destinos.id")
        ->join("products as p", "p.id", "pd.product_id")
        ->select("destinos.id as id","destinos.nombre as nombredestino","pd.product_id as idproducto","pd.stock as stock")
        ->where("destinos.sucursal_id", $this->idsucursal())
        ->where('destinos.nombre', '<>' ,'TIENDA')
        ->where('pd.product_id', $this->producto_id)
        ->where('p.status', 'ACTIVO')
        ->get();

        //Guardando el nombre del producto con 0 stock en tienda
        $this->nombreproducto = Product::find($idproducto)->nombre;
        $this->nombresucursal = Sucursal::find($this->idsucursal())->name;

        
        // Lista todas las sucursales menos la sucursal en la que esta
        $this->listasucursales = Sucursal::select("sucursals.*")
        ->where('sucursals.id', '<>' , $this->idsucursal())
        ->get();

        //Mostrando la ventana modal
        $this->emit('show-stockinsuficiente');
    }
}
