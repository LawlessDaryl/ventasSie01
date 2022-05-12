<?php

namespace App\Http\Livewire;

use App\Models\Notification;
use App\Models\User;
use DateTime;
use Livewire\Component;

class NotiController extends Component
{
    public $NotificacionIco,$notif, $tiempo, $year, $meses, $dias, $hora, $minutos;
    public function render()
    {
        $this->notif = [];
        //Verificando si el usuario Tiene Notificaciones Vistas para cargarlas a la vista Notificaciones
        $this->notif = User::join("notification_users as nu", "nu.user_id", "users.id")
        ->join("notifications as n", "n.id", "nu.notification_id")
        ->where('n.estado', 'NOVISTO')
        ->where('users.id', Auth()->user()->id)
        ->select('n.id','n.nombrenotificacion as nn','n.mensaje as m','n.estado as estado','n.created_at as fechanoti')
        ->OrderBy('n.created_at','DESC')
        ->get();



        //Misma consulta que arriba pero sin el $this-> para mostrar icono de notificacion nueva
        $notificacionesvistas = User::join("notification_users as nu", "nu.user_id", "users.id")
        ->join("notifications as n", "n.id", "nu.notification_id")
        ->where('n.estado', 'NOVISTO')
        ->where('users.id', Auth()->user()->id)
        ->select('n.nombrenotificacion as nn','n.mensaje as m')
        ->get();

        if ($notificacionesvistas->count() > 0)
        {
            $this->NotificacionIco = 1;
             //Consulta para sacar el tiempo: Fecha y Hora de la Notificacion
            $sacartiempo = User::join("notification_users as nu", "nu.user_id", "users.id")
            ->join("notifications as n", "n.id", "nu.notification_id")
            ->where('n.estado', 'NOVISTO')
            ->where('users.id', Auth()->user()->id)
            ->select('n.nombrenotificacion as nn','n.mensaje as m','n.created_at as tiempo')
            ->get()
            ->first();
            //Obteniendo el tiempo en el que se crea la notificación
            $fechahoranotificacion = $sacartiempo->tiempo;
            //Obteniendo la fecha actual
            $fechahoraactual = date("Y-m-d H:i:s");

            //$fechanotimasunasemana = date("d-m-Y",strtotime($fechahoranotificacion."+ 1 week"));
            //$p = date("d-m-Y",strtotime($fechahoranotificacion."+ 1 week"));


            $fechanotificacion = $this->convertFecha($fechahoranotificacion);
            $fechaactual = $this->convertFecha($fechahoraactual);
            $diff = $fechanotificacion->diff($fechaactual);

            $this->hora=$diff->h;
            $this->minutos=$diff->i;
            $this->dias=$diff->d;
            $this->meses=$diff->m;
            $this->year=$diff->y;

        }
        else
        {
            $this->NotificacionIco = 0;
        }
        
        return view('livewire.notificaciones.noti');
    }
    public function diferenciarfecha($fecha)
    {
        $fechahoraactual = date("Y-m-d H:i:s");
        $fechahoraactualconvertido = $this->convertFecha($fechahoraactual);
        $fechahoraconvertido = $this->convertFecha($fecha);
        return $fechahoraconvertido->diff($fechahoraactualconvertido);
    }
    //Para Convertir las fechas a formato comparable
    public function convertFecha($fecha)
    {
        $year = substr($fecha, 0, 4);
        $mes = substr($fecha, -14, -12);
        $dia = substr($fecha, -11, -9);
        $hora = substr($fecha, -8, -6);
        $minuto = substr($fecha, -5, -3);
        return new DateTime("$year-$mes-$dia $hora:$minuto");
    }
}
