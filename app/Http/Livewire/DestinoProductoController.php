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

    public $selected_id,$search,$selected_ubicacion,$componentName,$title,$sql,$pr=false,$show=false,$mm=[1,2,3],$lol;
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
                'p.cantidad_minima as cant_min','p.id as productoid')
                ->where('p.nombre', 'like', '%' . $this->search . '%')
                ->groupBy('productos_destinos.product_id')
                ->paginate($this->pagination);
            }
            
            else{

                $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                ->select(DB::raw('SUM(productos_destinos.stock) as stock_s'),'p.nombre as name',
                'p.cantidad_minima as cant_min','p.id as productoid')
                ->groupBy('productos_destinos.product_id')
                ->paginate($this->pagination);
                
            }

             
            else
             $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                                        ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                                        ->select('productos_destinos.*','p.nombre as name','dest.nombre as nombre_destino',
                                        'p.id as id_prod','p.id as productoid'
                                        
                                        )
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

                                                             }
            
            else{
               
             $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                                            ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                                            ->select(DB::raw('SUM(productos_destinos.stock) as stock_s'),'p.nombre as name',
                                            'p.cantidad_minima as cant_min','p.id as productoid')
                                            ->groupBy('productos_destinos.product_id')
                                            ->paginate($this->pagination);
            }
             $sucursal_ubicacion=Destino::join('sucursals as suc','suc.id','destinos.sucursal_id')
                                        ->select ('suc.name as sucursal','destinos.nombre as destino','destinos.id')
                                        ->orderBy('suc.name','asc');

                           

        return view('livewire.destino_producto.almacen_productos',['destinos_almacen'=>$almacen,'data_suc' =>  $sucursal_ubicacion->get(),
        'data_cat'=>Category::select('categories.name')->where('categories.categoria_padre','0')->get(), 'lol'=>$this->pr
        ])  
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function verMobiliario(Product $prod){
        
        $this->sql= "select rt,location,dsn,suc_name,loc,loc_cod,stock from ( select products.id as rt,destinos.id as dest,destinos.nombre as dsn, sucursals.name as suc_name,stock from productos_destinos 
        join products on productos_destinos.product_id= products.id
        join destinos on productos_destinos.destino_id= destinos.id
        join sucursals on destinos.sucursal_id= sucursals.id
         ) as dd left join ( select products.id as pt,destinos.id as best,destinos.nombre as bsn,locations.id as location, locations.tipo as loc
         ,locations.codigo as loc_cod
         from location_productos
          join products on location_productos.product= products.id
        join locations on location_productos.location= locations.id
        join destinos on locations.destino_id= destinos.id
        ) as mm on dd.dest= mm.best and dd.rt= mm.pt where rt='$prod->id'";
        
        $this->pr=DB::select($this->sql);

     if ($this->pr) {
         dd($this->pr);
        $this->emit('nms');
     }
        
    }
    

}
