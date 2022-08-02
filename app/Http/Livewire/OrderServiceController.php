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
    public $edit_precioservicioterminado, $edit_acuentaservicioterminado, $edit_saldoterminado;

    //Variables para cambiar técnico responsable
    public $id_usuario, $tipo;


    use WithPagination;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->paginacion = 50;
        $this->type = "PENDIENTE";
        $this->sucursal_id = $this->idsucursal();
        $this->catprodservid = "Todos";
        $this->tipofecha = 'hoy';
        $this->masfiltros = false;
        $this->usuarios = 'Todos';
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




    }
    public function render()
    {



        //Para Actualizar Saldo en la Ventana Modal Editar Servicio
        $this->edit_saldo = $this->edit_precioservicio - $this->edit_acuenta;
        //Para Actualizar Saldo en la Ventana Modal Editar Servicio Terminado
        $this->edit_saldoterminado = $this->edit_precioservicioterminado - $this->edit_acuentaservicioterminado;

        //Listar a los usuarios tecnicos responsables
        $this->lista_de_usuarios = $this->listarusuarios();
        if($this->sucursal_id != "Todos")
        {
            if($this->type != "Todos")
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
                    "order_services.type_service as tiposervicio",
                    "c.nombre as nombrecliente",
                    "c.id as idcliente",
                    'u.name as usuarioreceptor',
                    "mov.import as importe",
                    DB::raw('0 as num'),
                    DB::raw('0 as servicios'))
                    ->where('order_services.status', 'ACTIVO')
                    ->where('mov.type', $this->type)
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
                        $os->servicios = $this->detalle_orden_de_servicio($this->type, $os->codigo);
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
                    "order_services.type_service as tiposervicio",
                    'u.name as usuarioreceptor',
                    "c.nombre as nombrecliente",
                    "c.id as idcliente",
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
                        $os->servicios = $this->detalle_orden_de_servicio('Todos', $os->codigo);
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
    //Mostrar u Ocultar Mas filtros en la Vista
    public function mostrarocultarmasfiltros()
    {
        if($this->masfiltros)
        {
            $this->masfiltros = false;
        }
        else
        {
            $this->masfiltros = true;
        }
    }
    //Obtener el detalle de servicios a travez del id de la orden de servicio
    public function detalle_orden_de_servicio($tipo, $id_orden_de_servicio)
    {
        if($tipo != 'Todos')
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

        }
        else
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
            'services.marca as marca',
            DB::raw('0 as responsabletecnico'),
            DB::raw('0 as tecnicoreceptor'))
            ->where('mov.status', 'ACTIVO')
            ->where('services.order_service_id', $id_orden_de_servicio)
            ->get();

            foreach ($servicios as $ser)
            {
                $ser->responsabletecnico = $this->obtener_tecnico_responsable($ser->idservicio);
                $ser->tecnicoreceptor = $this->obtener_tecnico_receptor($ser->idservicio);
            }
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
                    if (($servmov->movs->type == 'TERMINADO'|| $servmov->movs->type == 'ENTREGADO') && $servmov->movs->status == 'ACTIVO')
                    {
                        return User::find($servmov->movs->user_id)->name;
                        break;
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
        //Actualizando variable $id_orden_de_servicio para mostrar el codigo de la orden del servicio en el titulo de la ventana modal
        $this->id_orden_de_servicio = $idordendeservicio;

        $this->id_servicio = $idservicio;
        $this->detallesservicios('PENDIENTE', $idservicio);
        if (Auth::user()->hasPermissionTo('Asignar_Tecnico_Servicio'))
        {
            $this->emit('show-asignartecnicoresponsable', 'show modal!');
        }
        else
        {
            dd("asd");
        }
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
        ->select("users.id as idusuario","users.name as nombreusuario",DB::raw('0 as proceso'), DB::raw('0 as terminado'))
        ->where('os.status', 'ACTIVO')
        ->where('m.status', 'ACTIVO')
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
                        dd("Si no tiene permiso");
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
                    
                    //$this->emit('product-added', 'Servicio en Proceso');
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

        $this->emit('show-asignartecnicoresponsablecerrar', 'show modal!');

    }
    //Llama al método modaleditarservicio pero ocultando los parámetros para Terminar un Servicio
    public function modaleditarservicio1($type, $idservicio, $idordendeservicio)
    {
        $this->tipo = $type;
        $this->mostrarterminar = "No";
        $this->modaleditarservicio($type, $idservicio, $idordendeservicio);
    }
    //Llama al método modaleditarservicio pero mostrando los parámetros para Terminar un Servicio
    public function modaleditarservicio2($type, $idservicio, $idordendeservicio)
    {
        $this->tipo = $type;
        $this->mostrarterminar = "Si";
        $this->modaleditarservicio($type, $idservicio, $idordendeservicio);
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
                        'import' => $movimiento->import,
                        'on_account' => $movimiento->on_account,
                        'saldo' => $movimiento->saldo,
                        'user_id' => $movimiento->user_id,
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
    public function saberactivo($id)
    {
        $datoscliente = Service::find($id);
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



        $this->id_usuario = $detallesservicio->idusuario;
        $this->edit_precioservicioterminado = $detallesservicio->precioservicio;
        $this->edit_acuentaservicioterminado = $detallesservicio->acuenta;
        $this->edit_saldoterminado = $this->edit_precioservicioterminado - $this->edit_acuentaservicioterminado;
        
        $this->emit('show-editarservicioterminado', 'show modal!');
    }

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
        
        $servicio->update([
            'import' => $this->edit_precioservicioterminado,
            'user_id' => $this->id_usuario,
            'on_account' => $this->edit_acuentaservicioterminado,
            'saldo' => $this->edit_saldoterminado,
        ]);

        $this->emit('show-editarservicioterminadoocultar', 'show modal!');
    }


}
