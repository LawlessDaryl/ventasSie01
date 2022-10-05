<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Areaspermissions;

class AreasPermissionsController extends Component
{
    use WithPagination;
    public $name, $search, $selected_id, $pageTitle, $componentName;

    private $pagination = 10;
    //paginations
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    //propiedades a inicar la vista del component
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Areas De Permisos';
        
    }
    public function render()
    {
        //buscador
        if (strlen($this->search) > 0) {
            $areas = Areaspermissions::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $areas = Areaspermissions::orderBy('id', 'asc')->paginate($this->pagination);
        }

        return view('livewire.areaspermissions.component',[
            'data' => $areas,
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
    
    public function Agregar()
    {
        $this->resetUI();
        $this->emit('show-modal', 'show modal!');
    }
     //store agregar Area nueva
     public function Store()
     {
        
         //validar los datos
         $rules = [
             'name' => 'required|unique:areaspermissions|min:3'
         ];
         //reglas de validacion
         $messages = [
             'name.required' => 'nombre de la Area de permisos es requerido',
             'name.unique' => 'Ya existe el nombre de la Area',
             'name.min' => 'El nombre de la Area de permisos debe tener al menos 3 caracteres' 
         ];
         //ejecutar las validaciones
         $this-> validate($rules, $messages);
         
         //insertar en la categoria nueva
         Areaspermissions::create([
             'name' => $this->name
         ]);
 
        
         
         $this->emit('area-added','Area de permisos Registrada');
         $this->resetUI();
 
     }
     public function Edit(Areaspermissions $area)
    {
        $this->selected_id = $area->id;
        $this->name = $area->name;

        $this->emit('show-modal', 'Show modal ');
    }

     public function Update()
    {
        $rules = [
            //validar datos
            'name' => "required|min:3|unique:areaspermissions,name,{$this->selected_id}"

        ];
        //mensajes personalizados
        $messages =[
            'name.required' => 'Nombre de Area de permisos requerido',
            'name.min' => 'El nombre de la Area de permisis debe tener al menos 3 caracteres',
            'name.unique' => 'El nombre de la Area de permisos ya existe'
        ];

        //ejecutar la validacion
        $this->validate($rules, $messages);
        //actualizar la caegoria
        $Area = Areaspermissions::find($this->selected_id);
        $Area->update([
            'name' => $this->name
        ]);

        //validacion de imagen
        
        $this->emit('item-update', 'Se actualizó el Area con éxito');
        $this->resetUI();
    }
    //destruir un area
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Areaspermissions $area)
    {
        //hola
        $area->delete();
        $this->emit('item-deleted', 'Se eliminó el Area con exito');
    }

     //eliminar todo lo que se tenga en el formulario
    public function resetUI()
    {
        $this->name = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
