<?php

namespace App\Http\Livewire;

use App\Models\Compras;
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
        $hola="hola mundo";

    return view('livewire.compras.component',['data'=>$hola])
        ->extends('layouts.theme.app')
        ->section('content');
        
    }
}
