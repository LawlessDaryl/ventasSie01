<?php

namespace App\Http\Livewire;

use App\Models\Destino;
use App\Models\Product;
use App\Models\ProductosDestino;
use Livewire\Component;

class MercanciaController extends Component
{

    public  $fecha,$buscarproducto=0,$searchproduct,$sm,$concepto,$destino,$tipo_proceso,$col;

    public function mount(){
        $this->col=collect();
    }

    public function render()
    {

       if (strlen($this->searchproduct) > 0) 
       {
         $this->sm = Product::select('products.*')
          ->where('products.nombre','like', '%' . $this->searchproduct . '%')
          ->orWhere('products.codigo', 'like', '%' . $this->searchproduct . '%')
          ->get();
          $this->buscarproducto=1;
       }
       else{
        $this->buscarproducto=0;
       }

        return view('livewire.entradas_salidas.mercancia-controller')
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Seleccionar(Product $id){
       
        $this->col->add($id);
        $this->searchproduct= $id->nombre;
        $this->emit('product-added');
        

    }

    public function Incrementar(){

        $items= Product::all();

        $destinos=Destino::all();
       
        foreach ($destinos as $data) {
            foreach ($items as $prod) {
                
                ProductosDestino::updateOrCreate(['product_id' => $prod->id, 'destino_id'=>$data->id],['stock'=>200]);
            }
        }


       
      
        

    }
}
