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
        $this->ros=1;
        
    
    }


    public function render()
    {
       

        
        $data= Transference::join('users','transferences.id_usuario','users.id')
        ->select('transferences.*','transferences.id as t_id','transferences.status as st','users.*')->get(); 

        return view('livewire.destino_producto.verTransferencias',['data_t'=>$data,'data_m'=>$this->detalle])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function visualizar($id){


        $this->detalle=DetalleTransferencia::join('products','detalle_transferencias.product_id','products.id')
        ->join('destinos','detalle_transferencias.id_destino','destinos.id')
        ->select('detalle_transferencias.*','products.nombre as prod_name','destinos.nombre as dest_name')
        ->where('detalle_transferencias.id_transference',$id)->get();

        $this->ros=2;
        
    }


}
