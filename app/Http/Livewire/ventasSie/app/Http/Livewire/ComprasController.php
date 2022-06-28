<?php

namespace App\Http\Livewire;

use App\Models\Compra;
use App\Models\ProductosDestino;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ComprasController extends Component
{
    use WithPagination;
    use WithFileUploads;
    private $pagination = 5;
    public $fromDate,$toDate,
            $from,
            $to,
            $filtro,
            $criterio,
           $total_compras,
            $nro,
            $fecha,
            $search,
            $datas_compras,
            $totales,
            $aprobado;

  public function paginationView()
     {
            return 'vendor.livewire.bootstrap';
     }
  public function mount(){
        $this->nro=1;
        $this->filtro='Contado';
        $this->fecha='hoy';
    }
    public function render()
    {
        $this->consultar();
        $this->datas_compras= Compra::join('providers as prov','compras.proveedor_id','prov.id')
        ->join('users','users.id','compras.user_id')
        ->select('compras.*','compras.id as compra_id','compras.status as status_compra','prov.nombre_prov as nombre_prov','users.name')
        ->whereBetween('compras.created_at',[$this->from,$this->to])
        ->where('compras.transaccion',$this->filtro)
        ->orderBy('compras.fecha_compra')
        ->get();

        $this->totales = $this->datas_compras->sum('importe_total');

        if (strlen($this->search) > 0){
            $this->datas_compras = Compra::join('movimiento_compras as mov_compra','compras.id','mov_compra.id')
            ->join('movimientos as mov','mov_compra.id','mov.id')
            ->join('users','mov.user_id','users.id')
            ->join('providers as prov','compras.proveedor_id','prov.id')
            ->select('compras.*','compras.status as status_compra','mov.*','prov.nombre_prov as nombre_prov','users.name')
            ->whereBetween('compras.created_at',[$this->from,$this->to])
            ->where('compras.transaccion',$this->filtro)
            ->where('nombre_prov', 'like', '%' . $this->search . '%')
            ->orWhere('users.name', 'like', '%' . $this->search . '%')
            ->orWhere('compras.id', 'like', '%' . $this->search . '%')
            ->orWhere('compras.created_at', 'like', '%' . $this->search . '%')
            ->orWhere('compras.status', 'like', '%' . $this->search . '%')
            ->get();
            $this->totales = $this->datas_compras->sum('importe_total');
        }
        return view('livewire.compras.component',['data_compras'=>$this->datas_compras, 'totales'=>$this->totales])
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
            $this->to = Carbon::parse(Carbon::now())->format('Y-m-d')     . ' 23:59:59';

        }

        else{

            $this->from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
            $this->to = Carbon::parse($this->toDate)->format('Y-m-d')     . ' 23:59:59';
        }
  
    }

    protected $listeners = ['deleteRow' => 'Destroy','editarcompras'=>'editarCompra'];

    public function editarCompra($id)
    {
        session(['id_compra' => null]);
        session(['id_compra' => $id]);
        return redirect()->route('editcompra');
    }
    public function Destroy(Compra $compra_edit)
    {
        
        foreach ($compra_edit->compradetalle as $data) {
            
           $mm= ProductosDestino::where('destino_id',$compra_edit->destino_id)
            ->where('product_id',$data->product_id)
            ->select('productos_destinos.*')
            ->value('stock');            

            if ($mm >= $data->cantidad) 
            {
                $this->aprobado=true;
            }
            else{
                $this->aprobado=false;
            }
   
        }
       
        if ($this->aprobado == true) {
            foreach ($compra_edit->compradetalle as $data) {
                ProductosDestino::where('destino_id',$compra_edit->destino_id)
                ->where('product_id',$data->product_id)
                ->decrement('stock',$data->cantidad);
    
            }
            $compra_edit->delete();
            $this->emit('purchase-deleted', 'Compra eliminada');
        }

        else{
            $this->emit('purchase-error', 'No puede eliminar la compra, Uno o varios de los productos acaban de ser distribuidos.');
        }

       
    
    }
  
}
