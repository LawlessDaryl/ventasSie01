<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class NotificacionController extends Component
{
    
    public function mount()
    {
        //$this->notificaciones= [];

    }
    public function render()
    {
        $notificaciones = User::join("notificacion_usuarios as nu", "nu.user_id", "users.id")
        ->join("notificacions as n", "n.id", "nu.notificacion_id")
        ->where('users.id', Auth()->user()->id)
        ->select('n.id','n.nombrenotificacion as nn','n.mensaje as m','n.estado as estado','n.created_at as fechanoti')
        ->OrderBy('n.created_at','DESC')
        ->get();

        return view('livewire.notificaciones.notificacion', [
            'notificacion' => $notificaciones
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
    public function mostrarnotificacion($idnotificacion)
    {
        
        

        return view('livewire.notificaciones.notificacion')
        ->extends('layouts.theme.app')
        ->section('content');
    }
    
}
