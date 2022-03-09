<?php

namespace App\Http\Livewire;

use App\Models\Module;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ModulosController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $description, $status, 
    $search,$selected_id, $pageTitle, $componentName, $condicion, $select;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Modulos';
        $this->status = 'Elegir';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search) > 0)
            $data = Module::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('status', 'like', '%' . $this->search . '%')
            ->paginate($this->pagination);
        else
            $data = Module::orderBy('id', 'desc')->paginate($this->pagination);
        
        return view(
            'livewire.modulos.component',[
                'modules' => $data
            ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit(Module $m)
    {
        $this->name = $m->name;
        $this->description = $m->description;
        $this->status = $m->status;
        $this->selected_id = $m->id;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store()
    {         
        $rules = [
            'name' => 'required|min:5|unique:modules',
            'status' => 'required|not_in:Elegir',

        ];
        $messages = [
            'name.required' => 'El nombre del modulo es requerido',
            'name.min' => 'El nombre del modulo debe tener al menos 5 caracteres',
            'name.unique' => 'El nombre del modulo ya esta registrado',
            'status.required' => 'El estado del modulo es requerido',
            'status.not_in' => 'Eliga un estado distinto a Elegir',            
        ];

        $this->validate($rules, $messages);
        
        DB::beginTransaction();

        try {

            Module::create([
                'name' => $this->name,
                'status' => $this->status,
                'description' => $this->description
            ]); 
            
            DB::commit();
            
            $this->resetUI();
            $this->emit('item-added', 'Módulo Registrado');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', $e->getMessage());
        }
    }

    public function Update()
    {
        $rules = [
            'name' => "required|min:5|unique:modules,name,{$this->selected_id}",
            'status' => 'required|not_in:Elegir',

        ];
        $messages = [
            'name.required' => 'El nombre del modulo es requerido',
            'name.min' => 'El nombre del modulo debe tener al menos 5 caracteres',
            'name.unique' => 'El nombre del modulo ya esta registrado',
            'status.required' => 'El estado del modulo es requerido',
            'status.not_in' => 'Eliga un estado distinto a Elegir',            
        ];
        $this->validate($rules, $messages);

        DB::beginTransaction();

        try {
            $modu = Module::find($this->selected_id);

            $modu->update([
                'name' => $this->name,
                'status' => $this->status,
                'description' => $this->description
            ]);

            DB::commit();
            
            $this->resetUI();
            $this->emit('item-added', 'Módulo Actualizado');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', $e->getMessage());
        }
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Module $m)
    {
        $m->delete();
        
        $this->resetUI();
        $this->emit('item-deleted', 'Módulo eliminado');
    }

    public function resetUI()
    {
        $this->name = '';
        $this->description = '';
        $this->status = 'Elegir';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}