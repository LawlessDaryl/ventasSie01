<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Sucursal;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CajasController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public  $search, $nombre, $estado, $sucursal_id, $selected_id;
    public  $pageTitle, $componentName;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Cajas';
        $this->sucursal_id = 'Elegir';
        $this->estado = 'Elegir';
        $this->selected_id = 0;
    }
    public function render()
    {
        if (strlen($this->search) > 0)
            $caja = Caja::join('sucursals as s', 's.id', 'cajas.sucursal_id')
            ->select('cajas.*', 's.name as sucursal')
            ->where('nombre', 'like', '%' . $this->search . '%')
            ->paginate($this->pagination);
        else
        $caja = Caja::join('sucursals as s', 's.id', 'cajas.sucursal_id')
        ->select('cajas.*', 's.name as sucursal')
        ->paginate($this->pagination);
        return view('livewire.cajas.component', [
            'data' => $caja,
            'sucursales' => Sucursal::orderBy('name', 'asc')->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function Store()
    {
        $rules = [
            'nombre' => 'required|unique:cajas',
            'sucursal_id' => 'required|not_in:Elegir',
            'estado' => 'required|not_in:Elegir'
        ];
        $messages = [
            'nombre.required' => 'El nombre de la caja es requerido.',
            'nombre.unique' => 'Ya existe una caja con ese nombre.',
            'sucursal_id.not_in' => 'Seleccione una sucursal diferente de Elegir',
            'estado.not_in' => 'Seleccione un estado diferente de Elegir',
        ];
        $this->validate($rules, $messages);

        Caja::create([
            'nombre' => $this->nombre,
            'estado' => $this->estado,
            'sucursal_id' => $this->sucursal_id
        ]);

        $this->resetUI();
        $this->emit('item-added', 'Caja Registrada');
    }
    public function Edit(Caja $caja)
    {
        $this->selected_id = $caja->id;
        $this->nombre = $caja->nombre;
        $this->estado = $caja->estado;
        $this->sucursal_id = $caja->sucursal_id;

        $this->emit('show-modal', 'show modal!');
    }
    public function Update()
    {
        $rules = [
            'nombre' => "required|unique:cajas,nombre,{$this->selected_id}",
            'sucursal_id' => 'required|not_in:Elegir',
            'estado' => 'required|not_in:Elegir'
        ];
        $messages = [
            'nombre.required' => 'El nombre de la caja es requerido.',
            'nombre.unique' => 'Ya existe una caja con ese nombre.',
            'sucursal_id.not_in' => 'Seleccione una sucursal diferente de Elegir',
            'estado.not_in' => 'Seleccione un estado diferente de Elegir',
        ];
        $this->validate($rules, $messages);
        $Caj = Caja::find($this->selected_id);
        $Caj->update([
            'nombre' => $this->nombre,
            'estado' => $this->estado,
            'sucursal_id' => $this->sucursal_id
        ]);
        $Caj->save();

        $this->resetUI();
        $this->emit('item-updated', 'Caja Actualizada');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Caja $caja)
    {
        $caja->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Caja Eliminada');
    }

    public function resetUI()
    {
        $this->nombre = '';
        $this->estado = 'Elegir';
        $this->sucursal_id = 'Elegir';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}

