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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class InicioController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $search, $selected_id, $pageTitle, $componentName,
        $cliente, $fecha_estimada_entrega, $detalle, $status, $saldo, $on_account, $import,
        $serviceid, $movtype, $orderservice, $users1, $service1, $categoria, $marca, $numeroOrden, $detalle1, $falla_segun_cliente, $nombreCliente, $celular, $usuarioId,
        $typew, $typeworkid, $catprodservid, $diagnostico, $solucion, $hora_entrega, $proceso,
        $terminado, $costo, $detalle_costo, $nombreUsuario, $modificar, $type_service, $movimiento,
        $opciones, $tipopago;


    private $pagination = 5;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Ordenes de Servicio';
        $this->usuarioId = -1;

        $this->typeworkid = '';
        $this->catprodservid = 'Elegir';
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
        $this->usuariolog = Auth()->user()->name;

    }
    
    public function render()
    {
        if (strlen($this->search) > 0) {
            $orderservices = OrderService::join(
                'services as s',
                'order_services.id',
                's.order_service_id'
            )
                ->join('mov_services as ms', 's.id', 'ms.service_id')
                ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                ->join('users as u', 'u.id', 'mov.user_id')
                ->select('order_services.*')
                ->where('mov.type', $this->opciones)
                ->where('mov.status', 'ACTIVO')
                ->where('cat.nombre',$this->catprodservid)
                ->orWhere('c.nombre', 'like', '%' . $this->search . '%')
                ->orWhere('order_services.id', 'like', '%' . $this->search . '%')
                ->orWhere('order_services.type_service', 'like', '%' . $this->search . '%')
                ->orWhere('cat.nombre', 'like', '%' . $this->search . '%')
                ->orWhere('s.detalle', 'like', '%' . $this->search . '%')
                ->orWhere('s.marca', 'like', '%' . $this->search . '%')
                ->orWhere('s.falla_segun_cliente', 'like', '%' . $this->search . '%')
                ->orWhere('u.name', 'like', '%' . $this->search . '%')
                ->orWhere('mov.import', 'like', '%' . $this->search . '%')
                
                ->distinct()
                ->orderBy('order_services.id', 'desc')
                ->paginate($this->pagination);
        } elseif ($this->opciones == 'TODOS') {
            $orderservices = OrderService::join(
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
        } elseif ($this->catprodservid != 'Elegir') {
            $orderservices = OrderService::join(
                'services as s',
                'order_services.id',
                's.order_service_id'
            )
                ->join('mov_services as ms', 's.id', 'ms.service_id')
                ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                ->where('mov.type', 'like', '%' . $this->opciones)
                ->where('mov.status', 'like', 'ACTIVO')
                ->where('cat.id',$this->catprodservid)
                ->select('order_services.*')
                ->orderBy('order_services.id', 'desc')
                ->distinct()
                ->paginate($this->pagination);
        }else {
            $orderservices = OrderService::join(
                'services as s',
                'order_services.id',
                's.order_service_id'
            )
                ->join('mov_services as ms', 's.id', 'ms.service_id')
                ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                ->where('mov.type', 'like', '%' . $this->opciones)
                ->where('mov.status', 'like', 'ACTIVO')
                ->where('mov.user_id', Auth()->user()->id)
                ->select('order_services.*')
                ->orderBy('order_services.id', 'desc')
                ->distinct()
                ->paginate($this->pagination);
        }
        $users = User::all();
        $typew = TypeWork::orderBy('name', 'asc')->get();
        $dato1 = CatProdService::orderBy('nombre', 'asc')->get();


        return view('livewire.inicio.component', [
            'data' => $orderservices,
            'users' => $users,
            'work' => $typew,
            'cate' => $dato1,
            'ordserv' => OrderService::orderBy('order_services.id', 'asc')
                ->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function ListadoTipo()
    {
        $orderservices = OrderService::join(
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
            ->where('mov.type', $this->opciones)
            ->select('order_services.*')
            ->orderBy('order_services.id', 'desc')
            ->distinct()
            ->paginate($this->pagination);
    }

    
    
    public function resetUI()
    {
        $this->name = '';
        $this->barcode = '';
        $this->cost = '';
        $this->price = '';
        $this->stock = '';
        $this->alerts = '';
        $this->search = '';
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
        $this->catprodservid = 'Elegir';
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

        $this->resetValidation();
    }
    
}
