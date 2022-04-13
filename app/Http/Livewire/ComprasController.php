<?php

namespace App\Http\Livewire;

use App\Models\Compra;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
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
            $nro;

  public function paginationView()
     {
                return 'vendor.livewire.bootstrap';
     }

    public function mount(){
        $this->nro=1;
        $this->filtro='tipo_doc';
        $this->criterio = '45464';
        
    }


    public function render()
    {
        
        $this->consultar();
        $totales = Compra::whereBetween('compras.created_at',[$this->from,$this->to])
        ->where('compras.'.$this->filtro,$this->criterio)
        ->orderBy('compras.fecha_compra')
        ->sum('compras.importe_total');
        

        $datas_compras= Compra::join('movimiento_compras as mov_compra','compras.id','mov_compra.id')
        ->join('movimientos as mov','mov_compra.id','mov.id')
        ->join('users','mov.user_id','users.id')
        ->join('providers as prov','compras.proveedor_id','prov.id')
        ->select('compras.*','compras.status as status_compra','mov.*','prov.nombre as nombre_prov','users.name')
        ->whereBetween('compras.created_at',[$this->from,$this->to])
        ->where('compras.'.$this->filtro,$this->criterio)
        ->orderBy('compras.fecha_compra')
        ->get();


        return view('livewire.compras.component',['data_compras'=>$datas_compras, 'totales'=>$totales])
        ->extends('layouts.theme.app')
        ->section('content');
    }
    public function consultar()
    {

        $this->from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
        $this->to = Carbon::parse($this->toDate)->format('Y-m-d')     . ' 23:59:59';
  
    }
}
