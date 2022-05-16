<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cartera;
use App\Models\ModelHasRoles;
use App\Models\Movimiento;
use App\Models\OrderService;
use App\Models\Service;
use App\Models\Transaccion;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReportEntregadoServController extends Component
{
    public $componentName, $data, $details, $sumDetails, $countDetails, $reportType,
        $userId, $dateFrom, $dateTo, $transaccionId, $estado, $fechas, $sumaEfectivo,
        $sumaBanco, $cajaSucursal, $caja, $movbancarios, $contador, $sumaCosto,
        $sumaUtilidad, $sumaUtilidadBanco,$sumaUtilidadTotal;

    public function mount()
    {
        $this->componentName = 'REPORTES SERVICIOS ENTREGADOS';
        $this->data = [];
        $this->details = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->reportType = 0;
        $this->userId = 0;
        $this->estado = 'ENTREGADO';
        $this->transaccionId = 0;
        $this->fechas = [];
        $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->sumaEfectivo = 0;
        $this->sumaBanco = 0;
        $this->cajaSucursal = [];
        $this->caja = 'Todos';
        $this->movbancarios = [];
        $this->contador = 0;
        $this->sumaCosto = 0;
        $this->sumaUtilidad = 0;
        $this->sumaUtilidadBanco = 0;
        $this->sumaUtilidadTotal = 0;
    }

    public function render()
    {
        $this->sumaEfectivo = 0;
        $this->sumaBanco = 0;
        $this->sumaCosto = 0;
        $this->sumaUtilidad = 0;
        $this->sumaUtilidadBanco = 0;
        $this->sumaUtilidadTotal = 0;

        $user = User::find(Auth()->user()->id);
        foreach ($user->sucursalusers as $usersuc) {
            if ($usersuc->estado == 'ACTIVO') {
                $this->sucursal = $usersuc->sucursal->id;
            }
        }

        $this->cajaSucursal = Caja::where('sucursal_id', $this->sucursal)
            ->where('nombre', '!=', 'Caja General')->get();

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

        $this->trsbydate();

        
        if ('Todos' == $this->caja) {
            $totalEfectivo = Cartera::join('cajas as caj', 'caj.id', 'carteras.caja_id')
                ->join('sucursals as s', 's.id', 'caj.sucursal_id')
                ->join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
                ->join('movimientos as m', 'm.id', 'cm.movimiento_id')
                ->join('mov_services as ms', 'ms.movimiento_id', 'm.id')
                ->join('services as serv', 'serv.id', 'ms.service_id')
                ->select('m.*')
                ->whereBetween('m.created_at', [$from, $to])
                ->where('m.status', 'ACTIVO')
                ->where('cm.tipoDeMovimiento', 'SERVICIOS')
                ->where('carteras.tipo', 'CajaFisica')
                ->where('s.id', $this->sucursal)
                /* ->where('services.sucursal_id',$this->sucursal) */
                ->get();
            $this->sumaEfectivo = $totalEfectivo->sum('import');

            $totalBanco = Cartera::join('cajas as caj', 'caj.id', 'carteras.caja_id')
                ->join('sucursals as s', 's.id', 'caj.sucursal_id')
                ->join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
                ->join('movimientos as m', 'm.id', 'cm.movimiento_id')
                ->join('mov_services as ms', 'ms.movimiento_id', 'm.id')
                ->join('services as serv', 'serv.id', 'ms.service_id')
                ->select('m.*')
                ->whereBetween('m.created_at', [$from, $to])
                ->where('m.status', 'ACTIVO')
                ->where('cm.tipoDeMovimiento', 'SERVICIOS')
                ->where('carteras.tipo', 'Banco')
                ->where('s.id', $this->sucursal)
                /* ->where('services.sucursal_id',$this->sucursal) */
                ->get();
            $this->sumaBanco = $totalBanco->sum('import');
        }
   
        return view('livewire.reporte_serv_entreg.component', [
           
            'cajas' => $this->cajaSucursal
        ])->extends('layouts.theme.app')
            ->section('content');
    }

    public function trsbydate()
    {

        if ($this->reportType == 0) {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        } else {
         
                $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
                $to = Carbon::parse($this->dateTo)->format('Y-m-d')     . ' 23:59:59';
           
        }

        if ($this->reportType == 1 && ($this->dateFrom == '' || $this->dateTo == '')) {
            return;
        }

        if ($this->caja != 'Todos') {
            $this->data = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'mov.id')
                ->join('carteras as c', 'c.id', 'cmv.cartera_id')
                ->join('cajas as ca', 'ca.id', 'c.caja_id')
                ->where('mov.status', 'ACTIVO')
                ->select(
                    'services.*',
                    DB::raw('0 as utilidad')
                )
                ->where('ca.id', $this->caja)
                ->where('mov.type', 'ENTREGADO')
                ->whereBetween('mov.created_at', [$from, $to])
                ->distinct()
                ->get();

                foreach ($this->data as $serv) {
                    foreach ($serv->movservices as $mm) {
                        if ($mm->movs->status == 'ACTIVO') {
                            $serv->utilidad = $mm->movs->import - $serv->costo;
                            $this->sumaUtilidad += $serv->utilidad;
                        }
                    }
                }

           


            $data1 = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
            ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
            ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'mov.id')
            ->join('carteras as c', 'c.id', 'cmv.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->where('mov.status', 'ACTIVO')
            ->select(
                'mov.*',
               
            )
            ->where('ca.id', $this->caja)
            ->where('mov.type', 'ENTREGADO')
            ->whereBetween('mov.created_at', [$from, $to])
            ->distinct()
            ->get();

            $banco = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'mov.id')
                ->join('carteras as c', 'c.id', 'cmv.cartera_id')
                ->join('cajas as ca', 'ca.id', 'c.caja_id')
                ->join('sucursals as s', 's.id', 'ca.sucursal_id')
                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                ->join('clientes as cli', 'cli.id', 'cliemov.cliente_id')
                ->join('users as u', 'u.id', 'mov.user_id')
                
                ->where('mov.status', 'like', 'ACTIVO')
                ->select(
                    'services.*',
                    'u.*',
                    'u.id as idusuario',
                    'ca.*',
                    'cmv.*',
                    'cmv.created_at as creacion_cartMov',
                    'mov.*',
                    'mov.created_at as creacion_Mov',
                    'mov.type as type',
                    'mov.status as status',
                    'cli.*',
                    'cli.nombre as nomCli',
                    'os.id as orderId',
                    'services.marca as marca',
                    'services.detalle as detalle',
                    'cat.nombre as nomCat',
                    'services.costo as costo',
                    'mov.import as import',
                    DB::raw('0 as utilidad')
                )
                
              
                ->where('ca.id', '1')
                ->where('mov.type', 'ENTREGADO')
                ->whereBetween('mov.created_at', [$from, $to])
              
                ->distinct()
                ->get();
            $this->contador = $this->data->count();

            /*  dd($banco); */

            $this->movbancarios = [];
            
            foreach ($banco as  $value) {
                $aperturasCierres = Caja::join('carteras as car', 'cajas.id', 'car.caja_id')
                    ->join('cartera_movs as cartmovs', 'car.id', 'cartmovs.cartera_id')
                    ->join('movimientos as mov', 'mov.id', 'cartmovs.movimiento_id')
                    ->select('mov.*')
                    ->where('cajas.id', $this->caja)
                    ->where('mov.user_id', $value->idusuario)
                    ->where('mov.type', 'APERTURA')
                    ->orWhere('mov.type', 'CIERRE')
                    ->get();

                $break = 0;
                $hasta = 0;

                foreach ($aperturasCierres as  $value2) {

                    if ($value2->status == 'ACTIVO' && $value2->type == 'APERTURA' && $value2->created_at <= $value->creacion_Mov) {
                        array_push($this->movbancarios, $value);
                        $this->sumaBanco += $value->import;

                        $break = 1;
                    } elseif ($value2->type == 'APERTURA' && $value2->created_at <= $value->creacion_Mov) {
                        $hasta = 1;
                    } elseif ($hasta == 1 && $value2->type == 'CIERRE' && $value2->created_at >= $value->creacion_Mov) {
                        array_push($this->movbancarios, $value);
                        $this->sumaBanco += $value->import;
                        /* $movbancarios=$value; */
                        $break = 1;
                    } elseif ($hasta == 1 && $value2->type == 'CIERRE' && $value2->created_at <= $value->creacion_Mov) {
                        $hasta = 0;
                    }

                    if ($break == 1)
                        break;
                }
                
            }
            /* dd($this->movbancarios); */
            foreach ($this->movbancarios as $mB) {
                $this->sumaCosto += $mB->costo;
            }
            
            foreach ($this->movbancarios as $movbanc) {
                        $movbanc->utilidad = $movbanc->import - $movbanc->costo;
                        $this->sumaUtilidadBanco += $movbanc->utilidad;
            }
            $this->sumaUtilidadTotal = $this->sumaUtilidadBanco +$this->sumaUtilidad;
            /* 
                dd($banco); */
        } else {
            $this->data = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                ->join('mov_services as ms', 'services.id', 'ms.service_id')
                ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'mov.id')
                ->join('carteras as c', 'c.id', 'cmv.cartera_id')
                ->join('cajas as ca', 'ca.id', 'c.caja_id')
                ->join('sucursals as s', 's.id', 'ca.sucursal_id')
                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                ->join('clientes as cli', 'cli.id', 'cliemov.cliente_id')
                ->join('users as u', 'u.id', 'mov.user_id')
                ->join('sucursal_users as su', 'u.id', 'su.user_id')
                ->where('mov.status', 'ACTIVO')
                ->select(
                    'services.*',
                    DB::raw('0 as utilidad')

                )
                ->where('s.id', $this->sucursal)
                /* ->where('services.sucursal_id',$this->sucursal) */
                ->where('mov.type', 'ENTREGADO')
                ->whereBetween('mov.created_at', [$from, $to])
                ->orderBy('services.id', 'desc')
                ->distinct()
                ->get();
                
                foreach ($this->data as $serv) {
                    foreach ($serv->movservices as $mm) {
                        
                        if ($mm->movs->status == 'ACTIVO') {
                            $serv->utilidad = $mm->movs->import - $serv->costo;
                            foreach($mm->movs->cartmov as $carmv){
                                
                                if($carmv->cartera->tipo == 'CajaFisica'){
                                    
                                    $this->sumaUtilidad += $serv->utilidad;
                                    
                                }
                                else{
                                    $this->sumaUtilidadBanco += $serv->utilidad;
                                }
                            }
                            
                            
                        }
                    }
                }
                
                $this->sumaUtilidadTotal = $this->sumaUtilidadBanco +$this->sumaUtilidad;
                

            $data1 = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                ->join('mov_services as ms', 'services.id', 'ms.service_id')
                ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'mov.id')
                ->join('carteras as c', 'c.id', 'cmv.cartera_id')
                ->join('cajas as ca', 'ca.id', 'c.caja_id')
                ->join('sucursals as s', 's.id', 'ca.sucursal_id')
                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                ->join('clientes as cli', 'cli.id', 'cliemov.cliente_id')
                ->join('users as u', 'u.id', 'mov.user_id')
                ->join('sucursal_users as su', 'u.id', 'su.user_id')
                ->where('mov.status', 'ACTIVO')
                ->select(
                    'mov.*',

                )
                ->where('s.id', $this->sucursal)
                /* ->where('services.sucursal_id',$this->sucursal) */
                ->where('mov.type', 'ENTREGADO')
                ->whereBetween('mov.created_at', [$from, $to])

                ->distinct()
                ->get();
        }
        $this->sumaEfectivo = $data1->sum('import');
    }
}
