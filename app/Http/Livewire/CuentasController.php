<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\AccountProfile;
use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\ClienteMov;
use App\Models\Email;
use App\Models\Movimiento;
use App\Models\Plan;
use App\Models\PlanAccount;
use App\Models\Platform;
use App\Models\Profile;
use App\Models\StrSupplier;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CuentasController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $platform_id, $email_id, $expiration, $status, $number_profiles,
        $search, $selected_id, $pageTitle, $componentName, $proveedor, $nameP, $PIN, $estado,
        $availability, $Observaciones, $perfiles, $correos, $selected,
        $expiration_account, $password_account, $price, $mostrarCampos, $condicional,
        $meses, $expirationActual, $expirationNueva, $observations, $selected_plan;
    private $pagination = 10;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->componentName = 'Cuentas';
        $this->pageTitle = 'Listado';
        $this->selected_id = 0;
        $this->selected_plan = 0;
        $this->selected = 0;
        $this->email_id = 'Elegir';
        $this->platform_id = 'Elegir';
        $this->proveedor = 'Elegir';
        $this->estado = 'Elegir';
        $this->availability = 'Elegir';
        $this->number_profiles = 5;
        $this->nameP = '';
        $this->PIN = '';
        $this->Observaciones = '';
        $this->perfiles = [];
        $this->correos = [];
        $this->password_account = '';
        $this->price = '';
        $this->mostrarCampos = 0;
        $this->condicional = 'cuentas';
        $this->meses = 0;
        $this->expirationNueva = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->tipopago = 'EFECTIVO';
        $this->importe = 0;
    }
    public function render()
    {
        if ($this->condicional == 'cuentas') {
            if (strlen($this->search) > 0) {
                $cuentas = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                    ->join('emails as e', 'accounts.email_id', 'e.id')
                    ->join('str_suppliers as strsp', 'accounts.str_supplier_id', 'strsp.id')
                    ->select(
                        'accounts.id as id',
                        'accounts.expiration_account as expiration_account',
                        'accounts.number_profiles',
                        'accounts.whole_account',
                        'accounts.password_account',
                        'p.nombre as nombre',
                        'e.content as content',
                        'e.pass as pass',
                        'strsp.name as name',
                        DB::raw('0 as perfActivos'),
                        DB::raw('0 as perfLibres')
                    )
                    ->where('accounts.status', 'like', '%' . $this->search . '%')
                    ->orWhere('accounts.number_profiles', 'like', '%' . $this->search . '%')
                    ->orWhere('p.nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('e.content', 'like', '%' . $this->search . '%')
                    ->orWhere('strsp.name', 'like', '%' . $this->search . '%')
                    ->orderBy('accounts.id', 'desc')
                    ->get();
            } else {
                $cuentas = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                    ->join('emails as e', 'accounts.email_id', 'e.id')
                    ->join('str_suppliers as strsp', 'accounts.str_supplier_id', 'strsp.id')
                    ->select(
                        'accounts.id as id',
                        'accounts.expiration_account as expiration_account',
                        'accounts.number_profiles',
                        'accounts.whole_account',
                        'accounts.password_account',
                        'p.nombre as nombre',
                        'e.content as content',
                        'e.pass as pass',
                        'strsp.name as name',
                        DB::raw('0 as perfActivos'),
                        DB::raw('0 as perfLibres')
                    )
                    ->where('accounts.status', 'ACTIVO')
                    ->where('accounts.availability', 'LIBRE')
                    ->orderBy('accounts.id', 'desc')
                    ->get();
                foreach ($cuentas as $c) {
                    $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                        ->join('profiles as p', 'ap.profile_id', 'p.id')
                        ->where('accounts.id', $c->id)
                        ->where('ap.status', 'ACTIVO')
                        ->where('p.status', 'ACTIVO')->get();
                    $perfilesLibres = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                        ->join('profiles as p', 'ap.profile_id', 'p.id')
                        ->where('accounts.id', $c->id)
                        ->where('p.availability', 'LIBRE')
                        ->where('ap.status', 'ACTIVO')
                        ->where('p.status', 'ACTIVO')->get();
                    $cantidadActivos = $perfilesActivos->count();
                    $c->perfActivos = $cantidadActivos;
                    $cantidadLibres = $perfilesLibres->count();
                    $c->perfLibres = $cantidadLibres;
                }
            }
        } elseif ($this->condicional == 'ocupados') {
            $cuentas = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                ->join('emails as e', 'accounts.email_id', 'e.id')
                ->join('str_suppliers as strsp', 'accounts.str_supplier_id', 'strsp.id')
                ->join('plan_accounts as pa', 'pa.account_id', 'accounts.id')
                ->join('plans as pl', 'pa.plan_id', 'pl.id')
                ->join('movimientos as m', 'm.id', 'pl.movimiento_id')
                ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                ->select(
                    'pl.id as planid',
                    'accounts.id as id',
                    'accounts.expiration_account as expiration_account',
                    'accounts.number_profiles',
                    'accounts.whole_account',
                    'accounts.status',
                    'accounts.password_account',
                    'p.nombre as nombre',
                    'e.content as content',
                    'e.pass as pass',
                    'strsp.name as name',
                    'pl.expiration_plan as expiration_plan',
                    'pl.plan_start as plan_start',
                    'pl.status as plan_status',
                    'c.nombre as clienteNombre',
                    'c.celular as clienteCelular',
                )
                ->where('pa.status', 'ACTIVO')
                ->where('accounts.availability', 'OCUPADO')
                ->where('accounts.status', 'ACTIVO')
                ->orderBy('accounts.id', 'desc')
                ->get();
        } else {
            $cuentas = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                ->join('emails as e', 'accounts.email_id', 'e.id')
                ->join('str_suppliers as strsp', 'accounts.str_supplier_id', 'strsp.id')
                ->join('plan_accounts as pa', 'pa.account_id', 'accounts.id')
                ->join('plans as pl', 'pa.plan_id', 'pl.id')
                ->join('movimientos as m', 'm.id', 'pl.movimiento_id')
                ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                ->select(
                    'pl.id as planid',
                    'accounts.id as id',
                    'accounts.expiration_account as expiration_account',
                    'accounts.number_profiles',
                    'accounts.whole_account',
                    'accounts.status',
                    'accounts.password_account',
                    'p.nombre as nombre',
                    'e.content as content',
                    'e.pass as pass',
                    'strsp.name as name',
                    'pl.expiration_plan as expiration_plan',
                    'pl.plan_start as plan_start',
                    'pl.status as plan_status',
                    'c.nombre as clienteNombre',
                    'c.celular as clienteCelular',
                )
                ->where('pl.status', 'VENCIDO')
                ->orderBy('accounts.id', 'desc')
                ->get();
        }
        $this->correos = Email::where('availability', 'LIBRE')->orWhere('id', $this->selected)->orderBy('id', 'desc')->get();
        if ($this->selected_id != 0) {
            /* MOSTRAR TODOS LOS PERFILES DE ESA CUENTA */
            $this->perfiles = Profile::join('account_profiles as ap', 'ap.profile_id', 'profiles.id')
                ->join('accounts as a', 'ap.account_id', 'a.id')
                ->select(
                    'profiles.id as id',
                    'profiles.nameprofile as namep',
                    'profiles.pin as PIN',
                    'profiles.status as estado',
                    'profiles.availability as availability',
                    'profiles.observations as Observaciones'
                )
                ->where('ap.status', 'ACTIVO')
                ->where('profiles.status', 'ACTIVO')
                ->where('ap.account_id', $this->selected_id)
                ->get();

            $cuenta = Account::find($this->selected_id);
            /* CONTAR LOS PERFILES ACTIVOS Y DE LA CUENTA */
            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $this->selected_id)
                ->where('ap.status', 'ACTIVO')
                ->where('p.status', 'ACTIVO')->get();
            /* SI LA CUENTA TIENE LA CANTIDAD DE PERFILES MAXIMO DE ESA CUENTA - NO MOSTRAR CAMPOS */
            if ($perfilesActivos->count() == $cuenta->number_profiles) {
                $this->mostrarCampos = 1;
            }
            /* SI LA CUENTA TIENE MENOS DE LA CANTIDAD MAXIMA DE PERF - MOSTRAR CAMPOS */
            if ($perfilesActivos->count() < $cuenta->number_profiles) {
                $this->mostrarCampos = 0;
            }
            /* SI LA CUENTA TIENE CERO PERFILES - MOSTRAR CAMPOS */
            if ($perfilesActivos->count() == 0) {
                $this->mostrarCampos = 0;
            }
        }
        if ($this->meses > 0) {
            $dias = $this->meses * 30;
            $this->expirationNueva = strtotime('+' . $dias . ' day', strtotime($this->expirationActual));
            $this->expirationNueva = date('Y-m-d', $this->expirationNueva);
        } else {
            $this->expirationNueva = $this->expirationActual;
        }
        return view('livewire.cuentas.component', [
            'cuentas' => $cuentas,
            'plataformas' => Platform::where('estado', 'ACTIVO')->orderBy('nombre', 'asc')->get(),
            'proveedores' => StrSupplier::where('status', 'ACTIVO')->orderBy('id', 'asc')->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function Store()
    {
        $rules = [
            'expiration_account' => 'required',
            'number_profiles' => 'required',
            'platform_id' => 'required|not_in:Elegir',
            'proveedor' => 'required|not_in:Elegir',
            'email_id' => 'required|not_in:Elegir|unique:accounts'
        ];
        $messages = [
            'expiration_account.required' => 'La fecha de expiración es requerida',
            'number_profiles.required' => 'La cantidad de perfiles es requerida',
            'platform_id.required' => 'La plataforma es requerida',
            'platform_id.not_in' => 'Elija una plataforma distinta a Elegir',
            'email_id.required' => 'El correo es requerido',
            'email_id.not_in' => 'Elija un correo distinto a Elegir',
            'email_id.unique' => 'El email ya existe registrado en una cuenta refresca la pagina',
            'proveedor.required' => 'El proveedor es requerido',
            'proveedor.not_in' => 'El proveedor tiene que ser diferente de Elegir',
        ];

        $this->validate($rules, $messages);

        DB::beginTransaction();
        try {
            Account::create([
                'expiration_account' => $this->expiration_account,
                'status' => $this->estado,
                'whole_account' => 'ENTERA',
                'number_profiles' => $this->number_profiles,
                'password_account' => $this->password_account,
                'price' => $this->price,
                'str_supplier_id' => $this->proveedor,
                'platform_id' => $this->platform_id,
                'email_id' => $this->email_id,
            ]);

            $correo = Email::find($this->email_id);
            $correo->availability = 'OCUPADO';
            $correo->save();
            DB::commit();
            $this->resetUI();
            $this->emit('item-added', 'Cuenta Registrada');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

    public function Agregar()
    {
        $this->resetUI();
        $this->emit('modal-show', 'show modal!');
    }

    public function Edit(Account $acc)
    {
        $this->selected_id = $acc->id;
        $this->selected = $acc->email_id;
        $this->expiration_account = $acc->expiration_account;
        $this->estado = $acc->status;
        $this->number_profiles = $acc->number_profiles;
        $this->password_account = $acc->password_account;
        $this->price = $acc->price;
        $this->proveedor = $acc->str_supplier_id;
        $this->platform_id = $acc->platform_id;
        $this->email_id = $acc->email_id;
        $this->emit('modal-show', 'show modal!');
    }

    public function Update()
    {
        $rules = [
            'expiration_account' => 'required',
            'number_profiles' => 'required',
            'platform_id' => 'required|not_in:Elegir',
            'proveedor' => 'required|not_in:Elegir',
            'email_id' => "required|not_in:Elegir|unique:accounts,email_id,{$this->selected_id}"
        ];

        $messages = [
            'expiration_account.required' => 'La fecha de expiración es requerida',
            'number_profiles.required' => 'La cantidad de perfiles es requerida',
            'platform_id.required' => 'La plataforma es requerida',
            'platform_id.not_in' => 'Elija una plataforma distinta a Elegir',
            'email_id.required' => 'El correo es requerido',
            'email_id.not_in' => 'Elija un correo distinto a Elegir',
            'email_id.unique' => 'El email ya existe registrado en una cuenta refresca la pagina',
            'proveedor.required' => 'El proveedor es requerido',
            'proveedor.not_in' => 'El proveedor tiene que ser diferente de Elegir',
        ];

        $this->validate($rules, $messages);

        $acc = Account::find($this->selected_id);

        $acc->update([
            'expiration_account' => $this->expiration_account,
            'status' => $this->estado,
            'number_profiles' => $this->number_profiles,
            'password_account' => $this->password_account,
            'price' => $this->price,
            'str_supplier_id' => $this->proveedor,
            'platform_id' => $this->platform_id,
            'email_id' => $this->email_id,
        ]);
        $acc->save();


        $this->resetUI();
        $this->emit('item-updated', 'Cuenta Actualizada');
    }

    protected $listeners = ['deleteRow' => 'Destroy', 'borrarPerfil' => 'BorrarPerfil'];

    public function Crear(Account $acc)
    {
        $this->selected_id = $acc->id;

        $this->emit('details-show', 'show modal!');
    }

    public function CrearPerfil()
    {
        $cuenta = Account::find($this->selected_id);

        $perfil = Profile::create([
            'nameprofile' => $this->nameP,
            'pin' => $this->PIN,
            'status' => $this->estado,
            'availability' => $this->availability,
            'observations' => $this->Observaciones,
            'entity' => 'PERFIL'
        ]);
        AccountProfile::create([
            'account_id' => $this->selected_id,
            'profile_id' => $perfil->id,
        ]);
        /* LA CUENTA PASA A DIVIDIDA */
        $cuenta->whole_account = 'DIVIDIDA';
        $cuenta->save();

        $this->nameP = '';
        $this->PIN = '';
        $this->estado = 'Elegir';
        $this->availability = 'Elegir';
        $this->Observaciones = '';

        $this->emit('item-deleted', 'Perfil Registrado');
    }

    public function BorrarPerfil(Profile $perf)
    {   /* PONER EN INACTIVO AccountProfile */
        $CuentaPerf = $perf->CuentaPerfil;
        $CuentaPerf->status = 'INACTIVO';
        $CuentaPerf->save();
        /* PONER EN INACTIVO EL PERFIL */
        $perf->status = 'INACTIVO';
        $perf->save();
        /* CONTAR LOS PERFILES ACTIVOS OCUPADOS */
        $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
            ->join('profiles as p', 'ap.profile_id', 'p.id')
            ->where('accounts.id', $this->selected_id)
            ->where('ap.status', 'ACTIVO')
            ->where('p.status', 'ACTIVO')->get();
        /* SI LA CUENTA NO TIENE PERFILES ACTIVOS REGRESA A SER ENTERA */
        if ($perfilesActivos->count() == 0) {
            $cuenta = Account::find($this->selected_id);
            $cuenta->whole_account = 'ENTERA';
            $cuenta->save();
        }
        $this->emit('item-deleted', 'Perfil Eliminado');
    }


    public function Acciones(Plan $plan)
    {
        $this->meses = 0;
        $this->selected_plan = $plan->id;
        /* OBTENER FECHA DE EXPIRACION DEL PLAN */
        $this->expirationActual = Plan::where('plans.id', $plan->id)
            ->get()->first()->expiration_plan;

        $this->expirationActual = substr($this->expirationActual, 0, 10);
        /* dd($this->expirationActual); */
        $this->emit('details2-show', 'show modal!');
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
        /* CAJA EN LA QUE ESTA EL USUARIO */
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

        if ($this->tipopago == 'EFECTIVO') {    /* SI PAGA EN EFECTIVO */
            $cartera = Cartera::where('tipo', 'cajafisica')
                ->where('caja_id', $CajaActual->id)
                ->get()->first();
        } else {        /* SI PAGA POR TIGO MNY O BANCO */
            $cartera = Cartera::where('tipo', $this->tipopago)
                ->where('caja_id', $CajaActual->id)->get()->first();
        }
        /* OBTENER IDS PARA HACER LOS CAMBIOS */
        $datos = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
            ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
            ->join('accounts as acc', 'acc.id', 'pa.account_id')
            ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
            ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
            ->select(
                'c.*',
                'acc.id as cuentaid',
                'plans.id as planid',
                'pa.id as planAccountid',
            )
            ->where('plans.id', $this->selected_plan)
            ->get()->first();
        /* CALCULAR IMPORTE SEGUN LA PLATAFORMA DE LA CUENTA */
        $cuenta = Account::find($datos->cuentaid);
        $this->importe += $cuenta->Plataforma->precioEntera;
        $this->importe *= $this->meses;
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
                'plan_id' => $plan->id,
                'account_id' => $cuenta->id,
            ]);

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

            /* PONER EN VENCIDO EL PLAN ANTIGUO */
            $planviejo = Plan::find($datos->planid);
            $planviejo->status = 'VENCIDO';
            $planviejo->save();

            /* PONER EN INACTIVO EL PLAN ACCOUNT */
            $planCuenta = PlanAccount::find($datos->planAccountid);
            $planCuenta->status = 'INACTIVO';
            $planCuenta->save();

            DB::commit();
            $this->resetUI();
            $this->emit('cuenta-renovado-vencida', 'Se renovó la cuenta');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }
    public function Vencer()
    {
        /* OBTENER IDS */
        $datos = Plan::join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
            ->join('accounts as acc', 'acc.id', 'pa.account_id')
            ->select(
                'acc.id as cuentaid',
                'pa.id as paid'
            )
            ->where('plans.id', $this->selected_plan)
            ->get()->first();
        /* PONER LA CUENTA EN LIBRE */
        $cuenta = Account::find($datos->cuentaid);
        $cuenta->availability = 'LIBRE';
        $cuenta->save();
        /* PONER EL PLANACCOUNT EN INACTIVO */
        $plancuenta = PlanAccount::find($datos->paid);
        $plancuenta->status = 'INACTIVO';
        $plancuenta->save();

        $this->resetUI();
        $this->emit('cuenta-renovado-vencida', 'No se renovó este perfil y ahora esta inactivo');
    }

    public function resetUI()
    {
        $this->selected_id = 0;
        $this->selected_plan = 0;
        $this->selected = 0;
        $this->email_id = 'Elegir';
        $this->platform_id = 'Elegir';
        $this->proveedor = 'Elegir';
        $this->estado = 'Elegir';
        $this->availability = 'Elegir';
        $this->number_profiles = 5;
        $this->nameP = '';
        $this->PIN = '';
        $this->Observaciones = '';
        $this->perfiles = [];
        $this->correos = [];
        $this->password_account = '';
        $this->price = '';
        $this->mostrarCampos = 0;
        $this->meses = 0;
        $this->expirationNueva = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->tipopago = 'EFECTIVO';
        $this->importe = 0;
        $this->resetValidation();
    }
}
