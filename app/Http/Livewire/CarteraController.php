<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cartera;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CarteraController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public  $search, $nombre, $descripcion, $tipo, $selected_id, $caja_id;
    public  $pageTitle, $componentName;
    private $pagination = 5;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Carteras';
        $this->caja_id = 'Elegir';
        $this->tipo = 'Elegir';
        $this->selected_id = 0;
    }
    public function render()
    {
        if (strlen($this->search) > 0)
            $data = Cartera::join('cajas as c', 'c.id', 'carteras.caja_id')
                ->select('carteras.*', 'c.nombre as cajanombre')
                ->where('nombre', 'like', '%' . $this->search . '%')
                ->orwhere('tipo', 'like', '%' . $this->search . '%')
                ->paginate($this->pagination);
        else
            $data = Cartera::join('cajas as c', 'c.id', 'carteras.caja_id')
                ->select('carteras.*', 'c.nombre as cajanombre')
                ->orderBy('id', 'desc')
                ->paginate($this->pagination);
        return view('livewire.cartera.component', [
            'data' => $data,
            'cajas' => Caja::orderBy('nombre', 'asc')->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function Store()
    {
        $rules = [
            'nombre' => 'required|unique:carteras',
            'caja_id' => 'required|not_in:Elegir',
            'tipo' => 'required|not_in:Elegir'
        ];
        $messages = [
            'nombre.required' => 'Nombre de la cartera requerido.',
            'nombre.unique' => 'Ese nombre de cartera ya existe.',
            'caja_id.required' => 'La caja es requerido.',
            'caja_id.not_in' => 'La caja debe ser distinto de Elegir.',
            'tipo.required' => 'El tipo es requerido.',
            'tipo.not_in' => 'El tipo debe ser distinto de Elegir.'
        ];
        $this->validate($rules, $messages);

        Cartera::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'tipo' => $this->tipo,
            'caja_id' => $this->caja_id
        ]);

        $this->resetUI();
        $this->emit('item-added', 'Cartera Registrada');
    }
    public function Edit(Cartera $cartera)
    {
        $this->selected_id = $cartera->id;
        $this->nombre = $cartera->nombre;
        $this->descripcion = $cartera->descripcion;
        $this->tipo = $cartera->tipo;
        $this->caja_id = $cartera->caja_id;

        $this->emit('show-modal', 'show modal!');
    }
    public function Update()
    {
        $rules = [
            'nombre' => "required|unique:carteras,nombre,{$this->selected_id}",
            'caja_id' => 'required|not_in:Elegir',
            'tipo' => 'required|not_in:Elegir'
        ];
        $messages = [
            'nombre.required' => 'Nombre de la cartera requerido.',
            'nombre.unique' => 'Ese nombre de cartera ya existe.',
            'caja_id.required' => 'La caja es requerido.',
            'caja_id.not_in' => 'La caja debe ser distinto de Elegir.',
            'tipo.required' => 'El tipo es requerido.',
            'tipo.not_in' => 'El tipo debe ser distinto de Elegir.'
        ];
        $this->validate($rules, $messages);
        $cartera = Cartera::find($this->selected_id);
        $cartera->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'tipo' => $this->tipo,
            'caja_id' => $this->caja_id
        ]);
        $cartera->save();

        $this->resetUI();
        $this->emit('item-updated', 'Cartera Actualizada');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Cartera $cartera)
    {
        $cartera->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Cartera Eliminada');
    }

    public function resetUI()
    {
        $this->nombre = '';
        $this->descripcion = '';
        $this->tipo = '';
        $this->search = '';
        $this->caja_id = 'Elegir';
        $this->tipo = 'Elegir';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
