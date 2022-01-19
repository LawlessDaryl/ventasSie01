<?php

namespace App\Http\Livewire;

use App\Models\Comision;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ComisionesController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $nombre, $tipo, $monto_a, $monto_inicial, $monto_final, $comision, $por, $search,
    $selected_id, $pageTitle, $componentName, $porcentaje;
    private $pagination = 8;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Comisiones';
        $this->por = '';
        $this->porcentaje = 'Elegir';
        $this->tipo = 'Elegir';
        $this->monto_a = 'Ninguna';
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function render()
    {
        if (strlen($this->search) > 0)
            $data = Comision::where('nombre', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $data = Comision::orderBy('monto_inicial', 'asc')->paginate($this->pagination);

        return view('livewire.comisiones.component', [
            'data' => $data
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Store()
    {
        $rules = [
            'nombre' => 'required|unique:comisions',
            'tipo' => 'required|not_in:Elegir',
            'monto_inicial' => 'required_with:monto_final|integer|min:1|not_in:0',
            'monto_final' => 'required_with:monto_inicial|integer|gt:monto_inicial|min:1|not_in:0',
            'comision' => 'required|min:1|not_in:0',
            'porcentaje' => 'required|not_in:Elegir'
        ];
        $messages = [
            'nombre.required' => 'El nombre de la comision es requerido.',
            'nombre.unique' => 'Ya existe una comision con ese nombre.',
            'tipo.required' => 'El tipo es requerido.', 
            'tipo.not_in' => 'El tipo debe ser diferente de Elegir.',
            'monto_inicial.required_with' => 'Ingrese un monto válido.',
            'monto_inicial.min' => 'Ingrese una monto mayor a 0.',
            'monto_inicial.not_in' => 'Ingrese un monto válido.',
            'monto_inicial.integer' => 'El monto inicial debe ser un número.',
            'monto_final.required_with' => 'Ingrese un monto válido.',
            'monto_final.min' => 'Ingrese una monto mayor a 0.',
            'monto_final.not_in' => 'Ingrese un monto válido.',
            'monto_final.integer' => 'El monto final debe ser un número.',
            'monto_final.gt' => 'El monto final debe ser mayor al monto inicial.',
            'comision.required' => 'Ingrese una comisión válida.',
            'comision.min' => 'Ingrese una comision mayor a 0.',
            'comision.not_in' => 'Ingrese una comisión válida.',
            'porcentaje.required' => 'El porcentaje afectado es requerido.',
            'porcentaje.not_in' => 'El porcentaje debe ser diferente de Elegir.'
        ];
        $this->validate($rules, $messages);

        Comision::create([
            'nombre' => $this->nombre,
            'tipo' => $this->tipo,
            'monto_a' => $this->monto_a,
            'monto_inicial' => $this->monto_inicial,
            'monto_final' => $this->monto_final,
            'comision' => $this->comision,
            'porcentaje' => $this->porcentaje
        ]);

        $this->resetUI();
        $this->emit('item-added', 'Comisión Registrada');
    }

    public function Edit(Comision $comision)
    {
        $this->selected_id = $comision->id;
        $this->nombre = $comision->nombre;
        $this->tipo = $comision->tipo;
        $this->monto_a = $comision->monto_a;
        $this->monto_inicial = $comision->monto_inicial;
        $this->monto_final = $comision->monto_final;
        $this->comision = $comision->comision;
        $this->porcentaje = $comision->porcentaje;


        $this->emit('modal-show', 'show modal!');
    }

    public function Update()
    {
        $rules = [
            'nombre' => "required|unique:comisions,nombre,{$this->selected_id}",
            'tipo' => 'required|not_in:Elegir'
        ];
        $messages = [
            'nombre.required' => 'El nombre de la comisión es requerido.',
            'nombre.unique' => 'Ya existe una comisión con ese nombre.',
            'tipo.required' => 'El tipo es requerido.',
            'tipo.not_in' => 'El tipo debe ser diferente de Elegir.'
        ];
        $this->validate($rules, $messages);

        $comision = Comision::find($this->selected_id);

        $comision->update([
            'nombre' => $this->nombre,
            'tipo' => $this->tipo,
            'monto_a' => $this->monto_a,
            'monto_inicial' => $this->monto_inicial,
            'monto_final' => $this->monto_final,
            'comision' => $this->comision,
            'porcentaje' => $this->porcentaje
        ]);
        $comision->save();
        $this->resetUI();
        $this->emit('item-updated', 'Comisión Actualizada');
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Comision $comision)
    {
        $comision->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Comisión eliminada');
    }

    public function resetUI()
    {
        $this->nombre = '';
        $this->monto_a = 'Ninguna';
        $this->monto_inicial = '';
        $this->monto_final = '';
        $this->comision = '';
        $this->selected_id = 0;
        $this->porcentaje = 'Elegir';
        $this->tipo = 'Elegir';
        $this->resetValidation();
    }
}
