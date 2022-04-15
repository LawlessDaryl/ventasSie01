<?php

namespace App\Http\Controllers;

use App\Models\OrderService;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Service;
use App\Models\User;

class ImprimirController extends Controller
{
    public function print($idServicio)
    {
        /* DATOS MOVIMIENTO CLIENTE SERVICIO Y DEMAS */
        $data = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
            ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
            ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
            ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
            ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
            ->join('cat_prod_services as cps', 'services.cat_prod_service_id', 'cps.id')
            ->select(
                'services.*',
                'mov.type as tipo',
                'mov.import as import',
                'mov.saldo as saldo',
                'mov.type as type',
                'mov.on_account as on_account',
                'mov.user_id as usuarioid',
                'cat.nombre as category',
                'c.nombre as nombreC',
                'c.celular as celular',
                'c.telefono as telefono',
                'cps.nombre as nombreCateg'
            )
            ->where('services.order_service_id',  $idServicio)
            ->where('mov.status', 'ACTIVO')
            ->get();

        /* DATOS ORDEN DE SERVICIO */
        $datos = OrderService::find($idServicio);
        
        
        $usuario = User::find(Auth()->user()->id);
        foreach($usuario->sucursalusers as $su){
            if($su->estado == 'ACTIVO'){
                $sucursal=$su->sucursal;
            }
        }
        
        $pdf = PDF::loadView('livewire.pdf.ImprimirOrden', compact('data', 'datos', 'usuario','sucursal'));
        /* $pdf->setPaper("A4", "landscape"); //orientacion y tamaño */

        return $pdf->stream('OrdenTrServicio.pdf');  //visualizar
        /* return $pdf->download('ordenServicio.pdf');  //descargar  */
    }
}
