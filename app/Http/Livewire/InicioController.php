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
        $opciones, $tipopago, $condicional, $fechahoy, $horaActual, $condicion, $diffmin;


    private $pagination = 10;
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
        $this->catprodservid = 'Todos';
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
        $this->tipopago = 'EFECTIVO';
        if((Auth::user()->hasPermissionTo('Recepcionar_Servicio')) && (Auth::user()->hasPermissionTo('Boton_Entregar_Servicio'))){
            $this->condicional = 'Pendientes';
        }elseif(Auth::user()->hasPermissionTo('Boton_Entregar_Servicio'))
        {
            $this->condicional = 'TerminadosTodos';
        }elseif(Auth::user()->hasPermissionTo('Recepcionar_Servicio'))
        {
            $this->condicional = 'Pendientes';
        }
        $this->condicion = 'MiSucursal';
        $this->usuariolog = Auth()->user()->name;
        $this->fechahoy = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->diffmin = '';
    }

    public function render()
    {
        $data = Caja::join('sucursals as s', 's.id', 'cajas.sucursal_id')
            ->join('sucursal_users as su', 'su.sucursal_id', 's.id')
            ->join('carteras as car', 'cajas.id', 'car.caja_id')
            ->join('cartera_movs as cartmovs', 'car.id', 'cartmovs.cartera_id')
            ->join('movimientos as mov', 'mov.id', 'cartmovs.movimiento_id')
            ->where('mov.user_id', Auth()->user()->id)
            ->where('mov.status', 'ACTIVO')
            ->where('mov.type', 'APERTURA')
            ->select('cajas.*', 's.name as sucursal')
            ->get()->first();
         
        if ($data) {
            session(['sesionCaja' => $data->nombre]);
        } else{
            session(['sesionCaja' => null]);
        }

        $this->horaActual = date("d-m-y H:i:s ");

        $user = User::find(Auth()->user()->id);
        foreach($user->sucursalusers as $usersuc){
            if($usersuc->estado == 'ACTIVO'){
                $this->sucursal= $usersuc->sucursal->id;
            }
        }

        if (strlen($this->search) > 0) {
            if ($this->condicional == 'TerminadosTodos'){
                if ($this->catprodservid != 'Todos') {
                    $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                        ->join('mov_services as ms', 'services.id', 'ms.service_id')
                        ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                        ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                        ->join('users as u', 'u.id', 'mov.user_id')
                        ->join('sucursal_users as suu', 'u.id', 'suu.user_id')
                        ->join('sucursals as suc', 'suc.id', 'suu.sucursal_id')
                        ->select(
                            'services.*',
                            DB::raw('0 as dias')
                        )
                        ->where('mov.type', 'TERMINADO')
                        /* ->where('mov.user_id', Auth()->user()->id) */
                        ->where('mov.status', 'ACTIVO')
                        ->where('os.id', 'like', '%' . $this->search . '%')
                        ->where('cat.id', $this->catprodservid)
                        ->where('os.status', 'ACTIVO')
                        ->where('suc.id',$this->sucursal)
                        ->where('suu.estado','ACTIVO')
                        ->orderBy('services.fecha_estimada_entrega', 'asc')
                        ->distinct()
                        ->paginate($this->pagination);
                        foreach ($orderservices as $c) {
                            /* $date1 = new DateTime($c->fecha_estimada_entrega);
                            $date2 = new DateTime("now");
                            $diff = $date2->diff($date1);
                            if ($diff->invert == 1) {
                                $c->dias = (($diff->days)) + ($diff->d);
                            } */
    
                            foreach($c->movservices as $mm){
                                if($mm->movs->type == 'TERMINADO'){
                                    $date1 = new DateTime($mm->movs->created_at);
                                    $date2 = new DateTime("now");
                                    $diff = $date2->diff($date1);
                                    if ($diff->invert == 1) {
                                        $c->dias = (($diff->days)) + ($diff->d);
                                        $c->dias = $c->dias / 2;
                                    }
                                }
                            }
    
                        }
                } else {
                    $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                        ->join('mov_services as ms', 'services.id', 'ms.service_id')
                        ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                        ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                        ->join('users as u', 'u.id', 'mov.user_id')
                        ->join('sucursal_users as suu', 'u.id', 'suu.user_id')
                        ->join('sucursals as suc', 'suc.id', 'suu.sucursal_id')
                        ->select(
                            'services.*',
                            DB::raw('0 as dias')/* ,
                            DB::raw('0 as minutos') */
                        )
                        ->where('mov.type', 'TERMINADO')
                        /* ->where('mov.user_id', Auth()->user()->id) */
                        ->where('os.id', 'like', '%' . $this->search . '%')
                        ->where('mov.status', 'ACTIVO')
                        ->where('os.status', 'ACTIVO')
                        ->where('suc.id',$this->sucursal)
                        ->where('suu.estado','ACTIVO')
                        ->orderBy('services.fecha_estimada_entrega', 'asc')
                        ->distinct()
                        ->paginate($this->pagination);
                        
                        foreach ($orderservices as $c) {
                            /* $date1 = new DateTime($c->fecha_estimada_entrega);
                            $date2 = new DateTime("now");
                            $diff = $date2->diff($date1);
                            
                            if ($diff->invert == 1) {
                                $c->dias = (($diff->days)) + ($diff->d);
                            } */
    
                            foreach($c->movservices as $mm){
                                if($mm->movs->type == 'TERMINADO'){
                                    $date1 = new DateTime($mm->movs->created_at);
                                    $date2 = new DateTime("now");
                                    $diff = $date2->diff($date1);
                                    if ($diff->invert == 1) {
                                        $c->dias = (($diff->days)) + ($diff->d);
                                        $c->dias = $c->dias / 2;
                                    }
                                }
                            }
    
                        }
                }

            }
        }
        else{

        

        /* dd($horaActual); */
        if ($this->condicional == 'Pendientes') {
            if($this->condicion == 'Todos'){
                if ($this->catprodservid != 'Todos') {
                    $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                        ->join('mov_services as ms', 'services.id', 'ms.service_id')
                        ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                        ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                        ->join('users as u', 'u.id', 'mov.user_id')
                        ->select(
                            'services.*',
                            DB::raw('0 as horas')
                        )
                        ->where('mov.type', 'PENDIENTE')
                        ->where('mov.status', 'ACTIVO')
                        ->where('cat.id', $this->catprodservid)
                        ->where('os.status', 'ACTIVO')
                        ->orderBy('services.fecha_estimada_entrega', 'asc')
                        ->distinct()
                        ->paginate($this->pagination);
                        foreach ($orderservices as $c) {
                            $date1 = new DateTime($c->fecha_estimada_entrega);
                            $date2 = new DateTime("now");
                            $diff = $date2->diff($date1);
                            if ($diff->invert != 1) {
                                $c->horas = (($diff->days * 24)) + ($diff->h) /* . ' horas' */;
                            } else {
                                $c->horas = 'EXPIRADO';
                            }
                        }
                } else {
                    $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                        ->join('mov_services as ms', 'services.id', 'ms.service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->select(
                            'services.*',
                            DB::raw('0 as horas')/* ,
                            DB::raw('0 as minutos') */
                        )
                        ->where('mov.type', 'PENDIENTE')
                        ->where('mov.status', 'ACTIVO')
                        ->where('os.status', 'ACTIVO')
                        ->orderBy('services.fecha_estimada_entrega', 'asc')
                        ->distinct()
                        ->paginate($this->pagination);
                        
                    foreach ($orderservices as $c) {
                        $date1 = new DateTime($c->fecha_estimada_entrega);
                        $date2 = new DateTime("now");
                        $diff = $date2->diff($date1);
                        if ($diff->invert != 1) {
                            $c->horas = (($diff->days * 24)) + ($diff->h) /* . ' horas' */;
                        } else {
                            $c->horas = 'EXPIRADO';
                        }
                    }
                }
            }elseif($this->condicion == 'MiSucursal'){
                if ($this->catprodservid != 'Todos') {
                    $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                        ->join('mov_services as ms', 'services.id', 'ms.service_id')
                        ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                        ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                        ->join('users as u', 'u.id', 'mov.user_id')
                        ->join('sucursal_users as suu', 'u.id', 'suu.user_id')
                        ->join('sucursals as suc', 'suc.id', 'suu.sucursal_id')
                        ->select(
                            'services.*',
                            DB::raw('0 as horas')
                        )
                        ->where('mov.type', 'PENDIENTE')
                        ->where('mov.status', 'ACTIVO')
                        ->where('cat.id', $this->catprodservid)
                        ->where('os.status', 'ACTIVO')
                        ->where('suc.id',$this->sucursal)
                        ->where('suu.estado','ACTIVO')
                        ->orderBy('services.fecha_estimada_entrega', 'asc')
                        ->distinct()
                        ->paginate($this->pagination);
                        foreach ($orderservices as $c) {
                            $date1 = new DateTime($c->fecha_estimada_entrega);
                            $date2 = new DateTime("now");
                            $diff = $date2->diff($date1);
                            if ($diff->invert != 1) {
                                $c->horas = (($diff->days * 24)) + ($diff->h) /* . ' horas' */;
                            } else {
                                $c->horas = 'EXPIRADO';
                            }
                        }
                } else {
                    $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                        ->join('mov_services as ms', 'services.id', 'ms.service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('users as u', 'u.id', 'mov.user_id')
                        ->join('sucursal_users as suu', 'u.id', 'suu.user_id')
                        ->join('sucursals as suc', 'suc.id', 'suu.sucursal_id')
                        ->select(
                            'services.*',
                            DB::raw('0 as horas')/* ,
                            DB::raw('0 as minutos') */
                        )
                        ->where('mov.type', 'PENDIENTE')
                        ->where('mov.status', 'ACTIVO')
                        ->where('os.status', 'ACTIVO')
                        ->where('suc.id',$this->sucursal)
                        ->where('suu.estado','ACTIVO')
                        ->orderBy('services.fecha_estimada_entrega', 'asc')
                        ->distinct()
                        ->paginate($this->pagination);
                        
                    foreach ($orderservices as $c) {
                        $date1 = new DateTime($c->fecha_estimada_entrega);
                        $date2 = new DateTime("now");
                        $diff = $date2->diff($date1);

                        /* $this->diffmin = (($diff->days * 24)* 60) + ($diff->i); */

                        if ($diff->invert != 1) {
                            $c->horas = (($diff->days * 24)) + ($diff->h)/*  . ' horas' */;
                            /* $c->minutos = (($diff->days * 24* 60)) + ($diff->i); */
                            /* $this->diffmin; */
                        } else {
                            $c->horas = 'EXPIRADO';
                            /* $c->minutos = 'EXPIRADO'; */
                        }
                    }
                }
            }

        }elseif ($this->condicional == 'Terminados') {
            
            if ($this->catprodservid != 'Todos') {
                
                $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                    ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                    ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                    ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                    ->join('users as u', 'u.id', 'mov.user_id')
                    ->select(
                        'services.*',
                        DB::raw('0 as dias')
                    )
                    ->where('mov.type', 'TERMINADO')
                    ->where('mov.user_id', Auth()->user()->id)
                    ->where('mov.status', 'ACTIVO')
                    ->where('cat.id', $this->catprodservid)
                    ->where('os.status', 'ACTIVO')
                    ->orderBy('services.fecha_estimada_entrega', 'asc')
                    ->distinct()
                    ->paginate($this->pagination);
                    foreach ($orderservices as $c) {
                        /* $date1 = new DateTime($c->fecha_estimada_entrega);
                        $date2 = new DateTime("now");
                        $diff = $date2->diff($date1);
                        if ($diff->invert == 1) {
                            $c->dias = (($diff->days)) + ($diff->d);
                        } */

                        foreach($c->movservices as $mm){
                            if($mm->movs->type == 'TERMINADO'){
                                $date1 = new DateTime($mm->movs->created_at);
                                $date2 = new DateTime("now");
                                $diff = $date2->diff($date1);
                                if ($diff->invert == 1) {
                                    $c->dias = (($diff->days)) + ($diff->d);
                                    $c->dias = $c->dias / 2;
                                }
                            }
                        }

                    }
                    


            } else {
                
                $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                    ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                    ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                    ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                    ->join('users as u', 'u.id', 'mov.user_id')
                    ->select(
                        'services.*',
                        DB::raw('0 as dias')/* ,
                        DB::raw('0 as minutos') */
                    )
                    ->where('mov.type', 'TERMINADO')
                    ->where('mov.user_id', Auth()->user()->id)
                    ->where('mov.status', 'ACTIVO')
                    ->where('os.status', 'ACTIVO')
                    ->orderBy('services.fecha_estimada_entrega', 'asc')
                    ->distinct()
                    ->paginate($this->pagination);
                    
                    foreach ($orderservices as $c) {
                        /* $date1 = new DateTime($c->fecha_estimada_entrega);
                        $date2 = new DateTime("now");
                        $diff = $date2->diff($date1);
                        
                        if ($diff->invert == 1) {
                            $c->dias = (($diff->days)) + ($diff->d);
                        } */

                        foreach($c->movservices as $mm){
                            if($mm->movs->type == 'TERMINADO'){
                                $date1 = new DateTime($mm->movs->created_at);
                                $date2 = new DateTime("now");
                                $diff = $date2->diff($date1);
                                
                                if ($diff->invert == 1) {
                                    $c->dias = (($diff->days)) + ($diff->d);
                                    $c->dias = $c->dias / 2;

                                }
                            }
                        }

                    }
            }
        }elseif($this->condicional == 'TerminadosTodos'){
            if ($this->catprodservid != 'Todos') {
                
                $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                    ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                    ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                    ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                    ->join('users as u', 'u.id', 'mov.user_id')
                    ->join('sucursal_users as suu', 'u.id', 'suu.user_id')
                    ->join('sucursals as suc', 'suc.id', 'suu.sucursal_id')
                    ->select(
                        'services.*',
                        DB::raw('0 as dias')
                    )
                    ->where('mov.type', 'TERMINADO')
                    /* ->where('mov.user_id', Auth()->user()->id) */
                    ->where('mov.status', 'ACTIVO')
                    ->where('cat.id', $this->catprodservid)
                    ->where('os.status', 'ACTIVO')
                    ->where('suc.id',$this->sucursal)
                    ->where('suu.estado','ACTIVO')
                    ->orderBy('services.fecha_estimada_entrega', 'asc')
                    ->distinct()
                    ->paginate($this->pagination);
                    foreach ($orderservices as $c) {
                        /* $date1 = new DateTime($c->fecha_estimada_entrega);
                        $date2 = new DateTime("now");
                        $diff = $date2->diff($date1);
                        if ($diff->invert == 1) {
                            $c->dias = (($diff->days)) + ($diff->d);
                        } */

                        foreach($c->movservices as $mm){
                            if($mm->movs->type == 'TERMINADO'){
                                $date1 = new DateTime($mm->movs->created_at);
                                $date2 = new DateTime("now");
                                $diff = $date2->diff($date1);
                                if ($diff->invert == 1) {
                                    $c->dias = (($diff->days)) + ($diff->d);
                                    $c->dias = $c->dias / 2;
                                }
                            }
                        }

                    }
            } else {
                $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                    ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                    ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                    ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                    ->join('users as u', 'u.id', 'mov.user_id')
                    ->join('sucursal_users as suu', 'u.id', 'suu.user_id')
                    ->join('sucursals as suc', 'suc.id', 'suu.sucursal_id')
                    ->select(
                        'services.*',
                        DB::raw('0 as dias')/* ,
                        DB::raw('0 as minutos') */
                    )
                    ->where('mov.type', 'TERMINADO')
                    /* ->where('mov.user_id', Auth()->user()->id) */
                    ->where('mov.status', 'ACTIVO')
                    ->where('os.status', 'ACTIVO')
                    ->where('suc.id',$this->sucursal)
                    ->where('suu.estado','ACTIVO')
                    ->orderBy('services.fecha_estimada_entrega', 'asc')
                    ->distinct()
                    ->paginate($this->pagination);
                    
                    foreach ($orderservices as $c) {
                        /* $date1 = new DateTime($c->fecha_estimada_entrega);
                        $date2 = new DateTime("now");
                        $diff = $date2->diff($date1);
                        
                        if ($diff->invert == 1) {
                            $c->dias = (($diff->days)) + ($diff->d);
                        } */

                        foreach($c->movservices as $mm){
                            if($mm->movs->type == 'TERMINADO'){
                                $date1 = new DateTime($mm->movs->created_at);
                                $date2 = new DateTime("now");
                                $diff = $date2->diff($date1);
                                if ($diff->invert == 1) {
                                    $c->dias = (($diff->days)) + ($diff->d);
                                    $c->dias = $c->dias / 2;
                                }
                            }
                        }

                    }
            }
        }elseif($this->condicional == 'EntregadosPropios'){
            if ($this->catprodservid != 'Todos') {
                $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                    ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                    ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                    ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                    ->join('users as u', 'u.id', 'mov.user_id')
                    ->select(
                        'services.*',
                        DB::raw('0 as horas')
                    )
                    ->where('mov.type', 'ENTREGADO')
                    ->where('mov.user_id', Auth()->user()->id)
                    ->where('mov.status', 'ACTIVO')
                    ->where('cat.id', $this->catprodservid)
                    ->where('os.status', 'ACTIVO')
                    ->orderBy('services.fecha_estimada_entrega', 'asc')
                    ->distinct()
                    ->paginate($this->pagination);
                    foreach ($orderservices as $c) {
                        $date1 = new DateTime($c->fecha_estimada_entrega);
                        $date2 = new DateTime("now");
                        $diff = $date2->diff($date1);
                        if ($diff->invert != 1) {
                            $c->horas = (($diff->days * 24)) + ($diff->h) /* . ' horas' */;
                        } else {
                            $c->horas = 'EXPIRADO';
                        }
                    }
            } else {

                $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                    ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                    ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                    ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                    ->join('users as u', 'u.id', 'mov.user_id')
                    ->select(
                        'services.*',
                        DB::raw('0 as horas')
                    )
                    ->where('mov.type', 'ENTREGADO')
                    ->where('mov.user_id', Auth()->user()->id)
                    ->where('mov.status', 'ACTIVO')
                    ->where('os.status', 'ACTIVO')
                    ->orderBy('services.fecha_estimada_entrega', 'asc')
                    ->distinct()
                    ->paginate($this->pagination);
                    foreach ($orderservices as $c) {
                        $date1 = new DateTime($c->fecha_estimada_entrega);
                        $date2 = new DateTime("now");
                        $diff = $date2->diff($date1);
                        if ($diff->invert != 1) {
                            $c->horas = (($diff->days * 24)) + ($diff->h) /* . ' horas' */;
                        } else {
                            $c->horas = 'EXPIRADO';
                        }
                    }
            }
        }    
        else {

            if ($this->catprodservid != 'Todos') {
                $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                    ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                    ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                    ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                    ->join('users as u', 'u.id', 'mov.user_id')
                    ->select(
                        'services.*',
                        DB::raw('0 as horas')
                    )
                    ->where('mov.type', 'PROCESO')
                    ->where('mov.user_id', Auth()->user()->id)
                    ->where('mov.status', 'ACTIVO')
                    ->where('cat.id', $this->catprodservid)
                    ->where('os.status', 'ACTIVO')
                    ->orderBy('services.fecha_estimada_entrega', 'asc')
                    ->distinct()
                    ->paginate($this->pagination);
                    foreach ($orderservices as $c) {
                        $date1 = new DateTime($c->fecha_estimada_entrega);
                        $date2 = new DateTime("now");
                        $diff = $date2->diff($date1);
                        if ($diff->invert != 1) {
                            $c->horas = (($diff->days * 24)) + ($diff->h) /* . ' horas' */;
                        } else {
                            $c->horas = 'EXPIRADO';
                        }
                    }
            } else {

                $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                    ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                    ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                    ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                    ->join('users as u', 'u.id', 'mov.user_id')
                    ->select(
                        'services.*',
                        DB::raw('0 as horas')
                    )
                    ->where('mov.type', 'PROCESO')
                    ->where('mov.user_id', Auth()->user()->id)
                    ->where('mov.status', 'ACTIVO')
                    ->where('os.status', 'ACTIVO')
                    ->orderBy('services.fecha_estimada_entrega', 'asc')
                    ->distinct()
                    ->paginate($this->pagination);
                    foreach ($orderservices as $c) {
                        $date1 = new DateTime($c->fecha_estimada_entrega);
                        $date2 = new DateTime("now");
                        $diff = $date2->diff($date1);
                        if ($diff->invert != 1) {
                            $c->horas = (($diff->days * 24)) + ($diff->h) /* . ' horas' */;
                        } else {
                            $c->horas = 'EXPIRADO';
                        }
                    }
            }
        }
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

    public function GoOrderservice()
    {
        $this->redirect('orderservice');
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
        $this->catprodservid = 'Todos';
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
