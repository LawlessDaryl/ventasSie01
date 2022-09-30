<?php

namespace App\Http\Livewire;

use App\Models\Cartera;
use App\Models\ServiceRepDetalleSolicitud;
use App\Models\ServiceRepSolicitud;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SolicitudRepuestosController extends Component
{
    public $asd;
    public function render()
    {

        $lista_solicitudes = ServiceRepSolicitud::join("users as u","u.id","service_rep_solicituds.user_id")
        ->select("service_rep_solicituds.*",
        DB::raw('0 as minutos'),
        DB::raw('0 as detalles'),
        "service_rep_solicituds.order_service_id as codigo",
        "u.name as nombresolicitante", "service_rep_solicituds.created_at as created_at")
        ->orderBy("service_rep_solicituds.created_at", "desc")
        ->get();


        foreach($lista_solicitudes as $l)
        {
            $l->minutos = $this->solicitudreciente($l->id);
            $l->detalles = $this->obtenerdetalles($l->id);
        }

        $lista_usuarios = User::select("users.*")
        ->where("users.status","ACTIVE")
        ->get();

        $lista_carteras = Cartera::join("cajas as c","c.id", "carteras.caja_id")
        ->select("carteras.id as carteraid","carteras.nombre as nombrecartera")
        ->where("c.sucursal_id", $this->idsucursal())
        ->get();



        return view('livewire.solicitudrepuestos.component', [
            'lista_solicitudes' => $lista_solicitudes,
            'lista_usuarios' => $lista_usuarios,
            'lista_carteras' => $lista_carteras
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
    //Obtener el Id de la Sucursal donde esta el Usuario
    public function idsucursal()
    {
        $idsucursal = User::join("sucursal_users as su","su.user_id","users.id")
        ->select("su.sucursal_id as id","users.name as n")
        ->where("users.id",Auth()->user()->id)
        ->where("su.estado","ACTIVO")
        ->get()
        ->first();
        return $idsucursal->id;
    }

    //Devuelve los detalles de una solicitud
    public function obtenerdetalles($idsolicitud)
    {
        $detalles = ServiceRepDetalleSolicitud::join("service_rep_solicituds as srs","srs.id","service_rep_detalle_solicituds.solicitud_id")
        ->join("products as p","p.id","service_rep_detalle_solicituds.product_id")
        ->join("service_rep_estado_solicituds as e","e.detalle_solicitud_id","service_rep_detalle_solicituds.id")
        ->join("destinos as d","d.id","service_rep_detalle_solicituds.destino_id")
        ->select("service_rep_detalle_solicituds.id as iddetalle","p.nombre as nombreproducto","p.costo as costoproducto","service_rep_detalle_solicituds.cantidad as cantidad"
        ,"service_rep_detalle_solicituds.tipo as tipo","e.status as status", "d.nombre as nombredestino")
        ->where("srs.id", $idsolicitud)
        ->get();
        return $detalles;
    }
    //Cambia el estado PENDIENTE del detalle de una sulicitad
    public function cambiarpendiente($iddetalle)
    {
        $this->emit("Confirmar-Aceptar");
    }

    public function generarcompra($idsolicitud)
    {
        $this->emit("modalcomprarepuesto-show");
    }




    //Devuelve el tiempo en minutos de una Solicitud Reciente
    public function solicitudreciente($idsolicitud)
    {
        //Variable donde se guardaran los minutos de diferencia entre el tiempo de la solicitud y el tiempo actual
        $minutos = -1;
        //Guardando el tiempo en la cual se realizo la solicitud
        $date = Carbon::parse(ServiceRepSolicitud::find($idsolicitud)->created_at)->format('Y-m-d');
        //Comparando que el dia-mes-año de la solicitud sean iguales al tiempo actual
        if($date == Carbon::parse(Carbon::now())->format('Y-m-d'))
        {
            //Obteniendo la hora en la que se realizo la solicitud
            $hora = Carbon::parse(ServiceRepSolicitud::find($idsolicitud)->created_at)->format('H');
            //Obteniendo la hora de la solicitud mas 1 para incluir horas diferentes entre una hora solicitud y la hora actual en el else
            $hora_mas = $hora + 1;
            //Si la hora de la solicitud coincide con la hora actual
            if($hora == Carbon::parse(Carbon::now())->format('H'))
            {
                //Obtenemmos el minuto de la solicitud
                $minutos_solicitud = Carbon::parse(ServiceRepSolicitud::find($idsolicitud)->created_at)->format('i');
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
                    $minutos_solicitud = Carbon::parse(ServiceRepSolicitud::find($idsolicitud)->created_at)->format('i');
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
