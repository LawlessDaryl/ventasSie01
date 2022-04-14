<?php

namespace App\Http\Livewire;

use App\Models\Compra;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
class ComprasController extends Component
{
    use WithPagination;
    use WithFileUploads;
    private $pagination = 5;
    public $fromDate,
            $toDate,
            $filtro,
            $criterio,
           $total_compras,
            $nro,
            $fecha,
            $search,
            $datas_compras;

  public function paginationView()
     {
                return 'vendor.livewire.bootstrap';
     }

    public function mount(){
        $this->nro=1;
        $this->filtro='Contado';
        
        
    }


    public function render()
    {
        
        $this->consultar();
       

        $this->datas_compras= Compra::join('movimiento_compras as mov_compra','compras.id','mov_compra.id')
        ->join('movimientos as mov','mov_compra.id','mov.id')
        ->join('users','mov.user_id','users.id')
        ->join('providers as prov','compras.proveedor_id','prov.id')
        ->select('compras.*','compras.status as status_compra','mov.*','prov.nombre as nombre_prov','users.name')
        ->whereBetween('compras.created_at',[$this->from,$this->to])
        ->where('compras.transaccion',$this->filtro)
        ->orderBy('compras.fecha_compra')
        ->get();

        $totales = $this->datas_compras->sum('importe_total');


        if (strlen($this->search) > 0){
            $this->datas_compras = Compra::join('movimiento_compras as mov_compra','compras.id','mov_compra.id')
            ->join('movimientos as mov','mov_compra.id','mov.id')
            ->join('users','mov.user_id','users.id')
            ->join('providers as prov','compras.proveedor_id','prov.id')
            ->select('compras.*','compras.status as status_compra','mov.*','prov.nombre as nombre_prov','users.name')
            ->where('compras.transaccion',$this->filtro)
            ->where('nombre', 'like', '%' . $this->search . '%')
            ->orWhere('users.name', 'like', '%' . $this->search . '%')
            ->orWhere('compras.created_at', 'like', '%' . $this->search . '%')
            ->orWhere('compras.id', 'like', '%' . $this->search . '%')
            ->orWhere('compras.status', 'like', '%' . $this->search . '%')
            ->get();

          

            $totales = $this->datas_compras->sum('importe_total');


        }

        return view('livewire.compras.component',['data_compras'=>$this->datas_compras, 'totales'=>$totales])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function consultar()
    {
        if ($this->fecha == 'hoy') {

            $this->fromDate = Carbon::now();
            $this->toDate = Carbon::now();
            $this->from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
            $this->to = Carbon::parse($this->toDate)->format('Y-m-d')     . ' 23:59:59';
        }
        if ($this->fecha == 'ayer') {

            $this->fromDate = Carbon::yesterday();
            $this->toDate = Carbon::yesterday();
            $this->from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
            $this->to = Carbon::parse($this->toDate)->format('Y-m-d')     . ' 23:59:59';
        }
        if ($this->fecha == 'semana') 
        {

            $this->toDate = Carbon::now();
            $this->fromDate = $this->toDate->subWeeks(1);
            $this->from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
            $this->to = Carbon::parse($this->toDate)->format('Y-m-d')     . ' 23:59:59';

        }

        else{

            $this->from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
            $this->to = Carbon::parse($this->toDate)->format('Y-m-d')     . ' 23:59:59';
        }
  
    }

    public function print()
    {
    
        $usuario = Auth()->user()->id;
        $data= $this->datas_compras;
     
        $pdf = PDF::loadView('livewire.pdf.ImprimirOrden', compact('data', 'usuario'));
        /* $pdf->setPaper("A4", "landscape"); //orientacion y tamaño */

        //no se q hace esta linea
        return $pdf->stream('OrdenTrSe.pdf');  //visualizar
        /* return $pdf->download('ordenServicio.pdf');  //descargar  */
    }
}
