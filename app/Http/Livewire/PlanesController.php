<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\AccountProfile;
use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\Cliente;
use App\Models\ClienteMov;
use App\Models\Movimiento;
use App\Models\MovPlan;
use App\Models\Plan;
use App\Models\PlanAccount;
use App\Models\Platform;
use App\Models\Profile;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class PlanesController extends Component
{
    use WithPagination;

    public $profile_id, $movimiento_id, $expiration_plan, $status, $p_type, $importe,
        $pageTitle, $componentName, $selected_id, $hora, $search, $condicion, $type, $cartera_id,
        $nombre, $cedula, $celular, $direccion, $email, $fecha_nacim, $razon, $nit, $plataforma,
        $cuentaperfil, $accounts, $profiles, $cantidaperf, $mostrartabla, $tipopago, $condicional,
        $meses, $observaciones;

    private $pagination = 10;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Planes';
        $this->componentName = 'Streaming';
        $this->selected_id = 0;
        $this->hora = date("d-m-Y H:i:s ");
        $this->status = 'Vigente';
        $this->p_type = 'VENTA';
        $this->plataforma = 'Elegir';
        $this->cuentaperfil = 'Elegir';
        $this->cantidaperf = 1;
        $this->nombre = '';
        $this->celular = '';
        $this->nit = 0;
        $this->importe = 0;
        $this->condicion = 0;
        $this->select = 1;
        $this->mostrartabla = 0;
        $this->tipopago = 'EFECTIVO';
        $this->condicional = 'perfiles';
        $this->meses = 1;
        $this->observaciones = '';
    }

    public function render()
    {
        $user_id = Auth()->user()->id;
        $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';

        /* Caja en la cual se encuentra el usuario */
        $cajausuario = Caja::join('sucursals as s', 's.id', 'cajas.sucursal_id')
            ->join('sucursal_users as su', 'su.sucursal_id', 's.id')
            ->join('carteras as car', 'cajas.id', 'car.caja_id')
            ->join('cartera_movs as cartmovs', 'car.id', 'cartmovs.cartera_id')
            ->join('movimientos as mov', 'mov.id', 'cartmovs.movimiento_id')
            ->where('mov.user_id', Auth()->user()->id)
            ->where('mov.status', 'ACTIVO')
            ->where('mov.type', 'APERTURA')
            ->select('cajas.id as id')
            ->get()->first();
        if ($this->condicional == 'perfiles') {
            if (strlen($this->search) > 0) {
                /*  */
            } else {
                $data = Plan::join('mov_plans as mp', 'plans.id', 'mp.plan_id')
                    ->join('movimientos as m', 'm.id', 'mp.movimiento_id')
                    ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                    ->join('accounts as acc', 'acc.id', 'pa.account_id')
                    ->join('account_profiles as ap', 'acc.id', 'ap.account_id')
                    ->join('profiles as prof', 'prof.id', 'ap.profile_id')
                    ->join('emails as e', 'e.id', 'acc.email_id')
                    ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                    ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                    ->join('cartera_movs as cmvs', 'm.id', 'cmvs.movimiento_id')
                    ->join('carteras as cart', 'cart.id', 'cmvs.cartera_id')
                    ->join('cajas as ca', 'ca.id', 'cart.caja_id')
                    ->select(
                        'plat.nombre as plataforma',
                        'acc.expiration_account as accexp',
                        'c.nombre as cliente',
                        'c.celular as celular',
                        'e.content as correo',
                        'acc.password_account as password_account',
                        'prof.nameprofile as nameprofile',
                        'prof.pin as pin',
                        'plans.id as id',
                        'plans.created_at as planinicio',
                        'plans.expiration_plan as planfin',
                        'plans.observations as obs',
                        'plans.importe as importe',
                        'plans.status as estado'
                    )
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('acc.whole_account', 'DIVIDIDA')
                    ->where('prof.availability', 'OCUPADO')
                    ->where('prof.status', 'ACTIVO')
                    ->whereColumn('pa.id', '=', 'ap.plan_account_id')
                    ->where('ca.id', $cajausuario->id)
                    ->orderBy('plans.created_at', 'desc')
                    ->get();
            }
        } else {
            if (strlen($this->search) > 0) {
                /*  */
            } else {
                $data = Plan::join('mov_plans as mp', 'plans.id', 'mp.plan_id')
                    ->join('movimientos as m', 'm.id', 'mp.movimiento_id')
                    ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                    ->join('accounts as acc', 'acc.id', 'pa.account_id')
                    ->join('emails as e', 'e.id', 'acc.email_id')
                    ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                    ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                    ->join('cartera_movs as cmvs', 'm.id', 'cmvs.movimiento_id')
                    ->join('carteras as cart', 'cart.id', 'cmvs.cartera_id')
                    ->join('cajas as ca', 'ca.id', 'cart.caja_id')
                    ->select(
                        'plat.nombre as plataforma',
                        'acc.expiration_account as accexp',
                        'c.nombre as cliente',
                        'c.celular as celular',
                        'e.content as correo',
                        'plans.importe as importe',
                        'acc.password_account as password_account',
                        'acc.status as accstatus',
                        'plans.id as id',
                        'plans.created_at as planinicio',
                        'plans.expiration_plan as planfin',
                        'plans.observations as obs',
                        'plans.status as estado'
                    )
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('acc.whole_account', 'ENTERA')
                    ->where('acc.availability', 'OCUPADO')
                    ->where('ca.id', $cajausuario->id)
                    ->orderBy('plans.created_at', 'desc')
                    ->get();
            }
        }

        if ($this->meses > 0) {            
            $date_now = date('Y-m-d h:i:s', time()); 
            $dias = $this->meses * 30;
            $this->expiration_plan = strtotime('+' . $dias . ' day', strtotime($date_now));
            $this->expiration_plan = date('Y-m-d', $this->expiration_plan);
        } else {
            $this->meses = 1;
        }

        $datos = [];
        if (strlen($this->cedula) > 0) {
            $datos = Cliente::where('nombre', 'like', '%' . $this->nombre . '%')
                ->orWhere('celular', 'like', '%' . $this->celular . '%')
                ->orderBy('id', 'desc')->get();
            if ($datos->count() > 0) {
                $this->condicion = 1;
            } else {
                $this->condicion = 0;
            }
            if ($this->select == 0) {
                $this->condicion = 0;
            }
        } else {
            if ($this->select == 0)
                $this->select = 1;
        }

        /* MOSTRAR CARTERAS DE LA CAJA EN LA QUE SE ENCUENTRA */
        $carterasCaja = Cartera::where('caja_id', $cajausuario->id)
            ->select('id', 'nombre', DB::raw('0 as monto'))->get();
        foreach ($carterasCaja as $c) {
            /* SUMAR TODO LOS INGRESOS DE LA CARTERA */
            $INGRESOS = Cartera::join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
                ->join('movimientos as m', 'm.id', 'cm.movimiento_id')
                ->where('cm.type', 'INGRESO')
                ->where('m.status', 'ACTIVO')
                ->where('carteras.id', $c->id)->sum('m.import');
            /* SUMAR TODO LOS EGRESOS DE LA CARTERA */
            $EGRESOS = Cartera::join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
                ->join('movimientos as m', 'm.id', 'cm.movimiento_id')
                ->where('cm.type', 'EGRESO')
                ->where('m.status', 'ACTIVO')
                ->where('carteras.id', $c->id)->sum('m.import');
            /* REALIZAR CALCULO DE INGRESOS - EGRESOS */
            $c->monto = $INGRESOS - $EGRESOS;
        }

        if ($this->plataforma != 'Elegir') {
            if ($this->cuentaperfil == 'ENTERA') {
                $this->mostrartabla = 0;

                $this->accounts = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                    ->join('emails as e', 'accounts.email_id', 'e.id')
                    ->select('accounts.*')
                    ->where('accounts.whole_account', 'ENTERA')
                    ->where('accounts.availability', 'LIBRE')
                    ->where('accounts.status', 'ACTIVO')
                    ->where('p.id', $this->plataforma)
                    ->orderBy('accounts.expiration_account', 'desc')
                    ->get()->take($this->cantidaperf);

                $this->mostrartabla = 1;
            } elseif ($this->cuentaperfil == 'PERFIL') {
                $this->mostrartabla = 0;
                $this->profiles = Profile::join('account_profiles as ap', 'ap.profile_id', 'profiles.id')
                    ->join('accounts as a', 'ap.account_id', 'a.id')
                    ->join('platforms as p', 'a.platform_id', 'p.id')
                    ->join('emails as e', 'a.email_id', 'e.id')
                    ->select(
                        'profiles.id as id',
                        'a.id as cuentaid',
                        'e.content as email',
                        'e.pass as contraseña',
                        'profiles.nameprofile as nombre_perfil',
                        'profiles.pin as pin',
                        'a.password_account as password_account',
                    )
                    ->where('profiles.availability', 'LIBRE')
                    ->where('profiles.status', 'ACTIVO')
                    ->where('a.status', 'ACTIVO')
                    ->where('a.availability', 'LIBRE')
                    ->orderBy('a.expiration_account', 'desc')
                    ->where('p.id', $this->plataforma)->get()->take($this->cantidaperf);
                $this->mostrartabla = 2;
            } else {
                $this->accounts = [];
                $this->profiles = [];
            }
        }

        return view('livewire.planes.component', [
            'planes' => $data,
            'carterasCaja' => $carterasCaja,
            'datos' => $datos,
            'platforms' => Platform::where('estado', 'Activo')->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Agregar()
    {
        if ($this->selected_id != 0) {
            $this->resetUI();
        }
        $this->emit('show-modal', 'show modal!');
    }

    /* Registrar una transaccion */
    public function Store()
    {
        $rules = [
            'plataforma' => 'required|not_in:Elegir',
            'cuentaperfil' => 'required|not_in:Elegir',
            'nombre' => 'required|min:4|unique:clientes',
            'celular' => 'required|integer|min:8',
            'tipopago' => 'required|not_in:Elegir',
            'expiration_plan' => 'required|not_in:0000-00-00',
            'accounts' => 'required_if:mostrartabla,1',
            'profiles' => 'required_if:mostrartabla,2',
        ];
        $messages = [
            'plataforma.required' => 'La Plataforma es requerida',
            'plataforma.not_in' => 'Seleccione un valor distinto a Elegir',
            'cuentaperfil.required' => 'El tipo es requerido',
            'cuentaperfil.not_in' => 'Seleccione un valor distinto a Elegir',
            'nombre.required' => 'El nombre del cliente es requerido',
            'nombre.min' => 'El nombre debe tener al menos 4 caracteres',
            'nombre.unique' => 'El nombre ya se encuentra registrado',
            'celular.required' => 'El numero de celular del cliente es requerido',
            'celular.integer' => 'El celular debe ser un número',
            'celular.min' => 'El celular debe tener 8 dígitos',
            'tipopago.required' => 'El tipo de pago es requerido',
            'tipopago.not_in' => 'Seleccione un valor distinto a Elegir',
            'expiration_plan.required' => 'Seleccione una fecha valida',
            'expiration_plan.not_in' => 'Seleccione una fecha valida',
            'accounts.required_if' => 'No tiene cuentas seleccionadas',
            'profiles.required_if' => 'No tiene perfiles seleccionados',
        ];

        $this->validate($rules, $messages);

        $cccc = Caja::join('sucursals as s', 's.id', 'cajas.sucursal_id')
            ->join('sucursal_users as su', 'su.sucursal_id', 's.id')
            ->join('carteras as car', 'cajas.id', 'car.caja_id')
            ->join('cartera_movs as cartmovs', 'car.id', 'cartmovs.cartera_id')
            ->join('movimientos as mov', 'mov.id', 'cartmovs.movimiento_id')
            ->where('mov.user_id', Auth()->user()->id)
            ->where('mov.status', 'ACTIVO')
            ->where('mov.type', 'APERTURA')
            ->select('cajas.id as id')
            ->get()->first();

        if ($this->tipopago == 'EFECTIVO') {
            $cartera = Cartera::where('tipo', 'cajafisica')
                ->where('caja_id', $cccc->id)
                ->get()->first();
        } else {
            $cartera = Cartera::where('tipo', $this->tipopago)
                ->where('caja_id', $cccc->id)->get()->first();
        }
        DB::beginTransaction();
        try {
            /* Registrar un nuevo cliente */
            $listaCL = Cliente::create([
                'nombre' => $this->nombre,
                'cedula' => null,
                'celular' => $this->celular,
                'direccion' => null,
                'email' => null,
                'fecha_nacim' => null,
                'razon_social' => null,
                'nit' => null,
                'procedencia_cliente_id' => 1,
            ]);
            if ($this->cuentaperfil == 'ENTERA') {

                foreach ($this->accounts as $accp) {
                    $DateAndTime = date('Y-m-d h:i:s', time()); 
                    $this->importe += $accp->Plataforma->precioEntera;
                    $plan = Plan::create([
                        'importe' => $this->importe,
                        'plan_start' => $DateAndTime,
                        'expiration_plan' => $this->expiration_plan,
                        'status' => 'VIGENTE',
                        'type_pay' => $this->tipopago,
                        'observations' => $this->observaciones
                    ]);

                    PlanAccount::create([
                        'plan_id' => $plan->id,
                        'account_id' => $accp->id
                    ]);

                    $accp->availability = 'OCUPADO';
                    $accp->save();

                    $mv = Movimiento::create([
                        'type' => 'TERMINADO',
                        'status' => 'ACTIVO',
                        'import' => $this->importe,
                        'user_id' => Auth()->user()->id,
                    ]);

                    CarteraMov::create([
                        'type' => 'INGRESO',
                        'comentario' => '',
                        'cartera_id' => $cartera->id,
                        'movimiento_id' => $mv->id
                    ]);

                    ClienteMov::create([
                        'movimiento_id' => $mv->id,
                        'cliente_id' => $listaCL->id
                    ]);

                    MovPlan::create([
                        'movimiento_id' => $mv->id,
                        'plan_id' => $plan->id
                    ]);
                    $this->importe = 0;
                }
            } elseif ($this->cuentaperfil == 'PERFIL') {
                $DateAndTime = date('Y-m-d h:i:s', time()); 
                
                $plan = Plan::create([
                    'importe' => $this->importe,
                    'plan_start' => $DateAndTime,
                    'expiration_plan' => $this->expiration_plan,
                    'status' => 'VIGENTE',
                    'type_pay' => $this->tipopago,
                    'observations' => $this->observaciones
                ]);

                foreach ($this->profiles as $accp) {

                    $this->importe += $accp->CuentaPerfil->Cuenta->Plataforma->precioPerfil;

                    $pa = PlanAccount::create([
                        'plan_id' => $plan->id,
                        'account_id' => $accp->CuentaPerfil->account_id,
                    ]);

                    $accp->availability = 'OCUPADO';
                    $accp->save();

                    $cuentaPerfil = $accp->CuentaPerfil;
                    $cuentaPerfil->plan_account_id = $pa->id;
                    $cuentaPerfil->save();

                    $perfilesOcupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                        ->join('profiles as p', 'ap.profile_id', 'p.id')
                        ->where('accounts.id', $accp->CuentaPerfil->Cuenta->id)
                        ->where('p.availability', 'OCUPADO')
                        ->where('p.status', 'ACTIVO')->get();

                    if (($perfilesOcupados->count() / 2) == $accp->CuentaPerfil->Cuenta->number_profiles) {

                        $cuenta = $accp->CuentaPerfil->Cuenta;
                        $cuenta->availability = 'OCUPADO';
                        $cuenta->save();
                    }
                }

                $plan->importe = $this->importe;
                $plan->save();

                $mv = Movimiento::create([
                    'type' => 'TERMINADO',
                    'status' => 'ACTIVO',
                    'import' => $this->importe,
                    'user_id' => Auth()->user()->id,
                ]);

                CarteraMov::create([
                    'type' => 'INGRESO',
                    'comentario' => '',
                    'cartera_id' => $cartera->id,
                    'movimiento_id' => $mv->id
                ]);

                ClienteMov::create([
                    'movimiento_id' => $mv->id,
                    'cliente_id' => $listaCL->id
                ]);

                MovPlan::create([
                    'movimiento_id' => $mv->id,
                    'plan_id' => $plan->id
                ]);
            }
            DB::commit();
            $this->resetUI();
            $this->emit('item-added', 'Plan Registrado');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

    protected $listeners = ['deleteRow' => 'Anular'];
    /* Anular una transacción */
    public function Anular(Plan $plan)
    {
        $anular = Plan::join('mov_plans as mp', 'mp.plan_id', 'plans.id')
            ->join('movimientos as m', 'mp.movimiento_id', 'm.id')
            ->join('plan_accounts as pa', 'pa.plan_id', 'plans.id')
            ->join('accounts as a', 'pa.account_id', 'a.id')
            ->join('account_profiles as ap', 'ap.account_id', 'a.id')
            ->join('profiles as p', 'ap.profile_id', 'p.id')
            ->select('m.*', 'pa.id as paid', 'a.id as cuentaid', 'p.id as perfilid', 'ap.id as apid')
            ->whereColumn('pa.id', '=', 'ap.plan_account_id')
            ->where('plans.id', $plan->id)
            ->get()->first();
        $movimiento = Movimiento::find($anular->id);
        $movimiento->status = 'INACTIVO';
        $movimiento->save();

        $planCuenta = PlanAccount::find($anular->paid);
        $planCuenta->status = 'INACTIVO';
        $planCuenta->save();

        $cuenta = Account::find($anular->cuentaid);
        $cuenta->availability = 'LIBRE';
        $cuenta->save();

        $plan->status = 'ANULADO';
        $plan->save();

        $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
            ->join('profiles as p', 'ap.profile_id', 'p.id')
            ->where('accounts.id', $anular->cuentaid)
            ->where('p.availability', 'LIBRE')
            ->where('ap.status', 'ACTIVO')
            ->where('p.status', 'ACTIVO')->get();
        /* PONER EN INACTIVO AccountProfile */
        if ($perfilesActivos->count() > 0) {
            $CuentaPerf = AccountProfile::find($anular->apid);
            $CuentaPerf->status = 'INACTIVO';
            $CuentaPerf->save();
            /* PONER EN INACTIVO EL PERFIL */
            $perf = Profile::find($anular->perfilid);
            $perf->availability = 'LIBRE';
            $perf->status = 'INACTIVO';
            $perf->save();
            /* CONTAR LOS PERFILES ACTIVOS */
            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $cuenta->id)
                ->where('p.availability', 'LIBRE')
                ->where('ap.status', 'ACTIVO')
                ->where('p.status', 'ACTIVO')->get();
            /* SI LA CUENTA NO TIENE PERFILES REGRESA A SER ENTERA */
            if ($perfilesActivos->count() == 0) {
                $cuenta->whole_account = 'ENTERA';
                $cuenta->save();
            }
        }

        $this->emit('item-anulado', 'Se anuló el plan');
    }

    public function viewDetails()
    {
        $this->emit('show-modal2', 'open modal');
    }

    public function VerObservaciones(Plan $plan)
    {
        $this->selected_id = $plan->id;
        $this->observaciones = $plan->observations;
        $this->emit('show-modal3', 'open modal');
    }

    public function Modificar()
    {
        $plan = Plan::find($this->selected_id);
        $plan->observations = $this->observaciones;
        $plan->save();
        $this->resetUI();
        $this->emit('item-actualizado', 'Se actulizaron las observaciones');
    }

    public function resetUI()
    {
        $this->selected_id = 0;
        $this->hora = date("d-m-Y H:i:s ");
        $this->status = 'Vigente';
        $this->p_type = 'VENTA';
        $this->plataforma = 'Elegir';
        $this->cuentaperfil = 'Elegir';
        $this->cantidaperf = 1;
        $this->nombre = '';
        $this->celular = '';
        $this->nit = 0;
        $this->importe = 0;
        $this->condicion = 0;
        $this->select = 1;
        $this->mostrartabla = 0;
        $this->tipopago = 'EFECTIVO';
        $this->condicional = 'perfiles';
        $this->meses = 1;
        $this->observaciones = '';
        $this->resetValidation();
    }
}
