<?php

namespace App\Http\Livewire;

use App\Models\Notificacion;
use App\Models\User;
use Livewire\Component;

class NotiController extends Component
{
    public $NotificacionIco;
    public function render()
    {
        //Verificando si Tiene Notificaciones
        $noti = User::join("notificacion_usuarios as nu", "nu.user_id", "users.id")
        ->join("notificacion as n", "n.id", "nu.notificacion_id")
        ->where('users.id', Auth()->user()->id)
        ->get()
        ->first();
        if ($noti->count() > 0)
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
