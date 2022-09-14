<?php

namespace App\Http\Livewire;

use App\Models\CarteraMovCategoria;
use Livewire\Component;
use Livewire\WithPagination;

class CarteraMovCategoriaController extends Component
{
    public $nombrecategoria, $detallecategoria, $pagination, $mensaje_toast;

    use WithPagination;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pagination = 10;
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
        $this->emit('nuevacategoria-show');
    }
    public function save()
    {
        CarteraMovCategoria::create([
            'nombre' => $this->nombrecategoria,
            'detalle' => $this->detallecategoria
        ]);
        $this->mensaje_toast = "¡Categoria: " . $this->nombrecategoria . " creada exitósamente!";
        $this->resetUI();
        $this->emit('nuevacategoria-hide');
    }
    public function resetUI()
    {
        $this->nombrecategoria = "";
        $this->detallecategoria = "";
    }
}
