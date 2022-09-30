<?php

namespace App\Http\Livewire;

use App\Http\Controllers\ExportExcelAlmacenController;
use App\Models\Category;
use App\Models\Destino;
use App\Models\DetalleEntradaProductos;
use App\Models\DetalleOperacion;
use App\Models\DetalleSalidaProductos;
use App\Models\IngresoProductos;
use App\Models\IngresoSalida;
use App\Models\Location;
use App\Models\LocationProducto;
use App\Models\Lote;
use App\Models\Product;
use App\Models\ProductosDestino;
use App\Models\SalidaLote;
use App\Models\SalidaProductos;
use Illuminate\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DestinoProductoController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $selected_id,$search,$selected_mood,$selected_ubicacion,$loteproducto,$filtro_stock,$componentName,$title,$sql,$prod,$grouped,$stocks,$productoajuste,$cant_operacion,$opcion_operacion,$obs_operacion,$cantidad,$productid,$productstock,$mobiliario,$mobs,$mop_prod, $active,$toogle,$qq;
    private $pagination = 50;
   
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    
    public function mount()
    {

        $this->selected_id='General';
        $this->componentName='crear';
        $this->title='ssss';
        $this->pr=20;
        $this->toogle=1;
        $this->selected_mood='todos';
   
    
    }
    public function cerrar()
    {
        $this->grouped=false;
    }

    public function render()
    {

        if ($this->toogle == 1) {
            $this->active1="active show";
            $this->active2="";
            $this->active3="";
        }
        if ($this->toogle == 2) {
            $this->active1="";
            $this->active2="active show";
            $this->active3="";
        }
        if ($this->toogle == 3) {
            $this->active1="";
            $this->active2="";
            $this->active3="active show";
        }

        $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product_id')
                    ->join('destinos as dest','dest.id','productos_destinos.destino_id')
                    ->where(function($query){
                        $query->where('p.nombre', 'like', '%' . $this->search . '%')
                                ->orWhere('p.codigo', 'like', '%' . $this->search . '%');    
                    })
                    
                    //->select('productos_destinos.stock','p.*')
                    ->when($this->selected_id =='General',function($query){
                       return $query->select('p.*','p.cantidad_minima as cant',DB::raw("SUM(productos_destinos.stock) as stock_s"))->groupBy('p.id');
                    })
                    ->when($this->selected_id != 'General',function($query){
                        return $query->select('p.*','p.cantidad_minima as cant2','productos_destinos.stock as stock')->where('productos_destinos.destino_id',$this->selected_id);
                     })
                     ->when($this->selected_mood =='cero',function($query){
                        if ($this->selected_id =='General') {
                            return $query->having('stock_s',0);
                        }
                        else{
                            return $query->where('stock',0);
                        }
                     })
                     ->when($this->selected_mood =='bajo',function($query){

                        if ($this->selected_id =='General') {
                           
                            return $query->having('stock_s','<',DB::raw("cant"));
                        }
                        else{
                            return $query->whereColumn('stock','<','cantidad_minima');
                        }

                     });

                    //dd($almacen->get());

             $sucursal_ubicacion=Destino::join('sucursals as suc','suc.id','destinos.sucursal_id')
                                        ->select ('suc.name as sucursal','destinos.nombre as destino','destinos.id')
                                        ->orderBy('suc.name','asc');
        
            

                           

        return view('livewire.destinoproducto.almacenproductos',[
            'destinos_almacen'=>$almacen->paginate($this->pagination),
            'data_suc' =>  $sucursal_ubicacion->get(),
        'data_cat'=>Category::select('categories.name')->where('categories.categoria_padre','0')->get()
        ])  
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function operacionInventario(){
        $stockactual=ProductosDestino::where('productos_destinos.product_id',$this->productid)->where('productos_destinos.destino_id',$this->selected_id)->value('stock');

        if ($this->opcion_operacion == 'Entrada') {
            
            ProductosDestino::where('productos_destinos.destino_id',$this->selected_id)->where('productos_destinos.product_id',$this->productid)
            ->update(['stock' => $stockactual + $this->cant_operacion ]);
            $entrada = IngresoProductos::create([
                'destino' => $this->selected_id,
                'user_id' => Auth()->user()->id,
                'concepto'=>'INGRESO',
                'observacion'=>$this->obs_operacion
            ]);

            $lot= Lote::create([
                'existencia'=>$this->cant_operacion,
                'status'=>'Activo'
            ]);

            DetalleEntradaProductos::create([

                'product_id'=>$this->productid,
                'cantidad'=>$this->cant_operacion,
                'id_entrada'=>$entrada->id,
                'lote_id'=>$lot->id

            ]);
        }
        if ($this->opcion_operacion == 'Salida') {
            ProductosDestino::where('productos_destinos.destino_id',$this->selected_id)->where('productos_destinos.product_id',$this->productid)
            ->update(['stock' => $stockactual - $this->cant_operacion ]);


        }
       

        
        $this->cant_operacion=0;
        $this->obs_operacion=null;
        $aux= Product::find($this->productid);
        $this->ajuste($aux);
        $this->emit('show-modal-ajuste');
    }

    public function ver(Product $prod){
         $this->sql= "select rt,location,dsn,suc_id,loc,loc_cod,stock from ( select products.id as rt,destinos.id as dest,destinos.nombre as dsn, sucursals.name as suc_id,stock from productos_destinos 
        join products on productos_destinos.product_id= products.id
        join destinos on productos_destinos.destino_id= destinos.id
        join sucursals on destinos.sucursal_id= sucursals.id
         ) as dd left join ( select products.id as pt,destinos.id as best,destinos.nombre as bsn,locations.id as location, locations.tipo as loc
         ,locations.codigo as loc_cod
         from location_productos
          join products on location_productos.product= products.id
        join locations on location_productos.location= locations.id
        join destinos on locations.destino_id= destinos.id
        ) as mm on dd.dest= mm.best and dd.rt= mm.pt where rt='$prod->id'";
        
        $this->pr=DB::select($this->sql);
        $collection= new SupportCollection();
         
        foreach ($this->pr as $value) {
            $collection->push(
                (object)[
                    'producto_id'=>$value->rt,
                    'mob_code'=>$value->loc_cod,
                    'tipo'=>$value->loc,
                    'estancia'=>$value->dsn,
                    'sucursal_id'=>$value->suc_id,
                    'stock'=>$value->stock
                ]
                );
        }

     $this->grouped= $collection->groupBy(['sucursal_id','estancia']);
    
//dd($this->grouped);
        $this->emit('show-modal','showsss');
     
    
    }

    public function ajuste(Product $prod){

        $this->productoajuste=$prod->nombre;
        $this->productid=$prod->id;
       $this->productstock=ProductosDestino::where('productos_destinos.product_id',$prod->id)->where('productos_destinos.destino_id',$this->selected_id)->value('stock');

        $this->mop_prod = LocationProducto::where('location_productos.product',$this->productid)->get();

        $arr= $this->mop_prod->pluck('location');

        
        $this->mobs = Location::whereNotIn('id',$arr)->get();

        $this->emit('show-modal-ajuste');
    }
    
 
    public function incrementar(){

        $stockactual=ProductosDestino::where('productos_destinos.product_id',$this->productid)->where('productos_destinos.destino_id',$this->selected_id)->value('stock');


        ProductosDestino::where('productos_destinos.destino_id',$this->selected_id)->where('productos_destinos.product_id',$this->productid)
        ->update(['stock' => $stockactual + $this->cantidad ]);
       

        $auxi2=ProductosDestino::where('productos_destinos.destino_id',$this->selected_id)->where('productos_destinos.product_id',$this->productid)->get();
        // dd($auxi2->values('stock'));
             if ( $auxi2->pluck('stock')[0]>0) {
              $operacion= IngresoProductos::create([
         
             'destino'=>$this->selected_id,
             'user_id'=> Auth()->user()->id,
             'concepto'=>'AJUSTE',
             'observacion'=>'Ajuste de inventarios por producto'
                  ]);
                  $lot= Lote::create([
                    'existencia'=>$this->cantidad,
                    'status'=>'Activo'
                ]);
     
             // dd($auxi2->pluck('stock')[0]);
             DetalleEntradaProductos::create([
             'product_id'=>$this->productid,
             'cantidad'=> $this->cantidad,
             'id_entrada'=>$operacion->id,
             'lote_id'=>$lot->id
         ]);
        }
        $this->cantidad=0;
        $aux= Product::find($this->productid);
        $this->ajuste($aux);
        $this->emit('show-modal-ajuste');

    }

    public function disminuir(){
        $stockactual=ProductosDestino::where('productos_destinos.product_id',$this->productid)->where('productos_destinos.destino_id',$this->selected_id)->value('stock');


        ProductosDestino::where('productos_destinos.destino_id',$this->selected_id)->where('productos_destinos.product_id',$this->productid)
        ->update(['stock' => $stockactual - $this->cantidad ]);
       

        $auxi2=ProductosDestino::where('productos_destinos.destino_id',$this->selected_id)->where('productos_destinos.product_id',$this->productid)->get();
        // dd($auxi2->values('stock'));
           
             $operacion= SalidaProductos::create([
            
             'destino'=>$this->selected_id,
             'user_id'=> Auth()->user()->id,
             'concepto'=>'AJUSTE',
             'observacion'=>'Ajuste de inventarios por producto']);
             // dd($auxi2->pluck('stock')[0]);
             $auxi=DetalleSalidaProductos::create([
             'product_id'=>$this->productid,
             'cantidad'=> $this->cantidad,
             'id_salida'=>$operacion->id
         ]);


         $lot=Lote::where('product_id',$this->productid)->where('status','Activo')->get();

         //obtener la cantidad del detalle de la venta 
         $this->qq=$this->cantidad;//q=8
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
                    'cantidad'=>$val->existencia
                    
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
        $this->cantidad=0;
        $aux= Product::find($this->productid);
        $this->ajuste($aux);
        $this->emit('show-modal-ajuste');
    }

    public function aplicarCambios(){


        $rules = [
            'cantidad' => 'required|min:0'
       
            
        ];
        $messages = [
            'cantidad.required' => 'La existencia es requerida',
            'cantidad.min'=>'El monto minimo debe ser 0.' 
         
        ];
        $this->validate($rules, $messages);

        if ($this->cantidad>$this->productstock) {
            $this->incrementar();
        }
        else{
            $this->disminuir();
        }


    }


    public function asignmob(){
        if ($this->mobiliario) {
        
            LocationProducto::create([
                'product'=>$this->productid,
                'location'=>$this->mobiliario
            ]);
           }
           $this->mobiliario = null;
           $aux= Product::find($this->productid);
           $this->ajuste($aux);
           $this->emit('show-modal-ajuste');
    
    }

  

    public function resetajuste(){
        $this->cantidad= null;
        $this->mobiliario = null;
        $this->emit('hide-modal-ajuste');

    }
    protected $listeners = ['vaciarDestino' => 'vaciarAlmacen'];

    public function vaciarAlmacen(){

        $auxi2=ProductosDestino::where('productos_destinos.destino_id',$this->selected_id)->get();
        foreach ($auxi2 as $data) {
        $data->stock = 0;
        $data->save();
        }
    }

    public function vaciarProducto(){
        //dd($this->selected_id);
        $auxi2=ProductosDestino::where('productos_destinos.destino_id',$this->selected_id)->where('productos_destinos.product_id',$this->productid)->get();
   //dd($auxi2->pluck('stock')[0]);
   try{
        if ( $auxi2->pluck('stock')[0]>0) {
      
    // ajuste de inventarios

    $operacion= SalidaProductos::create([
            
        'destino'=>$this->selected_id,
        'user_id'=> Auth()->user()->id,
        'concepto'=>'AJUSTE',
        'observacion'=>'Ajuste de inventarios por producto'
    ]);
        
    

    // dd($auxi2->pluck('stock')[0]);



        $auxi=DetalleSalidaProductos::create([
        'product_id'=>$this->productid,
        'cantidad'=> $auxi2->pluck('stock')[0],
        'id_salida'=>$operacion->id
]);


        $lot=Lote::where('product_id',$this->productid)
        ->where('status','Activo')->get();

        //obtener la cantidad del detalle de la venta 
        $this->qq=$auxi2->pluck('stock')[0];//q=8
        //dd($this->qq);
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

     
     $q=ProductosDestino::where('product_id',$this->productid)
     ->where('destino_id',$this->selected_id)->value('stock');

     ProductosDestino::updateOrCreate(['product_id' => $this->productid, 'destino_id'=>$this->selected_id],['stock'=>$q-$auxi2->pluck('stock')[0]]); 


    DB::commit();
}
   }
 catch (Exception $e)
{
DB::rollback();
dd($e->getMessage());
}


   foreach ($auxi2 as $data) 
   {
       $data->stock = 0;
       $data->save();
   }

   $aux= Product::find($this->productid);
   $this->ajuste($aux);
   $this->emit('show-modal-ajuste');
    }

    public function eliminarmob(LocationProducto $id){

      
        $id->delete();
       
        $aux= Product::find($this->productid);
        $this->ajuste($aux);
        $this->emit('show-modal-ajuste');
    }

    public function lotes($id){

        //dd($id);
        $this->loteproducto= Lote::where('product_id',$id)->get();
        //dd($this->loteproducto);
        $this->emit('show-modal-lotes');
    }


    public function export() 
    {
        return Excel::download(new ExportExcelAlmacenController, 'almacen.xlsx');
    }


}
