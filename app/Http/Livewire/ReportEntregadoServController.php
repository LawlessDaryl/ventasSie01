<?php

namespace App\Http\Livewire;

use App\Models\Cartera;
use App\Models\ModelHasRoles;
use App\Models\OrderService;
use App\Models\Service;
use App\Models\Transaccion;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReportEntregadoServController extends Component
{
    public $componentName, $data, $details, $sumDetails, $countDetails, $reportType,
        $userId, $dateFrom, $dateTo, $transaccionId, $estado, $fechas, $sumaEfectivo,
        $sumaBanco;

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
    }

    public function render()
    {
        $user = User::find(Auth()->user()->id);
        foreach($user->sucursalusers as $usersuc){
            if($usersuc->estado == 'ACTIVO'){
                $this->sucursal= $usersuc->sucursal->id;
            }
        }

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

        /* $rules = [
            'dateFrom' => 'required|max:10',
            
        ];
        $messages = [
            'dateFrom.required' => 'La fecha es requerida',
            'dateFrom.max' => 'Máximo 10 digitos',
            
        ];

        $this->validate($rules, $messages); */
        
        $users = User::join('model_has_roles as mr', 'users.id', 'mr.model_id')
        ->join('roles as r', 'r.id', 'mr.role_id')
        ->join('role_has_permissions as rp', 'r.id', 'rp.role_id')
        ->join('permissions as p', 'p.id', 'rp.permission_id')
        ->where('p.name','Orden_Servicio_Index')
        ->where('r.name','TECNICO')
        ->orWhere('r.name', 'SUPERVISOR')
        ->where('p.name','Orden_Servicio_Index')
        ->orWhere('r.name', 'ADMIN')
        ->where('p.name','Orden_Servicio_Index')
        ->select('users.*')
        ->orderBy('name', 'asc')
        ->distinct()
        ->get();
        
        $totalEfectivo = Cartera ::join('cajas as caj','caj.id','carteras.caja_id')
        ->join('sucursals as s', 's.id', 'caj.sucursal_id')
        ->join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
        ->join('movimientos as m', 'm.id','cm.movimiento_id')
        ->join('mov_services as ms', 'ms.movimiento_id', 'm.id')
        ->join('services as serv', 'serv.id','ms.service_id')
        ->select('m.*')
        ->whereBetween('serv.created_at', [$from, $to])
        ->where('m.status', 'ACTIVO')
        ->where('cm.comentario', 'SERVICIOS')
        ->where('carteras.tipo', 'CajaFisica')
        ->where('s.id',$this->sucursal)
        ->get();
        $this->sumaEfectivo = $totalEfectivo->sum('import');

        $totalBanco = Cartera ::join('cajas as caj','caj.id','carteras.caja_id')
        ->join('sucursals as s', 's.id', 'caj.sucursal_id')
        ->join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
        ->join('movimientos as m', 'm.id','cm.movimiento_id')
        ->join('mov_services as ms', 'ms.movimiento_id', 'm.id')
        ->join('services as serv', 'serv.id','ms.service_id')
        ->select('m.*')
        ->whereBetween('serv.created_at', [$from, $to])
        ->where('m.status', 'ACTIVO')
        ->where('cm.comentario', 'SERVICIOS')
        ->where('carteras.tipo', 'Banco')
        ->where('s.id',$this->sucursal)
        ->get();
        $this->sumaBanco = $totalBanco->sum('import');


        /* foreach($users as $us){
            if($us->hasPermissionTo('Orden_Servicio_Index')){
                $usuario = 
            }
        } */
        return view('livewire.reporte_serv_entreg.component', [
            'users'=>$users
        ])->extends('layouts.theme.app')
            ->section('content');
    }

    public function trsbydate()
    {

        if ($this->reportType == 0) {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        } else {
            try {
                $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
                $to = Carbon::parse($this->dateTo)->format('Y-m-d')     . ' 23:59:59';
            } catch (Exception $e) {
                DB::rollback();
                $this->emit('', 'Datos no Validos', $e->getMessage());
            }
        }

        if ($this->reportType == 1 && ($this->dateFrom == '' || $this->dateTo == '')) {
            return;
        }

        if ($this->estado == 'Todos') {
            if ($this->userId == 0) {
                $this->data = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                    ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                    ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                    ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                    ->join('users as u', 'u.id', 'mov.user_id')
                    ->where('mov.status', 'like', 'ACTIVO')
                    ->select(
                        'services.*'
                    )
                    ->whereBetween('os.created_at', [$from, $to])
                    ->orderBy('services.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $this->data = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                    ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                    ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                    ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                    ->join('users as u', 'u.id', 'mov.user_id')
                    ->where('mov.status', 'like', 'ACTIVO')
                    ->select(
                        'services.*'
                    )
                    ->whereBetween('os.created_at', [$from, $to])
                    ->where('mov.user_id', $this->userId)
                    ->orderBy('services.id', 'desc')
                    ->distinct()
                    ->get();
            }
        } else {
            if ($this->userId == 0) {
                $this->data = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                    ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                    ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                    ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                    ->join('users as u', 'u.id', 'mov.user_id')
                    ->where('mov.status', 'like', 'ACTIVO')
                    ->select(
                        'services.*'
                    )
                    ->whereBetween('os.created_at', [$from, $to])
                    ->where('mov.type', $this->estado)
                    ->orderBy('services.id', 'desc')
                    ->distinct()
                    ->get();
            } else {
                $this->data = Service::join('order_services as os', 'os.id', 'services.order_service_id')
                    ->join('mov_services as ms', 'services.id', 'ms.service_id')
                    ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                    ->join('sub_cat_prod_services as scps', 'cat.id', 'scps.cat_prod_service_id')
                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                    ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                    ->join('users as u', 'u.id', 'mov.user_id')
                    ->where('mov.status', 'like', 'ACTIVO')
                    ->select(
                        'services.*'
                    )
                    ->whereBetween('os.created_at', [$from, $to])
                    ->where('mov.user_id', $this->userId)
                    ->where('mov.type', $this->estado)
                    ->orderBy('services.id', 'desc')
                    ->distinct()
                    ->get();
            }
        }
    }
}
