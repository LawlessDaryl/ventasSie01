<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SaleStatisticController extends Component
{
    public $numero;
    public function mount()
    {
        $this->numero = 40;
    }
    public function render()
    {
        return view('livewire.sales.salestatistic')
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
