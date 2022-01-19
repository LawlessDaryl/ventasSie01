<?php

namespace App\Http\Livewire;

use App\Models\Platform;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PlataformasController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $nombre, $description, $status, $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Plataformas';
        $this->status = 'Elegir';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search) > 0)
            $data = Platform::where('nombre', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $data = Platform::orderBy('id', 'desc')->paginate($this->pagination);
        return view(
            'livewire.plataformas.component',[
                'platforms' => $data
            ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit(Platform $plat)
    {
        $this->nombre = $plat->nombre;
        $this->description = $plat->descripcion;
        $this->status = $plat->estado;
        $this->selected_id = $plat->id;
        $this->image = null;

        $this->emit('show-modal', 'show modal!');
    }
    public function Store()
    {
        
        $rules = [
            'nombre' => 'required|unique:platforms|min:3',
            'status' => 'required|not_in:elegir',

        ];
        $messages = [
            'nombre.required' => 'El nombre de la plataforma es requerido',
            'nombre.unique' => 'Ya existe el nombre de la plataforma',
            'nombre.min' => 'El nombre de la plataforma debe tener al menos 3 caracteres',
            'status.required' => 'El nombre de la plataforma es requerido',
            'status.not_in' => 'Eliga un valor distinto a Elegir',
        ];
        $this->validate($rules, $messages);

        $plataf = Platform::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->description,
            'estado' => $this->status
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/plataformas', $customFileName);
            $plataf->image = $customFileName;
            $plataf->save();
        }
        $this->resetUI();
        $this->emit('item-added', 'Plataforma Registrada');
    }


    public function Update()
    {
        $rules = [
            'nombre' => "required|unique:platforms,nombre,{$this->selected_id}",
            'status' => 'required|not_in:elegir',

        ];
        $messages = [
            'nombre.required' => 'El nombre de la plataforma es requerido',
            'nombre.unique' => 'Ya existe el nombre de la plataforma',
            'nombre.min' => 'El nombre de la plataforma debe tener al menos 3 caracteres',
            'status.required' => 'El nombre de la plataforma es requerido',
            'status.not_in' => 'Eliga un valor distinto a Elegir',
        ];
        $this->validate($rules, $messages);
        $plataf = Platform::find($this->selected_id);

        $plataf->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->description,
            'estado' => $this->status
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/plataformas', $customFileName);
            $imageName = $plataf->image;
            $plataf->image = $customFileName;
            $plataf->save();
            if ($imageName != null) {
                if (file_exists('storage/plataformas/' . $imageName)) {
                    unlink('storage/plataformas/' . $imageName);
                }
            }
        }
        $this->resetUI();
        $this->emit('item-updated', 'Plataforma Actualizada');
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Platform $plataform)
    {
        $imageName = $plataform->image;
        $plataform->delete();
        if ($imageName != null) {
            unlink('storage/plataformas/' . $imageName);
        }
        $this->resetUI();
        $this->emit('item-deleted', 'Plataforma eliminada');
    }

    public function resetUI()
    {
        $this->nombre = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
