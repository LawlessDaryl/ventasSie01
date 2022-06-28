<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CatProdService;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class CatProdServiceController extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $nombre, $search, $estado, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = 'LISTADO';
        $this->componentName = 'CATEGORÍAS DE EQUIPOS EN EL SERVICIO';
        $this->estado = 'Elegir';
        $this->selected_id = 0;
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search) > 0)
            $data = CatProdService::where('nombre', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $data = CatProdService::orderBy('id', 'desc')->paginate($this->pagination);
        return view('livewire.categoria_producto_servicio.component', ['categories' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit($id)
    {
        $record = CatProdService::find($id, ['id', 'nombre', 'estado']);
        $this->nombre = $record->nombre;
        $this->selected_id = $record->id;
        $this->estado = $record->estado;

        $this->emit('show-modal', 'show modal!');
    }
    public function Store()
    {
        $rules = [
            'nombre' => 'required|unique:cat_prod_services|min:1',
            'estado' => 'required|not_in:Elegir'
    ];
        $messages = [
            'nombre.required' => 'El nombre de la categoría es requerido',
            'nombre.unique' => 'Ya existe el nombre de la categoría',
            'nombre.min' => 'El nombre de la categoría debe tener al menos 3 caracteres',
            'estado.required' => 'Selecciona el estado de la categoria'
        ];
        $this->validate($rules, $messages);

        $category = CatProdService::create([
            'nombre' => $this->nombre,
            'estado' => $this->estado,
        ]);

  
        $this->resetUI();
        $this->emit('item-added', 'Categoría Registrada');
    }


    public function Update()
    {
        $rules = [
            'nombre' => "required|unique:cat_prod_services,nombre,{$this->selected_id}",
            'nombre' => 'required|min:1',
            'estado' => 'required|not_in:Elegir'
    ];
        $messages = [
            'nombre.required' => 'El nombre de la categoría es requerido',
            'nombre.unique' => 'Ya existe el nombre de la categoría',
            'nombre.min' => 'El nombre de la categoría debe tener al menos 3 caracteres',
            'estado.required' => 'Selecciona el estado de la categoria'
        ];
        $this->validate($rules, $messages);
        $category = CatProdService::find($this->selected_id);

        $category->update([
            'nombre' => $this->nombre,
            'estado' => $this->estado,
        ]);


        $this->resetUI();
        $this->emit('item-updated', 'Categoria Actualizada');
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(CatProdService $category)
    {
        
        $category->delete();
        
        $this->resetUI();
        $this->emit('item-deleted', 'Categoria eliminada');
    }

    public function resetUI()
    {
        $this->nombre = '';
        $this->estado = 'Elegir';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
