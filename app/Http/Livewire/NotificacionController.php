<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NotificacionController extends Component
{
    public function render()
    {

        



        return view('livewire.notificaciones.notificacion')
        ->extends('layouts.theme.app')
        ->section('content');
            
    }
}
