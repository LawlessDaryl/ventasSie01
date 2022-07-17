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
use App\Models\Sucursal;
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
    //Tipo del Servicio (Pendiente,Proceso,Terminado, etc...)
    public $type;
    //id de la sucursal
    public $sucursal_id;
    // Categorias de los Servicios (Combo en la Vista)
    public $catprodservid;

    use WithPagination;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->paginacion = 20;
        $this->type = "PENDIENTE";
        $this->sucursal_id = $this->idsucursal();
        $this->catprodservid = "Todos";
    }
    public function render()
    {
        if($this->sucursal_id != "Todos")
        {
            if($this->type == "PENDIENTE")
            {
                if ($this->catprodservid == 'Todos')
                {
                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                    ->select("order_services.id as codigo",
                    "order_services.created_at as fechacreacion",
                    "c.nombre as nombrecliente",
                    "mov.import as importe",
                    DB::raw('0 as num'),
                    DB::raw('0 as servicios'))
                    ->where('order_services.status', 'ACTIVO')
                    ->where('mov.type', "PENDIENTE")
                    ->where('mov.status', 'ACTIVO')
                    ->where('s.sucursal_id',$this->sucursal_id)
                    ->groupBy("order_services.id")
                    ->orderBy("order_services.id","desc")
                    ->paginate($this->paginacion);
        
        
                    $x = 1;
                    foreach ($orden_de_servicio as $os)
                    {
                        //Numeración de Paginación
                        if($orden_de_servicio->currentPage() != 1)
                        {
                            $os->num = (($orden_de_servicio->currentPage() - 1) * $this->paginacion) + $x++;
                        }
                        else
                        {
                            $os->num = $x++;
                        }
        
                        //Obtener los servicios de la orden de servicio
                        $os->servicios = $this->detalle_orden_de_servicio($os->codigo);
                    }
                }
                else
                {

                }
            }
            else
            {

            }
        }
        else
        {

        }



        return view('livewire.order_service.component', [
            'orden_de_servicio' => $orden_de_servicio,
            'listasucursales' => Sucursal::all(),
            'categorias' => CatProdService::orderBy('nombre', 'asc')->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    //Obtener el detalle de servicios a travez del id de la orden de servicio
    public function detalle_orden_de_servicio($id_orden_de_servicio)
    {
        $servicios =  Service::join('order_services as os', 'os.id', 'services.order_service_id')
        ->join('mov_services as ms', 'services.id', 'ms.service_id')
        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
        ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
        ->select('cps.nombre as nombrecategoria',
        'services.detalle as detalle',
        'mov.type as estado',
        'services.falla_segun_cliente as falla_segun_cliente',
        'services.fecha_estimada_entrega as fecha_estimada_entrega',
        'services.marca as marca')
        ->where('mov.type', "PENDIENTE")
        ->where('mov.status', 'ACTIVO')
        ->where('services.order_service_id', $id_orden_de_servicio)
        ->get();
        return $servicios;
    }
    //Obtener el Id de la Sucursal Donde esta el Usuario
    public function idsucursal()
    {
        $idsucursal = User::join("sucursal_users as su","su.user_id","users.id")
        ->select("su.sucursal_id as id","users.name as n")
        ->where("users.id",Auth()->user()->id)
        ->where("su.estado","ACTIVO")
        ->get()
        ->first();
        return $idsucursal->id;
    }
}
