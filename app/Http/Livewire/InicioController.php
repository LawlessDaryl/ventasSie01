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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class InicioController extends Component
{
    use WithPagination;
    use WithFileUploads;

    private $pagination = 10;

    //Variable para seleccionar la sucursal 
    public $sucursal_id;
    //Variable para seleccionar el tipo de Servicio
    public $tipo_servicio;
    //Variable para seleccionar el tipo de Servicio
    public $search;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->sucursal_id = $this->idsucursal();
        $this->type = "PENDIENTE";
        $this->catprodservid = 'Todos';
    }

    public function render()
    {
        //Listar las sucursales
        $listasucursales = Sucursal::all();

        if (strlen($this->search) > 0)
        {
            if($this->type == "PENDIENTE")
                {
                    if ($this->catprodservid == 'Todos')
                    {
                        $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                                ->join('mov_services as ms', 'services.id', 'ms.service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
                                ->select('services.fecha_estimada_entrega as fecha_estimada_entrega',
                                'cps.nombre as nombrecategoria',
                                'services.marca as marca',
                                'services.detalle as detalle',
                                'services.falla_segun_cliente as falla_segun_cliente',
                                'services.id as id',
                                'os.id as id_orden',
                                DB::raw('0 as tiempo'),
                                DB::raw('0 as receptor'),
                                DB::raw('0 as encargado'))
                                ->where('mov.type', "PENDIENTE")
                                ->where('mov.status', 'ACTIVO')
                                ->where('os.id', 'like', '%' . $this->search . '%')
                                ->where('os.status', 'ACTIVO')
                                ->orderBy('services.fecha_estimada_entrega', 'asc')
                                ->distinct()
                                ->get();
                                
                            foreach ($orderservices as $c)
                            {
                                $c->receptor = $this->obtenerreceptor($c->id);
                                // $c->encargado tendrá el valor de "a" para ser tomado en cuenta en la vista Tabla
                                $c->encargado = "a";
                                $date1 = new DateTime($c->fecha_estimada_entrega);
                                $date2 = new DateTime("now");
                                $diff = $date2->diff($date1);
                                if ($diff->invert != 1)
                                {
                                    $c->tiempo = (($diff->days * 24)) + ($diff->h);
                                }
                                else
                                {
                                    $c->tiempo = -1;
                                }
                            }
                    }
                    else
                    {
                        $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                                ->join('mov_services as ms', 'services.id', 'ms.service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
                                ->select('services.fecha_estimada_entrega as fecha_estimada_entrega',
                                'cps.nombre as nombrecategoria',
                                'services.marca as marca',
                                'services.detalle as detalle',
                                'services.falla_segun_cliente as falla_segun_cliente',
                                'services.id as id',
                                'os.id as id_orden',
                                DB::raw('0 as tiempo'),
                                DB::raw('0 as receptor'),
                                DB::raw('0 as encargado'))
                                ->where('mov.type', "PENDIENTE")
                                ->where('mov.status', 'ACTIVO')
                                ->where('os.id', 'like', '%' . $this->search . '%')
                                ->where('cps.id', $this->catprodservid)
                                ->where('os.status', 'ACTIVO')
                                ->orderBy('services.fecha_estimada_entrega', 'asc')
                                ->distinct()
                                ->get();
                                
                            foreach ($orderservices as $c)
                            {
                                $c->receptor = $this->obtenerreceptor($c->id);
                                // $c->encargado tendrá el valor de "a" para ser tomado en cuenta en la vista Tabla
                                $c->encargado = "a";
                                $date1 = new DateTime($c->fecha_estimada_entrega);
                                $date2 = new DateTime("now");
                                $diff = $date2->diff($date1);
                                if ($diff->invert != 1)
                                {
                                    $c->tiempo = (($diff->days * 24)) + ($diff->h);
                                }
                                else
                                {
                                    $c->tiempo = -1;
                                }
                            }
                    }
                }
                else
                {
                    if($this->type == "PROCESO")
                    {
                        if ($this->catprodservid == 'Todos')
                        {
                            $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
                                    ->select('services.fecha_estimada_entrega as fecha_estimada_entrega',
                                    'cps.nombre as nombrecategoria',
                                    'services.marca as marca',
                                    'services.detalle as detalle',
                                    'services.falla_segun_cliente as falla_segun_cliente',
                                    'services.id as id',
                                    'os.id as id_orden',
                                    DB::raw('0 as tiempo'),
                                    DB::raw('0 as receptor'),
                                    DB::raw('0 as encargado'))
                                    ->where('mov.type', "PROCESO")
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('os.id', 'like', '%' . $this->search . '%')
                                    ->where('os.status', 'ACTIVO')
                                    ->orderBy('services.fecha_estimada_entrega', 'asc')
                                    ->distinct()
                                    ->get();
                                    
                                foreach ($orderservices as $c)
                                {
                                    $c->receptor = $this->obtenerreceptor($c->id);
                                    $c->encargado = $this->obtenerencargado($c->id);
                                    $date1 = new DateTime($c->fecha_estimada_entrega);
                                    $date2 = new DateTime("now");
                                    $diff = $date2->diff($date1);
                                    
                                    if ($diff->invert != 1)
                                    {
                                        $c->tiempo = (($diff->days * 24)) + ($diff->h);
                                    }
                                    else
                                    {
                                        $c->tiempo = -1;
                                    }
                                }
                        }
                        else
                        {
                            $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                                ->join('mov_services as ms', 'services.id', 'ms.service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
                                ->select('services.fecha_estimada_entrega as fecha_estimada_entrega',
                                'cps.nombre as nombrecategoria',
                                'services.marca as marca',
                                'services.detalle as detalle',
                                'services.falla_segun_cliente as falla_segun_cliente',
                                'services.id as id',
                                'os.id as id_orden',
                                DB::raw('0 as tiempo'),
                                DB::raw('0 as receptor'),
                                DB::raw('0 as encargado'))
                                ->where('mov.type', "PROCESO")
                                ->where('mov.status', 'ACTIVO')
                                ->where('os.id', 'like', '%' . $this->search . '%')
                                ->where('cps.id', $this->catprodservid)
                                ->where('os.status', 'ACTIVO')
                                ->orderBy('services.fecha_estimada_entrega', 'asc')
                                ->distinct()
                                ->get();
                                
                            foreach ($orderservices as $c)
                            {
                                $c->receptor = $this->obtenerreceptor($c->id);
                                $c->encargado = $this->obtenerencargado($c->id);
                                $date1 = new DateTime($c->fecha_estimada_entrega);
                                $date2 = new DateTime("now");
                                $diff = $date2->diff($date1);
                                if ($diff->invert != 1)
                                {
                                    $c->tiempo = (($diff->days * 24)) + ($diff->h);
                                }
                                else
                                {
                                    $c->tiempo = -1;
                                }
                            }
                        }
                    }
                    else
                    {
                        //Cuando el Tipo de Servicio sea Terminado
                        if ($this->catprodservid == 'Todos')
                        {
                            $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
                                    ->select('services.fecha_estimada_entrega as fecha_estimada_entrega',
                                    'cps.nombre as nombrecategoria',
                                    'services.marca as marca',
                                    'services.detalle as detalle',
                                    'services.falla_segun_cliente as falla_segun_cliente',
                                    'services.id as id',
                                    'os.id as id_orden',
                                    DB::raw('0 as tiempo'),
                                    DB::raw('0 as receptor'),
                                    DB::raw('0 as encargado'))
                                    ->where('mov.type', "TERMINADO")
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('os.id', 'like', '%' . $this->search . '%')
                                    ->where('os.status', 'ACTIVO')
                                    ->orderBy('tiempo', 'desc')
                                    ->distinct()
                                    ->get();
                                    
                                foreach ($orderservices as $c)
                                {
                                    $c->receptor = $this->obtenerreceptor($c->id);
                                    $c->encargado = $this->obtenerencargado($c->id);
                                    $c->tiempo = $this->obtenertiempo($c->id);
                                }
                        }
                        else
                        {
                            $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                                ->join('mov_services as ms', 'services.id', 'ms.service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
                                ->select('services.fecha_estimada_entrega as fecha_estimada_entrega',
                                'cps.nombre as nombrecategoria',
                                'services.marca as marca',
                                'services.detalle as detalle',
                                'services.falla_segun_cliente as falla_segun_cliente',
                                'services.id as id',
                                'os.id as id_orden',
                                DB::raw('0 as tiempo'),
                                DB::raw('0 as receptor'),
                                DB::raw('0 as encargado'))
                                ->where('mov.type', "TERMINADO")
                                ->where('mov.status', 'ACTIVO')
                                ->where('os.id', 'like', '%' . $this->search . '%')
                                ->where('cps.id', $this->catprodservid)
                                ->where('os.status', 'ACTIVO')
                                ->orderBy('services.fecha_estimada_entrega', 'asc')
                                ->distinct()
                                ->get();
                                
                            foreach ($orderservices as $c)
                            {
                                $c->receptor = $this->obtenerreceptor($c->id);
                                $c->encargado = $this->obtenerencargado($c->id);
                                $c->tiempo = $this->obtenertiempo($c->id);
                            }
                        }
                    }
                }
        }
        else
        {
            //Si selecciona Todas las Sucursales
            if($this->sucursal_id == 'Todos')
            {
                if($this->type == "PENDIENTE")
                {
                    if ($this->catprodservid == 'Todos')
                    {
                        $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                                ->join('mov_services as ms', 'services.id', 'ms.service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
                                ->select('services.fecha_estimada_entrega as fecha_estimada_entrega',
                                'cps.nombre as nombrecategoria',
                                'services.marca as marca',
                                'services.detalle as detalle',
                                'services.falla_segun_cliente as falla_segun_cliente',
                                'services.id as id',
                                'os.id as id_orden',
                                DB::raw('0 as tiempo'),
                                DB::raw('0 as receptor'),
                                DB::raw('0 as encargado'))
                                ->where('mov.type', "PENDIENTE")
                                ->where('mov.status', 'ACTIVO')
                                ->where('os.status', 'ACTIVO')
                                ->orderBy('services.fecha_estimada_entrega', 'asc')
                                ->distinct()
                                ->get();
                                
                            foreach ($orderservices as $c)
                            {
                                $c->receptor = $this->obtenerreceptor($c->id);
                                // $c->encargado tendrá el valor de "a" para ser tomado en cuenta en la vista Tabla
                                $c->encargado = "a";
                                $date1 = new DateTime($c->fecha_estimada_entrega);
                                $date2 = new DateTime("now");
                                $diff = $date2->diff($date1);
                                if ($diff->invert != 1)
                                {
                                    $c->tiempo = (($diff->days * 24)) + ($diff->h);
                                }
                                else
                                {
                                    $c->tiempo = -1;
                                }
                            }
                    }
                    else
                    {
                        $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                                ->join('mov_services as ms', 'services.id', 'ms.service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
                                ->select('services.fecha_estimada_entrega as fecha_estimada_entrega',
                                'cps.nombre as nombrecategoria',
                                'services.marca as marca',
                                'services.detalle as detalle',
                                'services.falla_segun_cliente as falla_segun_cliente',
                                'services.id as id',
                                'os.id as id_orden',
                                DB::raw('0 as tiempo'),
                                DB::raw('0 as receptor'),
                                DB::raw('0 as encargado'))
                                ->where('mov.type', "PENDIENTE")
                                ->where('mov.status', 'ACTIVO')
                                ->where('cps.id', $this->catprodservid)
                                ->where('os.status', 'ACTIVO')
                                ->orderBy('services.fecha_estimada_entrega', 'asc')
                                ->distinct()
                                ->get();
                                
                            foreach ($orderservices as $c)
                            {
                                $c->receptor = $this->obtenerreceptor($c->id);
                                // $c->encargado tendrá el valor de "a" para ser tomado en cuenta en la vista Tabla
                                $c->encargado = "a";
                                $date1 = new DateTime($c->fecha_estimada_entrega);
                                $date2 = new DateTime("now");
                                $diff = $date2->diff($date1);
                                if ($diff->invert != 1)
                                {
                                    $c->tiempo = (($diff->days * 24)) + ($diff->h);
                                }
                                else
                                {
                                    $c->tiempo = -1;
                                }
                            }
                    }
                }
                else
                {
                    if($this->type == "PROCESO")
                    {
                        if ($this->catprodservid == 'Todos')
                        {
                            $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
                                    ->select('services.fecha_estimada_entrega as fecha_estimada_entrega',
                                    'cps.nombre as nombrecategoria',
                                    'services.marca as marca',
                                    'services.detalle as detalle',
                                    'services.falla_segun_cliente as falla_segun_cliente',
                                    'services.id as id',
                                    'os.id as id_orden',
                                    DB::raw('0 as tiempo'),
                                    DB::raw('0 as receptor'),
                                    DB::raw('0 as encargado'))
                                    ->where('mov.type', "PROCESO")
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('os.status', 'ACTIVO')
                                    ->orderBy('services.fecha_estimada_entrega', 'asc')
                                    ->distinct()
                                    ->get();
                                    
                                foreach ($orderservices as $c)
                                {
                                    $c->receptor = $this->obtenerreceptor($c->id);
                                    $c->encargado = $this->obtenerencargado($c->id);
                                    $date1 = new DateTime($c->fecha_estimada_entrega);
                                    $date2 = new DateTime("now");
                                    $diff = $date2->diff($date1);
                                    
                                    if ($diff->invert != 1)
                                    {
                                        $c->tiempo = (($diff->days * 24)) + ($diff->h);
                                    }
                                    else
                                    {
                                        $c->tiempo = -1;
                                    }
                                }
                        }
                        else
                        {
                            $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                                ->join('mov_services as ms', 'services.id', 'ms.service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
                                ->select('services.fecha_estimada_entrega as fecha_estimada_entrega',
                                'cps.nombre as nombrecategoria',
                                'services.marca as marca',
                                'services.detalle as detalle',
                                'services.falla_segun_cliente as falla_segun_cliente',
                                'services.id as id',
                                'os.id as id_orden',
                                DB::raw('0 as tiempo'),
                                DB::raw('0 as receptor'),
                                DB::raw('0 as encargado'))
                                ->where('mov.type', "PROCESO")
                                ->where('mov.status', 'ACTIVO')
                                ->where('cps.id', $this->catprodservid)
                                ->where('os.status', 'ACTIVO')
                                ->orderBy('services.fecha_estimada_entrega', 'asc')
                                ->distinct()
                                ->get();
                                
                            foreach ($orderservices as $c)
                            {
                                $c->receptor = $this->obtenerreceptor($c->id);
                                $c->encargado = $this->obtenerencargado($c->id);
                                $date1 = new DateTime($c->fecha_estimada_entrega);
                                $date2 = new DateTime("now");
                                $diff = $date2->diff($date1);
                                if ($diff->invert != 1)
                                {
                                    $c->tiempo = (($diff->days * 24)) + ($diff->h);
                                }
                                else
                                {
                                    $c->tiempo = -1;
                                }
                            }
                        }
                    }
                    else
                    {
                        //Cuando el Tipo de Servicio sea Terminado
                        if ($this->catprodservid == 'Todos')
                        {
                            $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
                                    ->select('services.fecha_estimada_entrega as fecha_estimada_entrega',
                                    'cps.nombre as nombrecategoria',
                                    'services.marca as marca',
                                    'services.detalle as detalle',
                                    'services.falla_segun_cliente as falla_segun_cliente',
                                    'services.id as id',
                                    'os.id as id_orden',
                                    DB::raw('0 as tiempo'),
                                    DB::raw('0 as receptor'),
                                    DB::raw('0 as encargado'))
                                    ->where('mov.type', "TERMINADO")
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('os.status', 'ACTIVO')
                                    ->orderBy('tiempo', 'desc')
                                    ->distinct()
                                    ->get();
                                    
                                foreach ($orderservices as $c)
                                {
                                    $c->receptor = $this->obtenerreceptor($c->id);
                                    $c->encargado = $this->obtenerencargado($c->id);
                                    $c->tiempo = $this->obtenertiempo($c->id);
                                }
                        }
                        else
                        {
                            $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                                ->join('mov_services as ms', 'services.id', 'ms.service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
                                ->select('services.fecha_estimada_entrega as fecha_estimada_entrega',
                                'cps.nombre as nombrecategoria',
                                'services.marca as marca',
                                'services.detalle as detalle',
                                'services.falla_segun_cliente as falla_segun_cliente',
                                'services.id as id',
                                'os.id as id_orden',
                                DB::raw('0 as tiempo'),
                                DB::raw('0 as receptor'),
                                DB::raw('0 as encargado'))
                                ->where('mov.type', "TERMINADO")
                                ->where('mov.status', 'ACTIVO')
                                ->where('cps.id', $this->catprodservid)
                                ->where('os.status', 'ACTIVO')
                                ->orderBy('services.fecha_estimada_entrega', 'asc')
                                ->distinct()
                                ->get();
                                
                            foreach ($orderservices as $c)
                            {
                                $c->receptor = $this->obtenerreceptor($c->id);
                                $c->encargado = $this->obtenerencargado($c->id);
                                $c->tiempo = $this->obtenertiempo($c->id);
                            }
                        }
                    }
                }
            }
            else
            {
                if($this->type == "PENDIENTE")
                {
                    if ($this->catprodservid == 'Todos')
                    {
                        $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                                ->join('mov_services as ms', 'services.id', 'ms.service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
                                ->select('services.fecha_estimada_entrega as fecha_estimada_entrega',
                                'cps.nombre as nombrecategoria',
                                'services.marca as marca',
                                'services.detalle as detalle',
                                'services.falla_segun_cliente as falla_segun_cliente',
                                'services.id as id',
                                'os.id as id_orden',
                                DB::raw('0 as tiempo'),
                                DB::raw('0 as receptor'),
                                DB::raw('0 as encargado'))
                                ->where('mov.type', "PENDIENTE")
                                ->where('mov.status', 'ACTIVO')
                                ->where('os.status', 'ACTIVO')
                                ->where('services.sucursal_id',$this->sucursal_id)
                                ->orderBy('services.fecha_estimada_entrega', 'asc')
                                ->distinct()
                                ->get();
                                
                            foreach ($orderservices as $c)
                            {
                                $c->receptor = $this->obtenerreceptor($c->id);
                                // $c->encargado tendrá el valor de "a" para ser tomado en cuenta en la vista Tabla
                                $c->encargado = "a";
                                $date1 = new DateTime($c->fecha_estimada_entrega);
                                $date2 = new DateTime("now");
                                $diff = $date2->diff($date1);
                                if ($diff->invert != 1)
                                {
                                    $c->tiempo = (($diff->days * 24)) + ($diff->h);
                                }
                                else
                                {
                                    $c->tiempo = -1;
                                }
                            }
                    }
                    else
                    {
                        $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                                ->join('mov_services as ms', 'services.id', 'ms.service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
                                ->select('services.fecha_estimada_entrega as fecha_estimada_entrega',
                                'cps.nombre as nombrecategoria',
                                'services.marca as marca',
                                'services.detalle as detalle',
                                'services.falla_segun_cliente as falla_segun_cliente',
                                'services.id as id',
                                'os.id as id_orden',
                                DB::raw('0 as tiempo'),
                                DB::raw('0 as receptor'),
                                DB::raw('0 as encargado'))
                                ->where('mov.type', "PENDIENTE")
                                ->where('mov.status', 'ACTIVO')
                                ->where('cps.id', $this->catprodservid)
                                ->where('os.status', 'ACTIVO')
                                ->where('services.sucursal_id',$this->sucursal_id)
                                ->orderBy('services.fecha_estimada_entrega', 'asc')
                                ->distinct()
                                ->get();
                                
                            foreach ($orderservices as $c)
                            {
                                $c->receptor = $this->obtenerreceptor($c->id);
                                // $c->encargado tendrá el valor de "a" para ser tomado en cuenta en la vista Tabla
                                $c->encargado = "a";
                                $date1 = new DateTime($c->fecha_estimada_entrega);
                                $date2 = new DateTime("now");
                                $diff = $date2->diff($date1);
                                if ($diff->invert != 1)
                                {
                                    $c->tiempo = (($diff->days * 24)) + ($diff->h);
                                }
                                else
                                {
                                    $c->tiempo = -1;
                                }
                            }
                    }
                }
                else
                {
                    if($this->type == "PROCESO")
                    {
                        if ($this->catprodservid == 'Todos')
                        {
                            $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
                                    ->select('services.fecha_estimada_entrega as fecha_estimada_entrega',
                                    'cps.nombre as nombrecategoria',
                                    'services.marca as marca',
                                    'services.detalle as detalle',
                                    'services.falla_segun_cliente as falla_segun_cliente',
                                    'services.id as id',
                                    'os.id as id_orden',
                                    DB::raw('0 as tiempo'),
                                    DB::raw('0 as receptor'),
                                    DB::raw('0 as encargado'))
                                    ->where('mov.type', "PROCESO")
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('os.status', 'ACTIVO')
                                    ->where('services.sucursal_id', $this->sucursal_id)
                                    ->orderBy('services.fecha_estimada_entrega', 'asc')
                                    ->distinct()
                                    ->get();
                                    
                                foreach ($orderservices as $c)
                                {
                                    $c->receptor = $this->obtenerreceptor($c->id);
                                    $c->encargado = $this->obtenerencargado($c->id);
                                    $date1 = new DateTime($c->fecha_estimada_entrega);
                                    $date2 = new DateTime("now");
                                    $diff = $date2->diff($date1);
                                    
                                    if ($diff->invert != 1)
                                    {
                                        $c->tiempo = (($diff->days * 24)) + ($diff->h);
                                    }
                                    else
                                    {
                                        $c->tiempo = -1;
                                    }
                                }
                        }
                        else
                        {
                            $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                                ->join('mov_services as ms', 'services.id', 'ms.service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
                                ->select('services.fecha_estimada_entrega as fecha_estimada_entrega',
                                'cps.nombre as nombrecategoria',
                                'services.marca as marca',
                                'services.detalle as detalle',
                                'services.falla_segun_cliente as falla_segun_cliente',
                                'services.id as id',
                                'os.id as id_orden',
                                DB::raw('0 as tiempo'),
                                DB::raw('0 as receptor'),
                                DB::raw('0 as encargado'))
                                ->where('mov.type', "PROCESO")
                                ->where('mov.status', 'ACTIVO')
                                ->where('cps.id', $this->catprodservid)
                                ->where('os.status', 'ACTIVO')
                                ->where('services.sucursal_id',$this->sucursal_id)
                                ->orderBy('services.fecha_estimada_entrega', 'asc')
                                ->distinct()
                                ->get();
                                
                            foreach ($orderservices as $c)
                            {
                                $c->receptor = $this->obtenerreceptor($c->id);
                                $c->encargado = $this->obtenerencargado($c->id);
                                $date1 = new DateTime($c->fecha_estimada_entrega);
                                $date2 = new DateTime("now");
                                $diff = $date2->diff($date1);
                                if ($diff->invert != 1)
                                {
                                    $c->tiempo = (($diff->days * 24)) + ($diff->h);
                                }
                                else
                                {
                                    $c->tiempo = -1;
                                }
                            }
                            // $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                            //         ->join('mov_services as ms', 'services.id', 'ms.service_id')
                            //         ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                            //         ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                            //         ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                            //         ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                            //         ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                            //         ->join('users as u', 'u.id', 'mov.user_id')
                            //         ->select(
                            //             'services.*',
                            //             DB::raw('0 as tiempo')
                            //         )
                            //         ->where('mov.type', $this->type)
                            //         ->where('mov.status', 'ACTIVO')
                            //         ->where('cat.id', $this->catprodservid)
                            //         ->where('os.status', 'ACTIVO')
                            //         ->where('services.sucursal_id',$this->sucursal_id)
                            //         ->orderBy('services.fecha_estimada_entrega', 'asc')
                            //         ->distinct()
                            //         ->get();
                            //         foreach ($orderservices as $c) {
                            //             $date1 = new DateTime($c->fecha_estimada_entrega);
                            //             $date2 = new DateTime("now");
                            //             $diff = $date2->diff($date1);
                            //             if ($diff->invert != 1) {
                            //                 $c->tiempo = (($diff->days * 24)) + ($diff->h) /* . ' tiempo' */;
                            //             } else {
                            //                 $c->tiempo = 'EXPIRADO';
                            //             }
                            //         }
                        }
                    }
                    else
                    {
                        //Cuando el Tipo de Servicio sea Terminado
                        if ($this->catprodservid == 'Todos')
                        {
                            $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                    ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
                                    ->select('services.fecha_estimada_entrega as fecha_estimada_entrega',
                                    'cps.nombre as nombrecategoria',
                                    'services.marca as marca',
                                    'services.detalle as detalle',
                                    'services.falla_segun_cliente as falla_segun_cliente',
                                    'services.id as id',
                                    'os.id as id_orden',
                                    DB::raw('0 as tiempo'),
                                    DB::raw('0 as receptor'),
                                    DB::raw('0 as encargado'))
                                    ->where('mov.type', "TERMINADO")
                                    ->where('mov.status', 'ACTIVO')
                                    ->where('os.status', 'ACTIVO')
                                    ->where('services.sucursal_id', $this->sucursal_id)
                                    ->orderBy('tiempo', 'desc')
                                    ->distinct()
                                    ->get();
                                    
                                foreach ($orderservices as $c)
                                {
                                    $c->receptor = $this->obtenerreceptor($c->id);
                                    $c->encargado = $this->obtenerencargado($c->id);
                                    $c->tiempo = $this->obtenertiempo($c->id);
                                }
                        }
                        else
                        {
                            $orderservices = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                                ->join('mov_services as ms', 'services.id', 'ms.service_id')
                                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                                ->join('cat_prod_services as cps', 'cps.id', 'services.cat_prod_service_id')
                                ->select('services.fecha_estimada_entrega as fecha_estimada_entrega',
                                'cps.nombre as nombrecategoria',
                                'services.marca as marca',
                                'services.detalle as detalle',
                                'services.falla_segun_cliente as falla_segun_cliente',
                                'services.id as id',
                                'os.id as id_orden',
                                DB::raw('0 as tiempo'),
                                DB::raw('0 as receptor'),
                                DB::raw('0 as encargado'))
                                ->where('mov.type', "TERMINADO")
                                ->where('mov.status', 'ACTIVO')
                                ->where('cps.id', $this->catprodservid)
                                ->where('os.status', 'ACTIVO')
                                ->where('services.sucursal_id',$this->sucursal_id)
                                ->orderBy('services.fecha_estimada_entrega', 'asc')
                                ->distinct()
                                ->get();
                                
                            foreach ($orderservices as $c)
                            {
                                $c->receptor = $this->obtenerreceptor($c->id);
                                $c->encargado = $this->obtenerencargado($c->id);
                                $c->tiempo = $this->obtenertiempo($c->id);
                            }
                        }
                    }
                }
            }
        }




        $categorias = CatProdService::orderBy('nombre', 'asc')->get();


        return view('livewire.inicio.component', [
            'listasucursales' => $listasucursales,
            'orderservices' => $orderservices,
            'categorias' => $categorias
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    //Obtener el Nombre del usuario que recepciona el servicio (Buscando por el Id del Servicio, no por el Orden del Servicio)
    public function obtenerreceptor($id)
    {
        $listamovimientos = MovService::select("mov_services.movimiento_id as id")
        ->where("mov_services.service_id",$id)->get();
        foreach($listamovimientos as $mov)
        {
            $movimiento = Movimiento::find($mov->id);
            if($movimiento->type == "PENDIENTE")
            {
                return User::find($movimiento->user_id)->name;
                break;
            }
        }
    }
    //Obtener el Nombre del usuario que realiza el servicio (Buscando por el Id del Servicio, no por el Orden del Servicio)
    public function obtenerencargado($id)
    {
        $listamovimientos = MovService::select("mov_services.movimiento_id as id")
        ->where("mov_services.service_id",$id)->get();
        foreach($listamovimientos as $mov)
        {
            $movimiento = Movimiento::find($mov->id);
            if($movimiento->type == $this->type)
            {
                if(User::find($movimiento->user_id)->id == Auth()->user()->id)
                {
                    return User::find($movimiento->user_id)->name;
                    break;
                }
                else
                {
                    return "";
                }
            }
        }
    }
    //Verificar si un servicio fue entregado (Buscando por el Id del Servicio, no por el Orden del Servicio)
    public function verificarentregado($id)
    {
        $listamovimientos = MovService::select("mov_services.movimiento_id as id")
        ->where("mov_services.service_id",$id)->get();
        foreach($listamovimientos as $mov)
        {
            $movimiento = Movimiento::find($mov->id);
            if($movimiento->type == "ENTREGADO")
            {
                return "a";
                break;
            }
        }
        return "b";
    }
    //Obtener el tiempo desde que el servicio a concluido hasta el tiempo actual(Buscando por le Id del Servicio)
    public function obtenertiempo($id)
    {
        $listamovimientos = MovService::select("mov_services.movimiento_id as id")
        ->where("mov_services.service_id",$id)->get();

        foreach($listamovimientos as $mov)
        {
            $movimiento = Movimiento::find($mov->id);
            if($movimiento->type == "TERMINADO")
            {
                $fechaAntigua  = $movimiento->updated_at;
 
                $fechaActual = Carbon::parse(Carbon::now());

                $cantidadDias = $fechaAntigua->diffInDays($fechaActual);
                return $cantidadDias;
                break;
            }
        }
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
