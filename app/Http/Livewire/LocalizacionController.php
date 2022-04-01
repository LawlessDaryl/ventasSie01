<?php

namespace App\Http\Livewire;

use App\Models\Destino;
use App\Models\Sucursal;
use App\Models\Location;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class LocalizacionController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $sucursal, $codigo, $descripcion,$ubicacion, $aparador, 
    $selected_id, $pageTitle, $componentName,$search,$destino;
    private $pagination = 8;
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
                ->orWhere('dest.name', 'like', '%' . $this->search . '%')
                ->orWhere('locations.ubicacion', 'like', '%' . $this->search . '%')
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

    
        return view('livewire.localizacion.component', [
            'data_locations' => $locations,
            'data_suc' => $suc_data->get(),
           
        
        ])->extends('layouts.theme.app')->section('content');
    }
    public function Store()
    {
        $rules = [
         
            'codigo' => 'required|unique:locations|min:4',
            'aparador' => 'required|not_in:Elegir',
            'destino' => 'required|not_in:Elegir',
            'descripcion' => 'required|min:5',
            
        ];
        $messages = [
            
            'codigo.required' => 'Codigo de la locacion es requerido',
            'codigo.unique' => 'Ya existe el codigo de la locacion',
            'codigo.min' => 'El codigo debe contener al menos 4 caracteres',
            'aparador.required' => 'El codigo debe contener al menos 4 caracteres',
            'aparador.not_in' => 'El codigo debe contener al menos 4 caracteres',
            'destino.required' => 'La ubicacion es requerida',
            'destino.not_in' => 'Elegir una ubicacion  diferente de Elegir',
            
            'descripcion.required' => 'La descripcion es requerida',
            'descripcion.min' => 'La descripcion debe contener al menos 10 caracteres',
        ];

        $this->validate($rules, $messages);
        $localizacion = Location::create([
           
            'codigo' => $this->codigo,
            'descripcion' => $this->descripcion,
            'destino_id' => $this->destino,
            'tipo' => $this->aparador
            
        ]);
        
        $localizacion->save();
        $this->resetUI();
        $this->emit('localizacion-added', 'Localizacion Registrada Exitosamente');
    }
    public function Edit(Location $loc)
    {
        $this->selected_id = $loc->id;
        $this->aparador = $loc->tipo;
        $this->codigo = $loc->codigo;
        $this->descripcion = $loc->descripcion;
        $this->destino = $loc->destino_id;
       
  

        $this->emit('modal-locacion', 'show modal!');
    }
    public function Update()
    {
        $rules = [
           
            'codigo' => 'required',
            'aparador' => 'required',
            'destino' => 'required',
            'descripcion' => 'required',
        ];
        $messages = [
           
            'codigo.required' => 'El codigo es requerido',
            'aparador.required' => 'El nombre de tipo aparador es requerido',
            'destino.required' => 'La ubicacion es requerido',
            'descripcion.required' => 'La descripcion es requerida',
        ];
        $this->validate($rules, $messages);
        $locations = Location::find($this->selected_id);
        $locations->update([
            'codigo' => $this->codigo,
            'descripcion' => $this->descripcion,
            'destino_id' => $this->destino,
            'tipo' => $this->aparador
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
    public function resetUI()
    {
        $this->aparador = 'Elegir';
        $this->codigo = '';
        $this->descripcion = '';
        $this->destino = 'Elegir';
        
       

        $this->resetValidation();
    }
}
