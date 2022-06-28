<?php

namespace App\Http\Livewire;

use App\Models\Origen;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class OrigenController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public  $search, $nombre, $selected_id;
    public  $pageTitle, $componentName;
    private $pagination = 5;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Orígenes';
        $this->selected_id = 0;
    }
    public function render()
    {
        if (strlen($this->search) > 0)
            $origen = Origen::where('nombre', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $origen = Origen::orderBy('id', 'desc')->paginate($this->pagination);
        return view('livewire.origen.component', [
            'data' => $origen,
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Agregar()
    {
        $this->resetUI();
        $this->emit('show-modal', 'show modal!');
    }
    
    public function Store()
    {
        $rules = [
            'nombre' => 'required|unique:origens',
        ];
        $messages = [
            'nombre.required' => 'Nombre del orígen requerido.',
            'nombre.unique' => 'El nombre del orígen debe ser único.',
        ];
        $this->validate($rules, $messages);

        Origen::create([
            'nombre' => $this->nombre,
        ]);
        
        $this->resetUI();
        $this->emit('item-added', 'Orígen Registrado');
    }
    public function Edit(Origen $origen)
    {
        $this->selected_id = $origen->id;
        $this->nombre = $origen->nombre;


        $this->emit('show-modal', 'show modal!');
    }
    public function Update()
    {
        $rules = [
            'nombre' => "required|unique:origens,nombre,{$this->selected_id}",
        ];
        $messages = [
            'nombre.required' => 'Nombre del orígen requerido.',
            'nombre.unique' => 'El nombre del orígen debe ser único.',
        ];
        $this->validate($rules, $messages);

        $orig = Origen::find($this->selected_id);
        $orig->update([
            'nombre' => $this->nombre,
        ]);
        $orig->save();

        $this->resetUI();
        $this->emit('item-updated', 'Orígen Actualizado');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Origen $origen)
    {

        $origen->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Orígen Eliminado');
    }
    public function resetUI()
    {
        $this->nombre = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
