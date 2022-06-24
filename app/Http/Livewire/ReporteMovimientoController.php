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
use App\Models\Transaccion;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReporteMovimientoController extends Component
{
    public  $search, $selected_id;
    public  $pageTitle, $componentName, $opciones,
        $cartera_id, $type, $cantidad, $comentario,$totalesIngresos,$totalesEgresos,$vertotales=0,$importetotalingresos,$importetotalegresos;
    private $pagination = 10;

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
            ->select('carteras.id', 'carteras.nombre as carteraNombre', 'c.nombre as cajaNombre', DB::raw('0 as monto'))->get();
        foreach ($carterasSucursal as $c) {
            /* SUMAR TODO LOS INGRESOS DE LA CARTERA */
            $INGRESOS = Cartera::join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
                ->join('movimientos as m', 'm.id', 'cm.movimiento_id')
                ->where('cm.type','INGRESO')
                ->where('m.status', 'ACTIVO')
                ->where('carteras.id', $c->id)->sum('m.import');
            /* SUMAR TODO LOS EGRESOS DE LA CARTERA */
            $EGRESOS = Cartera::join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
                ->join('movimientos as m', 'm.id', 'cm.movimiento_id')
                ->where('cm.type', 'EGRESO')
                ->where('m.status','ACTIVO')
                ->where('carteras.id', $c->id)->sum('m.import');
            /* REALIZAR CALCULO DE INGRESOS - EGRESOS */
            $c->monto = $INGRESOS - $EGRESOS;
        }
        $this->Cargar();
        return view('livewire.reporte_movimientos.component', [
            'carterasSucursal' => $carterasSucursal,
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
                ->orderBy('movimientos.id', 'desc')
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
                ->orderBy('movimientos.id', 'desc')
                ->get();
        }
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
    /* ABRIR MODAL */
    public function viewDetails()
    {
        $this->emit('show-modal', 'open modal');
    }
    /* GENERAR INGRESO O EGRESO  */
    public function Generar()
    {
        $rules = [ /* Reglas de validacion */
            'type' => 'required|not_in:Elegir',
            'cartera_id' => 'required|not_in:Elegir',
            'cantidad' => 'required|not_in:0',
            'comentario' => 'required',
        ];
        $messages = [ /* mensajes de validaciones */
            'type.not_in' => 'Seleccione un valor distinto a Elegir',
            'type.not_in' => 'Seleccione un valor distinto a Elegir',
            'cartera_id.not_in' => 'Seleccione un valor distinto a Elegir',
            'cartera_id.not_in' => 'Seleccione un valor distinto a Elegir',
            'cantidad.required' => 'Ingrese un monto válido',
            'cantidad.not_in' => 'Ingrese un monto válido',
            'comentario.required' => 'El comentario es obligatorio',
        ];

        $this->validate($rules, $messages);

        $mvt = Movimiento::create([
            'type' => 'TERMINADO',
            'status' => 'ACTIVO',
            'import' => $this->cantidad,
            'user_id' => Auth()->user()->id,
        ]);

        CarteraMov::create([
            'type' => $this->type,
            'tipoDeMovimiento' => 'EGRESO/INGRESO',
            'comentario' => $this->comentario,
            'cartera_id' => $this->cartera_id,
            'movimiento_id' => $mvt->id
        ]);

        $this->emit('hide-modal', 'Se generó el ingreso/egreso');
        $this->resetUI();
    }
    public function resetUI()
    {
        $this->cartera_id = 'Elegir';
        $this->type = 'Elegir';
        $this->cantidad = '';
        $this->comentario = '';
    }

  public function viewTotales(){
    $this->vertotales=1;
    $this->totalesIngresos = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
    ->join('carteras as c', 'c.id', 'crms.cartera_id')
    ->join('cajas as ca', 'ca.id', 'c.caja_id')
    ->join('users as u', 'u.id', 'movimientos.user_id')
    ->select(
        'movimientos.type as movimientotype',
        'movimientos.import as mimpor',
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
    ->where('movimientos.status', 'ACTIVO')
    ->orderBy('crms.type', 'asc')
  
    
    ->get();

    $this->importetotalingresos= sum::

    $this->totalesEgresos = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
    ->join('carteras as c', 'c.id', 'crms.cartera_id')
    ->join('cajas as ca', 'ca.id', 'c.caja_id')
    ->join('users as u', 'u.id', 'movimientos.user_id')
    ->select(
        'movimientos.type as movimientotype',
        'movimientos.import as mimpor',
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
    ->where('movimientos.status', 'ACTIVO')
    ->orderBy('crms.type', 'asc')
  
    
    ->get();


  }
}