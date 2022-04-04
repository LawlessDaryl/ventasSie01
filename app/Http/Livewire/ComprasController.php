<?php

namespace App\Http\Livewire;

use App\Models\Compra;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ComprasController extends Component
{
    use WithPagination;
    use WithFileUploads;
    private $pagination = 5;
    public $fromDate,
            $toDate,
            $filtro,
            $criterio;

  public function paginationView()
     {
                return 'vendor.livewire.bootstrap';
     }

    


    public function render()
    {



        $data_compras= Compra::join('movimiento_compras as mov_compra','compras.id','mov_compra.id')
        ->join('movimientos as mov','mov_compra.id','mov.id')
        ->join('users','mov.user_id','users.id')
        ->join('providers as prov','compras.proveedor_id','prov.id')
        ->select('compras.*','compras.status as status_compra','mov.*','prov.nombre as nombre_prov','users.*')->paginate($this->pagination);
       // dd($data_compras);

        return view('livewire.compras.component',['data_compras'=>$data_compras])
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
