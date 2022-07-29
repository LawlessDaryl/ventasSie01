<?php

namespace App\Http\Livewire;

use App\Models\Destino;
use App\Models\IngresoSalida;
use App\Models\Product;
use App\Models\ProductosDestino;
use Livewire\Component;
use Carbon\Carbon;

class MercanciaController extends Component
{

    public  $fecha,$buscarproducto=0,$searchproduct,$sm,$concepto,$destino,$tipo_proceso,$col,$destinosucursal,$observacion,$cantidad,$result;

    public function mount(){
        $this->col=collect();


    }

    public function render()
    {

        $op_inv= IngresoSalida::join('detalle_operacions','detalle_operacions.id_operacion','ingreso_salidas.id')
        ->join('destinos','destinos.id','ingreso_salidas.destino')
        ->join('sucursals','sucursals.id','destinos.sucursal_id')
        ->join('users','users.id','ingreso_salidas.user_id')
        ->select('ingreso_salidas.*','detalle_operacions.*','destinos.nombre as destino_nombre','sucursals.name as suc_name','users.name as userop')->get();


       if (strlen($this->searchproduct) > 0) 
       {
         $this->sm = Product::select('products.*')
          ->where('products.nombre','like', '%' . $this->searchproduct . '%')
          ->orWhere('products.codigo', 'like', '%' . $this->searchproduct . '%')
          ->get();
          $this->buscarproducto=1;
       }
       else{
        $this->buscarproducto=0;
       }



       $destinosuc= Destino::join('sucursals as suc','suc.id','destinos.sucursal_id')
       ->select ('suc.name as sucursal','destinos.nombre as destino','destinos.id as destino_id')
       ->get();

        return view('livewire.entradas_salidas.mercancia-controller',['operaciones'=>$op_inv,'destinosp'=>$destinosuc])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Seleccionar(Product $id){
       
        $this->result= $id->nombre;
        $this->buscarproducto=0;
        // $this->emit('product-added');
    }
    
    public function Incrementar(){
        
        $items= Product::whereBetween('products.created_at',[ Carbon::parse('2022-06-29')->format('Y-m-d') . ' 00:00:00',Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])->get();
        
        $destinos=Destino::all();
       
        foreach ($destinos as $data) {
            foreach ($items as $prod) {
                
                ProductosDestino::updateOrCreate(['product_id' => $prod->id, 'destino_id'=>$data->id],['stock'=>50]);
            }
        }
        
    }
    
    public function addProduct(Product $id){
        
        $this->col->add($id);
    }
}
