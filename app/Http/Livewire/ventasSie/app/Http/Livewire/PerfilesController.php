<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\AccountProfile;
use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\Cliente;
use App\Models\ClienteMov;
use App\Models\CuentaInversion;
use App\Models\Movimiento;
use App\Models\Plan;
use App\Models\PlanAccount;
use App\Models\Platform;
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

    public $nameperfil, $pin, $status, $availability, $observations, $search, $selected_id,
        $pageTitle, $componentName, $condicional = 'ocupados', $meses, $expirationNueva,
        $expirationPlanActual, $tipopago, $importe, $mostrartabla2, $perfil, $selected_plan,
        $nombreCliente, $celular, $cuentasEnteras, $nombrePerfil, $pinPerfil, $datos, $perfil1COMBO,
        $perfil2COMBO, $perfil3COMBO, $PIN1COMBO, $PIN2COMBO, $PIN3COMBO, $plataforma1Nombre,
        $plataforma2Nombre, $plataforma3Nombre, $perfil1ID, $perfil2ID, $perfil3ID;

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
        $this->meses = 1;
        $this->expirationNueva = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->tipopago = 'EFECTIVO';
        $this->importe = '';
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
        $this->selected_perfil1 = '';
        $this->selected_perfil2 = '';
        $this->selected_perfil3 = '';
        $this->mostrarTablaCambiar1 = 'NO';
        $this->mostrarTablaCambiar2 = 'NO';
        $this->mostrarTablaCambiar3 = 'NO';
        $this->selected_plataforma1 = '';
        $this->selected_plataforma2 = '';
        $this->selected_plataforma3 = '';
        $this->selected_cuenta1 = '';
        $this->selected_cuenta2 = '';
        $this->selected_cuenta3 = '';
        $this->planAccount1 = '';
        $this->planAccount2 = '';
        $this->planAccount3 = '';
        $this->selected_accountProf1 = '';
        $this->selected_accountProf2 = '';
        $this->selected_accountProf3 = '';
        $this->clienteID = '';
        $this->expiracionCuenta1 = '';
        $this->expiracionCuenta2 = '';
        $this->expiracionCuenta3 = '';
        $this->PlataformaFiltro = 'TODAS';
        $this->diasdePlan = 30;
        $this->inicioPlanActual = null;
        $this->plataformaPlan = '';
        $this->mesesPlan = '';
        $this->importePlan = '';
        $this->inicioNueva = '';
        $this->start_account = null;
        $this->expiration_account = null;
        $this->comprobante = null;
        $this->selected_perfil = 0;
        $this->selected_accountProf = 0;
        $this->selected_account = 0;
        $this->selected_planAccount = 0;
        $this->selected_platf = 0;
        $this->selected_cliente = 0;

        $this->selected_accountProf1 = 0;
        $this->selected_accountProf2 = 0;
        $this->selected_accountProf3 = 0;

        $this->selected_planAccount1 = 0;
        $this->selected_planAccount2 = 0;
        $this->selected_planAccount3 = 0;
    }

    public function render()
    {
        if ($this->condicional == 'ocupados') {
            if ($this->PlataformaFiltro != 'TODAS') {
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
                            'prof.id as IDperfil',
                            'prof.nameprofile as namep',
                            'prof.pin as pin',
                            'ap.id as IDaccountProfile',
                            'ap.status as estadoCuentaPerfil',
                            'acc.id as IDaccount',
                            'acc.expiration_account as expiration',
                            'acc.password_account as passAccount',
                            'pa.id as IDplanAccount',
                            'plans.id as planid',
                            'plans.expiration_plan as expiration_plan',
                            'plans.plan_start as plan_start',
                            'plans.done as done',
                            'plat.id as IDplatf',
                            'plat.nombre',
                            'plat.image',
                            'e.content',
                            'e.pass',
                            'c.id as clienteID',
                            'c.nombre as clienteNombre',
                            'c.celular as clienteCelular',
                            DB::raw('0 as horasPlan'),
                            DB::raw('0 as horasCuenta')
                        )
                        ->where('c.nombre', 'like', '%' . $this->search . '%')
                        ->where('plans.type_plan', 'PERFIL')
                        ->where('plans.status', 'VIGENTE')
                        ->where('pa.status', 'ACTIVO')
                        ->where('ap.status', 'ACTIVO')
                        ->where('plans.ready', 'SI')
                        ->where('plat.id', $this->PlataformaFiltro)
                        ->whereColumn('plans.id', '=', 'ap.plan_id')

                        ->orWhere('c.celular', 'like', '%' . $this->search . '%')
                        ->where('plans.type_plan', 'PERFIL')
                        ->where('plans.status', 'VIGENTE')
                        ->where('pa.status', 'ACTIVO')
                        ->where('ap.status', 'ACTIVO')
                        ->where('plans.ready', 'SI')
                        ->where('plat.id', $this->PlataformaFiltro)
                        ->whereColumn('plans.id', '=', 'ap.plan_id')

                        ->orWhere('e.content', 'like', '%' . $this->search . '%')
                        ->where('plans.type_plan', 'PERFIL')
                        ->where('plans.status', 'VIGENTE')
                        ->where('pa.status', 'ACTIVO')
                        ->where('ap.status', 'ACTIVO')
                        ->where('plans.ready', 'SI')
                        ->where('plat.id', $this->PlataformaFiltro)
                        ->whereColumn('plans.id', '=', 'ap.plan_id')

                        ->orWhere('prof.nameprofile', 'like', '%' . $this->search . '%')
                        ->where('plans.type_plan', 'PERFIL')
                        ->where('plans.status', 'VIGENTE')
                        ->where('pa.status', 'ACTIVO')
                        ->where('ap.status', 'ACTIVO')
                        ->where('plans.ready', 'SI')
                        ->where('plat.id', $this->PlataformaFiltro)
                        ->whereColumn('plans.id', '=', 'ap.plan_id')

                        ->orderBy('plans.done', 'desc')
                        ->orderBy('plans.expiration_plan', 'asc')
                        ->paginate($this->pagination);
                    foreach ($prof as $c) {
                        $date1 = new DateTime($c->expiration_plan);
                        $date2 = new DateTime("now");
                        $diff = $date2->diff($date1);
                        if ($diff->invert != 1) {
                            $c->horasPlan = (($diff->days * 24)) + ($diff->h);
                        } else {
                            $c->horasPlan = '-1';
                        }
                        $date1 = new DateTime($c->expiration);
                        $diff = $date2->diff($date1);
                        if ($diff->invert != 1) {
                            $c->horasCuenta = (($diff->days * 24)) + ($diff->h);
                        } else {
                            $c->horasCuenta = '-1';
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
                            'prof.id as IDperfil',
                            'prof.nameprofile as namep',
                            'prof.pin as pin',
                            'ap.id as IDaccountProfile',
                            'ap.status as estadoCuentaPerfil',
                            'acc.id as IDaccount',
                            'acc.expiration_account as expiration',
                            'acc.password_account as passAccount',
                            'pa.id as IDplanAccount',
                            'plans.id as planid',
                            'plans.expiration_plan as expiration_plan',
                            'plans.plan_start as plan_start',
                            'plans.done as done',
                            'plat.id as IDplatf',
                            'plat.nombre',
                            'plat.image',
                            'e.content',
                            'e.pass',
                            'c.id as clienteID',
                            'c.nombre as clienteNombre',
                            'c.celular as clienteCelular',
                            DB::raw('0 as horasPlan'),
                            DB::raw('0 as horasCuenta')
                        )
                        ->where('plans.type_plan', 'PERFIL')
                        ->where('plans.status', 'VIGENTE')
                        ->where('pa.status', 'ACTIVO')
                        ->where('ap.status', 'ACTIVO')
                        ->where('plans.ready', 'SI')
                        ->where('plat.id', $this->PlataformaFiltro)
                        ->whereColumn('plans.id', '=', 'ap.plan_id')
                        ->orderBy('plans.done', 'desc')
                        ->orderBy('plans.expiration_plan', 'asc')
                        ->paginate($this->pagination);
                    foreach ($prof as $c) {
                        $date1 = new DateTime($c->expiration_plan);
                        $date2 = new DateTime("now");
                        $diff = $date2->diff($date1);
                        if ($diff->invert != 1) {
                            $c->horasPlan = (($diff->days * 24)) + ($diff->h);
                        } else {
                            $c->horasPlan = '-1';
                        }
                        $date1 = new DateTime($c->expiration);
                        $diff = $date2->diff($date1);
                        if ($diff->invert != 1) {
                            $c->horasCuenta = (($diff->days * 24)) + ($diff->h);
                        } else {
                            $c->horasCuenta = '-1';
                        }
                    }
                }
            } else {
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
                            'prof.id as IDperfil',
                            'prof.nameprofile as namep',
                            'prof.pin as pin',
                            'ap.id as IDaccountProfile',
                            'ap.status as estadoCuentaPerfil',
                            'acc.id as IDaccount',
                            'acc.expiration_account as expiration',
                            'acc.password_account as passAccount',
                            'pa.id as IDplanAccount',
                            'plans.id as planid',
                            'plans.expiration_plan as expiration_plan',
                            'plans.plan_start as plan_start',
                            'plans.done as done',
                            'plat.id as IDplatf',
                            'plat.nombre',
                            'plat.image',
                            'e.content',
                            'e.pass',
                            'c.id as clienteID',
                            'c.nombre as clienteNombre',
                            'c.celular as clienteCelular',
                            DB::raw('0 as horasPlan'),
                            DB::raw('0 as horasCuenta')
                        )
                        ->where('c.nombre', 'like', '%' . $this->search . '%')
                        ->where('plans.type_plan', 'PERFIL')
                        ->where('plans.status', 'VIGENTE')
                        ->where('pa.status', 'ACTIVO')
                        ->where('ap.status', 'ACTIVO')
                        ->where('plans.ready', 'SI')
                        ->whereColumn('plans.id', '=', 'ap.plan_id')

                        ->orWhere('c.celular', 'like', '%' . $this->search . '%')
                        ->where('plans.type_plan', 'PERFIL')
                        ->where('plans.status', 'VIGENTE')
                        ->where('pa.status', 'ACTIVO')
                        ->where('ap.status', 'ACTIVO')
                        ->where('plans.ready', 'SI')
                        ->whereColumn('plans.id', '=', 'ap.plan_id')

                        ->orWhere('e.content', 'like', '%' . $this->search . '%')
                        ->where('plans.type_plan', 'PERFIL')
                        ->where('plans.status', 'VIGENTE')
                        ->where('pa.status', 'ACTIVO')
                        ->where('ap.status', 'ACTIVO')
                        ->where('plans.ready', 'SI')
                        ->whereColumn('plans.id', '=', 'ap.plan_id')

                        ->orWhere('prof.nameprofile', 'like', '%' . $this->search . '%')
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
                            $c->horasPlan = (($diff->days * 24)) + ($diff->h);
                        } else {
                            $c->horasPlan = '-1';
                        }
                        $date1 = new DateTime($c->expiration);
                        $diff = $date2->diff($date1);
                        if ($diff->invert != 1) {
                            $c->horasCuenta = (($diff->days * 24)) + ($diff->h);
                        } else {
                            $c->horasCuenta = '-1';
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
                            'prof.id as IDperfil',
                            'prof.nameprofile as namep',
                            'prof.pin as pin',
                            'ap.id as IDaccountProfile',
                            'ap.status as estadoCuentaPerfil',
                            'acc.id as IDaccount',
                            'acc.expiration_account as expiration',
                            'acc.password_account as passAccount',
                            'pa.id as IDplanAccount',
                            'plans.id as planid',
                            'plans.expiration_plan as expiration_plan',
                            'plans.plan_start as plan_start',
                            'plans.done as done',
                            'plat.id as IDplatf',
                            'plat.nombre',
                            'plat.image',
                            'e.content',
                            'e.pass',
                            'c.id as clienteID',
                            'c.nombre as clienteNombre',
                            'c.celular as clienteCelular',
                            DB::raw('0 as horasPlan'),
                            DB::raw('0 as horasCuenta')
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
                            $c->horasPlan = (($diff->days * 24)) + ($diff->h);
                        } else {
                            $c->horasPlan = '-1';
                        }
                        $date1 = new DateTime($c->expiration);
                        $diff = $date2->diff($date1);
                        if ($diff->invert != 1) {
                            $c->horasCuenta = (($diff->days * 24)) + ($diff->h);
                        } else {
                            $c->horasCuenta = '-1';
                        }
                    }
                }
            }
        } elseif ($this->condicional == 'vencidos') {    /* VENCIDOS */
            if ($this->PlataformaFiltro != 'TODAS') {
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
                            'prof.id as IDperfil',
                            'prof.nameprofile as namep',
                            'prof.pin as pin',
                            'ap.id as IDaccountProfile',
                            'ap.status as estadoCuentaPerfil',
                            'acc.id as IDaccount',
                            'acc.expiration_account as expiration',
                            'acc.password_account as passAccount',
                            'pa.id as IDplanAccount',
                            'plans.id as planid',
                            'plans.expiration_plan as expiration_plan',
                            'plans.plan_start as plan_start',
                            'plans.done as done',
                            'plat.id as IDplatf',
                            'plat.nombre',
                            'plat.image',
                            'e.content',
                            'e.pass',
                            'c.id as clienteID',
                            'c.nombre as clienteNombre',
                            'c.celular as clienteCelular',
                        )
                        ->where('c.nombre', 'like', '%' . $this->search . '%')
                        ->where('plans.status', 'VENCIDO')
                        ->where('plans.type_plan', 'PERFIL')
                        ->where('plans.ready', 'SI')
                        ->where('plat.id', $this->PlataformaFiltro)
                        ->whereColumn('plans.id', '=', 'ap.plan_id')
                        ->where('ap.status', 'VENCIDO')

                        ->orWhere('c.celular', 'like', '%' . $this->search . '%')
                        ->where('plans.status', 'VENCIDO')
                        ->where('plans.type_plan', 'PERFIL')
                        ->where('plans.ready', 'SI')
                        ->where('plat.id', $this->PlataformaFiltro)
                        ->whereColumn('plans.id', '=', 'ap.plan_id')
                        ->where('ap.status', 'VENCIDO')

                        ->orWhere('e.content', 'like', '%' . $this->search . '%')
                        ->where('plans.status', 'VENCIDO')
                        ->where('plans.type_plan', 'PERFIL')
                        ->where('plans.ready', 'SI')
                        ->where('plat.id', $this->PlataformaFiltro)
                        ->whereColumn('plans.id', '=', 'ap.plan_id')
                        ->where('ap.status', 'VENCIDO')

                        ->orWhere('prof.nameprofile', 'like', '%' . $this->search . '%')
                        ->where('plans.status', 'VENCIDO')
                        ->where('plans.type_plan', 'PERFIL')
                        ->where('plans.ready', 'SI')
                        ->where('plat.id', $this->PlataformaFiltro)
                        ->whereColumn('plans.id', '=', 'ap.plan_id')
                        ->where('ap.status', 'VENCIDO')

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
                            'prof.id as IDperfil',
                            'prof.nameprofile as namep',
                            'prof.pin as pin',
                            'ap.id as IDaccountProfile',
                            'ap.status as estadoCuentaPerfil',
                            'acc.id as IDaccount',
                            'acc.expiration_account as expiration',
                            'acc.password_account as passAccount',
                            'pa.id as IDplanAccount',
                            'plans.id as planid',
                            'plans.expiration_plan as expiration_plan',
                            'plans.plan_start as plan_start',
                            'plans.done as done',
                            'plat.id as IDplatf',
                            'plat.nombre',
                            'plat.image',
                            'e.content',
                            'e.pass',
                            'c.id as clienteID',
                            'c.nombre as clienteNombre',
                            'c.celular as clienteCelular',
                        )
                        ->where('plans.status', 'VENCIDO')
                        ->where('plans.type_plan', 'PERFIL')
                        ->where('plans.ready', 'SI')
                        ->where('plat.id', $this->PlataformaFiltro)
                        ->whereColumn('plans.id', '=', 'ap.plan_id')
                        ->where('ap.status', 'VENCIDO')
                        ->orderBy('plans.done', 'desc')
                        ->orderBy('plans.expiration_plan', 'desc')
                        ->paginate($this->pagination);
                }
            } else {
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
                            'prof.id as IDperfil',
                            'prof.nameprofile as namep',
                            'prof.pin as pin',
                            'ap.id as IDaccountProfile',
                            'ap.status as estadoCuentaPerfil',
                            'acc.id as IDaccount',
                            'acc.expiration_account as expiration',
                            'acc.password_account as passAccount',
                            'pa.id as IDplanAccount',
                            'plans.id as planid',
                            'plans.expiration_plan as expiration_plan',
                            'plans.plan_start as plan_start',
                            'plans.done as done',
                            'plat.id as IDplatf',
                            'plat.nombre',
                            'plat.image',
                            'e.content',
                            'e.pass',
                            'c.id as clienteID',
                            'c.nombre as clienteNombre',
                            'c.celular as clienteCelular',
                        )
                        ->where('c.nombre', 'like', '%' . $this->search . '%')
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
                            'prof.id as IDperfil',
                            'prof.nameprofile as namep',
                            'prof.pin as pin',
                            'ap.id as IDaccountProfile',
                            'ap.status as estadoCuentaPerfil',
                            'acc.id as IDaccount',
                            'acc.expiration_account as expiration',
                            'acc.password_account as passAccount',
                            'pa.id as IDplanAccount',
                            'plans.id as planid',
                            'plans.expiration_plan as expiration_plan',
                            'plans.plan_start as plan_start',
                            'plans.done as done',
                            'plat.id as IDplatf',
                            'plat.nombre',
                            'plat.image',
                            'e.content',
                            'e.pass',
                            'c.id as clienteID',
                            'c.nombre as clienteNombre',
                            'c.celular as clienteCelular',
                        )
                        ->where('plans.status', 'VENCIDO')
                        ->where('plans.type_plan', 'PERFIL')
                        ->where('plans.ready', 'SI')
                        ->where('ap.status', 'VENCIDO')
                        ->whereColumn('plans.id', '=', 'ap.plan_id')
                        ->orderBy('plans.done', 'desc')
                        ->orderBy('plans.expiration_plan', 'desc')
                        ->paginate($this->pagination);
                }
            }
        } elseif ($this->condicional == 'combos') {
            if (strlen($this->search) > 0) {
                $prof = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                    ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                    ->join('accounts as acc', 'acc.id', 'pa.account_id')
                    ->join('emails as e', 'e.id', 'acc.email_id')
                    ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                    ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                    ->select(
                        'plans.*',
                        DB::raw('0 as horasPlan'),
                        DB::raw('0 as horasCuenta')
                    )
                    ->where('c.celular', 'like', '%' . $this->search . '%')
                    ->where('plans.status', 'VIGENTE')
                    ->where('plans.type_plan', 'COMBO')
                    ->where('plans.ready', 'SI')

                    ->orWhere('c.nombre', 'like', '%' . $this->search . '%')
                    ->where('plans.status', 'VIGENTE')
                    ->where('plans.type_plan', 'COMBO')
                    ->where('plans.ready', 'SI')

                    ->orWhere('acc.account_name', 'like', '%' . $this->search . '%')
                    ->where('plans.status', 'VIGENTE')
                    ->where('plans.type_plan', 'COMBO')
                    ->where('plans.ready', 'SI')

                    ->orderBy('plans.done', 'desc')
                    ->orderBy('plans.expiration_plan', 'desc')
                    ->distinct()
                    ->paginate($this->pagination);
                foreach ($prof as $c) {
                    $date1 = new DateTime($c->expiration_plan);
                    $date2 = new DateTime("now");
                    $diff = $date2->diff($date1);
                    if ($diff->invert != 1) {
                        $c->horasPlan = (($diff->days * 24)) + ($diff->h);
                    } else {
                        $c->horasPlan = '-1';
                    }
                }
            } else {
                $prof = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                    ->select(
                        'plans.*',
                        DB::raw('0 as horasPlan'),
                        DB::raw('0 as horasCuenta')
                    )
                    ->where('plans.status', 'VIGENTE')
                    ->where('plans.type_plan', 'COMBO')
                    ->where('plans.ready', 'SI')
                    ->orderBy('plans.done', 'desc')
                    ->orderBy('plans.expiration_plan', 'desc')
                    ->paginate($this->pagination);
                foreach ($prof as $c) {
                    $date1 = new DateTime($c->expiration_plan);
                    $date2 = new DateTime("now");
                    $diff = $date2->diff($date1);
                    if ($diff->invert != 1) {
                        $c->horasPlan = (($diff->days * 24)) + ($diff->h);
                    } else {
                        $c->horasPlan = '-1';
                    }
                }
            }
        } elseif ($this->condicional == 'combosVencidos') {
            if (strlen($this->search) > 0) {
                $prof = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                    ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                    ->join('accounts as acc', 'acc.id', 'pa.account_id')
                    ->join('emails as e', 'e.id', 'acc.email_id')
                    ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                    ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                    ->select(
                        'plans.*',
                        DB::raw('0 as horasPlan'),
                        DB::raw('0 as horasCuenta')
                    )
                    ->where('c.celular', 'like', '%' . $this->search . '%')
                    ->where('plans.status', 'VENCIDO')
                    ->where('plans.type_plan', 'COMBO')
                    ->where('plans.ready', 'SI')

                    ->orWhere('c.nombre', 'like', '%' . $this->search . '%')
                    ->where('plans.status', 'VENCIDO')
                    ->where('plans.type_plan', 'COMBO')
                    ->where('plans.ready', 'SI')

                    ->orWhere('acc.account_name', 'like', '%' . $this->search . '%')
                    ->where('plans.status', 'VENCIDO')
                    ->where('plans.type_plan', 'COMBO')
                    ->where('plans.ready', 'SI')

                    ->orderBy('plans.done', 'desc')
                    ->orderBy('plans.expiration_plan', 'desc')
                    ->distinct()
                    ->paginate($this->pagination);
                foreach ($prof as $c) {
                    $date1 = new DateTime($c->expiration_plan);
                    $date2 = new DateTime("now");
                    $diff = $date2->diff($date1);
                    if ($diff->invert != 1) {
                        $c->horasPlan = (($diff->days * 24)) + ($diff->h);
                    } else {
                        $c->horasPlan = '-1';
                    }
                }
            } else {
                $prof = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                    ->select(
                        'plans.*',
                        DB::raw('0 as horasPlan'),
                        DB::raw('0 as horasCuenta')
                    )
                    ->where('plans.status', 'VENCIDO')
                    ->where('plans.type_plan', 'COMBO')
                    ->where('plans.ready', 'SI')
                    ->orderBy('plans.done', 'desc')
                    ->orderBy('plans.expiration_plan', 'desc')
                    ->paginate($this->pagination);
                foreach ($prof as $c) {
                    $date1 = new DateTime($c->expiration_plan);
                    $date2 = new DateTime("now");
                    $diff = $date2->diff($date1);
                    if ($diff->invert != 1) {
                        $c->horasPlan = (($diff->days * 24)) + ($diff->h);
                    } else {
                        $c->horasPlan = '-1';
                    }
                }
            }
        }

        /* CALCULAR LA FECHA DE EXPIRACION NUEVA SEGUN LA CANTIDAD DE MESES A RENOVAR */
        if ($this->diasdePlan > 0) {
            if ($this->meses > 0) {
                $dias = $this->meses * $this->diasdePlan;
                $this->expirationNueva = strtotime('+' . $dias . ' day', strtotime($this->inicioNueva));
                $this->expirationNueva = date('Y-m-d', $this->expirationNueva);
            } else {
                $this->expirationNueva = $this->inicioNueva;
            }
        }

        return view('livewire.perfiles.component', [
            'profiles' => $prof,
            'plataformas' => Platform::where('estado', 'ACTIVO')->orderBy('nombre', 'asc')->get(),
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function EditCombo(Plan $plan, Cliente $cliente)
    {
        $this->resetUI();
        $this->selected_id = $plan->id;
        $this->observations = $plan->observations;
        $this->start_account = $plan->plan_start;
        $this->expiration_account = $plan->expiration_plan;
        $this->comprobante = $plan->comprobante;

        $this->clienteID = $cliente->id;
        $this->nombreCliente = $cliente->nombre;
        $this->celular = $cliente->celular;
        if ($this->condicional == 'combos') {
            /* CARGAR NOMBRE DE PERFIL, PIN E ID EN LAS VARIABLES */
            foreach ($plan->PlanAccounts as  $value) {
                if ($value->status == 'ACTIVO' && $value->COMBO == 'PERFIL1') {
                    foreach ($value->Cuenta->CuentaPerfiles as  $v) {
                        if ($v->status == 'ACTIVO' && $v->COMBO == 'PERFIL1' && $v->plan_id == $this->selected_id) {
                            $this->plataforma1Nombre = $v->Cuenta->Plataforma->nombre;
                            $this->perfil1COMBO =  $v->Perfil->nameprofile;
                            $this->PIN1COMBO = $v->Perfil->pin;
                            $this->selected_perfil1 = $v->Perfil->id;
                        }
                    }
                }
            }
            foreach ($plan->PlanAccounts as  $value) {
                if ($value->status == 'ACTIVO' && $value->COMBO == 'PERFIL2') {
                    foreach ($value->Cuenta->CuentaPerfiles as  $v) {
                        if ($v->status == 'ACTIVO' && $v->COMBO == 'PERFIL2' && $v->plan_id == $this->selected_id) {
                            $this->plataforma2Nombre = $v->Cuenta->Plataforma->nombre;
                            $this->perfil2COMBO =  $v->Perfil->nameprofile;
                            $this->PIN2COMBO = $v->Perfil->pin;
                            $this->selected_perfil2 = $v->Perfil->id;
                        }
                    }
                }
            }
            foreach ($plan->PlanAccounts as  $value) {
                if ($value->status == 'ACTIVO' && $value->COMBO == 'PERFIL3') {
                    foreach ($value->Cuenta->CuentaPerfiles as  $v) {
                        if ($v->status == 'ACTIVO' && $v->COMBO == 'PERFIL3' && $v->plan_id == $this->selected_id) {
                            $this->plataforma3Nombre = $v->Cuenta->Plataforma->nombre;
                            $this->perfil3COMBO =  $v->Perfil->nameprofile;
                            $this->PIN3COMBO = $v->Perfil->pin;
                            $this->selected_perfil3 = $v->Perfil->id;
                        }
                    }
                }
            }
        } else {
            /* CARGAR NOMBRE DE PERFIL, PIN E ID EN LAS VARIABLES */
            foreach ($plan->PlanAccounts as  $value) {
                if ($value->status == 'VENCIDO' && $value->COMBO == 'PERFIL1') {
                    foreach ($value->Cuenta->CuentaPerfiles as  $v) {
                        if ($v->status == 'VENCIDO' && $v->COMBO == 'PERFIL1' && $v->plan_id == $this->selected_id) {
                            $this->plataforma1Nombre = $v->Cuenta->Plataforma->nombre;
                            $this->perfil1COMBO =  $v->Perfil->nameprofile;
                            $this->PIN1COMBO = $v->Perfil->pin;
                            $this->selected_perfil1 = $v->Perfil->id;
                        }
                    }
                }
            }
            foreach ($plan->PlanAccounts as  $value) {
                if ($value->status == 'VENCIDO' && $value->COMBO == 'PERFIL2') {
                    foreach ($value->Cuenta->CuentaPerfiles as  $v) {
                        if ($v->status == 'VENCIDO' && $v->COMBO == 'PERFIL2' && $v->plan_id == $this->selected_id) {
                            $this->plataforma2Nombre = $v->Cuenta->Plataforma->nombre;
                            $this->perfil2COMBO =  $v->Perfil->nameprofile;
                            $this->PIN2COMBO = $v->Perfil->pin;
                            $this->selected_perfil2 = $v->Perfil->id;
                        }
                    }
                }
            }
            foreach ($plan->PlanAccounts as  $value) {
                if ($value->status == 'VENCIDO' && $value->COMBO == 'PERFIL3') {
                    foreach ($value->Cuenta->CuentaPerfiles as  $v) {
                        if ($v->status == 'VENCIDO' && $v->COMBO == 'PERFIL3' && $v->plan_id == $this->selected_id) {
                            $this->plataforma3Nombre = $v->Cuenta->Plataforma->nombre;
                            $this->perfil3COMBO =  $v->Perfil->nameprofile;
                            $this->PIN3COMBO = $v->Perfil->pin;
                            $this->selected_perfil3 = $v->Perfil->id;
                        }
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
            'nombreCliente' => 'required|min:4',
            'celular' => 'required|integer|min:8',
            'start_account' => 'required|not_in:0000-00-00',
            'expiration_account' => 'required|not_in:0000-00-00',
        ];
        $messages = [
            'perfil1COMBO.required' => 'El nombre del perfil es requerido',
            'PIN1COMBO.required' => 'El pin del perfil es requerido',
            'perfil2COMBO.required' => 'El nombre del perfil es requerido',
            'PIN2COMBO.required' => 'El pin del perfil es requerido',
            'perfil3COMBO.required' => 'El nombre del perfil es requerido',
            'PIN3COMBO.required' => 'El pin del perfil es requerido',
            'nombreCliente.required' => 'El nombre del cliente es requerido',
            'nombreCliente.min' => 'El nombre debe tener al menos 4 caracteres',
            'celular.required' => 'El número de celular del cliente es requerido',
            'celular.integer' => 'El celular debe ser un número',
            'celular.min' => 'El celular debe tener 8 dígitos',
            'start_account.required' => 'Seleccione una fecha valida',
            'start_account.not_in' => 'Seleccione una fecha valida',
            'expiration_account.required' => 'Seleccione una fecha valida',
            'expiration_account.not_in' => 'Seleccione una fecha valida',
        ];

        $this->validate($rules, $messages);

        $plan = Plan::find($this->selected_id);
        $plan->observations = $this->observations;
        $plan->plan_start = $this->start_account;
        $plan->expiration_plan = $this->expiration_account;
        $plan->save();

        if ($this->comprobante != $plan->comprobante) {
            $customFileName = uniqid() . '_.' . $this->comprobante->extension();
            $this->comprobante->storeAs('public/planesComprobantes', $customFileName);
            $imageTemp = $plan->comprobante;
            $plan->comprobante = $customFileName;
            $plan->save();
            if ($imageTemp != null) {
                if (file_exists('storage/planesComprobantes/' . $imageTemp)) {
                    unlink('storage/planesComprobantes/' . $imageTemp);
                }
            }
        }

        $cliente = Cliente::find($this->clienteID);
        $cliente->nombre = $this->nombreCliente;
        $cliente->celular = $this->celular;
        $cliente->save();

        $prof1 = Profile::find($this->selected_perfil1);
        $prof1->update([
            'nameprofile' => $this->perfil1COMBO,
            'pin' => $this->PIN1COMBO,
        ]);

        $prof2 = Profile::find($this->selected_perfil2);
        $prof2->update([
            'nameprofile' => $this->perfil2COMBO,
            'pin' => $this->PIN2COMBO,
        ]);

        $prof3 = Profile::find($this->selected_perfil3);
        $prof3->update([
            'nameprofile' => $this->perfil3COMBO,
            'pin' => $this->PIN3COMBO,
        ]);

        $this->resetUI();
        $this->emit('combo-updated', 'Perfiles Actualizados');
    }

    public function AccionesCombo(Plan $plan, Cliente $cliente)
    {
        $this->resetUI();

        $this->selected_plan = $plan->id;
        $this->observations = $plan->observations;
        $this->inicioPlanActual = $plan->plan_start;
        $this->expirationPlanActual = $plan->expiration_plan;
        $this->mesesPlan = $plan->meses;
        $this->importePlan = $plan->importe;

        $this->clienteID = $cliente->id;
        $this->nombreCliente = $cliente->nombre;
        $this->celular = $cliente->celular;

        $this->inicioNueva = strtotime('+' . 1 . ' day', strtotime($this->expirationPlanActual));
        $this->inicioNueva = date('Y-m-d', $this->inicioNueva);

        $this->selected_accountProf3 = 0;

        /* CARGAR NOMBRE DE PERFIL, PIN E ID EN LAS VARIABLES */
        foreach ($plan->PlanAccounts as  $value) {
            if ($value->status == 'ACTIVO' && $value->COMBO == 'PERFIL1') {
                $this->selected_planAccount1 = $value->id;
                foreach ($value->Cuenta->CuentaPerfiles as  $v) {
                    if ($v->status == 'ACTIVO' && $v->COMBO == 'PERFIL1' && $v->plan_id == $this->selected_plan) {
                        $this->selected_accountProf1 = $v->id;
                        $this->plataforma1Nombre = $v->Cuenta->Plataforma->nombre;
                        $this->selected_plataforma1 = $v->Cuenta->Plataforma->id;
                        $this->selected_cuenta1 = $v->Cuenta->id;
                        $this->perfil1COMBO =  $v->Perfil->nameprofile;
                        $this->PIN1COMBO = $v->Perfil->pin;
                        $this->selected_perfil1 = $v->Perfil->id;
                        $this->expiracionCuenta1 = $v->Cuenta->expiration_account;
                    }
                }
            }
        }
        foreach ($plan->PlanAccounts as  $value) {
            if ($value->status == 'ACTIVO' && $value->COMBO == 'PERFIL2') {
                $this->selected_planAccount2 = $value->id;
                foreach ($value->Cuenta->CuentaPerfiles as  $v) {
                    if ($v->status == 'ACTIVO' && $v->COMBO == 'PERFIL2' && $v->plan_id == $this->selected_plan) {
                        $this->selected_accountProf2 = $v->id;
                        $this->plataforma2Nombre = $v->Cuenta->Plataforma->nombre;
                        $this->selected_plataforma2 = $v->Cuenta->Plataforma->id;
                        $this->selected_cuenta2 = $v->Cuenta->id;
                        $this->perfil2COMBO =  $v->Perfil->nameprofile;
                        $this->PIN2COMBO = $v->Perfil->pin;
                        $this->selected_perfil2 = $v->Perfil->id;
                        $this->expiracionCuenta2 = $v->Cuenta->expiration_account;
                    }
                }
            }
        }
        foreach ($plan->PlanAccounts as  $value) {
            if ($value->status == 'ACTIVO' && $value->COMBO == 'PERFIL3') {
                $this->selected_planAccount3 = $value->id;
                foreach ($value->Cuenta->CuentaPerfiles as  $v) {
                    if ($v->status == 'ACTIVO' && $v->COMBO == 'PERFIL3' && $v->plan_id == $this->selected_plan) {
                        $this->selected_accountProf3 = $v->id;
                        $this->plataforma3Nombre = $v->Cuenta->Plataforma->nombre;
                        $this->selected_plataforma3 = $v->Cuenta->Plataforma->id;
                        $this->selected_cuenta3 = $v->Cuenta->id;
                        $this->perfil3COMBO =  $v->Perfil->nameprofile;
                        $this->PIN3COMBO = $v->Perfil->pin;
                        $this->selected_perfil3 = $v->Perfil->id;
                        $this->expiracionCuenta3 = $v->Cuenta->expiration_account;
                    }
                }
            }
        }
        $this->emit('modal-acciones-combo', '');
    }

    public function cambiarCuentaPlat1()
    {
        $this->mostrarTablaCambiar1 = 'SI';
        /* MOSTRAR CUENTAS CON ESPACIOS DE PERFILES */
        $date_now = date('Y-m-d', time());
        $this->cuentasConEspaciosP1 = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
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
                DB::raw('0 as espacios'),
            )
            ->where('accounts.status', 'ACTIVO')
            ->where('accounts.availability', 'LIBRE')
            ->where('accounts.expiration_account', '>', $date_now)
            ->where('accounts.id', '!=', $this->selected_cuenta1)
            ->where('p.id', $this->selected_plataforma1)
            ->get();

        foreach ($this->cuentasConEspaciosP1 as $c) {
            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $c->id)
                ->where('ap.status', '!=', 'VENCIDO')
                ->where('p.availability', 'OCUPADO')->get();

            $cantidadActivos = $perfilesActivos->count();
            $c->perfActivos = $cantidadActivos;

            $c->espacios = $c->number_profiles - $c->perfActivos;
        }
    }

    public function SeleccionarCuenta1(Account $cuenta)
    {
        DB::beginTransaction();
        try {
            /* PONER EN NO LISTO LA ACCION */
            $plan = Plan::find($this->selected_plan);
            $plan->done = 'NO';
            /* $plan->observations = $this->observations; */
            $plan->save();

            /* OBTENER UN PERFIL DE LA CUENTA NUEVA PARA PONER LOS DATOS DEL PERFIL ANTERIOR */
            $perfilCambiar = Account::join('account_profiles as ap', 'accounts.id', 'ap.account_id')
                ->join('profiles as p', 'p.id', 'ap.profile_id')
                ->select('p.*')
                ->where('accounts.id', $cuenta->id)
                ->where('p.availability', 'LIBRE')->get()->first();

            /* PONER LOS DATOS DEL ANTERIOR PERFIL AL NUEVO */
            $profile = Profile::find($perfilCambiar->id);
            $profile->nameprofile = $this->perfil1COMBO;
            $profile->pin = $this->PIN1COMBO;
            $profile->availability = 'OCUPADO';
            $profile->save();

            /* LA CUENTA PASA A DIVIDIDA SI NO LO ESTABA */
            $cuenta->whole_account = 'DIVIDIDA';
            $cuenta->save();

            /* PONER EN CAMBIADO EL PLAN-ACCOUNT */
            $planAccountVIEJO = PlanAccount::find($this->selected_planAccount1);
            $planAccountVIEJO->update([
                'status' => 'CAMBIADO',
            ]);

            /* CREAR NUEVO PLAN-ACCOUNT */
            PlanAccount::create([
                'COMBO' => 'PERFIL1',
                'plan_id' => $this->selected_plan,
                'account_id' => $cuenta->id,
            ]);

            /* crear un nuevo perfil libre en la cuenta antigua que reemplace al que se cambió */
            $perfil = Profile::create([
                'nameprofile' => 'emanuel' . rand(100, 999),
                'pin' => rand(1000, 9999),
            ]);
            AccountProfile::create([
                'status' => 'SinAsignar',
                'account_id' => $this->selected_cuenta1,
                'profile_id' => $perfil->id,
            ]);


            /* PONER EN VENCIDO EL PERFIL */
            $perfilViejo = Profile::find($this->selected_perfil1);
            $perfilViejo->status = 'INACTIVO';
            $perfilViejo->availability = 'VENCIDO';
            $perfilViejo->save();

            /* PONER EN CAMBIADO EL ACCOUNT-PROFILE */
            $cuentaPerfilViejo = AccountProfile::find($this->selected_accountProf1);
            $cuentaPerfilViejo->update([
                'status' => 'CAMBIADO',
            ]);

            /* poner en activo el account_profile del perfil y ponerle el id del plan */
            $accountProfiles = AccountProfile::where('account_id', $cuenta->id)
                ->where('profile_id', $profile->id)->get()->first();
            $ACCOUNTPROF = AccountProfile::find($accountProfiles->id);
            $ACCOUNTPROF->update([
                'status' => 'ACTIVO',
                'COMBO' => 'PERFIL1',
                'plan_id' => $this->selected_plan,
            ]);

            /* CONTAR LOS PERFILES ocupados de la cuenta anterior */
            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $this->selected_cuenta1)
                ->where('p.availability', 'OCUPADO')->get();

            /* SI LA CUENTA NO TIENE PERFILES ACTIVOS REGRESA A SER ENTERA */
            if ($perfilesActivos->count() == 0) {
                $cuenta = Account::find($this->selected_cuenta1);
                $cuenta->whole_account = 'ENTERA';
                $cuenta->save();
            }

            $this->resetUI();
            DB::commit();
            $this->emit('acciones-combo-hide', 'Se creó el perfil en la cuenta seleccionada');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

    public function cambiarCuentaPlat2()
    {
        $this->mostrarTablaCambiar2 = 'SI';
        /* MOSTRAR CUENTAS CON ESPACIOS DE PERFILES */
        $date_now = date('Y-m-d', time());
        $this->cuentasConEspaciosP2 = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
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
                DB::raw('0 as espacios'),
            )
            ->where('accounts.status', 'ACTIVO')
            ->where('accounts.availability', 'LIBRE')
            ->where('accounts.expiration_account', '>', $date_now)
            ->where('accounts.id', '!=', $this->selected_cuenta2)
            ->where('p.id', $this->selected_plataforma2)
            ->get();

        foreach ($this->cuentasConEspaciosP2 as $c) {
            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $c->id)
                ->where('ap.status', '!=', 'VENCIDO')
                ->where('p.availability', 'OCUPADO')->get();

            $cantidadActivos = $perfilesActivos->count();
            $c->perfActivos = $cantidadActivos;

            $c->espacios = $c->number_profiles - $c->perfActivos;
        }
    }

    public function SeleccionarCuenta2(Account $cuenta)
    {
        DB::beginTransaction();
        try {
            /* PONER EN NO LISTO LA ACCION */
            $plan = Plan::find($this->selected_plan);
            $plan->done = 'NO';
            /* $plan->observations = $this->observations; */
            $plan->save();

            /* OBTENER UN PERFIL DE LA CUENTA NUEVA PARA PONER LOS DATOS DEL PERFIL ANTERIOR */
            $perfilCambiar = Account::join('account_profiles as ap', 'accounts.id', 'ap.account_id')
                ->join('profiles as p', 'p.id', 'ap.profile_id')
                ->select('p.*')
                ->where('accounts.id', $cuenta->id)
                ->where('p.availability', 'LIBRE')->get()->first();

            /* PONER LOS DATOS DEL ANTERIOR PERFIL AL NUEVO */
            $profile = Profile::find($perfilCambiar->id);
            $profile->nameprofile = $this->perfil2COMBO;
            $profile->pin = $this->PIN2COMBO;
            $profile->availability = 'OCUPADO';
            $profile->save();

            /* LA CUENTA PASA A DIVIDIDA SI NO LO ESTABA */
            $cuenta->whole_account = 'DIVIDIDA';
            $cuenta->save();

            /* PONER EN CAMBIADO EL PLAN-ACCOUNT */
            $planAccountVIEJO = PlanAccount::find($this->selected_planAccount2);
            $planAccountVIEJO->update([
                'status' => 'CAMBIADO',
            ]);

            /* CREAR NUEVO PLAN-ACCOUNT */
            PlanAccount::create([
                'COMBO' => 'PERFIL2',
                'plan_id' => $this->selected_plan,
                'account_id' => $cuenta->id,
            ]);

            /* crear un nuevo perfil libre en la cuenta antigua que reemplace al que se cambió */
            $perfil = Profile::create([
                'nameprofile' => 'emanuel' . rand(100, 999),
                'pin' => rand(1000, 9999),
            ]);
            AccountProfile::create([
                'status' => 'SinAsignar',
                'account_id' => $this->selected_cuenta2,
                'profile_id' => $perfil->id,
            ]);

            /* PONER EN VENCIDO EL PERFIL */
            $perfilViejo = Profile::find($this->selected_perfil2);
            $perfilViejo->status = 'INACTIVO';
            $perfilViejo->availability = 'VENCIDO';
            $perfilViejo->save();

            /* PONER EN CAMBIADO EL ACCOUNT-PROFILE */
            $cuentaPerfilViejo = AccountProfile::find($this->selected_accountProf2);
            $cuentaPerfilViejo->update([
                'status' => 'CAMBIADO',
            ]);

            $accountProfiles = AccountProfile::where('account_id', $cuenta->id)
                ->where('profile_id', $profile->id)->get()->first();
            $ACCOUNTPROF = AccountProfile::find($accountProfiles->id);
            $ACCOUNTPROF->update([
                'status' => 'ACTIVO',
                'COMBO' => 'PERFIL2',
                'plan_id' => $this->selected_plan,
            ]);

            /* CONTAR LOS PERFILES ocupados de la cuenta anterior */
            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $this->selected_cuenta2)
                ->where('p.availability', 'OCUPADO')->get();

            /* SI LA CUENTA NO TIENE PERFILES ACTIVOS REGRESA A SER ENTERA */
            if ($perfilesActivos->count() == 0) {
                $cuenta = Account::find($this->selected_cuenta2);
                $cuenta->whole_account = 'ENTERA';
                $cuenta->save();
            }

            $this->resetUI();
            DB::commit();
            $this->emit('acciones-combo-hide', 'Se creó el perfil en la cuenta seleccionada');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

    public function cambiarCuentaPlat3()
    {
        $this->mostrarTablaCambiar3 = 'SI';
        /* MOSTRAR CUENTAS CON ESPACIOS DE PERFILES */
        $date_now = date('Y-m-d', time());
        $this->cuentasConEspaciosP3 = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
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
                DB::raw('0 as espacios'),
            )
            ->where('accounts.status', 'ACTIVO')
            ->where('accounts.availability', 'LIBRE')
            ->where('accounts.expiration_account', '>', $date_now)
            ->where('accounts.id', '!=', $this->selected_cuenta3)
            ->where('p.id', $this->selected_plataforma3)
            ->get();

        foreach ($this->cuentasConEspaciosP3 as $c) {
            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $c->id)
                ->where('ap.status', '!=', 'VENCIDO')
                ->where('p.availability', 'OCUPADO')->get();

            $cantidadActivos = $perfilesActivos->count();
            $c->perfActivos = $cantidadActivos;

            $c->espacios = $c->number_profiles - $c->perfActivos;
        }
    }

    public function SeleccionarCuenta3(Account $cuenta)
    {
        DB::beginTransaction();
        try {
            /* PONER EN NO LISTO LA ACCION */
            $plan = Plan::find($this->selected_plan);
            $plan->done = 'NO';
            /* $plan->observations = $this->observations; */
            $plan->save();

            /* OBTENER UN PERFIL DE LA CUENTA NUEVA PARA PONER LOS DATOS DEL PERFIL ANTERIOR */
            $perfilCambiar = Account::join('account_profiles as ap', 'accounts.id', 'ap.account_id')
                ->join('profiles as p', 'p.id', 'ap.profile_id')
                ->select('p.*')
                ->where('accounts.id', $cuenta->id)
                ->where('p.availability', 'LIBRE')->get()->first();

            /* PONER LOS DATOS DEL ANTERIOR PERFIL AL NUEVO */
            $profile = Profile::find($perfilCambiar->id);
            $profile->nameprofile = $this->perfil3COMBO;
            $profile->pin = $this->PIN3COMBO;
            $profile->availability = 'OCUPADO';
            $profile->save();

            /* LA CUENTA PASA A DIVIDIDA SI NO LO ESTABA */
            $cuenta->whole_account = 'DIVIDIDA';
            $cuenta->save();

            /* PONER EN CAMBIADO EL PLAN-ACCOUNT */
            $planAccountVIEJO = PlanAccount::find($this->selected_planAccount3);
            $planAccountVIEJO->update([
                'status' => 'CAMBIADO',
            ]);

            /* CREAR NUEVO PLAN-ACCOUNT */
            PlanAccount::create([
                'COMBO' => 'PERFIL3',
                'plan_id' => $this->selected_plan,
                'account_id' => $cuenta->id,
            ]);

            /* crear un nuevo perfil libre en la cuenta antigua que reemplace al que se cambió */
            $perfil = Profile::create([
                'nameprofile' => 'emanuel' . rand(100, 999),
                'pin' => rand(1000, 9999),
            ]);
            AccountProfile::create([
                'status' => 'SinAsignar',
                'account_id' => $this->selected_cuenta3,
                'profile_id' => $perfil->id,
            ]);


            /* PONER EN VENCIDO EL PERFIL */
            $perfilViejo = Profile::find($this->selected_perfil3);
            $perfilViejo->status = 'INACTIVO';
            $perfilViejo->availability = 'VENCIDO';
            $perfilViejo->save();

            /* PONER EN CAMBIADO EL ACCOUNT-PROFILE */
            $cuentaPerfilViejo = AccountProfile::find($this->selected_accountProf3);
            $cuentaPerfilViejo->update([
                'status' => 'CAMBIADO',
            ]);

            $accountProfiles = AccountProfile::where('account_id', $cuenta->id)
                ->where('profile_id', $profile->id)->get()->first();
            $ACCOUNTPROF = AccountProfile::find($accountProfiles->id);
            $ACCOUNTPROF->update([
                'status' => 'ACTIVO',
                'COMBO' => 'PERFIL3',
                'plan_id' => $this->selected_plan,
            ]);

            /* CONTAR LOS PERFILES ACTIVOS OCUPADOS */
            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $this->selected_cuenta3)
                ->where('p.availability', 'OCUPADO')->get();

            /* SI LA CUENTA NO TIENE PERFILES ACTIVOS REGRESA A SER ENTERA */
            if ($perfilesActivos->count() == 0) {
                $cuenta = Account::find($this->selected_cuenta3);
                $cuenta->whole_account = 'ENTERA';
                $cuenta->save();
            }

            $this->resetUI();
            DB::commit();
            $this->emit('acciones-combo-hide', 'Se creó el perfil en la cuenta seleccionada');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

    public function RenovarCombo()
    {
        $rules = [
            'tipopago' => 'required|not_in:Elegir',
            'meses' => 'required|integer|gt:0',
            'diasdePlan' => 'required|integer|gt:0',
            'importe' => 'required|integer|gt:0',
        ];
        $messages = [
            'tipopago.required' => 'El tipo de pago es requerido',
            'tipopago.not_in' => 'Seleccione un valor distinto a Elegir',
            'meses.required' => 'La cantidad de meses es requerido',
            'meses.integer' => 'La cantidad de meses debe ser un número',
            'meses.gt' => 'La cantidad de meses debe ser mayor a 0',
            'diasdePlan.required' => 'La cantidad de dias requerido',
            'diasdePlan.integer' => 'La cantidad de dias debe ser un número',
            'diasdePlan.gt' => 'La cantidad de dias debe ser mayor a 0',
            'importe.required' => 'El importe es requerido',
            'importe.integer' => 'El importe debe ser un número',
            'importe.gt' => 'El importe debe ser mayor a 0',
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

        DB::beginTransaction();
        try {
            $mv = Movimiento::create([
                'type' => 'TERMINADO',
                'status' => 'ACTIVO',
                'import' => $this->importe,
                'user_id' => Auth()->user()->id,
            ]);

            $date_now = date("Y-m-d H:i");
            /* INVERSION DEL PERFIL 1 */
            CuentaInversion::create([
                'tipo' => 'INGRESO',
                'cantidad' => $this->importe / 3,
                'tipoPlan' => 'COMBO',
                'tipoTransac' => 'RENOVACION',
                'num_meses' => $this->meses,
                'fecha_realizacion' => $date_now,
                'account_id' => $this->selected_cuenta1
            ]);
            /* INVERSION DEL PERFIL 2 */
            CuentaInversion::create([
                'tipo' => 'INGRESO',
                'cantidad' => $this->importe / 3,
                'tipoPlan' => 'COMBO',
                'tipoTransac' => 'RENOVACION',
                'num_meses' => $this->meses,
                'fecha_realizacion' => $date_now,
                'account_id' => $this->selected_cuenta2
            ]);
            /* INVERSION DEL PERFIL 3 */
            CuentaInversion::create([
                'tipo' => 'INGRESO',
                'cantidad' => $this->importe / 3,
                'tipoPlan' => 'COMBO',
                'tipoTransac' => 'RENOVACION',
                'num_meses' => $this->meses,
                'fecha_realizacion' => $date_now,
                'account_id' => $this->selected_cuenta3
            ]);

            /* CREAR EL PLAN */
            $plan = Plan::create([
                'importe' => $this->importe,
                'plan_start' => $this->inicioNueva,
                'expiration_plan' => $this->expirationNueva,
                'meses' => $this->meses,
                'ready' => 'SI',
                'done' => 'NO',
                'status' => 'VIGENTE',
                'type_plan' => 'COMBO',
                'type_pay' => $this->tipopago,
                'observations' => $this->observations,
                'movimiento_id' => $mv->id
            ]);


            if ($this->comprobante) {
                $customFileName = uniqid() . '_.' . $this->comprobante->extension();
                $this->comprobante->storeAs('public/planesComprobantes', $customFileName);
                $plan->comprobante = $customFileName;
                $plan->save();
            }

            /* CREAR PLAN ACCOUNT Y ACCOUNT PROFILE NUEVOS PARA EL PERFIL 1 */
            PlanAccount::create([
                'status' => 'ACTIVO',
                'COMBO' => 'PERFIL1',
                'plan_id' => $plan->id,
                'account_id' => $this->selected_cuenta1,
            ]);
            AccountProfile::create([
                'account_id' => $this->selected_cuenta1,
                'profile_id' => $this->selected_perfil1,
                'plan_id' => $plan->id,
                'COMBO' => 'PERFIL1',
                'status' => 'ACTIVO',
            ]);

            /* CREAR PLAN ACCOUNT Y ACCOUNT PROFILE NUEVOS PARA EL PERFIL 2 */
            PlanAccount::create([
                'status' => 'ACTIVO',
                'COMBO' => 'PERFIL2',
                'plan_id' => $plan->id,
                'account_id' => $this->selected_cuenta2,
            ]);
            AccountProfile::create([
                'account_id' => $this->selected_cuenta2,
                'profile_id' => $this->selected_perfil2,
                'plan_id' => $plan->id,
                'COMBO' => 'PERFIL2',
                'status' => 'ACTIVO',
            ]);

            /* CREAR PLAN ACCOUNT Y ACCOUNT PROFILE NUEVOS PARA EL PERFIL 3 */
            PlanAccount::create([
                'status' => 'ACTIVO',
                'COMBO' => 'PERFIL3',
                'plan_id' => $plan->id,
                'account_id' => $this->selected_cuenta3,
            ]);
            AccountProfile::create([
                'account_id' => $this->selected_cuenta3,
                'profile_id' => $this->selected_perfil3,
                'plan_id' => $plan->id,
                'COMBO' => 'PERFIL3',
                'status' => 'ACTIVO',
            ]);

            /* PONER EN VENCIDO EL PLAN ANTERIOR */
            $planviejo = Plan::find($this->selected_plan);
            $planviejo->status = 'VENCIDO';
            $planviejo->save();

            /* PONER EN VENCIDO EL PLAN ACCOUNT DEL PERFIL 1 */
            $plAccount1 = PlanAccount::find($this->selected_planAccount1);
            $plAccount1->status = 'VENCIDO';
            $plAccount1->save();
            /* PONER EN VENCIDO EL PLAN ACCOUNT DEL PERFIL 2 */
            $plAccount2 = PlanAccount::find($this->selected_planAccount2);
            $plAccount2->status = 'VENCIDO';
            $plAccount2->save();
            /* PONER EN VENCIDO EL PLAN ACCOUNT DEL PERFIL 3 */
            $plAccount3 = PlanAccount::find($this->selected_planAccount3);
            $plAccount3->status = 'VENCIDO';
            $plAccount3->save();

            /* PONER EN VENCIDO ACCOUNTPROFILE ANTERIOR*/
            $cuentaPerfil1 = AccountProfile::find($this->selected_accountProf1);
            $cuentaPerfil1->status = 'VENCIDO';
            $cuentaPerfil1->save();
            /* PONER EN VENCIDO ACCOUNTPROFILE ANTERIOR*/
            $cuentaPerfil2 = AccountProfile::find($this->selected_accountProf2);
            $cuentaPerfil2->status = 'VENCIDO';
            $cuentaPerfil2->save();
            /* PONER EN VENCIDO ACCOUNTPROFILE ANTERIOR*/
            $cuentaPerfil3 = AccountProfile::find($this->selected_accountProf3);
            $cuentaPerfil3->status = 'VENCIDO';
            $cuentaPerfil3->save();

            if ($this->tipopago == 'EFECTIVO') {
                $cajaFisica = Cartera::where('tipo', 'CajaFisica')
                    ->where('caja_id', $CajaActual->id)->get()->first();
                CarteraMov::create([
                    'type' => 'INGRESO',
                    'tipoDeMovimiento' => 'STREAMING',
                    'comentario' => '',
                    'cartera_id' => $cajaFisica->id,
                    'movimiento_id' => $mv->id
                ]);
            }

            ClienteMov::create([
                'movimiento_id' => $mv->id,
                'cliente_id' => $this->clienteID
            ]);

            DB::commit();
            $this->resetUI();
            $this->emit('acciones-combo-hide', 'Se renovó el combo');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
            $this->emit('item-accion', 'No se pudo renovar el plan porque la cuenta de uno de los perfiles no ha sido renovada con su proveedor');
        }
    }

    public function VencerCombo()
    {
        DB::beginTransaction();
        try {
            /* CREAR PERFIL Y ACCOUNT PROFILE EN LA CUENTA ANTERIOR PARA QUE REEMPLACE AL QUE SE VENCE */
            $perfil1 = Profile::create([
                'nameprofile' => 'emanuel' . rand(100, 999),
                'pin' => rand(1000, 9999),
            ]);
            AccountProfile::create([
                'status' => 'SinAsignar',
                'account_id' => $this->selected_cuenta1,
                'profile_id' => $perfil1->id,
            ]);
            /* CREAR PERFIL Y ACCOUNT PROFILE EN LA CUENTA ANTERIOR PARA QUE REEMPLACE AL QUE SE VENCE */
            $perfil2 = Profile::create([
                'nameprofile' => 'emanuel' . rand(100, 999),
                'pin' => rand(1000, 9999),
            ]);
            AccountProfile::create([
                'status' => 'SinAsignar',
                'account_id' => $this->selected_cuenta2,
                'profile_id' => $perfil2->id,
            ]);
            /* CREAR PERFIL Y ACCOUNT PROFILE EN LA CUENTA ANTERIOR PARA QUE REEMPLACE AL QUE SE VENCE */
            $perfil3 = Profile::create([
                'nameprofile' => 'emanuel' . rand(100, 999),
                'pin' => rand(1000, 9999),
            ]);
            AccountProfile::create([
                'status' => 'SinAsignar',
                'account_id' => $this->selected_cuenta3,
                'profile_id' => $perfil3->id,
            ]);

            $planAntiguo = Plan::find($this->selected_plan);
            $planAntiguo->status = 'VENCIDO';
            $planAntiguo->done = 'NO';
            $planAntiguo->observations = $this->observations;
            $planAntiguo->save();

            /* PONER EN VENCIDO EL PLAN ACCOUNT DEL PERFIL 1 */
            $plAccount1 = PlanAccount::find($this->selected_planAccount1);
            $plAccount1->status = 'VENCIDO';
            $plAccount1->save();
            /* PONER EN VENCIDO EL PLAN ACCOUNT DEL PERFIL 2 */
            $plAccount2 = PlanAccount::find($this->selected_planAccount2);
            $plAccount2->status = 'VENCIDO';
            $plAccount2->save();
            /* PONER EN VENCIDO EL PLAN ACCOUNT DEL PERFIL 3 */
            $plAccount3 = PlanAccount::find($this->selected_planAccount3);
            $plAccount3->status = 'VENCIDO';
            $plAccount3->save();

            /* PONER EN INACTIVO AccountProfile 1 */
            $CuentaPerf1 = AccountProfile::find($this->selected_accountProf1);
            $CuentaPerf1->status = 'VENCIDO';
            $CuentaPerf1->save();
            /* PONER EN INACTIVO AccountProfile 2 */
            $CuentaPerf2 = AccountProfile::find($this->selected_accountProf2);
            $CuentaPerf2->status = 'VENCIDO';
            $CuentaPerf2->save();
            /* PONER EN INACTIVO AccountProfile 3 */
            $CuentaPerf3 = AccountProfile::find($this->selected_accountProf3);
            $CuentaPerf3->status = 'VENCIDO';
            $CuentaPerf3->save();

            /* PONER EN INACTIVO EL PERFIL 1 */
            $perf = Profile::find($this->selected_perfil1);
            $perf->availability = 'VENCIDO';
            $perf->status = 'INACTIVO';
            $perf->save();
            /* PONER EN INACTIVO EL PERFIL 2 */
            $perf2 = Profile::find($this->selected_perfil2);
            $perf2->availability = 'VENCIDO';
            $perf2->status = 'INACTIVO';
            $perf2->save();
            /* PONER EN INACTIVO EL PERFIL 3 */
            $perf3 = Profile::find($this->selected_perfil3);
            $perf3->availability = 'VENCIDO';
            $perf3->status = 'INACTIVO';
            $perf3->save();

            /* CONTAR LOS PERFILES OCUPADOS DE LA CUENTA DEL PERFIL 1 */
            $perfOcupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $this->selected_cuenta1)
                ->where('p.availability', 'OCUPADO')->get();
            /* SI LA CUENTA NO TIENE PERFILES OCUPADOS REGRESA A SER ENTERA */
            if ($perfOcupados->count() == 0) {
                $Cuenta1 = Account::find($this->selected_cuenta1);
                $Cuenta1->whole_account = 'ENTERA';
                $Cuenta1->save();
            }
            /* CONTAR LOS PERFILES OCUPADOS DE LA CUENTA DEL PERFIL 2 */
            $perfOcupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $this->selected_cuenta2)
                ->where('p.availability', 'OCUPADO')->get();
            /* SI LA CUENTA NO TIENE PERFILES OCUPADOS REGRESA A SER ENTERA */
            if ($perfOcupados->count() == 0) {
                $Cuenta2 = Account::find($this->selected_cuenta2);
                $Cuenta2->whole_account = 'ENTERA';
                $Cuenta2->save();
            }
            /* CONTAR LOS PERFILES OCUPADOS DE LA CUENTA DEL PERFIL 3 */
            $perfOcupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $this->selected_cuenta3)
                ->where('p.availability', 'OCUPADO')->get();
            /* SI LA CUENTA NO TIENE PERFILES OCUPADOS REGRESA A SER ENTERA */
            if ($perfOcupados->count() == 0) {
                $Cuenta3 = Account::find($this->selected_cuenta3);
                $Cuenta3->whole_account = 'ENTERA';
                $Cuenta3->save();
            }
            DB::commit();
            $this->resetUI();
            $this->emit('acciones-combo-hide', 'NO SE RENOVO EL COMBO');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

    // renovacion vencimiento y cambiar de cuenta de perfil
    public function Acciones(Profile $profile, AccountProfile $accountPRO, Account $cuenta, PlanAccount $planAccount, Plan $plan, Cliente $cliente, Platform $plataforma)
    {
        $this->resetUI();

        $this->selected_perfil = $profile->id;
        $this->nameperfil = $profile->nameprofile;
        $this->pin = $profile->pin;

        $this->selected_accountProf = $accountPRO->id;

        $this->selected_account = $cuenta->id;

        $this->selected_planAccount = $planAccount->id;

        $this->selected_plan = $plan->id;
        $this->observations = $plan->observations;
        $this->inicioPlanActual = $plan->plan_start;
        $this->expirationPlanActual = $plan->expiration_plan;
        $this->mesesPlan = $plan->meses;
        $this->importePlan = $plan->importe;

        $this->selected_cliente = $cliente->id;
        $this->nombreCliente = $cliente->nombre;
        $this->celular = $cliente->celular;

        $this->selected_platf = $plataforma->id;
        $this->plataformaPlan = $plataforma->nombre;

        $this->inicioNueva = strtotime('+' . 1 . ' day', strtotime($this->expirationPlanActual));
        $this->inicioNueva = date('Y-m-d', $this->inicioNueva);

        $this->emit('details-show', 'show modal!');
    }

    public function Renovar()
    {
        $rules = [
            'tipopago' => 'required|not_in:Elegir',
            'meses' => 'required|integer|gt:0',
            'diasdePlan' => 'required|integer|gt:0',
            'importe' => 'required|integer|gt:0',
        ];
        $messages = [
            'tipopago.required' => 'El tipo de pago es requerido',
            'tipopago.not_in' => 'Seleccione un valor distinto a Elegir',
            'meses.required' => 'Los meses a renovar son requeridos si va a renovar',
            'meses.integer' => 'Los meses deben ser un número',
            'meses.gt' => 'Los meses a renovar deben ser minimo 1',
            'diasdePlan.required' => 'Los dias a renovar son requeridos si va a renovar',
            'diasdePlan.integer' => 'Los dias deben ser un número',
            'diasdePlan.gt' => 'Los dias a renovar deben ser minimo 1',
            'importe.required' => 'El importe es requerido',
            'importe.integer' => 'El importe debe ser un número',
            'importe.gt' => 'El importe debe ser mayor a 0',
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
        try {
            $caja = Caja::find($CajaActual->id);
        } catch (Exception $e) {
            $this->emit('item-error', "NO TIENE UNA CAJA ABIERTA PARA RENOVAR");
            return;
        }

        DB::beginTransaction();
        try {
            $mv = Movimiento::create([
                'type' => 'TERMINADO',
                'status' => 'ACTIVO',
                'import' => $this->importe,
                'user_id' => Auth()->user()->id,
            ]);

            $date_now = date("Y-m-d H:i");

            CuentaInversion::create([
                'tipo' => 'INGRESO',
                'cantidad' => $this->importe,
                'tipoPlan' => 'PERFIL',
                'tipoTransac' => 'RENOVACION',
                'num_meses' => $this->meses,
                'fecha_realizacion' => $date_now,
                'account_id' => $this->selected_account
            ]);

            $plan = Plan::create([
                'importe' => $this->importe,
                'plan_start' => $this->inicioNueva,
                'expiration_plan' => $this->expirationNueva,
                'meses' => $this->meses,
                'ready' => 'SI',
                'done' => 'NO',
                'type_plan' => 'PERFIL',
                'status' => 'VIGENTE',
                'type_pay' => $this->tipopago,
                'observations' => $this->observations,
                'movimiento_id' => $mv->id
            ]);

            if ($this->comprobante) {
                $customFileName = uniqid() . '_.' . $this->comprobante->extension();
                $this->comprobante->storeAs('public/planesComprobantes', $customFileName);
                $plan->comprobante = $customFileName;
                $plan->save();
            }

            PlanAccount::create([
                'status' => 'ACTIVO',
                'plan_id' => $plan->id,
                'account_id' => $this->selected_account,
            ]);

            AccountProfile::create([
                'account_id' => $this->selected_account,
                'profile_id' => $this->selected_perfil,
                'plan_id' => $plan->id,
                'status' => 'ACTIVO',
            ]);

            /* PONER EN VENCIDO EL PLAN ANTERIOR */
            $planviejo = Plan::find($this->selected_plan);
            $planviejo->status = 'VENCIDO';
            $planviejo->save();
            /* PONER EN VENCIDO PLANACCOUNT ANTERIOR */
            $planCuenta = PlanAccount::find($this->selected_planAccount);
            $planCuenta->status = 'VENCIDO';
            $planCuenta->save();
            /* PONER EN VENCIDO ACCOUNTPROFILE ANTERIOR*/
            $cuentaPerfil = AccountProfile::find($this->selected_accountProf);
            $cuentaPerfil->status = 'VENCIDO';
            $cuentaPerfil->save();

            if ($this->tipopago == 'EFECTIVO') {
                $cajaFisica = Cartera::where('tipo', 'CajaFisica')
                    ->where('caja_id', $CajaActual->id)->get()->first();
                CarteraMov::create([
                    'type' => 'INGRESO',
                    'tipoDeMovimiento' => 'STREAMING',
                    'comentario' => '',
                    'cartera_id' => $cajaFisica->id,
                    'movimiento_id' => $mv->id
                ]);
            }

            ClienteMov::create([
                'movimiento_id' => $mv->id,
                'cliente_id' => $this->selected_cliente
            ]);

            DB::commit();
            $this->resetUI();
            $this->emit('item-accion', 'Se renovó este perfil');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
            $this->emit('item-error', 'No se pudo renovar el plan porque la cuenta de este perfil no ha sido renovada con su proveedor');
        }
    }

    public function Vencer()
    {
        /* crear un nuevo perfil vacio en la cuenta donde se vence el plan */
        $perfil = Profile::create([
            'nameprofile' => 'emanuel' . rand(100, 999),
            'pin' => rand(1000, 9999),
        ]);
        AccountProfile::create([
            'status' => 'SinAsignar',
            'account_id' => $this->selected_account,
            'profile_id' => $perfil->id,
        ]);

        $planAntiguo = Plan::find($this->selected_plan);
        $planAntiguo->status = 'VENCIDO';
        $planAntiguo->done = 'NO';
        $planAntiguo->observations = $this->observations;
        $planAntiguo->save();

        $plaAcount = PlanAccount::find($this->selected_planAccount);
        $plaAcount->status = 'VENCIDO';
        $plaAcount->save();

        /* PONER EN INACTIVO AccountProfile */
        $CuentaPerf = AccountProfile::find($this->selected_accountProf);
        $CuentaPerf->status = 'VENCIDO';
        $CuentaPerf->save();

        /* PONER EN INACTIVO EL PERFIL */
        $perf = Profile::find($this->selected_perfil);
        $perf->availability = 'VENCIDO';
        $perf->status = 'INACTIVO';
        $perf->save();

        /* CONTAR LOS PERFILES OCUPADOS */
        $perfOcupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
            ->join('profiles as p', 'ap.profile_id', 'p.id')
            ->where('accounts.id', $this->selected_account)
            ->where('p.availability', 'OCUPADO')->get();
        /* SI LA CUENTA NO TIENE PERFILES OCUPADOS REGRESA A SER ENTERA */
        if ($perfOcupados->count() == 0) {
            $Cuenta = Account::find($this->selected_account);
            $Cuenta->whole_account = 'ENTERA';
            $Cuenta->save();
        }

        $this->condicional = 'vencidos';

        $this->resetUI();
        $this->emit('item-accion', 'Se plan fue vencido');
    }

    public function CambiarCuenta()
    {
        $this->mostrartabla2 = 1;

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
                DB::raw('0 as espacios'),
            )
            ->where('accounts.status', 'ACTIVO')
            ->where('accounts.availability', 'LIBRE')
            ->where('accounts.expiration_account', '>', $date_now)
            ->where('accounts.id', '!=', $this->selected_account)
            ->where('p.id', $this->selected_platf)
            ->get();

        foreach ($this->cuentasEnteras as $c) {
            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $c->id)
                ->where('ap.status', '!=', 'VENCIDO')
                ->where('p.availability', 'OCUPADO')->get();

            $cantidadActivos = $perfilesActivos->count();
            $c->perfActivos = $cantidadActivos;

            $c->espacios = $c->number_profiles - $c->perfActivos;
        }
    }

    public function SeleccionarCuenta(Account $cuenta)
    {
        DB::beginTransaction();
        try {
            /* PONER EN NO LISTO LA ACCION */
            $plan = Plan::find($this->selected_plan);
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
            $planAccountVIEJO = PlanAccount::find($this->selected_planAccount);
            $planAccountVIEJO->update([
                'status' => 'CAMBIADO',
            ]);

            /* CREAR NUEVO PLAN-ACCOUNT */
            PlanAccount::create([
                'plan_id' => $this->selected_plan,
                'account_id' => $cuenta->id,
            ]);

            /* crear un nuevo perfil libre en la cuenta antigua que reemplace al que se cambió */
            $perfil = Profile::create([
                'nameprofile' => 'emanuel' . rand(100, 999),
                'pin' => rand(1000, 9999),
            ]);
            AccountProfile::create([
                'status' => 'SinAsignar',
                'account_id' => $this->selected_account,
                'profile_id' => $perfil->id,
            ]);

            /* PONER EN VENCIDO EL PERFIL */
            $perfilViejo = Profile::find($this->selected_perfil);
            $perfilViejo->status = 'INACTIVO';
            $perfilViejo->availability = 'VENCIDO';
            $perfilViejo->save();

            /* PONER EN CAMBIADO EL ACCOUNT-PROFILE */
            $cuentaPerfilViejo = AccountProfile::find($this->selected_accountProf);
            $cuentaPerfilViejo->update([
                'status' => 'CAMBIADO',
            ]);

            /* PONER EN ACTIVO EL NUEVO ACCOUNT PROFILE y poner el id del plan */
            $accountProfiles = AccountProfile::where('account_id', $cuenta->id)
                ->where('profile_id', $profile->id)->get()->first();
            $ACCOUNTPROF = AccountProfile::find($accountProfiles->id);
            $ACCOUNTPROF->update([
                'status' => 'ACTIVO',
                'plan_id' => $this->selected_plan,
            ]);

            /* CONTAR LOS PERFILES ACTIVOS OCUPADOS DE LA CUENTA ANTERIOR */
            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $this->selected_account)
                ->where('p.availability', 'OCUPADO')->get();

            /* SI LA CUENTA NO TIENE PERFILES ACTIVOS REGRESA A SER ENTERA */
            if ($perfilesActivos->count() == 0) {
                $account = Account::find($this->selected_account);
                $account->whole_account = 'ENTERA';
                $account->save();
            }

            $this->resetUI();
            DB::commit();
            $this->emit('item-accion', 'Se creó el perfil en la cuenta seleccionada');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }
    // fin renovacion vencimiento y cambiar de cuenta


    public function EditObservaciones(Plan $plan, Profile $perfil, Cliente $cliente)
    {
        $this->resetUI();
        $this->selected_plan = $plan->id;
        $this->observations = $plan->observations;
        $this->start_account = $plan->plan_start;
        $this->expiration_account = $plan->expiration_plan;
        $this->comprobante = $plan->comprobante;

        $this->selected_id = $perfil->id;
        $this->nameperfil = $perfil->nameprofile;
        $this->pin = $perfil->pin;

        $this->clienteID = $cliente->id;
        $this->nombreCliente = $cliente->nombre;
        $this->celular = $cliente->celular;

        $this->emit('modal-observaciones-show', 'show modal!');
    }

    public function updateObserv()
    {
        $rules = [
            'nameperfil' => 'required',
            'pin' => 'required',
            'nombreCliente' => 'required|min:4',
            'celular' => 'required|integer|min:8',
            'start_account' => 'required|not_in:0000-00-00',
            'expiration_account' => 'required|not_in:0000-00-00',
        ];

        $messages = [
            'nameperfil.required' => 'El nombre del perfil es requerido',
            'pin.required' => 'El pin es requerido',
            'nombreCliente.required' => 'El nombre del cliente es requerido',
            'nombreCliente.min' => 'El nombre debe tener al menos 4 caracteres',
            'celular.required' => 'El número de celular del cliente es requerido',
            'celular.integer' => 'El celular debe ser un número',
            'celular.min' => 'El celular debe tener 8 dígitos',
            'start_account.required' => 'Seleccione una fecha valida',
            'start_account.not_in' => 'Seleccione una fecha valida',
            'expiration_account.required' => 'Seleccione una fecha valida',
            'expiration_account.not_in' => 'Seleccione una fecha valida',
        ];

        $this->validate($rules, $messages);

        $plan = Plan::find($this->selected_plan);
        $plan->observations = $this->observations;
        $plan->plan_start = $this->start_account;
        $plan->expiration_plan = $this->expiration_account;
        $plan->save();

        if ($this->comprobante != $plan->comprobante) {
            $customFileName = uniqid() . '_.' . $this->comprobante->extension();
            $this->comprobante->storeAs('public/planesComprobantes', $customFileName);
            $imageTemp = $plan->comprobante;
            $plan->comprobante = $customFileName;
            $plan->save();
            if ($imageTemp != null) {
                if (file_exists('storage/planesComprobantes/' . $imageTemp)) {
                    unlink('storage/planesComprobantes/' . $imageTemp);
                }
            }
        }

        $perfil = Profile::find($this->selected_id);
        $perfil->nameprofile = $this->nameperfil;
        $perfil->pin = $this->pin;
        $perfil->save();

        $cliente = Cliente::find($this->clienteID);
        $cliente->nombre = $this->nombreCliente;
        $cliente->celular = $this->celular;
        $cliente->save();

        $this->emit('modal-observaciones-hide', 'Se actualizaron los datos del plan');
    }

    protected $listeners = [
        'deleteRow' => 'Destroy',
        'Vencer' => 'Vencer',
        'Realizado' => 'Realizado',
        'SeleccionarCuenta' => 'SeleccionarCuenta',
        'RenovarCombo' => 'RenovarCombo',
        'VencerCombo' => 'VencerCombo',
        'SeleccionarCuenta1' => 'SeleccionarCuenta1',
        'SeleccionarCuenta2' => 'SeleccionarCuenta2',
        'SeleccionarCuenta3' => 'SeleccionarCuenta3',
    ];

    public function Realizado(Plan $plan)
    {
        $plan->done = 'SI';
        $plan->save();
        $this->resetUI();
        $this->emit('item-accion', 'Se cambio a realizado');
    }
    public function resetUI()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Perfiles';
        $this->status = 'Elegir';
        $this->nameperfil = '';
        $this->pin = '';
        $this->availability = 'Elegir';
        $this->meses = 1;
        $this->expirationNueva = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->tipopago = 'EFECTIVO';
        $this->importe = '';
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
        $this->selected_perfil1 = '';
        $this->selected_perfil2 = '';
        $this->selected_perfil3 = '';
        $this->mostrarTablaCambiar1 = 'NO';
        $this->mostrarTablaCambiar2 = 'NO';
        $this->mostrarTablaCambiar3 = 'NO';
        $this->selected_plataforma1 = '';
        $this->selected_plataforma2 = '';
        $this->selected_plataforma3 = '';
        $this->selected_cuenta1 = '';
        $this->selected_cuenta2 = '';
        $this->selected_cuenta3 = '';
        $this->planAccount1 = '';
        $this->planAccount2 = '';
        $this->planAccount3 = '';
        $this->selected_accountProf1 = '';
        $this->selected_accountProf2 = '';
        $this->selected_accountProf3 = '';
        $this->clienteID = '';
        $this->expiracionCuenta1 = '';
        $this->expiracionCuenta2 = '';
        $this->expiracionCuenta3 = '';
        $this->PlataformaFiltro = 'TODAS';
        $this->diasdePlan = 30;
        $this->inicioPlanActual = null;
        $this->plataformaPlan = '';
        $this->mesesPlan = '';
        $this->importePlan = '';
        $this->inicioNueva = '';
        $this->start_account = null;
        $this->expiration_account = null;
        $this->comprobante = null;
        $this->selected_perfil = 0;
        $this->selected_accountProf = 0;
        $this->selected_account = 0;
        $this->selected_planAccount = 0;
        $this->selected_platf = 0;
        $this->selected_cliente = 0;

        $this->selected_accountProf1 = 0;
        $this->selected_accountProf2 = 0;
        $this->selected_accountProf3 = 0;

        $this->selected_planAccount1 = 0;
        $this->selected_planAccount2 = 0;
        $this->selected_planAccount3 = 0;

        $this->resetValidation();
    }
}