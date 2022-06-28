<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\CompraDetalle;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;


class ExportComprasController extends Controller
{
    public $nro,$totales,$data;
    
    public function reporteComprasPdf($filtro,$fecha, $dateFrom , $dateTo,$search=null)
    {
        $this->nro=1;
        $nro=$this->nro;
       
        $totales=$this->totales;

        if (strlen($search) > 0){

            $this->data = Compra::join('movimiento_compras as mov_compra','compras.id','mov_compra.id')
                                ->join('movimientos as mov','mov_compra.id','mov.id')
                                ->join('users','mov.user_id','users.id')
                                ->join('providers as prov','compras.proveedor_id','prov.id')
                                ->select('compras.*','compras.id as compras_id','mov.*','prov.nombre_prov as nombre_prov','users.name')
                                ->where('compras.transaccion',$filtro)
                                ->where('nombre', 'like', '%' . $search . '%')
                                ->orWhere('users.name', 'like', '%' . $search . '%')
                                ->orWhere('compras.id', 'like', '%' . $search . '%')
                                ->orWhere('compras.created_at', 'like', '%' . $search . '%')
                                ->orWhere('compras.status', 'like', '%' . $search . '%')
                                ->get();
            $this->totales = $this->data->sum('importe_total');

        }
        else{
            $this->data= Compra::join('movimiento_compras as mov_compra','compras.id','mov_compra.id')
                                ->join('movimientos as mov','mov_compra.id','mov.id')
                                ->join('users','mov.user_id','users.id')
                                ->join('providers as prov','compras.proveedor_id','prov.id')
                                ->select('compras.*','compras.status as status_compra','mov.*','prov.nombre_prov as nombre_prov','users.name')
                                ->whereBetween('compras.created_at',[$dateFrom,$dateTo])
                                ->where('compras.transaccion',$filtro)
                                ->orderBy('compras.fecha_compra')
                                ->get();

        $this->totales = $this->data->sum('importe_total');
        }

        $data=$this->data;
      
       $nro= $this->nro;
       $totales=$this->totales;

        $pdf = PDF::loadView('livewire.pdf.reporteCompras', compact('data', 'filtro', 'fecha','dateFrom', 'dateTo', 'dateTo','nro','totales'));

        return $pdf->stream('ComprasReport.pdf');  //visualizar
        /* return $pdf->download('salesReport.pdf');  //descargar  */
    }

    public function PrintCompraPdf($id){
            $data= Compra::join('providers as prov','compras.proveedor_id','prov.id')->select('compras.*','compras.id as compra_id','prov.*')->where('compras.id',$id)->first();
            $detalle=CompraDetalle::join('products as prod','compra_detalles.product_id','prod.id')->select('compra_detalles.*','prod.*')->where('compra_id',$id)->get();
            $nro= $this->nro+1;
   
            $pdf = PDF::loadView('livewire.pdf.ImprimirCompra',compact('data','detalle','nro'));

            return $pdf->stream('CompraDetalle.pdf');  //visualizar
            /* return $pdf->download('salesReport.pdf');  //descargar  */
    }

}
