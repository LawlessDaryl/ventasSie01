<?php

namespace App\Http\Livewire;

use App\Models\Categoria_estante;
use App\Models\Category;
use App\Models\Destino;
use App\Models\Sucursal;
use App\Models\Location;
use App\Models\LocationProducto;
use App\Models\Product;
use App\Models\ProductosDestino;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class LocalizacionController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $sucursal, $codigo, $descripcion,$ubicacion, $tipo,$product,$product_name,
    $selected_id, $categoria,$subcategoria,$location, $pageTitle, $componentName,$search,$search2,$destino,$listaproductos,$auxi=[];
    private $pagination = 20;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Mobiliario';
        $this->tipo = 'Elegir';
        $this->ubicacion = 'Elegir';
        $this->sucursal_id = 'Elegir';
     
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $locations = Location::join('destinos as dest', 'dest.id', 'locations.destino_id')
                ->join('sucursals as suc','suc.id','dest.sucursal_id')
                ->select('locations.*', 'dest.nombre as destino','suc.name as sucursal' )
                ->where('locations.codigo', 'like', '%' . $this->search . '%')
                ->orWhere('locations.tipo', 'like', '%' . $this->search . '%')
                ->orWhere('dest.nombre', 'like', '%' . $this->search . '%')
                ->orWhere('suc.name', 'like', '%' . $this->search . '%')
                ->orderBy('locations.id', 'desc')
                ->paginate($this->pagination);
        } else {
            $locations = Location::join('destinos as dest', 'dest.id', 'locations.destino_id')
                ->join('sucursals as suc','suc.id','dest.sucursal_id')
                ->select('locations.*', 'dest.nombre as destino','suc.name as sucursal' )
                ->orderBy('locations.id', 'desc')
                ->paginate($this->pagination);
        }

        $suc_data=Destino::join('sucursals as suc','suc.id','destinos.sucursal_id')
        ->select('destinos.nombre as destino','destinos.id as id','suc.name as sucursal')
        ->orderBy('destinos.id','asc');


        $data_categoria= Category::where('categories.categoria_padre',0)->orderBy('name', 'asc')->get();
     
        if (strlen($this->search2) > 0)
        $data_prod_mob = Product::select('products.*')
        ->where('nombre', 'like', '%' . $this->search2 . '%')
        ->orWhere('codigo','like','%'.$this->search2.'%')
        ->take(3)
        ->get();
        else
        $data_prod_mob=false;

        $data_subcategoria= Category::where('categories.categoria_padre',$this->categoria)
        ->where('categories.categoria_padre','!=','Elegir')
        ->get();
        $data_producto= Product::where('category_id',$this->subcategoria)->get();

        $data_destino=Sucursal::join('destinos as dest','sucursals.id','dest.sucursal_id')
        ->select('dest.*','dest.id as destino_id','sucursals.*')->get();

        $data_mobiliario=Location::join('destinos as dest', 'dest.id', 'locations.destino_id')
        ->join('sucursals as suc','suc.id','dest.sucursal_id')
        ->select('locations.*', 'dest.nombre as destino','suc.name as sucursal' )
        ->where('dest.id',$this->destino)
        ->get();

    
        return view('livewire.localizacion.component', [
                    'data_locations' => $locations,
                    'data_suc' => $suc_data->get(),
                    'data_categoria'=> $data_categoria,
                    'data_subcategoria'=> $data_subcategoria,
                    'data_destino'=>$data_destino,
                    'data_mobiliario'=> $data_mobiliario,
                    'data_mob'=> $data_prod_mob,
                    'data_producto'=>$data_producto

           
        
        ])->extends('layouts.theme.app')->section('content');
    }
    public function Store()
    {
        $rules = [
            'tipo' => 'required|not_in:Elegir',
            'codigo' => 'required|unique:locations|min:4',
            'destino' => 'required|not_in:Elegir',
            'descripcion' => 'required|min:5'
        ];
        $messages = [
            
            'codigo.required' => 'Codigo de la locacion es requerido',
            'codigo.unique' => 'Ya existe el codigo de la locacion',
            'codigo.min' => 'El codigo debe contener al menos 4 caracteres',
            'tipo.required' => 'El tipo de aparador es requerido',
            'tipo.not_in' => 'Escoja una opcion diferente de elegir',
            'destino.required' => 'La ubicacion es requerida',
            'destino.not_in' => 'Elegir una ubicacion  diferente de Elegir',
            'descripcion.required' => 'La descripcion es requerida',
            'descripcion.min' => 'La descripcion debe contener al menos 5 caracteres',
        ];

        $this->validate($rules, $messages);
        $localizacion = Location::create([
           
            'codigo' => $this->codigo,
            'descripcion' => $this->descripcion,
            'destino_id' => $this->destino,
            'tipo' => $this->tipo
            
        ]);
        
        $localizacion->save();
        $this->resetUI();
        $this->emit('localizacion-added', 'Localizacion Registrada Exitosamente');
    }
    public function Edit(Location $loc)
    {
        $this->selected_id = $loc->id;
        $this->tipo = $loc->tipo;
        $this->codigo = $loc->codigo;
        $this->descripcion = $loc->descripcion;
        $this->destino = $loc->destino_id;
       
  

        $this->emit('modal-locacion', 'show modal!');
    }
    public function Update()
    {
        $rules = [
           
            'codigo' => 'required',
            'tipo' => 'required',
            'destino' => 'required',
            'descripcion' => 'required',
        ];
        $messages = [
           
            'codigo.required' => 'El codigo es requerido',
            'tipo.required' => 'El nombre de tipo aparador es requerido',
            'destino.required' => 'La ubicacion es requerido',
            'descripcion.required' => 'La descripcion es requerida',
        ];
        $this->validate($rules, $messages);
        $locations = Location::find($this->selected_id);
        $locations->update([
            'codigo' => $this->codigo,
            'descripcion' => $this->descripcion,
            'destino_id' => $this->destino,
            'tipo' => $this->tipo
        ]);
       
        $this->resetUI();
        $this->emit('location-updated', 'Locacion Actualizada');
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Location $loc)
    {
   
        $loc->delete();

        $this->resetUI();
        $this->emit('localizacion-deleted', 'Localizacion Eliminada');
    }

    public function asignarMobiliario()
    {
        
        
        $rules = [
            'product' => "required|not_in:Elegir|unique:location_productos,product,NULL,NULL,location,{$this->location}",
            'location' => "required|not_in:Elegir|unique:location_productos,location,NULL,NULL,product,{$this->product}"
        ];
        $messages = [
            'product.not_in' => 'Elija una opcion diferente de elegir',
            'product.unique' => 'Este producto ya esta asignado a este mobiliario.',
            'location.unique' => 'Este mobiliario ya esta asignado a este producto',
            'location.required' => 'El nombre de tipo aparador es requerido'
        ];

        $this->validate($rules, $messages);

        LocationProducto::create([
            'product'=>$this->product,
            'location'=>$this->location
        ]);
        $this->resetUI();

        $this->emit('localizacion-assigned', 'Mobiliario asignado Exitosamente');
    }
    public function resetUI()
    {
        $this->tipo =null;
        $this->selected_id=null;
        $this->codigo=null;
        $this->descripcion= null;
        $this->sucursal= null ;
        $this->categoria=null ;
        $this->subcategoria= null;
        $this->producto=null ;
        $this->product_name=null;
        $this->destino= null;
        $this->location= null;
        $this->resetValidation();
    }

    public function ver($id){
        
        $this->listaproductos= LocationProducto::join('locations','locations.id','location_productos.location')
        ->join('products','location_productos.product','products.id')
        ->where('locations.id',$id)
        ->select('location_productos.*')
        ->get();
        //dd($this->listaproductos->count());
        $this->emit('verprod');
    }

    public function delete($id)
    {
        LocationProducto::where('location_productos.id',$id)->delete();

        
    }

    public function addProd( Product $id){

      
      $this->product=$id->id;
    $this->product_name=$id->nombre;
    

    }


}
