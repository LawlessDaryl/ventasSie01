<?php

namespace App\Http\Livewire;

use App\Models\Location;
use Livewire\Component;

class DestinoController extends Component
{
    public function render()
    {
        
        $almacen= Location::all();



        return view('livewire.destino.destino-controller',['destinos_almacen'=>$almacen])  
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
