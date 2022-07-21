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

    //Variables para la ventana modal Detalles Servicio
    public $responsabletecnico, $nombrecliente, $celularcliente, $fechaestimadaentrega, $fallaseguncliente,
    $tipotrabajo, $detalleservicio, $falla, $diagnostico, $solucion, $precioservicio, $acuenta,
    $saldo, $estado, $categoriaservicio, $costo, $detallecosto;

    //Variable para almacenar todos los usuarios de servicios
    public $lista_de_usuarios;

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
        $this->lista_de_usuarios = $this->listarusuarios();
    }
    public function render()
    {
        $this->lista_de_usuarios = $this->listarusuarios();
        if($this->sucursal_id != "Todos")
        {
            if($this->type == "PENDIENTE")
            {
                if ($this->catprodservid == 'Todos')
                {
                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                    ->join('users as u', 'u.id', 'mov.user_id')
                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                    ->select("order_services.id as codigo",
                    "order_services.created_at as fechacreacion",
                    "c.nombre as nombrecliente",
                    'u.name as usuarioreceptor',
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
                if ($this->catprodservid == 'Todos')
                {
                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                    ->join('users as u', 'u.id', 'mov.user_id')
                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                    ->select("order_services.id as codigo",
                    "order_services.created_at as fechacreacion",
                    'u.name as usuarioreceptor',
                    "c.nombre as nombrecliente",
                    "mov.import as importe",
                    DB::raw('0 as num'),
                    DB::raw('0 as servicios'))
                    ->where('order_services.status', 'ACTIVO')
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
                        $os->servicios = $this->detalle_orden_de_servicio_modal($os->codigo);
                    }
                }
                else
                {

                }
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
        'services.id as idservicio',
        'mov.type as estado',
        'mov.import as importe',
        'services.falla_segun_cliente as falla_segun_cliente',
        'services.fecha_estimada_entrega as fecha_estimada_entrega',
        'services.marca as marca')
        ->where('mov.type', "PENDIENTE")
        ->where('mov.status', 'ACTIVO')
        ->where('services.order_service_id', $id_orden_de_servicio)
        ->get();
        return $servicios;
    }
    //Obtener el detalle de servicios a travez del id del Servicio
    public function detalle_orden_de_servicio_modal($id_orden_de_servicio)
    {
        $servicios =  Service::join('order_services as os', 'os.id', 'services.order_service_id')
        ->join('mov_services as ms', 'services.id', 'ms.service_id')
        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
        ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
        ->select('cps.nombre as nombrecategoria',
        'services.id as idservicio',
        'services.detalle as detalle',
        'mov.type as estado',
        'mov.import as importe',
        'services.falla_segun_cliente as falla_segun_cliente',
        'services.fecha_estimada_entrega as fecha_estimada_entrega',
        'services.marca as marca')
        ->where('mov.status', 'ACTIVO')
        ->where('services.order_service_id', $id_orden_de_servicio)
        ->get();


        return $servicios;

    }
    //Obtener el Id de la Sucursal donde esta el Usuario
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
    //Mostrar detalles del servicio en una Ventana Modal
    public function modalserviciodetalles($type, $idservicio)
    {
        $detallesservicio =  Service::join('order_services as os', 'os.id', 'services.order_service_id')
        ->join('mov_services as ms', 'services.id', 'ms.service_id')
        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
        ->join('clientes as c', 'c.id', 'cm.cliente_id')
        ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
        ->join('type_works as tw', 'tw.id', 'services.type_work_id')
        ->select('cps.nombre as nombrecategoria',
        'services.detalle as detalle',
        'mov.type as estado',
        'c.nombre as nombrecliente',
        'mov.on_account as acuenta',
        'mov.saldo as saldo',
        'c.celular as celularcliente',
        'services.falla_segun_cliente as falla_segun_cliente',
        'services.fecha_estimada_entrega as fecha_estimada_entrega',
        'services.detalle as detalleservicio',
        'services.costo as costo',
        'services.diagnostico as diagnostico',
        'services.solucion as solucion',
        'services.detalle_costo as detallecosto',
        'mov.import as precioservicio',
        'tw.name as tipotrabajo',
        'services.marca as marca')
        ->where('mov.type', $type)
        ->where('mov.status', 'ACTIVO')
        ->where('services.id', $idservicio)
        ->get()
        ->first();


        $this->estado = $type;
        $this->nombrecliente = $detallesservicio->nombrecliente;
        $this->celularcliente = $detallesservicio->celularcliente;
        $this->fechaestimadaentrega = $detallesservicio->fecha_estimada_entrega;
        $this->categoriaservicio = $detallesservicio->nombrecategoria;
        $this->detalleservicio = $detallesservicio->detalleservicio;
        $this->tipotrabajo = $detallesservicio->tipotrabajo;
        $this->precioservicio = $detallesservicio->precioservicio;
        $this->fallaseguncliente = $detallesservicio->falla_segun_cliente;
        $this->acuenta = $detallesservicio->acuenta;
        $this->saldo = $detallesservicio->saldo;
        $this->costo = $detallesservicio->costo;
        $this->detallecosto = $detallesservicio->detallecosto;
        $this->diagnostico = $detallesservicio->diagnostico;
        $this->solucion = $detallesservicio->solucion;
        
        $this->emit('show-sd', 'show modal!');
    }
    //Mostrar una lista de usuarios tecnicos para asignar un servicio en una Ventana Modal
    public function modalasignartecnico($idservicio)
    {
        //dd($this->lista_de_usuarios);
        $this->emit('show-asignartecnicoresponsable', 'show modal!');
    }
    //Listar los Usuarios para ser asignados a un servicio Pendiente en una Ventana Modal
    public function listarusuarios()
    {
        $listausuarios1 = User::join('movimientos as m', 'm.user_id', 'users.id')
        ->join('mov_services as ms', 'ms.movimiento_id', 'm.id')
        ->join('services as s', 's.id', 'ms.service_id')
        ->join('order_services as os', 'os.id', 's.order_service_id')
        ->join('model_has_roles as mhr', 'mhr.model_id', 'users.id')
        ->join('roles as r', 'r.id', 'mhr.role_id')
        ->join('role_has_permissions as rhp', 'rhp.role_id', 'r.id')
        ->join('permissions as p', 'p.id', 'rhp.permission_id')
        ->select("users.name as nombreusuario",DB::raw('0 as proceso'), DB::raw('0 as terminado'))
        ->where('os.status', 'ACTIVO')
        ->where('m.status', 'ACTIVO')
        ->where('p.name', 'Recepcionar_Servicio')
        ->distinct()
        ->orderBy('proceso','asc')
        ->get();



        $listausuarios2 = User::join('movimientos as m', 'm.user_id', 'users.id')
        ->join('mov_services as ms', 'ms.movimiento_id', 'm.id')
        ->join('services as s', 's.id', 'ms.service_id')
        ->join('order_services as os', 'os.id', 's.order_service_id')
        ->select("users.name as nombreusuario", "m.type as type")
        ->where('os.status', 'ACTIVO')
        ->where('m.type', "PROCESO")
        ->where('m.status', 'ACTIVO')
        ->get();

        $listausuarios3 = User::join('movimientos as m', 'm.user_id', 'users.id')
        ->join('mov_services as ms', 'ms.movimiento_id', 'm.id')
        ->join('services as s', 's.id', 'ms.service_id')
        ->join('order_services as os', 'os.id', 's.order_service_id')
        ->select("users.name as nombreusuario", "m.type as type")
        ->where('os.status', 'ACTIVO')
        ->where('m.type', "TERMINADO")
        ->where('m.status', 'ACTIVO')
        ->get();
        //dd($listausuarios);

        foreach($listausuarios1 as $l)
        {
            foreach($listausuarios2 as $n)
            {
                if($l->nombreusuario == $n->nombreusuario)
                {
                    $l->proceso = $l->proceso + 1;
                }
            }
            foreach($listausuarios3 as $z)
            {
                if($l->nombreusuario == $z->nombreusuario)
                {
                    $l->terminado = $l->terminado + 1;
                }
            }
        }

        $sorted = $listausuarios1->sortBy('proceso');

        return $sorted;
    }
}
