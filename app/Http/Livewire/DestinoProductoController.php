<?php

namespace App\Http\Livewire;

use App\Models\Destino;
use App\Models\Location;
use App\Models\ProductosDestino;
use App\Models\Sucursal;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class DestinoProductoController extends Component
{
    use WithPagination;

    public $selected_id,$selected_ubicacion,$componentName,$title;
    private $pagination = 10;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->selected_id=0;
        $this->componentName='crear';
        $this->title='ssss';



    }


  

    public function render()
    {
        if($this->selected_id !== null){

            if($this->selected_id == 'General')
            
              
            $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                                        ->join('locations as loc','loc.id','productos_destinos.location_id')
                                        ->join('destinos as dest','dest.id','loc.destino_id')
                                        
                                        ->select(DB::raw('SUM(productos_destinos.stock) as stock_s'),'p.nombre as name','p.cantidad_minima as cant_min')
                                        ->groupBy('productos_destinos.product_id')
                                      
                                        ->paginate($this->pagination);
            
         else
            $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                                        ->join('locations as loc','loc.id','productos_destinos.location_id')
                                        ->join('destinos as dest','dest.id','loc.destino_id')
                                        
                                        ->select('productos_destinos.*','loc.*','p.nombre as name','loc.tipo as type','dest.nombre as nombre_destino')
                                    
                                        ->where('dest.id',$this->selected_id)
                                        ->orderBy('p.nombre','desc')
                                        ->paginate($this->pagination);
                                        
        }
            
            else{
               
                $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                ->join('locations as loc','loc.id','productos_destinos.location_id')
                ->join('destinos as dest','dest.id','loc.destino_id')
                
                ->select(DB::raw('SUM(productos_destinos.stock) as stock_s'),'p.nombre as name','p.cantidad_minima as cant_min')
                ->groupBy('productos_destinos.product_id')
              
                ->paginate($this->pagination);
            }
            

      
        /*$products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->where('products.name', 'like', '%' . $this->search . '%')
                ->orWhere('products.barcode', 'like', '%' . $this->search . '%')
                ->orWhere('c.name', 'like', '%' . $this->search . '%')
                ->orderBy('products.id', 'desc')
                ->paginate($this->pagination);
        */
            $sucursal_ubicacion=Destino::join('sucursals as suc','suc.id','destinos.sucursal_id')
                                        ->select ('suc.name as sucursal','destinos.nombre as destino','destinos.id')
                                       
                                        ->orderBy('suc.name','asc');

                                    

        return view('livewire.destino_producto.destino-controller',['destinos_almacen'=>$almacen,'data_suc' =>  $sucursal_ubicacion->get()])  
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
