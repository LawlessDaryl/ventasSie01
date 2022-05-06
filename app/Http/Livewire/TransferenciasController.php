<?php

namespace App\Http\Livewire;

use App\Models\Destino;
use App\Models\DetalleTransferencia;
use App\Models\Transference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TransferenciasController extends Component
{
    public $nro,$nro_det,$detalle,$estado,$vs=[];
    public function mount(){
        $this->nro=1;
        $this->nro_det=1;
        $this->verPermisos();
       
    }
    public function render()
    {
        $data= Transference::join('estado_transferencias','transferences.id','estado_transferencias.id_transferencia')
        ->join('users','estado_transferencias.id_usuario','users.id')
        ->join('destinos as origen','origen.id','transferences.id_origen')
        ->join('sucursals as suc_origen','suc_origen.id','origen.sucursal_id')
        ->join('destinos as destino1','destino1.id','transferences.id_destino')
        ->join('sucursals as suc_destino','suc_destino.id','destino1.sucursal_id')
        ->select('transferences.created_at as fecha_tr','transferences.id as t_id',
        'users.*','suc_origen.name as origen_name',
        'suc_destino.name as destino_name','estado_transferencias.estado as estado_tr',
        'origen.nombre as origen','destino1.nombre as dst')
        ->where('estado_transferencias.op','Activo')
        ->whereIn('origen.id',$this->vs)
        
        ->get();
       /* $data= Transference::join('estado_transferencias','transferences.id','estado_transferencias.id_transferencia')
        ->join('users','estado_transferencias.id_usuario','users.id')
        ->join('destinos as origen','origen.id','transferences.id_origen')
        ->join('sucursals as suc_origen','suc_origen.id','origen.sucursal_id')
        ->join('destinos as destino1','destino1.id','transferences.id_destino')
        ->join('sucursals as suc_destino','suc_destino.id','destino1.sucursal_id')
        ->select('transferences.created_at as fecha_tr','transferences.id as t_id',
        'users.*','suc_origen.name as origen_name',
        'suc_destino.name as destino_name','estado_transferencias.estado as estado_tr',
        'origen.nombre as origen','destino1.nombre as dst')
        ->where('estado_transferencias.op','Activo')
        ->whereIn('.id',$this->vs)
        
        ->get();*/

        return view('livewire.destino_producto.verTransferencias',['data_t'=>$data,'data_m'=>$this->detalle,'data_estado'=>$this->estado])
        ->extends('layouts.theme.app')
        ->section('content');
        
    }

    public function visualizar($id)
    {
        $this->detalle=DetalleTransferencia::join('products','detalle_transferencias.product_id','products.id')
        ->join('estado_trans_detalles','detalle_transferencias.id','estado_trans_detalles.detalle_id')
        ->join('estado_transferencias','estado_trans_detalles.estado_id','estado_transferencias.id')
        ->join('transferences','estado_transferencias.id_transferencia','transferences.id')
        ->select('detalle_transferencias.*','products.nombre as prod_name')
        ->where('transferences.id',$id)->get();

        $this->estado= Transference::join('estado_transferencias','transferences.id','estado_transferencias.id_transferencia')
        ->select('estado_transferencias.estado')->value('estado_transferencias.estado');
        
    }
    public function verPermisos(){
       
        $ss= Destino::select('destinos.id','destinos.nombre')->get();
        $arr=[];
        foreach ($ss as $item) {
            $arr[$item->nombre.'_'.$item->id]=($item->id);
        }

       foreach ($arr as $key => $value) {
        if (Auth::user()->hasPermissionTo($key)) {
            array_push($this->vs,$value);
        }
       }

    }

    public function verificarStock(){
        
    }
}
