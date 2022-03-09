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

    public $nombre, $description, $status, $image, $precioEntera, $precioPerfil, $selected_id,
        $pageTitle, $componentName, $search;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Plataformas';
        $this->nombre = '';
        $this->description = '';
        $this->status = 'Elegir';
        $this->precioEntera = '';
        $this->precioPerfil = '';
        $this->selected_id = 0;
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $plataformas = Platform::where('nombre', 'like', '%' . $this->nombre . '%')
                ->orWhere('ACTIVO', 'like', '%' . $this->status . '%')
                ->orderBy('id', 'desc')
                ->paginate($this->pagination);
        } else {
            $plataformas = Platform::orderBy('id', 'desc')
                ->paginate($this->pagination);
        }
        return view(
            'livewire.plataformas.component',
            [
                'platforms' => $plataformas
            ]
        )
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Store()
    {
        $rules = [
            'nombre' => 'required|unique:platforms|min:3',
            'status' => 'required|not_in:Elegir',
            'precioEntera' => 'required',
            'precioPerfil' => 'required',

        ];
        $messages = [
            'nombre.required' => 'El nombre de la plataforma es requerido',
            'nombre.unique' => 'Ya existe el nombre de la plataforma',
            'nombre.min' => 'El nombre de la plataforma debe tener al menos 3 caracteres',
            'status.required' => 'El estado de la plataforma es requerido',
            'status.not_in' => 'Eliga un valor distinto a Elegir',
            'precioEntera.required' => 'El precio de las cuentas Enteras de esta plataforma es requerido',
            'precioPerfil.required' => 'El precio individual de los Perfiles de esta plataforma es requerido',
        ];
        $this->validate($rules, $messages);

        $plataf = Platform::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->description,
            'estado' => $this->status,
            'precioEntera' => $this->precioEntera,
            'precioPerfil' => $this->precioPerfil,
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/plataformas', $customFileName);
            $plataf->image = $customFileName;
            $plataf->save();
        } else {
            $plataf->image = 'noimage.jpg';
            $plataf->save();
        }

        $this->resetUI();
        $this->emit('item-added', 'Plataforma Registrada');
    }
    public function Edit(Platform $plat)
    {
        $this->selected_id = $plat->id;
        $this->nombre = $plat->nombre;
        $this->description = $plat->descripcion;
        $this->status = $plat->estado;
        $this->precioEntera = $plat->precioEntera;
        $this->precioPerfil = $plat->precioPerfil;
        $this->image = null;

        $this->emit('show-modal', 'show modal!');
    }

    public function Update()
    {
        $rules = [
            'nombre' => "required|unique:platforms,nombre,{$this->selected_id}",
            'status' => 'required|not_in:Elegir',
            'precioEntera' => 'required',
            'precioPerfil' => 'required',

        ];
        $messages = [
            'nombre.required' => 'El nombre de la plataforma es requerido',
            'nombre.unique' => 'Ya existe el nombre de la plataforma',
            'nombre.min' => 'El nombre de la plataforma debe tener al menos 3 caracteres',
            'status.required' => 'El estado de la plataforma es requerido',
            'status.not_in' => 'Eliga un valor distinto a Elegir',
            'precioEntera.required' => 'El precio de las cuentas Enteras de esta plataforma es requerido',
            'precioPerfil.required' => 'El precio individual de los Perfiles de esta plataforma es requerido',
        ];
        $this->validate($rules, $messages);

        $plataf = Platform::find($this->selected_id);

        $plataf->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->description,
            'estado' => $this->status,
            'precioEntera' => $this->precioEntera,
            'precioPerfil' => $this->precioPerfil,
        ]);
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/plataformas', $customFileName);
            $imageTemp = $plataf->image;
            $plataf->image = $customFileName;
            $plataf->save();

            if ($imageTemp != null) {
                if (file_exists('storage/plataformas/' . $imageTemp)) {
                    unlink('storage/plataformas/' . $imageTemp);
                }
            }
        }

        $this->resetUI();
        $this->emit('item-updated', 'Plataforma Actualizada');
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Platform $plataform)
    {
        $imageTemp = $plataform->image;
        $plataform->delete();

        if ($imageTemp != null) {
            if (file_exists('storage/plataformas/' . $imageTemp)) {
                unlink('storage/plataformas/' . $imageTemp);
            }
        }

        $this->resetUI();
        $this->emit('item-deleted', 'Plataforma eliminada');
    }

    public function resetUI()
    {
        $this->nombre = '';
        $this->description = '';
        $this->status = 'Elegir';
        $this->precioEntera = '';
        $this->precioPerfil = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
