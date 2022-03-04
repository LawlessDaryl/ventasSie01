<?php

namespace App\Http\Livewire;

use App\Models\Unidad;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class ComprasController extends Component
{

    use WithPagination;
    use WithFileUploads;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function render()
    {
        $unidad = Unidad::select('unidads.*')
        ->paginate($this->pagination);

    return view('livewire.compras.component', [
        'data_unidad' => $unidad
    ])
        ->extends('layouts.theme.app')
        ->section('content');
        
    }
}
