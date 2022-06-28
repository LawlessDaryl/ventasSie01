<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TransaccionesController extends Component


{
    public function mount(){
        
    }


    public function render()
    {
       




        return view('livewire.i_transacciones.component')
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
