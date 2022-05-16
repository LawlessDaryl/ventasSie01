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
    use WithPagination;
    use WithFileUploads;
    public $search, $selected_id, $pageTitle, $componentName,
        $cliente, $fecha_estimada_entrega, $detalle, $status, $saldo, $on_account, $import,
        $serviceid, $movtype, $orderservice, $users1, $service1, $categoria, $marca, $numeroOrden,
        $detalle1, $falla_segun_cliente, $nombreCliente, $celular, $usuarioId,
        $typew, $typeworkid, $catprodservid, $diagnostico, $solucion, $hora_entrega, $proceso,
        $terminado, $costo, $detalle_costo, $nombreUsuario, $modificar, $type_service, $movimiento,
        $opciones, $tipopago, $dateFrom, $dateTo, $reportType, $userId, $estado, $mostrar,
        $mostrarEliminar, $tipo, $condicion, $fechahoy, $variable, $nomUsuTerm;

    private $pagination = null;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'LISTADO';
        $this->componentName = 'ORDENES DE SERVICIO';
        $this->usuarioId = -1;
        /* $this->search = ''; */
        $this->typeworkid = '';
        $this->catprodservid = '';
        $this->diagnostico = '';
        $this->solucion = '';
        $this->fecha_estimada_entrega = '';
        $this->hora_entrega = '';
        $this->import = 0;
        $this->on_account = 0;
        $this->saldo = 0;
        $this->detalle = '';
        $this->proceso = false;
        $this->terminado = false;
        $this->costo = 0;
        $this->detalle_costo = '';
        $this->nombreUsuario = '';
        $this->opciones = 'PENDIENTE';
        $this->tipopago = 'EFECTIVO';
        $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->reportType = 0;
        $this->userId = 0;
        $this->estado = 'Todos';
        $this->tipo = '';
        $this->condicion = 'MiSucursal';
        $this->fechahoy = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->variable = false;
        $this->nomUsuTerm = '';
    }
    public function render()
    {
        $this->fechahoy = Carbon::parse(Carbon::now())->format('Y-m-d');
        /* session(['opcio' => null]);
        if (!empty(session('opcio'))) {
            
            $this->opciones = session('opcio');
            session(['opcio' => null]);
            
        }else{
            session(['opcio' => 'PENDIENTE']);
            
        } */


        if ($this->reportType == 0) {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        } else {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d')     . ' 23:59:59';
        }
        if ($this->reportType == 1 && ($this->dateFrom == '' || $this->dateTo == '')) {
            $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
            $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
            $this->emit('item', 'Hiciste algo incorrecto, la fecha se actualizó');
        }

        if ($this->dateFrom == "" || $this->dateTo == "") {
            $this->reportType = 0;
        }

        $user = User::find(Auth()->user()->id);
        foreach ($user->sucursalusers as $usersuc) {
            if ($usersuc->estado == 'ACTIVO') {
                $this->sucursal = $usersuc->sucursal->id;
            }
        }

        
            

        if ($this->condicion == 'Todos') {
            if (!empty(session('orderserv'))) {
                $this->search = session('orderserv');
                session(['orderserv' => null]);
                $orderservices = OrderService::where('id', $this->search)
                    ->orderBy('order_services.id', 'desc')
                    ->paginate($this->pagination);
            } else {
                if (strlen($this->search) > 0) {
                    if ($this->opciones == 'TODOS') {
                        $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                            ->join('mov_services as ms', 's.id', 'ms.service_id')
                            ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                            ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                            ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                            ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                            ->join('users as u', 'u.id', 'mov.user_id')
                            ->select('order_services.*')
                            /* ->where('mov.type',  $this->opciones) */
                            ->where('mov.status', 'ACTIVO')
                            ->where('c.nombre', 'like', '%' . $this->search . '%')
                            ->orWhere('order_services.id', 'like', '%' . $this->search . '%')
                            ->where('mov.status', 'ACTIVO')
                            ->orWhere('order_services.type_service', 'like', '%' . $this->search . '%')
                            ->where('mov.status', 'ACTIVO')
                            ->orWhere('cat.nombre', 'like', '%' . $this->search . '%')
                            ->where('mov.status', 'ACTIVO')
                            ->orWhere('s.detalle', 'like', '%' . $this->search . '%')
                            ->where('mov.status', 'ACTIVO')
                            ->orWhere('s.marca', 'like', '%' . $this->search . '%')
                            ->where('mov.status', 'ACTIVO')
                            ->orWhere('s.falla_segun_cliente', 'like', '%' . $this->search . '%')
                            ->where('mov.status', 'ACTIVO')
                            ->orWhere('u.name', 'like', '%' . $this->search . '%')
                            /* ->orWhere('mov.import', 'like', '%' . $this->search . '%') */
                            /* ->orderBy('order_services.id', 'desc') */
                            ->where('mov.status', 'ACTIVO')
                            /* ->orderBy('mov.created_at', 'desc') */
                            ->distinct()
                            ->paginate($this->pagination);
                    } else {
                        if ($this->opciones == 'ANULADO') {
                            $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                                ->join('mov_services as ms', 's.id', 'ms.service_id')
                                ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->select('order_services.*')
                                ->where('mov.type', 'ANULADO')
                                ->where('mov.status', 'INACTIVO')
                                ->where('c.nombre', 'like', '%' . $this->search . '%')
                                ->where('mov.type', 'ANULADO')
                                ->where('mov.status', 'INACTIVO')
                                ->orWhere('order_services.id', 'like', '%' . $this->search . '%')
                                ->where('mov.type', 'ANULADO')
                                ->where('mov.status', 'INACTIVO')
                                ->orWhere('order_services.type_service', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'INACTIVO')
                                ->where('mov.type', 'ANULADO')
                                ->orWhere('cat.nombre', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'INACTIVO')
                                ->where('mov.type', 'ANULADO')
                                ->orWhere('s.detalle', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'INACTIVO')
                                ->where('mov.type', 'ANULADO')
                                ->orWhere('s.marca', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'INACTIVO')
                                ->where('mov.type', 'ANULADO')
                                ->orWhere('s.falla_segun_cliente', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'INACTIVO')
                                ->where('mov.type', 'ANULADO')
                                ->orWhere('u.name', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'INACTIVO')
                                ->where('mov.type', 'ANULADO')
                                /* ->orWhere('mov.import', 'like', '%' . $this->search . '%') */
                                /* ->orderBy('order_services.id', 'desc') */
                                /* ->orderBy('mov.created_at', 'desc') */
                                ->distinct()
                                ->paginate($this->pagination);
                        } else {
                            $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                                ->join('mov_services as ms', 's.id', 'ms.service_id')
                                ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->select('order_services.*')
                                /* ->where('s.sucursal_id',$this->sucursal) */
                                ->where('mov.type',  $this->opciones)
                                ->where('mov.status', 'ACTIVO')
                                ->where('c.nombre', 'like', '%' . $this->search . '%')
                                ->orWhere('order_services.id', 'like', '%' . $this->search . '%')
                                ->where('mov.type',  $this->opciones)
                                ->where('mov.status', 'ACTIVO')
                                ->orWhere('order_services.type_service', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'ACTIVO')
                                ->where('mov.type',  $this->opciones)
                                ->orWhere('cat.nombre', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'ACTIVO')
                                ->where('mov.type',  $this->opciones)
                                ->orWhere('s.detalle', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'ACTIVO')
                                ->where('mov.type',  $this->opciones)
                                ->orWhere('s.marca', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'ACTIVO')
                                ->where('mov.type',  $this->opciones)
                                ->orWhere('s.falla_segun_cliente', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'ACTIVO')
                                ->where('mov.type',  $this->opciones)
                                ->orWhere('u.name', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'ACTIVO')
                                ->where('mov.type',  $this->opciones)
                                /* ->orWhere('mov.import', 'like', '%' . $this->search . '%') */
                                /* ->orderBy('order_services.id', 'desc') */
                                /* ->orderBy('mov.created_at', 'desc') */
                                ->distinct()
                                ->paginate($this->pagination);
                        }
                    }
                } elseif ($this->opciones == 'TODOS') {

                    $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                        ->join('mov_services as ms', 's.id', 'ms.service_id')
                        ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                        ->where('mov.status', 'ACTIVO')
                        ->orWhere('mov.status', 'INACTIVO')
                        ->where('mov.type', 'ANULADO')
                        ->select('order_services.*')
                        /* ->orderBy('order_services.id', 'desc') */
                        /* ->orderBy('mov.created_at', 'desc') */
                        ->distinct()
                        ->paginate($this->pagination);
                } elseif ($this->opciones == 'ANULADO') {

                    $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                        ->join('mov_services as ms', 's.id', 'ms.service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->where('mov.type', 'ANULADO')
                        ->select('order_services.*')
                        /* ->orderBy('order_services.id', 'desc') */
                        /* ->orderBy('mov.created_at', 'desc') */
                        ->distinct()
                        ->paginate($this->pagination);
                } elseif ($this->opciones != 'fechas') {
                    $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                        ->join('mov_services as ms', 's.id', 'ms.service_id')
                        ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                        ->where('mov.type',  $this->opciones)
                        ->where('mov.status', 'ACTIVO')
                        ->select('order_services.*')
                        /* ->orderBy('order_services.id', 'desc') */
                        /* ->orderBy('mov.created_at', 'desc') */
                        ->distinct()
                        ->paginate($this->pagination);
                } elseif ($this->opciones == 'fechas') {
                    if ($this->estado == 'Todos') {
                        if ($this->userId == 0) {
                            $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                                ->join('mov_services as ms', 's.id', 'ms.service_id')
                                ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                                ->where('mov.status', 'ACTIVO')
                                ->select('order_services.*')
                                ->whereBetween('mov.created_at', [$from, $to])
                                /* ->orderBy('order_services.id', 'desc') */
                                /* ->orderBy('mov.created_at', 'desc') */
                                ->distinct()
                                ->paginate($this->pagination);
                        } else {
                            $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                                ->join('mov_services as ms', 's.id', 'ms.service_id')
                                ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')

                                ->select('order_services.*')
                                ->whereBetween('mov.created_at', [$from, $to])
                                ->where('mov.user_id', $this->userId)
                                ->where('mov.status', 'ACTIVO')
                                /* ->orderBy('order_services.id', 'desc') */
                                /* ->orderBy('mov.created_at', 'desc') */
                                ->distinct()
                                ->paginate($this->pagination);
                        }
                    } else {
                        if ($this->userId == 0) {
                            $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                                ->join('mov_services as ms', 's.id', 'ms.service_id')
                                ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                                ->select('order_services.*')
                                ->whereBetween('mov.created_at', [$from, $to])
                                ->where('mov.type', $this->estado)
                                ->where('mov.status', 'ACTIVO')
                                /* ->orderBy('order_services.id', 'desc') */
                               /*  ->orderBy('mov.created_at', 'desc') */
                                ->distinct()
                                ->paginate($this->pagination);
                        } else {
                            $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                                ->join('mov_services as ms', 's.id', 'ms.service_id')
                                ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                                ->select('order_services.*')
                                ->whereBetween('mov.created_at', [$from, $to])
                                ->where('mov.user_id', $this->userId)
                                ->where('mov.type', $this->estado)
                                ->where('mov.status', 'ACTIVO')
                                /* ->orderBy('order_services.id', 'desc') */
                               /*  ->orderBy('mov.created_at', 'desc') */
                                ->distinct()
                                ->paginate($this->pagination);
                        }
                    }
                }
            }
        } elseif ($this->condicion == 'MiSucursal') {
            if (!empty(session('orderserv'))) {
                $this->search = session('orderserv');
                session(['orderserv' => null]);
                $this->opciones = 'TODOS';
                $orderservices = OrderService::where('id', $this->search)
                    ->orderBy('order_services.id', 'desc')
                    ->paginate($this->pagination);
            } else {
                /* $this->opciones = 'PENDIENTE'; */
                if (strlen($this->search) > 0) {
                    if ($this->opciones == 'TODOS') {
                        $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                            ->join('mov_services as ms', 's.id', 'ms.service_id')
                            ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                            ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                            ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                            ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                            ->join('users as u', 'u.id', 'mov.user_id')
                            ->join('sucursal_users as suu', 'u.id', 'suu.user_id')
                            ->join('sucursals as suc', 'suc.id', 'suu.sucursal_id')
                            ->select('order_services.*')
                            ->where('s.sucursal_id',$this->sucursal)
                            /* ->where('suu.estado','ACTIVO') */
                            /* ->where('mov.type',  $this->opciones) */
                            ->where('mov.status', 'ACTIVO')
                            ->where('c.nombre', 'like', '%' . $this->search . '%')
                            ->where('s.sucursal_id',$this->sucursal)
                            ->orWhere('order_services.id', 'like', '%' . $this->search . '%')
                            ->where('mov.status', 'ACTIVO')
                            ->where('s.sucursal_id',$this->sucursal)
                            ->orWhere('order_services.type_service', 'like', '%' . $this->search . '%')
                            ->where('mov.status', 'ACTIVO')
                            ->where('s.sucursal_id',$this->sucursal)
                            ->orWhere('cat.nombre', 'like', '%' . $this->search . '%')
                            ->where('mov.status', 'ACTIVO')
                            ->where('s.sucursal_id',$this->sucursal)
                            ->orWhere('s.detalle', 'like', '%' . $this->search . '%')
                            ->where('mov.status', 'ACTIVO')
                            ->where('s.sucursal_id',$this->sucursal)
                            ->orWhere('s.marca', 'like', '%' . $this->search . '%')
                            ->where('mov.status', 'ACTIVO')
                            ->where('s.sucursal_id',$this->sucursal)
                            ->orWhere('s.falla_segun_cliente', 'like', '%' . $this->search . '%')
                            ->where('mov.status', 'ACTIVO')
                            ->where('s.sucursal_id',$this->sucursal)
                            ->orWhere('u.name', 'like', '%' . $this->search . '%')
                            ->where('mov.status', 'ACTIVO')
                            ->where('s.sucursal_id',$this->sucursal)
                            /* ->orWhere('mov.import', 'like', '%' . $this->search . '%') */
                            /* ->orderBy('order_services.id', 'desc') */
                            /* ->orderBy('mov.created_at', 'desc') */
                            ->distinct()
                            ->paginate($this->pagination);
                    } else {
                        if ($this->opciones == 'ANULADO') {
                            $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                                ->join('mov_services as ms', 's.id', 'ms.service_id')
                                ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->join('sucursal_users as suu', 'u.id', 'suu.user_id')
                                ->join('sucursals as suc', 'suc.id', 'suu.sucursal_id')
                                ->select('order_services.*')
                                ->where('s.sucursal_id',$this->sucursal)
                                /* ->where('suu.estado','ACTIVO') */
                                ->where('mov.type', 'ANULADO')
                                ->where('mov.status', 'INACTIVO')
                                ->where('c.nombre', 'like', '%' . $this->search . '%')
                                ->where('mov.type', 'ANULADO')
                                ->where('mov.status', 'INACTIVO')
                                ->orWhere('order_services.id', 'like', '%' . $this->search . '%')
                                ->where('s.sucursal_id',$this->sucursal)
                                ->where('mov.type', 'ANULADO')
                                ->where('mov.status', 'INACTIVO')
                                ->orWhere('order_services.type_service', 'like', '%' . $this->search . '%')
                                ->where('s.sucursal_id',$this->sucursal)
                                ->where('mov.status', 'INACTIVO')
                                ->where('mov.type', 'ANULADO')
                                ->orWhere('cat.nombre', 'like', '%' . $this->search . '%')
                                ->where('s.sucursal_id',$this->sucursal)
                                ->where('mov.status', 'INACTIVO')
                                ->where('mov.type', 'ANULADO')
                                ->orWhere('s.detalle', 'like', '%' . $this->search . '%')
                                ->where('s.sucursal_id',$this->sucursal)
                                ->where('mov.status', 'INACTIVO')
                                ->where('mov.type', 'ANULADO')
                                ->orWhere('s.marca', 'like', '%' . $this->search . '%')
                                ->where('s.sucursal_id',$this->sucursal)
                                ->where('mov.status', 'INACTIVO')
                                ->where('mov.type', 'ANULADO')
                                ->orWhere('s.falla_segun_cliente', 'like', '%' . $this->search . '%')
                                ->where('s.sucursal_id',$this->sucursal)
                                ->where('mov.status', 'INACTIVO')
                                ->where('mov.type', 'ANULADO')
                                ->orWhere('u.name', 'like', '%' . $this->search . '%')
                                ->where('s.sucursal_id',$this->sucursal)
                                ->where('mov.status', 'INACTIVO')
                                ->where('mov.type', 'ANULADO')
                                /* ->orWhere('mov.import', 'like', '%' . $this->search . '%') */
                                /* ->orderBy('order_services.id', 'desc') */
                                /* ->orderBy('mov.created_at', 'desc') */
                                ->distinct()
                                ->paginate($this->pagination);
                        } else {
                            
                            $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                                ->join('mov_services as ms', 's.id', 'ms.service_id')
                                ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->join('sucursal_users as suu', 'u.id', 'suu.user_id')
                                ->join('sucursals as suc', 'suc.id', 'suu.sucursal_id')
                                ->select('order_services.*')
                                ->where('s.sucursal_id',$this->sucursal)
                                ->where('mov.type',  $this->opciones)
                                /* ->where('suu.estado','ACTIVO') */
                                ->where('mov.status', 'ACTIVO')
                                ->where('c.nombre', 'like', '%' . $this->search . '%')
                                ->orWhere('order_services.id', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'ACTIVO')
                                ->where('s.sucursal_id',$this->sucursal)
                                ->where('mov.type',  $this->opciones)
                                ->orWhere('order_services.type_service', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'ACTIVO')
                                ->where('s.sucursal_id',$this->sucursal)
                                ->where('mov.type',  $this->opciones)
                                ->orWhere('cat.nombre', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'ACTIVO')
                                ->where('s.sucursal_id',$this->sucursal)
                                ->where('mov.type',  $this->opciones)
                                ->orWhere('s.detalle', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'ACTIVO')
                                ->where('s.sucursal_id',$this->sucursal)
                                ->where('mov.type',  $this->opciones)
                                ->orWhere('s.marca', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'ACTIVO')
                                ->where('s.sucursal_id',$this->sucursal)
                                ->where('mov.type',  $this->opciones)
                                ->orWhere('s.falla_segun_cliente', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'ACTIVO')
                                ->where('s.sucursal_id',$this->sucursal)
                                ->where('mov.type',  $this->opciones)
                                ->orWhere('u.name', 'like', '%' . $this->search . '%')
                                ->where('mov.status', 'ACTIVO')
                                ->where('s.sucursal_id',$this->sucursal)
                                ->where('mov.type',  $this->opciones)
                                /* ->orWhere('mov.import', 'like', '%' . $this->search . '%') */
                                /* ->orderBy('order_services.id', 'desc') */
                                /* ->orderBy('mov.created_at', 'desc') */
                                ->distinct()
                                ->paginate($this->pagination);
                        }
                    }
                } elseif ($this->opciones == 'TODOS') {
                    
                    $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                        ->join('mov_services as ms', 's.id', 'ms.service_id')
                        ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                        ->join('users as u', 'u.id', 'mov.user_id')
                        ->join('sucursal_users as suu', 'u.id', 'suu.user_id')
                        ->join('sucursals as suc', 'suc.id', 'suu.sucursal_id')
                        ->where('mov.status', 'ACTIVO')
                        ->where('s.sucursal_id',$this->sucursal)
                        /* ->where('suu.estado','ACTIVO') */
                        ->orWhere('mov.status', 'INACTIVO')
                        ->where('mov.type', 'ANULADO')
                        ->select('order_services.*',
                            DB::raw('0 as fecha')
                        )
                        /* ->orderBy('order_services.id', 'desc') */
                        ->orderBy('fecha', 'desc')
                        ->distinct()
                        ->paginate($this->pagination);

                } elseif ($this->opciones == 'ANULADO') {

                    $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                        ->join('mov_services as ms', 's.id', 'ms.service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('users as u', 'u.id', 'mov.user_id')
                        ->join('sucursal_users as suu', 'u.id', 'suu.user_id')
                        ->join('sucursals as suc', 'suc.id', 'suu.sucursal_id')
                        ->where('mov.type', 'ANULADO')
                        ->where('s.sucursal_id',$this->sucursal)
                        /* ->where('suu.estado','ACTIVO') */
                        ->select('order_services.*')
                        /* ->orderBy('order_services.id', 'desc') */
                        /* ->orderBy('mov.created_at', 'desc') */
                        ->distinct()
                        ->paginate($this->pagination);
                } elseif ($this->opciones != 'fechas') {
                    $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                        ->join('mov_services as ms', 's.id', 'ms.service_id')
                        ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                        ->join('users as u', 'u.id', 'mov.user_id')
                        ->join('sucursal_users as suu', 'u.id', 'suu.user_id')
                        ->join('sucursals as suc', 'suc.id', 'suu.sucursal_id')
                        ->where('mov.type',  $this->opciones)
                        ->where('mov.status', 'ACTIVO')
                        ->where('s.sucursal_id',$this->sucursal)
                        /* ->where('suu.estado','ACTIVO') */
                        ->select('order_services.*')
                        /* ->orderBy('order_services.id', 'desc') */
                        /* ->orderBy('mov.created_at', 'desc') */
                        ->distinct()
                        ->paginate($this->pagination);
                } elseif ($this->opciones == 'fechas') {
                    if ($this->estado == 'Todos') {
                        if ($this->userId == 0) {
                            $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                                ->join('mov_services as ms', 's.id', 'ms.service_id')
                                ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->join('sucursal_users as suu', 'u.id', 'suu.user_id')
                                ->join('sucursals as suc', 'suc.id', 'suu.sucursal_id')
                                ->where('mov.status', 'ACTIVO')
                                ->where('s.sucursal_id',$this->sucursal)
                                /* ->where('suu.estado','ACTIVO') */
                                ->select('order_services.*')
                                ->whereBetween('mov.created_at', [$from, $to])
                                /* ->orderBy('order_services.id', 'desc') */
                                /* ->orderBy('mov.created_at', 'desc') */
                                ->distinct()
                                ->paginate($this->pagination);
                        } else {
                            $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                                ->join('mov_services as ms', 's.id', 'ms.service_id')
                                ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->join('sucursal_users as suu', 'u.id', 'suu.user_id')
                                ->join('sucursals as suc', 'suc.id', 'suu.sucursal_id')
                                ->select('order_services.*')
                                ->whereBetween('mov.created_at', [$from, $to])
                                ->where('mov.user_id', $this->userId)
                                ->where('mov.status', 'ACTIVO')
                                ->where('s.sucursal_id',$this->sucursal)
                                /* ->where('suu.estado','ACTIVO') */
                                /* ->orderBy('order_services.id', 'desc') */
                                /* ->orderBy('mov.created_at', 'desc') */
                                ->distinct()
                                ->paginate($this->pagination);
                        }
                    } else {
                        if ($this->userId == 0) {
                            $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                                ->join('mov_services as ms', 's.id', 'ms.service_id')
                                ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->join('sucursal_users as suu', 'u.id', 'suu.user_id')
                                ->join('sucursals as suc', 'suc.id', 'suu.sucursal_id')
                                ->select('order_services.*')
                                ->whereBetween('mov.created_at', [$from, $to])
                                ->where('mov.type', $this->estado)
                                ->where('mov.status', 'ACTIVO')
                                ->where('s.sucursal_id',$this->sucursal)
                                /* ->where('suu.estado','ACTIVO') */
                                /* ->orderBy('order_services.id', 'desc') */
                               /*  ->orderBy('mov.created_at', 'desc') */
                                ->distinct()
                                ->paginate($this->pagination);
                        } else {
                            $orderservices = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                                ->join('mov_services as ms', 's.id', 'ms.service_id')
                                ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                                ->join('users as u', 'u.id', 'mov.user_id')
                                ->join('sucursal_users as suu', 'u.id', 'suu.user_id')
                                ->join('sucursals as suc', 'suc.id', 'suu.sucursal_id')
                                ->select('order_services.*')
                                ->whereBetween('mov.created_at', [$from, $to])
                                ->where('mov.user_id', $this->userId)
                                ->where('mov.type', $this->estado)
                                ->where('mov.status', 'ACTIVO')
                                ->where('s.sucursal_id',$this->sucursal)
                                /* ->where('suu.estado','ACTIVO') */
                                /* ->orderBy('order_services.id', 'desc') */
                                /* ->orderBy('mov.created_at', 'desc') */
                                ->distinct()
                                ->paginate($this->pagination);
                        }
                    }
                }
            }
        }


        $orderser = OrderService::join(
            'services as s',
            'order_services.id',
            's.order_service_id'
        )
            ->join('mov_services as ms', 's.id', 'ms.service_id')
            ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
            ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
            ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
            ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
            ->where('mov.status', 'like', 'ACTIVO')
            ->select('order_services.*')
            ->orderBy('order_services.id', 'desc')
            ->distinct()
            ->paginate($this->pagination);

        foreach ($orderser as $os) {
            foreach ($os->services as $serv) {
                foreach ($serv->movservices as $ms) {
                    if ($ms->movs->type != 'ABANDONADO' && $ms->movs->status == 'ACTIVO') {
                        $date1 = new DateTime($serv->fecha_estimada_entrega);
                        $date2 = new DateTime("now");
                        $diff = $date1->diff($date2);

                        if ($diff->invert != 1) {
                            $serv->dias = (($diff->days)) + ($diff->d);
                            if ($serv->dias >= 90) {
                                $movimiento = $ms->movs;

                                DB::beginTransaction();
                                try {
                                    $mv = Movimiento::create([
                                        'type' => 'ABANDONADO',
                                        'status' => 'ACTIVO',
                                        'import' => $movimiento->import,
                                        'on_account' => $movimiento->on_account,
                                        'saldo' => $movimiento->saldo,
                                        'user_id' => Auth()->user()->id,
                                    ]);
                                    MovService::create([
                                        'movimiento_id' => $mv->id,
                                        'service_id' => $serv->id
                                    ]);
                                    ClienteMov::create([
                                        'movimiento_id' => $mv->id,
                                        'cliente_id' => $movimiento->climov->cliente_id,
                                    ]);

                                    DB::commit();
                                    $movimiento->update([
                                        'status' => 'INACTIVO'

                                    ]);

                                    /* $this->resetUI(); */
                                    /* $this->emit('product-added', 'Servicio en Proceso'); */
                                } catch (Exception $e) {
                                    DB::rollback();
                                    $this->emit('item-error', 'ERROR' . $e->getMessage());
                                }
                            }
                        }
                    }
                }
            }
        }




        //$users = User::all();
        $users = User::join('model_has_roles as mr', 'users.id', 'mr.model_id')
            ->join('roles as r', 'r.id', 'mr.role_id')
            ->join('role_has_permissions as rp', 'r.id', 'rp.role_id')
            ->join('permissions as p', 'p.id', 'rp.permission_id')
            ->where('p.name', 'Recepcionar_Servicio')
            ->where('users.status','ACTIVE')
            /* ->where('r.name', 'TECNICO')
            ->orWhere('r.name', 'SUPERVISOR')
            ->where('p.name', 'Orden_Servicio_Index')
            ->orWhere('r.name', 'ADMIN')
            ->where('p.name', 'Orden_Servicio_Index') */
            ->select('users.*')
            ->orderBy('name', 'asc')
            ->distinct()
            ->get();
        $typew = TypeWork::orderBy('name', 'asc')->get();
        $dato1 = CatProdService::orderBy('nombre', 'asc')->get();

        if ($this->catprodservid != 'Elegir') {
            $marca = SubCatProdService::where('cat_prod_service_id', $this->catprodservid)->orderBy('name', 'asc')->get();
        } else {
            $marca = [];
        }

        if ((strlen($this->import)) != 0 && (strlen($this->on_account) != 0))
            $this->saldo = $this->import - $this->on_account;
        elseif ((strlen($this->on_account) == 0))
            $this->saldo = $this->import;
        elseif ((strlen($this->import) == 0))
            $this->saldo = 0;




        return view('livewire.order_service.component', [
            'data' => $orderservices,
            'users' => $users,
            'work' => $typew,
            'cate' => $dato1,
            'marcas' => $marca,
            //'users' => User::orderBy('name', 'asc')->get(),
            'ordserv' => OrderService::orderBy('order_services.id', 'asc')
                ->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function IrInicio()
    {
        $this->redirect('inicio');
    }

    public function GoService()
    {
        session(['od' => null]);
        session(['clie' => null]);
        session(['tservice' => null]);
        $this->redirect('service');
    }

    public function EditService($id)
    {
        $this->orderservice = $id;
        $order = OrderService::find($id);
        $this->nombreCliente = $order->services[0]->movservices[0]->movs->climov->client;
        $this->type_service = $order->type_service;
        session(['clie' => $this->nombreCliente]);
        session(['od' => $this->orderservice]);
        session(['tservice' => $this->type_service]);

        $this->redirect('service');
    }

    public function VerAnular($id)
    {
        $order = OrderService::find($id);
        $this->emit('show-modalanular', 'show modal!');
    }

    public function Anular($id)
    {
        $order = OrderService::find($id);

        foreach ($order->services as $servicio) {
            foreach ($servicio->movservices as $mm) {
                if (($mm->movs->status == 'ACTIVO') && ($mm->movs->type == 'TERMINADO' || $mm->movs->type == 'ENTREGADO')) {
                    $this->emit('hide-modalanular-msg', 'Tiene un Servicio Entregado o Terminado');
                    return;
                }
            }
            foreach ($servicio->movservices as $mm) {
                if ($mm->movs->status == 'ACTIVO') {
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


        $this->emit('hide-modalanular-msg', 'Orden Anulada Correctamente');
    }

    public function VerEliminar($id)
    {
        $order = OrderService::find($id);
        $this->nombreCliente = $order->services[0]->movservices[0]->movs->climov->client->nombre;
        $this->celular = $order->services[0]->movservices[0]->movs->climov->client->celular;
        $this->emit('show-deletemodal', 'show modal!');
    }

    public function DeleteAllServices()
    {

        $orderservice = OrderService::select('order_services.*')->get();

        DB::beginTransaction();
        try {
            foreach($orderservice as $os){
                foreach ($os->services as $servicio) {
                    foreach ($servicio->movservices as $movimientoservicio) {
                        foreach ($movimientoservicio->movs->cartmov as $cmov){
                            $carteraMovimiento = $cmov;
                            $carteraMovimiento->delete();
                        }
                        $movimientoservicio->movs->climov->delete();
                        $movimiento = $movimientoservicio->movs;
                        $movimientoservicio->delete();
                        $movimiento->delete();
                    }
                    $servicio->delete();
                }
                $os->delete();
            }
            
            DB::commit();

            $this->resetUI();
            $this->emit('item', 'Servicios eliminados correctamente');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

    public function Delete($id)
    {
        $orderservice = OrderService::find($id);

        DB::beginTransaction();
        try {
            foreach ($orderservice->services as $servicio) {
                foreach ($servicio->movservices as $movimientoservicio) {
                    $movimientoservicio->movs->climov->delete();
                    $movimiento = $movimientoservicio->movs;
                    $movimientoservicio->delete();
                    $movimiento->delete();
                }
                $servicio->delete();
            }
            $orderservice->delete();

            DB::commit();

            $this->resetUI();
            $this->emit('hide-deletemodal-msg', 'Orden Eliminada Correctamente');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

    public function Edit($id)
    {
        $this->service1 = Service::find($id);

        $this->categoria = $this->service1->categoria->nombre;
        $this->marca = $this->service1->marca;
        $this->numeroOrden = $this->service1->order_service_id;
        $this->detalle1 = $this->service1->detalle;
        $this->falla_segun_cliente = $this->service1->falla_segun_cliente;
        $this->nombreCliente = $this->service1->movservices[0]->movs->climov->client->nombre;
        $this->celular = $this->service1->movservices[0]->movs->climov->client->celular;
        $this->users1 = $this->service1->movservices[0]->movs->user_id;
        $this->emit('show-modal', 'show modal!');
    }

    public function Detalles($id)
    {
        $this->service1 = Service::find($id);
        $this->typeworkid = TypeWork::find($this->service1->type_work_id)->id;
        $this->catprodservid = CatProdService::find($this->service1->cat_prod_service_id)->id;
        $this->proceso = false;
        $this->tipo = 'PENDIENTE';
        foreach ($this->service1->movservices as $mm) {
            if ($mm->movs->status == 'ACTIVO') {
                if ($mm->movs->type == 'PROCESO') {
                    $this->proceso = true;
                    $this->tipo = 'PROCESO';
                }
                if ($mm->movs->type == 'TERMINADO') {
                    $this->tipo = 'TERMINADO';
                }
                $this->import = $mm->movs->import;
                $this->on_account = $mm->movs->on_account;
                $this->saldo = $mm->movs->saldo;
                $this->nombreCliente = $mm->movs->climov->client->nombre;
                $this->celular = $mm->movs->climov->client->celular;
                $this->usuarioId = $mm->movs->user_id;
            }
        }
        $this->costo = $this->service1->costo;
        $this->detalle_costo = $this->service1->detalle_costo;
        $this->diagnostico = $this->service1->diagnostico;
        $this->solucion = $this->service1->solucion;
        $this->fecha_estimada_entrega = substr($this->service1->fecha_estimada_entrega, 0, 10);
        $this->hora_entrega = substr($this->service1->fecha_estimada_entrega, 11, 14);
        $this->detalle = $this->service1->detalle;
        $this->categoria = $this->service1->categoria->nombre;
        $this->marca = $this->service1->marca;
        $this->numeroOrden = $this->service1->order_service_id;
        $this->falla_segun_cliente = $this->service1->falla_segun_cliente;

        $this->emit('show-detail', 'show modal!');
    }

    public function DetallesTerminado($id)
    {
        $this->service1 = Service::find($id);
        $this->typeworkid = TypeWork::find($this->service1->type_work_id)->id;
        $this->catprodservid = CatProdService::find($this->service1->cat_prod_service_id)->id;

        $this->terminado = false;
        foreach ($this->service1->movservices as $mm) {
            if ($mm->movs->status == 'ACTIVO') {
                if ($mm->movs->type == 'TERMINADO') {
                    $this->terminado = true;
                }
                $this->import = $mm->movs->import;
                $this->on_account = $mm->movs->on_account;
                $this->saldo = $mm->movs->saldo;
                $this->nombreCliente = $mm->movs->climov->client->nombre;
                $this->celular = $mm->movs->climov->client->celular;
                $this->usuarioId = $mm->movs->user_id;
            }
        }
        $this->costo = $this->service1->costo;
        $this->detalle_costo = $this->service1->detalle_costo;
        $this->diagnostico = $this->service1->diagnostico;
        $this->solucion = $this->service1->solucion;
        $this->fecha_estimada_entrega = substr($this->service1->fecha_estimada_entrega, 0, 10);
        $this->hora_entrega = substr($this->service1->fecha_estimada_entrega, 11, 14);
        $this->detalle = $this->service1->detalle;
        $this->categoria = $this->service1->categoria->nombre;
        $this->marca = $this->service1->marca;
        $this->numeroOrden = $this->service1->order_service_id;
        $this->detalle1 = $this->service1->detalle;
        $this->falla_segun_cliente = $this->service1->falla_segun_cliente;

        $this->emit('show-detalle-entrega', 'show modal!');
    }

    public function DetalleEntregado($id)
    {
        $this->service1 = Service::find($id);
        $this->typeworkid = TypeWork::find($this->service1->type_work_id)->id;
        $this->catprodservid = CatProdService::find($this->service1->cat_prod_service_id)->id;

        foreach ($this->service1->movservices as $mm) {
            if ($mm->movs->status == 'ACTIVO') {
                if ($mm->movs->type == 'ENTREGADO') {
                    $this->tipo = 'ENTREGADO';
                }
                $this->import = $mm->movs->import;
                $this->on_account = $mm->movs->on_account;
                $this->saldo = $mm->movs->saldo;
                $this->nombreCliente = $mm->movs->climov->client->nombre;
                $this->celular = $mm->movs->climov->client->celular;
                $this->usuarioId = $mm->movs->user_id;
            }
        }
        $this->costo = $this->service1->costo;
        $this->detalle_costo = $this->service1->detalle_costo;
        $this->numeroOrden = $this->service1->order_service_id;
        $this->diagnostico = $this->service1->diagnostico;
        $this->solucion = $this->service1->solucion;
        $this->fecha_estimada_entrega = substr($this->service1->fecha_estimada_entrega, 0, 10);
        $this->hora_entrega = substr($this->service1->fecha_estimada_entrega, 11, 14);
        $this->detalle = $this->service1->detalle;
        $this->categoria = $this->service1->categoria->nombre;
        $this->marca = $this->service1->marca;
        $this->falla_segun_cliente = $this->service1->falla_segun_cliente;
        $this->emit('show-enddetail', 'show modal!');
    }

    public function buscarid($id)
    {
        session(['orderserv' => $id]);
        /* $this->opciones = 'TODOS'; */
        /* $this->redirect('orderservice'); */
        return redirect()->intended("orderservice");
    }

    public function Imprimir($id)
    {
        $this->orderservice = OrderService::find($id);
    }

    public function InfoService($id)
    {
        $this->service1 = Service::find($id);

        $this->typeworkid = TypeWork::find($this->service1->type_work_id)->name;
        $this->catprodservid = CatProdService::find($this->service1->cat_prod_service_id)->nombre;
        $this->diagnostico = $this->service1->diagnostico;
        $this->solucion = $this->service1->solucion;
        $this->fecha_estimada_entrega = substr($this->service1->fecha_estimada_entrega, 0, 10);
        $this->hora_entrega = substr($this->service1->fecha_estimada_entrega, 11, 14);

        $this->variable = false;

        foreach ($this->service1->movservices as $mm) {
            if ($mm->movs->status == 'ACTIVO') {
                $this->import = $mm->movs->import;
                $this->on_account = $mm->movs->on_account;
                $this->saldo = $mm->movs->saldo;
                $this->nombreCliente = $mm->movs->climov->client->nombre;
                $this->celular = $mm->movs->climov->client->celular;
                $this->usuarioId = $mm->movs->user_id;
                $this->nombreUsuario = $mm->movs->usermov->name;
            }
            if ($mm->movs->type == 'TERMINADO') {
                $this->nomUsuTerm = $mm->movs->usermov->name;
                $this->variable = true;
            }
        }
        $this->costo = $this->service1->costo;
        $this->detalle_costo = $this->service1->detalle_costo;
        $this->detalle = $this->service1->detalle;
        $this->categoria = $this->service1->categoria->nombre;
        $this->marca = $this->service1->marca;
        $this->numeroOrden = $this->service1->order_service_id;
        $this->falla_segun_cliente = $this->service1->falla_segun_cliente;

        $this->emit('show-infserv', 'show modal!');
    }

    public function VerOpciones($id)
    {
        $this->orderservice = $id;
        $orders = OrderService::find($id);
        $this->mostrar = 0;
        $this->mostrarEliminar = 0;

        foreach ($orders->services as $servic) {
            foreach ($servic->movservices as $mms) {
                if (($mms->movs->type == 'PENDIENTE'  && $mms->movs->status == 'ACTIVO') || ($mms->movs->type == 'PROCESO' && $mms->movs->status == 'ACTIVO')) {
                    $this->mostrar = 1;
                    $this->mostrarEliminar = 1;
                } elseif ($mms->movs->type == 'ANULADO') {
                    $this->mostrarEliminar = 1;
                }
            }
        }
        $this->emit('show-options', 'show modal!');
    }



    public function GuardarCambio(Service $service)
    {
        if($this->costo == ''){
            $this->costo = 0;
        }
        $from = Carbon::parse($this->fecha_estimada_entrega)->format('Y-m-d') . Carbon::parse($this->hora_entrega)->format(' H:i') . ':00';
        $service->update([
            'type_work_id' => $this->typeworkid,
            'cat_prod_service_id' => $this->catprodservid,
            'marca' => $this->marca,
            'detalle' => $this->detalle,
            'falla_segun_cliente' => $this->falla_segun_cliente,
            'diagnostico' => $this->diagnostico,
            'solucion' => $this->solucion,
            'costo' => $this->costo,
            'detalle_costo' => $this->detalle_costo,
            'fecha_estimada_entrega' => $from,

        ]);
        foreach ($this->service1->movservices as $mm) {
            /* $rules = [
                'on_account' => 'required_with:import|lt:import',
                'import' => 'required_with:on_account',
                
            ];
            $messages = [
                'import.required_with' => 'Ingrese un monto válido',
                'on_account.required_with' => 'Ingrese un monto válido.',
                'on_account.lt' => 'A cuenta no puede ser mayor al total',
            ];
            $this->validate($rules, $messages);

            if ($mm->movs->status == 'ACTIVO') {
                $mm->movs->update([
                    'import' => $this->import,
                    'on_account' => $this->on_account,
                    'saldo' => $this->saldo,
                ]);
            } */

            if ($this->on_account <= $this->import) {
                $mm->movs->update([
                    'import' => $this->import,
                    'on_account' => $this->on_account,
                    'saldo' => $this->saldo,
                ]);
            } else {
                $rules = [
                    'on_account' => 'required_with:import|lt:import',
                    'import' => 'required_with:on_account',
                ];
                $messages = [
                    'import.required_with' => 'Ingrese un monto válido',
                    'on_account.required_with' => 'Ingrese un monto válido.',
                    'on_account.lt' => 'A cuenta no puede ser mayor al total',
                ];
                $this->validate($rules, $messages);
            }
        }
        $this->resetUI();
        $this->emit('detail-hide-msg', 'Servicio Actualizado');
    }

    public function abrirventana($status)
    {

        session(['opcio' => $status]);

        return redirect()->intended("orderservice");
    }

    public function Cambio(Service $service)
    {
        foreach ($service->movservices as $servmov) {
            if ($servmov->movs->status == 'ACTIVO' && $servmov->movs->type == 'PENDIENTE') {
                $movimiento = $servmov->movs;

                DB::beginTransaction();
                try {
                    if (Auth::user()->hasPermissionTo('Asignar_Tecnico_Servicio')) {
                        $mv = Movimiento::create([
                            'type' => 'PROCESO',
                            'status' => 'ACTIVO',
                            'import' => $movimiento->import,
                            'on_account' => $movimiento->on_account,
                            'saldo' => $movimiento->saldo,
                            'user_id' => $this->users1,
                        ]);
                    } else {
                        $mv = Movimiento::create([
                            'type' => 'PROCESO',
                            'status' => 'ACTIVO',
                            'import' => $movimiento->import,
                            'on_account' => $movimiento->on_account,
                            'saldo' => $movimiento->saldo,
                            'user_id' => Auth()->user()->id,
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

                    $this->resetUI();
                    $this->emit('product-added', 'Servicio en Proceso');
                } catch (Exception $e) {
                    DB::rollback();
                    $this->emit('item-error', 'ERROR' . $e->getMessage());
                }
            }
        }
    }


    public function CambioProceso(Service $service)
    {
        $this->GuardarCambio($service);
        foreach ($service->movservices as $servmov) {

            if ($servmov->movs->status == 'ACTIVO' && $servmov->movs->type == 'PROCESO') {
                $movimiento = $servmov->movs;

                DB::beginTransaction();
                try {
                    if (Auth::user()->hasPermissionTo('Orden_Servicio_Index')) {
                        $mv = Movimiento::create([
                            'type' => 'TERMINADO',
                            'status' => 'ACTIVO',
                            'import' => $movimiento->import,
                            'on_account' => $movimiento->on_account,
                            'saldo' => $movimiento->saldo,
                            'user_id' => Auth()->user()->id,
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


                    $this->resetUI();
                    $this->emit('product-added', 'Servicio Terminado');
                } catch (Exception $e) {
                    DB::rollback();
                    $this->emit('item-error', 'ERROR' . $e->getMessage());
                }
            }
        }
    }

    public function CambioTerminado(Service $service)
    {

        $this->GuardarCambio($service);
        foreach ($service->movservices as $servmov) {

            if ($servmov->movs->status == 'ACTIVO' && $servmov->movs->type == 'TERMINADO') {
                $movimiento = $servmov->movs;

                DB::beginTransaction();
                try {
                    if (Auth::user()->hasPermissionTo('Boton_Entregar_Servicio')) {

                        $mv = Movimiento::create([
                            'type' => 'ENTREGADO',
                            'status' => 'ACTIVO',
                            'import' => $movimiento->import,
                            'on_account' => $movimiento->on_account,
                            'saldo' => $movimiento->saldo,
                            'user_id' => Auth()->user()->id,
                            /* 'user_id' => $movimiento->user_id */
                        ]);
                    }
                    $cajaActual = Caja::join('sucursals as s', 's.id', 'cajas.sucursal_id')
                        ->join('sucursal_users as su', 'su.sucursal_id', 's.id')
                        ->join('carteras as car', 'cajas.id', 'car.caja_id')
                        ->join('cartera_movs as cartmovs', 'car.id', 'cartmovs.cartera_id')
                        ->join('movimientos as mov', 'mov.id', 'cartmovs.movimiento_id')
                        ->where('mov.user_id', Auth()->user()->id)
                        ->where('mov.status', 'ACTIVO')
                        ->where('mov.type', 'APERTURA')
                        ->select('cajas.id as id')
                        ->get()->first();

                    if ($this->tipopago == 'EFECTIVO') {
                        $cartera = Cartera::where('tipo', 'cajafisica')
                            ->where('caja_id', $cajaActual->id)
                            ->get()->first();
                    } else {
                        $cartera = Cartera::where('tipo', 'Banco')
                            ->where('caja_id', '1')
                            ->get()
                            ->first();
                    }
                    CarteraMov::create([
                        'type' => 'INGRESO',
                        'tipoDeMovimiento' => 'SERVICIOS',
                        'comentario' => '',
                        'cartera_id' => $cartera->id,
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

                    $this->resetUI();
                    $this->tipopago = 'EFECTIVO';
                    $this->emit('hide-detalle-entrega-msg', 'Servicio Entregado');
                } catch (Exception $e) {
                    DB::rollback();
                    $this->emit('item-error', 'ERROR' . $e->getMessage());
                }
            }
        }
    }


    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(OrderService $product)
    {
        $imageTemp = $product->image;
        $product->delete();

        if ($imageTemp != null) {
            if (file_exists('storage/productos/' . $imageTemp)) {
                unlink('storage/productos/' . $imageTemp);
            }
        }
        $this->resetUI();
        $this->emit('product-deleted', 'Producto Eliminado');
    }
    public function resetUI()
    {
        $this->name = '';
        $this->barcode = '';
        $this->cost = '';
        $this->price = '';
        $this->stock = '';
        $this->alerts = '';
        /* $this->search = ''; */
        $this->categoryid = 'Elegir';
        $this->image = null;
        $this->selected_id = 0;

        $this->categoria = '';
        $this->marca = '';
        $this->numeroOrden = '';
        $this->detalle1 = '';
        $this->falla_segun_cliente = '';
        $this->nombreCliente = '';
        $this->celular = 0;
        $this->usuarioId = -1;

        $this->typeworkid = '';
        $this->catprodservid = '';
        $this->diagnostico = '';
        $this->solucion = '';
        $this->fecha_estimada_entrega = '';
        $this->hora_entrega = '';
        $this->import = 0;
        $this->on_account = 0;
        $this->saldo = 0;
        $this->detalle = '';

        $this->proceso = false;
        $this->terminado = false;

        $this->costo = 0;
        $this->detalle_costo = '';
        $this->nombreUsuario = '';
        
        /* $this->opciones = 'PENDIENTE'; */

        /* $this->condicion == 'MiSucursal'; */

        $this->resetValidation();
    }
}
