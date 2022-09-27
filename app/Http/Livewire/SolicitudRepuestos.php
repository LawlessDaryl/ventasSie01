<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SolicitudRepuestos extends Component
{
    public function render()
    {

        
        return view('livewire.solicitudrepuestos.component')
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
