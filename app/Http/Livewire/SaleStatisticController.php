<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SaleStatisticController extends Component
{
    public function render()
    {
        return view('livewire.sales.salestatistic')
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
