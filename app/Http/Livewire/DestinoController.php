<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DestinoController extends Component
{
    public function render()
    {
        
        return view('livewire.destino.destino-controller')  
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
