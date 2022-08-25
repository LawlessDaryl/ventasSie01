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
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\SaleLote;
use App\Models\User;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Exception;
use Illuminate\Support\Facades\DB;
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

    use WithPagination;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->paginacion = 10;
        $this->total_bs = Cart::getTotal();
        $this->total_items = Cart::getTotalQuantity();
        $this->factura = false;
        $this->clienteanonimo = true;
        $this->cartera_id = 'Elegir';
        foreach($this->listarcarteras() as $list)
        {
            if($list->tipo == 'CajaFisica')
            {
                $this->cartera_id = $list->idcartera;
                break;
            }
            
        }
        $this->cliente_id = $this->clienteanonimo_id();
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


        return view('livewire.pos.component', [
            'denominations' => Denomination::orderBy('id', 'asc')->get(),
            'listaproductos' => $listaproductos,
            'cart' => Cart::getContent(),
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
            $this->emit('increase-ok');
        }
        else
        {
            Cart::add($producto->id, $producto->nombre, $producto->precio_venta, 1 , $producto->image);
            $this->mensaje_toast = "¡'" . $producto->nombre . "' agregado correctamente!";
            $this->emit('increase-ok');
        }
        $this->actualizarvalores();
    }
    //Llama al modal para calcular cambio y finalizar una venta
    public function modalfinalizarventa()
    {
        if($this->cartera_id != "Elegir")
        {
            $this->emit('show-finalizarventa');
        }
        else
        {
            $this->emit('show-elegircartera');
        }
    }
    protected $listeners = [
        'scan-code' => 'ScanCode',
        'clear-Cart' => 'clearcart',
        'saveSale' => 'saveSale'
    ];
    //Recibe el codigo del producto para ponerlo en el Shopping Cart (Carrito de Compras)
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
    }
    //Vaciar todos los Items en el Carrito
    public function clearcart()
    {
        Cart::clear();
        $this->actualizarvalores();
        $this->emit('cart-clear');
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
            'movimiento_id' => $Movimiento->id,
            'user_id' => Auth()->user()->id
        ]);



        //Obteniendo todos los productos del Shopping Cart (Carrito de Compras)
        $productos = Cart::getContent();

        foreach($productos as $p)
        {
            $sd = SaleDetail::create([
                'price' => $p->price,
                'quantity' => $p->quantity,
                'product_id' => $p->id,
                'sale_id' => $sale->id,
            ]);

            // $lote = Lote::where('product_id', $p->id)->where('status','Activo')->get();

            // //Para obtener la cantidad del producto
            // $cantidad_producto = $p->quantity;

            // foreach($lote as $val)
            // {
            //     $lotecantidad = $val->existencia;
            //     if($cantidad_producto > $lotecantidad)
            //     {
            //         $sl = SaleLote::create([
            //             'sale_detail_id' => $sd->id,
            //             'lote_id' => $val->id,
            //             'cantidad' => $val->existencia
            //         ]);

            //         $val->update([
            //             'existencia' => 0,
            //             'status' => 'Inactivo'
            //          ]);
            //          $val->save();
            //     }
            //     else
            //     {
            //         $dd = SaleLote::create([
            //             'sale_detail_id' => $sd->id,
            //             'lote_id' => $val->id,
            //             'cantidad' => $this->qq
            //         ]);
                  

            //         $val->update([ 
            //             'existencia'=>$this->lotecantidad-$this->qq
            //         ]);
            //         $val->save();
            //         $cantidad_producto = 0;
            //     }
            // }
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
        $this->total_bs = Cart::getTotal();
        $this->total_items = Cart::getTotalQuantity();
        $this->factura = false;
        $this->buscarproducto = "";
        $this->cartera_id = 'Elegir';
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
    //Devuelve el nombre de la cartera seleccionada y su tipo
    public function nombrecartera()
    {
        $nombrecartera = Cartera::select('carteras.*')
        ->where('carteras.id' , $this->cartera_id)
        ->get()
        ->first();
        return $nombrecartera->nombre . " - " . $nombrecartera->tipo;
    }
}
