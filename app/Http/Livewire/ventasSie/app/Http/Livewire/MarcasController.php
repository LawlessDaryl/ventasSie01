<?php

namespace App\Http\Livewire;

use App\Models\Marca;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MarcasController extends Component
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
        $this->componentName = 'Marcas';
        $this->selected_id = 0;
    }

    public function render()
    {
        if (strlen($this->search) > 0)
                $marcas = Marca::select('marcas.*')
                ->where('nombre', 'like', '%' . $this->search . '%')->paginate($this->pagination);
            else
            $marcas = Marca::select('marcas.*')->paginate($this->pagination);

            return view('livewire.marca.component', [
                'marcas' => $marcas
            ])
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function Store()
    {
        $rules = [
            'nombre' => 'required|unique:unidads',
            
        ];
        $messages = [
            'nombre.required' => 'El nombre de la unidad es requerido.',
            'nombre.unique' => 'Ya existe una unidad con ese nombre.',
        ];
        $this->validate($rules, $messages);

        Marca::create([
            'nombre' => $this->nombre
        ]);

        $this->resetUI();
        $this->emit('marca-added', 'Marca Registrada');
    }
    public function Edit(Marca $unity)
    {
        $this->selected_id = $unity->id;
        $this->nombre = $unity->nombre;
        
       

        $this->emit('show-modal', 'show modal!');
    }
    public function Update()
    {
        $rules = [
            'nombre' => 'required'
        ];
        $messages = [
            'nombre.required' => 'El nombre de la unidad es requerido, ingrese la unidad.',
            

        ];
        $this->validate($rules, $messages);
        $uni = Marca::find($this->selected_id);
        $uni->update([
            'nombre' => $this->nombre,
            
        ]);
        $uni->save();

        $this->resetUI();
        $this->emit('marca-updated', 'Marca Actualizada');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Marca $uni)
    {
        $uni->delete();
        $this->resetUI();
        $this->emit('marca-deleted', 'Marca Eliminada');
    }

    public function resetUI()
    {
        $this->nombre = '';
        $this->selected_id=0;
       
    }
}
