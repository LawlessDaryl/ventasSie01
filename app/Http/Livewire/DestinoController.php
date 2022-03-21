<?php

namespace App\Http\Livewire;

use App\Models\Location;
use App\Models\ProductosDestino;
use Livewire\Component;
use Livewire\WithPagination;

class DestinoController extends Component
{
    use WithPagination;
    private $pagination = 10;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function render()
    {
        
        $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product-id')
                                    ->join('locations as loc','loc.id','productos_destinos.destino-id')
                                    ->join('sucursals as suc','suc.id','loc.sucursal_id')
                                    ->select('productos_destinos.*','p.nombre as name','loc.ubicacion','suc.id')
                                    ->where('loc.ubicacion','ALMACEN')
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
        
                                    $tienda=ProductosDestino::join('products as p','p.id','productos_destinos.product-id')
                                    ->join('locations as loc','loc.id','productos_destinos.destino-id')
                                    ->select('productos_destinos.*','p.nombre as name','loc.ubicacion','loc.sucursal_id')
                                    ->where('loc.ubicacion','TIENDA')
                                    ->orderBy('p.nombre','desc')
                                    ->paginate($this->pagination);

        return view('livewire.destino.destino-controller',['destinos_almacen'=>$almacen, 'destinos_tienda'=>$tienda])  
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
