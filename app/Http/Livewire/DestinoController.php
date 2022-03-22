<?php

namespace App\Http\Livewire;

use App\Models\Location;
use App\Models\ProductosDestino;
use App\Models\Sucursal;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class DestinoController extends Component
{
    use WithPagination;

    public $selected_id,$selected_ubicacion;
    private $pagination = 10;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }


  

    public function render()
    {
        if($this->selected_id !== null && $this->selected_ubicacion !== null )

            $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product-id')
                                        ->join('locations as loc','loc.id','productos_destinos.destino-id')
                                        ->join('sucursals as suc','suc.id','loc.sucursal_id')
                                        ->select('productos_destinos.*','loc.*','p.nombre as name','loc.ubicacion as ubi','suc.name as suc_id','loc.codigo as codigo')
                                        ->where('loc.ubicacion',$this->selected_ubicacion)
                                        ->where('suc.name',$this->selected_id)
                                        ->orderBy('p.nombre','desc')
                                        ->paginate($this->pagination);
        else

            if($this->selected_id == 'General')
            {
                $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product-id')
                                            ->join('locations as loc','loc.id','productos_destinos.destino-id')
                                            ->join('sucursals as suc','suc.id','loc.sucursal_id')
                                            ->select(DB::raw('sum(product-id)'),'productos_destinos.*','loc.*','p.nombre as name','loc.ubicacion as ubi','suc.name as suc_id','loc.codigo as codigo')
                                            ->groupBy('productos_destinos.product-id')
                                          
                                            ->paginate($this->pagination);

            }
            $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product-id')
                                        ->join('locations as loc','loc.id','productos_destinos.destino-id')
                                        ->join('sucursals as suc','suc.id','loc.sucursal_id')
                                        ->select('productos_destinos.*','loc.*','p.nombre as name','loc.ubicacion as ubi','suc.name as suc_id','loc.codigo as codigo')
                                        ->where('loc.ubicacion','ALMACEN')
                                        ->where('suc.id',1)
                                        ->orderBy('p.nombre','desc')
                                        ->paginate($this->pagination);

      
        /*$products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->where('products.name', 'like', '%' . $this->search . '%')
                ->orWhere('products.barcode', 'like', '%' . $this->search . '%')
                ->orWhere('c.name', 'like', '%' . $this->search . '%')
                ->orderBy('products.id', 'desc')
                ->paginate($this->pagination);
        */
            $suc_data=Sucursal::select('sucursals.*')
                                    ->orderBy('sucursals.id','asc');

                                    

        return view('livewire.destino.destino-controller',['destinos_almacen'=>$almacen,'data_suc' => $suc_data->get()])  
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
