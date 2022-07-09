<?php

namespace App\Http\Livewire;
use App\Models\Category;
use App\Models\Destino;
use App\Models\Location;
use App\Models\LocationProducto;
use App\Models\Product;
use App\Models\ProductosDestino;
use Illuminate\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;



class DestinoProductoController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $selected_id,$search,$selected_ubicacion,$componentName,$title,$sql,$prod,$grouped,$productoajuste,$cantidad,$productid,$productstock,$mobiliario,$mobs,$mop_prod=0;
    private $pagination = 50;
   
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    
    public function mount()
    {
        $this->selected_id="General";
        $this->componentName='crear';
        $this->title='ssss';
        $this->pr=20;
    
    }
    public function cerrar(){
        $this->grouped=false;
    }

    public function render()
    {

        if($this->selected_id !== null){

            if($this->selected_id === 'General')

            if (strlen($this->search) > 0) {
                $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                ->select('p.*')
                ->where('p.nombre', 'like', '%' . $this->search . '%')
                ->groupBy('productos_destinos.product_id')
                ->selectRaw('sum(productos_destinos.stock) as stock_s')
                ->paginate($this->pagination);
            }
            else{
                $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                ->select('p.*')
                ->groupBy('productos_destinos.product_id')
                ->selectRaw('sum(productos_destinos.stock) as stock_s')
                ->paginate($this->pagination);
               // dd($almacen);
                
            }

             
            else
             $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                                        ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                                        ->select('productos_destinos.*','p.*')
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

                                                             }
            
            else{
               
             $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                                            ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                                            ->select('p.*')
                                            ->groupBy('productos_destinos.product_id')
                                            ->selectRaw('sum(productos_destinos.stock) as stock_s')
                                            ->paginate($this->pagination);
            }
             $sucursal_ubicacion=Destino::join('sucursals as suc','suc.id','destinos.sucursal_id')
                                        ->select ('suc.name as sucursal','destinos.nombre as destino','destinos.id')
                                        ->orderBy('suc.name','asc');

                           

        return view('livewire.destinoproducto.almacenproductos',[
            'destinos_almacen'=>$almacen,
            'data_suc' =>  $sucursal_ubicacion->get(),
        'data_cat'=>Category::select('categories.name')->where('categories.categoria_padre','0')->get()
        ])  
        ->extends('layouts.theme.app')
        ->section('content');
    }


    public function ver(Product $prod){
         $this->sql= "select rt,location,dsn,suc_id,loc,loc_cod,stock from ( select products.id as rt,destinos.id as dest,destinos.nombre as dsn, sucursals.name as suc_id,stock from productos_destinos 
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
        $collection= new SupportCollection();
         
        foreach ($this->pr as $value) {
            $collection->push(
                (object)[
                    'producto_id'=>$value->rt,
                    'mob_code'=>$value->loc_cod,
                    'tipo'=>$value->loc,
                    'estancia'=>$value->dsn,
                    'sucursal_id'=>$value->suc_id,
                    'stock'=>$value->stock
                ]
                );
        }

     $this->grouped= $collection->groupBy(['sucursal_id','estancia']);
    
//dd($this->grouped);
        $this->emit('show-modal','showsss');
     
    
    }

    public function ajuste(Product $prod){

        $this->productoajuste=$prod->nombre;
        $this->productid=$prod->id;
        $this->productstock=ProductosDestino::where('productos_destinos.product_id',$prod->id)->where('productos_destinos.destino_id',$this->selected_id)->value('stock');

        $this->mobs = Location::where('locations.destino_id',$this->selected_id)
        ->select('locations.*')
        ->get();

        $this->mop_prod = LocationProducto::where('location_productos.product',$this->productid)->get();

        $this->emit('show-modal-ajuste');
    }
    
    public function guardarajuste(){
       
        ProductosDestino::where('productos_destinos.destino_id',$this->selected_id)->where('productos_destinos.product_id',$this->productid)
        ->update(['stock' => $this->productstock+ $this->cantidad ]);

       if ($this->mobiliario) {
        
        LocationProducto::create([
            'product'=>$this->productid,
            'location'=>$this->mobiliario
        ]);
       }

        $this->emit('hide-modal-ajuste');
        $this->cantidad= null;
        
    }
    protected $listeners = ['vaciarDestino' => 'vaciarAlmacen'];

    public function vaciarAlmacen(){

        $auxi2=ProductosDestino::where('productos_destinos.destino_id',$this->selected_id)->get();
        foreach ($auxi2 as $data) {
        $data->stock = 0;
        $data->save();
        }
    }

}
