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
    public $nameperfil, $pin, $status, $availability, $observations,
        $search, $selected_id, $pageTitle, $componentName, $condicional = 'ocupados',
        $meses, $expirationNueva, $expirationPlanActual, $tipopago, $importe,
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
        $this->perfil1ID = '';
        $this->perfil2ID = '';
        $this->perfil3ID = '';
        $this->mostrarTablaCambiar1 = 'NO';
        $this->mostrarTablaCambiar2 = 'NO';
        $this->mostrarTablaCambiar3 = 'NO';
        $this->plataforma1ID = '';
        $this->plataforma2ID = '';
        $this->plataforma3ID = '';
        $this->PERFIL1cuentaID = '';
        $this->PERFIL2cuentaID = '';
        $this->PERFIL3cuentaID = '';
        $this->planAccount1 = '';
        $this->planAccount2 = '';
        $this->planAccount3 = '';
        $this->cuentaPerfil1 = '';
        $this->cuentaPerfil2 = '';
        $this->cuentaPerfil3 = '';
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
                            'c.id as clienteID',
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
                            'c.id as clienteID',
                            'c.nombre as clienteNombre',
                            'c.celular as clienteCelular',
                            'plans.done as done',
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
                            'c.id as clienteID',
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
                            'c.id as clienteID',
                            'c.nombre as clienteNombre',
                            'c.celular as clienteCelular',
                            'plans.done as done',
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
                            'c.id as clienteID',
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
                            'c.id as clienteID',
                            'c.nombre as clienteNombre',
                            'c.celular as clienteCelular',
                            'plans.done as done'
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
                            'c.id as clienteID',
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
                            'c.id as clienteID',
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
            }
        } elseif ($this->condicional == 'combos') {
            $prof = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                ->select(
                    'plans.*',
                    DB::raw('0 as horasPlan'),
                    DB::raw('0 as horasCuenta')
                )
                ->where('plans.status', 'VIGENTE')
                ->where('plans.type_plan', 'COMBO')
                /* ->whereColumn('plans.id', '=', 'ap.plan_id') */
                ->orderBy('plans.created_at', 'desc')
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
        } elseif ($this->condicional == 'combosVencidos') {
            $prof = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                ->select(
                    'plans.*',
                    DB::raw('0 as horasPlan'),
                    DB::raw('0 as horasCuenta')
                )
                ->where('plans.status', 'VENCIDO')
                ->where('plans.type_plan', 'COMBO')
                /* ->whereColumn('plans.id', '=', 'ap.plan_id') */
                ->orderBy('plans.created_at', 'desc')
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
        } else {
            /* CARGAR NOMBRE DE PERFIL, PIN E ID EN LAS VARIABLES */
            foreach ($plan->PlanAccounts as  $value) {
                if ($value->status == 'VENCIDO') {
                    foreach ($value->Cuenta->CuentaPerfiles as  $v) {
                        if ($v->status == 'VENCIDO' && $v->COMBO == 'PERFIL1') {
                            $this->plataforma1Nombre = $v->Cuenta->Plataforma->nombre;
                            $this->perfil1COMBO =  $v->Perfil->nameprofile;
                            $this->PIN1COMBO = $v->Perfil->pin;
                            $this->perfil1ID = $v->Perfil->id;
                        }
                    }
                }
            }
            foreach ($plan->PlanAccounts as  $value) {
                if ($value->status == 'VENCIDO') {
                    foreach ($value->Cuenta->CuentaPerfiles as  $v) {
                        if ($v->status == 'VENCIDO' && $v->COMBO == 'PERFIL2') {
                            $this->plataforma2Nombre = $v->Cuenta->Plataforma->nombre;
                            $this->perfil2COMBO =  $v->Perfil->nameprofile;
                            $this->PIN2COMBO = $v->Perfil->pin;
                            $this->perfil2ID = $v->Perfil->id;
                        }
                    }
                }
            }
            foreach ($plan->PlanAccounts as  $value) {
                if ($value->status == 'VENCIDO') {
                    foreach ($value->Cuenta->CuentaPerfiles as  $v) {
                        if ($v->status == 'VENCIDO' && $v->COMBO == 'PERFIL3') {
                            $this->plataforma3Nombre = $v->Cuenta->Plataforma->nombre;
                            $this->perfil3COMBO =  $v->Perfil->nameprofile;
                            $this->PIN3COMBO = $v->Perfil->pin;
                            $this->perfil3ID = $v->Perfil->id;
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
            'celular.required' => 'El numero de celular del cliente es requerido',
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

    public function AccionesCombo(Plan $plan)
    {
        $this->selected_plan = $plan->id;

        $this->data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
            ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
            ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
            ->select(
                'plans.observations as observations',
                'c.id as clienteID',
                'c.nombre as nombreCliente',
                'c.celular as celular',
                'plans.plan_start as plan_start',
                'plans.expiration_plan as expiration_plan',
                'plans.meses as meses',
                'plans.importe as importe'
            )
            ->where('plans.id', $this->selected_plan)
            ->get()->first();

        $this->nombreCliente = $this->data->nombreCliente;
        $this->celular = $this->data->celular;
        $this->observations = $this->data->observations;
        $this->inicioPlanActual = $this->data->plan_start;
        $this->expirationPlanActual = $this->data->expiration_plan;
        $this->clienteID = $this->data->clienteID;
        $this->mesesPlan = $this->data->meses;
        $this->importePlan = $this->data->importe;
        $this->inicioNueva = strtotime('+' . 1 . ' day', strtotime($this->expirationPlanActual));
        $this->inicioNueva = date('Y-m-d', $this->inicioNueva);

        /* CARGAR NOMBRE DE PERFIL, PIN E ID EN LAS VARIABLES */
        foreach ($plan->PlanAccounts as  $value) {
            if ($value->status == 'ACTIVO') {
                foreach ($value->Cuenta->CuentaPerfiles as  $v) {
                    if ($v->status == 'ACTIVO' && $v->COMBO == 'PERFIL1') {
                        $this->cuentaPerfil1 = $v->id;
                        $this->plataforma1Nombre = $v->Cuenta->Plataforma->nombre;
                        $this->plataforma1ID = $v->Cuenta->Plataforma->id;
                        $this->PERFIL1cuentaID = $v->Cuenta->id;
                        $this->perfil1COMBO =  $v->Perfil->nameprofile;
                        $this->PIN1COMBO = $v->Perfil->pin;
                        $this->perfil1ID = $v->Perfil->id;
                        $this->expiracionCuenta1 = $v->Cuenta->expiration_account;
                    }
                }
            }
        }
        foreach ($plan->PlanAccounts as  $value) {
            if ($value->status == 'ACTIVO') {
                foreach ($value->Cuenta->CuentaPerfiles as  $v) {
                    if ($v->status == 'ACTIVO' && $v->COMBO == 'PERFIL2') {
                        $this->cuentaPerfil2 = $v->id;
                        $this->plataforma2Nombre = $v->Cuenta->Plataforma->nombre;
                        $this->plataforma2ID = $v->Cuenta->Plataforma->id;
                        $this->PERFIL2cuentaID = $v->Cuenta->id;
                        $this->perfil2COMBO =  $v->Perfil->nameprofile;
                        $this->PIN2COMBO = $v->Perfil->pin;
                        $this->perfil2ID = $v->Perfil->id;
                        $this->expiracionCuenta2 = $v->Cuenta->expiration_account;
                    }
                }
            }
        }
        foreach ($plan->PlanAccounts as  $value) {
            if ($value->status == 'ACTIVO') {
                foreach ($value->Cuenta->CuentaPerfiles as  $v) {
                    if ($v->status == 'ACTIVO' && $v->COMBO == 'PERFIL3') {
                        $this->cuentaPerfil3 = $v->id;
                        $this->plataforma3Nombre = $v->Cuenta->Plataforma->nombre;
                        $this->plataforma3ID = $v->Cuenta->Plataforma->id;
                        $this->PERFIL3cuentaID = $v->Cuenta->id;
                        $this->perfil3COMBO =  $v->Perfil->nameprofile;
                        $this->PIN3COMBO = $v->Perfil->pin;
                        $this->perfil3ID = $v->Perfil->id;
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
                DB::raw('0 as cantiadadQueSePuedeCrear'),
            )
            ->where('accounts.status', 'ACTIVO')
            ->where('accounts.availability', 'LIBRE')
            ->where('accounts.expiration_account', '>', $date_now)
            ->where('accounts.id', '!=', $this->PERFIL1cuentaID)
            ->where('p.id', $this->plataforma1ID)
            ->get();

        foreach ($this->cuentasConEspaciosP1 as $c) {
            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $c->id)
                ->where('ap.status', '!=', 'VENCIDO')
                ->where('p.availability', 'OCUPADO')->get();

            $cantidadActivos = $perfilesActivos->count();
            $c->perfActivos = $cantidadActivos;

            $c->cantiadadQueSePuedeCrear = $c->number_profiles - $c->perfActivos;
        }
    }

    public function SeleccionarCuenta1(Account $cuenta)
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
            ->where('ap.COMBO', 'PERFIL1')
            ->whereColumn('plans.id', '=', 'ap.plan_id')
            ->orderby('plans.id', 'desc')
            ->get()->first();

        DB::beginTransaction();
        try {
            /* PONER EN NO LISTO LA ACCION */
            $plan = Plan::find($datos->planid);
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
                'COMBO' => 'PERFIL1',
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
                DB::raw('0 as cantiadadQueSePuedeCrear'),
            )
            ->where('accounts.status', 'ACTIVO')
            ->where('accounts.availability', 'LIBRE')
            ->where('accounts.expiration_account', '>', $date_now)
            ->where('accounts.id', '!=', $this->PERFIL2cuentaID)
            ->where('p.id', $this->plataforma2ID)
            ->get();

        foreach ($this->cuentasConEspaciosP2 as $c) {
            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $c->id)
                ->where('ap.status', '!=', 'VENCIDO')
                ->where('p.availability', 'OCUPADO')->get();

            $cantidadActivos = $perfilesActivos->count();
            $c->perfActivos = $cantidadActivos;

            $c->cantiadadQueSePuedeCrear = $c->number_profiles - $c->perfActivos;
        }
    }

    public function SeleccionarCuenta2(Account $cuenta)
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
            ->where('ap.COMBO', 'PERFIL2')
            ->whereColumn('plans.id', '=', 'ap.plan_id')
            ->orderby('plans.id', 'desc')
            ->get()->first();

        DB::beginTransaction();
        try {
            /* PONER EN NO LISTO LA ACCION */
            $plan = Plan::find($datos->planid);
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
                'COMBO' => 'PERFIL2',
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
                DB::raw('0 as cantiadadQueSePuedeCrear'),
            )
            ->where('accounts.status', 'ACTIVO')
            ->where('accounts.availability', 'LIBRE')
            ->where('accounts.expiration_account', '>', $date_now)
            ->where('accounts.id', '!=', $this->PERFIL3cuentaID)
            ->where('p.id', $this->plataforma3ID)
            ->get();

        foreach ($this->cuentasConEspaciosP3 as $c) {
            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $c->id)
                ->where('ap.status', '!=', 'VENCIDO')
                ->where('p.availability', 'OCUPADO')->get();

            $cantidadActivos = $perfilesActivos->count();
            $c->perfActivos = $cantidadActivos;

            $c->cantiadadQueSePuedeCrear = $c->number_profiles - $c->perfActivos;
        }
    }

    public function SeleccionarCuenta3(Account $cuenta)
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
            ->where('ap.COMBO', 'PERFIL3')
            ->whereColumn('plans.id', '=', 'ap.plan_id')
            ->orderby('plans.id', 'desc')
            ->get()->first();

        DB::beginTransaction();
        try {
            /* PONER EN NO LISTO LA ACCION */
            $plan = Plan::find($datos->planid);
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
                'COMBO' => 'PERFIL3',
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
            'importe.integer' => 'El importe debe ser un numero',
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

        $perfil1 = Profile::find($this->perfil1ID);
        $perfil2 = Profile::find($this->perfil2ID);
        $perfil3 = Profile::find($this->perfil3ID);

        DB::beginTransaction();
        try {
            $mv = Movimiento::create([
                'type' => 'TERMINADO',
                'status' => 'ACTIVO',
                'import' => $this->importe,
                'user_id' => Auth()->user()->id,
            ]);
            foreach ($perfil1->CuentaPerfil as  $value) {
                if ($value->status == 'ACTIVO') {

                    $date_now = date('Y-m-d', time());

                    CuentaInversion::create([
                        'tipo' => 'INGRESO',
                        'cantidad' => $this->importe / 3,
                        'tipoPlan' => 'COMBO',
                        'tipoTransac' => 'RENOVACION',
                        'num_meses' => $this->meses,
                        'fecha_realizacion' => $date_now,
                        'account_id' => $value->Cuenta->id
                    ]);
                }
            }

            foreach ($perfil2->CuentaPerfil as  $value) {
                if ($value->status == 'ACTIVO') {

                    $date_now = date('Y-m-d', time());

                    CuentaInversion::create([
                        'tipo' => 'INGRESO',
                        'cantidad' => $this->importe / 3,
                        'tipoPlan' => 'COMBO',
                        'tipoTransac' => 'RENOVACION',
                        'num_meses' => $this->meses,
                        'fecha_realizacion' => $date_now,
                        'account_id' => $value->Cuenta->id
                    ]);
                }
            }

            foreach ($perfil3->CuentaPerfil as  $value) {
                if ($value->status == 'ACTIVO') {

                    $date_now = date('Y-m-d', time());

                    CuentaInversion::create([
                        'tipo' => 'INGRESO',
                        'cantidad' => $this->importe / 3,
                        'tipoPlan' => 'COMBO',
                        'tipoTransac' => 'RENOVACION',
                        'num_meses' => $this->meses,
                        'fecha_realizacion' => $date_now,
                        'account_id' => $value->Cuenta->id
                    ]);
                }
            }
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


            foreach ($perfil1->CuentaPerfil as  $value) {
                if ($value->status == 'ACTIVO') {
                    PlanAccount::create([
                        'status' => 'ACTIVO',
                        'plan_id' => $plan->id,
                        'account_id' => $value->Cuenta->id,
                    ]);

                    AccountProfile::create([
                        'account_id' => $value->Cuenta->id,
                        'profile_id' => $perfil1->id,
                        'plan_id' => $plan->id,
                        'COMBO' => 'PERFIL1',
                        'status' => 'ACTIVO',
                    ]);
                }
            }
            foreach ($perfil2->CuentaPerfil as  $value) {
                if ($value->status == 'ACTIVO') {
                    PlanAccount::create([
                        'status' => 'ACTIVO',
                        'plan_id' => $plan->id,
                        'account_id' => $value->Cuenta->id,
                    ]);

                    AccountProfile::create([
                        'account_id' => $value->Cuenta->id,
                        'profile_id' => $perfil2->id,
                        'plan_id' => $plan->id,
                        'COMBO' => 'PERFIL2',
                        'status' => 'ACTIVO',
                    ]);
                }
            }
            foreach ($perfil3->CuentaPerfil as  $value) {
                if ($value->status == 'ACTIVO') {
                    PlanAccount::create([
                        'status' => 'ACTIVO',
                        'plan_id' => $plan->id,
                        'account_id' => $value->Cuenta->id,
                    ]);

                    AccountProfile::create([
                        'account_id' => $value->Cuenta->id,
                        'profile_id' => $perfil3->id,
                        'plan_id' => $plan->id,
                        'COMBO' => 'PERFIL3',
                        'status' => 'ACTIVO',
                    ]);
                }
            }


            /* PONER EN VENCIDO EL PLAN ANTERIOR */
            $planviejo = Plan::find($this->selected_plan);
            $planviejo->status = 'VENCIDO';
            $planviejo->save();

            $plansAccount = Plan::join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                ->select('pa.*')
                ->where('plans.id', $this->selected_plan)
                ->get();

            foreach ($plansAccount as $value) {
                $planCuenta = PlanAccount::find($value->id);
                $planCuenta->status = 'VENCIDO';
                $planCuenta->save();
            }

            /* PONER EN VENCIDO ACCOUNTPROFILE ANTERIOR*/
            $cuentaPerfil1 = AccountProfile::find($this->cuentaPerfil1);
            $cuentaPerfil1->status = 'VENCIDO';
            $cuentaPerfil1->save();
            /* PONER EN VENCIDO ACCOUNTPROFILE ANTERIOR*/
            $cuentaPerfil2 = AccountProfile::find($this->cuentaPerfil2);
            $cuentaPerfil2->status = 'VENCIDO';
            $cuentaPerfil2->save();
            /* PONER EN VENCIDO ACCOUNTPROFILE ANTERIOR*/
            $cuentaPerfil3 = AccountProfile::find($this->cuentaPerfil3);
            $cuentaPerfil3->status = 'VENCIDO';
            $cuentaPerfil3->save();

            /* PONER EN OCUPADO EL PERFIL */
            $perfil1->availability = 'OCUPADO';
            $perfil1->save();
            /* PONER EN OCUPADO EL PERFIL */
            $perfil2->availability = 'OCUPADO';
            $perfil2->save();
            /* PONER EN OCUPADO EL PERFIL */
            $perfil3->availability = 'OCUPADO';
            $perfil3->save();

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
                $tigoStreaming = Cartera::where('tipo', 'TigoStreaming')
                    ->where('caja_id', '1')->get()->first();
                CarteraMov::create([
                    'type' => 'INGRESO',
                    'tipoDeMovimiento' => 'STREAMING',
                    'comentario' => '',
                    'cartera_id' => $tigoStreaming->id,
                    'movimiento_id' => $mv->id
                ]);
                $carteraTelefono = Cartera::where('tipo', 'Telefono')
                    ->where('caja_id', $CajaActual->id)->get()->first();
                CarteraMov::create([
                    'type' => 'EGRESO',
                    'tipoDeMovimiento' => 'STREAMING',
                    'comentario' => '',
                    'cartera_id' => $carteraTelefono->id,
                    'movimiento_id' => $mv->id
                ]);
            } elseif ($this->tipopago == 'Banco') {
                $banco = Cartera::where('tipo', 'Banco')
                    ->where('caja_id', '1')->get()->first();
                CarteraMov::create([
                    'type' => 'INGRESO',
                    'tipoDeMovimiento' => 'STREAMING',
                    'comentario' => '',
                    'cartera_id' => $banco->id,
                    'movimiento_id' => $mv->id
                ]);
            } else {
                $tigoStreaming = Cartera::where('tipo', 'TigoStreaming')
                    ->where('caja_id', '1')->get()->first();
                CarteraMov::create([
                    'type' => 'INGRESO',
                    'tipoDeMovimiento' => 'STREAMING',
                    'comentario' => '',
                    'cartera_id' => $tigoStreaming->id,
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
            $perfil1 = Profile::create([
                'nameprofile' => 'emanuel' . rand(100, 999),
                'pin' => rand(1000, 9999),
            ]);
            AccountProfile::create([
                'status' => 'SinAsignar',
                'account_id' => $this->PERFIL1cuentaID,
                'profile_id' => $perfil1->id,
            ]);
            $perfil2 = Profile::create([
                'nameprofile' => 'emanuel' . rand(100, 999),
                'pin' => rand(1000, 9999),
            ]);
            AccountProfile::create([
                'status' => 'SinAsignar',
                'account_id' => $this->PERFIL2cuentaID,
                'profile_id' => $perfil2->id,
            ]);
            $perfil3 = Profile::create([
                'nameprofile' => 'emanuel' . rand(100, 999),
                'pin' => rand(1000, 9999),
            ]);
            AccountProfile::create([
                'status' => 'SinAsignar',
                'account_id' => $this->PERFIL3cuentaID,
                'profile_id' => $perfil3->id,
            ]);

            $planAntiguo = Plan::find($this->selected_plan);
            $planAntiguo->status = 'VENCIDO';
            $planAntiguo->done = 'NO';
            $planAntiguo->observations = $this->observations;
            $planAntiguo->save();

            $plansAccount = Plan::join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                ->select('pa.*')
                ->where('plans.id', $this->selected_plan)
                ->get();

            foreach ($plansAccount as $value) {
                $planCuenta = PlanAccount::find($value->id);
                $planCuenta->status = 'VENCIDO';
                $planCuenta->save();
            }

            /* PONER EN INACTIVO AccountProfile */
            $CuentaPerf1 = AccountProfile::find($this->cuentaPerfil1);
            $CuentaPerf1->status = 'VENCIDO';
            $CuentaPerf1->save();

            $CuentaPerf2 = AccountProfile::find($this->cuentaPerfil2);
            $CuentaPerf2->status = 'VENCIDO';
            $CuentaPerf2->save();

            $CuentaPerf3 = AccountProfile::find($this->cuentaPerfil3);
            $CuentaPerf3->status = 'VENCIDO';
            $CuentaPerf3->save();

            /* PONER EN INACTIVO EL PERFIL */
            $perf = Profile::find($this->perfil1ID);
            $perf->availability = 'VENCIDO';
            $perf->status = 'INACTIVO';
            $perf->save();

            $perf2 = Profile::find($this->perfil2ID);
            $perf2->availability = 'VENCIDO';
            $perf2->status = 'INACTIVO';
            $perf2->save();

            $perf3 = Profile::find($this->perfil3ID);
            $perf3->availability = 'VENCIDO';
            $perf3->status = 'INACTIVO';
            $perf3->save();

            $Cuenta1 = Account::find($this->PERFIL1cuentaID);
            /* CONTAR LOS PERFILES OCUPADOS */
            $perfOcupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $Cuenta1->id)
                ->where('p.availability', 'OCUPADO')->get();
            /* SI LA CUENTA NO TIENE PERFILES OCUPADOS REGRESA A SER ENTERA */
            if ($perfOcupados->count() == 0) {
                $Cuenta1->whole_account = 'ENTERA';
                $Cuenta1->save();
            }

            $Cuenta2 = Account::find($this->PERFIL2cuentaID);
            /* CONTAR LOS PERFILES OCUPADOS */
            $perfOcupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $Cuenta2->id)
                ->where('p.availability', 'OCUPADO')->get();
            /* SI LA CUENTA NO TIENE PERFILES OCUPADOS REGRESA A SER ENTERA */
            if ($perfOcupados->count() == 0) {
                $Cuenta2->whole_account = 'ENTERA';
                $Cuenta2->save();
            }

            $Cuenta3 = Account::find($this->PERFIL3cuentaID);
            /* CONTAR LOS PERFILES OCUPADOS */
            $perfOcupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $Cuenta3->id)
                ->where('p.availability', 'OCUPADO')->get();
            /* SI LA CUENTA NO TIENE PERFILES OCUPADOS REGRESA A SER ENTERA */
            if ($perfOcupados->count() == 0) {
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
            ->join('platforms as p', 'p.id', 'acc.platform_id')
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
                'plans.plan_start as plan_start',
                'plans.expiration_plan as expiration_plan',
                'plans.meses as meses',
                'plans.importe as importe',
                'p.nombre as nombrePlataforma',
            )
            ->where('plans.id', $this->selected_plan)
            ->whereColumn('plans.id', '=', 'ap.plan_id')
            ->where('pa.status', 'ACTIVO')
            ->where('ap.status', 'ACTIVO')
            ->orderby('plans.id', 'desc')
            ->get()->first();

        $this->nameperfil = $this->data->nameprofile;
        $this->pin = $this->data->pin;
        $this->nombreCliente = $this->data->nombreCliente;
        $this->celular = $this->data->celular;
        $this->observations = $this->data->observations;
        $this->inicioPlanActual = $this->data->plan_start;
        $this->expirationPlanActual = $this->data->expiration_plan;
        $this->plataformaPlan = $this->data->nombrePlataforma;
        $this->mesesPlan = $this->data->meses;
        $this->importePlan = $this->data->importe;
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
            'importe.integer' => 'El importe debe ser un numero',
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
            ->where('pa.status', 'ACTIVO')
            ->where('ap.status', 'ACTIVO')
            ->whereColumn('plans.id', '=', 'ap.plan_id')
            ->orderby('plans.id', 'desc')
            ->get()->first();

        $perfil = Profile::find($datos->Profileid);

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

                    $date_now = date('Y-m-d', time());

                    CuentaInversion::create([
                        'tipo' => 'INGRESO',
                        'cantidad' => $this->importe,
                        'tipoPlan' => 'PERFIL',
                        'tipoTransac' => 'RENOVACION',
                        'num_meses' => $this->meses,
                        'fecha_realizacion' => $date_now,
                        'account_id' => $value->Cuenta->id
                    ]);
                }
            }
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
                    'tipoDeMovimiento' => 'STREAMING',
                    'comentario' => '',
                    'cartera_id' => $cajaFisica->id,
                    'movimiento_id' => $mv->id
                ]);
                $tigoStreaming = Cartera::where('tipo', 'TigoStreaming')
                    ->where('caja_id', '1')->get()->first();
                CarteraMov::create([
                    'type' => 'INGRESO',
                    'tipoDeMovimiento' => 'STREAMING',
                    'comentario' => '',
                    'cartera_id' => $tigoStreaming->id,
                    'movimiento_id' => $mv->id
                ]);
                $carteraTelefono = Cartera::where('tipo', 'Telefono')
                    ->where('caja_id', $CajaActual->id)->get()->first();
                CarteraMov::create([
                    'type' => 'EGRESO',
                    'tipoDeMovimiento' => 'STREAMING',
                    'comentario' => '',
                    'cartera_id' => $carteraTelefono->id,
                    'movimiento_id' => $mv->id
                ]);
            } elseif ($this->tipopago == 'Banco') {
                $banco = Cartera::where('tipo', 'Banco')
                    ->where('caja_id', '1')->get()->first();
                CarteraMov::create([
                    'type' => 'INGRESO',
                    'tipoDeMovimiento' => 'STREAMING',
                    'comentario' => '',
                    'cartera_id' => $banco->id,
                    'movimiento_id' => $mv->id
                ]);
            } else {
                $tigoStreaming = Cartera::where('tipo', 'TigoStreaming')
                    ->where('caja_id', '1')->get()->first();
                CarteraMov::create([
                    'type' => 'INGRESO',
                    'tipoDeMovimiento' => 'STREAMING',
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
            $this->emit('item-error', 'No se pudo renovar el plan porque la cuenta de este perfil no ha sido renovada con su proveedor');
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
        $this->emit('item-accion', 'Se plan fue vencido');
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
                ->where('ap.status', '!=', 'VENCIDO')
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

    public function EditObservaciones(Plan $plan, Profile $perfil, Cliente $cliente)
    {
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
            'celular.required' => 'El numero de celular del cliente es requerido',
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
        'SeleccionarCuenta' => 'SeleccionarCuenta'
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
        $this->perfil1ID = '';
        $this->perfil2ID = '';
        $this->perfil3ID = '';
        $this->mostrarTablaCambiar1 = 'NO';
        $this->mostrarTablaCambiar2 = 'NO';
        $this->mostrarTablaCambiar3 = 'NO';
        $this->plataforma1ID = '';
        $this->plataforma2ID = '';
        $this->plataforma3ID = '';
        $this->PERFIL1cuentaID = '';
        $this->PERFIL2cuentaID = '';
        $this->PERFIL3cuentaID = '';
        $this->planAccount1 = '';
        $this->planAccount2 = '';
        $this->planAccount3 = '';
        $this->cuentaPerfil1 = '';
        $this->cuentaPerfil2 = '';
        $this->cuentaPerfil3 = '';
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

        $this->resetValidation();
    }
}
