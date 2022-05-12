<?php

namespace App\Http\Livewire;
use App\Models\Category;
use App\Models\Destino;
use App\Models\LocationProducto;
use App\Models\Product;
use App\Models\ProductosDestino;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;



class DestinoProductoController extends Component
{
    
    use WithPagination;

    public $selected_id,$search,$selected_ubicacion,$componentName,$title;
    private $pagination = 10;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    
    public function mount()
    {
        $this->selected_id="General";
        $this->componentName='crear';
        $this->title='ssss';
      
    }

    public function render()
    {
        if($this->selected_id !== null){

            if($this->selected_id === 'General')

            if (strlen($this->search) > 0) {
                $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                ->select(DB::raw('SUM(productos_destinos.stock) as stock_s'),'p.nombre as name',
                'p.cantidad_minima as cant_min')
                ->where('p.nombre', 'like', '%' . $this->search . '%')
                ->groupBy('productos_destinos.product_id')
                ->paginate($this->pagination);

            }
            
            else{

                $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                ->select(DB::raw('SUM(productos_destinos.stock) as stock_s'),'p.nombre as name',
                'p.cantidad_minima as cant_min')
                ->groupBy('productos_destinos.product_id')
                ->paginate($this->pagination);
            }

             
            else
             $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                                        ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                                        ->select('productos_destinos.*','p.nombre as name','dest.nombre as nombre_destino',
                                        'p.id as id_prod')
                                        ->where('dest.id',$this->selected_id)
                                        ->where(function($query){
                                            $query->where('p.nombre', 'like', '%' . $this->search . '%')
                                                  ->orWhere('p.codigo', 'like', '%' . $this->search . '%');
                                        })
                                        ->orderBy('p.nombre','desc')
                                        ->paginate($this->pagination);  

                                        /* para hacer merge $collection = collect(['Desk', 'Chair']);
                                        $merged = $collection->merge(['Bookcase', 'Door']);
                                        $merged->all();*/ 
                                        
                                        $sql= 'select rt,location,dest from ( select products.nombre as rt,destinos.id as dest from productos_destinos 
                                        join products on productos_destinos.product_id= products.id
                                        join destinos on productos_destinos.destino_id= destinos.id
                                         ) as dd left join ( select products.nombre as pt,destinos.id as best,locations.id as location from location_productos
                                          join products on location_productos.product= products.id
                                        join locations on location_productos.location= locations.id
                                        join destinos on locations.destino_id= destinos.id) as mm on dd.dest= mm.best and dd.rt= mm.pt';

                                        

                                        $ff= ProductosDestino::join('products','productos_destinos.product_id','products.id')
                                        ->join('destinos','productos_destinos.destino_id','destinos.id')
                                        ->select('products.nombre','destinos.id as destiti')->get();

                                        

                                        $kk= LocationProducto::join('products','location_productos.product','products.id')
                                        ->join('locations','location_productos.location','locations.id')
                                        ->join('destinos','locations.destino_id','destinos.id')
                                        ->select('products.nombre','destinos.id as destino','locations.id as location')->get();

                                        


                                        $pr=DB::select($sql);
                                     
    }
            
            else{
               
             $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                                            ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                                            ->select(DB::raw('SUM(productos_destinos.stock) as stock_s'),'p.nombre as name',
                                            'p.cantidad_minima as cant_min')
                                            ->groupBy('productos_destinos.product_id')
                                            ->paginate($this->pagination);
            }
             $sucursal_ubicacion=Destino::join('sucursals as suc','suc.id','destinos.sucursal_id')
                                        ->select ('suc.name as sucursal','destinos.nombre as destino','destinos.id')
                                        ->orderBy('suc.name','asc');

                           

        return view('livewire.destino_producto.almacen_productos',['destinos_almacen'=>$almacen,'data_suc' =>  $sucursal_ubicacion->get(),
        'data_cat'=>Category::select('categories.name')->where('categories.categoria_padre','0')->get()
        ])  
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function verMobiliario(){
        
    }
    

}
