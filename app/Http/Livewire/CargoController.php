<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cargo;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Employee;

use Illuminate\Support\Facades\DB;

class CargoController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, /*$nrovacantes,*/ $estado, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 10;

    public function mount(){
        $this -> pageTitle = 'Listado';
        $this -> componentName = 'Cargos de Trabajo';

        $this->estado = 'Elegir';
        $this->idEmpleado = 0;
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $data = Cargo::select('cargos.id as idcargo',
            'cargos.name as name',
            //'cargos.nrovacantes as nrovacantes',
            'cargos.estado as estado',
            DB::raw('0 as verificar'))
            ->orderBy('id','desc')
            ->where('cargos.name', 'like', '%' . $this->search . '%')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idcargo);
            }
        }
        else
        {
            $data = Cargo::select('cargos.id as idcargo',
            'cargos.name as name',
            //'cargos.nrovacantes as nrovacantes',
            'cargos.estado as estado',
            DB::raw('0 as verificar'))
            ->orderBy('id','desc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio idcategoria
                $os->verificar = $this->verificar($os->idcargo);
            }
        }

        return view('livewire.cargo.component', ['cargos' => $data ]) // se envia cargos
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // verificar 
    public function verificar($idcargo)
    {
        $consulta = Cargo::join('employees as e', 'e.cargo_id', 'cargos.id')
        ->select('cargos.*')
        ->where('cargos.id', $idcargo)
        ->get();
       
        if($consulta->count() > 0)
        {
            return "no";
        }
        else
        {
            return "si";
        }
    }

    // editar 
    public function Edit($id){
        $record = Cargo::find($id, ['id', 'name'/*, 'nrovacantes'*/, 'estado']);
        $this->name = $record->name;
        //$this->nrovacantes = $record->nrovacantes;
        $this->estado = $record->estado;
        $this->selected_id = $record->id;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules = [
            'name' => 'required|unique:cargos|min:5',
            //'nrovacantes.required' => 'Nombre del cargo es requerida',
            'estado' => 'required|not_in:Elegir',
        ];
        $messages =  [
            'name.required' => 'Nombre de cargo es requerida',
            'name.unique' => 'ya existe el nombre del cargo',
            'name.min' => 'el nombre del cargo debe tener al menos 5 caracteres',

            //'nrovacantes.required' => 'Ingrese nro de vacantes que dispone el cargo',

            'estado.required' => 'seleccione estado de cargo',
            'estado.not_in' => 'selecciona estado de cargo',
        ];

        $this->validate($rules, $messages);
       
        $cargo = Cargo::create([
            'name'=>$this->name,
            //'nrovacantes'=>$this->nrovacantes,
            'estado'=>$this->estado
        ]);

        // if($this->nrovacantes ){
            //if($rows <10){se pueden registrar}else{ no se pueden registrar}
        // }

        $this->resetUI();
        $this->emit('cargo-added', 'Cargo Registrado');
    }

    // actualizar
    public function Update(){
        $rules = [
            'name' => "required|min:5|unique:cargos,name,{$this->selected_id}",
            //'nrovacantes.required' => 'Nombre del cargo es requerida',
            'estado' => 'required|not_in:Elegir',
        ];

        $messages = [
            'name.required' => 'Nombre de cargo es requerida',
            'name.unique' => 'ya existe el nombre del cargo',
            'name.min' => 'el nombre del cargo debe tener al menos 5 caracteres',

            //'nrovacantes.required' => 'Ingrese nro de vacantes que dispone el cargo',

            'estado.required' => 'seleccione estado de cargo',
            'estado.not_in' => 'selecciona estado de cargo',
        ];
        $this->validate($rules,$messages);

        $cargo = Cargo::find($this->selected_id);
        $cargo -> update([
            'name' => $this->name,
            //'nrovacantes'=>$this->nrovacantes,
            'estado'=>$this->estado
        ]);

        $this->resetUI();
        $this->emit('cargo-updated','Cargo Actualizada');
    }

    public function resetUI(){
        $this->name='';
        //$this->nrovacantes='';
        $this->estado = 'Elegir';
        $this->search='';
        $this->selected_id=0;
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    // eliminar
    public function Destroy($id)
    {
        $cargo = Cargo::find($id);
        $cargo->delete();
        $this->resetUI();
        $this->emit('cargo-deleted','Cargo Eliminada');
    }
}
