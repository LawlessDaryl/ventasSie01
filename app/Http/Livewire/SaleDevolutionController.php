<?php

namespace App\Http\Livewire;

use App\Models\DevolutionSale;
use App\Models\Product;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class SaleDevolutionController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public  $search, $nombre, $selected_id, $nombreproducto, $productoentrante;
    public  $pageTitle, $componentName;
    private $pagination = 7;
    
    
    public $identrante, $tipodevolucion, $observaciondevolucion, $bs, $usuarioseleccionado, $tipovista;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Devoluciones';
        $this->componentName = 'Ventas';
        $this->tipovista = "devolucion";
        $this->ProductSelectNombre = 1;
        $this->selected_id = 0;
        $this->tipodevolucion = 'monetario';
        if(Auth()->user()->profile == "ADMIN")
        {
            $this->usuarioseleccionado = "Todos";
        }
        else
        {
            $this->usuarioseleccionado = Auth()->user()->id;
        }
        
    }
    public function render()
    {
        /* Buscar Productos por el Nombre*/
        $datosnombreproducto = [];
        if (strlen($this->nombreproducto) > 0)
        {
            //Buscando Stock del Producto en Tienda
            $datosnombreproducto = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
            ->join('locations as d', 'd.id', 'pd.location_id')
            ->join('destinos as des', 'des.id', 'd.destino_id')
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





        //Buscando Producto Entrante en La Devolucion
        $pe = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
        ->join('locations as d', 'd.id', 'pd.location_id')
        ->join('destinos as des', 'des.id', 'd.destino_id')
        ->select("products.id as llaveid","products.nombre as nombre", "products.image as image", "products.precio_venta as precio_venta",
        "products.costo as costoproducto")
        ->where("des.nombre", 'TIENDA')
        ->where("des.sucursal_id", $this->idsucursal())
        ->where('products.id', $this->identrante)
        ->get();


        //Listando Todos los Usuarios
        $listausuarios = User::select("users.id as id","users.name as nombreusuario")
        ->get();


        

        if (strlen($this->search) > 0)
        {
            $devolucionesusuario = DevolutionSale::join("products as p", "p.id", "devolution_sales.product_id")
            ->join("users as u", "u.id", "devolution_sales.user_id")
            ->select('devolution_sales.id as id', 'p.image as image', 'p.nombre as nombre', 'devolution_sales.monto_dev as monto',
            'devolution_sales.created_at as fechadevolucion','u.name as nombreusuario',
            'devolution_sales.tipo_dev as tipo','devolution_sales.observations as observacion')
            ->where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('devolution_sales.created_at', 'desc')
            ->paginate($this->pagination);

            $usuarioespecifico = DevolutionSale::join("products as p", "p.id", "devolution_sales.product_id")
            ->join("users as u", "u.id", "devolution_sales.user_id")
            ->select('devolution_sales.id as id', 'p.image as image', 'p.nombre as nombre', 'devolution_sales.monto_dev as monto',
            'devolution_sales.created_at as fechadevolucion','u.name as nombreusuario',
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
            'devolution_sales.created_at as fechadevolucion','u.name as nombreusuario',
            'devolution_sales.tipo_dev as tipo','devolution_sales.observations as observacion')
            ->orderBy('devolution_sales.created_at', 'desc')
            ->paginate($this->pagination);

            $usuarioespecifico = DevolutionSale::join("products as p", "p.id", "devolution_sales.product_id")
            ->join("users as u", "u.id", "devolution_sales.user_id")
            ->select('devolution_sales.id as id', 'p.image as image', 'p.nombre as nombre', 'devolution_sales.monto_dev as monto',
            'devolution_sales.created_at as fechadevolucion','u.name as nombreusuario',
            'devolution_sales.tipo_dev as tipo','devolution_sales.observations as observacion')
            ->where('u.id', $this->usuarioseleccionado)
            ->orderBy('devolution_sales.created_at', 'desc')
            ->paginate($this->pagination);
        }














        return view('livewire.sales.saledevolution', [
            'datosnombreproducto' => $datosnombreproducto,
            'ppee' => $pe,
            'usuarioespecifico' => $usuarioespecifico,
            'data' => $devolucionesusuario,
            'listausuarios' => $listausuarios,
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
    public function buscarproducto($id)
    {
        $a = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
        ->join('locations as d', 'd.id', 'pd.location_id')
        ->join('destinos as des', 'des.id', 'd.destino_id')
        ->select("products.id as llaveid","products.nombre as nombre", "products.image as image", "products.precio_venta as precio_venta",
        "products.costo as costoproducto")
        ->where("des.nombre", 'TIENDA')
        ->where("des.sucursal_id", $this->idsucursal())
        ->where('products.id', $id)
        ->get()
        ->first();
        return $a;
    }

    //Poner el Precio Original en el Input
    public function llenarbs()
    {
        $precio = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
        ->join('locations as d', 'd.id', 'pd.location_id')
        ->join('destinos as des', 'des.id', 'd.destino_id')
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
        if($this->observaciondevolucion == "")
        {
            $this->observaciondevolucion = "Sin Motivo";
        }
        DevolutionSale::create([
            'tipo_dev' => "MONETARIO",
            'monto_dev' => $this->bs,
            'observations' => $this->observaciondevolucion,
            'product_id' => $this->identrante,
            'user_id' => Auth()->user()->id
        ]);
        $this->resetUI();
    }

    //Guardar una devolucion Cuando se devuelve el mismo Producto
    public  function devolverproducto()
    {
        if($this->observaciondevolucion == "")
        {
            $this->observaciondevolucion = "Sin Motivo";
        }
        DevolutionSale::create([
            'tipo_dev' => "PRODUCTO",
            'monto_dev' => 0,
            'observations' => $this->observaciondevolucion,
            'product_id' => $this->identrante,
            'user_id' => Auth()->user()->id
        ]);
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


    public function resetUI()
    {
        $this->observaciondevolucion = "";
        $this->nombreproducto = "";
        $this->productoentrante = null;
        $this->selected_id = 0;
    }



}
