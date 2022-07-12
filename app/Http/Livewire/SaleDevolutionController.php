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
use Carbon\Carbon;


class SaleDevolutionController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public  $search, $nombre, $selected_id, $nombreproducto, $productoentrante;
    public  $pageTitle, $componentName;
    private $pagination = 10;
    
    
    public $identrante, $tipodevolucion, $observaciondevolucion, $bs, $usuarioseleccionado, $tipopago, $destino;

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

        $this->tipopago = 'Elegir';
        $listac = $this->listarcarteras();
        foreach($listac as $list)
            {
                if($list->tipo == 'CajaFisica')
                {
                    $this->tipopago = $list->idcartera;
                    break;
                }
                
            }
        $this->destino = $this->listardestinos()->first()->iddestino;
        
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
            "pd.stock as stock", "products.codigo as barcode")
            ->where("des.nombre", 'TIENDA')
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
            $data = DevolutionSale::join("products as p", "p.id", "devolution_sales.product_id")
            ->join("users as u", "u.id", "devolution_sales.user_id")
            ->join("destinos as des","des.id","devolution_sales.destino_id")
            ->join("carteras as c","c.id","devolution_sales.cartera_id")
            ->select('devolution_sales.id as iddevolucion', 'p.image as image','c.nombre as cartera', 'p.nombre as nombre', 'devolution_sales.monto_dev as monto',
            'devolution_sales.created_at as fechadevolucion','u.name as nombreusuario', 'devolution_sales.estado as estado',
            'devolution_sales.tipo_dev as tipo','devolution_sales.observations as observacion','des.nombre as destino')
            ->where(function($query){
                $query->where('p.nombre', 'like', '%' . $this->search . '%')
                      ->orWhere('p.codigo', 'like', '%' . $this->search . '%');  
                          
            })
            ->orderBy('devolution_sales.created_at', 'desc')
            ->paginate($this->pagination);

            $usuarioespecifico = DevolutionSale::join("products as p", "p.id", "devolution_sales.product_id")
            ->join("users as u", "u.id", "devolution_sales.user_id")
            ->join("destinos as des","des.id","devolution_sales.destino_id")
            ->join("carteras as c","c.id","devolution_sales.cartera_id")
            ->select('devolution_sales.id as iddevolucion', 'p.image as image','c.nombre as cartera', 'p.nombre as nombre', 'devolution_sales.monto_dev as monto',
            'devolution_sales.created_at as fechadevolucion','u.name as nombreusuario','devolution_sales.estado as estado',
            'devolution_sales.tipo_dev as tipo','devolution_sales.observations as observacion','des.nombre as destino')
            ->where(function($query){
                $query->where('p.nombre', 'like', '%' . $this->search . '%')
                      ->orWhere('p.codigo', 'like', '%' . $this->search . '%');  
                          
            })
            ->where('u.id', $this->usuarioseleccionado)
            ->orderBy('devolution_sales.created_at', 'desc')
            ->paginate($this->pagination);
        }  

        else
        {
            $data = DevolutionSale::join("products as p", "p.id", "devolution_sales.product_id")
            ->join("users as u", "u.id", "devolution_sales.user_id")
            ->join("destinos as des","des.id","devolution_sales.destino_id")
            ->join("carteras as c","c.id","devolution_sales.cartera_id")
            ->select('devolution_sales.id as iddevolucion', 'p.image as image','c.nombre as cartera', 'p.nombre as nombre', 'devolution_sales.monto_dev as monto',
            'devolution_sales.created_at as fechadevolucion','u.name as nombreusuario', 'devolution_sales.estado as estado',
            'devolution_sales.tipo_dev as tipo','devolution_sales.observations as observacion','des.nombre as destino')
            ->orderBy('devolution_sales.created_at', 'desc')
            ->paginate($this->pagination);

            $usuarioespecifico = DevolutionSale::join("products as p", "p.id", "devolution_sales.product_id")
            ->join("users as u", "u.id", "devolution_sales.user_id")
            ->join("destinos as des","des.id","devolution_sales.destino_id")
            ->join("carteras as c","c.id","devolution_sales.cartera_id")
            ->select('devolution_sales.id as iddevolucion', 'p.image as image','c.nombre as cartera', 'p.nombre as nombre', 'devolution_sales.monto_dev as monto',
            'devolution_sales.created_at as fechadevolucion','u.name as nombreusuario','devolution_sales.estado as estado',
            'devolution_sales.tipo_dev as tipo','devolution_sales.observations as observacion','des.nombre as destino')
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
            'data' => $data,
            'listausuarios' => $listausuarios,
            'historialventa' => $historialventa,
            'listacarteras' => $this->listarcarteras(),
            'listacarterasg' => $this->listarcarterasg(),
            'listardestinos' => $this->listardestinos()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
    public function listardestinos()
    {
        $destinos = Destino::where('destinos.sucursal_id', $this->idsucursal())
        ->select('destinos.nombre as nombredestino','destinos.id as iddestino')
        ->get();
        return $destinos;
    }
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

    //Guarda la Devolución cuando se devuelve dinero
    public function guardardevolucionmonetaria()
    {
        $Movimiento = Movimiento::create([
            'type' => "DEVOLUCIONVENTA",
            'import' => $this->bs,
            'user_id' => Auth()->user()->id,
        ]);
        $cartera = Cartera::find($this->tipopago);
        //Creando un registro en la tabla devolución
        DevolutionSale::create([
        'tipo_dev' => "MONETARIO",
        'monto_dev' => $this->bs,
        'observations' => $this->observaciondevolucion,
        'product_id' => $this->identrante,
        'user_id' => Auth()->user()->id,
        'movimiento_id' => $Movimiento->id,
        'cartera_id' => $cartera->id,
        'destino_id' => $this->destino
        ]);
        // Creando Cartera Movimiento
        CarteraMov::create([
            'type' => "EGRESO",
            'tipoDeMovimiento' => "VENTA",
            'comentario' => "Devolución Venta",
            'cartera_id' => $cartera->id,
            'movimiento_id' => $Movimiento->id,
        ]);


        //Registrando el Producto Entrante
        //Buscando si existen Productos en Almacen Devoluciones
        $tiendaproducto = ProductosDestino::join('destinos as des', 'des.id', 'productos_destinos.destino_id')
        ->select("productos_destinos.id as id")
        ->where("productos_destinos.product_id", $this->identrante)
        ->where("productos_destinos.destino_id", $this->destino)
        ->where("des.sucursal_id", $this->idsucursal())
        ->get();

        //Si existen Productos en el destino de su Respectiva Sucursal actualizamos su Stock
        //Si no existen Productos Creamos uno en el Else
        if($tiendaproducto->count() > 0)
        {
            $id = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
            ->join('destinos as des', 'des.id', 'productos_destinos.destino_id')
            ->select("productos_destinos.id as id","p.nombre as name",
            "productos_destinos.stock as stock")
            ->where("p.id", $this->identrante)
            ->where("des.id", $this->destino)
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
            ->where("destinos.id", $this->destino)
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
    //Guarda la Devolución cuando se devuelve dinero
    public function guardardevolucionproducto()
    {
        $Movimiento = Movimiento::create([
            'type' => "DEVOLUCIONVENTA",
            'import' => 0,
            'status' => 'INACTIVO',
            'user_id' => Auth()->user()->id,
        ]);
        $cartera = Cartera::find($this->tipopago);
        //Creando un registro en la tabla devolución
        DevolutionSale::create([
        'tipo_dev' => "PRODUCTO",
        'monto_dev' => 0,
        'observations' => $this->observaciondevolucion,
        'product_id' => $this->identrante,
        'user_id' => Auth()->user()->id,
        'movimiento_id' => $Movimiento->id,
        'cartera_id' => $cartera->id,
        'destino_id' => $this->destino
        ]);



         //Decrementando el stock en tienda
         $tienda = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
         ->join('destinos as des', 'des.id', 'productos_destinos.destino_id')
         ->select("productos_destinos.id as id","p.nombre as name",
         "productos_destinos.stock as stock")
         ->where("p.id", $this->identrante)
         ->where("des.nombre", 'TIENDA')
         ->where("des.sucursal_id", $this->idsucursal())
         ->get()->first();


         $tienda->update([
             'stock' => $tienda->stock - 1
         ]);







        //Registrando el Producto Entrante
        //Buscando si existen Productos en Almacen Devoluciones
        $tiendaproducto = ProductosDestino::join('destinos as des', 'des.id', 'productos_destinos.destino_id')
        ->select("productos_destinos.id as id")
        ->where("productos_destinos.product_id", $this->identrante)
        ->where("productos_destinos.destino_id", $this->destino)
        ->where("des.sucursal_id", $this->idsucursal())
        ->get();


        //Si existen Productos en el destino de su Respectiva Sucursal actualizamos su Stock
        //Si no existen Productos Creamos uno en el Else
        if($tiendaproducto->count() > 0)
        {
            $id = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
            ->join('destinos as des', 'des.id', 'productos_destinos.destino_id')
            ->select("productos_destinos.id as id","p.nombre as name",
            "productos_destinos.stock as stock")
            ->where("p.id", $this->identrante)
            ->where("des.id", $this->destino)
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
            ->where("destinos.id", $this->destino)
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


    protected $listeners = ['eliminardevolucion' => 'Destroy'];

    //Eliminar o Anular una Devolución
    public function Destroy(DevolutionSale $id)
    {
        //Encontrando el Id de la Tabla Movimiento  a actualizar (para anular ese movimiento)
        $movimiento = Movimiento::find($id->movimiento_id);
        $movimiento->update([
            'status' => 'INACTIVO'
        ]);
        $movimiento->save();


        //Decrementamos el stock de la locacion donde se guardo la devolucion
        $tiendaproducto = ProductosDestino::join('destinos as des', 'des.id', 'productos_destinos.destino_id')
        ->select("productos_destinos.id as id","productos_destinos.stock as stock")
        ->where("productos_destinos.product_id", $id->product_id)
        ->where("productos_destinos.destino_id", $id->destino_id)
        ->where("des.sucursal_id", $this->idsucursal())
        ->get()
        ->first();

        $tiendaproducto->update([
            'stock' => $tiendaproducto->stock - 1
        ]);
        $tiendaproducto->save();


        //Eliminando la devolucion
        DevolutionSale::where('id', $id->id)->delete();
        
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
