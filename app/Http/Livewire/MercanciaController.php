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
    public  $fecha,$buscarproducto=0,$selected,$registro
    ,$archivo,$searchproduct,$costo,$sm,$dataconcepto,$destino,$tipo_proceso,$col,$destinosucursal,$observacion,$cantidad,$result,$arr;

    public function mount(){
        $this->col=collect([]);
        $this->tipo_proceso= "Entrada";
        $this->registro='Manual';
        $this->dataconcepto="INGRESO";
       // $this->borrarLotes();
       //$this->ajustarLotes();
       //$this->productosajustados();
      //$this->limpiarstock();
     //$this->inactivarlotes();

    }
    public function render()
    {
        
        $ingprod= IngresoProductos::with(['detalleingreso'])->orderBy('ingreso_productos.created_at','desc')->get();
        //dd($ingprod);
        $salprod=SalidaProductos::with(['detallesalida']);

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
        
        $this->col->push(['product_id'=> $id->id,'product-name'=>$id->nombre,'costo'=>$this->costo,'cantidad'=>$this->cantidad]);

        $rules = [
            'costo' => 'required',
            'cantidad' => 'required',
        ];

        $messages = [
            'costo.required' => 'El costo es requerido',
            'cantidad.required' => 'La cantidad es requerida'
        ];

        $this->validate($rules, $messages);


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
                    $qq=$data3->quantity;//q=8

                    foreach ($lot as $val) { //lote1= 3 Lote2=3 Lote3=3
                       
                        if($qq>0){            //true//5//2
                            
                            if ($qq > $val->existencia) {

                                $ss=SaleLote::create([
                                    'sale_detail_id'=>$data3->id,
                                    'lote_id'=>$val->id,
                                    'cantidad'=>$val->existencia
                                    
                                ]);
                                $ss->update(['created_at'=>$data3->created_at,'updated_at'=>$data3->updated_at]);
                                $ss->save();
  
                                $val->update([
                                    
                                    'existencia'=>0,
                                    'status'=>'Inactivo'
    
                                ]);
                                $val->save();
                                $qq=$qq-$val->existencia;
                            }
                            else{
                                $dd=SaleLote::create([
                                    'sale_detail_id'=>$data3->id,
                                    'lote_id'=>$val->id,
                                    'cantidad'=>$qq
                                ]);
                                $dd->update(['created_at'=>$data3->created_at,'updated_at'=>$data3->updated_at]);
                                $dd->save();
   
    
                                $val->update([ 
                                    'existencia'=>$val->existencia-$qq
                                ]);
                                $val->save();
                              
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

    public function BuscarProducto()
    {
        //obtengo la cantidad total de todos los productos que se ingresaron despues del ajuste a cada sucursal
        $v3=IngresoSalida::join('detalle_operacions','detalle_operacions.id_operacion','ingreso_salidas.id')->join('products', 'products.id','detalle_operacions.product_id')
        ->where('proceso','Entrada')->groupBy('detalle_operacions.product_id')->selectRaw('sum(cantidad) as sum, detalle_operacions.product_id,products.costo')->get();
    

        $object = $v3->filter(function($item) {
            
            $auxi= SaleDetail::where('product_id',$item->product_id)->first();
          if ($auxi and $auxi->product_id == $item->product_id ) 
          {}
          else{
            return $item;
          }
        })->values();
               foreach ($object as $data3) {
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
                        'costo'=>$data3->costo,
                        'status'=>'Activo',
                        'product_id'=>$data3->product_id
                    ]);
    
                       DetalleEntradaProductos::create([
                            'product_id'=>$data3->product_id,
                            'cantidad'=>$data3->sum,
                            'costo'=>$data3->costo,
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
            $fg= Lote::where('product_id',$val8->product_id)->where('existencia')->get();

            foreach ($fg as $daf) {
                $daf->update([
                    'existencia'=>$val8->sum
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
            if ($this->dataconcepto === "INICIAL" && $this->registro === "Documento") {
             
                try {
                    //$import->import('import-users.xlsx');
                    Excel::import(new StockImport($this->destinosucursal,$this->dataconcepto,$this->observacion),$this->archivo);
                    return redirect()->route('productos');
                } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

                     $this->failures = $e->failures();
                     dump($this->failures);
                   
                }
            }
            foreach ($this->col as $datas) {
                if ($this->tipo_proceso == 'Entrada') {

                    $rules = [
                        'observacion' => 'required',
                        'destinosucursal' => 'not_in:Elegir',
                    ];
            
                    $messages = [
                        'observacion.required' => 'Agregue una observacion',
                        'destinosucursal.not_in' => 'Elija el destino de la mercaderia'
                    ];
            
                    $this->validate($rules, $messages);

                    
                 
                        DB::beginTransaction();
                        try {
                            $rs=IngresoProductos::create([
                                'destino'=>$this->destinosucursal,
                                'user_id'=>Auth()->user()->id,
                                'concepto'=>$this->dataconcepto,
                                'observacion'=>$this->observacion
                               ]);
            
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
                    ->where('destino_id',$this->destinosucursal)->value('stock');

                    ProductosDestino::updateOrCreate(['product_id' => $datas['product_id'], 'destino_id'=>$this->destinosucursal],['stock'=>$q+$datas['cantidad']]);
            
        
        
        
                              
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

                       $auxi= SalidaProductos::create([
                            'destino'=>$this->destinosucursal,
                            'user_id'=>Auth()->user()->id,
                            'concepto'=>$this->dataconcepto,
                            'observacion'=>$this->observacion
                        ]);
                   
        
                            $lot=Lote::where('product_id',$datas['product_id'])->where('status','Activo')->get();
        
                             //obtener la cantidad del detalle de la venta 
                            $qq=$datas['cantidad'];//q=8
        
                            foreach ($lot as $val) { //lote1= 3 Lote2=3 Lote3=3
                               
                                if($qq>0){            //true//5//2
                                    
                                    if ($qq > $val->existencia) {
        
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
                                        $qq=$qq-$val->existencia;
                                    }
                                    else{
                                        $dd=SaleLote::create([
                                            'sale_detail_id'=>$auxi->id,
                                            'lote_id'=>$val->id,
                                            'cantidad'=>$qq
                                        ]);
                                      
           
            
                                        $val->update([ 
                                            'existencia'=>$val->existencia-$qq
                                        ]);
                                        $val->save();
                                      
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
            }


            $this->emit('product-added');
            $this->resetui();
    }

    public function resetui(){
        $this->tipo_proceso='Entrada';
        $this->reset([
        'archivo',
        'costo',
        'dataconcepto'
        ,'destino'
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
        $this->emit('product-added');
    }

    
}
