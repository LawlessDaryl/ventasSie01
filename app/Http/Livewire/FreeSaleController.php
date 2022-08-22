<?php

namespace App\Http\Livewire;
use App\Models\FreePlanes;

use Livewire\Component;

class FreeSaleController extends Component
{
    public $freeplan_id;
    public function render()
    {
        return view('livewire.freesale.freesale', [
            'listplans' => FreePlanes::all()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function showmodalnewsale()
    {
        $this->emit('show-modal-sale');
    }
    
}
