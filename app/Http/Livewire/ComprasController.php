<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ComprasController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public  $nro_compra;

    private $pagination = 5;
    public function mount()
    {
        $this->nro_compra = 00200;
     
    }
    public function render()
    {
        return view('livewire.compras.component')
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
