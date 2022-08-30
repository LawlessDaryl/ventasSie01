<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\AccountProfile;
use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\CuentaInversion;
use App\Models\Movimiento;
use App\Models\Plan;
use App\Models\PlanAccount;
use App\Models\Profile;
use App\Models\Sale;
use App\Models\Service;
use App\Models\Transaccion;
use App\Models\User;

use Carbon\Carbon;
use Exception;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ReporteMovimientoController extends Component
{
    public  $search, $selected_id;
    public  $pageTitle, $componentName, $opciones,
        $cartera_id, $type, $cantidad, $comentario,$totalesIngresos,$totalesEgresos,$vertotales=0,$importetotalingresos,$importetotalegresos,$fromDate,$toDate,
        $operacionefectivoing,$noefectivo,$operacionefectivoeg,$noefectivoeg,$subtotalcaja,$utilidadtotal=5,$caja,$ops;
    private $pagination = 10;

    //Crear Pdf 
    public $tablamovdiageneral, $opcionespdf;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Movimientos';
        $this->selected_id = 0;
        $this->opciones = 'TODAS';
        $this->cartera_id = 'Elegir';
        $this->type = 'Elegir';
        $this->cantidad = '';
        $this->comentario = '';
        $this->fromDate= Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->toDate=  Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->caja=0;

    }
    public function render()
    {
        /* Caja en la cual se encuentra el usuario */
        $SucursalUsuario = User::join('sucursal_users as su', 'su.user_id', 'users.id')
            ->join('sucursals as s', 's.id', 'su.sucursal_id')
            ->where('users.id', Auth()->user()->id)
            ->where('su.estado', 'ACTIVO')
            ->select('s.*')
            ->get()->first();
        /* MOSTRAR CARTERAS DE LA CAJA EN LA QUE SE ENCUENTRA */
        $carterasSucursal = Cartera::join('cajas as c', 'carteras.caja_id', 'c.id')
            ->join('sucursals as s', 's.id', 'c.sucursal_id')
            ->where('s.id', $SucursalUsuario->id)
            ->select('carteras.id', 'carteras.nombre as carteraNombre', 'c.nombre as cajaNombre', 'carteras.tipo as tipo', DB::raw('0 as monto'))->get();
        foreach ($carterasSucursal as $c) {
            /* SUMAR TODO LOS INGRESOS DE LA CARTERA */
            $INGRESOS = Cartera::join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
                ->join('movimientos as m', 'm.id', 'cm.movimiento_id')
                ->where('cm.type','INGRESO')
                ->where('m.status', 'ACTIVO')
                ->whereBetween('m.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
                ->where('carteras.id', $c->id)->sum('m.import');
            /* SUMAR TODO LOS EGRESOS DE LA CARTERA */
            $EGRESOS = Cartera::join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
                ->join('movimientos as m', 'm.id', 'cm.movimiento_id')
                ->where('cm.type', 'EGRESO')
                ->where('m.status','ACTIVO')
                ->whereBetween('m.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
                ->where('carteras.id', $c->id)->sum('m.import');
            /* REALIZAR CALCULO DE INGRESOS - EGRESOS */
            $c->monto = $INGRESOS - $EGRESOS;
        }
        $this->Cargar();
        return view('livewire.reporte_movimientos.component', [
            'carterasSucursal' => $carterasSucursal,
            'cajas2'=> Caja::all()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function Cargar()
    {
        if ($this->opciones == 'TODAS') {
            $this->data = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
                ->join('carteras as c', 'c.id', 'crms.cartera_id')
                ->join('cajas as ca', 'ca.id', 'c.caja_id')
                ->join('users as u', 'u.id', 'movimientos.user_id')
                ->whereBetween('movimientos.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
                ->select(
                    'movimientos.type as movimientotype',
                    'movimientos.import',
                    'crms.type as carteramovtype',
                    'crms.tipoDeMovimiento',
                    'crms.comentario',
                    'c.nombre',
                    'c.descripcion',
                    'c.tipo',
                    'c.telefonoNum',
                    'ca.nombre as cajaNombre',
                    'u.name as usuarioNombre',
                    'movimientos.created_at as movimientoCreacion',
                )
                ->orderBy('movimientos.created_at', 'desc')
                ->get();
        } elseif ($this->opciones == 'CORTE') {
            $this->data = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
                ->join('carteras as c', 'c.id', 'crms.cartera_id')
                ->join('cajas as ca', 'ca.id', 'c.caja_id')
                ->join('users as u', 'u.id', 'movimientos.user_id')
                ->select(
                    'movimientos.type as movimientotype',
                    'movimientos.status',
                    'crms.tipoDeMovimiento',
                    'ca.nombre as cajaNombre',
                    'u.name as usuarioNombre',
                    'movimientos.created_at as movimientoCreacion',
                )
                ->where('crms.tipoDeMovimiento', 'CORTE')
                ->whereBetween('movimientos.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
                ->orderBy('movimientos.created_at', 'desc')
                ->distinct()
                ->get();
        } else {
            $this->data = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
                ->join('carteras as c', 'c.id', 'crms.cartera_id')
                ->join('cajas as ca', 'ca.id', 'c.caja_id')
                ->join('users as u', 'u.id', 'movimientos.user_id')
                ->select(
                    'movimientos.type as movimientotype',
                    'movimientos.import',
                    'crms.type as carteramovtype',
                    'crms.tipoDeMovimiento',
                    'crms.comentario',
                    'c.nombre',
                    'c.descripcion',
                    'c.tipo',
                    'c.telefonoNum',
                    'ca.nombre as cajaNombre',
                    'u.name as usuarioNombre',
                    'movimientos.created_at as movimientoCreacion',
                )
                ->where('crms.tipoDeMovimiento', $this->opciones)
                ->whereBetween('movimientos.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
                ->orderBy('movimientos.id', 'desc')
                ->get();
        }
    }



    public function printresumen(){
        session(['fecha_movimiento_inicio' => Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',
    'fecha_movimiento_fin'=> Carbon::parse($this->toDate)->format('Y-m-d') . ' 00:00:00']);

        return redirect()->route('movimiento.pdf');
    }


    public function EliminarTigoMoney()
    {
        DB::beginTransaction();
        try {
            $transacciones = Transaccion::orderBy('id', 'desc')->get();

            foreach ($transacciones as $transac) {
                foreach ($transac->movTransac as $value) {
                    foreach ($value->Movimiento->cartmov as $value2) {
                        $carteraMov = $value2;
                        $carteraMov->delete();
                    }
                    $clientemov = $value->Movimiento->climov;
                    if ($clientemov) {
                        $clientemov->delete();
                    }
                    $value->delete();
                    $value->Movimiento->delete();
                }
                $transac->delete();
            }

            DB::commit();
            $this->resetUI();
            $this->emit('tigo-delete', 'Se eliminaron las transacciones tigo money');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }
    public function EliminarStreaming()
    {
        DB::beginTransaction();
        try {
            $accountProf = AccountProfile::orderby('id', 'desc')->get();
            foreach ($accountProf as $accPr) {
                $accPr->delete();
            }
            $planAccounts = PlanAccount::orderby('id', 'desc')->get();
            foreach ($planAccounts as $planAcc) {
                $planAcc->delete();
            }
            $inversiones = CuentaInversion::orderby('id', 'desc')->get();
            foreach ($inversiones as $inv) {
                $inv->delete();
            }
            $cuentas = Account::orderby('id', 'desc')->get();
            foreach ($cuentas as $cue) {
                $cue->delete();
            }
            $profiles = Profile::orderby('id', 'desc')->get();
            foreach ($profiles as $prof) {
                $prof->delete();
            }

            $planes = Plan::orderBy('id', 'desc')->get();
            foreach ($planes as $pl) {

                foreach ($pl->Mov->cartmov as $value2) {
                    $carteraMov = $value2;
                    $carteraMov->delete();
                }

                $clientemov = $pl->Mov->climov;
                if ($clientemov) {
                    $clientemov->delete();
                }
                $pl->delete();
                $pl->Mov->delete();
            }

            DB::commit();
            $this->resetUI();
            $this->emit('tigo-delete', 'Se eliminó todo de streaming');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

   

    public function resetUI()
    {
        $this->cartera_id = 'Elegir';
        $this->type = 'Elegir';
        $this->cantidad = '';
        $this->comentario = '';
    }

 


   

    

}