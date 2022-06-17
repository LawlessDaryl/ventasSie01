<?php

namespace App\Http\Livewire;

use App\Models\Destino;
use App\Models\DetalleTransferencia;
use App\Models\EstadoTransDetalle;
use App\Models\EstadoTransferencia;
use App\Models\ProductosDestino;
use App\Models\Transference;
use Carbon\Carbon;
use Darryldecode\Cart\Facades\EditarTransferenciaFacade;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Session;
use Darryldecode\Cart\Facades\EditarTransferenciaFacade as EditarTransferencia;

class TransferenciasController extends Component
{
    public $nro,$nro_det,$detalle,$estado,$estado_destino,$vs=[], $datalist_destino,$selected_id1,$class1,$class,$selected_id2,$data_origen,$estado_lista_tr,$estado_lista_te,$show1,$show2;
    public function mount(){
        $this->nro=1;
        $this->nro_det=1;
        $this->verPermisos();
        $this->estado_lista_tr='active';
        $this->estado_lista_te='';
        $this->show1='show';
        $this->show2='';

    }
    public function render()
    {
       
        $data_or= Transference::join('estado_transferencias','transferences.id','estado_transferencias.id_transferencia')
        ->join('users','estado_transferencias.id_usuario','users.id')
        ->join('destinos as origen','origen.id','transferences.id_origen')
        ->join('sucursals as suc_origen','suc_origen.id','origen.sucursal_id')
        ->join('destinos as destino1','destino1.id','transferences.id_destino')
        ->join('sucursals as suc_destino','suc_destino.id','destino1.sucursal_id')
        ->select('transferences.created_at as fecha_tr','transferences.id as t_id',
        'users.*','suc_origen.name as origen_name','origen.id as orih',
        'suc_destino.name as destino_name','estado_transferencias.estado as estado_tr','estado_transferencias.op',
        'origen.nombre as origen','destino1.nombre as dst')
        ->whereIn('origen.id',$this->vs)
        ->OrWhereIn('destino1.id',$this->vs)
        ->orderBy('fecha_tr','desc')
        ->get();
        $this->data_origen= $data_or->where('op','Activo');
        

        $data_destino= Transference::join('estado_transferencias','transferences.id','estado_transferencias.id_transferencia')
        ->join('users','estado_transferencias.id_usuario','users.id')
        ->join('destinos as origen','origen.id','transferences.id_origen')
        ->join('sucursals as suc_origen','suc_origen.id','origen.sucursal_id')
        ->join('destinos as destino2','destino2.id','transferences.id_destino')
        ->join('sucursals as suc_destino','suc_destino.id','destino2.sucursal_id')
        ->select('transferences.created_at as fecha_tr','transferences.id as tr_des_id',
        'users.*','suc_origen.name as origen_name',
        'suc_destino.name as destino_name','estado_transferencias.estado as estado_te',
        'origen.nombre as origen','destino2.nombre as dst2')
        ->where('estado_transferencias.op','Activo')
        ->where('estado_transferencias.estado','En Transito')
        ->whereIn('destino2.id',$this->vs)
        ->orderBy('fecha_tr','desc')
        ->get();

        return view('livewire.destinoproducto.verTransferencias',['data_t'=>$this->data_origen,'data_estado'=>$this->estado, 'data_d'=>$data_destino
       ])
        ->extends('layouts.theme.app')
        ->section('content');
        
    }
    public function ver($id)
    {
       
        $this->selected_id1= $id;
        $this->detalle=DetalleTransferencia::join('products','detalle_transferencias.product_id','products.id')
        ->join('estado_trans_detalles','detalle_transferencias.id','estado_trans_detalles.detalle_id')
        ->join('estado_transferencias','estado_trans_detalles.estado_id','estado_transferencias.id')
        ->join('transferences','estado_transferencias.id_transferencia','transferences.id')
        ->select('detalle_transferencias.*','transferences.id as tr')
        ->where('transferences.id',$id)
        ->where('estado_transferencias.op','Activo')
        ->get();
        $this->estado= Transference::join('estado_transferencias','transferences.id','estado_transferencias.id_transferencia')
        ->select('estado_transferencias.estado')->value('estado_transferencias.estado');
        //dd($this->detalle);

        $this->emit('show1');
        
        
    }
    public function visualizardestino($id2)
    {
        
        $this->selected_id2= $id2;
        
        $this->datalist_destino=DetalleTransferencia::join('products','detalle_transferencias.product_id','products.id')
        ->join('estado_trans_detalles','detalle_transferencias.id','estado_trans_detalles.detalle_id')
        ->join('estado_transferencias','estado_trans_detalles.estado_id','estado_transferencias.id')
        ->join('transferences','estado_transferencias.id_transferencia','transferences.id')
        ->select('detalle_transferencias.*','transferences.id as tr','estado_transferencias.estado as esty')
        ->where('transferences.id',$id2)
        ->where('estado_transferencias.op','Activo')
        ->get();
        
      
        $this->estado_destino= Transference::join('estado_transferencias','transferences.id','estado_transferencias.id_transferencia')
        ->where('estado_transferencias.op','Activo')
        ->where('transferences.id',$id2)
        ->select('estado_transferencias.estado')->value('estado_transferencias.estado');
        $this->emit('show2');
        
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
    protected $listeners = ['editRow' => 'editar'];
    public function editar($id)
    {
        session(['id_transferencia' => null]);
        session(['id_transferencia' => $id]);
        return redirect()->route('editdest');
    }

    public function ingresarProductos()
    {
        $rm=Transference::where('transferences.id',$this->selected_id2)->value('id_destino');
       DB::beginTransaction();
            try {
                foreach ($this->datalist_destino as $value)
                {
                  
                    $q=ProductosDestino::where('product_id',$value->product_id)
                    ->where('destino_id',$rm)->value('stock');
                    
                    //$dd=ProductosDestino::where('product_id',$value->product_id)
                    //->where('destino_id',$rm)->value('stock');
                    
                    ProductosDestino::updateOrCreate(['product_id' => $value->product_id, 'destino_id'=>$rm],['stock'=>$q+$value->cantidad]);
                    //ProductosDestino::updateOrCreate(['product_id' => $value->product_id, 'destino_id'=>$rm],['stock'=>($dd - $value->cantidad)]);
                }
               

                

          EstadoTransferencia::where('id_transferencia',$this->selected_id2)->update(['op'=>'Inactivo']);
       
          $aux=EstadoTransferencia::create([
                 'estado'=>'Recibido',
                 'op'=>1,
                 'id_transferencia'=>$this->selected_id2,
                 'id_usuario'=>Auth()->user()->id
             ]);


             foreach ($this->datalist_destino as $values) 
             {
                EstadoTransDetalle::create([
                    'estado_id'=> $aux->id,
                    'detalle_id'=>$values->id,
                  
                ]);
             }
            } 
            catch (Exception $e) {
                DB::rollback();
                dd($e->getMessage());
                
            }
        DB::commit();

        $this->emit('close2');
        $tr=$this->selected_id2;
        $this->reset('selected_id2','datalist_destino','estado_destino');
        session(['id_transf' =>$tr]);
        return redirect()->route('transferencia.pdf');
       

    }

    public function rechazarTransferencia(){
        $rm=Transference::where('transferences.id',$this->selected_id2)->value('id_origen');
        DB::beginTransaction();
        try {
            foreach ($this->datalist_destino as $value)
            {
              
                $q=ProductosDestino::where('product_id',$value->product_id)
                ->where('destino_id',$rm)->value('stock');
                ProductosDestino::updateOrCreate(['product_id' => $value->product_id, 'destino_id'=>$rm],['stock'=>$q+$value->cantidad]);
              
            }

      EstadoTransferencia::where('id_transferencia',$this->selected_id2)->update(['op'=>'Inactivo']);
   
      $aux=EstadoTransferencia::create([
             'estado'=>'Rechazado',
             'op'=>1,
             'id_transferencia'=>$this->selected_id2,
             'id_usuario'=>Auth()->user()->id
         ]);


         foreach ($this->datalist_destino as $values) 
         {
            EstadoTransDetalle::create([
                'estado_id'=> $aux->id,
                'detalle_id'=>$values->id,
              
            ]);
         }
        } 
        catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            
        }
    DB::commit();

    $this->emit('close2');

    }

    public function imprimir($id){
        
        session(['id_transf' =>$id]);

        return redirect()->route('transferencia.pdf');
    } 
}
