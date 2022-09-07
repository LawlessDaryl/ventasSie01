<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\CatProdService;
use App\Models\ClienteMov;
use App\Models\Cliente;
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
    //Tipo de Fechas (Servicios de Hoy, Servicios por Fechas)
    public $tipofecha;
    //Fechas de Inicio y Fin
    public $dateFrom, $dateTo;
    //Variable para Ocultar o Mostrar mas Filtros
    public $masfiltros;
    //Lista de Usuarios en la Vista
    public $usuario;
    //Variable para buscar por Código o Nombre del Cliente
    public $search;


    //Variables para la (Ventana Modal) Detalles Servicio
    public $responsabletecnico, $nombrecliente, $celularcliente, $fechaestimadaentrega, $fallaseguncliente,
    $tipotrabajo, $detalleservicio, $falla, $diagnostico, $solucion, $precioservicio, $acuenta,
    $saldo, $estado, $categoriaservicio, $costo, $detallecosto, $tiposervicio;

    //Variable para almacenar todos los usuarios Técnico de servicios (Ventana Modal)
    public $lista_de_usuarios;

    //Id Servicio, Id Orden de Servicio
    public $id_servicio, $id_orden_de_servicio;

    //Variables para la Ventana Modal Editar Servicio
    public $edit_tipodetrabajo, $edit_categoriatrabajo, $edit_marca, $edit_detalle, $edit_fallaseguncliente, $edit_diagnostico, $edit_solucion;
    public $edit_fechaestimadaentrega, $edit_horaentrega, $edit_precioservicio, $edit_acuenta, $edit_saldo, $edit_costoservicio, $edit_motivocostoservicio;

    //Variable para mostrar el boton 'Terminar Servicio' en la Ventana Modal Editar Servicio
    public $mostrarterminar;

    //tipopago = guarda el id de la cartera :: estadocaja = guarda si se tiene una caja abierta
    public $tipopago, $estadocaja;

    //Variables para editar un servicio terminado
    public $edit_precioservicioterminado, $edit_acuentaservicioterminado, $edit_saldoterminado, $edit_costoservicioterminado, $edit_motivoservicioterminado, $edit_carteraservicioterminado;

    //Variables para cambiar técnico responsable
    public $id_usuario, $tipo;

    //Variables para mostrar tecnico responsable en los sweet alerts (Alertas JavaScript)
    public $alert_responsabletecnico;

    use WithPagination;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->paginacion = 10;
        $this->type = 'PENDIENTE';
        $this->sucursal_id = $this->idsucursal();
        $this->catprodservid = 'Todos';
        $this->tipofecha = 'hoy';
        $this->masfiltros = false;
        $this->usuario = 'Todos';
        $this->tipofecha = 'Todos';
        $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->lista_de_usuarios = $this->listarusuarios();
        $this->mostrarterminar = "No";

        //Variable que guarda el id de la cartera
        $this->tipopago = 'Elegir';

        //Verificando si el usuario tiene una caja abierta
        if($this->listarcarteras() == null)
        {
            $this->estadocaja = "cerrado";
        }
        else
        {
            $this->estadocaja = "abierto";
            //Listando todas las carteras disponibles para la caja abierta
            $listac = $this->listarcarteras();
            //Poniendo por defecto la primera cartera de tipo Cajafisica
            foreach($listac as $list)
                {
                    if($list->tipo == 'CajaFisica')
                    {
                        $this->tipopago = $list->idcartera;
                        break;
                    }
                    
                }
        }


        if(session('orderserv') != "")
        {
            $this->search = session('orderserv');
            session(['orderserv' => null]);
        }


    }
    public function render()
    {

        if(Auth::user()->hasPermissionTo('Asignar_Tecnico_Servicio'))
        {

        }
        else
        {
            if($this->type == 'PENDIENTE')
            {
                $this->usuario = 'Todos';
            }
            else
            {
                $this->usuario = Auth()->user()->id;
            }
        }





        //Para Actualizar Saldo en la Ventana Modal Editar Servicio
        $this->edit_saldo = $this->edit_precioservicio - $this->edit_acuenta;
        //Para Actualizar Saldo en la Ventana Modal Editar Servicio Terminado
        $this->edit_saldoterminado = $this->edit_precioservicioterminado - $this->edit_acuentaservicioterminado;

        //Listar a los usuarios tecnicos responsables
        $this->lista_de_usuarios = $this->listarusuarios();

        if (strlen($this->search) == 0)
        {
            if($this->sucursal_id != 'Todos')
            {
                if($this->type != 'Todos')
                {
                    if ($this->catprodservid == 'Todos')
                    {
                        if($this->usuario == 'Todos')
                        {
                            if($this->tipofecha == 'Todos')
                            {
                                $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                ->join('mov_services as ms', 'ms.service_id', 's.id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                ->select("order_services.id as codigo",
                                "order_services.created_at as fechacreacion",
                                "su.name as nombresucursal",
                                "order_services.type_service as tiposervicio",
                                "c.nombre as nombrecliente",
                                "c.id as idcliente",
                                'u.name as usuarioreceptor',
                                "mov.import as importe",
                                DB::raw('0 as servicios'))
                                ->where('order_services.status', 'ACTIVO')
                                ->where('mov.type', $this->type)
                                ->where('mov.status', 'ACTIVO')
                                ->where('s.sucursal_id',$this->sucursal_id)
                                ->groupBy("order_services.id")
                                ->orderBy("order_services.id","desc")
                                ->paginate($this->paginacion);
                    
                                foreach ($orden_de_servicio as $os)
                                {
                                    //Obtener los servicios de la orden de servicio
                                    $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
                                }
                            }
                            else
                            {
                                if($this->tipofecha == 'Dia')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.type', $this->type)
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('s.sucursal_id',$this->sucursal_id)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
                                    }
                                }
                                else
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.type', $this->type)
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('s.sucursal_id',$this->sucursal_id)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
                                    }
                                }
                            }
                        }
                        else
                        {
                            //Si selecciona un Usuario en Específico
    
                            if($this->type != 'ENTREGADO')
                            {
                                if($this->tipofecha == 'Todos')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->where('mov.type', $this->type)
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('mov.user_id', $this->usuario)
                                    ->where('s.sucursal_id',$this->sucursal_id)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
                                    }
                                }
                                else
                                {
                                    if($this->tipofecha == 'Dia')
                                    {
                                        $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.type', $this->type)
                                        ->where('mov.status', 'ACTIVO')
                                        ->where('mov.user_id', $this->usuario)
                                        ->where('s.sucursal_id',$this->sucursal_id)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->paginate($this->paginacion);
                            
                                        foreach ($orden_de_servicio as $os)
                                        {
                                            //Obtener los servicios de la orden de servicio
                                            $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
                                        }
                                    }
                                    else
                                    {
                                        $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.type', $this->type)
                                        ->where('mov.status', 'ACTIVO')
                                        ->where('mov.user_id', $this->usuario)
                                        ->where('s.sucursal_id',$this->sucursal_id)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->paginate($this->paginacion);
                            
                                        foreach ($orden_de_servicio as $os)
                                        {
                                            //Obtener los servicios de la orden de servicio
                                            $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
                                        }
                                    }
                                }
                            }
                            else
                            {
                                if($this->tipofecha == 'Todos')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->where('mov.type', 'TERMINADO')
                                    ->where('mov.status', 'INACTIVO')
                                    ->where('mov.user_id', $this->usuario)
                                    ->where('s.sucursal_id',$this->sucursal_id)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
                                    }
                                }
                                else
                                {
                                    if($this->tipofecha == 'Dia')
                                    {
                                        $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.type', 'TERMINADO')
                                        ->where('mov.status', 'INACTIVO')
                                        ->where('mov.user_id', $this->usuario)
                                        ->where('s.sucursal_id',$this->sucursal_id)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->paginate($this->paginacion);
                            
                                        foreach ($orden_de_servicio as $os)
                                        {
                                            //Obtener los servicios de la orden de servicio
                                            $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
                                        }
                                    }
                                    else
                                    {
                                        $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.type', 'TERMINADO')
                                        ->where('mov.status', 'INACTIVO')
                                        ->where('mov.user_id', $this->usuario)
                                        ->where('s.sucursal_id',$this->sucursal_id)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->paginate($this->paginacion);
                            
                                        foreach ($orden_de_servicio as $os)
                                        {
                                            //Obtener los servicios de la orden de servicio
                                            $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        //Si selecciona una categoria (Computadoras, Impresoras, Celulares, etc...) en específico
    
                        if($this->usuario == 'Todos')
                        {
                            if($this->tipofecha == 'Todos')
                            {
                                $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                ->join('mov_services as ms', 'ms.service_id', 's.id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                ->select("order_services.id as codigo",
                                "order_services.created_at as fechacreacion",
                                "su.name as nombresucursal",
                                "order_services.type_service as tiposervicio",
                                "c.nombre as nombrecliente",
                                "c.id as idcliente",
                                'u.name as usuarioreceptor',
                                "mov.import as importe",
                                DB::raw('0 as servicios'))
                                ->where('order_services.status', 'ACTIVO')
                                ->where('mov.type', $this->type)
                                ->where('mov.status', 'ACTIVO')
                                ->where('s.sucursal_id',$this->sucursal_id)
                                ->where('s.cat_prod_service_id', $this->catprodservid)
                                ->groupBy("order_services.id")
                                ->orderBy("order_services.id","desc")
                                ->paginate($this->paginacion);
                    
                                foreach ($orden_de_servicio as $os)
                                {
                                    //Obtener los servicios de la orden de servicio
                                    $os->servicios = $this->detalle_orden_de_servicio_categoria($this->type, $os->codigo, $this->catprodservid);
                                }
                            }
                            else
                            {
                                if($this->tipofecha == 'Dia')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.type', $this->type)
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('s.sucursal_id',$this->sucursal_id)
                                    ->where('s.cat_prod_service_id',$this->catprodservid)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_categoria($this->type, $os->codigo, $this->catprodservid);
                                    }
                                }
                                else
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.type', $this->type)
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('s.sucursal_id',$this->sucursal_id)
                                    ->where('s.cat_prod_service_id',$this->catprodservid)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_categoria($this->type, $os->codigo, $this->catprodservid);
                                    }
                                }
                            }
                        }
                        else
                        {
                            //Si selecciona un Usuario en Específico
                            if($this->type != 'ENTREGADO')
                            {
                                if($this->tipofecha == 'Todos')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->where('mov.type', $this->type)
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('mov.user_id', $this->usuario)
                                    ->where('s.sucursal_id',$this->sucursal_id)
                                    ->where('s.cat_prod_service_id',$this->catprodservid)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_categoria($this->type, $os->codigo, $this->catprodservid);
                                    }
                                }
                                else
                                {
                                    if($this->tipofecha == 'Dia')
                                    {
                                        $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.type', $this->type)
                                        ->where('mov.status', 'ACTIVO')
                                        ->where('mov.user_id', $this->usuario)
                                        ->where('s.sucursal_id',$this->sucursal_id)
                                        ->where('s.cat_prod_service_id',$this->catprodservid)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->paginate($this->paginacion);
                            
                                        foreach ($orden_de_servicio as $os)
                                        {
                                            //Obtener los servicios de la orden de servicio
                                            $os->servicios = $this->detalle_orden_de_servicio_categoria($this->type, $os->codigo, $this->catprodservid);
                                        }
                                    }
                                    else
                                    {
                                        $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.type', $this->type)
                                        ->where('mov.status', 'ACTIVO')
                                        ->where('mov.user_id', $this->usuario)
                                        ->where('s.sucursal_id',$this->sucursal_id)
                                        ->where('s.cat_prod_service_id',$this->catprodservid)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->paginate($this->paginacion);
                            
                                        foreach ($orden_de_servicio as $os)
                                        {
                                            //Obtener los servicios de la orden de servicio
                                            $os->servicios = $this->detalle_orden_de_servicio_categoria($this->type, $os->codigo, $this->catprodservid);
                                        }
                                    }
                                }
                            }
                            else
                            {
                                if($this->tipofecha == 'Todos')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->where('mov.type', 'TERMINADO')
                                    ->where('mov.status', 'INACTIVO')
                                    ->where('mov.user_id', $this->usuario)
                                    ->where('s.sucursal_id',$this->sucursal_id)
                                    ->where('s.cat_prod_service_id',$this->catprodservid)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_categoria($this->type, $os->codigo, $this->catprodservid);
                                    }
                                }
                                else
                                {
                                    if($this->tipofecha == 'Dia')
                                    {
                                        $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.type', 'TERMINADO')
                                        ->where('mov.status', 'INACTIVO')
                                        ->where('mov.user_id', $this->usuario)
                                        ->where('s.sucursal_id',$this->sucursal_id)
                                        ->where('s.cat_prod_service_id',$this->catprodservid)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->paginate($this->paginacion);
                            
                                        foreach ($orden_de_servicio as $os)
                                        {
                                            //Obtener los servicios de la orden de servicio
                                            $os->servicios = $this->detalle_orden_de_servicio_categoria($this->type, $os->codigo, $this->catprodservid);
                                        }
                                    }
                                    else
                                    {
                                        $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.type', 'TERMINADO')
                                        ->where('mov.status', 'INACTIVO')
                                        ->where('mov.user_id', $this->usuario)
                                        ->where('s.sucursal_id',$this->sucursal_id)
                                        ->where('s.cat_prod_service_id',$this->catprodservid)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->paginate($this->paginacion);
                            
                                        foreach ($orden_de_servicio as $os)
                                        {
                                            //Obtener los servicios de la orden de servicio
                                            $os->servicios = $this->detalle_orden_de_servicio_categoria($this->type, $os->codigo, $this->catprodservid);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                else
                {
                    //Si Selecciona Tipo de Servicio Todos
    
                    if ($this->catprodservid == 'Todos')
                    {
                        if($this->usuario == 'Todos')
                        {
                            if($this->tipofecha == 'Todos')
                            {
                                $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                ->join('mov_services as ms', 'ms.service_id', 's.id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                ->select("order_services.id as codigo",
                                "order_services.created_at as fechacreacion",
                                "su.name as nombresucursal",
                                "order_services.type_service as tiposervicio",
                                "c.nombre as nombrecliente",
                                "c.id as idcliente",
                                'u.name as usuarioreceptor',
                                "mov.import as importe",
                                DB::raw('0 as servicios'))
                                ->where('order_services.status', 'ACTIVO')
                                ->where('mov.status', 'ACTIVO')
                                ->where('s.sucursal_id',$this->sucursal_id)
                                ->groupBy("order_services.id")
                                ->orderBy("order_services.id","desc")
                                ->paginate($this->paginacion);
                    
                                foreach ($orden_de_servicio as $os)
                                {
                                    //Obtener los servicios de la orden de servicio
                                    $os->servicios = $this->detalle_orden_de_servicio_todos($os->codigo);
                                }
                            }
                            else
                            {
                                if($this->tipofecha == 'Dia')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('s.sucursal_id',$this->sucursal_id)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_todos($os->codigo);
                                    }
                                }
                                else
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('s.sucursal_id',$this->sucursal_id)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_todos($os->codigo);
                                    }
                                }
                            }
                        }
                        else
                        {
                            //Si selecciona un Usuario en Específico Salta
                            
                            if($this->tipofecha == 'Todos')
                                {
                                    //Obteniendo todas las ordenes de servicio que no sean Entregadas
                                    $aa = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->where('mov.user_id', $this->usuario)
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('mov.type', '<>', 'ENTREGADO')
                                    ->where('s.sucursal_id',$this->sucursal_id)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->get();


                                    //Obteniendo todas las ordenes de servicio que sean Terminadas e Inactivas
                                    $bb = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->where('mov.type', 'TERMINADO')
                                    ->where('mov.status', 'INACTIVO')
                                    ->where('mov.user_id', $this->usuario)
                                    ->where('s.sucursal_id',$this->sucursal_id)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->get();

                                    //Variable que almacenará a todos los ids de las ordenes de servicio de $aa y $bb
                                    $ids_orden_servicio[] = 0; 

                                    foreach ($aa as $a)
                                    {
                                        array_push($ids_orden_servicio, $a->codigo);
                                    }
                                    foreach ($bb as $b)
                                    {
                                        array_push($ids_orden_servicio, $b->codigo);
                                    }



                                    //Consulta de todas las ordenes de servicio que tengan los ids de $ids_orden_servicio[]
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->whereIn('order_services.id', $ids_orden_servicio)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);



                                    
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_todos($os->codigo);
                                    }
                                }
                                else
                                {
                                    if($this->tipofecha == 'Dia')
                                    {
                                        //Obteniendo todas las ordenes de servicio que no sean Entregadas
                                        $aa = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.user_id', $this->usuario)
                                        ->where('mov.status', 'ACTIVO')
                                        ->where('mov.type', '<>', 'ENTREGADO')
                                        ->where('s.sucursal_id',$this->sucursal_id)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->get();


                                        //Obteniendo todas las ordenes de servicio que sean Terminadas e Inactivas
                                        $bb = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.type', 'TERMINADO')
                                        ->where('mov.status', 'INACTIVO')
                                        ->where('mov.user_id', $this->usuario)
                                        ->where('s.sucursal_id',$this->sucursal_id)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->get();

                                        //Variable que almacenará a todos los ids de las ordenes de servicio de $aa y $bb
                                        $ids_orden_servicio[] = 0; 

                                        foreach ($aa as $a)
                                        {
                                            array_push($ids_orden_servicio, $a->codigo);
                                        }
                                        foreach ($bb as $b)
                                        {
                                            array_push($ids_orden_servicio, $b->codigo);
                                        }

                                        //Consulta de todas las ordenes de servicio que tengan los ids de $ids_orden_servicio[]
                                        $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->whereIn('order_services.id', $ids_orden_servicio)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->paginate($this->paginacion);
                            
                                        foreach ($orden_de_servicio as $os)
                                        {
                                            //Obtener los servicios de la orden de servicio
                                            $os->servicios = $this->detalle_orden_de_servicio_todos($os->codigo);
                                        }
                                    }
                                    else
                                    {
                                        //Obteniendo todas las ordenes de servicio que no sean Entregadas
                                        $aa = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.user_id', $this->usuario)
                                        ->where('mov.status', 'ACTIVO')
                                        ->where('mov.type', '<>', 'ENTREGADO')
                                        ->where('s.sucursal_id',$this->sucursal_id)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->get();


                                        //Obteniendo todas las ordenes de servicio que sean Terminadas e Inactivas
                                        $bb = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.type', 'TERMINADO')
                                        ->where('mov.status', 'INACTIVO')
                                        ->where('mov.user_id', $this->usuario)
                                        ->where('s.sucursal_id',$this->sucursal_id)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->get();

                                        //Variable que almacenará a todos los ids de las ordenes de servicio de $aa y $bb
                                        $ids_orden_servicio[] = 0; 

                                        foreach ($aa as $a)
                                        {
                                            array_push($ids_orden_servicio, $a->codigo);
                                        }
                                        foreach ($bb as $b)
                                        {
                                            array_push($ids_orden_servicio, $b->codigo);
                                        }

                                        //Consulta de todas las ordenes de servicio que tengan los ids de $ids_orden_servicio[]
                                        $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->whereIn('order_services.id', $ids_orden_servicio)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->paginate($this->paginacion);

                                        foreach ($orden_de_servicio as $os)
                                        {
                                            //Obtener los servicios de la orden de servicio
                                            $os->servicios = $this->detalle_orden_de_servicio_todos($os->codigo);
                                        }
                                    }
                                }
                        }
                    }
                    else
                    {
                        //Si selecciona una categoria (Computadoras, Impresoras, Celulares, etc...) en específico
    
                        if($this->usuario == 'Todos')
                        {
                            if($this->tipofecha == 'Todos')
                            {
                                $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                ->join('mov_services as ms', 'ms.service_id', 's.id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                ->select("order_services.id as codigo",
                                "order_services.created_at as fechacreacion",
                                "su.name as nombresucursal",
                                "order_services.type_service as tiposervicio",
                                "c.nombre as nombrecliente",
                                "c.id as idcliente",
                                'u.name as usuarioreceptor',
                                "mov.import as importe",
                                DB::raw('0 as servicios'))
                                ->where('order_services.status', 'ACTIVO')
                                ->where('mov.status', 'ACTIVO')
                                ->where('s.sucursal_id',$this->sucursal_id)
                                ->where('s.cat_prod_service_id', $this->catprodservid)
                                ->groupBy("order_services.id")
                                ->orderBy("order_services.id","desc")
                                ->paginate($this->paginacion);
                    
                                foreach ($orden_de_servicio as $os)
                                {
                                    //Obtener los servicios de la orden de servicio
                                    $os->servicios = $this->detalle_orden_de_servicio_todos_categoria($os->codigo, $this->catprodservid);
                                }
                            }
                            else
                            {
                                if($this->tipofecha == 'Dia')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('s.sucursal_id',$this->sucursal_id)
                                    ->where('s.cat_prod_service_id',$this->catprodservid)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_todos_categoria($os->codigo, $this->catprodservid);
                                    }
                                }
                                else
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('s.sucursal_id',$this->sucursal_id)
                                    ->where('s.cat_prod_service_id',$this->catprodservid)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_todos_categoria($os->codigo, $this->catprodservid);
                                    }
                                }
                            }
                        }
                        else
                        {
                            //Si selecciona un Usuario en Específico Salta
    
                            if($this->tipofecha == 'Todos')
                            {
                                $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                ->join('mov_services as ms', 'ms.service_id', 's.id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                ->select("order_services.id as codigo",
                                "order_services.created_at as fechacreacion",
                                "su.name as nombresucursal",
                                "order_services.type_service as tiposervicio",
                                "c.nombre as nombrecliente",
                                "c.id as idcliente",
                                'u.name as usuarioreceptor',
                                "mov.import as importe",
                                DB::raw('0 as servicios'))
                                ->where('order_services.status', 'ACTIVO')
                                ->where('mov.status', 'ACTIVO')
                                ->where('mov.user_id', $this->usuario)
                                ->where('s.sucursal_id',$this->sucursal_id)
                                ->where('s.cat_prod_service_id',$this->catprodservid)
                                ->groupBy("order_services.id")
                                ->orderBy("order_services.id","desc")
                                ->paginate($this->paginacion);
                    
                                foreach ($orden_de_servicio as $os)
                                {
                                    //Obtener los servicios de la orden de servicio
                                    $os->servicios = $this->detalle_orden_de_servicio_todos_categoria($os->codigo, $this->catprodservid);
                                }
                            }
                            else
                            {
                                if($this->tipofecha == 'Dia')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('mov.user_id', $this->usuario)
                                    ->where('s.sucursal_id',$this->sucursal_id)
                                    ->where('s.cat_prod_service_id',$this->catprodservid)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_todos_categoria($os->codigo, $this->catprodservid);
                                    }
                                }
                                else
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('mov.user_id', $this->usuario)
                                    ->where('s.sucursal_id',$this->sucursal_id)
                                    ->where('s.cat_prod_service_id',$this->catprodservid)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_todos_categoria($os->codigo, $this->catprodservid);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            else
            {
                //Si Selecciona Todas las Sucursales
    
                if($this->type != 'Todos')
                {
                    if ($this->catprodservid == 'Todos')
                    {
                        if($this->usuario == 'Todos')
                        {
                            if($this->tipofecha == 'Todos')
                            {
                                $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                ->join('mov_services as ms', 'ms.service_id', 's.id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                ->select("order_services.id as codigo",
                                "order_services.created_at as fechacreacion",
                                "su.name as nombresucursal",
                                "order_services.type_service as tiposervicio",
                                "c.nombre as nombrecliente",
                                "c.id as idcliente",
                                'u.name as usuarioreceptor',
                                "mov.import as importe",
                                DB::raw('0 as servicios'))
                                ->where('order_services.status', 'ACTIVO')
                                ->where('mov.type', $this->type)
                                ->where('mov.status', 'ACTIVO')
                                ->groupBy("order_services.id")
                                ->orderBy("order_services.id","desc")
                                ->paginate($this->paginacion);
                    
                                foreach ($orden_de_servicio as $os)
                                {
                                    //Obtener los servicios de la orden de servicio
                                    $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
                                }
                            }
                            else
                            {
                                if($this->tipofecha == 'Dia')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.type', $this->type)
                                    ->where('mov.status', 'ACTIVO')
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
                                    }
                                }
                                else
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.type', $this->type)
                                    ->where('mov.status', 'ACTIVO')
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
                                    }
                                }
                            }
                        }
                        else
                        {
                            //Si selecciona un Usuario en Específico
    
                            if($this->type != 'ENTREGADO')
                            {
                                if($this->tipofecha == 'Todos')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->where('mov.type', $this->type)
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('mov.user_id', $this->usuario)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
                                    }
                                }
                                else
                                {
                                    if($this->tipofecha == 'Dia')
                                    {
                                        $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.type', $this->type)
                                        ->where('mov.status', 'ACTIVO')
                                        ->where('mov.user_id', $this->usuario)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->paginate($this->paginacion);
                            
                                        foreach ($orden_de_servicio as $os)
                                        {
                                            //Obtener los servicios de la orden de servicio
                                            $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
                                        }
                                    }
                                    else
                                    {
                                        $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.type', $this->type)
                                        ->where('mov.status', 'ACTIVO')
                                        ->where('mov.user_id', $this->usuario)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->paginate($this->paginacion);
                            
                                        foreach ($orden_de_servicio as $os)
                                        {
                                            //Obtener los servicios de la orden de servicio
                                            $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
                                        }
                                    }
                                }
                            }
                            else
                            {
                                if($this->tipofecha == 'Todos')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->where('mov.type', 'TERMINADO')
                                    ->where('mov.status', 'INACTIVO')
                                    ->where('mov.user_id', $this->usuario)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
                                    }
                                }
                                else
                                {
                                    if($this->tipofecha == 'Dia')
                                    {
                                        $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.type', 'TERMINADO')
                                        ->where('mov.status', 'INACTIVO')
                                        ->where('mov.user_id', $this->usuario)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->paginate($this->paginacion);
                            
                                        foreach ($orden_de_servicio as $os)
                                        {
                                            //Obtener los servicios de la orden de servicio
                                            $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
                                        }
                                    }
                                    else
                                    {
                                        $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.type', 'TERMINADO')
                                        ->where('mov.status', 'INACTIVO')
                                        ->where('mov.user_id', $this->usuario)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->paginate($this->paginacion);
                            
                                        foreach ($orden_de_servicio as $os)
                                        {
                                            //Obtener los servicios de la orden de servicio
                                            $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        //Si selecciona una categoria (Computadoras, Impresoras, Celulares, etc...) en específico
    
                        if($this->usuario == 'Todos')
                        {
                            if($this->tipofecha == 'Todos')
                            {
                                $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                ->join('mov_services as ms', 'ms.service_id', 's.id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                ->select("order_services.id as codigo",
                                "order_services.created_at as fechacreacion",
                                "su.name as nombresucursal",
                                "order_services.type_service as tiposervicio",
                                "c.nombre as nombrecliente",
                                "c.id as idcliente",
                                'u.name as usuarioreceptor',
                                "mov.import as importe",
                                DB::raw('0 as servicios'))
                                ->where('order_services.status', 'ACTIVO')
                                ->where('mov.type', $this->type)
                                ->where('mov.status', 'ACTIVO')
                                ->where('s.cat_prod_service_id', $this->catprodservid)
                                ->groupBy("order_services.id")
                                ->orderBy("order_services.id","desc")
                                ->paginate($this->paginacion);
                    
                                foreach ($orden_de_servicio as $os)
                                {
                                    //Obtener los servicios de la orden de servicio
                                    $os->servicios = $this->detalle_orden_de_servicio_categoria($this->type, $os->codigo, $this->catprodservid);
                                }
                            }
                            else
                            {
                                if($this->tipofecha == 'Dia')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.type', $this->type)
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('s.cat_prod_service_id',$this->catprodservid)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_categoria($this->type, $os->codigo, $this->catprodservid);
                                    }
                                }
                                else
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.type', $this->type)
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('s.cat_prod_service_id',$this->catprodservid)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_categoria($this->type, $os->codigo, $this->catprodservid);
                                    }
                                }
                            }
                        }
                        else
                        {
                            //Si selecciona un Usuario en Específico
    
                            if($this->type != 'ENTREGADO')
                            {
                                if($this->tipofecha == 'Todos')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->where('mov.type', $this->type)
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('mov.user_id', $this->usuario)
                                    ->where('s.cat_prod_service_id',$this->catprodservid)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_categoria($this->type, $os->codigo, $this->catprodservid);
                                    }
                                }
                                else
                                {
                                    if($this->tipofecha == 'Dia')
                                    {
                                        $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.type', $this->type)
                                        ->where('mov.status', 'ACTIVO')
                                        ->where('mov.user_id', $this->usuario)
                                        ->where('s.cat_prod_service_id',$this->catprodservid)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->paginate($this->paginacion);
                            
                                        foreach ($orden_de_servicio as $os)
                                        {
                                            //Obtener los servicios de la orden de servicio
                                            $os->servicios = $this->detalle_orden_de_servicio_categoria($this->type, $os->codigo, $this->catprodservid);
                                        }
                                    }
                                    else
                                    {
                                        $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.type', $this->type)
                                        ->where('mov.status', 'ACTIVO')
                                        ->where('mov.user_id', $this->usuario)
                                        ->where('s.cat_prod_service_id',$this->catprodservid)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->paginate($this->paginacion);
                            
                                        foreach ($orden_de_servicio as $os)
                                        {
                                            //Obtener los servicios de la orden de servicio
                                            $os->servicios = $this->detalle_orden_de_servicio_categoria($this->type, $os->codigo, $this->catprodservid);
                                        }
                                    }
                                }
                            }
                            else
                            {
                                if($this->tipofecha == 'Todos')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->where('mov.type', 'TERMINADO')
                                    ->where('mov.status', 'INACTIVO')
                                    ->where('mov.user_id', $this->usuario)
                                    ->where('s.cat_prod_service_id',$this->catprodservid)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_categoria($this->type, $os->codigo, $this->catprodservid);
                                    }
                                }
                                else
                                {
                                    if($this->tipofecha == 'Dia')
                                    {
                                        $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.type', 'TERMINADO')
                                        ->where('mov.status', 'INACTIVO')
                                        ->where('mov.user_id', $this->usuario)
                                        ->where('s.cat_prod_service_id',$this->catprodservid)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->paginate($this->paginacion);
                            
                                        foreach ($orden_de_servicio as $os)
                                        {
                                            //Obtener los servicios de la orden de servicio
                                            $os->servicios = $this->detalle_orden_de_servicio_categoria($this->type, $os->codigo, $this->catprodservid);
                                        }
                                    }
                                    else
                                    {
                                        $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                        ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                        ->join('mov_services as ms', 'ms.service_id', 's.id')
                                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                        ->join('users as u', 'u.id', 'mov.user_id')
                                        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                        ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                        ->select("order_services.id as codigo",
                                        "order_services.created_at as fechacreacion",
                                        "su.name as nombresucursal",
                                        "order_services.type_service as tiposervicio",
                                        "c.nombre as nombrecliente",
                                        "c.id as idcliente",
                                        'u.name as usuarioreceptor',
                                        "mov.import as importe",
                                        DB::raw('0 as servicios'))
                                        ->where('order_services.status', 'ACTIVO')
                                        ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                        ->where('mov.type', 'TERMINADO')
                                        ->where('mov.status', 'INACTIVO')
                                        ->where('mov.user_id', $this->usuario)
                                        ->where('s.cat_prod_service_id',$this->catprodservid)
                                        ->groupBy("order_services.id")
                                        ->orderBy("order_services.id","desc")
                                        ->paginate($this->paginacion);
                            
                                        foreach ($orden_de_servicio as $os)
                                        {
                                            //Obtener los servicios de la orden de servicio
                                            $os->servicios = $this->detalle_orden_de_servicio_categoria($this->type, $os->codigo, $this->catprodservid);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                else
                {
                    //Si Selecciona Tipo de Servicio Todos
    
                    if ($this->catprodservid == 'Todos')
                    {
                        if($this->usuario == 'Todos')
                        {
                            if($this->tipofecha == 'Todos')
                            {
                                $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                ->join('mov_services as ms', 'ms.service_id', 's.id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                ->select("order_services.id as codigo",
                                "order_services.created_at as fechacreacion",
                                "su.name as nombresucursal",
                                "order_services.type_service as tiposervicio",
                                "c.nombre as nombrecliente",
                                "c.id as idcliente",
                                'u.name as usuarioreceptor',
                                "mov.import as importe",
                                DB::raw('0 as servicios'))
                                ->where('order_services.status', 'ACTIVO')
                                ->where('mov.status', 'ACTIVO')
                                ->groupBy("order_services.id")
                                ->orderBy("order_services.id","desc")
                                ->paginate($this->paginacion);
                    
                                foreach ($orden_de_servicio as $os)
                                {
                                    //Obtener los servicios de la orden de servicio
                                    $os->servicios = $this->detalle_orden_de_servicio_todos($os->codigo);
                                }
                            }
                            else
                            {
                                if($this->tipofecha == 'Dia')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.status', 'ACTIVO')
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_todos($os->codigo);
                                    }
                                }
                                else
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.status', 'ACTIVO')
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_todos($os->codigo);
                                    }
                                }
                            }
                        }
                        else
                        {
                            //Si selecciona un Usuario en Específico Salta
    
                            if($this->tipofecha == 'Todos')
                            {
                                $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                ->join('mov_services as ms', 'ms.service_id', 's.id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                ->select("order_services.id as codigo",
                                "order_services.created_at as fechacreacion",
                                "su.name as nombresucursal",
                                "order_services.type_service as tiposervicio",
                                "c.nombre as nombrecliente",
                                "c.id as idcliente",
                                'u.name as usuarioreceptor',
                                "mov.import as importe",
                                DB::raw('0 as servicios'))
                                ->where('order_services.status', 'ACTIVO')
                                ->where('mov.status', 'ACTIVO')
                                ->where('mov.user_id', $this->usuario)
                                ->groupBy("order_services.id")
                                ->orderBy("order_services.id","desc")
                                ->paginate($this->paginacion);
                    
                                foreach ($orden_de_servicio as $os)
                                {
                                    //Obtener los servicios de la orden de servicio
                                    $os->servicios = $this->detalle_orden_de_servicio_todos($os->codigo);
                                }
                            }
                            else
                            {
                                if($this->tipofecha == 'Dia')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('mov.user_id', $this->usuario)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_todos($os->codigo);
                                    }
                                }
                                else
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('mov.user_id', $this->usuario)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_todos($os->codigo);
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        //Si selecciona una categoria (Computadoras, Impresoras, Celulares, etc...) en específico
    
                        if($this->usuario == 'Todos')
                        {
                            if($this->tipofecha == 'Todos')
                            {
                                $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                ->join('mov_services as ms', 'ms.service_id', 's.id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                ->select("order_services.id as codigo",
                                "order_services.created_at as fechacreacion",
                                "su.name as nombresucursal",
                                "order_services.type_service as tiposervicio",
                                "c.nombre as nombrecliente",
                                "c.id as idcliente",
                                'u.name as usuarioreceptor',
                                "mov.import as importe",
                                DB::raw('0 as servicios'))
                                ->where('order_services.status', 'ACTIVO')
                                ->where('mov.status', 'ACTIVO')
                                ->where('s.cat_prod_service_id', $this->catprodservid)
                                ->groupBy("order_services.id")
                                ->orderBy("order_services.id","desc")
                                ->paginate($this->paginacion);
                    
                                foreach ($orden_de_servicio as $os)
                                {
                                    //Obtener los servicios de la orden de servicio
                                    $os->servicios = $this->detalle_orden_de_servicio_todos_categoria($os->codigo, $this->catprodservid);
                                }
                            }
                            else
                            {
                                if($this->tipofecha == 'Dia')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('s.cat_prod_service_id',$this->catprodservid)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_todos_categoria($os->codigo, $this->catprodservid);
                                    }
                                }
                                else
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('s.cat_prod_service_id',$this->catprodservid)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_todos_categoria($os->codigo, $this->catprodservid);
                                    }
                                }
                            }
                        }
                        else
                        {
                            //Si selecciona un Usuario en Específico Salta
    
                            if($this->tipofecha == 'Todos')
                            {
                                $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                ->join('mov_services as ms', 'ms.service_id', 's.id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                ->select("order_services.id as codigo",
                                "order_services.created_at as fechacreacion",
                                "su.name as nombresucursal",
                                "order_services.type_service as tiposervicio",
                                "c.nombre as nombrecliente",
                                "c.id as idcliente",
                                'u.name as usuarioreceptor',
                                "mov.import as importe",
                                DB::raw('0 as servicios'))
                                ->where('order_services.status', 'ACTIVO')
                                ->where('mov.status', 'ACTIVO')
                                ->where('mov.user_id', $this->usuario)
                                ->where('s.cat_prod_service_id',$this->catprodservid)
                                ->groupBy("order_services.id")
                                ->orderBy("order_services.id","desc")
                                ->paginate($this->paginacion);
                    
                                foreach ($orden_de_servicio as $os)
                                {
                                    //Obtener los servicios de la orden de servicio
                                    $os->servicios = $this->detalle_orden_de_servicio_todos_categoria($os->codigo, $this->catprodservid);
                                }
                            }
                            else
                            {
                                if($this->tipofecha == 'Dia')
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00', Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('mov.user_id', $this->usuario)
                                    ->where('s.cat_prod_service_id',$this->catprodservid)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_todos_categoria($os->codigo, $this->catprodservid);
                                    }
                                }
                                else
                                {
                                    $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                    ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                    ->join('mov_services as ms', 'ms.service_id', 's.id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('users as u', 'u.id', 'mov.user_id')
                                    ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                    ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                    ->select("order_services.id as codigo",
                                    "order_services.created_at as fechacreacion",
                                    "su.name as nombresucursal",
                                    "order_services.type_service as tiposervicio",
                                    "c.nombre as nombrecliente",
                                    "c.id as idcliente",
                                    'u.name as usuarioreceptor',
                                    "mov.import as importe",
                                    DB::raw('0 as servicios'))
                                    ->where('order_services.status', 'ACTIVO')
                                    ->whereBetween('mov.created_at', [Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00', Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59'])
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('mov.user_id', $this->usuario)
                                    ->where('s.cat_prod_service_id',$this->catprodservid)
                                    ->groupBy("order_services.id")
                                    ->orderBy("order_services.id","desc")
                                    ->paginate($this->paginacion);
                        
                                    foreach ($orden_de_servicio as $os)
                                    {
                                        //Obtener los servicios de la orden de servicio
                                        $os->servicios = $this->detalle_orden_de_servicio_todos_categoria($os->codigo, $this->catprodservid);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        else
        {
            $orden_de_servicio = OrderService::join('services as s', 's.order_service_id', 'order_services.id')
                                ->join('sucursals as su', 'su.id', 's.sucursal_id')
                                ->join('mov_services as ms', 'ms.service_id', 's.id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
                                ->join('clientes as c', 'c.id', 'cm.cliente_id')
                                ->select("order_services.id as codigo",
                                "order_services.created_at as fechacreacion",
                                "su.name as nombresucursal",
                                "order_services.type_service as tiposervicio",
                                "c.nombre as nombrecliente",
                                "c.id as idcliente",
                                'u.name as usuarioreceptor',
                                "mov.import as importe",
                                DB::raw('0 as servicios'))
                                ->where('order_services.status', 'ACTIVO')
                                ->where('mov.status', 'ACTIVO')
                                ->where('c.nombre', 'like', '%' . $this->search . '%')
                                ->orWhere('order_services.id', 'like', '%' . $this->search . '%')
                                ->orWhere('s.detalle', 'like', '%' . $this->search . '%')
                                ->groupBy("order_services.id")
                                ->orderBy("order_services.id","desc")
                                ->paginate($this->paginacion);
                    
                                foreach ($orden_de_servicio as $os)
                                {
                                    //Obtener los servicios de la orden de servicio
                                    $os->servicios = $this->detalle_orden_de_servicio_todos($os->codigo);
                                }
        }


        return view('livewire.order_service.component', [
            'orden_de_servicio' => $orden_de_servicio,
            'listasucursales' => Sucursal::all(),
            'categorias' => CatProdService::orderBy('nombre', 'asc')->get(),
            'listatipotrabajo' => TypeWorK::orderBy('name', 'asc')->get(),
            'listacategoriatrabajo' => CatProdService::orderBy('nombre', 'asc')->get(),
            'marcas' => SubCatProdService::orderBy('name', 'asc')->groupBy('name')->get(),
            'listacarteras' => $this->listarcarteras(),
            'listacarterasg' => $this->listarcarterasg()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    //Buscar el Codigo de una Orden de Servicio desde otra Pagina
    public function buscarid($id)
    {
        session(['orderserv' => $id]);
        /* $this->opciones = 'TODOS'; */
        /* $this->redirect('orderservice'); */
        return redirect()->intended("orderservice");
    }
    //Mostrar u Ocultar Mas filtros en la Vista
    public function mostrarocultarmasfiltros()
    {
        if($this->masfiltros)
        {
            $this->usuario = 'Todos';
            $this->tipofecha = 'Todos';
            $this->masfiltros = false;
        }
        else
        {
            $this->masfiltros = true;
        }
    }
    //Obtener el detalle de servicios a travez del id de la orden de servicioy el tipo
    public function detalle_orden_de_servicio($tipo, $id_orden_de_servicio)
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
            'services.marca as marca',
            DB::raw('0 as responsabletecnico'),
            DB::raw('0 as tecnicoreceptor'))
            ->where('mov.type', $tipo)
            ->where('mov.status', 'ACTIVO')
            ->where('services.order_service_id', $id_orden_de_servicio)
            ->get();

            foreach ($servicios as $ser)
            {
                $ser->responsabletecnico = $this->obtener_tecnico_responsable($ser->idservicio);
                $ser->tecnicoreceptor = $this->obtener_tecnico_receptor($ser->idservicio);
            }



        return $servicios;
    }
    //Obtener el detalle de servicios a travez del id de la orden de servicio con categoria
    public function detalle_orden_de_servicio_categoria($tipo, $id_orden_de_servicio, $categoria)
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
            'services.marca as marca',
            DB::raw('0 as responsabletecnico'),
            DB::raw('0 as tecnicoreceptor'))
            ->where('mov.type', $tipo)
            ->where('mov.status', 'ACTIVO')
            ->where('services.order_service_id', $id_orden_de_servicio)
            ->where('services.cat_prod_service_id', $categoria)
            ->groupBy('services.id')
            ->get();

            foreach ($servicios as $ser)
            {
                $ser->responsabletecnico = $this->obtener_tecnico_responsable($ser->idservicio);
                $ser->tecnicoreceptor = $this->obtener_tecnico_receptor($ser->idservicio);
            }



        return $servicios;
    }
    //Obtener el detalle de servicios a travez del id de la orden de servicio en todos los tipos (Pendientes, Proceso, Terminados, etc...)
    public function detalle_orden_de_servicio_todos($id_orden_de_servicio)
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
            'services.marca as marca',
            DB::raw('0 as responsabletecnico'),
            DB::raw('0 as tecnicoreceptor'))
            ->where('mov.status', 'ACTIVO')
            ->where('services.order_service_id', $id_orden_de_servicio)
            ->groupBy('services.id')
            ->get();

            foreach ($servicios as $ser)
            {
                $ser->responsabletecnico = $this->obtener_tecnico_responsable($ser->idservicio);
                $ser->tecnicoreceptor = $this->obtener_tecnico_receptor($ser->idservicio);
            }



        return $servicios;
    }
    //Obtener el detalle de servicios a travez del id de la orden de servicio con categoria y Tipo Todos
    public function detalle_orden_de_servicio_todos_categoria($id_orden_de_servicio, $categoria)
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
            'services.marca as marca',
            DB::raw('0 as responsabletecnico'),
            DB::raw('0 as tecnicoreceptor'))
            ->where('mov.status', 'ACTIVO')
            ->where('services.order_service_id', $id_orden_de_servicio)
            ->where('services.cat_prod_service_id', $categoria)
            ->groupBy('services.id')
            ->get();

            foreach ($servicios as $ser)
            {
                $ser->responsabletecnico = $this->obtener_tecnico_responsable($ser->idservicio);
                $ser->tecnicoreceptor = $this->obtener_tecnico_receptor($ser->idservicio);
            }



        return $servicios;
    }
    //Obtener Técnico Receptor a travéz del id de una Orden de Servicio
    public function obtener_tecnico_receptor($idservicio)
    {
        $servicio = Service::find($idservicio);
        foreach ($servicio->movservices as $servmov)
        {
            if ($servmov->movs->type == 'PENDIENTE')
            {
                return User::find($servmov->movs->user_id)->name;
                break;
            }
        }
    }
    //Obtener Técnico Responsable a travéz del id de un servicio
    public function obtener_tecnico_responsable($idservicio)
    {
        $servicio = Service::find($idservicio);
        foreach ($servicio->movservices as $servmov)
        {
            if($servmov->movs->type == 'PENDIENTE' && $servmov->movs->status == 'ACTIVO')
            {
                return "No Asignado";
            }
            else
            {

                if ($servmov->movs->type == 'PROCESO'  && $servmov->movs->status == 'ACTIVO')
                {
                    return User::find($servmov->movs->user_id)->name;
                    break;
                }
                else
                {
                    if ($servmov->movs->type == 'TERMINADO' && $servmov->movs->status == 'ACTIVO')
                    {
                        return User::find($servmov->movs->user_id)->name;
                        break;
                    }
                    else
                    {
                        if($servmov->movs->type == 'ENTREGADO'&& $servmov->movs->status == 'ACTIVO')
                        {
                            foreach ($servicio->movservices as $servmov)
                            {
                                if($servmov->movs->type == 'TERMINADO' && $servmov->movs->status == 'INACTIVO')
                                {
                                    return User::find($servmov->movs->user_id)->name;
                                    break;
                                }
                            }   
                        }
                    }
                }
            }
        }
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
    public function modalserviciodetalles($type, $idservicio, $idordendeservicio)
    {
        //Actualizando variable $id_orden_de_servicio para mostrar el codigo de la orden del servicio en el titulo de la ventana modal
        $this->id_orden_de_servicio = $idordendeservicio;
        $this->tiposervicio = OrderService::find($idordendeservicio)->type_service;
        $this->detallesservicios($type, $idservicio);
        $this->emit('show-sd', 'show modal!');
    }
    //Llenar las variables globales con los detalles de un servicio
    public function detallesservicios($type, $idservicio)
    {
        $detallesservicio =  Service::join('order_services as os', 'os.id', 'services.order_service_id')
        ->join('mov_services as ms', 'services.id', 'ms.service_id')
        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
        ->join('users as u', 'u.id', 'mov.user_id')
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
        'u.name as responsabletecnico',
        'services.marca as marca')
        ->where('mov.type', $type)
        ->where('mov.status', 'ACTIVO')
        ->where('services.id', $idservicio)
        ->get()
        ->first();

        $detallesservicio->responsabletecnico = $this->obtener_tecnico_responsable($idservicio);

        if($type == "PENDIENTE")
        {
            $this->responsabletecnico = "No Asignado";      
        }
        else
        {
            $this->responsabletecnico = $detallesservicio->responsabletecnico; 
        }



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
    }
    //Mostrar una lista de usuarios tecnicos para asignar un servicio en una Ventana Modal
    public function modalasignartecnico($idservicio, $idordendeservicio)
    {
        //Verificando que el servicio sea pendiente activo
        if($this->verificarpendiente($idservicio))
        {
            //Actualizando variable $id_orden_de_servicio para mostrar el codigo de la orden del servicio en el titulo de la ventana modal
            $this->id_orden_de_servicio = $idordendeservicio;
    
            $this->id_servicio = $idservicio;
    
            $this->detallesservicios('PENDIENTE', $idservicio);
    
            $this->emit('show-asignartecnicoresponsable', 'show modal!');
        }
        else
        {
            //Si el servicio no es pendiente activo, buscamos con el método el movimiento que sea activo
            $movimiento = $this->saberactivo($idservicio);
            //Buscamos el nombre del Responsable Técnico de ese servicio y lo guardamos en una variable para mostrarlo en una alerta
            $this->alert_responsabletecnico = User::find($movimiento->user_id)->name;
            $this->emit('Serviciopendienteocupado');

        }

    }
    //Listar los Usuarios para ser asignados a un servicio Pendiente en una Ventana Modal
    public function listarusuarios()
    {
        // $listausuarios1 = User::join('movimientos as m', 'm.user_id', 'users.id')
        // ->join('mov_services as ms', 'ms.movimiento_id', 'm.id')
        // ->join('services as s', 's.id', 'ms.service_id')
        // ->join('order_services as os', 'os.id', 's.order_service_id')
        // ->join('model_has_roles as mhr', 'mhr.model_id', 'users.id')
        // ->join('roles as r', 'r.id', 'mhr.role_id')
        // ->join('role_has_permissions as rhp', 'rhp.role_id', 'r.id')
        // ->join('permissions as p', 'p.id', 'rhp.permission_id')
        // ->select("users.id as idusuario","users.name as nombreusuario",DB::raw('0 as proceso'), DB::raw('0 as terminado'))
        // ->where('os.status', 'ACTIVO')
        // ->where('m.status', 'ACTIVO')
        // ->where('p.name', 'Aparecer_Lista_Servicios')
        // ->distinct()
        // ->orderBy('proceso','asc')
        // ->get();


        $listausuarios1 = User::join('model_has_roles as mhr', 'mhr.model_id', 'users.id')
        ->join('roles as r', 'r.id', 'mhr.role_id')
        ->join('role_has_permissions as rhp', 'rhp.role_id', 'r.id')
        ->join('permissions as p', 'p.id', 'rhp.permission_id')
        ->select("users.id as idusuario","users.name as nombreusuario",DB::raw('0 as proceso'), DB::raw('0 as terminado'))
        ->where('p.name', 'Aparecer_Lista_Servicios')
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
    //Ser asignado a un servicio
    public function serasignado($idordenservicio, $idservicio)
    {
        //Verificando que el servicio sea pendiente activo
        if($this->verificarpendiente($idservicio))
        {
            $this->id_orden_de_servicio = $idordenservicio;
            $this->id_servicio = $idservicio;
            $this->asignartecnico(Auth()->user()->id);
        }
        else
        {
            //Si el servicio no es pendiente activo, buscamos con el método el movimiento que sea activo
            $movimiento = $this->saberactivo($idservicio);
            //Buscamos el nombre del Responsable Técnico de ese servicio y lo guardamos en una variable para mostrarlo en una alerta
            $this->alert_responsabletecnico = User::find($movimiento->user_id)->name;
            $this->emit('Serviciopendienteocupado');

        }
    }
    //Asignar un Técnico Responsable a un Servicio
    public function asignartecnico($idusuario)
    {
        $service = Service::find($this->id_servicio);

        foreach ($service->movservices as $servmov)
        {
            if ($servmov->movs->status == 'ACTIVO' && $servmov->movs->type == 'PENDIENTE')
            {
                $movimiento = $servmov->movs;
                
                DB::beginTransaction();
                try
                {
                    if (Auth::user()->hasPermissionTo('Asignar_Tecnico_Servicio'))
                    {
                        $mv = Movimiento::create([
                            'type' => 'PROCESO',
                            'status' => 'ACTIVO',
                            'import' => $movimiento->import,
                            'on_account' => $movimiento->on_account,
                            'saldo' => $movimiento->saldo,
                            'user_id' => $idusuario
                        ]);
                    }
                    else
                    {
                        $mv = Movimiento::create([
                            'type' => 'PROCESO',
                            'status' => 'ACTIVO',
                            'import' => $movimiento->import,
                            'on_account' => $movimiento->on_account,
                            'saldo' => $movimiento->saldo,
                            'user_id' =>  Auth()->user()->id,
                        ]);
                    }



                    MovService::create([
                        'movimiento_id' => $mv->id,
                        'service_id' => $service->id
                    ]);
                    ClienteMov::create([
                        'movimiento_id' => $mv->id,
                        'cliente_id' => $movimiento->climov->cliente_id,
                    ]);
                    $movimiento->update([
                        'status' => 'INACTIVO'
                    ]);

                    DB::commit();
                    break;
                    
                }
                catch (Exception $e)
                {
                    DB::rollback();
                    $this->emit('item-error', 'ERROR' . $e->getMessage());
                }
            }
        }
        

        $mv = Movimiento::create([
            'type' => 'PROCESO',
            'status' => 'ACTIVO',
            'import' => $movimiento->import,
            'on_account' => $movimiento->on_account,
            'saldo' => $movimiento->saldo,
            'user_id' => $idusuario,
        ]);
        if (Auth::user()->hasPermissionTo('Asignar_Tecnico_Servicio'))
        {
            $this->emit('show-asignartecnicoresponsablecerrar', 'show modal!');
        }
        else
        {
            $this->emit('responsable-tecnico');
        }

    }
    //Llama al método modaleditarservicio pero ocultando los parámetros para Terminar un Servicio
    public function modaleditarservicio1($type, $idservicio, $idordendeservicio)
    {
        if(Auth::user()->hasPermissionTo('Asignar_Tecnico_Servicio'))
        {
            $this->tipo = $type;
            $this->mostrarterminar = "No";
            $this->modaleditarservicio($type, $idservicio, $idordendeservicio);
        }
        else
        {
            //Verificamos si el que solicita esta informacion sea el Técnico Responsable del Servicio en proceso
            if($this->verificartecnicoresponsable($idservicio))
            {
                $this->tipo = $type;
                $this->mostrarterminar = "No";
                $this->modaleditarservicio($type, $idservicio, $idordendeservicio);
            }
            else
            {
                $this->emit('acceso-denegado');
            }
        }
        
    }
    //Llama al método modaleditarservicio pero mostrando los parámetros para Terminar un Servicio
    public function modaleditarservicio2($type, $idservicio, $idordendeservicio)
    {
        if(Auth::user()->hasPermissionTo('Asignar_Tecnico_Servicio'))
        {
            $this->tipo = $type;
            $this->mostrarterminar = "Si";
            $this->modaleditarservicio($type, $idservicio, $idordendeservicio);
        }
        else
        {
            //Verificamos si el que solicita esta informacion sea el Técnico Responsable del Servicio en proceso
            if($this->verificartecnicoresponsable($idservicio))
            {
                $this->tipo = $type;
                $this->mostrarterminar = "Si";
                $this->modaleditarservicio($type, $idservicio, $idordendeservicio);
            }
            else
            {
                $this->emit('acceso-denegado');
            }
        }

    }
    //Muestra una Ventana Modal con todos los datos de un Servicio
    public function modaleditarservicio($type, $idservicio, $idordendeservicio)
    {

        //Actualizando variable $id_orden_de_servicio para mostrar el codigo de la orden del servicio en el titulo de la ventana modal
        $this->id_orden_de_servicio = $idordendeservicio;

        //Actualizando el id_servicio para terminar el servicio si así lo requiere el método terminarservicio()
        $this->id_servicio = $idservicio;

        $detallesservicio =  Service::join('order_services as os', 'os.id', 'services.order_service_id')
        ->join('mov_services as ms', 'services.id', 'ms.service_id')
        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
        ->join('clientes as c', 'c.id', 'cm.cliente_id')
        ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
        ->join('type_works as tw', 'tw.id', 'services.type_work_id')
        ->select('cps.id as idnombrecategoria',
        'services.detalle as detalle',
        'mov.type as estado',
        'c.nombre as nombrecliente',
        'mov.on_account as acuenta',
        'mov.saldo as saldo',
        'mov.user_id as idusuario',
        'c.celular as celularcliente',
        'services.falla_segun_cliente as falla_segun_cliente',
        'services.fecha_estimada_entrega as fecha_estimada_entrega',
        'services.detalle as detalleservicio',
        'services.costo as costo',
        'services.diagnostico as diagnostico',
        'services.solucion as solucion',
        'services.detalle_costo as detallecosto',
        'mov.import as precioservicio',
        'tw.id as idtipotrabajo',
        'services.marca as marca')
        ->where('mov.type', $type)
        ->where('mov.status', 'ACTIVO')
        ->where('services.id', $idservicio)
        ->get()
        ->first();



        $this->detallesservicios($type, $idservicio);
        $this->edit_tipodetrabajo = $detallesservicio->idtipotrabajo;
        $this->edit_categoriatrabajo = $detallesservicio->idnombrecategoria;
        $this->edit_marca = $detallesservicio->marca;
        $this->edit_detalle = $detallesservicio->detalleservicio;
        $this->edit_fallaseguncliente = $detallesservicio->falla_segun_cliente;
        $this->edit_diagnostico = $detallesservicio->diagnostico;
        $this->edit_solucion = $detallesservicio->solucion;
        $this->edit_fechaestimadaentrega = substr($detallesservicio->fecha_estimada_entrega, 0, 10);
        $this->edit_horaentrega = substr($detallesservicio->fecha_estimada_entrega, 11, 14);
        $this->edit_precioservicio = $detallesservicio->precioservicio;
        $this->edit_acuenta = $detallesservicio->acuenta;
        $this->edit_saldo = $this->edit_precioservicio - $this->edit_acuenta;
        $this->edit_costoservicio = $detallesservicio->costo;
        $this->edit_motivocostoservicio = $detallesservicio->detallecosto;
        $this->id_usuario = $detallesservicio->idusuario;
        $this->emit('show-editarserviciomostrar', 'show modal!');
    }
    //Muestra una Ventana Modal para entregar un Servicio
    public function modalentregarservicio($type, $idservicio, $idordendeservicio)
    {
         //Verificando si el usuario tiene una caja abierta
         if($this->listarcarteras() == null)
         {
             $this->estadocaja = "cerrado";
         }
         else
         {
             $this->estadocaja = "abierto";
             //Listando todas las carteras disponibles para la caja abierta
             $listac = $this->listarcarteras();
             //Poniendo por defecto la primera cartera de tipo Cajafisica
             foreach($listac as $list)
                 {
                     if($list->tipo == 'CajaFisica')
                     {
                         $this->tipopago = $list->idcartera;
                         break;
                     }
                     
                 }
         }
        //Actualizando variable $id_orden_de_servicio para mostrar el codigo de la orden del servicio en el titulo de la ventana modal
        $this->id_orden_de_servicio = $idordendeservicio;

        //Actualizando el id_servicio para terminar el servicio si así lo requiere el método terminarservicio()
        $this->id_servicio = $idservicio;



        $detallesservicio =  Service::join('order_services as os', 'os.id', 'services.order_service_id')
        ->join('mov_services as ms', 'services.id', 'ms.service_id')
        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
        ->join('clientes as c', 'c.id', 'cm.cliente_id')
        ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
        ->join('type_works as tw', 'tw.id', 'services.type_work_id')
        ->select('cps.id as idnombrecategoria',
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
        'tw.id as idtipotrabajo',
        'services.marca as marca')
        ->where('mov.type', $type)
        ->where('mov.status', 'ACTIVO')
        ->where('services.id', $idservicio)
        ->get()
        ->first();



        $this->detallesservicios($type, $idservicio);
        $this->edit_tipodetrabajo = $detallesservicio->idtipotrabajo;
        $this->edit_categoriatrabajo = $detallesservicio->idnombrecategoria;
        $this->edit_marca = $detallesservicio->marca;
        $this->edit_detalle = $detallesservicio->detalleservicio;
        $this->edit_fallaseguncliente = $detallesservicio->falla_segun_cliente;
        $this->edit_solucion = $detallesservicio->solucion;
        $this->edit_fechaestimadaentrega = substr($detallesservicio->fecha_estimada_entrega, 0, 10);
        $this->edit_horaentrega = substr($detallesservicio->fecha_estimada_entrega, 11, 14);
        $this->edit_precioservicio = $detallesservicio->precioservicio;
        $this->edit_acuenta = $detallesservicio->acuenta;
        $this->edit_saldo = $this->edit_precioservicio - $this->edit_acuenta;
        $this->edit_costoservicio = $detallesservicio->costo;
        $this->edit_motivocostoservicio = $detallesservicio->detallecosto;









        $this->emit('show-entregarservicio', 'show modal!');
    }
    //Entrega el Servicio Correspondiente, Marca como TERMINADO
    public function entregarservicio()
    {
        $service = Service::find($this->id_servicio);

        
        foreach ($service->movservices as $servmov)
        {
            if ($servmov->movs->status == 'ACTIVO' && $servmov->movs->type == 'TERMINADO')
            {
                $movimiento = $servmov->movs;

                DB::beginTransaction();
                try
                {
                    $mv = Movimiento::create([
                        'type' => 'ENTREGADO',
                        'status' => 'ACTIVO',
                        'import' => $this->edit_precioservicio,
                        'on_account' => $this->edit_acuenta,
                        'saldo' => $this->edit_precioservicio - $this->edit_acuenta,
                        'user_id' => Auth()->user()->id,
                    ]);


                    CarteraMov::create([
                        'type' => 'INGRESO',
                        'tipoDeMovimiento' => 'SERVICIOS',
                        'comentario' => '',
                        'cartera_id' => $this->tipopago,
                        'movimiento_id' => $mv->id
                    ]);

                    MovService::create([
                        'movimiento_id' => $mv->id,
                        'service_id' => $service->id
                    ]);
                    ClienteMov::create([
                        'movimiento_id' => $mv->id,
                        'cliente_id' => $movimiento->climov->cliente_id,
                    ]);

                    DB::commit();
                    $movimiento->update([
                        'status' => 'INACTIVO'

                    ]);

                    $this->emit('servicioentregado');
                }
                catch(Exception $e)
                {
                    DB::rollback();
                    $this->emit('item-error', 'ERROR' . $e->getMessage());
                }
            }
        }
    }
    //Actualizar un Servicio (Tabla services y movimientos)
    public function actualizarservicio()
    {
        //Reglas de Validación
        $rules = [
            'edit_tipodetrabajo' => 'required|not_in:Seleccionar',
            'edit_categoriatrabajo' => 'required|not_in:Seleccionar',
            'edit_marca' => 'required',
            'edit_detalle' => 'required',
            'edit_fallaseguncliente' => 'required',
            'edit_diagnostico' => 'required',
            'edit_solucion' => 'required',
            'edit_precioservicio' => 'required',
        ];
        $messages = [
            'edit_tipodetrabajo.required' => 'Elija otra Opción',
            'edit_categoriatrabajo.required' => 'Elija otra Opción',
            'edit_marca.required' => 'Información Requerida',
            'edit_detalle.required' => 'Información Requerida',
            'edit_fallaseguncliente.required' => 'Información Requerida',
            'edit_diagnostico.required' => 'Información Requerida',
            'edit_solucion.required' => 'Información Requerida',
            'edit_precioservicio.required' => 'Información Requerida',
        ];
        $this->validate($rules, $messages);

        $service = Service::find($this->id_servicio);

        $fecha_entrega = Carbon::parse($this->edit_fechaestimadaentrega)->format('Y-m-d') . Carbon::parse($this->edit_horaentrega)->format(' H:i') . ':00';

        $service->update([
            'type_work_id' => $this->edit_tipodetrabajo,
            'cat_prod_service_id' => $this->edit_categoriatrabajo,
            'marca' => $this->edit_marca,
            'detalle' => $this->edit_detalle,
            'falla_segun_cliente' => $this->edit_fallaseguncliente,
            'diagnostico' => $this->edit_diagnostico,
            'solucion' => $this->edit_solucion,
            'costo' => $this->edit_costoservicio,
            'detalle_costo' => $this->edit_motivocostoservicio,
            'fecha_estimada_entrega' => $fecha_entrega,
        ]);
        $service->save();
        //Editar solo el movimiento que esté activo
        $ser = $this->saberactivo($this->id_servicio);
        
        $ser->update([
            'import' => $this->edit_precioservicio,
            'user_id' => $this->id_usuario,
            'on_account' => $this->edit_acuenta,
            'saldo' => $this->edit_saldo,
        ]);

        
        $this->emit('show-editarservicioocultar', 'show modal!');
    }
    //Para saber el estado[ACTIVO,INACTIVO] de un servicio, devuelve el movimiento que sea activo
    public function saberactivo($idservicio)
    {
        $datoscliente = Service::find($idservicio);
        foreach ($datoscliente->movservices as $ms)
        {
            if($ms->movs->status == 'ACTIVO')
            {
                return $ms->movs;
            }
        }
    }
    //Registra como Terminado un Servicio
    public function terminarservicio()
    {
        //Llamando al Método para Actualizar el Servicio Antes de Marcarlo como Terminado
        $this->actualizarservicio();
        $service = Service::find($this->id_servicio);
            foreach ($service->movservices as $servmov)
            {
                if ($servmov->movs->status == 'ACTIVO' && $servmov->movs->type == 'PROCESO')
                {
                    $movimiento = $servmov->movs;

                    DB::beginTransaction();
                    try
                    {
                        if(Auth::user()->hasPermissionTo('Orden_Servicio_Index'))
                        {
                            $mv = Movimiento::create([
                                'type' => 'TERMINADO',
                                'status' => 'ACTIVO',
                                'import' => $movimiento->import,
                                'on_account' => $movimiento->on_account,
                                'saldo' => $movimiento->saldo,
                                'user_id' => $movimiento->user_id,
                            ]);
                        }

                        MovService::create([
                            'movimiento_id' => $mv->id,
                            'service_id' => $service->id
                        ]);
                        ClienteMov::create([
                            'movimiento_id' => $mv->id,
                            'cliente_id' => $movimiento->climov->cliente_id,
                        ]);

                        DB::commit();
                        $movimiento->update([
                            'status' => 'INACTIVO'
                        ]);
                        $this->emit('show-terminarservicio', 'show modal!');
                    }
                    catch(Exception $e)
                    {
                        DB::rollback();
                        $this->emit('item-error', 'ERROR' . $e->getMessage());
                    }
                }
            }

        
    }
    //Devuelve el true o false de un servicio por su Técnico Responsable
    public function verificartecnicoresponsable($idservicio)
    {
        $service = Service::find($idservicio);
        foreach ($service->movservices as $servmov)
        {
            if ($servmov->movs->status == 'ACTIVO' && $servmov->movs->type == 'PENDIENTE')
            {
                return true;
                break;
            }
            else
            {
                if($servmov->movs->status == 'ACTIVO' && $servmov->movs->type == 'PROCESO')
                {
                    $movimiento = $servmov->movs;

                    if($movimiento->user_id == Auth()->user()->id)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                    break;
                }
                else
                {
                    if($servmov->movs->status == 'ACTIVO' && $servmov->movs->type == 'TERMINADO')
                    {
                        return true;
                        break;
                    }
                    else
                    {
                        if($servmov->movs->status == 'ACTIVO' && $servmov->movs->type == 'ENTREGADO')
                        {
                            return true;
                            break;
                        }
                    }

                }
            }
        }
    }
    //Redirige para modificar una Orden de Servicio con las variables correspondientes
    public function modificarordenservicio($idcliente, $codigo, $tiposervicio)
    {
        $datoscliente = Cliente::find($idcliente);
        session(['clie' => $datoscliente]);
        session(['od' => $codigo]);
        session(['tservice' => $tiposervicio]);

        $this->redirect('service');
    }
    /* LISTENERS */
    protected $listeners = [
        'sertecnicoresponsable' => 'serasignado',
        'anularservicio' => 'anularordenservicio',
        'eliminarservicio' => 'eliminarordenservicio'
        ];

    //Anula un Servicio Modificando los estados
    public function anularordenservicio($id)
    {
        $this->id_orden_de_servicio = $id;
        $order = OrderService::find($id);

        foreach ($order->services as $servicio)
        {
            foreach ($servicio->movservices as $mm)
            {
                if(($mm->movs->status == 'ACTIVO') && ($mm->movs->type == 'TERMINADO' || $mm->movs->type == 'ENTREGADO'))
                {
                    $this->emit('entregado-terminado');
                    return;
                }
            }
            foreach ($servicio->movservices as $mm)
            {
                if ($mm->movs->status == 'ACTIVO')
                {
                    $mv = $mm->movs;
                    $mv->update([
                        'type' => 'ANULADO',
                        'status' => 'INACTIVO'
                    ]);
                }
            }
        }

        $order->status = 'INACTIVO';
        $order->save();


        $this->emit('orden-anulado');
    }
    //Elimina totalmente un servicio con sus tablas relacionadas
    public function eliminarordenservicio($id)
    {
        $this->id_orden_de_servicio = $id;

        $orderservice = OrderService::find($id);

        DB::beginTransaction();
        try {
            foreach ($orderservice->services as $servicio)
            {
                foreach ($servicio->movservices as $movimientoservicio)
                {
                    if(($movimientoservicio->movs->status == 'ACTIVO') && ($movimientoservicio->movs->type == 'TERMINADO' || $movimientoservicio->movs->type == 'ENTREGADO'))
                    {
                        $this->emit('entregado-terminado');
                        return;
                    }
                    else
                    {
                        $movimientoservicio->movs->climov->delete();
                        $movimiento = $movimientoservicio->movs;
                        $movimientoservicio->delete();
                        $movimiento->delete();
                    }
                }
                $servicio->delete();
            }

            $orderservice->delete();

            DB::commit();

            $this->emit('orden-eliminado');
        }
        catch (Exception $e)
        {
            DB::rollback();
            dd("Error");
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }
    //Mostrar una lista de usuarios tecnicos para asignar un servicio en una Ventana Modal
    public function modalaterminarservicio($type, $idservicio, $idordendeservicio)
    {
        //Actualizando variable $id_orden_de_servicio para mostrar el codigo de la orden del servicio en el titulo de la ventana modal
        $this->id_orden_de_servicio = $idordendeservicio;
        $this->id_servicio = $idservicio;

        $detallesservicio =  Service::join('order_services as os', 'os.id', 'services.order_service_id')
        ->join('mov_services as ms', 'services.id', 'ms.service_id')
        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
        ->join('clientes as c', 'c.id', 'cm.cliente_id')
        ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
        ->join('type_works as tw', 'tw.id', 'services.type_work_id')
        ->select('cps.id as idnombrecategoria',
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
        'tw.id as idtipotrabajo',
        'services.marca as marca')
        ->where('mov.type', $type)
        ->where('mov.status', 'ACTIVO')
        ->where('services.id', $idservicio)
        ->get()
        ->first();

        $this->id_servicio = $idservicio;


        $this->detallesservicios($type, $idservicio);
        $this->edit_tipodetrabajo = $detallesservicio->idtipotrabajo;
        $this->edit_categoriatrabajo = $detallesservicio->idnombrecategoria;
        $this->edit_marca = $detallesservicio->marca;
        $this->edit_detalle = $detallesservicio->detalleservicio;
        $this->edit_fallaseguncliente = $detallesservicio->falla_segun_cliente;
        $this->edit_diagnostico = $detallesservicio->diagnostico;
        $this->edit_solucion = $detallesservicio->solucion;
        $this->edit_fechaestimadaentrega = substr($detallesservicio->fecha_estimada_entrega, 0, 10);
        $this->edit_horaentrega = substr($detallesservicio->fecha_estimada_entrega, 11, 14);
        $this->edit_precioservicio = $detallesservicio->precioservicio;
        $this->edit_acuenta = $detallesservicio->acuenta;
        $this->edit_saldo = $this->edit_precioservicio - $this->edit_acuenta;

        $this->emit('show-registrarterminado', 'show modal!');
    }
    //Lista las carteras disponibles en la caja que esté abierto
    public function listarcarteras()
    {
        $carteras = Caja::join('carteras as car', 'cajas.id', 'car.caja_id')
        ->join('cartera_movs as cartmovs', 'car.id', 'cartmovs.cartera_id')
        ->join('movimientos as mov', 'mov.id', 'cartmovs.movimiento_id')
        ->where('cajas.estado', 'Abierto')
        ->where('mov.user_id', Auth()->user()->id)
        ->where('mov.status', 'ACTIVO')
        ->where('mov.type', 'APERTURA')
        ->where('cajas.sucursal_id', $this->idsucursal())
        ->select('car.id as idcartera', 'car.nombre as nombrecartera', 'car.descripcion as dc','car.tipo as tipo')
        ->get();

        if($carteras->count() > 0)
        {
            return $carteras;
        }
        else
        {
            return null;
        }


    }
    //Listar las carteras generales
    public function listarcarterasg()
    {
        $carteras = Caja::join('carteras as car', 'cajas.id', 'car.caja_id')
        ->where('cajas.id', 1)
        ->select('car.id as idcartera', 'car.nombre as nombrecartera', 'car.descripcion as dc','car.tipo as tipo')
        ->get();
        return $carteras;
    }
    //Llama a la ventana Modal Editar Servicio Terminado
    public function modaleditarservicioterminado($type, $idservicio, $idordendeservicio)
    {
        //Actualizando variable $id_orden_de_servicio para mostrar el codigo de la orden del servicio en el titulo de la ventana modal
        $this->id_orden_de_servicio = $idordendeservicio;

        //Actualizando el id_servicio para terminar el servicio si así lo requiere el método terminarservicio()
        $this->id_servicio = $idservicio;

        $detallesservicio =  Service::join('order_services as os', 'os.id', 'services.order_service_id')
        ->join('mov_services as ms', 'services.id', 'ms.service_id')
        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
        ->join('cliente_movs as cm', 'cm.movimiento_id', 'mov.id')
        ->join('clientes as c', 'c.id', 'cm.cliente_id')
        ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
        ->join('type_works as tw', 'tw.id', 'services.type_work_id')
        ->select('cps.id as idnombrecategoria',
        'services.detalle as detalle',
        'mov.type as estado',
        'c.nombre as nombrecliente',
        'mov.on_account as acuenta',
        'mov.saldo as saldo',
        'mov.user_id as idusuario',
        'c.celular as celularcliente',
        'services.falla_segun_cliente as falla_segun_cliente',
        'services.fecha_estimada_entrega as fecha_estimada_entrega',
        'services.detalle as detalleservicio',
        'services.costo as costo',
        'services.diagnostico as diagnostico',
        'services.solucion as solucion',
        'services.detalle_costo as detallecosto',
        'mov.import as precioservicio',
        'tw.id as idtipotrabajo',
        'services.marca as marca')
        ->where('mov.type', $type)
        ->where('mov.status', 'ACTIVO')
        ->where('services.id', $idservicio)
        ->get()
        ->first();


        //Buscando el movimiento de tipo Terminado para poner el usuario en el select de la Ventana Modal
        $servicio = Service::find($this->id_servicio);
        foreach ($servicio->movservices as $servmov)
        {
            if($servmov->movs->type == 'TERMINADO' && $servmov->movs->status == 'INACTIVO')
            {
                $this->id_usuario = $servmov->movs->user_id;
                break;
            }
        } 


        $this->edit_costoservicioterminado = $detallesservicio->costo;
        $this->edit_motivoservicioterminado = $detallesservicio->detallecosto;
        
        $this->edit_precioservicioterminado = $detallesservicio->precioservicio;
        $this->edit_acuentaservicioterminado = $detallesservicio->acuenta;
        $this->edit_saldoterminado = $this->edit_precioservicioterminado - $this->edit_acuentaservicioterminado;




        //Buscando tipo de pago (id de la cartera)

        //Buscando el movimiento de tipo Entregado para obtener la cartera_id a travez de la tabla cartera_movs
        $servicio = Service::find($this->id_servicio);
        foreach ($servicio->movservices as $servmov)
        {
            if($servmov->movs->type == 'ENTREGADO' && $servmov->movs->status == 'ACTIVO')
            {
                //Ponemos el id de la cartera en la variable $this->edit_carteraservicioterminado
                $this->edit_carteraservicioterminado = CarteraMov::where("cartera_movs.movimiento_id",$servmov->movs->id)->get()->first()->cartera_id;
                break;
            }
        } 



        
        $this->emit('show-editarservicioterminado', 'show modal!');
    }
    //Actualiza un servicio terminado
    public function actualizarservicioterminado()
    {
        //Reglas de Validación
        $rules = [
            'edit_precioservicioterminado' => 'required',
        ];
        $messages = [
            'edit_precioservicioterminado.required' => 'Información Requerida',
        ];
        $this->validate($rules, $messages);

        //Editar solo el movimiento que esté activo
        $servicio = $this->saberactivo($this->id_servicio);


        //Buscando el movimiento de tipo Terminado para actualizar el id Usuario
        $servicio = Service::find($this->id_servicio);

        foreach ($servicio->movservices as $servmov)
        {
            if($servmov->movs->type == 'TERMINADO' && $servmov->movs->status == 'INACTIVO')
            {
                
                $servmov->movs->update([
                    'user_id' => $this->id_usuario,
                ]);
                
                break;
            }
        }
        
        foreach ($servicio->movservices as $servmov)
        {
            if($servmov->movs->type == 'PROCESO' && $servmov->movs->status == 'INACTIVO')
            {
                
                $servmov->movs->update([
                    'user_id' => $this->id_usuario,
                ]);
                
                break;
            }
        }

        foreach ($servicio->movservices as $servmov)
        {
            if($servmov->movs->type == 'ENTREGADO' && $servmov->movs->status == 'ACTIVO')
            {
                
                $servmov->movs->update([
                    'import' => $this->edit_precioservicioterminado,
                    'on_account' => $this->edit_acuentaservicioterminado,
                    'saldo' => $this->edit_saldoterminado,
                ]);
                //Actuluazamos la cartera_id
                
                $carteramovs = CarteraMov::find(CarteraMov::where("cartera_movs.movimiento_id",$servmov->movs->id)->get()->first()->id);
                
                $carteramovs->update([
                    'cartera_id' => $this->edit_carteraservicioterminado
                ]);
                $carteramovs->save();

                break;
            }
        }

        
        $servicio->update([
            'import' => $this->edit_precioservicioterminado,
            'on_account' => $this->edit_acuentaservicioterminado,
            'saldo' => $this->edit_saldoterminado,
        ]);


        $idservicio = Service::find($this->id_servicio);
        $idservicio->update([
            'costo' => $this->edit_costoservicioterminado,
            'detalle_costo' => $this->edit_motivoservicioterminado,
        ]);



        $this->emit('show-editarservicioterminadoocultar', 'show modal!');
    }
    //Redireccionar para crear un Nuevo Servicio Eliminando Variables de Sesion
    public function irservicio()
    {

        session(['od' => null]);
        session(['clie' => null]);
        session(['tservice' => null]);
        $this->redirect('service');
    }
    //Verifica si un servicio que esté pendiente este activo
    public function verificarpendiente($idservicio)
    {
        $service = Service::find($idservicio);

        foreach ($service->movservices as $servmov)
        {
            if ($servmov->movs->status == 'ACTIVO' && $servmov->movs->type == 'PENDIENTE')
            {
                $movimiento = $servmov->movs;
                return true;
                break;
            }
        }
        return false;
    }
    //Limpiar todo el $search
    public function limpiarsearch()
    {
        $this->search = "";
    }
}
