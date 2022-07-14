<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\CatProdService;
use App\Models\ClienteMov;
use App\Models\Movimiento;
use App\Models\MovService;
use App\Models\Service;
use App\Models\OrderService;
use App\Models\SubCatProdService;
use App\Models\TypeWork;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class OrderServiceController extends Component
{
    public $paginacion;
    use WithPagination;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->paginacion = 30;
    }
    public function render()
    {
        $orden_de_Servicio = OrderService::select("order_services.id as id",
        "order_services.created_at as fechacreacion",
        DB::raw('0 as num'))
        ->orderBy("order_services.id","desc")
        ->paginate($this->paginacion);


        $x = 1;
        foreach ($orden_de_Servicio as $os)
        {
            if($orden_de_Servicio->currentPage() != 1)
            {
                $os->num = (($orden_de_Servicio->currentPage() - 1) * $this->paginacion) + $x++;
            }
            else
            {
                $os->num = $x++;
            }
        }



        return view('livewire.order_service.component', [
            'orden_de_Servicio' => $orden_de_Servicio
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
}
