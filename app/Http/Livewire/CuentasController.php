<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\AccountProfile;
use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\ClienteMov;
use App\Models\CuentaInversion;
use App\Models\Email;
use App\Models\Movimiento;
use App\Models\Plan;
use App\Models\PlanAccount;
use App\Models\Platform;
use App\Models\Profile;
use App\Models\StrSupplier;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CuentasController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $platform_id, $email_id, $expiration, $status, $number_profiles, $search, $selected_id,
        $pageTitle, $componentName, $proveedor, $nameP, $PIN, $estado, $availability, $Observaciones,
        $perfiles, $correos, $selected, $start_account, $start_account_new, $expiration_account,
        $expiration_account_new, $password_account, $price, $mostrarCampos, $condicional, $meses, $meseRenovarProv,
        $expirationActual, $expirationNueva, $observations, $selected_plan, $correoCuenta, $passCuenta,
        $nombreCliente, $celular, $observacionesTrans, $mostrarRenovar, $meses_comprados, $mesesComprar,
        $nombre_cuenta, $mostrartabla2, $mostrarCorreo, $mostrarNombreCuenta;
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
        $this->email_id = '';
        $this->platform_id = 'Elegir';
        $this->proveedor = 'Elegir';
        $this->estado = 'ACTIVO';
        $this->availability = 'LIBRE';
        $this->number_profiles = 1;
        $this->nameP = '';
        $this->PIN = '';
        $this->Observaciones = '';
        $this->perfiles = [];
        $this->correos = [];
        $this->nombre_cuenta = '';
        $this->password_account = '';
        $this->price = '';
        $this->mostrarCampos = 0;
        $this->condicional = 'cuentas';
        $this->meses = 0;
        $this->meseRenovarProv = 1;
        $this->expirationNueva = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->start_account = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->tipopago = 'EFECTIVO';
        $this->importe = '';
        $this->correoCuenta = '';
        $this->passCuenta = '';
        $this->nombreCliente = '';
        $this->celular = '';
        $this->observacionesTrans = '';
        $this->mostrarRenovar = 0;
        $this->mesesComprar = 1;
        $this->start_account_new = null;
        $this->expiration_account = null;
        $this->expiration_account_new = null;
        $this->mostrartabla2 = 0;
        $this->passwordGmail = '';
        $this->ClienteSelect = 0;
        $this->BuscarCliente = 0;
        $this->mostrarCorreo = 'NO';
        $this->mostrarNombreCuenta = 'NO';
        $this->mostrarNumPerf = 'NO';
        $this->EnterasDivididas = 'TODOS';
        $this->PlataformaFiltro = 'TODAS';
        $this->diasdePlan = 30;
        $this->inicioCompra = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->expirationCompra = null;
    }
    public function render()
    {
        if ($this->condicional == 'cuentas') {  /* cuentas libres y ocupadas */
            if ($this->EnterasDivididas != 'TODOS') {
                if ($this->PlataformaFiltro != 'TODAS') {
                    if (strlen($this->search) > 0) {
                        $cuentas = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                            ->join('emails as e', 'accounts.email_id', 'e.id')
                            ->join('str_suppliers as strsp', 'accounts.str_supplier_id', 'strsp.id')
                            ->select(
                                'accounts.id as id',
                                'accounts.expiration_account as expiration_account',
                                'accounts.number_profiles',
                                'accounts.whole_account',
                                'accounts.account_name',
                                'accounts.password_account',
                                'p.nombre as nombre',
                                'e.content as content',
                                'e.pass as pass',
                                'strsp.name as name',
                                DB::raw('0 as perfActivos'),
                                DB::raw('0 as perfLibres'),
                                DB::raw('0 as dias')
                            )
                            ->where('p.nombre', 'like', '%' . $this->search . '%')
                            ->where('accounts.status', 'ACTIVO')
                            ->where('accounts.availability', 'LIBRE')

                            ->orWhere('accounts.account_name', 'like', '%' . $this->search . '%')
                            ->where('accounts.status', 'ACTIVO')
                            ->where('accounts.availability', 'LIBRE')

                            ->orWhere('accounts.whole_account', 'like', '%' . $this->search . '%')
                            ->where('accounts.status', 'ACTIVO')
                            ->where('accounts.availability', 'LIBRE')

                            ->orderBy('accounts.expiration_account', 'asc')
                            ->paginate($this->pagination);
                        foreach ($cuentas as $c) {
                            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                                ->join('profiles as p', 'ap.profile_id', 'p.id')
                                ->where('accounts.id', $c->id)
                                ->where('p.status', 'ACTIVO')->get();
                            $perfilesLibres = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                                ->join('profiles as p', 'ap.profile_id', 'p.id')
                                ->where('accounts.id', $c->id)
                                ->where('p.availability', 'LIBRE')
                                ->where('p.status', 'ACTIVO')->get();
                            $cantidadActivos = $perfilesActivos->count();
                            $c->perfActivos = $cantidadActivos;
                            $cantidadLibres = $perfilesLibres->count();
                            $c->perfLibres = $cantidadLibres;

                            $fecha_actual = date("Y-m-d");
                            $s = strtotime($c->expiration_account) - strtotime($fecha_actual);
                            $d = intval($s / 86400);
                            $c->dias = $d;
                        }
                    } else {
                        $cuentas = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                            ->join('emails as e', 'accounts.email_id', 'e.id')
                            ->join('str_suppliers as strsp', 'accounts.str_supplier_id', 'strsp.id')
                            ->select(
                                'accounts.id as id',
                                'accounts.expiration_account as expiration_account',
                                'accounts.number_profiles',
                                'accounts.whole_account',
                                'accounts.account_name',
                                'accounts.password_account',
                                'p.nombre as nombre',
                                'e.content as content',
                                'e.pass as pass',
                                'strsp.name as name',
                                DB::raw('0 as perfOcupados'),
                                DB::raw('0 as perfLibres'),
                                DB::raw('0 as dias')
                            )
                            ->where('accounts.status', 'ACTIVO')
                            ->where('accounts.whole_account', $this->EnterasDivididas)
                            ->where('p.id', $this->PlataformaFiltro)
                            ->where('accounts.availability', 'LIBRE')
                            ->orderBy('accounts.expiration_account', 'asc')
                            ->paginate($this->pagination);
                        foreach ($cuentas as $c) {
                            $perfilesOcupado = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                                ->join('profiles as p', 'ap.profile_id', 'p.id')
                                ->where('accounts.id', $c->id)
                                ->where('p.availability', 'OCUPADO')->get();
                            $perfilesLibres = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                                ->join('profiles as p', 'ap.profile_id', 'p.id')
                                ->where('accounts.id', $c->id)
                                ->where('p.availability', 'LIBRE')
                                ->where('p.status', 'ACTIVO')->get();
                            $cantidadOcupados = $perfilesOcupado->count();
                            $c->perfOcupados = $cantidadOcupados;
                            $cantidadLibres = $perfilesLibres->count();
                            $c->perfLibres = $cantidadLibres;

                            $fecha_actual = date("Y-m-d");
                            $s = strtotime($c->expiration_account) - strtotime($fecha_actual);
                            $d = intval($s / 86400);
                            $c->dias = $d;
                        }
                    }
                } else {
                    if (strlen($this->search) > 0) {
                        $cuentas = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                            ->join('emails as e', 'accounts.email_id', 'e.id')
                            ->join('str_suppliers as strsp', 'accounts.str_supplier_id', 'strsp.id')
                            ->select(
                                'accounts.id as id',
                                'accounts.expiration_account as expiration_account',
                                'accounts.number_profiles',
                                'accounts.whole_account',
                                'accounts.account_name',
                                'accounts.password_account',
                                'p.nombre as nombre',
                                'e.content as content',
                                'e.pass as pass',
                                'strsp.name as name',
                                DB::raw('0 as perfActivos'),
                                DB::raw('0 as perfLibres'),
                                DB::raw('0 as dias')
                            )
                            ->where('p.nombre', 'like', '%' . $this->search . '%')
                            ->where('accounts.status', 'ACTIVO')
                            ->where('accounts.availability', 'LIBRE')

                            ->orWhere('accounts.account_name', 'like', '%' . $this->search . '%')
                            ->where('accounts.status', 'ACTIVO')
                            ->where('accounts.availability', 'LIBRE')

                            ->orWhere('accounts.whole_account', 'like', '%' . $this->search . '%')
                            ->where('accounts.status', 'ACTIVO')
                            ->where('accounts.availability', 'LIBRE')

                            ->orderBy('accounts.expiration_account', 'asc')
                            ->paginate($this->pagination);
                        foreach ($cuentas as $c) {
                            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                                ->join('profiles as p', 'ap.profile_id', 'p.id')
                                ->where('accounts.id', $c->id)
                                ->where('p.status', 'ACTIVO')->get();
                            $perfilesLibres = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                                ->join('profiles as p', 'ap.profile_id', 'p.id')
                                ->where('accounts.id', $c->id)
                                ->where('p.availability', 'LIBRE')
                                ->where('p.status', 'ACTIVO')->get();
                            $cantidadActivos = $perfilesActivos->count();
                            $c->perfActivos = $cantidadActivos;
                            $cantidadLibres = $perfilesLibres->count();
                            $c->perfLibres = $cantidadLibres;

                            $fecha_actual = date("Y-m-d");
                            $s = strtotime($c->expiration_account) - strtotime($fecha_actual);
                            $d = intval($s / 86400);
                            $c->dias = $d;
                        }
                    } else {
                        $cuentas = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                            ->join('emails as e', 'accounts.email_id', 'e.id')
                            ->join('str_suppliers as strsp', 'accounts.str_supplier_id', 'strsp.id')
                            ->select(
                                'accounts.id as id',
                                'accounts.expiration_account as expiration_account',
                                'accounts.number_profiles',
                                'accounts.whole_account',
                                'accounts.account_name',
                                'accounts.password_account',
                                'p.nombre as nombre',
                                'e.content as content',
                                'e.pass as pass',
                                'strsp.name as name',
                                DB::raw('0 as perfOcupados'),
                                DB::raw('0 as perfLibres'),
                                DB::raw('0 as dias')
                            )
                            ->where('accounts.status', 'ACTIVO')
                            ->where('accounts.whole_account', $this->EnterasDivididas)
                            ->where('accounts.availability', 'LIBRE')
                            ->orderBy('accounts.expiration_account', 'asc')
                            ->paginate($this->pagination);
                        foreach ($cuentas as $c) {
                            $perfilesOcupado = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                                ->join('profiles as p', 'ap.profile_id', 'p.id')
                                ->where('accounts.id', $c->id)
                                ->where('p.availability', 'OCUPADO')->get();
                            $perfilesLibres = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                                ->join('profiles as p', 'ap.profile_id', 'p.id')
                                ->where('accounts.id', $c->id)
                                ->where('p.availability', 'LIBRE')
                                ->where('p.status', 'ACTIVO')->get();
                            $cantidadOcupados = $perfilesOcupado->count();
                            $c->perfOcupados = $cantidadOcupados;
                            $cantidadLibres = $perfilesLibres->count();
                            $c->perfLibres = $cantidadLibres;

                            $fecha_actual = date("Y-m-d");
                            $s = strtotime($c->expiration_account) - strtotime($fecha_actual);
                            $d = intval($s / 86400);
                            $c->dias = $d;
                        }
                    }
                }
            } else {
                if ($this->PlataformaFiltro != 'TODAS') {
                    if (strlen($this->search) > 0) {
                        $cuentas = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                            ->join('emails as e', 'accounts.email_id', 'e.id')
                            ->join('str_suppliers as strsp', 'accounts.str_supplier_id', 'strsp.id')
                            ->select(
                                'accounts.id as id',
                                'accounts.expiration_account as expiration_account',
                                'accounts.number_profiles',
                                'accounts.whole_account',
                                'accounts.account_name',
                                'accounts.password_account',
                                'p.nombre as nombre',
                                'e.content as content',
                                'e.pass as pass',
                                'strsp.name as name',
                                DB::raw('0 as perfActivos'),
                                DB::raw('0 as perfLibres'),
                                DB::raw('0 as dias')
                            )
                            ->where('p.nombre', 'like', '%' . $this->search . '%')
                            ->where('accounts.status', 'ACTIVO')
                            ->where('accounts.availability', 'LIBRE')

                            ->orWhere('accounts.account_name', 'like', '%' . $this->search . '%')
                            ->where('accounts.status', 'ACTIVO')
                            ->where('accounts.availability', 'LIBRE')

                            ->orWhere('accounts.whole_account', 'like', '%' . $this->search . '%')
                            ->where('accounts.status', 'ACTIVO')
                            ->where('accounts.availability', 'LIBRE')

                            ->orderBy('accounts.expiration_account', 'asc')
                            ->paginate($this->pagination);
                        foreach ($cuentas as $c) {
                            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                                ->join('profiles as p', 'ap.profile_id', 'p.id')
                                ->where('accounts.id', $c->id)
                                ->where('p.status', 'ACTIVO')->get();
                            $perfilesLibres = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                                ->join('profiles as p', 'ap.profile_id', 'p.id')
                                ->where('accounts.id', $c->id)
                                ->where('p.availability', 'LIBRE')
                                ->where('p.status', 'ACTIVO')->get();
                            $cantidadActivos = $perfilesActivos->count();
                            $c->perfActivos = $cantidadActivos;
                            $cantidadLibres = $perfilesLibres->count();
                            $c->perfLibres = $cantidadLibres;

                            $fecha_actual = date("Y-m-d");
                            $s = strtotime($c->expiration_account) - strtotime($fecha_actual);
                            $d = intval($s / 86400);
                            $c->dias = $d;
                        }
                    } else {
                        $cuentas = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                            ->join('emails as e', 'accounts.email_id', 'e.id')
                            ->join('str_suppliers as strsp', 'accounts.str_supplier_id', 'strsp.id')
                            ->select(
                                'accounts.id as id',
                                'accounts.expiration_account as expiration_account',
                                'accounts.number_profiles',
                                'accounts.whole_account',
                                'accounts.account_name',
                                'accounts.password_account',
                                'p.nombre as nombre',
                                'e.content as content',
                                'e.pass as pass',
                                'strsp.name as name',
                                DB::raw('0 as perfOcupados'),
                                DB::raw('0 as perfLibres'),
                                DB::raw('0 as dias')
                            )
                            ->where('accounts.status', 'ACTIVO')
                            ->where('p.id', $this->PlataformaFiltro)
                            ->where('accounts.availability', 'LIBRE')
                            ->orderBy('accounts.expiration_account', 'asc')
                            ->paginate($this->pagination);
                        foreach ($cuentas as $c) {
                            $perfilesOcupado = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                                ->join('profiles as p', 'ap.profile_id', 'p.id')
                                ->where('accounts.id', $c->id)
                                ->where('p.availability', 'OCUPADO')->get();
                            $perfilesLibres = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                                ->join('profiles as p', 'ap.profile_id', 'p.id')
                                ->where('accounts.id', $c->id)
                                ->where('p.availability', 'LIBRE')
                                ->where('p.status', 'ACTIVO')->get();
                            $cantidadOcupados = $perfilesOcupado->count();
                            $c->perfOcupados = $cantidadOcupados;
                            $cantidadLibres = $perfilesLibres->count();
                            $c->perfLibres = $cantidadLibres;

                            $fecha_actual = date("Y-m-d");
                            $s = strtotime($c->expiration_account) - strtotime($fecha_actual);
                            $d = intval($s / 86400);
                            $c->dias = $d;
                        }
                    }
                } else {
                    if (strlen($this->search) > 0) {
                        $cuentas = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                            ->join('emails as e', 'accounts.email_id', 'e.id')
                            ->join('str_suppliers as strsp', 'accounts.str_supplier_id', 'strsp.id')
                            ->select(
                                'accounts.id as id',
                                'accounts.expiration_account as expiration_account',
                                'accounts.number_profiles',
                                'accounts.whole_account',
                                'accounts.account_name',
                                'accounts.password_account',
                                'p.nombre as nombre',
                                'e.content as content',
                                'e.pass as pass',
                                'strsp.name as name',
                                DB::raw('0 as perfActivos'),
                                DB::raw('0 as perfLibres'),
                                DB::raw('0 as dias')
                            )
                            ->where('p.nombre', 'like', '%' . $this->search . '%')
                            ->where('accounts.status', 'ACTIVO')
                            ->where('accounts.availability', 'LIBRE')

                            ->orWhere('accounts.account_name', 'like', '%' . $this->search . '%')
                            ->where('accounts.status', 'ACTIVO')
                            ->where('accounts.availability', 'LIBRE')

                            ->orWhere('accounts.whole_account', 'like', '%' . $this->search . '%')
                            ->where('accounts.status', 'ACTIVO')
                            ->where('accounts.availability', 'LIBRE')

                            ->orderBy('accounts.expiration_account', 'asc')
                            ->paginate($this->pagination);
                        foreach ($cuentas as $c) {
                            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                                ->join('profiles as p', 'ap.profile_id', 'p.id')
                                ->where('accounts.id', $c->id)
                                ->where('p.status', 'ACTIVO')->get();
                            $perfilesLibres = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                                ->join('profiles as p', 'ap.profile_id', 'p.id')
                                ->where('accounts.id', $c->id)
                                ->where('p.availability', 'LIBRE')
                                ->where('p.status', 'ACTIVO')->get();
                            $cantidadActivos = $perfilesActivos->count();
                            $c->perfActivos = $cantidadActivos;
                            $cantidadLibres = $perfilesLibres->count();
                            $c->perfLibres = $cantidadLibres;

                            $fecha_actual = date("Y-m-d");
                            $s = strtotime($c->expiration_account) - strtotime($fecha_actual);
                            $d = intval($s / 86400);
                            $c->dias = $d;
                        }
                    } else {
                        $cuentas = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                            ->join('emails as e', 'accounts.email_id', 'e.id')
                            ->join('str_suppliers as strsp', 'accounts.str_supplier_id', 'strsp.id')
                            ->select(
                                'accounts.id as id',
                                'accounts.expiration_account as expiration_account',
                                'accounts.number_profiles',
                                'accounts.whole_account',
                                'accounts.account_name',
                                'accounts.password_account',
                                'p.nombre as nombre',
                                'e.content as content',
                                'e.pass as pass',
                                'strsp.name as name',
                                DB::raw('0 as perfOcupados'),
                                DB::raw('0 as perfLibres'),
                                DB::raw('0 as dias')
                            )
                            ->where('accounts.status', 'ACTIVO')
                            ->where('accounts.availability', 'LIBRE')
                            ->orderBy('accounts.expiration_account', 'asc')
                            ->paginate($this->pagination);
                        foreach ($cuentas as $c) {
                            $perfilesOcupado = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                                ->join('profiles as p', 'ap.profile_id', 'p.id')
                                ->where('accounts.id', $c->id)
                                ->where('p.availability', 'OCUPADO')->get();
                            $perfilesLibres = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                                ->join('profiles as p', 'ap.profile_id', 'p.id')
                                ->where('accounts.id', $c->id)
                                ->where('p.availability', 'LIBRE')
                                ->where('p.status', 'ACTIVO')->get();
                            $cantidadOcupados = $perfilesOcupado->count();
                            $c->perfOcupados = $cantidadOcupados;
                            $cantidadLibres = $perfilesLibres->count();
                            $c->perfLibres = $cantidadLibres;

                            $fecha_actual = date("Y-m-d");
                            $s = strtotime($c->expiration_account) - strtotime($fecha_actual);
                            $d = intval($s / 86400);
                            $c->dias = $d;
                        }
                    }
                }
            }
        } elseif ($this->condicional == 'ocupados') { /* cuentas ocupadas enteras */
            if ($this->PlataformaFiltro != 'TODAS') {
                if (strlen($this->search) > 0) {
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
                            'pl.done as done',
                            'accounts.id as id',
                            'accounts.expiration_account as expiration_account',
                            'accounts.number_profiles',
                            'accounts.whole_account',
                            'accounts.status',
                            'accounts.account_name',
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
                            DB::raw('0 as horas'),
                            DB::raw('0 as dias')
                        )
                        ->where('p.nombre', 'like', '%' . $this->search . '%')
                        ->where('pl.status', 'VIGENTE')
                        ->where('pa.status', 'ACTIVO')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pl.ready', 'SI')

                        ->orWhere('c.nombre', 'like', '%' . $this->search . '%')
                        ->where('pl.status', 'VIGENTE')
                        ->where('pa.status', 'ACTIVO')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pl.ready', 'SI')

                        ->orWhere('c.celular', 'like', '%' . $this->search . '%')
                        ->where('pl.status', 'VIGENTE')
                        ->where('pa.status', 'ACTIVO')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pl.ready', 'SI')

                        ->orWhere('accounts.account_name', 'like', '%' . $this->search . '%')
                        ->where('pl.status', 'VIGENTE')
                        ->where('pa.status', 'ACTIVO')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pl.ready', 'SI')

                        ->orderBy('pl.done', 'desc')
                        ->orderBy('pl.expiration_plan', 'asc')
                        ->paginate($this->pagination);
                    foreach ($cuentas as $c) {
                        $date1 = new DateTime($c->expiration_plan);
                        $date2 = new DateTime("now");
                        $diff = $date2->diff($date1);
                        if ($diff->invert != 1) {
                            $c->horas = (($diff->days * 24)) + ($diff->h);
                        } else {
                            $c->horas = '0';
                        }
                        $fecha_actual = date("Y-m-d");
                        $s = strtotime($c->expiration_account) - strtotime($fecha_actual);
                        $d = intval($s / 86400);
                        $c->dias = $d;
                    }
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
                            'pl.done as done',
                            'accounts.id as id',
                            'accounts.expiration_account as expiration_account',
                            'accounts.number_profiles',
                            'accounts.whole_account',
                            'accounts.status',
                            'accounts.account_name',
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
                            DB::raw('0 as horas'),
                            DB::raw('0 as dias')
                        )
                        ->where('pl.status', 'VIGENTE')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pa.status', 'ACTIVO')
                        ->where('pl.ready', 'SI')
                        ->orderBy('pl.done', 'desc')
                        ->where('p.id', $this->PlataformaFiltro)
                        ->orderBy('pl.expiration_plan', 'asc')
                        ->paginate($this->pagination);
                    foreach ($cuentas as $c) {
                        $date1 = new DateTime($c->expiration_plan);
                        $date2 = new DateTime("now");
                        $diff = $date2->diff($date1);
                        if ($diff->invert != 1) {
                            $c->horas = (($diff->days * 24)) + ($diff->h);
                        } else {
                            $c->horas = '-1';
                        }
                        $fecha_actual = date("Y-m-d");
                        $s = strtotime($c->expiration_account) - strtotime($fecha_actual);
                        $d = intval($s / 86400);
                        $c->dias = $d;
                    }
                }
            } else {
                if (strlen($this->search) > 0) {
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
                            'pl.done as done',
                            'accounts.id as id',
                            'accounts.expiration_account as expiration_account',
                            'accounts.number_profiles',
                            'accounts.whole_account',
                            'accounts.status',
                            'accounts.account_name',
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
                            DB::raw('0 as horas'),
                            DB::raw('0 as dias')
                        )
                        ->where('p.nombre', 'like', '%' . $this->search . '%')
                        ->where('pl.status', 'VIGENTE')
                        ->where('pa.status', 'ACTIVO')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pl.ready', 'SI')

                        ->orWhere('c.nombre', 'like', '%' . $this->search . '%')
                        ->where('pl.status', 'VIGENTE')
                        ->where('pa.status', 'ACTIVO')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pl.ready', 'SI')

                        ->orWhere('c.celular', 'like', '%' . $this->search . '%')
                        ->where('pl.status', 'VIGENTE')
                        ->where('pa.status', 'ACTIVO')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pl.ready', 'SI')

                        ->orWhere('accounts.account_name', 'like', '%' . $this->search . '%')
                        ->where('pl.status', 'VIGENTE')
                        ->where('pa.status', 'ACTIVO')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pl.ready', 'SI')

                        ->orderBy('pl.done', 'desc')
                        ->orderBy('pl.expiration_plan', 'asc')
                        ->paginate($this->pagination);
                    foreach ($cuentas as $c) {
                        $date1 = new DateTime($c->expiration_plan);
                        $date2 = new DateTime("now");
                        $diff = $date2->diff($date1);
                        if ($diff->invert != 1) {
                            $c->horas = (($diff->days * 24)) + ($diff->h);
                        } else {
                            $c->horas = '0';
                        }
                        $fecha_actual = date("Y-m-d");
                        $s = strtotime($c->expiration_account) - strtotime($fecha_actual);
                        $d = intval($s / 86400);
                        $c->dias = $d;
                    }
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
                            'pl.done as done',
                            'accounts.id as id',
                            'accounts.expiration_account as expiration_account',
                            'accounts.number_profiles',
                            'accounts.whole_account',
                            'accounts.status',
                            'accounts.account_name',
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
                            DB::raw('0 as horas'),
                            DB::raw('0 as dias')
                        )
                        ->where('pl.status', 'VIGENTE')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pa.status', 'ACTIVO')
                        ->where('pl.ready', 'SI')
                        ->orderBy('pl.done', 'desc')
                        ->orderBy('pl.expiration_plan', 'asc')
                        ->paginate($this->pagination);
                    foreach ($cuentas as $c) {
                        $date1 = new DateTime($c->expiration_plan);
                        $date2 = new DateTime("now");
                        $diff = $date2->diff($date1);
                        if ($diff->invert != 1) {
                            $c->horas = (($diff->days * 24)) + ($diff->h);
                        } else {
                            $c->horas = '-1';
                        }
                        $fecha_actual = date("Y-m-d");
                        $s = strtotime($c->expiration_account) - strtotime($fecha_actual);
                        $d = intval($s / 86400);
                        $c->dias = $d;
                    }
                }
            }
        } elseif ($this->condicional == 'vencidos') {    /* CUENTAS VENCIDAS */
            if ($this->PlataformaFiltro != 'TODAS') {
                if (strlen($this->search) > 0) {
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
                            'pl.done as done',
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
                        ->where('p.nombre', 'like', '%' . $this->search . '%')
                        ->where('pl.status', 'VENCIDO')
                        ->where('pa.status', 'VENCIDO')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pl.ready', 'SI')

                        ->orWhere('c.nombre', 'like', '%' . $this->search . '%')
                        ->where('pl.status', 'VENCIDO')
                        ->where('pa.status', 'VENCIDO')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pl.ready', 'SI')

                        ->orWhere('c.celular', 'like', '%' . $this->search . '%')
                        ->where('pl.status', 'VENCIDO')
                        ->where('pa.status', 'VENCIDO')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pl.ready', 'SI')

                        ->orWhere('e.content', 'like', '%' . $this->search . '%')
                        ->where('pl.status', 'VENCIDO')
                        ->where('pa.status', 'VENCIDO')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pl.ready', 'SI')

                        ->orderBy('pl.done', 'desc')
                        ->orderBy('pl.expiration_plan', 'desc')
                        ->paginate($this->pagination);
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
                            'pl.done as done',
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
                        ->where('pa.status', 'VENCIDO')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pl.ready', 'SI')
                        ->where('p.id', $this->PlataformaFiltro)
                        ->orderBy('pl.done', 'desc')
                        ->orderBy('pl.expiration_plan', 'desc')
                        ->paginate($this->pagination);
                }
            } else {
                if (strlen($this->search) > 0) {
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
                            'pl.done as done',
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
                        ->where('p.nombre', 'like', '%' . $this->search . '%')
                        ->where('pl.status', 'VENCIDO')
                        ->where('pa.status', 'VENCIDO')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pl.ready', 'SI')

                        ->orWhere('c.nombre', 'like', '%' . $this->search . '%')
                        ->where('pl.status', 'VENCIDO')
                        ->where('pa.status', 'VENCIDO')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pl.ready', 'SI')

                        ->orWhere('c.celular', 'like', '%' . $this->search . '%')
                        ->where('pl.status', 'VENCIDO')
                        ->where('pa.status', 'VENCIDO')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pl.ready', 'SI')

                        ->orWhere('e.content', 'like', '%' . $this->search . '%')
                        ->where('pl.status', 'VENCIDO')
                        ->where('pa.status', 'VENCIDO')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pl.ready', 'SI')

                        ->orderBy('pl.done', 'desc')
                        ->orderBy('pl.expiration_plan', 'desc')
                        ->paginate($this->pagination);
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
                            'pl.done as done',
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
                        ->where('pa.status', 'VENCIDO')
                        ->where('pl.type_plan', 'CUENTA')
                        ->where('pl.ready', 'SI')
                        ->orderBy('pl.done', 'desc')
                        ->orderBy('pl.expiration_plan', 'desc')
                        ->paginate($this->pagination);
                }
            }
        } elseif ($this->condicional == 'inhabilitadas') {    /* CUENTAS INHABILITADAS */
            if ($this->PlataformaFiltro != 'TODAS') {
                if (strlen($this->search) > 0) {
                    /* $cuentas = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                    ->join('emails as e', 'accounts.email_id', 'e.id')
                    ->join('str_suppliers as strsp', 'accounts.str_supplier_id', 'strsp.id')
                    ->select(
                        'accounts.id as id',
                        'accounts.expiration_account as expiration_account',
                        'accounts.number_profiles',
                        'accounts.whole_account',
                        'accounts.account_name',
                        'accounts.password_account',
                        'p.nombre as nombre',
                        'e.content as content',
                        'e.pass as pass',
                        'strsp.name as name',
                        DB::raw('0 as perfActivos'),
                        DB::raw('0 as perfLibres'),
                        DB::raw('0 as dias')
                    )
                    ->where('p.nombre', 'like', '%' . $this->search . '%')
                    ->where('accounts.status', 'ACTIVO')
                    ->where('accounts.availability', 'LIBRE')

                    ->orWhere('accounts.account_name', 'like', '%' . $this->search . '%')
                    ->where('accounts.status', 'ACTIVO')
                    ->where('accounts.availability', 'LIBRE')

                    ->orWhere('accounts.whole_account', 'like', '%' . $this->search . '%')
                    ->where('accounts.status', 'ACTIVO')
                    ->where('accounts.availability', 'LIBRE')

                    ->orderBy('accounts.expiration_account', 'asc')
                    ->paginate($this->pagination);
                foreach ($cuentas as $c) {
                    $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                        ->join('profiles as p', 'ap.profile_id', 'p.id')
                        ->where('accounts.id', $c->id)
                        ->where('p.status', 'ACTIVO')->get();
                    $perfilesLibres = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                        ->join('profiles as p', 'ap.profile_id', 'p.id')
                        ->where('accounts.id', $c->id)
                        ->where('p.availability', 'LIBRE')
                        ->where('p.status', 'ACTIVO')->get();
                    $cantidadActivos = $perfilesActivos->count();
                    $c->perfActivos = $cantidadActivos;
                    $cantidadLibres = $perfilesLibres->count();
                    $c->perfLibres = $cantidadLibres;

                    $fecha_actual = date("Y-m-d");
                    $s = strtotime($c->expiration_account) - strtotime($fecha_actual);
                    $d = intval($s / 86400);
                    $c->dias = $d;
                } */
                } else {
                    $cuentas = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                        ->join('emails as e', 'accounts.email_id', 'e.id')
                        ->join('str_suppliers as strsp', 'accounts.str_supplier_id', 'strsp.id')
                        ->select(
                            'accounts.id as id',
                            'accounts.expiration_account as expiration_account',
                            'accounts.number_profiles',
                            'accounts.whole_account',
                            'accounts.account_name',
                            'accounts.password_account',
                            'p.nombre as nombre',
                            'e.content as content',
                            'e.pass as pass',
                            'strsp.name as name',
                            DB::raw('0 as horas'),
                            DB::raw('0 as dias')
                        )
                        ->where('accounts.status', 'INACTIVO')
                        ->where('accounts.availability', 'LIBRE')
                        ->where('p.id', $this->PlataformaFiltro)
                        ->orderBy('accounts.expiration_account', 'asc')
                        ->paginate($this->pagination);
                    foreach ($cuentas as $c) {
                        $date1 = new DateTime($c->expiration_plan);
                        $date2 = new DateTime("now");
                        $diff = $date2->diff($date1);
                        if ($diff->invert != 1) {
                            $c->horas = (($diff->days * 24)) + ($diff->h);
                        } else {
                            $c->horas = '-1';
                        }
                        $fecha_actual = date("Y-m-d");
                        $s = strtotime($c->expiration_account) - strtotime($fecha_actual);
                        $d = intval($s / 86400);
                        $c->dias = $d;
                    }
                }
            } else {
                if (strlen($this->search) > 0) {
                    /* $cuentas = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                    ->join('emails as e', 'accounts.email_id', 'e.id')
                    ->join('str_suppliers as strsp', 'accounts.str_supplier_id', 'strsp.id')
                    ->select(
                        'accounts.id as id',
                        'accounts.expiration_account as expiration_account',
                        'accounts.number_profiles',
                        'accounts.whole_account',
                        'accounts.account_name',
                        'accounts.password_account',
                        'p.nombre as nombre',
                        'e.content as content',
                        'e.pass as pass',
                        'strsp.name as name',
                        DB::raw('0 as perfActivos'),
                        DB::raw('0 as perfLibres'),
                        DB::raw('0 as dias')
                    )
                    ->where('p.nombre', 'like', '%' . $this->search . '%')
                    ->where('accounts.status', 'ACTIVO')
                    ->where('accounts.availability', 'LIBRE')

                    ->orWhere('accounts.account_name', 'like', '%' . $this->search . '%')
                    ->where('accounts.status', 'ACTIVO')
                    ->where('accounts.availability', 'LIBRE')

                    ->orWhere('accounts.whole_account', 'like', '%' . $this->search . '%')
                    ->where('accounts.status', 'ACTIVO')
                    ->where('accounts.availability', 'LIBRE')

                    ->orderBy('accounts.expiration_account', 'asc')
                    ->paginate($this->pagination);
                foreach ($cuentas as $c) {
                    $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                        ->join('profiles as p', 'ap.profile_id', 'p.id')
                        ->where('accounts.id', $c->id)
                        ->where('p.status', 'ACTIVO')->get();
                    $perfilesLibres = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                        ->join('profiles as p', 'ap.profile_id', 'p.id')
                        ->where('accounts.id', $c->id)
                        ->where('p.availability', 'LIBRE')
                        ->where('p.status', 'ACTIVO')->get();
                    $cantidadActivos = $perfilesActivos->count();
                    $c->perfActivos = $cantidadActivos;
                    $cantidadLibres = $perfilesLibres->count();
                    $c->perfLibres = $cantidadLibres;

                    $fecha_actual = date("Y-m-d");
                    $s = strtotime($c->expiration_account) - strtotime($fecha_actual);
                    $d = intval($s / 86400);
                    $c->dias = $d;
                } */
                } else {
                    $cuentas = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                        ->join('emails as e', 'accounts.email_id', 'e.id')
                        ->join('str_suppliers as strsp', 'accounts.str_supplier_id', 'strsp.id')
                        ->select(
                            'accounts.id as id',
                            'accounts.expiration_account as expiration_account',
                            'accounts.number_profiles',
                            'accounts.whole_account',
                            'accounts.account_name',
                            'accounts.password_account',
                            'p.nombre as nombre',
                            'e.content as content',
                            'e.pass as pass',
                            'strsp.name as name',
                            DB::raw('0 as horas'),
                            DB::raw('0 as dias')
                        )
                        ->where('accounts.status', 'INACTIVO')
                        ->where('accounts.availability', 'LIBRE')
                        ->orderBy('accounts.expiration_account', 'asc')
                        ->paginate($this->pagination);
                    foreach ($cuentas as $c) {
                        $date1 = new DateTime($c->expiration_plan);
                        $date2 = new DateTime("now");
                        $diff = $date2->diff($date1);
                        if ($diff->invert != 1) {
                            $c->horas = (($diff->days * 24)) + ($diff->h);
                        } else {
                            $c->horas = '-1';
                        }
                        $fecha_actual = date("Y-m-d");
                        $s = strtotime($c->expiration_account) - strtotime($fecha_actual);
                        $d = intval($s / 86400);
                        $c->dias = $d;
                    }
                }
            }
        }

        /* MOSTRAR CORREO O NOMBRE DE LA CUENTA DEPENDIENDO LA PLATAFORMA */
        if ($this->platform_id != 'Elegir') {
            $platform = Platform::find($this->platform_id);
            if ($platform->tipo == 'USUARIO') {
                $this->email_id = '';
                $this->passwordGmail = '';
                $this->mostrarCorreo = 'NO';
                $this->mostrarNombreCuenta = 'SI';
            } else {
                $this->nombre_cuenta = '';
                $this->mostrarCorreo = 'SI';
                $this->mostrarNombreCuenta = 'NO';
            }
            //MOSTRAR O NO NUMERO DE PERFILES DEPENDIENDO LA PLATAFORMA
            if ($platform->perfiles == 'SI') {
                $this->mostrarNumPerf = 'SI';
            } else {
                $this->number_profiles = 1;
                $this->mostrarNumPerf = 'NO';
            }
        }



        /* BUSCAR correo POR email EN EL INPUT DEL MODAL */
        $datos = [];
        if ($this->email_id != '') {
            $datos = Email::select('emails.*')
                ->where('content', 'like', $this->email_id . '%')
                ->where('availability', 'LIBRE')
                ->where('status', 'ACTIVO')
                ->where('content', '!=', 'Sin Correo')
                ->orderBy('id', 'desc')->get();
            if ($datos->count() > 0) {
                $this->BuscarCliente = 1;
            } else {
                $this->BuscarCliente = 0;
            }
            if ($this->ClienteSelect == 0) {
                $this->BuscarCliente = 0;
            }
        } else {
            $this->BuscarCliente = 0;
            if ($this->ClienteSelect == 0) {
                $this->ClienteSelect = 1;
            }
        }

        /* MOSTRAR CREAR O NO PERFILES EN UNA CUENTA SELECCIONADA */
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
                ->where('profiles.status', 'ACTIVO')
                ->where('a.id', $this->selected_id)
                ->get();

            $cuenta = Account::find($this->selected_id);
            /* CONTAR LOS PERFILES ACTIVOS Y DE LA CUENTA */
            $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $this->selected_id)
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

        /* CALCULAR FECHA DE FINALIZACION AL CREAR UNA NUEVA CUENTA */
        if ($this->start_account) {
            if ($this->mesesComprar > 0 && $this->mostrarRenovar == 0) {
                $dias = $this->mesesComprar * 30;
                $this->expiration_account = strtotime('+' . $dias . ' day', strtotime($this->start_account));
                $this->expiration_account = date('Y-m-d', $this->expiration_account);
            }
        }
        /* MOSTRAR UNA NUEVA FECHA DE EXPIRACION SEGUN EL NUMERO DE MESES QUE ESCRIBA EL USUARIO EN RENOVAR PLAN*/
        if ($this->diasdePlan > 0) {
            if ($this->meses > 0) {
                $dias = $this->meses * $this->diasdePlan;
                $this->expirationNueva = strtotime('+' . $dias . ' day', strtotime($this->expirationActual));
                $this->expirationNueva = date('Y-m-d', $this->expirationNueva);
            } else {
                $this->expirationNueva = $this->expirationActual;
            }
        }
        /* CALCULAR LOS DIAS SEGUN LOS MESES QUE PONGA EL USUARIO PARA RENOVAR CON EL PROVEEDOR */
        if ($this->start_account_new) {
            if ($this->diasdePlan > 0) {
                if ($this->meseRenovarProv > 0) {
                    $dias = $this->meseRenovarProv * $this->diasdePlan;
                    $this->expiration_account_new = strtotime('+' . $dias . ' day', strtotime($this->start_account_new));
                    $this->expiration_account_new = date('Y-m-d', $this->expiration_account_new);
                } else {
                    $this->expiration_account_new = $this->start_account_new;
                }
            }
        }

        return view('livewire.cuentas.component', [
            'cuentas' => $cuentas,
            'datos' => $datos,
            'plataformas' => Platform::where('estado', 'ACTIVO')->orderBy('nombre', 'asc')->get(),
            'proveedores' => StrSupplier::where('status', 'ACTIVO')->orderBy('id', 'asc')->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    /* Cargar los datos del correo seleccionado de la tabla */
    public function Seleccionar($content, $password)
    {
        $this->email_id = $content;
        $this->passwordGmail = $password;
        $this->ClienteSelect = 0;
    }

    /* ABRIR MODAL PARA RENOVAR Y VENCER CUENTA CON EL PROVEEDOR */
    public function mostrarRenovar(Account $cuenta)
    {
        $this->resetUI();
        $this->mostrarRenovar = 1;
        $this->selected_id = $cuenta->id;
        $this->start_account = $cuenta->start_account;
        $this->expiration_account = $cuenta->expiration_account;
        $this->meseRenovarProv = 1;
        $this->email_id = $cuenta->account_name;
        $this->number_profiles = $cuenta->number_profiles;
        $this->price = $cuenta->price;
        $this->password_account = $cuenta->password_account;
        $this->meses_comprados = $cuenta->meses_comprados;
        $this->emit('details3-show', 'show modal!');
    }

    public function RenovarCuenta()
    {   /* RENOVAR LA CUENTA CON EL PROVEEDOR SEGUN LOS MESES QUE PONE EL USUARIO */
        $rules = [
            'start_account_new' => 'required',
            'expiration_account_new' => 'required',
            'number_profiles' => 'required',
            'price' => 'required',
            'password_account' => 'required',
            'meseRenovarProv' => 'required|integer|gt:0',
            'diasdePlan' => 'required|integer|gt:0',
        ];
        $messages = [
            'start_account_new.required' => 'La nueva fecha de inicio es requerida',
            'expiration_account_new.required' => 'La nueva fecha de expiración es requerida',
            'number_profiles.required' => 'La cantidad de perfiles es requerida',
            'price.required' => 'El precio de la cuenta es requerida',
            'meseRenovarProv.required' => 'Los meses a renovar son requeridos si va a renovar',
            'meseRenovarProv.integer' => 'Los meses deben ser un número',
            'meseRenovarProv.gt' => 'Los meses a renovar deben ser minimo 1',
            'diasdePlan.required' => 'Los dias a renovar son requeridos si va a renovar',
            'diasdePlan.integer' => 'Los dias deben ser un número',
            'diasdePlan.gt' => 'Los dias a renovar deben ser minimo 1',
        ];
        /* OBTENER FECHA 30 DIAS DESPUES DE LA FECHA INICIO PARA LA PRIMERA INVERSION */
        /* $dias = 30;
        $fecha30diasdespues = strtotime('+' . $dias . ' day', strtotime($this->start_account_new));
        $fecha30diasdespues = date('Y-m-d', $fecha30diasdespues); */
        /* DIVIDIR EL PRECIO DE LA CUENTA PARA LAS INVERSIONES SEGUN LA CANTIDAD DE MESES */
        $this->validate($rules, $messages);
        /* $this->price /= $this->meseRenovarProv; */
        $cuenta = Account::find($this->selected_id);

        $cuenta->update([
            'status' => 'ACTIVO',
            'start_account' => $this->start_account_new,
            'expiration_account' => $this->expiration_account_new,
            'number_profiles' => $this->number_profiles,
            'password_account' => $this->password_account,
            'price' => $this->price,
            'meses_comprados' => $this->meseRenovarProv,
        ]);

        $date_now = date('Y-m-d', time());

        CuentaInversion::create([
            'tipo' => 'EGRESO',
            'cantidad' => $this->price,
            'fecha_realizacion' => $date_now,
            'account_id' => $cuenta->id,
        ]);

        /* CREAR LA MISMA CANTIDAD DE INVERSIONES QUE DE MESES EN LA RENOVACION */
        /* for ($i = 0; $i < $this->meseRenovarProv; $i++) {
            if ($i == 0) {
                CuentaInversion::create([
                    'start_date' => $this->start_account_new,
                    'expiration_date' => $fecha30diasdespues,
                    'price' => $this->price,
                    'number_profiles' => $this->number_profiles,
                    'sale_profiles' => 0,
                    'imports' => 0,
                    'ganancia' => - ($this->price),
                    'account_id' => $cuenta->id,
                ]);
            } else {
                if ($i == 1) {
                    $this->start_account_new = strtotime('+' . 1 . ' day', strtotime($fecha30diasdespues));
                    $this->start_account_new = date('Y-m-d', $this->start_account_new);
                } else {
                    $this->start_account_new = strtotime('+' . 1 . ' day', strtotime($this->expiration_account_new));
                    $this->start_account_new = date('Y-m-d', $this->start_account_new);
                }
                $dias = 30;

                $this->expiration_account_new = strtotime('+' . $dias . ' day', strtotime($this->start_account_new));
                $this->expiration_account_new = date('Y-m-d', $this->expiration_account_new);

                CuentaInversion::create([
                    'start_date' => $this->start_account_new,
                    'expiration_date' => $this->expiration_account_new,
                    'price' => $this->price,
                    'number_profiles' => $this->number_profiles,
                    'sale_profiles' => 0,
                    'imports' => 0,
                    'ganancia' => - ($this->price),
                    'account_id' => $cuenta->id,
                ]);
            }
        } */

        $this->resetUI();
        $this->emit('modal-hide3', 'Cuenta Actualizada');
    }

    public function Store()
    {   /* REGISTRAR UNA NUEVA CUENTA */
        $rules = [
            'start_account' => 'required',
            'expiration_account' => 'required',
            'number_profiles' => 'required',
            'price' => 'required',
            'password_account' => 'required',
            'platform_id' => 'required|not_in:Elegir',
            'proveedor' => 'required|not_in:Elegir',
            'email_id' => 'required_if:mostrarCorreo,0|not_in:Elegir',
        ];
        $messages = [
            'start_account.required' => 'La fecha de inicio es requerida',
            'expiration_account.required' => 'La fecha de expiración es requerida',
            'number_profiles.required' => 'La cantidad de perfiles es requerida',
            'price.required' => 'El precio de la cuenta es requerida',
            'password_account.required' => 'La contraseña de la cuenta es requerida',
            'platform_id.required' => 'La plataforma es requerida',
            'platform_id.not_in' => 'Elija una plataforma distinta a Elegir',
            'email_id.required_if' => 'El correo es requerido',
            'email_id.not_in' => 'El correo debe ser distinto de Elegir',
            'proveedor.required' => 'El proveedor es requerido',
            'proveedor.not_in' => 'El proveedor tiene que ser diferente de Elegir',
        ];

        $this->validate($rules, $messages);
        if ($this->email_id != '') {
            $correo = Email::where('content', $this->email_id)
                ->get()->first();
        } elseif ($this->email_id == '') {
            $correo = Email::find(1)
                ->get()->first();
        }

        DB::beginTransaction();
        try {
            if ($correo) {
            } else {
                $correo = Email::create([
                    'content' => $this->email_id,
                    'pass' => $this->passwordGmail,
                ]);
            }
            if ($correo->id != 1) {
                $correo->availability = 'OCUPADO';
                $correo->save();
            }

            $plataform = Platform::find($this->platform_id);
            if ($plataform->tipo == 'CORREO') {
                $acc = Account::create([
                    'start_account' => $this->start_account,
                    'expiration_account' => $this->expiration_account,
                    'status' => $this->estado,
                    'whole_account' => 'ENTERA',
                    'number_profiles' => $this->number_profiles,
                    'account_name' => $correo->content,
                    'password_account' => $this->password_account,
                    'price' => $this->price,
                    'meses_comprados' => $this->mesesComprar,
                    'str_supplier_id' => $this->proveedor,
                    'platform_id' => $this->platform_id,
                    'email_id' => $correo->id,
                ]);
            } else {
                $acc = Account::create([
                    'start_account' => $this->start_account,
                    'expiration_account' => $this->expiration_account,
                    'status' => $this->estado,
                    'whole_account' => 'ENTERA',
                    'number_profiles' => $this->number_profiles,
                    'account_name' => $this->nombre_cuenta,
                    'password_account' => $this->password_account,
                    'price' => $this->price,
                    'meses_comprados' => $this->mesesComprar,
                    'str_supplier_id' => $this->proveedor,
                    'platform_id' => $this->platform_id,
                    'email_id' => $correo->id,
                ]);
            }

            /* CREAR PERFILES VACIOS */
            for ($i = 0; $i < $this->number_profiles; $i++) {
                $perfil = Profile::create([
                    'nameprofile' => 'emanuel' . rand(100, 999),
                    'pin' => rand(1000, 9999),
                ]);
                AccountProfile::create([
                    'status' => 'SinAsignar',
                    'account_id' => $acc->id,
                    'profile_id' => $perfil->id,
                ]);
            }

            $date_now = date('Y-m-d', time());

            CuentaInversion::create([
                'tipo' => 'EGRESO',
                'cantidad' => $this->price,
                'fecha_realizacion' => $date_now,
                'account_id' => $acc->id,
            ]);

            /* $this->price /= $this->mesesComprar;
            $dias = 30;
            $fecha30diasdespues = strtotime('+' . $dias . ' day', strtotime($this->start_account));
            $fecha30diasdespues = date('Y-m-d', $fecha30diasdespues);
            for ($i = 0; $i < $this->mesesComprar; $i++) {
                if ($i == 0) {
                    CuentaInversion::create([
                        'start_date' => $this->start_account,
                        'expiration_date' => $fecha30diasdespues,
                        'price' => $this->price,
                        'number_profiles' => $this->number_profiles,
                        'sale_profiles' => 0,
                        'imports' => 0,
                        'ganancia' => - ($this->price),
                        'account_id' => $acc->id,
                    ]);
                } else {
                    if ($i == 1) {
                        $this->start_account = strtotime('+' . 1 . ' day', strtotime($fecha30diasdespues));
                        $this->start_account = date('Y-m-d', $this->start_account);
                    } else {
                        $this->start_account = strtotime('+' . 1 . ' day', strtotime($this->expiration_account));
                        $this->start_account = date('Y-m-d', $this->start_account);
                    }

                    $dias = 30;

                    $this->expiration_account = strtotime('+' . $dias . ' day', strtotime($this->start_account));
                    $this->expiration_account = date('Y-m-d', $this->expiration_account);

                    CuentaInversion::create([
                        'start_date' => $this->start_account,
                        'expiration_date' => $this->expiration_account,
                        'price' => $this->price,
                        'number_profiles' => $this->number_profiles,
                        'sale_profiles' => 0,
                        'imports' => 0,
                        'ganancia' => - ($this->price),
                        'account_id' => $acc->id,
                    ]);
                }
            } */

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
        /* MOSTRAR CORREO O NOMBRE DE LA CUENTA DEPENDIENDO LA PLATAFORMA */
        $platform = Platform::find($acc->Plataforma->id);
        if ($platform->tipo == 'USUARIO') {
            $this->email_id = '';
            $this->passwordGmail = '';
            $this->mostrarCorreo = 'NO';
            $this->mostrarNombreCuenta = 'SI';
        } else {
            $this->nombre_cuenta = '';
            $this->mostrarCorreo = 'SI';
            $this->mostrarNombreCuenta = 'NO';
        }

        $this->selected_id = $acc->id;
        $this->selected = $acc->email_id;
        $this->expiration_account = $acc->expiration_account;
        $this->estado = $acc->status;
        $this->number_profiles = $acc->number_profiles;
        $this->nombre_cuenta = $acc->account_name;
        $this->passwordGmail = $acc->Correo->pass;
        $this->password_account = $acc->password_account;
        $this->price = $acc->price;
        $this->proveedor = $acc->str_supplier_id;
        $this->platform_id = $acc->platform_id;
        $this->email_id = $acc->Correo->content;
        $this->emit('modal-show', 'show modal!');
    }

    public function Update()
    {
        $rules = [
            'password_account' => 'required',
            'passwordGmail' => 'required_if:mostrarCorreo,SI',
        ];

        $messages = [
            'password_account.required' => 'La contraseña de la cuenta es requerida',
            'passwordGmail.required_if' => 'La contraseña del correo es requerida',
        ];

        $this->validate($rules, $messages);

        $acc = Account::find($this->selected_id);
        $plataform = Platform::find($this->platform_id);

        $correo = Email::find($acc->Correo->id);
        $correo->update([
            'pass' => $this->passwordGmail,
        ]);
        $correo->save();

        if ($plataform->tipo == 'CORREO') {
            $acc->update([
                'password_account' => $this->password_account,
            ]);
            $acc->save();
        } else {
            $acc->update([
                'account_name' => $this->nombre_cuenta,
                'password_account' => $this->password_account,
            ]);
            $acc->save();
        }

        $this->resetUI();
        $this->emit('item-updated', 'Cuenta Actualizada');
    }

    public function InhabilitarCuenta(Account $cuenta)
    {
        $cuenta->status = 'INACTIVO';
        $cuenta->save();
        $this->emit('item-deleted', 'La cuenta se inhabilitó');
    }

    public function Crear(Account $acc)
    {
        $this->selected_id = $acc->id;

        $this->emit('details-show', 'show modal!');
    }

    public function Acciones(Plan $plan)
    {
        $this->selected_plan = $plan->id;
        /* OBTENER FECHA DE EXPIRACION DEL PLAN PARA CALCULAR LA FECHA DE EXPIRACION NUEVA */
        $this->data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
            ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
            ->join('accounts as acc', 'acc.id', 'pa.account_id')
            ->join('emails as e', 'e.id', 'acc.email_id')
            ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
            ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
            ->select(
                'c.nombre as nombreCliente',
                'c.celular as celular',
                'e.content as correoCuenta',
                'acc.account_name as account_name',
                'acc.password_account as password_account',
                'plans.expiration_plan as expiration_plan',
                'plans.observations as observations'
            )
            ->where('plans.id', $this->selected_plan)
            ->orderby('plans.id', 'desc')
            ->get()->first();
        $this->nombreCliente = $this->data->nombreCliente;
        $this->celular = $this->data->celular;
        $this->correoCuenta = $this->data->account_name;
        $this->passCuenta = $this->data->password_account;
        $this->observacionesTrans = $this->data->observations;
        $this->expirationActual = $this->data->expiration_plan;

        $this->emit('details2-show', 'show modal!');
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
        try {
            $caja = Caja::find($CajaActual->id);
        } catch (Exception $e) {
            $this->emit('item-error', "NO TIENE UNA CAJA ABIERTA PARA RENOVAR");
            return;
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

        $cuenta = Account::find($datos->cuentaid);
        /* CALCULAR IMPORTE SEGUN LA PLATAFORMA DE LA CUENTA */
        DB::beginTransaction();
        try {
            $mv = Movimiento::create([
                'type' => 'TERMINADO',
                'status' => 'ACTIVO',
                'import' => $this->importe,
                'user_id' => Auth()->user()->id,
            ]);

            /* ENCONTRAR INVERSION */
            /* $inversioncuenta = CuentaInversion::where('start_date', '<=', $this->expirationActual)
                ->where('expiration_date', '>=', $this->expirationActual)
                ->where('account_id', $cuenta->id)
                ->get()->first();

            $inversioncuenta->type = 'CUENTA';
            $inversioncuenta->imports = $this->importe;
            $inversioncuenta->ganancia = $this->importe - $inversioncuenta->price;
            $inversioncuenta->save(); */

            $date_now = date('Y-m-d', time());

            CuentaInversion::create([
                'tipo' => 'INGRESO',
                'cantidad' => $this->importe,
                'tipoPlan' => 'ENTERA',
                'fecha_realizacion' => $date_now,
                'account_id' => $cuenta->id,
            ]);

            $plan = Plan::create([
                'importe' => $this->importe,
                'plan_start' => $this->expirationActual,
                'expiration_plan' => $this->expirationNueva,
                'ready' => 'SI',
                'done' => 'NO',
                'type_plan' => 'CUENTA',
                'status' => 'VIGENTE',
                'type_pay' => $this->tipopago,
                'observations' => $this->observacionesTrans,
                'movimiento_id' => $mv->id
            ]);

            PlanAccount::create([
                'status' => 'ACTIVO',
                'plan_id' => $plan->id,
                'account_id' => $cuenta->id,
            ]);

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

            /* PONER EN VENCIDO EL PLAN ANTIGUO */
            $planviejo = Plan::find($datos->planid);
            $planviejo->status = 'VENCIDO';
            $planviejo->save();

            /* PONER EN INACTIVO EL PLAN ACCOUNT */
            $planCuenta = PlanAccount::find($datos->planAccountid);
            $planCuenta->status = 'VENCIDO';
            $planCuenta->save();

            DB::commit();
            $this->resetUI();
            $this->emit('cuenta-renovado-vencida', 'Se renovó la cuenta');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
            $this->emit('item-error', 'No se pudo renovar el plan porque la cuenta no ha sido renovada con su proveedor');
        }
    }

    public function Vencer()
    {
        /* OBTENER IDS */
        $datos = Plan::join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
            ->join('accounts as acc', 'acc.id', 'pa.account_id')
            ->select(
                'acc.id as cuentaid',
                'pa.id as paid',
            )
            ->where('plans.id', $this->selected_plan)
            ->get()->first();
        /* PONER EN VENCIDO EL PLAN */
        $plan = Plan::find($this->selected_plan);
        $plan->status = 'VENCIDO';
        $plan->done = 'NO';
        $plan->observations = $this->observacionesTrans;
        $plan->save();
        /* PONER LA CUENTA EN LIBRE */
        $cuenta = Account::find($datos->cuentaid);
        $cuenta->availability = 'LIBRE';
        $cuenta->save();
        /* PONER EL PLANACCOUNT EN VENCIDO */
        $plancuenta = PlanAccount::find($datos->paid);
        $plancuenta->status = 'VENCIDO';
        $plancuenta->save();

        $this->resetUI();
        $this->emit('cuenta-renovado-vencida', 'No se renovó esta cuenta y ahora esta libre');
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
                'acc.id as cuentaid',
                'acc.number_profiles as number_profiles'
            )
            ->where('plans.id', $this->selected_plan)
            ->where('pa.status', 'ACTIVO')
            ->orderby('plans.id', 'desc')
            ->get()->first();
        $date_now = date('Y-m-d', time());

        $this->cuentasEnteras = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
            ->join('emails as e', 'accounts.email_id', 'e.id')
            ->select(
                'accounts.*'
            )
            ->where('accounts.status', 'ACTIVO')
            ->where('accounts.start_account', '<=', $date_now)
            ->where('accounts.expiration_account', '>=', $date_now)
            ->where('accounts.availability', 'LIBRE')
            ->where('accounts.whole_account', 'ENTERA')
            ->where('p.id', $datos->platfid)
            ->where('accounts.number_profiles', $datos->number_profiles)
            ->get();
    }
    public function VerCuentas()
    {
        $this->emit('show-crearPerfil', 'show modal!');
    }

    public function SeleccionarCuenta(Account $cuenta)
    {
        $rules = [
            'nombrePerfil' => 'required',
            'pinPerfil' => 'required',

        ];
        $messages = [
            'nombrePerfil.required' => 'El nombre del perfil es requerido',
            'pinPerfil.required' => 'El pin es requerido',
        ];

        $this->validate($rules, $messages);

        $perfil = Profile::create([
            'nameprofile' => $this->nombrePerfil,
            'pin' => $this->pinPerfil,
            'status' => 'ACTIVO',
            'availability' => 'LIBRE',
            'observations' => '',
        ]);
        AccountProfile::create([
            'status' => 'SinAsignar',
            'account_id' => $cuenta->id,
            'profile_id' => $perfil->id,
        ]);
        /* LA CUENTA PASA A DIVIDIDA */
        $cuenta->whole_account = 'DIVIDIDA';
        $cuenta->save();

        $this->nombrePerfil = '';
        $this->pinPerfil = '';

        $plataforma = $perfil->CuentaPerfil->Cuenta->Plataforma->id;

        $cuentaVieja = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
            ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
            ->join('accounts as acc', 'acc.id', 'pa.account_id')
            ->select(
                'acc.id as cuentaid',
            )
            ->where('plans.id', $this->selected_plan)
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
            ->where('p.id', $plataforma)
            ->where('a.id', '!=', $cuentaVieja->cuentaid)
            ->get()->first();

        $this->emit('crearperfil-cerrar', 'Se creó el perfil en la cuenta seleccionada');
    }

    protected $listeners = [
        'borrarPerfil' => 'BorrarPerfil',
        'Vencer' => 'Vencer',
        'Realizado' => 'Realizado',
        'CambiarAccount' => 'CambiarAccount',
        'InhabilitarCuenta' => 'InhabilitarCuenta'
    ];

    public function CambiarAccount(Account $cuenta)
    {
        /* DATOS DEL ANTERIOR PLAN */
        $datos = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
            ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
            ->join('accounts as acc', 'acc.id', 'pa.account_id')
            ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
            ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
            ->select(
                'c.*',
                'plans.id as planid',
                'pa.id as planAccountid',
                'acc.id as cuentaid',
            )
            ->where('plans.id', $this->selected_plan)
            ->where('pa.status', 'ACTIVO')
            ->orderby('pa.id', 'desc')
            ->get()->first();
        DB::beginTransaction();
        try {
            /* PONER EN NO LISTO LA ACCION */
            $plan = Plan::find($datos->planid);
            $plan->done = 'NO';
            $plan->observations = $this->observations;
            $plan->save();

            /* OBTENER LA CUENTA NUEVA */
            $CuentaNueva = Account::find($cuenta->id);
            $CuentaNueva->availability = 'OCUPADO';
            $CuentaNueva->save();

            /* CAMBIAR A LIBRE LA CUENTA ANTERIOR */
            $cuentaAnterior = Account::find($datos->cuentaid);
            $cuentaAnterior->availability = 'LIBRE';
            $cuentaAnterior->save();

            /* PONER EN CAMBIADO EL PLAN-ACCOUNT */
            $planAccountVIEJO = PlanAccount::find($datos->planAccountid);
            $planAccountVIEJO->update([
                'status' => 'CAMBIADO',
            ]);
            /* CREAR NUEVO PLAN-ACCOUNT */
            PlanAccount::create([
                'plan_id' => $datos->planid,
                'account_id' => $CuentaNueva->id,
            ]);

            DB::commit();
            $this->resetUI();
            $this->emit('item-accion', 'Se cambio de cuenta');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }
    public function Realizado(Plan $plan)
    {
        $plan->done = 'SI';
        $plan->save();
        $this->resetUI();
        $this->emit('item-accion', 'Se cambio a realizado');
    }

    public function resetUI()
    {
        $this->selected_id = 0;
        $this->selected_plan = 0;
        $this->selected = 0;
        $this->email_id = '';
        $this->platform_id = 'Elegir';
        $this->proveedor = 'Elegir';
        $this->estado = 'ACTIVO';
        $this->availability = 'LIBRE';
        $this->number_profiles = 1;
        $this->nameP = '';
        $this->PIN = '';
        $this->Observaciones = '';
        $this->perfiles = [];
        $this->correos = [];
        $this->nombre_cuenta = '';
        $this->password_account = '';
        $this->price = '';
        $this->mostrarCampos = 0;
        $this->meses = 0;
        $this->meseRenovarProv = 1;
        $this->expirationNueva = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->start_account = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->tipopago = 'EFECTIVO';
        $this->importe = '';
        $this->correoCuenta = '';
        $this->passCuenta = '';
        $this->nombreCliente = '';
        $this->celular = '';
        $this->observacionesTrans = '';
        $this->mostrarRenovar = 0;
        $this->mesesComprar = 1;
        $this->start_account_new = null;
        $this->expiration_account = null;
        $this->expiration_account_new = null;
        $this->mostrartabla2 = 0;
        $this->passwordGmail = '';
        $this->ClienteSelect = 0;
        $this->BuscarCliente = 0;
        $this->mostrarCorreo = 'NO';
        $this->mostrarNombreCuenta = 'NO';
        $this->mostrarNumPerf = 'NO';
        $this->diasdePlan = 30;
        $this->resetValidation();
    }
}
