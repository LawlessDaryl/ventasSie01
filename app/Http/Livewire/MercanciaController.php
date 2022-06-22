<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class MercanciaController extends Component
{

    public  $fecha,$buscarproducto=0,$searchproduct,$sm,$concepto,$destino,$tipo_proceso,$col;

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

    public function Seleccionar($id){
        $this->col->push($id);
    }
}
