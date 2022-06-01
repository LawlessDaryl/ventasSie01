<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\ClienteMov;
use App\Models\Destino;
use App\Models\DevolutionSale;
use App\Models\Location;
use App\Models\Movimiento;
use App\Models\Product;
use App\Models\ProductosDestino;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class SaleDevolutionController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public  $search, $nombre, $selected_id, $nombreproducto, $productoentrante;
    public  $pageTitle, $componentName;
    private $pagination = 10;
    
    
    public $identrante, $tipodevolucion, $observaciondevolucion, $bs, $usuarioseleccionado;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Devoluciones';
        $this->componentName = 'Ventas';
        $this->ProductSelectNombre = 1;
        $this->selected_id = 0;
        $this->tipodevolucion = 'monetario';
        $this->usuarioseleccionado = Auth()->user()->id;
        
    }
    public function render()
    {
        /* Buscar Productos por el Nombre*/
        $datosnombreproducto = [];
        if (strlen($this->nombreproducto) > 0)
        {
            //Buscando Stock del Producto en Tienda
            $datosnombreproducto = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
            ->join('destinos as des', 'des.id', 'pd.destino_id')
            ->select("products.id as llaveid","products.nombre as nombre", "products.image as image", "products.precio_venta as precio_venta",
            "products.costo as costoproducto")
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





        //Buscando Producto Entrante que llega a la Tienda para la Devolucion
        $pe = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
        ->join('destinos as des', 'des.id', 'pd.destino_id')
        ->select("products.id as llaveid","products.nombre as nombre", "products.image as image", "products.precio_venta as precio_venta",
        "products.costo as costoproducto")
        ->where("des.nombre", 'TIENDA')
        ->where("des.sucursal_id", $this->idsucursal())
        ->where('products.id', $this->identrante)
        ->get();


        //Listando Todos los Usuarios
        $listausuarios = User::select("users.id as id","users.name as nombreusuario")
        ->get();


        
        //Listar, Buscar y filtrar la tabla de Devoluciones por Usuario
        if (strlen($this->search) > 0)
        {
            $devolucionesusuario = DevolutionSale::join("products as p", "p.id", "devolution_sales.product_id")
            ->join("users as u", "u.id", "devolution_sales.user_id")
            ->select('devolution_sales.id as id', 'p.image as image', 'p.nombre as nombre', 'devolution_sales.monto_dev as monto',
            'devolution_sales.created_at as fechadevolucion','u.name as nombreusuario', 'devolution_sales.estado as estado',
            'devolution_sales.tipo_dev as tipo','devolution_sales.observations as observacion')
            ->where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('devolution_sales.created_at', 'desc')
            ->paginate($this->pagination);

            $usuarioespecifico = DevolutionSale::join("products as p", "p.id", "devolution_sales.product_id")
            ->join("users as u", "u.id", "devolution_sales.user_id")
            ->select('devolution_sales.id as id', 'p.image as image', 'p.nombre as nombre', 'devolution_sales.monto_dev as monto',
            'devolution_sales.created_at as fechadevolucion','u.name as nombreusuario','devolution_sales.estado as estado',
            'devolution_sales.tipo_dev as tipo','devolution_sales.observations as observacion')
            ->where('nombre', 'like', '%' . $this->search . '%')
            ->where('u.id', $this->usuarioseleccionado)
            ->orderBy('devolution_sales.created_at', 'desc')
            ->paginate($this->pagination);
        }  

        else
        {
            $devolucionesusuario = DevolutionSale::join("products as p", "p.id", "devolution_sales.product_id")
            ->join("users as u", "u.id", "devolution_sales.user_id")
            ->select('devolution_sales.id as id', 'p.image as image', 'p.nombre as nombre', 'devolution_sales.monto_dev as monto',
            'devolution_sales.created_at as fechadevolucion','u.name as nombreusuario', 'devolution_sales.estado as estado',
            'devolution_sales.tipo_dev as tipo','devolution_sales.observations as observacion')
            ->orderBy('devolution_sales.created_at', 'desc')
            ->paginate($this->pagination);

            $usuarioespecifico = DevolutionSale::join("products as p", "p.id", "devolution_sales.product_id")
            ->join("users as u", "u.id", "devolution_sales.user_id")
            ->select('devolution_sales.id as id', 'p.image as image', 'p.nombre as nombre', 'devolution_sales.monto_dev as monto',
            'devolution_sales.created_at as fechadevolucion','u.name as nombreusuario','devolution_sales.estado as estado',
            'devolution_sales.tipo_dev as tipo','devolution_sales.observations as observacion')
            ->where('u.id', $this->usuarioseleccionado)
            ->orderBy('devolution_sales.created_at', 'desc')
            ->paginate($this->pagination);
        }


        //Listar un Historial de Ventas de un Producto Seleccionado
        $historialventa = Sale::join('sale_details as sd', 'sd.sale_id', 'sales.id')
        ->join('products as p', 'p.id', 'sd.product_id')
        ->join('users as u', 'u.id', 'sales.user_id')
        ->join("movimientos as m", "m.id", "sales.movimiento_id")
        ->join("cliente_movs as cm", "cm.movimiento_id", "m.id")
        ->join("clientes as c", "c.id", "cm.cliente_id")
        ->select('sales.id as id','sales.created_at as fechaventa', 'sales.items as items','sales.cash as totalbs', 'p.image as image'
        ,'sales.tipopago as tipopago','sales.observacion as ob','sales.items as items',
        'u.name as nombreusuario')
        ->where('p.id',$this->identrante)
        ->where('sales.created_at','>=',now()->subDays(30))
        ->orderBy('sales.created_at', 'desc')
        ->get();












        return view('livewire.sales.saledevolution', [
            'datosnombreproducto' => $datosnombreproducto,
            'ppee' => $pe,
            'usuarioespecifico' => $usuarioespecifico,
            'data' => $devolucionesusuario,
            'listausuarios' => $listausuarios,
            'historialventa' => $historialventa,
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    //Obtener el Id de la Sucursal Donde esta el Usuario
    public function idsucursal()
    {
        //Obteniendo el id de la sucursal del usuario
        $idsucursal = User::join("sucursal_users as su","su.user_id","users.id")
        ->select("su.sucursal_id as id","users.name as n")
        ->where("users.id",Auth()->user()->id)
        ->where("su.estado","ACTIVO")
        ->get()
        ->first();
        return $idsucursal->id;
    }

    //Listar el producto que nos estan devolviendo
    public function entry($id)
    {
        $this->productoentrante = 1;
        $this->identrante = $id;
        $this->entrada = $this->buscarproducto($this->identrante);
        $this->llenarbs();
        
    }

    public function exit($id)
    {
        $this->productosaliente = 1;
        $this->idsaliente = $id;
        $this->salida = $this->buscarproducto($this->idsaliente);
    }
    //Buscar Datos de un Producto Buscando por Id
    public function buscarproducto($id)
    {
        $datosproducto = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
        ->join('destinos as des', 'des.id', 'pd.destino_id')
        ->select("products.id as llaveid","products.nombre as nombre", "products.image as image", "products.precio_venta as precio_venta",
        "products.costo as costoproducto")
        ->where("des.nombre", 'TIENDA')
        ->where("des.sucursal_id", $this->idsucursal())
        ->where('products.id', $id)
        ->get()
        ->first();
        return $datosproducto;
    }

    //Poner el Precio Original en el Input
    public function llenarbs()
    {
        $precio = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
        ->join('destinos as des', 'des.id', 'pd.destino_id')
        ->select("products.id as llaveid","products.nombre as nombre", "products.image as image", "products.precio_venta as precio_venta",
        "products.costo as costoproducto")
        ->where("des.nombre", 'TIENDA')
        ->where("des.sucursal_id", $this->idsucursal())
        ->where('products.id', $this->identrante)
        ->get()
        ->first();
        $this->bs = $precio->precio_venta;
    }
    public function cambiarformatofecha($fecha)
    {
        $hora = date("h:i:s a", strtotime($fecha));
        $fecha = date("d/m/Y", strtotime($fecha));

        
        return $hora." - ".$fecha;
    }

    //Guarda la Devolución
    public function guardardevolucion()
    {
        //Si no puso ningun dato en el Motivo de la Devolución se pondra este mensaje 
        if($this->observaciondevolucion == "")
        {
            $this->observaciondevolucion = "No se coloco ningún Motivo";
        }
        //Creando un registro en la tabla devolución
        DevolutionSale::create([
            'tipo_dev' => "MONETARIO",
            'monto_dev' => $this->bs,
            'observations' => $this->observaciondevolucion,
            'product_id' => $this->identrante,
            'user_id' => Auth()->user()->id
        ]);
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



        // Creando Movimiento
        $Movimiento = Movimiento::create([
            'type' => "DEVOLUCIONVENTA",
            'import' => $this->bs,
            'user_id' => Auth()->user()->id,
        ]);
        //Creando Movimiento del Cliente
        ClienteMov::create([
            'movimiento_id' => $Movimiento->id,
            'cliente_id' => 1,
        ]);
        //Tipo de Pago
        $cartera = Cartera::where('tipo', 'cajafisica')
                    ->where('caja_id', $cajausuario->id)
                    ->get()->first();
        // Creando Cartera Movimiento
        CarteraMov::create([
            'type' => "EGRESO",
            'comentario' => "Devolución Venta",
            'cartera_id' => $cartera->id,
            'movimiento_id' => $Movimiento->id,
        ]);


        //Registrando el Producto Entrante

        //Buscando si existen Productos en Almacen Devoluciones
        $tiendaproducto = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
        ->join('destinos as des', 'des.id', 'productos_destinos.destino_id')
        ->select("productos_destinos.id as id","p.nombre as name",
        "productos_destinos.stock as stock")
        ->where("p.id", $this->identrante)
        ->where("des.nombre", 'Almacen Devoluciones')
        ->where("des.sucursal_id", $this->idsucursal())
        ->get();

        //Si existen Productos en Almacen Devoluciones de su Respectiva Sucursal actualizamos su Stock
        //Si no existen Productos Creamos uno en el Else
        if($tiendaproducto->count() > 0)
        {
            $id = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
            ->join('destinos as des', 'des.id', 'productos_destinos.destino_id')
            ->select("productos_destinos.id as id","p.nombre as name",
            "productos_destinos.stock as stock")
            ->where("p.id", $this->identrante)
            ->where("des.nombre", 'Almacen Devoluciones')
            ->where("des.sucursal_id", $this->idsucursal())
            ->get()
            ->first();
            
            $orig = ProductosDestino::find($id->id);
            $orig->update([
                'stock' => $id->stock + 1,
            ]);
            $orig->save();
        }
        else
        {
            //Buscamos el destino y sucursal donde se encuentra el usuario
            $destino = Destino::select("destinos.id as id")
            ->where("destinos.sucursal_id", $this->idsucursal())
            ->where("destinos.nombre", "Almacen Devoluciones")
            ->get()
            ->first();



            //Creamos el Producto
            ProductosDestino::create([
                'product_id' => $this->identrante,
                'destino_id' => $destino->id,
                'stock' => 1
            ]);

        }


        //Reseteamos los datos e información almacenados en la Venta Modal
        $this->resetUI();
    }

    //Guardar una devolucion Cuando se devuelve el mismo Producto
    public  function devolverproducto()
    {
        if($this->observaciondevolucion == "")
        {
            $this->observaciondevolucion = "No se coloco ningún Motivo";
        }
        DevolutionSale::create([
            'tipo_dev' => "PRODUCTO",
            'monto_dev' => 0,
            'observations' => $this->observaciondevolucion,
            'product_id' => $this->identrante,
            'user_id' => Auth()->user()->id
        ]);

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



        // Creando Movimiento
        $Movimiento = Movimiento::create([
            'type' => "DEVOLUCIONVENTA",
            'import' => 0,
            'user_id' => Auth()->user()->id,
        ]);
        //Creando Movimiento del Cliente
        ClienteMov::create([
            'movimiento_id' => $Movimiento->id,
            'cliente_id' => 1,
        ]);
        //Tipo de Pago
        $cartera = Cartera::where('tipo', 'cajafisica')
                    ->where('caja_id', $cajausuario->id)
                    ->get()->first();
        // Creando Cartera Movimiento
        CarteraMov::create([
            'type' => "EGRESO",
            'comentario' => "Devolución Venta",
            'cartera_id' => $cartera->id,
            'movimiento_id' => $Movimiento->id,
        ]);


        //Registrando el Producto Entrante

        //Buscando si existen Productos en Almacen Devoluciones
        $tiendaproducto = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
        ->join('destinos as des', 'des.id', 'productos_destinos.destino_id')
        ->select("productos_destinos.id as id","p.nombre as name",
        "productos_destinos.stock as stock")
        ->where("p.id", $this->identrante)
        ->where("des.nombre", 'Almacen Devoluciones')
        ->where("des.sucursal_id", $this->idsucursal())
        ->get();

        //Si existen Productos en Almacen Devoluciones de su Respectiva Sucursal actualizamos su Stock
        //Si no existen Productos Creamos uno en el Else
        if($tiendaproducto->count() > 0)
        {
            $id = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
            ->join('destinos as des', 'des.id', 'productos_destinos.destino_id')
            ->select("productos_destinos.id as id","p.nombre as name",
            "productos_destinos.stock as stock")
            ->where("p.id", $this->identrante)
            ->where("des.nombre", 'Almacen Devoluciones')
            ->where("des.sucursal_id", $this->idsucursal())
            ->get()
            ->first();
            
            $orig = ProductosDestino::find($id->id);
            $orig->update([
                'stock' => $id->stock + 1,
            ]);
            $orig->save();
        }
        else
        {
            //Buscamos la Locacion donde se encuentra el usuario
            $locacion = Location::join('destinos as des', 'des.id', 'locations.destino_id')
            ->join('sucursals as s','s.id','des.sucursal_id')
            ->select("locations.id as id")
            ->where("s.id", $this->idsucursal())
            ->where("des.nombre", 'Almacen Devoluciones')
            ->get()
            ->first();


            //Creamos el Producto
            ProductosDestino::create([
                'product_id' => $this->identrante,
                'location_id' => $locacion->id,
                'stock' => 1
            ]);

        }

        //Decrementamos el Stock del Producto que estamos Devolviendo
        $idproducto = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
            ->join('destinos as des', 'des.id', 'productos_destinos.destino_id')
            ->select("productos_destinos.id as id","p.nombre as name",
            "productos_destinos.stock as stock")
            ->where("p.id", $this->identrante)
            ->where("des.nombre", 'Tienda')
            ->where("des.sucursal_id", $this->idsucursal())
            ->get()
            ->first();
            
            $producto = ProductosDestino::find($idproducto->id);
            $producto->update([
                'stock' => $idproducto->stock - 1,
            ]);
            $producto->save();




        $this->resetUI();
    }


    protected $listeners = ['eliminardevolucion' => 'Destroy'];

    //Eliminar una Devolución
    public function Destroy(DevolutionSale $id)
    {
        $id->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Devolución Eliminada con Éxito');
    }

    //Mostrar Detalles del Historial de una Venta
    public function venta($idventa)
    {
        $venta = Sale::join("sale_details as sd", "sd.sale_id", "sales.id")
        ->join("products as p", "p.id", "sd.product_id")
        ->select("sales.created_at as fechaventa", "p.nombre as nombre", "sd.price as precio","sd.quantity as cantidad")
        ->where("sales.id", $idventa)
        ->get();
        return $venta;
    }
    //Verificamos si queda Stock Disponible si queremos devolver un Producto por un Producto
    public function verificarstock()
    {
        $producto = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
        ->join('destinos as des', 'des.id', 'productos_destinos.destino_id')
        ->select("productos_destinos.id as id","p.nombre as name",
        "productos_destinos.stock as stock")
        ->where("p.id", $this->identrante)
        ->where("des.nombre", 'Tienda')
        ->where("des.sucursal_id", $this->idsucursal())
        ->get()
        ->first();

        if($producto->stock > 0)
        {
            return true;
        }
        return false;

    }

    //Metodo para Verificar si el usuario tiene el Permiso para filtrar transferir y anular una devolucion
    public function verificarpermiso()
    {
        if(Auth::user()->hasPermissionTo('VentasDevolucionesFiltrar'))
        {
            return true;
        }
        return false;
    }

    public function resetUI()
    {
        $this->observaciondevolucion = "";
        $this->nombreproducto = "";
        $this->productoentrante = null;
        $this->selected_id = 0;
    }



}
