<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MercanciaController extends Component
{

    public  $fecha;

    public function render()
    {
        return view('livewire.entradas_salidas.mercancia-controller')->extends('layouts.theme.app')
        ->section('content');;
    }
}
