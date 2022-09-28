<?php

namespace App\Http\Livewire;

use App\Models\ServiceRepDetalleSolicitud;
use App\Models\ServiceRepSolicitud;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SolicitudRepuestos extends Component
{
    public $asd;
    public function render()
    {

        $lista_solicitudes = ServiceRepDetalleSolicitud::select("service_rep_detalle_solicituds.*",DB::raw('0 as minutos'))
        ->orderBy("service_rep_detalle_solicituds.created_at", "desc")
        ->get();


        foreach($lista_solicitudes as $l)
        {
            $l->minutos = $this->solicitudreciente($l->id);
        }


        return view('livewire.solicitudrepuestos.component', [
            'lista_solicitudes' => $lista_solicitudes,
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }


    //Devuelve el tiempo en minutos de una Solicitud Reciente
    public function solicitudreciente($idsolicitud)
    {
        //Variable donde se guardaran los minutos de diferencia entre el tiempo de la solicitud y el tiempo actual
        $minutos = -1;
        //Guardando el tiempo en la cual se realizo la solicitud
        $date = Carbon::parse(ServiceRepDetalleSolicitud::find($idsolicitud)->created_at)->format('Y-m-d');
        //Comparando que el dia-mes-año de la solicitud sean iguales al tiempo actual
        if($date == Carbon::parse(Carbon::now())->format('Y-m-d'))
        {
            //Obteniendo la hora en la que se realizo la solicitud
            $hora = Carbon::parse(ServiceRepDetalleSolicitud::find($idsolicitud)->created_at)->format('H');
            //Obteniendo la hora de la solicitud mas 1 para incluir horas diferentes entre una hora solicitud y la hora actual en el else
            $hora_mas = $hora + 1;
            //Si la hora de la solicitud coincide con la hora actual
            if($hora == Carbon::parse(Carbon::now())->format('H'))
            {
                //Obtenemmos el minuto de la solicitud
                $minutos_solicitud = Carbon::parse(ServiceRepDetalleSolicitud::find($idsolicitud)->created_at)->format('i');
                //Obtenemos el minuto actual
                $minutos_actual = Carbon::parse(Carbon::now())->format('i');
                //Calculamos la diferencia
                $diferenca = $minutos_actual - $minutos_solicitud;
                //Actualizamos la variable $minutos por los minutos de diferencia si la solicitud fue hace 1 hora antes que la hora actual
                if($diferenca <= 60)
                {
                    $minutos = $diferenca;
                }
            }
            else
            {
                //Ejemplo: Si la hora de la solicitud es 14:59 y la hora actual es 15:01
                //Usamos la variable $hora_mas para comparar con la hora actual, esto para obtener solo a las solicituds que sean una hora antes que la hora actual
                if($hora_mas == Carbon::parse(Carbon::now())->format('H'))
                {
                    //Obtenemmos el minuto de la solicitud con una hora antes que la hora actual
                    $minutos_solicitud = Carbon::parse(ServiceRepDetalleSolicitud::find($idsolicitud)->created_at)->format('i');
                    //Obtenemos el minuto actual
                    $minutos_actual = Carbon::parse(Carbon::now())->format('i');
                    //Restamos el minuto de la solicitud con el minuto actual y despues le restamos 60 minutos por la hora antes añadida ($hora_mas)
                    $mv = (($minutos_solicitud - $minutos_actual) - 60) * -1;
                    //Actualizamos la variable $minutos por los minutos de diferencia si la solicitud fue hace 1 hora antes que la hora actual
                    if($mv <= 60)
                    {
                        $minutos = $mv;
                    }
                }
            }
        }

        
        return $minutos;
    }
}
