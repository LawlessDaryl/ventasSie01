<?php

namespace App\Http\Livewire;

use App\Models\OrderService;
use App\Models\Service;
use App\Models\Transaccion;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class ReporteServiceController extends Component
{
    public $componentName, $data, $details, $sumDetails, $countDetails, $reportType,
        $userId, $dateFrom, $dateTo, $transaccionId, $estado, $fechas;

    public function mount()
    {
        $this->componentName = 'Reportes Servicio';
        $this->data = [];
        $this->details = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->reportType = 0;
        $this->userId = 0;
        $this->estado = 'Todos';
        $this->transaccionId = 0;
        $this->fechas = [];
        $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
    }

    public function render()
    {
        $this->trsbydate();

        return view('livewire.reporte_service.component', [
            'users' => User::orderBy('name', 'asc')->get()
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

        if ($this->estado == 'Todos') {
            if ($this->userId == 0) {
                /* $this->data=Service::orderBy('id','desc')->get(); */
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

                /* for ($x = 0; $x < $this->data->count(); $x++) {
                    $this->fechas = OrderService::join('services as s', 'order_services.id', 's.order_service_id')
                        ->join('mov_services as ms', 's.id', 'ms.service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->where('s.id', $this->data[$x]->serviceid)
                        ->pluck('mov.created_at')->toArray();
                    
                } */
                
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
