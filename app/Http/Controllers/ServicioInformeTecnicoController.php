<?php

namespace App\Http\Controllers;

use App\Models\OrderService;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Service;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;

class ServicioInformeTecnicoController extends Controller
{
    public function print($idservicio)
    {
        /* Código Orden de Servicio */
        $codigo = Service::find($idservicio)->order_service_id;

        //Fecha de cuando se recepcionó el servicio
        $fecharecepcion = OrderService::find($codigo)->created_at;

        //variable para guardar todos los datos de un servicio
        $datos_servicio = Service::find($idservicio);

        //Variable para guardar el nombre del Técnico Responsable de un Servicio
        $responsable_tecnico = $this->obtener_tecnico_responsable($idservicio);

        //variable para guardar datos extra de un servicio
        $detalles_extra =  Service::join('order_services as os', 'os.id', 'services.order_service_id')
        ->join('mov_services as ms', 'services.id', 'ms.service_id')
        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
        ->join('users as u', 'u.id', 'mov.user_id')
        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
        ->join('clientes as c', 'c.id', 'cm.cliente_id')
        ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
        ->join('type_works as tw', 'tw.id', 'services.type_work_id')
        ->select('cps.nombre as nombrecategoria',
        'services.detalle as detalle',
        'mov.type as estado',
        'c.nombre as nombrecliente',
        'mov.on_account as acuenta',
        'mov.saldo as saldo',
        'c.celular as celularcliente',
        'services.falla_segun_cliente as falla_segun_cliente',
        'services.fecha_estimada_entrega as fecha_estimada_entrega',
        'services.detalle as detalleservicio',
        'services.costo as costo',
        'services.diagnostico as diagnostico',
        'services.solucion as solucion',
        'services.detalle_costo as detallecosto',
        'mov.import as precioservicio',
        'tw.name as tipotrabajo',
        'u.name as responsabletecnico',
        'services.marca as marca')
        ->where('mov.status', 'ACTIVO')
        ->where('services.id', $idservicio)
        ->get()
        ->first();

        $dia_mes_actual = Carbon::parse(Carbon::now())->format('d M Y');
        $year = Carbon::parse(Carbon::now())->format('Y');

        $nombreempresa = Company::find(1)->name;
        $logoempresa = Company::find(1)->image;
        $direccionempresa = Company::find(1)->adress;


        
        $pdf = PDF::loadView('livewire.pdf.InformeTecnico', compact('datos_servicio','detalles_extra', 'direccionempresa' ,'year','logoempresa','nombreempresa' , 'codigo','fecharecepcion','responsable_tecnico','dia_mes_actual'));
        /* $pdf->setPaper("A4", "landscape"); //orientacion y tamaño */

        return $pdf->stream('InformeTecnico.pdf');  //visualizar
        /* return $pdf->download('ordenServicio.pdf');  //descargar  */
    }
    //Obtener Técnico Responsable a travéz del id de un servicio
    public function obtener_tecnico_responsable($idservicio)
    {
        $servicio = Service::find($idservicio);
        foreach ($servicio->movservices as $servmov)
        {
            if($servmov->movs->type == 'PENDIENTE' && $servmov->movs->status == 'ACTIVO')
            {
                return "No Asignado";
            }
            else
            {

                if ($servmov->movs->type == 'PROCESO'  && $servmov->movs->status == 'ACTIVO')
                {
                    return User::find($servmov->movs->user_id)->name;
                    break;
                }
                else
                {
                    if ($servmov->movs->type == 'TERMINADO' && $servmov->movs->status == 'ACTIVO')
                    {
                        return User::find($servmov->movs->user_id)->name;
                        break;
                    }
                    else
                    {
                        if($servmov->movs->type == 'ENTREGADO'&& $servmov->movs->status == 'ACTIVO')
                        {
                            foreach ($servicio->movservices as $servmov)
                            {
                                if($servmov->movs->type == 'TERMINADO' && $servmov->movs->status == 'INACTIVO')
                                {
                                    return User::find($servmov->movs->user_id)->name;
                                    break;
                                }
                            }   
                        }
                    }
                }
            }
        }
    }
}
