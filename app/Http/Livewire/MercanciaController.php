<?php

namespace App\Http\Livewire;

use App\Imports\StockImport;
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
use App\Models\SalidaLote;
use App\Models\SalidaProductos;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Session\ExistenceAwareInterface;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class MercanciaController extends Component
{

    use WithPagination;
    use WithFileUploads;
    public  $fecha,$buscarproducto=0,$selected,$registro,$tipo_de_operacion,
    $archivo,$searchproduct,$costo,$sm,$concepto,$destino,$detalle,$tipo_proceso,$col,$destinosucursal,$observacion,$cantidad,$result,$arr,$ing_prod_id,$destino_delete;
    private $pagination = 50;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount(){
        $this->col=collect([]);
        $this->tipo_proceso= "Elegir";
        $this->registro='Manual';
    
        $this->destino = 'Elegir';
        $this->concepto ="Elegir";
        $this->tipo_de_operacion="Entrada";
        //$this->CrearLotes();
       //$this->Ventas();
        //$this->buscarl();
        //$this->buscarproducto();
       // $this->borrarLotes();
       //$this->ajustarLotes();
       //$this->productosajustados();
   //$this->limpiarstock();
 // $this->buscarproducto();
   // $this->inactivarlotes();

    }
    public function render()
    {
        
        if ($this->tipo_de_operacion == "Entrada") {
            
            $ingprod= IngresoProductos::with(['detalleingreso'])->orderBy('ingreso_productos.created_at','desc')->paginate($this->pagination);
        }
        else{

            $ingprod=SalidaProductos::with(['detallesalida'])->orderBy('salida_productos.created_at','desc')->paginate($this->pagination);
        }

        //dd($ingprod);

       if (strlen($this->searchproduct) > 0) 
       {

         $st = Product::select('products.*')
          ->where('products.nombre','like', '%' . $this->searchproduct . '%')
          ->orWhere('products.codigo', 'like', '%' . $this->searchproduct . '%')
          ->get()->take(3);

          $arr= $this->col->pluck('product-name');
          $this->sm=$st->whereNotIn('nombre',$arr);
          //dd($this->sm);

          $this->buscarproducto=1;
          
       }
       else{

        $this->buscarproducto=0;

       }

       $destinosuc= Destino::join('sucursals as suc','suc.id','destinos.sucursal_id')
       ->select ('suc.name as sucursal','destinos.nombre as destino','destinos.id as destino_id')
       ->get();

        return view('livewire.entradas_salidas.mercancia-controller',['destinosp'=>$destinosuc,'ingprod'=>$ingprod])
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
        
        
        if ($this->tipo_proceso != 'Salida') {
            
            $rules = [
                'result' => 'required',
                'costo' => 'required',
                'cantidad' => 'required',
                'destino'=>'required'
            ];
            
            $messages = [
                'costo.required' => 'El costo es requerido',
                'result.required'=>'El producto es requerido',
                'cantidad.required' => 'La cantidad es requerida',
                'destino.required'=>'Elija una ubicacion de la salida del producto.'
            ];
            
            $this->validate($rules, $messages);
            
            $this->col->push(['product_id'=> $id->id,'product-name'=>$id->nombre,'costo'=>$this->costo,'cantidad'=>$this->cantidad]);
    
            $this->result=null;
            $this->cantidad=null;
            $this->costo=null;
            //dump($this->col);

        }
        else{

            $pd=ProductosDestino::where('product_id',$id->id)->where('destino_id',$this->destino)->select('stock')->value('stock');

          if ($pd>0 and $this->cantidad < $pd) {
        
            $rules = [
                'result' => 'required',
                'cantidad' => 'required'
            ];
            
            $messages = [
              
                'result.required'=>'El producto es requerido',
                'cantidad.required' => 'La cantidad es requerida'
            ];
            
            $this->validate($rules, $messages);
            
            $this->col->push(['product_id'=> $id->id,'product-name'=>$id->nombre,'cantidad'=>$this->cantidad]);
    
            $this->result=null;
            $this->cantidad=null;
            $this->costo=null;
          }
          else{
            $this->emit('stock-insuficiente');
          }
            //dump($this->col);
        }

     
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

    // public function Traspaso(){

    //     $auxi= IngresoSalida::where('proceso','Entrada')->get();

    //     DB::beginTransaction();

    //     try {
            
    //     foreach ($auxi as $data) {
    //         $entrada = IngresoProductos::create([
    //             'destino' => $data->destino,
    //             'user_id' => $data->user_id,
    //             'concepto'=>'ENTRADA',
    //             'observacion'=>$data->observacion
    //         ]);

    //         $newdata=DetalleOperacion::join('ingreso_salidas','ingreso_salidas.id','detalle_operacions.id')->where("ingreso_salidas.id",$data->id)->get();

    //         foreach ($newdata as $dat) {

    //             $auxi2= CompraDetalle::where('product_id',$dat->product_id);

    //             foreach ($auxi2 as $data3) {
    //                 if ($data3->created_at>$dat->created_at) {
    //                     $lot= Lote::create([
    //                         'existencia'=>$auxi2->cantidad,
    //                         'status'=>'Activo'
    //                     ]);
    //                     $data3->update([
    //                         'lote_compra'=>$lot->id
    //                     ]);
    //                     $data3->save();
    //                 }
    //             }

              
    //            $lot= Lote::create([
    //                 'existencia'=>$dat->cantidad,
    //                 'status'=>'Activo'
    //             ]);

    //             DetalleEntradaProductos::create([

    //                 'product_id'=>$dat->product_id,
    //                 'cantidad'=>$dat->cantidad,
    //                 'id_entrada'=>$entrada->id,
    //                 'lote_id'=>$lot->id
    
    //             ]);
    //         }

    //     }

    //     DB::commit();
    //         } catch (Exception $e) {
    //     DB::rollback();
    //     dd($e->getMessage());
        
    // }

    //     dd($auxi);
    // }
    //     public function TraspasoSalida(){

    //     $auxi= IngresoSalida::where('proceso','Salida')->get();

    //     foreach ($auxi as $data) {

    //         $salida = SalidaProductos::create([
    //             'destino' => $data->destino,
    //             'user_id' => $data->user_id,
    //             'concepto'=>$data->concepto,
    //             'observacion'=>$data->observacion
    //         ]);

    //         $newdata=DetalleOperacion::join('ingreso_salidas','ingreso_salidas.id',$data->id)->get();

    //         foreach ($newdata as $dat) {
    //             DetalleSalidaProductos::create([
    //                 'product_id'=>$dat->product_id,
    //                 'cantidad'=>$dat->cantidad,
    //                 'id_salida'=>$salida->id_operacion
                
    //             ]);
    
    //         }
        
    //     }
    //     //dd($auxi);
    // }

    // public function Verificar()
    // {
    //     $v1= CompraDetalle::all();

    //     foreach ($v1 as $data) {
    //         $v2 = DetalleOperacion::join('ingreso_salidas','ingresos_salidas.id','detalle_operacions.id_operacion')
    //         ->where('proceso','Entrada')->where('product_id',$data->product_id);
    //         if ($v2 != null and $data->created_at> $v1->created_at) {
                
    //         }
    //     }
    // }

    public function CrearLotes()
    {
        $auxi= Product::all();
        $destinos= Destino::all();
        DB::beginTransaction();

        try {
            $v3=SaleDetail::join('products','products.id','sale_details.product_id')
            ->groupBy('sale_details.product_id')
            ->selectRaw('sum(quantity) as sum, sale_details.product_id,products.costo')->get();    

            foreach ($v3 as $data) {

                $stockActual=ProductosDestino::join('products','products.id','productos_destinos.product_id')
                ->where('productos_destinos.product_id',$data->product_id)->sum('stock');  
 
                   $rs=IngresoProductos::create([
                    'destino'=>1,
                    'user_id'=>1,
                    'concepto'=>'INICIAL',
                    'observacion'=> 'Inventario inicial'
                   ]);

                   $lot= Lote::create([
                    'existencia'=>$data->sum + $stockActual,
                    'costo'=>$data->costo,
                    'status'=>'Activo',
                    'product_id'=>$data->product_id
                ]);

                   DetalleEntradaProductos::create([
                        'product_id'=>$data->product_id,
                        'cantidad'=>$data->sum+$stockActual,
                        'costo'=>$data->costo,
                        'id_entrada'=>$rs->id,
                        'lote_id'=>$lot->id
                   ]);


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

        DB::beginTransaction();

        try {
                $v4=SaleDetail::all();

                foreach ($v4 as $data3) {

                    $lot=Lote::where('product_id',$data3->product_id)->where('status','Activo')->get();

                    //obtener la cantidad del detalle de la venta
                    $this->qq=$data3->quantity;//q=8
                    foreach ($lot as $val) { //lote1= 3 Lote2=3 Lote3=3
                      $this->lotecantidad = $val->existencia;
                      //dd($this->lotecantidad);
                       if($this->qq>0){
                        //true//5//2
                           //dd($val);
                           if ($this->qq > $this->lotecantidad) {
        
                               $ss=SaleLote::create([
                                   'sale_detail_id'=>$data3->id,
                                   'lote_id'=>$val->id,
                                   'cantidad'=>$val->existencia
                               ]);
                               $val->update([
                                   
                                   'existencia'=>0,
                                   'status'=>'Inactivo'
                                   
                                ]);
                                $val->save();
                                $this->qq=$this->qq-$this->lotecantidad;
                                //dump("dam",$this->qq);
                           }
                           else{
                            //dd($this->lotecantidad);
                               $dd=SaleLote::create([
                                   'sale_detail_id'=>$data3->id,
                                   'lote_id'=>$val->id,
                                   'cantidad'=>$this->qq
                               ]);
                             
        
                               $val->update([ 
                                   'existencia'=>$this->lotecantidad-$this->qq
                               ]);
                               $val->save();
                               $this->qq=0;
                               //dd("yumi",$this->qq);
                           }
                       }
                   }
                }
     
                DB::commit();
            }
             catch (Exception $e)
            {
            DB::rollback();
            dd($e->getMessage());
            }
    }

    public function buscarProducto()
    {


        $ini= ProductosDestino::groupBy('productos_destinos.product_id')
        ->selectRaw('sum(stock) as sum,productos_destinos.product_id')->get();
        
        //dd($ini);


        //obtengo la cantidad total de todos los productos que se ingresaron despues del ajuste a cada sucursal

        $v3=IngresoSalida::join('detalle_operacions','detalle_operacions.id_operacion','ingreso_salidas.id')->join('products', 'products.id','detalle_operacions.product_id')
        ->where('proceso','Entrada')->groupBy('detalle_operacions.product_id')->selectRaw('sum(cantidad) as sum, detalle_operacions.product_id,products.costo')->get();
    
/*
EXISTEN PRODUCTOS QUE HAN INGRESADO POR AJUSTE DE INVENTARIOS O INVENTARIO INICIAL O POR COMPRAS QUE NO HAN TENIDO NI UNA VENTA
1. Un producto puede haber no tenido ni una venta en ningun destino, solo ingreso de inventarios
2. Un producto puede haberse vendido en algun destino o en todos los destinos 

*/
        

        // $object = $ini->filter(function($item)
        // {
        //     $auxi= SaleDetail::where('product_id',$item->product_id)->first();
        //   if ($auxi and $auxi->product_id == $item->product_id ) 
        //   { }
        //   else{
        //     return $item;
        //   }
        // })->values();




        //dd($object);
               foreach ($ini as $data3) {

                $compracosto= CompraDetalle::where('product_id',$data3->product_id)->latest('created_at')->value('precio');
                //dd($compracosto);
                $costoproducto=Product::where('id',$data3->product_id)->value('costo');

                DB::beginTransaction();
                try {


                    $rs=IngresoProductos::create([
                        'destino'=>1,
                        'user_id'=>1,
                        'concepto'=>'INICIAL',
                        'observacion'=> 'Inventario inicial'
                       ]);
    
                       $lot= Lote::create([
                        'existencia'=>$data3->sum,
                        'costo'=> $compracosto != null ? $compracosto : $costoproducto,
                        'status'=>'Activo',
                        'product_id'=>$data3->product_id
                    ]);
    
                       DetalleEntradaProductos::create([
                            'product_id'=>$data3->product_id,
                            'cantidad'=>$data3->sum,
                            'costo'=>$compracosto != null ? $compracosto : $costoproducto,
                            'id_entrada'=>$rs->id,
                            'lote_id'=>$lot->id
                       ]);
    



                      
                DB::commit();
                }
                 catch (Exception $e)
                {
                DB::rollback();
                dd($e->getMessage());
                }
               }// dd($object);
    }
    public function ajustarLotes()
    {
        $ss=ProductosDestino::groupBy('productos_destinos.product_id')->selectRaw('sum(stock) as sum, productos_destinos.product_id')->get();
        foreach ($ss as $val8) 
        {
            $fg= Lote::where('product_id',$val8->product_id)->where('status','Activo')->get();

            foreach ($fg as $daf) 
            {             
                    $daf->update([
                    'existencia'=> $val8->sum
                ]);
                $daf->save();
            }
        }
    }
    // public function productosajustados(){

    //     $v9=IngresoSalida::join('detalle_operacions','detalle_operacions.id_operacion','ingreso_salidas.id')
    //     ->where('concepto','AJUSTE')
    //     ->groupBy('detalle_operacions.product_id')
    //     ->selectRaw('sum(cantidad) as sum, detalle_operacions.product_id')
    //     ->take(5)
    //     ->get();
    //     $mm= ProductosDestino::all();
        
    //     foreach ($mm as $dam) {
            
    //         $finded= $v9->where('product_id',$dam->product_id);
    //         //dd($finded);
    //         if ($finded != null) {
    //             //dd("null");
    //             $dam->update([
    //             'stock'=>0
    //             ]);
    //         }
    //     }
    // }

    public function limpiarstock(){

        $fut= ProductosDestino::all();

        foreach ($fut as $vals) {
           //dump(count($gj));
           if ($vals->created_at == $vals->updated_at) {
                $vals->update(['stock'=>0]);
           }
        }
    }

    public function inactivarlotes()
    {
        $up= Lote::where('existencia',0)->get();
        foreach ($up as $data2) {
            $data2->update([
                'status'=>'Inactivo'
            ]);
        }
    }
    
    public function import($archivo){
        
        //$file = $request->file('import_file');
       // dd($this->archivo);

       try {
        //$import->import('import-users.xlsx');
       // Excel::import(new StockImport,$this->archivo);
        return redirect()->route('productos');
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
         $this->failures = $e->failures();
        // dd($this->failures);
        //  foreach ($failures as $failure) {
        //      dd($failure->attribute()); // row that went wrong
        //      $failure->attribute(); // either heading key (if using heading row concern) or column index
        //      $failure->errors(); // Actual error messages from Laravel validator
        //      $failure->values(); // The values of the row that has failed.
        //  }
    }


     
       //dd($errors->all());
    }

    public function GuardarOperacion(){
            //dd($this->col);
            if ($this->concepto === "INICIAL" && $this->registro === "Documento") {
             
                try {
                    //$import->import('import-users.xlsx');
                    Excel::import(new StockImport($this->destino,$this->concepto,$this->observacion),$this->archivo);
                    return redirect()->route('productos');
                } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

                     $this->failures = $e->failures();
                     dump($this->failures);
                   
                }
            }
            $rules = [
                'destino' => 'required|not_in:Elegir',
                'observacion' => 'required',
                'concepto' => 'required|not_in:Elegir'
            ];
    
            $messages = [
                'destino.required'=> 'El destino del producto es requerido',
                'concepto.required'=> 'El concepto es un dato requerido',
                'destino.not_in' => 'Elija una ubicacion del producto.',
                'concepto.not_in' => 'Elija un concepto diferente.',
                'observacion.required' => 'Agregue una observacion',
            ];
    
            $this->validate($rules, $messages);
            
            if ($this->tipo_proceso == 'Entrada') {
                    DB::beginTransaction();
                    try {
                    
                    $rs=IngresoProductos::create([
                        'destino'=>$this->destino,
                        'user_id'=>Auth()->user()->id,
                        'concepto'=>$this->concepto,
                        'observacion'=>$this->observacion
                       ]);
                    foreach ($this->col as $datas) {
                       
        
                                       $lot= Lote::create([
                                        'existencia'=>$datas['cantidad'],
                                        'costo'=>$datas['costo'],
                                        'status'=>'Activo',
                                        'product_id'=>$datas['product_id']
                                    ]);
                    
                                       DetalleEntradaProductos::create([
                                            'product_id'=>$datas['product_id'],
                                            'cantidad'=>$datas['cantidad'],
                                            'costo'=>$datas['costo'],
                                            'id_entrada'=>$rs->id,
                                            'lote_id'=>$lot->id
                                       ]);
        
                                       $q=ProductosDestino::where('product_id',$datas['product_id'])
                            ->where('destino_id',$this->destino)->value('stock');
        
                            ProductosDestino::updateOrCreate(['product_id' => $datas['product_id'], 'destino_id'=>$this->destino],['stock'=>$q+$datas['cantidad']]); 
                        
                    
                    }

                    DB::commit();
                }
                 catch (Exception $e)
                {
                DB::rollback();
                dd($e->getMessage());

                }
                    


                }
                else{
                    
                    try {
        
        
                        $operacion= SalidaProductos::create([
            
                            'destino'=>$this->destino,
                            'user_id'=> Auth()->user()->id,
                            'concepto'=>$this->concepto,
                            'observacion'=>$this->observacion]);
                            // dd($auxi2->pluck('stock')[0]);

                    foreach ($this->col as $datas) {

                        $auxi=DetalleSalidaProductos::create([
                        'product_id'=>$datas['product_id'],
                        'cantidad'=> $datas['cantidad'],
                        'id_salida'=>$operacion->id
                    ]);


                    $lot=Lote::where('product_id',$datas['product_id'])->where('status','Activo')->get();

                    //obtener la cantidad del detalle de la venta 
                    $this->qq=$datas['cantidad'];//q=8
                    foreach ($lot as $val) { //lote1= 3 Lote2=3 Lote3=3
                      $this->lotecantidad = $val->existencia;
                      //dd($this->lotecantidad);
                       if($this->qq>0){
                        //true//5//2
                           //dd($val);
                           if ($this->qq > $this->lotecantidad) {
                               $ss=SalidaLote::create([
                                   'salida_detalle_id'=>$auxi->id,
                                   'lote_id'=>$val->id,
                                   'cantidad'=>$val->existencia
                                   
                               ]);
                               $val->update([
                                   
                                   'existencia'=>0,
                                   'status'=>'Inactivo'
                                   
                                ]);
                                $val->save();
                                $this->qq=$this->qq-$this->lotecantidad;
                                //dump("dam",$this->qq);
                           }
                           else{
                            //dd($this->lotecantidad);
                            $ss=SalidaLote::create([
                               'salida_detalle_id'=>$auxi->id,
                               'lote_id'=>$val->id,
                               'cantidad'=>$this->qq
                               
                           ]);
                             
           
                               $val->update([ 
                                   'existencia'=>$this->lotecantidad-$this->qq
                               ]);
                               $val->save();
                               $this->qq=0;
                               //dd("yumi",$this->qq);
                           }
                       }
           
           
                
                         }

                         
                         $q=ProductosDestino::where('product_id',$datas['product_id'])
                         ->where('destino_id',$this->destino)->value('stock');
     
                         ProductosDestino::updateOrCreate(['product_id' => $datas['product_id'], 'destino_id'=>$this->destino],['stock'=>$q-$datas['cantidad']]); 
                    }
      
                        DB::commit();
             }
                     catch (Exception $e)
                    {
                    DB::rollback();
                    dd($e->getMessage());
                    }
                }
                
      
                   
       


            $this->emit('product-added');
            $this->resetui();
    }

    public function resetui(){
        $this->tipo_proceso=null;
        $this->archivo=null;
        $this->concepto= 'Elegir';
        $this->registro= "Manual";
        $this->destino= 'Elegir';
        $this->reset([
        'costo'
        ,'destinosucursal'
        ,'observacion'
        ,'cantidad']);


        foreach ($this->col as $key => $value)
        {
            $this->col->pull($key);
        }

    }

    public function Exit(){
       // dd("S");
        $this->resetui();
        $this->resetErrorBag();
        $this->emit('product-added');
    }
public function ver($id){

    $this->detalle= DetalleEntradaProductos::where('id_entrada',$id)->get();
    $this->emit('show-detail');

}

public function buscarl(){

    $v3=ProductosDestino::all();


    $object = $v3->filter(function($item) {
        
       $flot=Lote::where('product_id',$item->product_id)->get()->count();
//dump($flot);
      if ($flot==0) 
      {


          return $item;
      }
    
    })->values();

    dd($object);
}
protected $listeners = ['eliminar_registro' => 'eliminar_registro', 'eliminar_registro_total'=>'eliminar_registro_total'];

public function verifySale(IngresoProductos $id)
{
    //$id->delete();
    $auxi=0;
    $auxi1=IngresoProductos::join('detalle_entrada_productos','detalle_entrada_productos.id_entrada','ingreso_productos.id')
    ->join('lotes','detalle_entrada_productos.lote_id','lotes.id')
    ->where('ingreso_productos.id',$id->id)
    ->select('lotes.id as lote_id','detalle_entrada_productos.id as detalle_ent_id','ingreso_productos.id as ing_prod','lotes.product_id as product_id')
    ->get();
    $def=0;
    $rt=0;
    $er=[];

    //dd($auxi);
    if (count($auxi1)>0) {
        foreach ($auxi1 as $data) {

            SaleLote::where('lote_id',$data->lote_id)->get()->count()>0 ? $er="m" : $er='';
            SalidaLote::where('lote_id',$data->lote_id)->get()->count()>0 ? $er="" : $er='';

            //dd($rt);
          
            // if ($rt>0) 
            // {
            //    $def++;
            // }


        //     $product= Product::find($data->product_id);
        //     //$product->destinos->count()>0 ? $auxi++ : '' ;
        //    //$product->detalleCompra->count()>0 ? $auxi++ :'';
        //     $product->detalleSalida->count()>0 ? $auxi++ :'';
        //     $product->detalleTransferencia->count()>0 ? $auxi++ :'';
        //     $product->detalleVenta->count()>0 ? $auxi++ : '' ;

        }

        if ($er) {
            dd($er);
            $this->emit('venta');
        }
        else{
       
            if ($auxi == 0) 
            {

                $this->emit('confirmarAll');
                $this->ing_prod_id= $id->id;
                $this->destino_delete=$id->destino;

            }
            else{

                $this->emit('confirmar');
                $this->ing_prod_id= $id->id;
                $this->destino_delete=$id->destino;
            }
            
        }
    }
}

public function eliminar_registro()
{
   
    $rel=DetalleEntradaProductos::where('id_entrada',$this->ing_prod_id)->get();
    foreach ($rel as $data) {
        
        
        $data->delete();
        $lot=Lote::find($data->lote_id);
        $lot->delete();

        $q=ProductosDestino::where('product_id',$data->product_id)
        ->where('destino_id',$this->destino_delete)->value('stock');

        
        $gh=ProductosDestino::updateOrCreate(['product_id'=>$data->product_id,'destino_id'=>$this->destino_delete],['stock'=>$q-$data->cantidad]);
        



    }
    $del=IngresoProductos::find($this->ing_prod_id);
    $del->delete();
   

}


public function eliminar_registro_total()
{
   
    $rel=DetalleEntradaProductos::where('id_entrada',$this->ing_prod_id)->get();
    foreach ($rel as $data) {
        
        
        $lot=Lote::find($data->lote_id);
        $data->delete();
        $lot->delete();

        $q=ProductosDestino::where('product_id',$data->product_id)
        ->where('destino_id',$this->destino_delete);
     
        $q->delete();

    }
    $del=IngresoProductos::find($this->ing_prod_id);
    $del->delete();
   

}

   


    
}
