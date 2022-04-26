<?php

namespace App\Http\Livewire;

use App\Models\Devolution;
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
    private $pagination = 5;
    
    
    public $productosaliente;
    //Ids del Producto que Entra y Producto que sale
    public $identrante, $idsaliente, $tipodevolucion;

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








        
        /* Caja en la cual se encuentra el usuario */
        $data = Devolution::select('devolutions.id as id','devolutions.created_at as ferchadevolucion','devolutions.tipo as tipo')
            ->get();







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

        //Buscando Producto Saliente en La Devolucion
        $ps = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
        ->join('locations as d', 'd.id', 'pd.location_id')
        ->join('destinos as des', 'des.id', 'd.destino_id')
        ->select("products.id as llaveid","products.nombre as nombre", "products.image as image", "products.precio_venta as precio_venta",
        "products.costo as costoproducto")
        ->where("des.nombre", 'TIENDA')
        ->where("des.sucursal_id", $this->idsucursal())
        ->where('products.id', $this->idsaliente)
        ->get();


        return view('livewire.sales.saledevolution', [
            'datosnombreproducto' => $datosnombreproducto,
            'ppee' => $pe,
            'ppss' => $ps,
            'data' => $data,
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

    public function entry($id)
    {
        $this->productoentrante = 1;
        $this->identrante = $id;
        $this->entrada = $this->buscarproducto($this->identrante);
        
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
}
