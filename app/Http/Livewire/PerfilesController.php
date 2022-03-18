<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\AccountProfile;
use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\ClienteMov;
use App\Models\Movimiento;
use App\Models\Plan;
use App\Models\PlanAccount;
use App\Models\Profile;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PerfilesController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $nameperfil, $pin, $status, $availability, $observations,
        $search, $selected_id, $pageTitle, $componentName, $condicional,
        $meses, $expirationNueva, $expirationActual, $tipopago, $importe, $mostrartabla2, $perfil;
    private $pagination = 10;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->status = 'Elegir';
        $this->nameperfil = '';
        $this->availability = 'Elegir';
        $this->pageTitle = 'Listado';
        $this->componentName = 'Perfiles';
        $this->condicional = 'libres';
        $this->meses = 0;
        $this->expirationNueva = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->tipopago = 'EFECTIVO';
        $this->importe = 0;
        $this->mostrartabla2 = 0;
        $this->perfil = [];
    }
    public function render()
    {
        if ($this->condicional == 'libres') {
            if (strlen($this->search) > 0) {
                /* $prof = Profile::join('account_profiles as ap', 'ap.profile_id', 'profiles.id')
                    ->join('accounts as a', 'ap.account_id', 'a.id')
                    ->join('emails as e', 'e.id', 'a.email_id')
                    ->join('platforms as p', 'p.id', 'a.platform_id')
                    ->select(
                        'profiles.*',
                        'pl.expiration_plan as expiration',
                        'a.expiration_account as expiration',
                        'profiles.nameprofile as namep',
                        'a.password_account as passAccount',
                        'p.nombre',
                        'p.image',
                        'e.content',
                        'e.pass',
                        'a.expiration_account as exp',
                    )
                    ->where('profiles.availability', 'LIBRE')
                    ->where('profiles.status', 'ACTIVO')
                    ->where('a.expiration_account', 'like', '%' . $this->search . '%')
                    ->orWhere('profiles.pin', 'like', '%' . $this->search . '%')
                    ->orWhere('profiles.status', 'like', '%' . $this->search . '%')
                    ->orWhere('profiles.availability', 'like', '%' . $this->search . '%')
                    ->orWhere('profiles.observations', 'like', '%' . $this->search . '%')
                    ->orWhere('p.nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('e.content', 'like', '%' . $this->search . '%')
                    ->orWhere('e.pass', 'like', '%' . $this->search . '%')
                    ->orderBy('profiles.id', 'desc')
                    ->paginate($this->pagination); */
            } else {
                $prof = Profile::join('account_profiles as ap', 'ap.profile_id', 'profiles.id')
                    ->join('accounts as a', 'ap.account_id', 'a.id')
                    ->join('emails as e', 'e.id', 'a.email_id')
                    ->join('platforms as p', 'p.id', 'a.platform_id')
                    ->select(
                        'profiles.*',
                        'a.expiration_account as expiration',
                        'profiles.nameprofile as namep',
                        'a.password_account as passAccount',
                        'p.nombre',
                        'p.image',
                        'e.content',
                        'e.pass',
                        'ap.status as estadoCuentaPerfil',
                    )
                    ->where('profiles.availability', 'LIBRE')
                    ->where('profiles.status', 'ACTIVO')
                    ->orderBy('a.expiration_account', 'desc')
                    ->paginate($this->pagination);
            }
        } elseif ($this->condicional == 'ocupados') {
            if (strlen($this->search) > 0) {
                /* $prof = Profile::join('account_profiles as ap', 'ap.profile_id', 'profiles.id')
                    ->join('accounts as a', 'ap.account_id', 'a.id')
                    ->join('emails as e', 'e.id', 'a.email_id')
                    ->join('platforms as p', 'p.id', 'a.platform_id')
                    ->join('plan_accounts as pa', 'pa.account_id', 'a.id')
                    ->join('plans as pl', 'pa.plan_id', 'pl.id')
                    ->select(
                        'profiles.*',
                        'pl.expiration_plan as expiration_plan',
                        'a.expiration_account as expiration',
                        'profiles.nameprofile as namep',
                        'a.password_account as passAccount',
                        'p.nombre',
                        'p.image',
                        'e.content',
                        'e.pass',
                    )
                    ->where('profiles.availability', 'OCUPADO')
                    ->where('profiles.status', 'ACTIVO')
                    ->where('a.expiration_account', 'like', '%' . $this->search . '%')
                    ->orWhere('profiles.pin', 'like', '%' . $this->search . '%')
                    ->orWhere('profiles.status', 'like', '%' . $this->search . '%')
                    ->orWhere('profiles.availability', 'like', '%' . $this->search . '%')
                    ->orWhere('profiles.observations', 'like', '%' . $this->search . '%')
                    ->orWhere('p.nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('e.content', 'like', '%' . $this->search . '%')
                    ->orWhere('e.pass', 'like', '%' . $this->search . '%')
                    ->orderBy('pl.expiration_plan', 'desc')
                    ->paginate($this->pagination); */
            } else {
                $prof = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                    ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                    ->join('accounts as acc', 'acc.id', 'pa.account_id')
                    ->join('account_profiles as ap', 'acc.id', 'ap.account_id')
                    ->join('profiles as prof', 'prof.id', 'ap.profile_id')
                    ->join('emails as e', 'e.id', 'acc.email_id')
                    ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                    ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                    ->select(
                        'prof.*',
                        'prof.nameprofile as namep',
                        'plans.expiration_plan as expiration_plan',
                        'plans.plan_start as plan_start',
                        'acc.expiration_account as expiration',
                        'acc.password_account as passAccount',
                        'plat.nombre',
                        'plat.image',
                        'e.content',
                        'e.pass',
                        'ap.status as estadoCuentaPerfil',
                        'plans.id as planid',
                        'c.nombre as clienteNombre',
                        'c.celular as clienteCelular',
                    )
                    ->where('acc.whole_account', 'DIVIDIDA')
                    ->where('prof.availability', 'OCUPADO')
                    ->where('prof.status', 'ACTIVO')
                    ->where('plans.status', 'VIGENTE')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')
                    ->where('pa.status', 'ACTIVO')
                    ->where('ap.status', 'ACTIVO')
                    ->orderBy('plans.expiration_plan', 'desc')
                    ->paginate($this->pagination);
            }
        } else {
            $prof = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                ->join('accounts as acc', 'acc.id', 'pa.account_id')
                ->join('account_profiles as ap', 'acc.id', 'ap.account_id')
                ->join('profiles as prof', 'prof.id', 'ap.profile_id')
                ->join('emails as e', 'e.id', 'acc.email_id')
                ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                ->select(
                    'prof.*',
                    'prof.nameprofile as namep',
                    'plans.expiration_plan as expiration_plan',
                    'plans.plan_start as plan_start',
                    'acc.expiration_account as expiration',
                    'acc.password_account as passAccount',
                    'plat.nombre',
                    'plat.image',
                    'e.content',
                    'e.pass',
                    'ap.status as estadoCuentaPerfil',
                    'plans.id as planid',
                    'c.nombre as clienteNombre',
                    'c.celular as clienteCelular',
                )
                ->where('plans.status', 'VENCIDO')
                ->whereColumn('plans.id', '=', 'ap.plan_id')
                ->where('ap.status', 'VENCIDO')
                ->orderBy('plans.expiration_plan', 'desc')
                ->paginate($this->pagination);
        }
        /* CALCULAR LA FECHA DE EXPIRACION NUEVA SEGUN LA CANTIDAD DE MESES A RENOVAR */
        if ($this->meses > 0) {
            $dias = $this->meses * 30;
            $this->expirationNueva = strtotime('+' . $dias . ' day', strtotime($this->expirationActual));
            $this->expirationNueva = date('Y-m-d', $this->expirationNueva);
        } else {
            $this->expirationNueva = $this->expirationActual;
        }

        return view('livewire.perfiles.component', [
            'profiles' => $prof,
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit(Profile $prof)
    {
        $this->selected_id = $prof->id;
        $this->nameperfil = $prof->nameprofile;
        $this->pin = $prof->pin;
        $this->status = $prof->status;
        $this->availability = $prof->availability;
        $this->observations = $prof->observations;

        $this->emit('modal-show', 'show modal!');
    }

    public function Update()
    {
        $rules = [
            'nameperfil' => 'required',
            'pin' => 'required',
            'status' => 'required|not_in:Elegir',
            'availability' => 'required|not_in:Elegir'
        ];
        $messages = [
            'nameperfil.required' => 'El nombre del perfil es requerido',
            'pin.required' => 'El pin del perfil es requerido',
            'status.required' => 'El estado es requerido',
            'status.not_in' => 'Elija un estado distinto a Elegir',
            'availability.required' => 'La disponibilidad es requerida',
            'availability.not_in' => 'Elija una plataforma distinta a Elegir'
        ];

        $this->validate($rules, $messages);

        $prof = Profile::find($this->selected_id);

        $prof->update([
            'nameperfil' => $this->nameperfil,
            'pin' => $this->pin,
            'status' => $this->status,
            'availability' => $this->availability,
            'observations' => $this->observations
        ]);

        $this->resetUI();
        $this->emit('item-updated', 'Perfil Actualizado');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Profile $perf)
    {
        /* PONER EN INACTIVO EL ACCOUNTPROFILE */
        $CuentaPerf = $perf->CuentaPerfil;
        $CuentaPerf->status = 'INACTIVO';
        $CuentaPerf->save();
        /* PONER EN INACTIVO EL PERFIL */
        $perf->status = 'INACTIVO';
        $perf->save();
        $Cuenta = Account::find($perf->CuentaPerfil->Cuenta->id);
        /* CONTAR LOS PERFILES ACTIVOS */
        $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
            ->join('profiles as p', 'ap.profile_id', 'p.id')
            ->where('accounts.id', $Cuenta->id)
            ->where('ap.status', 'ACTIVO')
            ->where('p.status', 'ACTIVO')->get();
        /* SI LA CUENTA NO TIENE PERFILES REGRESA A SER ENTERA */
        if ($perfilesActivos->count() == 0) {
            $cuenta = Account::find($Cuenta->id);
            $cuenta->whole_account = 'ENTERA';
            $cuenta->save();
        }
        $this->resetUI();
        $this->emit('item-deleted', 'Perfil Eliminado');
    }

    public function Acciones(Plan $plan)
    {
        $this->selected_id = $plan->id;
        /* OBTENER FECHA DE EXPIRACION DEL PLAN PARA CALCULAR LA FECHA DE EXPIRACION NUEVA */
        $this->expirationActual = Plan::where('plans.id', $plan->id)
            ->get()->first()->expiration_plan;
        $this->expirationActual = substr($this->expirationActual, 0, 10);
        $this->emit('details-show', 'show modal!');
    }
    public function Renovar()
    {
        $rules = [
            'tipopago' => 'required|not_in:Elegir',
            'meses' => 'required|not_in:0',
        ];
        $messages = [
            'tipopago.required' => 'El tipo de pago es requerido',
            'tipopago.not_in' => 'Seleccione un valor distinto a Elegir',
            'meses.required' => 'la cantidad de meses debe ser un número valido',
            'meses.not_in' => 'La cantidad de meses debe ser mayor a 0',
        ];

        $this->validate($rules, $messages);
        /* OBTENER LA CAJA EN LA CUAL ESTA EL USUARIO */
        $CajaActual = Caja::join('sucursals as s', 's.id', 'cajas.sucursal_id')
            ->join('sucursal_users as su', 'su.sucursal_id', 's.id')
            ->join('carteras as car', 'cajas.id', 'car.caja_id')
            ->join('cartera_movs as cartmovs', 'car.id', 'cartmovs.cartera_id')
            ->join('movimientos as mov', 'mov.id', 'cartmovs.movimiento_id')
            ->where('mov.user_id', Auth()->user()->id)
            ->where('mov.status', 'ACTIVO')
            ->where('mov.type', 'APERTURA')
            ->select('cajas.id as id')
            ->get()->first();
        /* SI PAGA EN EFECTIVO */
        if ($this->tipopago == 'EFECTIVO') {
            $cartera = Cartera::where('tipo', 'cajafisica')
                ->where('caja_id', $CajaActual->id)
                ->get()->first();
        } else {    /* SI PAGA POR TIGO MONEY O BANCO */
            $cartera = Cartera::where('tipo', $this->tipopago)
                ->where('caja_id', $CajaActual->id)->get()->first();
        }
        /* OBTENER IDS PARA HACER LAS MODIFICACIONES */
        $datos = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
            ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
            ->join('accounts as acc', 'acc.id', 'pa.account_id')
            ->join('account_profiles as ap', 'acc.id', 'ap.account_id')
            ->join('profiles as prof', 'prof.id', 'ap.profile_id')
            ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
            ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
            ->select(
                'c.*',
                'plans.id as planid',
                'pa.id as planAccountid',
                'ap.id as accountProfileid',
                'prof.id as Profileid'
            )
            ->where('plans.id', $this->selected_id)
            ->whereColumn('plans.id', '=', 'ap.plan_id')
            ->orderby('plans.id', 'desc')
            ->get()->first();

        $perfil = Profile::find($datos->Profileid);
        /* CALCULAR EL IMPORTE SEGUN EL PRECIO DEL PERFIL Y LA CANTIDAD DE MESES A RENOVAR */
        $this->importe += $perfil->CuentaPerfil->Cuenta->Plataforma->precioPerfil;
        $this->importe = $this->importe * $this->meses;

        DB::beginTransaction();
        try {
            $mv = Movimiento::create([
                'type' => 'TERMINADO',
                'status' => 'ACTIVO',
                'import' => $this->importe,
                'user_id' => Auth()->user()->id,
            ]);

            $plan = Plan::create([
                'importe' => $this->importe,
                'plan_start' => $this->expirationActual,
                'expiration_plan' => $this->expirationNueva,
                'ready' => 'NO',
                'status' => 'VIGENTE',
                'type_pay' => $this->tipopago,
                'observations' => $this->observations,
                'movimiento_id' => $mv->id
            ]);

            PlanAccount::create([
                'status' => 'ACTIVO',
                'plan_id' => $plan->id,
                'account_id' => $perfil->CuentaPerfil->account_id,
            ]);

            AccountProfile::create([
                'account_id' => $perfil->CuentaPerfil->Cuenta->id,
                'profile_id' => $perfil->id,
                'plan_id' => $plan->id,
                'status' => 'ACTIVO',
            ]);
            /* PONER EN VENCIDO EL PLAN ANTERIOR */
            $planviejo = Plan::find($datos->planid);
            $planviejo->status = 'VENCIDO';
            $planviejo->save();
            /* PONER EN VENCIDO ACCOUNTPROFILE */
            $cuentaPerfil = AccountProfile::find($datos->accountProfileid);
            $cuentaPerfil->status = 'VENCIDO';
            $cuentaPerfil->save();
            /* PONER EN VENCIDO PLANACCOUNT */
            $planCuenta = PlanAccount::find($datos->planAccountid);
            $planCuenta->status = 'VENCIDO';
            $planCuenta->save();
            /* PONER EN OCUPADO EL PERFIL */
            $perfil->availability = 'OCUPADO';
            $perfil->save();
            /* CONTAR PERFILES OCUPADOS */
            /* $perfilesOcupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $perfil->CuentaPerfil->Cuenta->id)
                ->where('p.availability', 'OCUPADO')
                ->where('p.status', 'ACTIVO')->get(); */

            /* SI LA CUENTA TIENE TODOS SUS PERFILES OCUPADOS LA CUENTA PASA A OCUPADA */
            /* if (($perfilesOcupados->count() / 2) == $perfil->CuentaPerfil->Cuenta->number_profiles) {
                $cuenta = $perfil->CuentaPerfil->Cuenta;
                $cuenta->availability = 'OCUPADO';
                $cuenta->save();
            } */

            CarteraMov::create([
                'type' => 'INGRESO',
                'comentario' => '',
                'cartera_id' => $cartera->id,
                'movimiento_id' => $mv->id
            ]);

            ClienteMov::create([
                'movimiento_id' => $mv->id,
                'cliente_id' => $datos->id
            ]);

            DB::commit();
            $this->resetUI();
            $this->emit('item-accion', 'Se renovó este perfil');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }

        $this->emit('details-show', 'show modal!');
    }
    public function Vencer()
    {   /* OBTENER EL ID DEL PERFIL Y LA CUENTA */
        $datos = Plan::join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
            ->join('accounts as acc', 'acc.id', 'pa.account_id')
            ->join('account_profiles as ap', 'acc.id', 'ap.account_id')
            ->join('profiles as prof', 'prof.id', 'ap.profile_id')
            ->select(
                'prof.id as Profileid',
                'acc.id as cuentaid',
                'pa.id as plAccountid',
                'ap.id as accproid',
                'plans.id as planid',
            )
            ->where('plans.id', $this->selected_id)
            ->where('prof.status', 'ACTIVO')
            ->whereColumn('plans.id', '=', 'ap.plan_id')
            ->orderby('plans.id', 'desc')
            ->get()->first();

        $planAntiguo = Plan::find($datos->planid);
        $planAntiguo->status = 'VENCIDO';
        $planAntiguo->save();

        $plaAcount = PlanAccount::find($datos->plAccountid);
        $plaAcount->status = 'VENCIDO';
        $plaAcount->save();

        $perf = Profile::find($datos->Profileid);
        /* PONER EN INACTIVO AccountProfile */
        $CuentaPerf = AccountProfile::find($datos->accproid);
        $CuentaPerf->status = 'VENCIDO';
        $CuentaPerf->save();
        /* PONER EN INACTIVO EL PERFIL */
        $perf->availability = 'LIBRE';
        $perf->status = 'INACTIVO';
        $perf->save();

        $Cuenta = Account::find($perf->CuentaPerfil->Cuenta->id);
        /* CONTAR LOS PERFILES ACTIVOS */
        $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
            ->join('profiles as p', 'ap.profile_id', 'p.id')
            ->where('accounts.id', $Cuenta->id)
            ->where('ap.status', 'ACTIVO')
            ->where('p.status', 'ACTIVO')->get();
        /* SI LA CUENTA NO TIENE PERFILES ACTIVOS REGRESA A SER ENTERA */
        if ($perfilesActivos->count() == 0) {
            $Cuenta->whole_account = 'ENTERA';
            $Cuenta->save();
        }
        $this->resetUI();
        $this->emit('item-accion', 'No se renovó este perfil y ahora esta inactivo');
    }
    public function CambiarCuenta()
    {
        $this->mostrartabla2 = 1;
        /* OBTENER EL ID DEL PERFIL Y LA CUENTA */
        $datos = Plan::join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
            ->join('accounts as acc', 'acc.id', 'pa.account_id')
            ->join('platforms as p', 'p.id', 'acc.platform_id')
            ->select(
                'p.id as platfid',
            )
            ->where('plans.id', $this->selected_id)
            ->orderby('plans.id', 'desc')
            ->get()->first();

        $this->perfil = Profile::join('account_profiles as ap', 'ap.profile_id', 'profiles.id')
            ->join('accounts as a', 'ap.account_id', 'a.id')
            ->join('platforms as p', 'a.platform_id', 'p.id')
            ->join('emails as e', 'a.email_id', 'e.id')
            ->select(
                'profiles.id as id',
                'p.precioPerfil as precioPerfil',
                'a.id as cuentaid',
                'e.content as email',
                'profiles.nameprofile as nombre_perfil',
                'profiles.pin as pin',
                'a.password_account as password_account'
            )
            ->where('profiles.availability', 'LIBRE')
            ->where('profiles.status', 'ACTIVO')
            ->where('a.status', 'ACTIVO')
            ->orderBy('a.expiration_account', 'desc')
            ->where('p.id', $datos->platfid)
            ->get()->first();
        /* dd($this->perfil); */
    }
    public function CambiarAccount(Profile $perf)
    {
        /* Datos del anterior */
        $datos = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
            ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
            ->join('accounts as acc', 'acc.id', 'pa.account_id')
            ->join('account_profiles as ap', 'acc.id', 'ap.account_id')
            ->join('profiles as prof', 'prof.id', 'ap.profile_id')
            ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
            ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
            ->select(
                'c.*',
                'plans.id as planid',
                'pa.id as planAccountid',
                'ap.id as accountProfileid',
                'prof.id as Profileid',
                'acc.id as cuentaid',
            )
            ->where('plans.id', $this->selected_id)
            ->whereColumn('plans.id', '=', 'ap.plan_id')
            ->orderby('plans.id', 'desc')
            ->get()->first();
        DB::beginTransaction();
        try {
            /* PONER EN INACTIVO EL PERFIL */
            $perfilViejo = Profile::find($datos->Profileid);
            $perfilViejo->status = 'INACTIVO';
            $perfilViejo->availability = 'LIBRE';
            $perfilViejo->save();

            /* PONER DATOS DEL ANTERIOR PERFIL AL NUEVO PERFIL */
            $perf->update([
                'nameprofile' => $perfilViejo->nameprofile,
                'pin' => $perfilViejo->pin,
                'availability' => 'OCUPADO',
            ]);
            /* OBTENER LA CUENTA DEL NUEVO PERFIL */
            $CuentaNueva = Account::find($perf->CuentaPerfil->Cuenta->id);

            $planAccountVIEJO = PlanAccount::find($datos->planAccountid);
            /* ACTULIZAR EL PLAN ACCOUNT PONIENDO LA NUEVA CUENTA */
            /* $planAccount->update([
                'account_id' => $CuentaNueva->id,
            ]); */
            $planAccountVIEJO->update([
                'status' => 'VENCIDO',
            ]);
            PlanAccount::create([
                'plan_id' => $datos->planid,
                'account_id' => $CuentaNueva->id,
            ]);

            /* ACTUALIZAR EL ACCOUNT PROFILE PONIENDO NUEVA CUENTA Y NUEVO PERFIL */
            $cuentaPerfil = AccountProfile::find($datos->accountProfileid);
            /* $cuentaPerfil->update([
                'account_id' => $CuentaNueva->id,
                'profile_id' => $perf->id,
            ]); */
            $cuentaPerfil->update([
                'status' => 'VENCIDO',
            ]);
            AccountProfile::create([
                'status' => 'ACTIVO',
                'account_id' => $CuentaNueva->id,
                'profile_id' => $perf->id,
                'plan_id' => $datos->planid,
            ]);

            /* CONTAR LOS PERFILES ACTIVOS OCUPADOS */
            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $datos->cuentaid)
                ->where('ap.status', 'ACTIVO')
                ->where('p.status', 'ACTIVO')->get();

            /* SI LA CUENTA NO TIENE PERFILES ACTIVOS REGRESA A SER ENTERA */
            if ($perfilesActivos->count() == 0) {
                $cuenta = Account::find($datos->cuentaid);
                $cuenta->whole_account = 'ENTERA';
                $cuenta->save();
            }
            /* ELIMINAR DUPLICADO ACCOUNT-PROFILE SI EXISTE "CUENTA Y PERFIL IGUALES EN UN REGISTRO" */
            $accountProfilesD = AccountProfile::where('account_id', $CuentaNueva->id)
                ->where('profile_id', $perf->id)->get();
            foreach ($accountProfilesD as $acc) {
                if ($acc->plan_id == null) {
                    $acc->delete();
                }
            }
            DB::commit();
            $this->resetUI();
            $this->emit('item-accion', 'Se renovó este perfil');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }
    public function resetUI()
    {
        $this->status = 'Elegir';
        $this->nameperfil = '';
        $this->availability = 'Elegir';
        $this->meses = 0;
        $this->expirationNueva = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->tipopago = 'EFECTIVO';
        $this->importe = 0;
        $this->resetValidation();
    }
}
