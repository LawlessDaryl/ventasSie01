<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Cliente;
use App\Models\DetalleTransferencia;
use App\Models\EstadoTransferencia;
use App\Models\Sucursal;
use App\Models\Transference;
use Maatwebsite\Excel\Facades\Excel;


class ExportTransferenciaController extends Controller
{
    public function printPdf()
    {
     
        $ide=session('id_transf');
        $origen=Transference::join('destinos','destinos.id','transferences.id_origen')->where('transferences.id',$ide)->value('nombre');
        $destino=Transference::join('destinos','destinos.id','transferences.id_destino')->where('transferences.id',$ide)->value('nombre');
        $userrecepcion=EstadoTransferencia::join('users','users.id','estado_transferencias.id_usuario')->where('estado_transferencias.id_transferencia',$ide)
       ->where('estado_transferencias.op','Activo')
       ->select('users.name')->value('users.name');
    
        $fecha=EstadoTransferencia::where('estado_transferencias.id_transferencia',$ide)
        ->where('estado_transferencias.op','Activo')
        ->select('created_at')->value('created_at');
        
        $datalist_destino=DetalleTransferencia::join('products','detalle_transferencias.product_id','products.id')
        ->join('estado_trans_detalles','detalle_transferencias.id','estado_trans_detalles.detalle_id')
        ->join('estado_transferencias','estado_trans_detalles.estado_id','estado_transferencias.id')
        ->join('transferences','estado_transferencias.id_transferencia','transferences.id')
        ->select('detalle_transferencias.*','transferences.id as tr','estado_transferencias.estado as esty')
        ->where('transferences.id',$ide)
        ->where('estado_transferencias.op','Activo')
        ->get();
       
      
        $pdf = PDF::loadView('livewire.pdf.ImprimirTransferencia', compact('ide','origen','destino','userrecepcion','fecha','datalist_destino'));

        return $pdf->stream('transferencia.pdf');  
    }
}
