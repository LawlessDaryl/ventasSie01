<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Cartera;
use App\Models\OrderService;
use App\Models\Service;
use App\Models\Sucursal;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ExportServicioEntregPdfController extends Controller
{
    public function reporteServPDF($reportType, $dateFrom = null, $dateTo = null, $sucursal, $sumaEfectivo, $sumaBanco, $caja)
    {
        $data = [];

        $sumaEfectivo=0;
        $sumaBanco=0;
        $sumaCosto=0;
        $sumaCostoEfectivo=0;

        $user = User::find(Auth()->user()->id);
        foreach ($user->sucursalusers as $usersuc) {
            if ($usersuc->estado == 'ACTIVO') {
                $sucursal = $usersuc->sucursal->id;
            }
        }

        $cajaSucursal = Caja::where('sucursal_id', $sucursal)
            ->where('nombre', '!=', 'Caja General')->get();


        if ($reportType == 0) //ventas del dia
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        } else {
            $from = Carbon::parse($dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($dateTo)->format('Y-m-d')     . ' 23:59:59';
        }
        if ($reportType == 1 && ($dateFrom == '' || $dateTo == '')) {
            $dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
            $dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
            $this->emit('item', 'Hiciste algo incorrecto, la fecha se actualizó');
        }

        if ($dateFrom == "" || $dateTo == "") {
            $reportType = 0;
        }


        

        if ($reportType == 0) {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        } else {
            try {
                $from = Carbon::parse($dateFrom)->format('Y-m-d') . ' 00:00:00';
                $to = Carbon::parse($dateTo)->format('Y-m-d')     . ' 23:59:59';
            } catch (Exception $e) {
                DB::rollback();
                $this->emit('', 'Datos no Validos', $e->getMessage());
            }
        }

        if ($reportType == 1 && ($dateFrom == '' || $dateTo == '')) {
            return;
        }
        
        if ($caja != 'Todos') {
            $data = Service::join('order_services as os', 'os.id', 'services.order_service_id')
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
                ->where('mov.status', 'like', 'ACTIVO')
                ->select(
                    'services.*'
                )
                ->where('s.id', $sucursal)
                ->where('ca.id', $caja)
                ->where('mov.type', 'ENTREGADO')
                ->whereBetween('mov.created_at', [$from, $to])
                ->orderBy('services.id', 'desc')
                ->distinct()
                ->get();
                
                $sumaCostoEfectivo = $data->sum('costo');


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
                ->where('mov.status', 'like', 'ACTIVO')
                ->select(
                    'mov.*'
                )
                ->where('s.id', $sucursal)
                ->where('ca.id', $caja)
                ->where('mov.type', 'ENTREGADO')
                ->whereBetween('mov.created_at', [$from, $to])
                ->distinct()
                ->get();

            $banco = Service::join('order_services as os', 'os.id', 'services.order_service_id')
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
                    'mov.import as import'
                )
                ->where('s.id', $sucursal)
                ->where('ca.id', '1')
                ->where('mov.type', 'ENTREGADO')
                ->whereBetween('mov.created_at', [$from, $to])
                ->orderBy('services.id', 'desc')
                ->distinct()
                ->get();
            $contador = $data->count();
            /*  dd($banco); */

            $movbancarios = [];
           
            foreach ($banco as  $value) {
                $aperturasCierres = Caja::join('carteras as car', 'cajas.id', 'car.caja_id')
                    ->join('cartera_movs as cartmovs', 'car.id', 'cartmovs.cartera_id')
                    ->join('movimientos as mov', 'mov.id', 'cartmovs.movimiento_id')
                    ->select('mov.*')
                    ->where('cajas.id', $caja)
                    ->where('mov.user_id', $value->idusuario)
                    ->where('mov.type', 'APERTURA')                    
                    ->orWhere('mov.type', 'CIERRE')                    
                    ->get();     
                    
                    
                

                $break = 0;
                $hasta = 0;

                foreach ($aperturasCierres as  $value2) {

                    if ($value2->status == 'ACTIVO' && $value2->type == 'APERTURA' && $value2->created_at <= $value->creacion_Mov) {
                        array_push($movbancarios, $value);
                        $sumaBanco+=$value->import;
                        $break = 1;
                    } elseif ($value2->type == 'APERTURA' && $value2->created_at <= $value->creacion_Mov) {
                        $hasta = 1;
                    } elseif ($hasta == 1 && $value2->type == 'CIERRE' && $value2->created_at >= $value->creacion_Mov) {
                        array_push($movbancarios, $value);
                        $sumaBanco+=$value->import;
                        /* $movbancarios=$value; */
                        $break = 1;
                    }elseif ($hasta == 1 &&$value2->type == 'CIERRE'&& $value2->created_at <= $value->creacion_Mov){
                        $hasta = 0;
                    }

                    if ($break == 1)
                        break;
                }
                
            }
            /* dd($movbancarios); */
            foreach($movbancarios as $mB){
                $sumaCosto += $mB->costo;
            }
          
            /* 
                dd($banco); */
        }else {
            $movbancarios=[];
            $contador = 0;
            $data = Service::join('order_services as os', 'os.id', 'services.order_service_id')
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
                    
                )
                ->where('s.id', $sucursal)
                ->where('mov.type', 'ENTREGADO')
                ->whereBetween('mov.created_at', [$from, $to])
                ->orderBy('services.id', 'desc')
                ->distinct()
                ->get();
 
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
                ->where('s.id', $sucursal)
                ->where('mov.type', 'ENTREGADO')
                ->whereBetween('mov.created_at', [$from, $to])
               
                ->distinct()
                ->get();
        }
        $sumaEfectivo = $data1->sum('import');


        $users = User::join('model_has_roles as mr', 'users.id', 'mr.model_id')
            ->join('roles as r', 'r.id', 'mr.role_id')
            ->join('role_has_permissions as rp', 'r.id', 'rp.role_id')
            ->join('permissions as p', 'p.id', 'rp.permission_id')
            ->where('p.name', 'Orden_Servicio_Index')
            ->where('r.name', 'TECNICO')
            ->orWhere('r.name', 'SUPERVISOR')
            ->where('p.name', 'Orden_Servicio_Index')
            ->orWhere('r.name', 'ADMIN')
            ->where('p.name', 'Orden_Servicio_Index')
            ->select('users.*')
            ->orderBy('name', 'asc')
            ->distinct()
            ->get();

        if('Todos'==$caja){
            $totalEfectivo = Cartera::join('cajas as caj', 'caj.id', 'carteras.caja_id')
            ->join('sucursals as s', 's.id', 'caj.sucursal_id')
            ->join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
            ->join('movimientos as m', 'm.id', 'cm.movimiento_id')
            ->join('mov_services as ms', 'ms.movimiento_id', 'm.id')
            ->join('services as serv', 'serv.id', 'ms.service_id')
            ->select('m.*')
            ->whereBetween('m.created_at', [$from, $to])
            ->where('m.status', 'ACTIVO')
            ->where('cm.comentario', 'SERVICIOS')
            ->where('carteras.tipo', 'CajaFisica')
            ->where('s.id', $sucursal)
            ->get();
            $sumaEfectivo = $totalEfectivo->sum('import');

            $totalBanco = Cartera::join('cajas as caj', 'caj.id', 'carteras.caja_id')
            ->join('sucursals as s', 's.id', 'caj.sucursal_id')
            ->join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
            ->join('movimientos as m', 'm.id', 'cm.movimiento_id')
            ->join('mov_services as ms', 'ms.movimiento_id', 'm.id')
            ->join('services as serv', 'serv.id', 'ms.service_id')
            ->select('m.*')
            ->whereBetween('m.created_at', [$from, $to])
            ->where('m.status', 'ACTIVO')
            ->where('cm.comentario', 'SERVICIOS')
            ->where('carteras.tipo', 'Banco')
            ->where('s.id', $sucursal)
            ->get();
            $sumaBanco = $totalBanco->sum('import');
        }
        if($caja != 'Todos'){
            $nombreCaja = Caja::find($caja)
            ->nombre;
        }else{
            $nombreCaja = '';
        }
        
        $sucursal = Sucursal::find($sucursal);
        $pdf = PDF::loadView('livewire.pdf.reporteServiciosEntregados', compact('data', 'reportType', 'dateFrom', 'dateTo', 'sucursal', 'sumaEfectivo', 'sumaBanco', 'caja', 'movbancarios', 'contador','nombreCaja', 'sumaCosto', 'sumaCostoEfectivo'));

        return $pdf->setPaper('letter')->stream('ServiciosReport.pdf');  //visualizar
        /* return $pdf->download('salesReport.pdf');  //descargar  */

    }
}
