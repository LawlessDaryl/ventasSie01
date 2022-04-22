<?php

namespace App\Http\Livewire;

use App\Models\DetalleTransferencia;
use App\Models\Transference;

use Livewire\Component;

class TransferenciasController extends Component
{
    public $nro,$detalle,$ros;
    public function mount(){
        $this->nro=1;
       
    }
    public function render()
    {
        $data= Transference::join('estado_transferencias','transferences.id','estado_transferencias.id_transferencia')
        ->join('users','estado_transferencias.id_usuario','users.id')
        ->join('destinos','transferences.id_destino','destinos.id')
        ->select('transferences.created_at as fecha_tr','transferences.id as t_id','users.*',
        'estado_transferencias.estado as estado_tr','destinos.nombre as dest_nom')
        ->where('transferences.estado','Activo')
        ->get(); 
        
        return view('livewire.destino_producto.verTransferencias',['data_t'=>$data,'data_m'=>$this->detalle])
        ->extends('layouts.theme.app')
        ->section('content');
        
    }

    public function visualizar($id){

        

        $this->detalle=DetalleTransferencia::join('products','detalle_transferencias.product_id','products.id')
        ->join('destinos','detalle_transferencias.id_destino','destinos.id')
        ->join('transferencia_detalles as t_d','detalle_transferencias.id','t_d.id_detalle')
        ->join('transferences','t_d.id_transferencia','transferences.id')
        ->select('detalle_transferencias.*','products.nombre as prod_name','destinos.nombre as dest_name')
        ->where('transferences.id',$id)->get();



        
    }


}
