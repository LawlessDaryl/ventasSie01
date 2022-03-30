<?php

namespace App\Http\Livewire;

use App\Models\Notificacion;
use App\Models\User;
use Livewire\Component;

class NotiController extends Component
{
    public $NotificacionIco, $noti;
    public function render()
    {
        //Verificando si Tiene Notificaciones Vistas
        $this->noti = User::join("notificacion_usuarios as nu", "nu.user_id", "users.id")
        ->join("notificacions as n", "n.id", "nu.notificacion_id")
        ->where('n.estado', 'NOVISTO')
        ->where('users.id', Auth()->user()->id)
        ->select('n.nombrenotificacion as nn','n.mensaje as m')
        ->get()
        ->first();

        $notificacionesvistas = User::join("notificacion_usuarios as nu", "nu.user_id", "users.id")
        ->join("notificacions as n", "n.id", "nu.notificacion_id")
        ->where('n.estado', 'NOVISTO')
        ->where('users.id', Auth()->user()->id)
        ->select('n.nombrenotificacion as nn','n.mensaje as m')
        ->get();

        if ($notificacionesvistas->count() > 0)
        {
            $this->NotificacionIco = 1;
        }
        else
        {
            $this->NotificacionIco = 0;
        }
        
        return view('livewire.notificaciones.noti');
    }
}
