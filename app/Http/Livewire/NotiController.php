<?php

namespace App\Http\Livewire;

use App\Models\Notificacion;
use App\Models\User;
use DateTime;
use Livewire\Component;

class NotiController extends Component
{
    public $NotificacionIco, $noti, $tiempo, $year, $meses, $dias, $hora, $minutos;
    public function render()
    {
        //Verificando si el usuario Tiene Notificaciones Vistas
        $this->noti = User::join("notificacion_usuarios as nu", "nu.user_id", "users.id")
        ->join("notificacions as n", "n.id", "nu.notificacion_id")
        ->where('n.estado', 'NOVISTO')
        ->where('users.id', Auth()->user()->id)
        ->select('n.nombrenotificacion as nn','n.mensaje as m')
        ->get()
        ->first();
        //Misma consulta que arriba pero sin el $this-> para mostrar icono de notificacion nueva
        $notificacionesvistas = User::join("notificacion_usuarios as nu", "nu.user_id", "users.id")
        ->join("notificacions as n", "n.id", "nu.notificacion_id")
        ->where('n.estado', 'NOVISTO')
        ->where('users.id', Auth()->user()->id)
        ->select('n.nombrenotificacion as nn','n.mensaje as m')
        ->get();

        if ($notificacionesvistas->count() > 0)
        {
            $this->NotificacionIco = 1;
             //Consulta para sacar el tiempo: Fecha y Hora de la Notificacion
            $sacartiempo = User::join("notificacion_usuarios as nu", "nu.user_id", "users.id")
            ->join("notificacions as n", "n.id", "nu.notificacion_id")
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
