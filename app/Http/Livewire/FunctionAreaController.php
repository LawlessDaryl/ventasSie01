<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FunctionArea;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use App\Models\AreaTrabajo;
use Illuminate\Support\Facades\DB;

class FunctionAreaController extends Component
{
    use WithFileUploads;
    use WithPagination;

    // Datos de Funciones
    public $name, $description, $areaid, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 5;

    // Datos de Areas
    public $nameArea, $descriptionArea, $select_area_id, $componentNuevArea;

    public function mount(){
        $this -> pageTitle = 'Listado';
        $this -> componentName = 'Funciones';

        $this -> componentNuevArea = 'Areas';
        $this -> areaid = 'Elegir';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $data = FunctionArea::join('area_trabajos as at', 'at.id', 'function_areas.area_trabajo_id') // se uno amabas tablas
            ->select('function_areas.*','at.nameArea as area', 'function_areas.id as idFuncion', DB::raw('0 as verificar'))
            ->where('function_areas.name', 'like', '%' . $this->search . '%')   
            ->orWhere('at.nameArea', 'like', '%' . $this->search . '%')         
            ->orderBy('function_areas.name', 'asc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idFuncion);
            }
        }
        else
            $data = FunctionArea::join('area_trabajos as at', 'at.id', 'function_areas.area_trabajo_id')
            ->select('function_areas.*','at.nameArea as area', 'function_areas.id as idFuncion', DB::raw('0 as verificar'))
            ->orderBy('function_areas.name', 'asc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idFuncion);
            }


        return view('livewire.functionArea.component', [
            'functionarea' => $data,        // se envia functionarea
            'area_trabajos' => AreaTrabajo::orderBy('nameArea', 'asc')->get()
            ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // verificar 
    public function verificar($idFuncion)
    {
        $consulta = FunctionArea::where('function_areas.id', $idFuncion);
        
        if($consulta->count() > 0)
        {
            return "si";
        }
        else
        {
            return "no";
        }
    }

    // Abre el modal de Nuevo contrato
    public function NuevArea()
    {
        //$this->resetUI();
        $this->emit('modal-hide', 'show modal!');
        $this->emit('show-modal-area', 'show modal!');
    }

    // Cierra el modal y abre el modal de Registro de empleados
    public function cancelar()
    {
        $this->resetPage(); // regresa la pagina
        $this->emit('show-modal', 'show modal!');
    }

    // Registrar nueva Area
    public function RegNuevArea(){
        $rules = [
            'nameArea' => 'required|unique:area_trabajos|min:3',
        ];
        $messages =  [
            'nameArea.required' => 'Nombre del area es requerida',
            'nameArea.unique' => 'ya existe el nombre del area',
            'nameArea.min' => 'el nombre del area debe tener al menos 3 caracteres',
        ];

        $this->validate($rules, $messages);
       
        $area = AreaTrabajo::create([
            'nameArea'=>$this->nameArea, 
            'descriptionArea'=>$this->descriptionArea
        ]);

        $this->emit('area-added', 'Area Registrada');
        $this->resetUI();
        $this->emit('modal-hide-area', 'show modal!');
        $this->emit('show-modal', 'show modal!');
    }

    // Registrar nueva funcion
    public function Store(){
        $rules = [
            'name' => 'required|unique:function_areas|min:3',
            'areaid' => 'required|not_in:Elegir'
        ];
        $messages =  [
            'name.required' => 'Nombre de la funcion es requerida',
            'name.unique' => 'ya existe el nombre de la funcion',
            'name.min' => 'el nombre de la funcion debe tener al menos 3 caracteres',
            'areaid.not_in' => 'elije un nombre de area diferente de elegir',
        ];

        $this->validate($rules, $messages);

        $functionarea = FunctionArea::create([
            'name'=>$this->name,
            'description'=>$this->description,
            'area_trabajo_id' => $this->areaid
        ]);

        $this->resetUI();
        $this->emit('fun-added', 'Funcion Registrada');
        $this->emit('modal-hide-area', 'show modal!');
        $this->emit('show-modal', 'show modal!');
    }

    // editar datos
    public function Edit(FunctionArea $functionarea){
        $this->selected_id = $functionarea->id;
        $this->name = $functionarea->name;
        $this->description = $functionarea->description;
        $this->areaid = $functionarea->area_trabajo_id;

        $this->emit('show-modal', 'show modal!');
    }

    // Actualizar datos
    public function Update(){
        $rules = [
            'name' => "required|min:3|unique:function_areas,name,{$this->selected_id}",
            'areaid' => 'required|not_in:Elegir'
        ];
        $messages =  [
            'name.required' => 'Nombre de la funcion es requerida',
            'name.unique' => 'ya existe el nombre de la funcion',
            'name.min' => 'el nombre de la funcion debe tener al menos 3 caracteres',
            'areaid.not_in' => 'elije un nombre de area diferente de elegir',
        ];
        $this->validate($rules,$messages);

        $functionarea = FunctionArea::find($this->selected_id);
        $functionarea -> update([
            'name' => $this->name,
            'description' => $this->description,
            'area_trabajo_id' => $this->areaid
        ]);

        $this->resetUI();
        $this->emit('fun-updated','Categoria Actualizar');
    }

    // vaciar formulario
    public function resetUI(){
        $this->name='';
        $this->description='';
        $this->areaid = 'Elegir';
        $this->search='';
        $this->selected_id=0;

         // Datos de Area
         $this->nameArea='';
         $this->descriptionArea='';
         $this->select_area_id = 0;
         $this->resetValidation(); // resetValidation para quitar los smg Rojos
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    // eliminar
    public function Destroy(FunctionArea $functionarea){
        $functionarea->delete();
        $this->resetUI();
        $this->emit('fun-deleted','Producto Eliminada');
    }
}
