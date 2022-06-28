<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TypeWork;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class TypeWorkController extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $name, $search, $status, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = 'LISTADO';
        $this->componentName = 'TIPO DE TRABAJO';
        $this->status = 'Elegir';
        $this->selected_id = 0;
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search) > 0)
            $data = TypeWork::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $data = TypeWork::orderBy('id', 'desc')->paginate($this->pagination);
        return view('livewire.type_work.component', ['categories' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit($id)
    {
        $record = TypeWork::find($id, ['id', 'name', 'status']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->status = $record->status;

        $this->emit('show-modal', 'show modal!');
    }
    public function Store()
    {
        $rules = [
            'name' => 'required|unique:type_works|min:1',
            'status' => 'required|not_in:Elegir'
        ];
        $messages = [
            'name.required' => 'El nombre del tipo de trabajo es requerido',
            'name.unique' => 'Ya existe el nombre del tipo de trabajo',
            'name.min' => 'El nombre del tipo de trabajo debe tener al menos 1 caracter',
            'status.required' => 'Selecciona el estado del tipo de trabajo'
        ];
        $this->validate($rules, $messages);

        $category = TypeWork::create([
            'name' => $this->name,
            'status' => $this->status,
        ]);

  
        $this->resetUI();
        $this->emit('item-added', 'Tipo de Trabajo Registrado');
    }


    public function Update()
    {
        $rules = [
            'name' => "required|unique:type_works,name,{$this->selected_id}",
            'name' => 'required|min:1',
            'status' => 'required|not_in:Elegir'
        ];
        $messages = [
            'name.required' => 'El nombre del tipo de trabajo es requerido',
            'name.unique' => 'Ya existe el nombre del tipo de trabajo',
            'name.min' => 'El nombre del tipo de trabajo debe tener al menos 1 caracter',
            'status.required' => 'Selecciona el estado del tipo de trabajo'
        ];
        $this->validate($rules, $messages);
        $category = TypeWork::find($this->selected_id);

        $category->update([
            'name' => $this->name,
            'status' => $this->status,
        ]);


        $this->resetUI();
        $this->emit('item-updated', 'Tipo de Trabajo Actualizado');
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(TypeWork $category)
    {
        
        $category->delete();
        
        $this->resetUI();
        $this->emit('item-deleted', 'Tipo de Trabajo eliminado');
    }

    public function resetUI()
    {
        $this->name = '';
        $this->status = 'Elegir';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
