<?php

namespace App\Http\Livewire;

use App\Models\CarteraMovCategoria;
use Livewire\Component;
use Livewire\WithPagination;

class CarteraMovCategoriaController extends Component
{
    public $nombrecategoria, $detallecategoria, $tipo, $pagination, $mensaje_toast, $categoria_id;

    use WithPagination;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->categoria_id = null;
        $this->pagination = 10;
        $this->tipo = "Elegir";
    }

    public function render()
    {

        $data = CarteraMovCategoria::select("cartera_mov_categorias.*")
        ->paginate($this->pagination);


        return view('livewire.carteramovcategoria.carteramovcategoria', [
            'data' => $data
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function modalnuevacategoria()
    {
        $this->categoria_id = null;
        $this->emit('nuevacategoria-show');
    }
    //Guardando una nueva categoria
    public function save()
    {
        $rules = [
            'nombrecategoria' => "required|unique:cartera_mov_categorias,nombre",
            'tipo' => 'required|not_in:Elegir',
        ];
        $messages = [
            'nombrecategoria.required' => 'Nombre de la categoria es requerido.',
            'tipo.required' => 'La tipo es requerido.',
            'nombrecategoria.unique' => 'Ese nombre de la categoria ya existe.',
            'tipo.not_in' => 'Por favor seleccione un tipo'
        ];
        $this->validate($rules, $messages);

        CarteraMovCategoria::create([
            'nombre' => $this->nombrecategoria,
            'detalle' => $this->detallecategoria,
            'tipo' => $this->tipo
        ]);
        $this->mensaje_toast = "¡Categoria: " . $this->nombrecategoria . " creada exitósamente!";
        $this->resetUI();
        $this->emit('nuevacategoria-hide');
    }

    protected $listeners = ['anularcategoria' => 'Destroy'];


    public function modaleditar($id)
    {
        $this->categoria_id = $id;
        $categoria = CarteraMovCategoria::find($id);

        $this->nombrecategoria = $categoria->nombre;

        $this->detallecategoria = $categoria->detalle;
        
        $this->tipo = $categoria->tipo;



        $this->emit('nuevacategoria-show');
    }
    public function update()
    {
        $rules = [
            'nombrecategoria' => "required",
            'tipo' => 'required|not_in:Elegir',
        ];
        $messages = [
            'nombrecategoria.required' => 'Nombre de la categoria es requerido.',
            'tipo.required' => 'La tipo es requerido.',
            'tipo.not_in' => 'Por favor seleccione un tipo'
        ];
        $this->validate($rules, $messages);

        $categoria = CarteraMovCategoria::find($this->categoria_id);

        $categoria->update([
            'nombre' => $this->nombrecategoria,
            'detalle' => $this->detallecategoria,
            'tipo' => $this->tipo
        ]);
        $categoria->save();

        $this->resetUI();
        $this->mensaje_toast = "Categoria Actualizada Exitosamente";
        $this->emit('nuevacategoria-hide');
    }



    
    public function Destroy($id)
    {
        $categoria = CarteraMovCategoria::find($id);
        $categoria->update([
            'status' => 'INACTIVO',
        ]);
        $categoria->save();

        $this->resetUI();
        $this->mensaje_toast = $categoria->nombre;
        $this->emit('accion-ok');
    }
    
    public function reacctivar($id)
    {
        $categoria = CarteraMovCategoria::find($id);
        $categoria->update([
            'status' => 'ACTIVO',
        ]);
        $categoria->save();

        $this->resetUI();
        $this->mensaje_toast = "¡Categoria " . $categoria->nombre . " reactivada exitosamente!";
        $this->emit('accion-toast-ok');
    }
    //Regresando las variables a sus valores por defecto
    public function resetUI()
    {
        $this->nombrecategoria = "";
        $this->tipo = "Elegir";
        $this->detallecategoria = "";
        $this->categoria_id = null;
    }
}
