<?php

namespace App\Http\Livewire;

use App\Models\Unidad;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class UnidadesController extends Component
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
        $this->componentName = 'Unidades';
        $this->selected_id = 0;
    }


    public function render()
    {
        
            if (strlen($this->search) > 0)
                $uni = Unidad::select('unidads.*')
                ->where('nombre', 'like', '%' . $this->search . '%')
                ->paginate($this->pagination);
            else
            $uni = Unidad::select('unidads.*')
            ->paginate($this->pagination);

            return view('livewire.unidad.component', [
                'data_unidad' => $uni
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

        Unidad::create([
            'nombre' => $this->nombre
        ]);

        $this->resetUI();
        $this->emit('unidad-added', 'Unidad Registrada');
    }
    public function Edit(Unidad $unity)
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
        $uni = Unidad::find($this->selected_id);
        $uni->update([
            'nombre' => $this->nombre,
            
        ]);
        $uni->save();

        $this->resetUI();
        $this->emit('unidad-updated', 'Unidad Actualizada');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Unidad $uni)
    {
        $uni->delete();
        $this->resetUI();
        $this->emit('unidad-deleted', 'Unidad Eliminada');
    }

    public function resetUI()
    {
        $this->nombre = '';
        $this->selected_id=0;
       
    }
}
