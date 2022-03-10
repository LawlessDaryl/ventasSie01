<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\AccountProfile;
use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\ClienteMov;
use App\Models\Movimiento;
use App\Models\MovPlan;
use App\Models\Plan;
use App\Models\PlanAccount;
use App\Models\Profile;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Symfony\Component\HttpKernel\Profiler\Profile as ProfilerProfile;

class PerfilesController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $nameperfil, $pin, $status, $availability, $observations,
        $search, $selected_id, $pageTitle, $componentName, $condicional,
        $meses, $expirationNueva, $expirationActual, $tipopago, $importe;
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
        $this->tipopago = 'Elegir';
        $this->importe = 0;
    }
    public function render()
    {
        if ($this->condicional == 'ocupados') {
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
                $prof = Plan::join('mov_plans as mp', 'plans.id', 'mp.plan_id')
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
                        'prof.*',
                        'prof.nameprofile as namep',
                        'plans.expiration_plan as expiration_plan',
                        'acc.expiration_account as expiration',
                        'acc.password_account as passAccount',
                        'plat.nombre',
                        'plat.image',
                        'e.content',
                        'e.pass',
                    )
                    ->where('acc.whole_account', 'DIVIDIDA')
                    ->where('prof.availability', 'OCUPADO')
                    ->where('prof.status', 'ACTIVO')
                    ->where('plans.status', 'VIGENTE')
                    ->whereColumn('pa.id', '=', 'ap.plan_account_id')
                    ->where('pa.status', 'ACTIVO')
                    ->where('ap.status', 'ACTIVO')
                    ->orderBy('plans.expiration_plan', 'desc')
                    ->paginate($this->pagination);
            }
        } elseif ($this->condicional == 'libres') {
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
                    /* ->join('plan_accounts as pa', 'pa.account_id', 'a.id')
                    ->join('plans as pl', 'pa.plan_id', 'pl.id') */
                    ->select(
                        'profiles.*',
                        'a.expiration_account as expiration',
                        'profiles.nameprofile as namep',
                        'a.password_account as passAccount',
                        'p.nombre',
                        'p.image',
                        'e.content',
                        'e.pass',
                    )
                    ->where('profiles.availability', 'LIBRE')
                    ->where('profiles.status', 'ACTIVO')
                    ->orderBy('a.expiration_account', 'desc')
                    ->paginate($this->pagination);
            }
        } else {
            $prof = Plan::join('mov_plans as mp', 'plans.id', 'mp.plan_id')
                ->join('movimientos as m', 'm.id', 'mp.movimiento_id')
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
                    'acc.expiration_account as expiration',
                    'acc.password_account as passAccount',
                    'plat.nombre',
                    'plat.image',
                    'e.content',
                    'e.pass',
                )
                ->whereColumn('pa.id', '=', 'ap.plan_account_id')
                ->where('ap.status', 'INACTIVO')
                ->where('pa.status', 'INACTIVO')
                ->where('plans.status', 'VENCIDO')
                ->orderBy('plans.created_at', 'desc')
                ->paginate($this->pagination);
        }

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

    public function Destroy(Profile $prof)
    {
        $prof->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Perfil Eliminado');
    }
    public function Acciones(Profile $prof)
    {
        $this->selected_id = $prof->id;
        $this->selected_id = $prof->id;
        $this->selected_id = $prof->id;
        $this->expirationActual = Plan::join('mov_plans as mp', 'plans.id', 'mp.plan_id')
            ->join('movimientos as m', 'm.id', 'mp.movimiento_id')
            ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
            ->join('accounts as acc', 'acc.id', 'pa.account_id')
            ->join('account_profiles as ap', 'acc.id', 'ap.account_id')
            ->join('profiles as prof', 'prof.id', 'ap.profile_id')
            ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
            ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
            ->select(
                'plans.expiration_plan'
            )
            ->where('prof.id', $prof->id)
            ->whereColumn('pa.id', '=', 'ap.plan_account_id')
            ->get()->first()->expiration_plan;
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
        $perfil = Profile::find($this->selected_id);
        $datos = Plan::join('mov_plans as mp', 'plans.id', 'mp.plan_id')
            ->join('movimientos as m', 'm.id', 'mp.movimiento_id')
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
                'ap.id as accountProfileid'
            )
            ->where('prof.id', $perfil->id)
            ->whereColumn('pa.id', '=', 'ap.plan_account_id')
            ->get()->first();

        $this->importe += $perfil->CuentaPerfil->Cuenta->Plataforma->precioPerfil;
        $this->importe = $this->importe * $this->meses;
        DB::beginTransaction();
        try {
            $planviejo = Plan::find($datos->planid);
            $planviejo->status = 'VENCIDO';
            $planviejo->save();

            $plan = Plan::create([
                'importe' => $this->importe,
                'expiration_plan' => $this->expirationNueva,
                'status' => 'VIGENTE',
                'type_pay' => $this->tipopago,
                'observations' => $this->observations
            ]);

            $pa = PlanAccount::create([
                'plan_id' => $plan->id,
                'account_id' => $perfil->CuentaPerfil->account_id,
            ]);

            $perfil->availability = 'OCUPADO';
            $perfil->save();

            $cuentaPerfil = AccountProfile::find($datos->accountProfileid);
            $cuentaPerfil->status = 'INACTIVO';
            $cuentaPerfil->save();

            $planCuenta = PlanAccount::find($datos->planAccountid);
            $planCuenta->status = 'INACTIVO';
            $planCuenta->save();

            AccountProfile::create([
                'account_id' => $perfil->CuentaPerfil->Cuenta->id,
                'profile_id' => $perfil->id,
                'plan_account_id' => $pa->id,
            ]);

            $perfilesOcupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $perfil->CuentaPerfil->Cuenta->id)
                ->where('p.availability', 'OCUPADO')
                ->where('p.status', 'ACTIVO')->get();

            if (($perfilesOcupados->count() / 2) == $perfil->CuentaPerfil->Cuenta->number_profiles) {

                $cuenta = $perfil->CuentaPerfil->Cuenta;
                $cuenta->availability = 'OCUPADO';
                $cuenta->save();
            }

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
                'cliente_id' => $datos->id
            ]);

            MovPlan::create([
                'movimiento_id' => $mv->id,
                'plan_id' => $plan->id
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
    {
        /* PONER EN INACTIVO AccountProfile */
        $perf = Profile::find($this->selected_id);
        $CuentaPerf = $perf->CuentaPerfil;
        $CuentaPerf->status = 'INACTIVO';
        $CuentaPerf->save();
        /* PONER EN INACTIVO EL PERFIL */
        $perf->availability = 'LIBRE';
        $perf->status = 'INACTIVO';
        $perf->save();
        /* CONTAR LOS PERFILES ACTIVOS */
        $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
            ->join('profiles as p', 'ap.profile_id', 'p.id')
            ->where('accounts.id', $this->selected_id)
            ->where('p.availability', 'LIBRE')
            ->where('ap.status', 'ACTIVO')
            ->where('p.status', 'ACTIVO')->get();
        /* SI LA CUENTA NO TIENE PERFILES REGRESA A SER ENTERA */
        if ($perfilesActivos->count() == 0) {
            $cuenta = Account::find($this->selected_id);
            $cuenta->whole_account = 'ENTERA';
            $cuenta->save();
        }
        $this->resetUI();
        $this->emit('item-accion', 'No se renovó este perfil y ahora esta inactivo');
    }
    public function resetUI()
    {
        $this->importe = 0;
        $this->selected_id = 0;
        $this->nameperfil = '';
        $this->pin = '';
        $this->status = 'Elegir';
        $this->availability = 'Elegir';
        $this->observations = '';
        $this->resetValidation();
    }
}
