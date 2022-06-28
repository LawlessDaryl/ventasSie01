<?php

namespace App\Http\Livewire;

use App\Models\ProcedenciaCliente;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProcedenciaController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public  $search, $procedencia, $estado, $selected_id;
    public  $pageTitle, $componentName;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Procedencias';
        $this->estado = 'Elegir';
        $this->selected_id = 0;
    }

    public function render()
    {
        if (strlen($this->search) > 0)
            $procedencia = ProcedenciaCliente::where('procedencia', 'like', '%' . $this->search . '%')
                ->paginate($this->pagination);
        else
            $procedencia = ProcedenciaCliente::orderBy('id', 'desc')
                ->paginate($this->pagination);
        return view('livewire.procedencia.component', [
            'data' => $procedencia,
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
            'procedencia' => 'required|unique:procedencia_clientes',
            'estado' => 'required|not_in:Elegir'
        ];
        $messages = [
            'procedencia.required' => 'El nombre de la procedencia es requerido.',
            'procedencia.unique' => 'El nombre de la procedencia debe ser único.',
            'estado.required' => 'El estado es requerido.',
            'estado.not_in' => 'El estado debe ser distinto de Elegir.'
        ];
        $this->validate($rules, $messages);

        ProcedenciaCliente::create([
            'procedencia' => $this->procedencia,
            'estado' => $this->estado
        ]);

        $this->resetUI();
        $this->emit('item-added', 'Procedencia Registrada');
    }

    public function Edit(ProcedenciaCliente $proced)
    {
        $this->selected_id = $proced->id;
        $this->procedencia = $proced->procedencia;
        $this->estado = $proced->estado;

        $this->emit('show-modal', 'show modal!');
    }

    public function Update()
    {
        $rules = [
            'procedencia' => "required|unique:procedencia_clientes,procedencia,{$this->selected_id}",
            'estado' => 'required|not_in:Elegir'
        ];
        $messages = [
            'procedencia.required' => 'El nombre de la procedencia es requerido.',
            'procedencia.unique' => 'El nombre de la procedencia debe ser único.',
            'estado.required' => 'El estado es requerido.',
            'estado.not_in' => 'El estado debe ser distinto de Elegir.'
        ];
        $this->validate($rules, $messages);

        $pro = ProcedenciaCliente::find($this->selected_id);

        $pro->update([
            'procedencia' => $this->procedencia,
            'estado' => $this->estado
        ]);

        $pro->save();

        $this->resetUI();
        $this->emit('item-updated', 'Procedencia Actualizada');
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(ProcedenciaCliente $pro)
    {
        $pro->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Procedencia Eliminada');
    }

    public function resetUI()
    {
        $this->procedencia = '';
        $this->estado = 'Elegir';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
