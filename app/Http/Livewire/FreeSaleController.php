<?php

namespace App\Http\Livewire;
use App\Models\FreePlans;
use App\Models\FreeSale;
use App\Models\Movimiento;
use App\Models\User;
use Livewire\Component;

class FreeSaleController extends Component
{

    public $nameclient, $phone, $idgame, $alias, $freeplan_id, $cryptocurrencies;
    public function render()
    {
        return view('livewire.freesale.freesale', [
            'listplans' => FreePlans::all(),
            'listsales' => FreeSale::all()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function showmodalnewsale()
    {
        $this->emit('show-modal-sale');
    }
    public function savesale()
    {
        $mov = Movimiento::create([
            'type' => 'FREEFIRE',
            'import'=> 10,
            'user_id'=> Auth()->user()->id
        ]);
        
        $mov->save();


        $sale = FreeSale::create([
            'nameclient' => $this->nameclient,
            'phone'=>$this->phone,
            'idaccount'=>$this->idgame,
            'alias'=> $this->alias,
            'observation'=> "Ninguna",
            'free_plan_id'=> $this->freeplan_id,
            'sucursals_id'=> $this->idsucursal(),
            'user_id'=> Auth()->user()->id,
            'movimiento_id'=> $mov->id,
            'cartera_id'=> 1,
        ]);

        
        $sale->save();
    }
    
    //Obtener el Id de la Sucursal Donde esta el Usuario
    public function idsucursal()
    {
        $idsucursal = User::join("sucursal_users as su","su.user_id","users.id")
        ->select("su.sucursal_id as id","users.name as n")
        ->where("users.id", Auth()->user()->id)
        ->where("su.estado","ACTIVO")
        ->get()
        ->first();
        return $idsucursal->id;
    }
    
}
