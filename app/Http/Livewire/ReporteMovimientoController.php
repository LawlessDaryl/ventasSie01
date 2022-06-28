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
        $operacionefectivoing,$noefectivo,$operacionefectivoeg,$noefectivoeg,$subtotalcaja,$utilidadtotal=5;
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

    public function buscarventa($idmovimiento)
    {
        $venta = Sale::join('movimientos as m', 'm.id', 'sales.movimiento_id')
                ->select('sales.id as idventa')
                ->where('sales.movimiento_id',$idmovimiento)
                ->get();
        return $venta;
    }

    public function printresumen(){
        session(['fecha_movimiento_inicio' => Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',
    'fecha_movimiento_fin'=> Carbon::parse($this->toDate)->format('Y-m-d') . ' 00:00:00']);

        return redirect()->route('movimiento.pdf');
    }


    //Buscar la utilidad de una venta mediante el idventa
    public function buscarutilidad($idventa)
    {
        $utilidadventa = Sale::join('sale_details as sd', 'sd.sale_id', 'sales.id')
        ->join('products as p', 'p.id', 'sd.product_id')
        ->select('sd.quantity as cantidad','sd.price as precio','p.costo as costoproducto')
        ->where('sales.id', $idventa)
        ->get();

        $utilidad = 0;

        foreach ($utilidadventa as $item)
        {
            $utilidad = $utilidad + ($item->cantidad * $item->precio) - ($item->cantidad * $item->costoproducto);
        }

        $this->utilidadtotal=$this->utilidadtotal+$utilidad;
        return $utilidad;
    }

    public function buscarservicio($idmovimiento)
    {
       
        $serv = Service::join('mov_services as m', 'm.service_id', 'services.id')
                ->join('movimientos','movimientos.id','m.movimiento_id')
                ->where('movimientos.id',$idmovimiento)
                ->select('movimientos.import as ms','services.costo as mc')
                ->get();

        $utilidad2=$serv[0]->ms- $serv[0]->mc;
        $this->utilidadtotal=$this->utilidadtotal+$utilidad2;
        
       return $utilidad2;
    }

  

    //Buscar la utilidad de una venta mediante el idventa
    /*public function buscarutilidadservicio($ss)
    {
        $utilidadventa = Sale::join('sale_details as sd', 'sd.sale_id', 'sales.id')
        ->join('products as p', 'p.id', 'sd.product_id')
        ->select('sd.quantity as cantidad','sd.price as precio','p.costo as costoproducto')
        ->where('sales.id', $idventa)
        ->get();

        $utilidad = 0;

        foreach ($utilidadventa as $item)
        {
            $utilidad = $utilidad + ($item->cantidad * $item->precio) - ($item->cantidad * $item->costoproducto);
        }

        return $utilidad;
    }
*/

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




    public function viewDetailsR()
    {
        $this->emit('show-modalR', 'open modal');
    }
    public function GenerarR()
    {
        $rules = [ /* Reglas de validacion */
          
            'cartera_id' => 'required|not_in:Elegir',
            'cantidad' => 'required|not_in:0',
         
        ];
        $messages = [ /* mensajes de validaciones */
           
            'cartera_id.not_in' => 'Seleccione un valor distinto a Elegir',
            'cartera_id.not_in' => 'Seleccione un valor distinto a Elegir',
            'cantidad.required' => 'Ingrese un monto válido',
            'cantidad.not_in' => 'Ingrese un monto válido',
           
        ];

        $this->validate($rules, $messages);

        $mvt = Movimiento::create([
            'type' => 'TERMINADO',
            'status' => 'ACTIVO',
            'import' => $this->cantidad,
            'user_id' => Auth()->user()->id,
        ]);

        CarteraMov::create([
            'type' => 'EGRESO',
            'tipoDeMovimiento' => 'EGRESO/INGRESO',
            'comentario' => 'RECAUDO DEL DIA',
            'cartera_id' => $this->cartera_id,
            'movimiento_id' => $mvt->id
        ]);

        $this->emit('hide-modalR', 'SE GENERO EL RECAUDO');
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
        $this->utilidadtotal=0;
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
            'c.tipo as ctipo',
            'c.telefonoNum',
            'ca.nombre as cajaNombre',
            'u.name as usuarioNombre',
            'movimientos.created_at as movimientoCreacion',
            'movimientos.id as movid'
        )
        ->where('movimientos.status', 'ACTIVO')
        ->where('crms.type', 'INGRESO')
        ->where('crms.tipoDeMovimiento', '!=' , 'TIGOMONEY')
        ->where('crms.tipoDeMovimiento', '!=' , 'STREAMING')
        ->whereBetween('movimientos.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
        ->orderBy('crms.tipoDeMovimiento', 'asc')
    
        
        ->get();

        $this->importetotalingresos= $this->totalesIngresos->sum('mimpor');
        $this->operacionefectivoing= $this->totalesIngresos->where('ctipo','CajaFisica')->sum('mimpor');
        $this->noefectivoing=$this->totalesIngresos->where('ctipo','!=','CajaFisica')->sum('mimpor');


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
            'c.tipo as ctipo',
            'c.telefonoNum',
            'ca.nombre as cajaNombre',
            'u.name as usuarioNombre',
            'movimientos.created_at as movimientoCreacion',
        )
        ->where('movimientos.status', 'ACTIVO')
        ->where('crms.type', 'EGRESO')
        ->where('crms.tipoDeMovimiento', '!=' , 'TIGOMONEY')
        ->where('crms.tipoDeMovimiento', '!=' , 'STREAMING')
        ->whereBetween('movimientos.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])

        ->orderBy('crms.tipoDeMovimiento', 'asc')
    
        
        ->get();

        foreach ($this->totalesIngresos as $var) {
            if($var->tipoDeMovimiento == 'VENTA')
            $this->utilidadtotal= $this->utilidadtotal+($this->buscarutilidad($this->buscarventa($var->movid)->first()->idventa)) ;
            elseif($var->tipoDeMovimiento == 'SERVICIOS')
            $this->utilidadtotal= $this->utilidadtotal+ ($this->buscarservicio($var->movid));


        }


        $this->importetotalegresos= $this->totalesEgresos->sum('mimpor');
        $this->operacionefectivoeg= $this->totalesEgresos->where('ctipo','CajaFisica')->sum('mimpor');
        $this->noefectivoeg=  $this->totalesEgresos->where('ctipo','!=','CajaFisica')->sum('mimpor');
        $this->subtotalcaja= $this->importetotalingresos-$this->importetotalegresos;
    // $this->utilidadtotal=$this->utilidadtotal+0;


    }


    public function crearpdf()
    {
        $this->viewTotales();
        //dd($this->totalesIngresos);
        //Pasando la tabla a la variable tablereport para crear PDF
        session(['totalesIngresos' => $this->totalesIngresos]);
        session(['totalesEgresos' => $this->totalesEgresos]);

        $values = [$this->importetotalingresos, $this->operacionefectivoing, $this->noefectivoing, $this->importetotalegresos, $this->subtotalcaja, $this->utilidadtotal, $this->noefectivoing, $this->noefectivoeg];

        session(['variablesmovidia' => $values]);


        //dd(session('tablamovdiageneral'));

        //Redireccionando para crear el comprobante con sus respectvas variables
        return redirect::to('report/pdfmovdiageneral');
    }
}