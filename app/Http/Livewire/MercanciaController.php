<?php

namespace App\Http\Livewire;

use App\Models\CompraDetalle;
use App\Models\Destino;
use App\Models\DetalleEntradaProductos;
use App\Models\DetalleOperacion;
use App\Models\DetalleSalidaProductos;
use App\Models\IngresoProductos;
use App\Models\IngresoSalida;
use App\Models\Lote;
use App\Models\Product;
use App\Models\ProductosDestino;
use App\Models\SaleDetail;
use App\Models\SaleLote;
use App\Models\SalidaProductos;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Session\ExistenceAwareInterface;

class MercanciaController extends Component
{

    public  $fecha,$buscarproducto=0,$selected,$searchproduct,$costo,$sm,$concepto,$destino,$tipo_proceso,$col,$destinosucursal,$observacion,$cantidad,$result;

    public function mount(){
        $this->col=collect([]);
        $this->tipo_proceso= "Entrada";

    }
    public function render()
    {
        $op_inv = IngresoSalida::join('detalle_operacions','detalle_operacions.id_operacion','ingreso_salidas.id')
        ->join('destinos','destinos.id','ingreso_salidas.destino')
        ->join('sucursals','sucursals.id','destinos.sucursal_id')
        ->join('users','users.id','ingreso_salidas.user_id')
        ->select('ingreso_salidas.*','detalle_operacions.*','destinos.nombre as destino_nombre','sucursals.name as suc_name','users.name as userop')->get();


       if (strlen($this->searchproduct) > 0) 
       {

         $this->sm = Product::select('products.*')
          ->where('products.nombre','like', '%' . $this->searchproduct . '%')
          ->orWhere('products.codigo', 'like', '%' . $this->searchproduct . '%')
          ->get()->take(3);
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
        $this->selected=$id->id;
        $this->searchproduct=null;
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

    public function deleteItem(){
        $this->result=0;

    }
    
    public function addProduct(Product $id){
        
        $this->col->push(['product_id'=> $id->id,'product-name'=>$id->nombre,'costo'=>$this->costo,'cantidad'=>$this->cantidad]);
        $this->result=null;
        $this->cantidad=null;
        $this->costo=null;
        //dump($this->col);
    }

    public function eliminaritem($id){
 
    $item=null;
    foreach ($this->col as $key => $value) {
   
     if ($value['product_id'] == $id) {
        $item=$key;
        break;
         }
        }
    
      $this->col->pull($item);
     

    }

    public function Traspaso(){

        $auxi= IngresoSalida::where('proceso','Entrada')->get();

        DB::beginTransaction();

        try {
            
        foreach ($auxi as $data) {
            $entrada = IngresoProductos::create([
                'destino' => $data->destino,
                'user_id' => $data->user_id,
                'concepto'=>'ENTRADA',
                'observacion'=>$data->observacion
            ]);

            $newdata=DetalleOperacion::join('ingreso_salidas','ingreso_salidas.id','detalle_operacions.id')->where("ingreso_salidas.id",$data->id)->get();

            foreach ($newdata as $dat) {

                $auxi2= CompraDetalle::where('product_id',$dat->product_id);

                foreach ($auxi2 as $data3) {
                    if ($data3->created_at>$dat->created_at) {
                        $lot= Lote::create([
                            'existencia'=>$auxi2->cantidad,
                            'status'=>'Activo'
                        ]);
                        $data3->update([
                            'lote_compra'=>$lot->id
                        ]);
                        $data3->save();
                    }
                }

              
               $lot= Lote::create([
                    'existencia'=>$dat->cantidad,
                    'status'=>'Activo'
                ]);

                DetalleEntradaProductos::create([

                    'product_id'=>$dat->product_id,
                    'cantidad'=>$dat->cantidad,
                    'id_entrada'=>$entrada->id,
                    'lote_id'=>$lot->id
    
                ]);
            }

        }

        DB::commit();
            } catch (Exception $e) {
        DB::rollback();
        dd($e->getMessage());
        
    }

        //dd($auxi);
    }
        public function TraspasoSalida(){

        $auxi= IngresoSalida::where('proceso','Salida')->get();

        foreach ($auxi as $data) {

            $salida = SalidaProductos::create([
                'destino' => $data->destino,
                'user_id' => $data->user_id,
                'concepto'=>$data->concepto,
                'observacion'=>$data->observacion
            ]);

            $newdata=DetalleOperacion::join('ingreso_salidas','ingreso_salidas.id',$data->id)->get();

            foreach ($newdata as $dat) {
                DetalleSalidaProductos::create([
                    'product_id'=>$dat->product_id,
                    'cantidad'=>$dat->cantidad,
                    'id_salida'=>$salida->id_operacion
                
                ]);
    
            }
        
        }
        //dd($auxi);
    }

    public function Verificar()
    {
        $v1= CompraDetalle::all();

        foreach ($v1 as $data) {
            $v2 = DetalleOperacion::join('ingreso_salidas','ingresos_salidas.id','detalle_operacions.id_operacion')
            ->where('proceso','Entrada')->where('product_id',$data->product_id);
            if ($v2 != null and $data->created_at> $v1->created_at) {
                
            }
        }
    }

    //Primero se creo los lotes iniciales de la primera insercion de productos de 200 unidades

    
    public function CrearLotes()
    {
        $auxi= Product::all();
        $destinos= Destino::all();
        DB::beginTransaction();

        try {

    
            
            // $ingreso= IngresoProductos::create([
            //     'destino' => $data1->id,
            //     'user_id' => 1,
            //     'concepto'=>'INICIAL',
            //     'observacion'=>"inventario inicial no real"
            // ]);

            foreach ($auxi as $data) {

                $lot= Lote::create([
                    'existencia'=>350,
                    'costo'=>$data->costo,
                    'status'=>'Activo',
                    'product_id'=>$data->id
                ]);
                // $vs=DetalleEntradaProductos::create([

                //     'product_id'=>$data->id,
                //     'costo'=> $data->costo,
                //     'cantidad'=>200,
                //     'id_entrada'=>$ingreso->id,
                //     'lote_id'=>$lot->id
                
                // ]);

               
            }
        


        DB::commit();
        }
         catch (Exception $e)
        {
        DB::rollback();
        dd($e->getMessage());
        }

       
    }

    public function Ventas(){


        // $auxi= Product::all();

        // foreach ($auxi as $value) {

        //     //dump($v3);
            
        //     $v3=IngresoSalida::join('detalle_operacions','detalle_operacions.id_operacion','ingreso_salidas.id')->where('proceso','Salida')->where('detalle_operacions.product_id', $value->id)->get();
           
        //     $ent= IngresoSalida::join('detalle_operacions','detalle_operacions.id_operacion','ingreso_salidas.id')->where('detalle_operacions.product_id', $value->id)->get();

        //     $fechainicial= Carbon::parse('2015-01-01')->format('Y-m-d') . ' 00:00:00';
        //     $fecha_final=0;

        //     // foreach ($v3 as $valu) {

        //     //     if () {
                    
        //     //     }  
                
        //     // }

        //     if (count($v3)>0) {
        //         dd($ent);
                
                $v4=SaleDetail::all();

                foreach ($v4 as $data3) {

                    $lot=Lote::where('product_id',$data3->product_id)->where('status','Activo')->get();

                     //obtener la cantidad del detalle de la venta 
                    $qq=$data3->quantity;//q=8

                    foreach ($lot as $val) { //lote1= 3 Lote2=3 Lote3=3
                       
                        if($qq>0){            //true//5//2
                            
                            if ($qq > $val->existencia) {

                                SaleLote::create([
                                    'sale_detail_id'=>$data3->id,
                                    'lote_id'=>$val->id,
                                    'cantidad'=>$val->existencia
                                    
                                ]);
    
                                $val->update([
                                    
                                    'existencia'=>0,
                                    'status'=>'Inactivo'
    
                                ]);
                                $val->save();
                                $qq=$qq-$val->existencia;
                            }
                            else{
                                SaleLote::create([
                                    'sale_id'=>$data3->id,
                                    'lote_id'=>$val->id,
                                    'cantidad'=>$qq
                                ]);
    
                                $val->update([ 
                                    'existencia'=>$val->existencia-$qq
                                ]);
                                $val->save();
                                break;
                            }

                         
                        }
                    }

                  
                }
     
        


    }

    
}
