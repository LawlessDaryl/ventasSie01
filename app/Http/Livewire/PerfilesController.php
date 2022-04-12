<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\AccountProfile;
use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\ClienteMov;
use App\Models\CuentaInversion;
use App\Models\Movimiento;
use App\Models\Plan;
use App\Models\PlanAccount;
use App\Models\Profile;
use Carbon\Carbon;
use DateTime;
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
        $meses, $expirationNueva, $expirationActual, $tipopago, $importe,
        $mostrartabla2, $perfil, $selected_plan, $nombreCliente, $celular, $cuentasEnteras,
        $nombrePerfil, $pinPerfil, $datos, $perfil1COMBO, $perfil2COMBO, $perfil3COMBO, $PIN1COMBO, $PIN2COMBO, $PIN3COMBO,
        $plataforma1Nombre, $plataforma2Nombre, $plataforma3Nombre, $perfil1ID, $perfil2ID, $perfil3ID;

    private $pagination = 10;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Perfiles';
        $this->status = 'Elegir';
        $this->nameperfil = '';
        $this->pin = '';
        $this->availability = 'Elegir';
        $this->condicional = 'ocupados';
        $this->meses = 0;
        $this->expirationNueva = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->tipopago = 'EFECTIVO';
        $this->importe = 0;
        $this->mostrartabla2 = 0;
        $this->perfil = [];
        $this->selected_id = 0;
        $this->selected_plan = 0;
        $this->nombreCliente = '';
        $this->celular = '';
        $this->cuentasEnteras = [];
        $this->nombrePerfil = '';
        $this->pinPerfil = '';
        $this->observations = '';
        $this->perfil1COMBO = '';
        $this->perfil2COMBO = '';
        $this->perfil3COMBO = '';
        $this->PIN1COMBO = '';
        $this->PIN2COMBO = '';
        $this->PIN3COMBO = '';
        $this->plataforma1Nombre = '';
        $this->plataforma2Nombre = '';
        $this->plataforma3Nombre = '';
        $this->perfil1ID = '';
        $this->perfil2ID = '';
        $this->perfil3ID = '';
    }
    public function render()
    {
        if ($this->condicional == 'libres') {
            if (strlen($this->search) > 0) {
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
                    ->where('p.nombre', 'like', '%' . $this->search . '%')
                    ->where('profiles.availability', 'LIBRE')
                    ->where('profiles.status', 'ACTIVO')

                    ->orWhere('e.content', 'like', '%' . $this->search . '%')
                    ->where('profiles.availability', 'LIBRE')
                    ->where('profiles.status', 'ACTIVO')

                    ->orWhere('profiles.nameprofile', 'like', '%' . $this->search . '%')
                    ->where('profiles.availability', 'LIBRE')
                    ->where('profiles.status', 'ACTIVO')

                    ->orderBy('a.expiration_account', 'desc')
                    ->paginate($this->pagination);
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
                        'plans.done as done',
                        DB::raw('0 as horas')
                    )
                    ->where('plat.nombre', 'like', '%' . $this->search . '%')
                    ->where('plans.type_plan', 'PERFIL')
                    ->where('plans.status', 'VIGENTE')
                    ->where('pa.status', 'ACTIVO')
                    ->where('plans.ready', 'SI')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')

                    ->orWhere('c.nombre', 'like', '%' . $this->search . '%')
                    ->where('plans.type_plan', 'PERFIL')
                    ->where('plans.status', 'VIGENTE')
                    ->where('pa.status', 'ACTIVO')
                    ->where('plans.ready', 'SI')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')

                    ->orWhere('c.celular', 'like', '%' . $this->search . '%')
                    ->where('plans.type_plan', 'PERFIL')
                    ->where('plans.status', 'VIGENTE')
                    ->where('pa.status', 'ACTIVO')
                    ->where('plans.ready', 'SI')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')

                    ->orWhere('e.content', 'like', '%' . $this->search . '%')
                    ->where('plans.type_plan', 'PERFIL')
                    ->where('plans.status', 'VIGENTE')
                    ->where('pa.status', 'ACTIVO')
                    ->where('plans.ready', 'SI')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')

                    ->orWhere('prof.nameprofile', 'like', '%' . $this->search . '%')
                    ->where('plans.type_plan', 'PERFIL')
                    ->where('plans.status', 'VIGENTE')
                    ->where('pa.status', 'ACTIVO')
                    ->where('plans.ready', 'SI')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')

                    ->orderBy('plans.done', 'desc')
                    ->orderBy('plans.expiration_plan', 'asc')
                    ->paginate($this->pagination);
                foreach ($prof as $c) {
                    $date1 = new DateTime($c->expiration_plan);
                    $date2 = new DateTime("now");
                    $diff = $date2->diff($date1);
                    if ($diff->invert != 1) {
                        $c->horas = (($diff->days * 24)) + ($diff->h);
                    } else {
                        $c->horas = '0';
                    }
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
                        'plans.done as done',
                        DB::raw('0 as horas')
                    )
                    ->where('plans.type_plan', 'PERFIL')
                    ->where('plans.status', 'VIGENTE')
                    ->where('pa.status', 'ACTIVO')
                    ->where('ap.status', 'ACTIVO')
                    ->where('plans.ready', 'SI')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')
                    ->orderBy('plans.done', 'desc')
                    ->orderBy('plans.expiration_plan', 'asc')
                    ->paginate($this->pagination);
                foreach ($prof as $c) {
                    $date1 = new DateTime($c->expiration_plan);
                    $date2 = new DateTime("now");
                    $diff = $date2->diff($date1);
                    if ($diff->invert != 1) {
                        $c->horas = (($diff->days * 24)) + ($diff->h);
                    } else {
                        $c->horas = '0';
                    }
                }
            }
        } elseif ($this->condicional == 'vencidos') {    /* VENCIDOS */
            if (strlen($this->search) > 0) {
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
                        'plans.done as done'
                    )
                    ->where('plat.nombre', 'like', '%' . $this->search . '%')
                    ->where('plans.status', 'VENCIDO')
                    ->where('plans.type_plan', 'PERFIL')
                    ->where('plans.ready', 'SI')
                    ->where('ap.status', 'VENCIDO')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')

                    ->orWhere('c.nombre', 'like', '%' . $this->search . '%')
                    ->where('plans.status', 'VENCIDO')
                    ->where('plans.type_plan', 'PERFIL')
                    ->where('plans.ready', 'SI')
                    ->where('ap.status', 'VENCIDO')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')

                    ->orWhere('c.celular', 'like', '%' . $this->search . '%')
                    ->where('plans.status', 'VENCIDO')
                    ->where('plans.type_plan', 'PERFIL')
                    ->where('plans.ready', 'SI')
                    ->where('ap.status', 'VENCIDO')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')

                    ->orWhere('e.content', 'like', '%' . $this->search . '%')
                    ->where('plans.status', 'VENCIDO')
                    ->where('plans.type_plan', 'PERFIL')
                    ->where('plans.ready', 'SI')
                    ->where('ap.status', 'VENCIDO')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')

                    ->orWhere('prof.nameprofile', 'like', '%' . $this->search . '%')
                    ->where('plans.status', 'VENCIDO')
                    ->where('plans.type_plan', 'PERFIL')
                    ->where('plans.ready', 'SI')
                    ->where('ap.status', 'VENCIDO')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')

                    ->orderBy('plans.done', 'desc')
                    ->orderBy('plans.expiration_plan', 'desc')
                    ->paginate($this->pagination);
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
                        'plans.done as done'
                    )
                    ->where('plans.status', 'VENCIDO')
                    ->where('plans.type_plan', 'PERFIL')
                    ->where('plans.ready', 'SI')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')
                    ->where('ap.status', 'VENCIDO')
                    ->orderBy('plans.done', 'desc')
                    ->orderBy('plans.expiration_plan', 'desc')
                    ->paginate($this->pagination);
            }
        } else {
            $prof = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                ->select(
                    'plans.*'
                )
                ->where('plans.type_plan', 'COMBO')
                /* ->whereColumn('plans.id', '=', 'ap.plan_id') */
                ->orderBy('plans.created_at', 'desc')
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


    public function EditCombo(Plan $plan)
    {
        /* CARGAR NOMBRE DE PERFIL, PIN E ID EN LAS VARIABLES */
        foreach ($plan->PlanAccounts as  $value) {
            if ($value->status == 'ACTIVO') {

                foreach ($value->Cuenta->CuentaPerfiles as  $v) {
                    if ($v->status == 'ACTIVO' && $v->COMBO == 'PERFIL1') {
                        $this->plataforma1Nombre = $v->Cuenta->Plataforma->nombre;
                        $this->perfil1COMBO =  $v->Perfil->nameprofile;
                        $this->PIN1COMBO = $v->Perfil->pin;
                        $this->perfil1ID = $v->Perfil->id;
                    }
                }
            }
        }
        foreach ($plan->PlanAccounts as  $value) {
            if ($value->status == 'ACTIVO') {
                foreach ($value->Cuenta->CuentaPerfiles as  $v) {
                    if ($v->status == 'ACTIVO' && $v->COMBO == 'PERFIL2') {
                        $this->plataforma2Nombre = $v->Cuenta->Plataforma->nombre;
                        $this->perfil2COMBO =  $v->Perfil->nameprofile;
                        $this->PIN2COMBO = $v->Perfil->pin;
                        $this->perfil2ID = $v->Perfil->id;
                    }
                }
            }
        }
        foreach ($plan->PlanAccounts as  $value) {
            if ($value->status == 'ACTIVO') {
                foreach ($value->Cuenta->CuentaPerfiles as  $v) {
                    if ($v->status == 'ACTIVO' && $v->COMBO == 'PERFIL3') {
                        $this->plataforma3Nombre = $v->Cuenta->Plataforma->nombre;
                        $this->perfil3COMBO =  $v->Perfil->nameprofile;
                        $this->PIN3COMBO = $v->Perfil->pin;
                        $this->perfil3ID = $v->Perfil->id;
                    }
                }
            }
        }

        $this->emit('modal-show-edit-combo', 'show modal!');
    }

    public function UpdateCombo()
    {
        $rules = [
            'perfil1COMBO' => 'required',
            'PIN1COMBO' => 'required',
            'perfil2COMBO' => 'required',
            'PIN2COMBO' => 'required',
            'perfil3COMBO' => 'required',
            'PIN3COMBO' => 'required',
        ];
        $messages = [
            'perfil1COMBO.required' => 'El nombre del perfil es requerido',
            'PIN1COMBO.required' => 'El pin del perfil es requerido',
            'perfil2COMBO.required' => 'El nombre del perfil es requerido',
            'PIN2COMBO.required' => 'El pin del perfil es requerido',
            'perfil3COMBO.required' => 'El nombre del perfil es requerido',
            'PIN3COMBO.required' => 'El pin del perfil es requerido',
        ];

        $this->validate($rules, $messages);

        $prof1 = Profile::find($this->perfil1ID);

        $prof1->update([
            'nameprofile' => $this->perfil1COMBO,
            'pin' => $this->PIN1COMBO,
        ]);

        $prof2 = Profile::find($this->perfil2ID);

        $prof2->update([
            'nameprofile' => $this->perfil2COMBO,
            'pin' => $this->PIN2COMBO,
        ]);

        $prof3 = Profile::find($this->perfil3ID);

        $prof3->update([
            'nameprofile' => $this->perfil3COMBO,
            'pin' => $this->PIN3COMBO,
        ]);

        $this->resetUI();
        $this->emit('combo-updated', 'Perfiles Actualizados');
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
            'nameprofile' => $this->nameperfil,
            'pin' => $this->pin,
            'status' => $this->status,
            'availability' => $this->availability,
            'observations' => $this->observations
        ]);

        $this->resetUI();
        $this->emit('item-updated', 'Perfil Actualizado');
    }

    public function Destroy(Profile $perf)
    {
        /* PONER EN INACTIVO EL ACCOUNTPROFILE */
        $CuentaPerf = $perf->CuentaPerfil;
        $CuentaPerf->status = 'INACTIVO';
        $CuentaPerf->save();
        /* PONER EN INACTIVO EL PERFIL */
        $perf->status = 'INACTIVO';
        $perf->availability = 'VENCIDO';
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
        $this->selected_plan = $plan->id;
        /* OBTENER FECHA DE EXPIRACION DEL PLAN PARA CALCULAR LA FECHA DE EXPIRACION NUEVA */
        $this->data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
            ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
            ->join('accounts as acc', 'acc.id', 'pa.account_id')
            ->join('account_profiles as ap', 'acc.id', 'ap.account_id')
            ->join('profiles as prof', 'prof.id', 'ap.profile_id')
            ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
            ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
            ->select(
                'prof.nameprofile as nameprofile',
                'prof.pin as pin',
                'plans.observations as observations',
                'prof.nameprofile as nameprofile',
                'c.nombre as nombreCliente',
                'c.celular as celular',
                'plans.expiration_plan as expiration_plan'
            )
            ->where('plans.id', $this->selected_plan)
            ->whereColumn('plans.id', '=', 'ap.plan_id')
            ->orderby('plans.id', 'desc')
            ->get()->first();

        $this->nameperfil = $this->data->nameprofile;
        $this->pin = $this->data->pin;
        $this->nombreCliente = $this->data->nombreCliente;
        $this->celular = $this->data->celular;
        $this->observations = $this->data->observations;
        $this->expirationActual = substr($this->data->expiration_plan, 0, 10);
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
            ->where('plans.id', $this->selected_plan)
            ->whereColumn('plans.id', '=', 'ap.plan_id')
            ->orderby('plans.id', 'desc')
            ->get()->first();

        $perfil = Profile::find($datos->Profileid);
        foreach ($perfil->CuentaPerfil as  $value) {
            if ($value->status == 'ACTIVO') {
                /* CALCULAR EL IMPORTE SEGUN EL PRECIO DEL PERFIL Y LA CANTIDAD DE MESES A RENOVAR */
                $this->importe += $value->Cuenta->Plataforma->precioPerfil;
                $this->importe *= $this->meses;
            }
        }
        DB::beginTransaction();
        try {
            $mv = Movimiento::create([
                'type' => 'TERMINADO',
                'status' => 'ACTIVO',
                'import' => $this->importe,
                'user_id' => Auth()->user()->id,
            ]);
            foreach ($perfil->CuentaPerfil as  $value) {
                if ($value->status == 'ACTIVO') {
                    /* ENCONTRAR INVERSION */
                    $inversioncuenta = CuentaInversion::where('start_date', '<=', $this->expirationActual)
                        ->where('expiration_date', '>=', $this->expirationActual)
                        ->where('account_id', $value->Cuenta->id)
                        ->get()->first();

                    $inversioncuenta->type = 'PERFILES';
                    $inversioncuenta->sale_profiles += 1;
                    $inversioncuenta->imports += $this->importe;
                    $inversioncuenta->ganancia = $inversioncuenta->imports - $inversioncuenta->price;
                    $inversioncuenta->save();
                }
            }
            $plan = Plan::create([
                'importe' => $this->importe,
                'plan_start' => $this->expirationActual,
                'expiration_plan' => $this->expirationNueva,
                'ready' => 'SI',
                'done' => 'NO',
                'type_plan' => 'PERFIL',
                'status' => 'VIGENTE',
                'type_pay' => $this->tipopago,
                'observations' => $this->observations,
                'movimiento_id' => $mv->id
            ]);
            foreach ($perfil->CuentaPerfil as  $value) {
                if ($value->status == 'ACTIVO') {
                    PlanAccount::create([
                        'status' => 'ACTIVO',
                        'plan_id' => $plan->id,
                        'account_id' => $value->Cuenta->id,
                    ]);

                    AccountProfile::create([
                        'account_id' => $value->Cuenta->id,
                        'profile_id' => $perfil->id,
                        'plan_id' => $plan->id,
                        'status' => 'ACTIVO',
                    ]);
                }
            }
            /* PONER EN VENCIDO EL PLAN ANTERIOR */
            $planviejo = Plan::find($datos->planid);
            $planviejo->status = 'VENCIDO';
            $planviejo->save();
            /* PONER EN VENCIDO PLANACCOUNT ANTERIOR */
            $planCuenta = PlanAccount::find($datos->planAccountid);
            $planCuenta->status = 'VENCIDO';
            $planCuenta->save();
            /* PONER EN VENCIDO ACCOUNTPROFILE ANTERIOR*/
            $cuentaPerfil = AccountProfile::find($datos->accountProfileid);
            $cuentaPerfil->status = 'VENCIDO';
            $cuentaPerfil->save();
            /* PONER EN OCUPADO EL PERFIL */
            $perfil->availability = 'OCUPADO';
            $perfil->save();

            if ($this->tipopago == 'EFECTIVO') {

                $cajaFisica = Cartera::where('tipo', 'CajaFisica')
                    ->where('caja_id', $CajaActual->id)->get()->first();
                CarteraMov::create([
                    'type' => 'INGRESO',
                    'comentario' => '',
                    'cartera_id' => $cajaFisica->id,
                    'movimiento_id' => $mv->id
                ]);
                $tigoStreaming = Cartera::where('tipo', 'TigoStreaming')
                    ->where('caja_id', '1')->get()->first();
                CarteraMov::create([
                    'type' => 'INGRESO',
                    'comentario' => '',
                    'cartera_id' => $tigoStreaming->id,
                    'movimiento_id' => $mv->id
                ]);
                $carteraTelefono = Cartera::where('tipo', 'Telefono')
                    ->where('caja_id', $CajaActual->id)->get()->first();
                CarteraMov::create([
                    'type' => 'EGRESO',
                    'comentario' => '',
                    'cartera_id' => $carteraTelefono->id,
                    'movimiento_id' => $mv->id
                ]);
            } elseif ($this->tipopago == 'Banco') {
                $banco = Cartera::where('tipo', 'Banco')
                    ->where('caja_id', '1')->get()->first();
                CarteraMov::create([
                    'type' => 'INGRESO',
                    'comentario' => '',
                    'cartera_id' => $banco->id,
                    'movimiento_id' => $mv->id
                ]);
            } else {
                $tigoStreaming = Cartera::where('tipo', 'TigoStreaming')
                    ->where('caja_id', '1')->get()->first();
                CarteraMov::create([
                    'type' => 'INGRESO',
                    'comentario' => '',
                    'cartera_id' => $tigoStreaming->id,
                    'movimiento_id' => $mv->id
                ]);
            }

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
            $this->emit('item-accion', 'No se pudo renovar el plan porque la cuenta de este perfil no ha sido renovada con su proveedor');
        }
    }

    public function Vencer()
    {   /* OBTENER DATOS DEL PLAN */
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
            ->where('plans.id', $this->selected_plan)
            ->where('prof.status', 'ACTIVO')
            ->where('pa.status', 'ACTIVO')
            ->where('ap.status', 'ACTIVO')
            ->whereColumn('plans.id', '=', 'ap.plan_id')
            ->orderby('plans.id', 'desc')
            ->get()->first();

        $perfil = Profile::create([
            'nameprofile' => 'emanuel' . rand(100, 999),
            'pin' => rand(1000, 9999),
        ]);
        AccountProfile::create([
            'status' => 'SinAsignar',
            'account_id' => $datos->cuentaid,
            'profile_id' => $perfil->id,
        ]);

        $planAntiguo = Plan::find($datos->planid);
        $planAntiguo->status = 'VENCIDO';
        $planAntiguo->done = 'NO';
        $planAntiguo->observations = $this->observations;
        $planAntiguo->save();

        $plaAcount = PlanAccount::find($datos->plAccountid);
        $plaAcount->status = 'VENCIDO';
        $plaAcount->save();

        /* PONER EN INACTIVO AccountProfile */
        $CuentaPerf = AccountProfile::find($datos->accproid);
        $CuentaPerf->status = 'VENCIDO';
        $CuentaPerf->save();

        /* PONER EN INACTIVO EL PERFIL */
        $perf = Profile::find($datos->Profileid);
        $perf->availability = 'VENCIDO';
        $perf->status = 'INACTIVO';
        $perf->save();

        $Cuenta = Account::find($datos->cuentaid);
        /* CONTAR LOS PERFILES OCUPADOS */
        $perfOcupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
            ->join('profiles as p', 'ap.profile_id', 'p.id')
            ->where('accounts.id', $Cuenta->id)
            ->where('p.availability', 'OCUPADO')->get();
        /* SI LA CUENTA NO TIENE PERFILES OCUPADOS REGRESA A SER ENTERA */
        if ($perfOcupados->count() == 0) {
            $Cuenta->whole_account = 'ENTERA';
            $Cuenta->save();
        }
        $this->resetUI();
        $this->emit('item-accion', 'No se renovó este perfil y ahora esta inactivo');
    }

    public function CambiarCuenta()
    {
        $this->mostrartabla2 = 1;
        /* OBTENER LA PLATAFORMA DEL PERFIL */
        $datos = Plan::join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
            ->join('accounts as acc', 'acc.id', 'pa.account_id')
            ->join('platforms as p', 'p.id', 'acc.platform_id')
            ->select(
                'p.id as platfid',
                'acc.id as cuentaid'
            )
            ->where('plans.id', $this->selected_plan)
            ->where('pa.status', 'ACTIVO')
            ->orderby('plans.id', 'desc')
            ->get()->first();
        /* MOSTRAR CUENTAS CON ESPACIOS DE PERFILES */
        $date_now = date('Y-m-d', time());
        $this->cuentasEnteras = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
            ->join('emails as e', 'accounts.email_id', 'e.id')
            ->select(
                'accounts.id as id',
                'accounts.account_name as account_name',
                'accounts.expiration_account as expiration_account',
                'accounts.number_profiles',
                'p.nombre as nombre',
                'e.content as content',
                'e.pass as pass',
                DB::raw('0 as perfActivos'),
                DB::raw('0 as cantiadadQueSePuedeCrear'),
            )
            ->where('accounts.status', 'ACTIVO')
            ->where('accounts.availability', 'LIBRE')
            ->where('accounts.expiration_account', '>', $date_now)
            ->where('accounts.id', '!=', $datos->cuentaid)
            ->where('p.id', $datos->platfid)
            ->get();

        foreach ($this->cuentasEnteras as $c) {
            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $c->id)
                ->where('p.availability', 'OCUPADO')->get();

            $cantidadActivos = $perfilesActivos->count();
            $c->perfActivos = $cantidadActivos;

            $c->cantiadadQueSePuedeCrear = $c->number_profiles - $c->perfActivos;
        }
    }

    public function SeleccionarCuenta(Account $cuenta)
    {
        /* DATOS DEL ANTERIOR PLAN */
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
            ->where('plans.id', $this->selected_plan)
            ->where('pa.status', 'ACTIVO')
            ->where('ap.status', 'ACTIVO')
            ->where('plans.id', $this->selected_plan)
            ->whereColumn('plans.id', '=', 'ap.plan_id')
            ->orderby('plans.id', 'desc')
            ->get()->first();

        DB::beginTransaction();
        try {
            /* PONER EN NO LISTO LA ACCION */
            $plan = Plan::find($datos->planid);
            $plan->done = 'NO';
            $plan->observations = $this->observations;
            $plan->save();

            /* OBTENER UN PERFIL DE LA CUENTA NUEVA PARA PONER LOS DATOS DEL PERFIL ANTERIOR */
            $perfilCambiar = Account::join('account_profiles as ap', 'accounts.id', 'ap.account_id')
                ->join('profiles as p', 'p.id', 'ap.profile_id')
                ->select('p.*')
                ->where('accounts.id', $cuenta->id)
                ->where('p.availability', 'LIBRE')->get()->first();

            /* PONER LOS DATOS DEL ANTERIOR PERFIL AL NUEVO */
            $profile = Profile::find($perfilCambiar->id);
            $profile->nameprofile = $this->nameperfil;
            $profile->pin = $this->pin;
            $profile->availability = 'OCUPADO';
            $profile->save();

            /* LA CUENTA PASA A DIVIDIDA SI NO LO ESTABA */
            $cuenta->whole_account = 'DIVIDIDA';
            $cuenta->save();

            /* PONER EN CAMBIADO EL PLAN-ACCOUNT */
            $planAccountVIEJO = PlanAccount::find($datos->planAccountid);
            $planAccountVIEJO->update([
                'status' => 'CAMBIADO',
            ]);

            /* CREAR NUEVO PLAN-ACCOUNT */
            PlanAccount::create([
                'plan_id' => $datos->planid,
                'account_id' => $cuenta->id,
            ]);

            /* crear un nuevo perfil libre en la cuenta antigua que reemplace al que se cambió */
            $perfil = Profile::create([
                'nameprofile' => 'emanuel' . rand(100, 999),
                'pin' => rand(1000, 9999),
            ]);
            AccountProfile::create([
                'status' => 'SinAsignar',
                'account_id' => $datos->cuentaid,
                'profile_id' => $perfil->id,
            ]);

            /* PONER EN VENCIDO EL PERFIL */
            $perfilViejo = Profile::find($datos->Profileid);
            $perfilViejo->status = 'INACTIVO';
            $perfilViejo->availability = 'VENCIDO';
            $perfilViejo->save();

            /* PONER EN CAMBIADO EL ACCOUNT-PROFILE */
            $cuentaPerfilViejo = AccountProfile::find($datos->accountProfileid);
            $cuentaPerfilViejo->update([
                'status' => 'CAMBIADO',
            ]);

            $accountProfiles = AccountProfile::select('account_profiles.*')->where('account_id', $cuenta->id)
                ->where('profile_id', $profile->id)->get()->first();
            $ACCOUNTPROF = AccountProfile::find($accountProfiles->id);
            $ACCOUNTPROF->update([
                'status' => 'ACTIVO',
                'plan_id' => $datos->planid,
            ]);

            /* CONTAR LOS PERFILES ACTIVOS OCUPADOS */
            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $datos->cuentaid)
                ->where('p.availability', 'OCUPADO')->get();

            /* SI LA CUENTA NO TIENE PERFILES ACTIVOS REGRESA A SER ENTERA */
            if ($perfilesActivos->count() == 0) {
                $cuenta = Account::find($datos->cuentaid);
                $cuenta->whole_account = 'ENTERA';
                $cuenta->save();
            }

            $this->resetUI();
            DB::commit();
            $this->emit('item-accion', 'Se creó el perfil en la cuenta seleccionada');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }


    protected $listeners = ['deleteRow' => 'Destroy', 'Vencer' => 'Vencer', 'Renovar' => 'Renovar', 'Realizado' => 'Realizado'];

    public function Realizado(Plan $plan)
    {
        $plan->done = 'SI';
        $plan->save();
        $this->resetUI();
        $this->emit('item-accion', 'Se cambio a realizado');
    }
    public function resetUI()
    {
        $this->status = 'Elegir';
        $this->nameperfil = '';
        $this->pin = '';
        $this->availability = 'Elegir';
        $this->meses = 0;
        $this->expirationNueva = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->tipopago = 'EFECTIVO';
        $this->importe = 0;
        $this->mostrartabla2 = 0;
        $this->perfil = [];
        $this->selected_id = 0;
        $this->selected_plan = 0;
        $this->nombreCliente = '';
        $this->celular = '';
        $this->cuentasEnteras = [];
        $this->nombrePerfil = '';
        $this->pinPerfil = '';
        $this->resetValidation();
    }
}
