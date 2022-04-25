<?php

namespace App\Http\Livewire;
use App\Models\Category;
use App\Models\Destino;
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
        $this->selected_id=0;
        $this->componentName='crear';
        $this->title='ssss';
      
    }

    public function render()
    {
        if($this->selected_id !== null){

            if($this->selected_id == 'General')
            
              
             $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                                        ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                                        ->select(DB::raw('SUM(productos_destinos.stock) as stock_s'),'p.nombre as name','p.cantidad_minima as cant_min')
                                        ->groupBy('productos_destinos.product_id')
                                      
                                        ->paginate($this->pagination);
            
         else
             $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                                        
            ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                                        
                                        ->select('productos_destinos.*','p.nombre as name','dest.nombre as nombre_destino','p.id as id_prod')
                                    
                                        ->where('dest.id',$this->selected_id)
                                        ->orderBy('p.nombre','desc')
                                        ->paginate($this->pagination);
                                        
        }
            
            else{
               
                $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                
                ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                
                ->select(DB::raw('SUM(productos_destinos.stock) as stock_s'),'p.nombre as name','p.cantidad_minima as cant_min')
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
    

}
