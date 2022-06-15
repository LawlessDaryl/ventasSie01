<?php

namespace App\Http\Livewire;

use App\Models\Notification;
use App\Models\Sucursal;
use App\Models\User;
use Livewire\Component;

class NotificationController extends Component
{
    
    public function mount()
    {
        //$this->notificaciones= [];

    }
    public function render()
    {
        $notificaciones = User::join("notification_users as nu", "nu.user_id", "users.id")
        ->join("notifications as n", "n.id", "nu.notification_id")
        ->where('users.id', Auth()->user()->id)
        ->select('n.id as id','n.estado as estado','n.user_id as idusuario','n.sucursal_id as sucursal_id','n.nombrenotificacion as nn','n.mensaje as m','n.estado as estado','n.created_at as fechanoti')
        ->OrderBy('n.created_at','DESC')
        ->get();

        return view('livewire.notificaciones.notification', [
            'notificacion' => $notificaciones
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
    public function mostrarnotificacion($idnotificacion)
    {
        return view('livewire.notificaciones.notification')
        ->extends('layouts.theme.app')
        ->section('content');
    }
    public function buscarusuario($id)
    {
        //Obteniendo el nombre del Usuario
        $nombreusuario = User::select("users.id as id","users.name as nombre","users.profile as rol")
        ->where("users.id", $id)
        ->get()
        ->first();

        return $nombreusuario->nombre;
    }
    public function buscarsucursal($id)
    {
        //Obteniendo el nombre del Usuario
        $nombresucursal = Sucursal::select("sucursals.id as id","sucursals.name as nombre", "sucursals.adress as direccion")
        ->get()
        ->first();

        return $nombresucursal->direccion;
    }
    public function quitarnovisto($id)
    {
        //dd("Hola");
        $notificacion = Notification::find($id);
        $notificacion->update([
            'estado' => "VISTO",
        ]);
        $notificacion->save();
    }
    
}
