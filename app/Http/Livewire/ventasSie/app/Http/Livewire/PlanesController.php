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
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PlanesController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $pageTitle = 'Planes', $componentName = 'Streaming';

    public $expiration_plan,  $importe, $search,
        $nombre, $celular, $plataforma, $cuentaperfil, $accounts, $profiles,
        $mostrartabla, $tipopago, $condicional = 'perfiles', $meses, $observaciones, $selected_perf,
        $BuscarCliente, $ClienteSelect, $cuentasEnteras, $nombrePerfil, $pinPerfil,
        $fecha_inicio, $plataforma1, $plataforma2, $plataforma3, $telefonoAnterior, $NombreAnterior, $comprobante;

    private $pagination = 10;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->search = '';

        $this->plataforma = 'Elegir';
        $this->cuentaperfil = 'Elegir';

        $this->nombre = '';
        $this->celular = '';

        $this->importe = '';
        $this->mostrartabla = 0;
        $this->tipopago = 'EFECTIVO';
        $this->meses = 1;
        $this->observaciones = '';

        $this->BuscarCliente = 0;
        $this->ClienteSelect = 0;
        $this->nombrePerfil = '';
        $this->pinPerfil = '';

        $this->cuentasEnteras = [];

        $this->plataforma1 = 'Elegir';
        $this->plataforma2 = 'Elegir';
        $this->plataforma3 = 'Elegir';
        $this->cuentasp1 = [];
        $this->cuentasp2 = [];
        $this->cuentasp3 = [];

        $this->perfil1id = null;
        $this->perfilNombre1 = '';
        $this->perfilPin1 = '
        ';
        $this->perfil2id = null;
        $this->perfilNombre2 = '';
        $this->perfilPin2 = '';

        $this->perfil3id = null;
        $this->perfilNombre3 = '';
        $this->perfilPin3 = '';

        $this->perfiles_si_no = '';
        $this->plataformaReset = 'INICIO';
        $this->plataforma1Require = 'NO';
        $this->plataforma2Require = 'NO';
        $this->plataforma3Require = 'NO';
        /* $this->fecha_inicio = Carbon::parse(Carbon::now())->format('Y-m-d'); */
        $this->fecha_inicio = null;
        $this->expiration_plan = null;
        $this->PerfilCliente = '';
        $this->PinCliente = '';
        $this->Reset1Platf = 'INICIO';
        $this->Reset2Platf = 'INICIO';
        $this->Reset3Platf = 'INICIO';
        $this->mostrartablaCuenta = 'NO';
        $this->mostrartablaPerfiles = 'NO';
        $this->arrayCuentas = array();
        $this->arrayPerfiles = array();
        $this->diasdePlan = 30;

        $this->perfilId = 0;
        $this->clienteId = 0;

        $this->plataforma1Nombre = '';
        $this->perfil1COMBO =  0;
        $this->PIN1COMBO = 0;
        $this->perfil1ID = 0;

        $this->plataforma2Nombre = '';
        $this->perfil2COMBO =  0;
        $this->PIN2COMBO = 0;
        $this->perfil2ID = 0;

        $this->plataforma3Nombre = '';
        $this->perfil3COMBO =  0;
        $this->PIN3COMBO = 0;
        $this->perfil3ID = 0;

        $this->comprobante = null;
        $this->selected_plan = 0;
        $this->selected_planAccount = 0;
        $this->selected_account = 0;
        $this->selected_accountProf = 0;
        $this->selected_perfil = 0;
        $this->selected_platf = 0;
        $this->selected_cliente = 0;

        $this->selected_account1 = 0;
        $this->selected_account2 = 0;
        $this->selected_account3 = 0;

        $this->selected_accountProf1 = 0;
        $this->selected_accountProf2 = 0;
        $this->selected_accountProf3 = 0;
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
        
        /* dd((session('sesionCajaID'))); */

        /* MOSTRAR CARTERAS DE LA CAJA EN LA QUE SE ENCUENTRA */
        $carterasCaja = Cartera::where('caja_id', $cajausuario->id)
            ->orWhere('caja_id', '1')
            ->select('id', 'nombre', DB::raw('0 as monto'))->orderBy('id', 'desc')->get();
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

        if ($this->condicional == 'perfiles') {
            if (strlen($this->search) > 0) {
                $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                    ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                    ->join('accounts as acc', 'acc.id', 'pa.account_id')
                    ->join('account_profiles as ap', 'acc.id', 'ap.account_id')
                    ->join('profiles as prof', 'prof.id', 'ap.profile_id')
                    ->join('emails as e', 'e.id', 'acc.email_id')
                    ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                    ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                    ->select(
                        'plans.id as planid',
                        'plans.plan_start as planinicio',
                        'plans.expiration_plan as planfin',
                        'plans.observations as obs',
                        'plans.status as estado',
                        'plans.ready as ready',
                        'plans.importe as importe',
                        'pa.id as IDplanAccount',
                        'acc.id as IDaccount',
                        'acc.account_name as account_name',
                        'acc.password_account as password_account',
                        'acc.status as accstatus',
                        'acc.expiration_account as accexp',
                        'ap.id as IDaccountProfile',
                        'prof.id as IDperfil',
                        'prof.nameprofile as nameprofile',
                        'prof.pin as pin',
                        'plat.id as IDplatf',
                        'plat.nombre as plataforma',
                        'c.id as clienteID',
                        'c.nombre as cliente',
                        'c.celular as celular',
                        'e.content as correo',
                        'e.pass as passCorreo',
                    )
                    ->where('plat.nombre', 'like', '%' . $this->search . '%')
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'PERFIL')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')

                    ->orWhere('c.nombre', 'like', '%' . $this->search . '%')
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'PERFIL')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')

                    ->orWhere('acc.account_name', 'like', '%' . $this->search . '%')
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'PERFIL')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')

                    ->orWhere('prof.nameprofile', 'like', '%' . $this->search . '%')
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'PERFIL')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')

                    ->orderBy('plans.created_at', 'desc')
                    ->paginate($this->pagination);
            } else {
                $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                    ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                    ->join('accounts as acc', 'acc.id', 'pa.account_id')
                    ->join('account_profiles as ap', 'acc.id', 'ap.account_id')
                    ->join('profiles as prof', 'prof.id', 'ap.profile_id')
                    ->join('emails as e', 'e.id', 'acc.email_id')
                    ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                    ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                    ->select(
                        'plans.id as planid',
                        'plans.plan_start as planinicio',
                        'plans.expiration_plan as planfin',
                        'plans.observations as obs',
                        'plans.status as estado',
                        'plans.ready as ready',
                        'plans.importe as importe',
                        'pa.id as IDplanAccount',
                        'acc.id as IDaccount',
                        'acc.account_name as account_name',
                        'acc.password_account as password_account',
                        'acc.status as accstatus',
                        'acc.expiration_account as accexp',
                        'ap.id as IDaccountProfile',
                        'prof.id as IDperfil',
                        'prof.nameprofile as nameprofile',
                        'prof.pin as pin',
                        'plat.id as IDplatf',
                        'plat.nombre as plataforma',
                        'c.id as clienteID',
                        'c.nombre as cliente',
                        'c.celular as celular',
                        'e.content as correo',
                        'e.pass as passCorreo',
                    )
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'PERFIL')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')
                    ->orderBy('plans.created_at', 'desc')
                    ->paginate($this->pagination);
            }
        } elseif ($this->condicional == 'cuentas') {    /* cuentas */
            if (strlen($this->search) > 0) {
                $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                    ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                    ->join('accounts as acc', 'acc.id', 'pa.account_id')
                    ->join('emails as e', 'e.id', 'acc.email_id')
                    ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                    ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                    ->select(
                        'plans.id as planid',
                        'plans.plan_start as planinicio',
                        'plans.expiration_plan as planfin',
                        'plans.observations as obs',
                        'plans.status as estado',
                        'plans.ready as ready',
                        'plans.importe as importe',
                        'pa.id as IDplanAccount',
                        'acc.id as IDaccount',
                        'acc.account_name as account_name',
                        'acc.password_account as password_account',
                        'acc.status as accstatus',
                        'acc.expiration_account as accexp',
                        'plat.id as IDplatf',
                        'plat.nombre as plataforma',
                        'c.id as clienteID',
                        'c.nombre as cliente',
                        'c.celular as celular',
                        'e.content as correo',
                        'e.pass as passCorreo',
                    )
                    ->where('plat.nombre', 'like', '%' . $this->search . '%')
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'CUENTA')

                    ->orWhere('c.celular', 'like', '%' . $this->search . '%')
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'CUENTA')

                    ->orWhere('c.nombre', 'like', '%' . $this->search . '%')
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'CUENTA')

                    ->orWhere('acc.account_name', 'like', '%' . $this->search . '%')
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'CUENTA')

                    ->orderBy('plans.created_at', 'desc')
                    ->paginate($this->pagination);
            } else {
                $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                    ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                    ->join('accounts as acc', 'acc.id', 'pa.account_id')
                    ->join('emails as e', 'e.id', 'acc.email_id')
                    ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                    ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                    ->select(
                        'plans.id as planid',
                        'plans.plan_start as planinicio',
                        'plans.expiration_plan as planfin',
                        'plans.observations as obs',
                        'plans.status as estado',
                        'plans.ready as ready',
                        'plans.importe as importe',
                        'pa.id as IDplanAccount',
                        'acc.id as IDaccount',
                        'acc.account_name as account_name',
                        'acc.password_account as password_account',
                        'acc.status as accstatus',
                        'acc.expiration_account as accexp',
                        'plat.id as IDplatf',
                        'plat.nombre as plataforma',
                        'c.id as clienteID',
                        'c.nombre as cliente',
                        'c.celular as celular',
                        'e.content as correo',
                        'e.pass as passCorreo',
                    )
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'CUENTA')
                    ->orderBy('plans.created_at', 'desc')
                    ->paginate($this->pagination);
            }
        } elseif ($this->condicional == 'combos') {
            if (strlen($this->search) > 0) {
                $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                    ->join('plan_accounts as pa', 'plans.id', 'pa.plan_id')
                    ->join('accounts as acc', 'acc.id', 'pa.account_id')
                    ->join('emails as e', 'e.id', 'acc.email_id')
                    ->join('platforms as plat', 'plat.id', 'acc.platform_id')
                    ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                    ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                    ->select(
                        'plans.*'
                    )
                    ->where('plat.nombre', 'like', '%' . $this->search . '%')
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'COMBO')

                    ->orWhere('c.celular', 'like', '%' . $this->search . '%')
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'COMBO')

                    ->orWhere('c.nombre', 'like', '%' . $this->search . '%')
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'COMBO')

                    ->orWhere('acc.account_name', 'like', '%' . $this->search . '%')
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'COMBO')

                    ->orderBy('plans.created_at', 'desc')
                    ->distinct()
                    ->paginate($this->pagination);
            } else {
                $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                    ->select(
                        'plans.*'
                    )
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'COMBO')
                    ->orderBy('plans.created_at', 'desc')
                    ->paginate($this->pagination);
            }
        }

        /* CALCULAR LA FECHA DE EXPIRACION SEGUN LA CANTIDAD DE MESES Y DIAS */
        if ($this->selected_plan == 0) {
            if ($this->fecha_inicio) {
                if ($this->diasdePlan >= 1) {
                    if ($this->meses > 0) {
                        $date_now = date('Y-m-d h:i:s', time());
                        $dias = $this->meses * $this->diasdePlan;
                        $this->expiration_plan = strtotime('+' . $dias . ' day', strtotime($this->fecha_inicio));
                        $this->expiration_plan = date('Y-m-d', $this->expiration_plan);
                    } else {
                        $this->meses = 1;
                    }
                }
            }
        }

        /* BUSCAR CLIENTE POR CEDULA EN EL INPUT DEL MODAL */
        $datos = [];
        if ($this->celular != '') {
            $datos = Cliente::where('celular', 'like', $this->celular . '%')->orderBy('celular', 'desc')->get();
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

        /* MOSTRAR SOLO CUENTA ENTERA O CUENTA ENTERA Y PERFILES SEGUN LA PLATAFORMA SELECCIONADA EN EL MODAL*/
        if ($this->plataforma != 'Elegir') {
            $PLATF = Platform::find($this->plataforma);
            if ($PLATF->perfiles == 'SI') {
                $this->perfiles_si_no = 'SI';
            } else {
                $this->perfiles_si_no = 'NO';
            }
        }


        /* RESET tipo cuenta o perfil al cambiar la plataforma */
        if ($this->plataforma != 'Elegir' && $this->plataformaReset == 'INICIO') {
            $this->plataformaReset = $this->plataforma;
        }
        if ($this->plataforma != 'Elegir' && $this->plataforma != $this->plataformaReset) {
            $this->plataformaReset = 'INICIO';
            $this->cuentaperfil = 'Elegir';
            $this->mostrartabla = 0;
            $this->plataforma1Require = 'NO';
            $this->plataforma2Require = 'NO';
            $this->plataforma3Require = 'NO';
            $this->Reset1Platf = 'INICIO';
            $this->Reset2Platf = 'INICIO';
            $this->Reset3Platf = 'INICIO';
            $this->mostrartablaCuenta = 'NO';
            $this->mostrartablaPerfiles = 'NO';
            $this->arrayCuentas = array();
        }


        $date_now = date('Y-m-d', time());

        /* MOSTRAR CUENTAS ENTERAS O PERFILES SEGUN ELIGE EL USUARIO */
        if ($this->plataforma != 'Elegir') {
            if ($this->cuentaperfil == 'ENTERA') {  /* MOSTRAR TODAS LAS CUENTAS ENTERAS LIBRES */
                $this->mostrartabla = 0;

                $this->cuentasLibresEnteras = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                    ->join('emails as e', 'accounts.email_id', 'e.id')
                    ->select(
                        'accounts.*',
                        'p.precioEntera'
                    )
                    ->where('accounts.status', 'ACTIVO')
                    ->where('accounts.expiration_account', '>', $date_now)
                    ->where('accounts.availability', 'LIBRE')
                    ->where('accounts.whole_account', 'ENTERA')
                    ->where('p.id', $this->plataforma)
                    ->get();

                $this->mostrartabla = 1;
            } elseif ($this->cuentaperfil == 'PERFIL') {  /* MOSTRAR LOS PERFILES LIBRES */
                $this->mostrartabla = 0;
                $this->mostrartabla = 2;
                /* CUENTAS CON PERFILES DISPONIBLES */
                $this->cuentasEnteras = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                    ->join('emails as e', 'accounts.email_id', 'e.id')
                    ->join('str_suppliers as strsp', 'accounts.str_supplier_id', 'strsp.id')
                    ->select(
                        'accounts.*',
                        'p.nombre as nombre',
                        'e.content as content',
                        'e.pass as pass',
                        'strsp.name as name',
                        DB::raw('0 as perfOcupados'),
                        DB::raw('0 as espacios'),
                    )
                    ->where('accounts.status', 'ACTIVO')
                    ->where('accounts.availability', 'LIBRE')
                    ->where('accounts.expiration_account', '>', $date_now)
                    ->where('p.id', $this->plataforma)
                    ->orderBy('accounts.expiration_account', 'asc')
                    ->get();

                foreach ($this->cuentasEnteras as $c) {
                    $perfilesOcupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                        ->join('profiles as p', 'ap.profile_id', 'p.id')
                        ->where('accounts.id', $c->id)
                        ->where('ap.status', '!=', 'VENCIDO')
                        ->where('p.availability', 'OCUPADO')->get();

                    $cantidadOcupados = $perfilesOcupados->count();
                    $c->perfOcupados = $cantidadOcupados;

                    $c->espacios = $c->number_profiles - $c->perfOcupados;
                }
            } else {
                $this->accounts = [];
                $this->profiles = [];
            }
        }

        /* RESET de nombre de perfil 1 y pin al cambiar la plataforma 1 */
        if ($this->plataforma1 != 'Elegir' && $this->Reset1Platf == 'INICIO') {
            $this->Reset1Platf = $this->plataforma1;
        }
        if ($this->plataforma1 != 'Elegir' && $this->plataforma1 != $this->Reset1Platf) {
            $this->Reset1Platf = 'INICIO';
            $this->perfil1id = null;
            $this->perfilNombre1 = '';
            $this->perfilPin1 = '';
            $this->plataforma1Require = 'NO';

            $this->Reset2Platf = 'INICIO';
            $this->perfil2id = null;
            $this->perfilNombre2 = '';
            $this->perfilPin2 = '';
            $this->plataforma2Require = 'NO';

            $this->Reset3Platf = 'INICIO';
            $this->perfil3id = null;
            $this->perfilNombre3 = '';
            $this->perfilPin3 = '';
            $this->plataforma3Require = 'NO';

            $this->cuentasp2 = [];
            $this->cuentasp3 = [];
        }

        /* RESET de nombre de perfil 2 y pin al cambiar la plataforma 2 */
        if ($this->plataforma2 != 'Elegir' && $this->Reset2Platf == 'INICIO') {
            $this->Reset2Platf = $this->plataforma2;
        }
        if ($this->plataforma2 != 'Elegir' && $this->plataforma2 != $this->Reset2Platf) {
            $this->Reset1Platf = 'INICIO';
            $this->perfil1id = null;
            $this->perfilNombre1 = '';
            $this->perfilPin1 = '';
            $this->plataforma1Require = 'NO';

            $this->Reset2Platf = 'INICIO';
            $this->perfil2id = null;
            $this->perfilNombre2 = '';
            $this->perfilPin2 = '';
            $this->plataforma2Require = 'NO';

            $this->Reset3Platf = 'INICIO';
            $this->perfil3id = null;
            $this->perfilNombre3 = '';
            $this->perfilPin3 = '';
            $this->plataforma3Require = 'NO';

            $this->cuentasp1 = [];
            $this->cuentasp3 = [];
        }

        /* RESET de nombre de perfil 3 y pin al cambiar la plataforma 3 */
        if ($this->plataforma3 != 'Elegir' && $this->Reset3Platf == 'INICIO') {
            $this->Reset3Platf = $this->plataforma3;
        }
        if ($this->plataforma3 != 'Elegir' && $this->plataforma3 != $this->Reset3Platf) {
            $this->Reset1Platf = 'INICIO';
            $this->perfil1id = null;
            $this->perfilNombre1 = '';
            $this->perfilPin1 = '';
            $this->plataforma1Require = 'NO';

            $this->Reset2Platf = 'INICIO';
            $this->perfil2id = null;
            $this->perfilNombre2 = '';
            $this->perfilPin2 = '';
            $this->plataforma2Require = 'NO';

            $this->Reset3Platf = 'INICIO';
            $this->perfil3id = null;
            $this->perfilNombre3 = '';
            $this->perfilPin3 = '';
            $this->plataforma3Require = 'NO';

            $this->cuentasp1 = [];
            $this->cuentasp2 = [];
        }

        if ($this->plataforma2 == 'Elegir' && $this->plataforma3 == 'Elegir') {
            $platforms1 = Platform::where('estado', 'Activo')->where('perfiles', 'SI')->get();
        } else {
            $platforms1 = Platform::where('estado', 'Activo')
                ->where('perfiles', 'SI')
                ->where('id', '!=', $this->plataforma2)
                ->where('id', '!=', $this->plataforma3)
                ->get();
        }

        /* mostrar cuentas de la plataforma 1 */
        if ($this->plataforma1 != 'Elegir') {
            $platforms2 = Platform::where('estado', 'Activo')
                ->where('perfiles', 'SI')
                ->where('id', '!=', $this->plataforma1)
                ->where('id', '!=', $this->plataforma3)
                ->get();
            $this->cuentasp1 = Account::where('status', 'ACTIVO')
                ->where('accounts.start_account', '<=', $date_now)
                ->where('accounts.expiration_account', '>=', $date_now)
                ->where('availability', 'LIBRE')
                ->where('platform_id', $this->plataforma1)
                ->get();
            foreach ($this->cuentasp1 as $c) {
                $perfilesOcupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                    ->join('profiles as p', 'ap.profile_id', 'p.id')
                    ->select(
                        'accounts.*',
                        DB::raw('0 as perfOcupados'),
                        DB::raw('0 as espacios'),
                    )
                    ->where('accounts.id', $c->id)
                    ->where('p.availability', 'OCUPADO')->get();

                $cantidadOcupados = $perfilesOcupados->count();
                $c->perfOcupados = $cantidadOcupados;

                $c->espacios = $c->number_profiles - $c->perfOcupados;
            }
        } else {
            $this->cuentasp1 = [];
            $platforms2 = [];
        }

        /* mostrar cuentas de la plataforma 2 */
        if ($this->plataforma1 != 'Elegir' && $this->plataforma2 != 'Elegir') {
            $platforms3 = Platform::where('estado', 'Activo')
                ->where('perfiles', 'SI')
                ->where('id', '!=', $this->plataforma1)
                ->where('id', '!=', $this->plataforma2)->get();
            $this->cuentasp2 = Account::where('status', 'ACTIVO')
                ->where('accounts.start_account', '<=', $date_now)
                ->where('accounts.expiration_account', '>=', $date_now)
                ->where('availability', 'LIBRE')
                ->where('platform_id', $this->plataforma2)->get();
            foreach ($this->cuentasp2 as $c) {
                $perfilesOcupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                    ->join('profiles as p', 'ap.profile_id', 'p.id')
                    ->select(
                        'accounts.*',
                        DB::raw('0 as perfOcupados'),
                        DB::raw('0 as espacios'),
                    )
                    ->where('accounts.id', $c->id)
                    ->where('p.availability', 'OCUPADO')->get();

                $cantidadOcupados = $perfilesOcupados->count();
                $c->perfOcupados = $cantidadOcupados;

                $c->espacios = $c->number_profiles - $c->perfOcupados;
            }
        } else {
            $this->cuentasp2 = [];
            $platforms3 = [];
        }
        /* mostrar cuentas de la plataforma 3 */
        if ($this->plataforma1 != 'Elegir' && $this->plataforma2 != 'Elegir' && $this->plataforma3 != 'Elegir') {
            $this->cuentasp3 = Account::where('status', 'ACTIVO')
                ->where('accounts.start_account', '<=', $date_now)
                ->where('accounts.expiration_account', '>=', $date_now)
                ->where('availability', 'LIBRE')
                ->where('platform_id', $this->plataforma3)->get();
            foreach ($this->cuentasp3 as $c) {
                $perfilesOcupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                    ->join('profiles as p', 'ap.profile_id', 'p.id')
                    ->select(
                        'accounts.*',
                        DB::raw('0 as perfOcupados'),
                        DB::raw('0 as espacios'),
                    )
                    ->where('accounts.id', $c->id)
                    ->where('p.availability', 'OCUPADO')->get();

                $cantidadOcupados = $perfilesOcupados->count();
                $c->perfOcupados = $cantidadOcupados;

                $c->espacios = $c->number_profiles - $c->perfOcupados;
            }
        } else {
            $this->cuentasp3 = [];
        }


        return view('livewire.planes.component', [
            'planes' => $data,
            'carterasCaja' => $carterasCaja,
            'datos' => $datos,
            'platforms' => Platform::where('estado', 'Activo')->get(),
            'platforms1' => $platforms1,
            'platforms2' => $platforms2,
            'platforms3' => $platforms3
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    /* Cargar los datos del cliente seleccionado de la tabla a los label */
    public function Seleccionar($celular, $nombre)
    {
        $this->celular = $celular;
        $this->nombre = $nombre;
        $this->ClienteSelect = 0;
    }

    public function CargarAnterior()
    {
        $this->celular = $this->telefonoAnterior;
        $this->nombre = $this->NombreAnterior;
        $this->ClienteSelect = 0;
    }

    /* PONER LA CUENTA SELECCIONADA EN EL SEGUNDA TABLA PARA LA VENTA AÑADIENDO A UN ARREGLO*/
    public function AgregarCuenta(Account $cuenta)
    {
        $this->mostrartablaCuenta = 'SI';
        array_push($this->arrayCuentas, $cuenta->id);
        $this->arrayCuentas = array_unique($this->arrayCuentas);
        $this->accounts = Account::find($this->arrayCuentas);
    }
    
    /* ELIMINAR CUENTA DEL ARREGLO */
    public function QuitarCuenta(Account $cuenta)
    {
        $clave = array_search($cuenta->id, $this->arrayCuentas);
        unset($this->arrayCuentas[$clave]);
        $this->accounts = Account::find($this->arrayCuentas);
    }

    /* PONER PERFILES EN LA SEGUNDA TABLA DESPUES DE SELECCIONAR UNA CUENTA */
    public function AgregarPerfil(Account $cuenta)
    {
        $this->mostrartablaPerfiles = 'SI';

        $perfilCuenta = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
            ->join('profiles as p', 'p.id', 'ap.profile_id')
            ->select('p.*')
            ->where('accounts.id', $cuenta->id)
            ->whereNotIn('p.id', $this->arrayPerfiles)
            ->where('p.availability', 'LIBRE')
            ->where('p.status', 'ACTIVO')->get()->first();
        if ($perfilCuenta) {
            array_push($this->arrayPerfiles, $perfilCuenta->id);
        }
        $this->arrayPerfiles = array_unique($this->arrayPerfiles);
        $this->profiles = Profile::find($this->arrayPerfiles);
    }
    /* ELIMINAR CUENTA DEL ARREGLO */
    public function QuitarPerfil(Profile $perfil)
    {
        $clave = array_search($perfil->id, $this->arrayPerfiles);
        unset($this->arrayPerfiles[$clave]);
        $this->profiles = Profile::find($this->arrayPerfiles);
    }

    public function CrearCombo()
    {
        $this->resetUI();
        $this->importe = 35;
        $this->emit('show-modalCombos', '');
    }

    public function PrimerPerfil(Account $cuenta1)
    {   //CARGAR PERFIL 1 EN LOS INPUT
        $perfil1 = Account::join('account_profiles as ap', 'accounts.id', 'ap.account_id')
            ->join('profiles as p', 'p.id', 'ap.profile_id')
            ->select('p.*', 'ap.id as IDaccProf')
            ->where('accounts.id', $cuenta1->id)
            ->where('p.availability', 'LIBRE')->get()->first();
        $this->perfil1id = $perfil1->id;
        $this->perfilNombre1 = $perfil1->nameprofile;
        $this->perfilPin1 = $perfil1->pin;

        $this->selected_accountProf1 = $perfil1->IDaccProf;

        $this->plataforma1Require = 'SI';
        $this->selected_account1 = $cuenta1->id;
    }

    public function SegundoPerfil(Account $cuenta2)
    {   //CARGAR PERFIL 2 EN LOS INPUT
        $perfil2 = Account::join('account_profiles as ap', 'accounts.id', 'ap.account_id')
            ->join('profiles as p', 'p.id', 'ap.profile_id')
            ->select('p.*', 'ap.id as IDaccProf')
            ->where('accounts.id', $cuenta2->id)
            ->where('p.availability', 'LIBRE')->get()->first();
        $this->perfil2id = $perfil2->id;
        $this->perfilNombre2 = $perfil2->nameprofile;
        $this->perfilPin2 = $perfil2->pin;

        $this->selected_accountProf2 = $perfil2->IDaccProf;

        $this->plataforma2Require = 'SI';
        $this->selected_account2 = $cuenta2->id;
    }

    public function TercerPerfil(Account $cuenta3)
    {   //CARGAR PERFIL 3 EN LOS INPUT
        $perfil3 = Account::join('account_profiles as ap', 'accounts.id', 'ap.account_id')
            ->join('profiles as p', 'p.id', 'ap.profile_id')
            ->select('p.*', 'ap.id as IDaccProf')
            ->where('accounts.id', $cuenta3->id)
            ->where('p.availability', 'LIBRE')->get()->first();
        $this->perfil3id = $perfil3->id;
        $this->perfilNombre3 = $perfil3->nameprofile;
        $this->perfilPin3 = $perfil3->pin;

        $this->selected_accountProf3 = $perfil3->IDaccProf;

        $this->plataforma3Require = 'SI';
        $this->selected_account3 = $cuenta3->id;
    }

    public function venderCombo()
    {
        $rules = [
            'nombre' => 'required|min:4',
            'celular' => 'required|integer|min:8',
            'fecha_inicio' => 'required|not_in:0000-00-00',
            'perfilNombre1' => 'required',
            'perfilPin1' => 'required',
            'perfilNombre2' => 'required',
            'perfilPin2' => 'required',
            'perfilNombre3' => 'required',
            'perfilPin3' => 'required',
            'perfil1id' => 'required_if:plataforma1Require,NO',
            'perfil2id' => 'required_if:plataforma2Require,NO',
            'perfil3id' => 'required_if:plataforma3Require,NO',
            'importe' => 'required|integer|gt:0',
            'meses' => 'required|integer|gt:0',
            'diasdePlan' => 'required|integer|gt:0',
        ];
        $messages = [
            'nombre.required' => 'El nombre del cliente es requerido',
            'nombre.min' => 'El nombre debe tener al menos 4 caracteres',
            'celular.required' => 'El número de celular del cliente es requerido',
            'celular.integer' => 'El celular debe ser un número',
            'perfilNombre1.required' => 'EL nombre del perfil es requerido',
            'perfilPin1.required' => 'El pin es requerido',
            'perfilNombre2.required' => 'EL nombre del perfil es requerido',
            'perfilPin2.required' => 'El pin es requerido',
            'perfilNombre3.required' => 'EL nombre del perfil es requerido',
            'perfilPin3.required' => 'El pin es requerido',
            'fecha_inicio.required' => 'Seleccione una fecha valida',
            'fecha_inicio.not_in' => 'Seleccione una fecha valida',
            'perfil1id.required_if' => 'Seleccione una cuenta de la plataforma 1',
            'perfil2id.required_if' => 'Seleccione una cuenta de la plataforma 2',
            'perfil3id.required_if' => 'Seleccione una cuenta de la plataforma 3',
            'importe.required' => 'El importe es requerido',
            'importe.integer' => 'El importe debe ser un número',
            'importe.gt' => 'El importe debe ser mayor a 0',
            'meses.required' => 'La cantidad de meses es requerido',
            'meses.integer' => 'La cantidad de meses debe ser un número',
            'meses.gt' => 'La cantidad de meses debe ser mayor a 0',
            'diasdePlan.required' => 'La cantidad de dias requerido',
            'diasdePlan.integer' => 'La cantidad de dias debe ser un número',
            'diasdePlan.gt' => 'La cantidad de dias debe ser mayor a 0',
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

        /* Obtener al cliente con EL CELULAR */
        $cliente = Cliente::where('celular', $this->celular)
            ->get()
            ->first();

        DB::beginTransaction();
        try {
            if ($cliente) { /* Actualizar nombre del cliente por el telefono */
                if ($cliente->celular != $this->celular) {
                    $cliente->celular = $this->celular;
                    $cliente->save();
                }
            } else { /* Registrar un nuevo cliente */
                $cliente = Cliente::create([
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
            }

            /* CREAR EL MOVIMIENTO */
            $mv = Movimiento::create([
                'type' => 'TERMINADO',
                'status' => 'ACTIVO',
                'import' => $this->importe,
                'user_id' => Auth()->user()->id,
            ]);

            $date_now = date("Y-m-d H:i");

            // Poner la cuenta del perfil 1 en dividida
            $account1 = Account::find($this->selected_account1);
            $account1->whole_account = 'DIVIDIDA';
            $account1->save();

            CuentaInversion::create([
                'tipo' => 'INGRESO',
                'cantidad' => $this->importe / 3,
                'tipoPlan' => 'COMBO',
                'tipoTransac' => 'VENTA',
                'num_meses' => $this->meses,
                'fecha_realizacion' => $date_now,
                'account_id' => $this->selected_account1
            ]);

            // Poner la cuenta del perfil 2 en dividida
            $account2 = Account::find($this->selected_account2);
            $account2->whole_account = 'DIVIDIDA';
            $account2->save();

            CuentaInversion::create([
                'tipo' => 'INGRESO',
                'cantidad' => $this->importe / 3,
                'tipoPlan' => 'COMBO',
                'tipoTransac' => 'VENTA',
                'num_meses' => $this->meses,
                'fecha_realizacion' => $date_now,
                'account_id' => $this->selected_account2
            ]);


            // Poner la cuenta del perfil 3 en dividida
            $account3 = Account::find($this->selected_account3);
            $account3->whole_account = 'DIVIDIDA';
            $account3->save();

            CuentaInversion::create([
                'tipo' => 'INGRESO',
                'cantidad' => $this->importe / 3,
                'tipoPlan' => 'COMBO',
                'tipoTransac' => 'VENTA',
                'num_meses' => $this->meses,
                'fecha_realizacion' => $date_now,
                'account_id' => $this->selected_account3
            ]);

            /* actualizar los datos de los perfiles si fueron cambiados y ponerlos en ocupado */
            $perfil1 = Profile::find($this->perfil1id);
            $perfil1->update([
                'nameprofile' => $this->perfilNombre1,
                'pin' => $this->perfilPin1,
                'availability' => 'OCUPADO'
            ]);
            $perfil1->save();

            $perfil2 = Profile::find($this->perfil2id);
            $perfil2->update([
                'nameprofile' => $this->perfilNombre2,
                'pin' => $this->perfilPin2,
                'availability' => 'OCUPADO'
            ]);
            $perfil2->save();

            $perfil3 = Profile::find($this->perfil3id);
            $perfil3->update([
                'nameprofile' => $this->perfilNombre3,
                'pin' => $this->perfilPin3,
                'availability' => 'OCUPADO'
            ]);
            $perfil3->save();

            /* CREAR EL PLAN */
            $plan = Plan::create([
                'importe' => $this->importe,
                'plan_start' => $this->fecha_inicio,
                'expiration_plan' => $this->expiration_plan,
                'meses' => $this->meses,
                'ready' => 'NO',
                'status' => 'VIGENTE',
                'type_plan' => 'COMBO',
                'type_pay' => $this->tipopago,
                'observations' => $this->observaciones,
                'movimiento_id' => $mv->id
            ]);

            if ($this->comprobante) {
                $customFileName = uniqid() . '_.' . $this->comprobante->extension();
                $this->comprobante->storeAs('public/planesComprobantes', $customFileName);
                $plan->comprobante = $customFileName;
                $plan->save();
            }

            /* crear plan account para los 3 perfiles con las 3 cuentas */
            PlanAccount::create([
                'status' => 'ACTIVO',
                'COMBO' => 'PERFIL1',
                'plan_id' => $plan->id,
                'account_id' => $account1->id,
            ]);
            PlanAccount::create([
                'status' => 'ACTIVO',
                'COMBO' => 'PERFIL2',
                'plan_id' => $plan->id,
                'account_id' => $account2->id,
            ]);
            PlanAccount::create([
                'status' => 'ACTIVO',
                'COMBO' => 'PERFIL3',
                'plan_id' => $plan->id,
                'account_id' => $account3->id,
            ]);

            /* MODIFICAR REGISTRO ACCONNTPROFILE Y DARLE EL ID DEL PLAN*/
            $accountProfile1 = AccountProfile::find($this->selected_accountProf1);
            $accountProfile1->plan_id = $plan->id;
            $accountProfile1->status = 'ACTIVO';
            $accountProfile1->COMBO = 'PERFIL1';
            $accountProfile1->save();

            $accountProfile2 = AccountProfile::find($this->selected_accountProf2);
            $accountProfile2->plan_id = $plan->id;
            $accountProfile2->status = 'ACTIVO';
            $accountProfile2->COMBO = 'PERFIL2';
            $accountProfile2->save();

            $accountProfile3 = AccountProfile::find($this->selected_accountProf3);
            $accountProfile3->plan_id = $plan->id;
            $accountProfile3->status = 'ACTIVO';
            $accountProfile3->COMBO = 'PERFIL3';
            $accountProfile3->save();

            if ($this->tipopago == 'EFECTIVO') {
                $cajaFisica = Cartera::where('tipo', 'CajaFisica')
                    ->where('caja_id', $cccc->id)->get()->first();
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
                'cliente_id' => $cliente->id
            ]);

            $this->condicional = 'combos';

            DB::commit();
            $this->resetUI();
            $this->emit('hide-modalCombos', 'Plan Registrado');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

    public function Agregar()
    {
        $this->resetUI();
        $this->emit('show-modal', 'show modal!');
    }

    /* Registrar un nuevo plan */
    public function Store()
    {
        $rules = [
            'plataforma' => 'required|not_in:Elegir',
            'cuentaperfil' => 'required|not_in:Elegir',
            'nombre' => 'required|min:4',
            'celular' => 'required|integer|min:8',
            'tipopago' => 'required|not_in:Elegir',
            'fecha_inicio' => 'required|not_in:0000-00-00',
            'expiration_plan' => 'required|not_in:0000-00-00',
            'accounts' => 'required_if:mostrartabla,1',
            'profiles' => 'required_if:mostrartabla,2',
            'importe' => 'required|integer|gt:0',
            'meses' => 'required|integer|gt:0',
            'diasdePlan' => 'required|integer|gt:0',
        ];
        $messages = [
            'plataforma.required' => 'La Plataforma es requerida',
            'plataforma.not_in' => 'Seleccione un valor distinto a Elegir',
            'cuentaperfil.required' => 'El tipo es requerido',
            'cuentaperfil.not_in' => 'Seleccione un valor distinto a Elegir',
            'nombre.required' => 'El nombre del cliente es requerido',
            'nombre.min' => 'El nombre debe tener al menos 4 caracteres',
            'celular.required' => 'El número de celular del cliente es requerido',
            'celular.integer' => 'El celular debe ser un número',
            'celular.min' => 'El celular debe tener 8 dígitos',
            'tipopago.required' => 'El tipo de pago es requerido',
            'tipopago.not_in' => 'Seleccione un valor distinto a Elegir',
            'fecha_inicio.required' => 'Seleccione una fecha valida',
            'fecha_inicio.not_in' => 'Seleccione una fecha valida',
            'expiration_plan.required' => 'Seleccione una fecha valida',
            'expiration_plan.not_in' => 'Seleccione una fecha valida',
            'accounts.required_if' => 'No tiene cuentas seleccionadas',
            'profiles.required_if' => 'Selecciona una cuenta para el perfil',
            'importe.required' => 'El importe es requerido',
            'importe.integer' => 'El importe debe ser un número',
            'importe.gt' => 'El importe debe ser mayor a 0',
            'meses.required' => 'La cantidad de meses es requerido',
            'meses.integer' => 'La cantidad de meses debe ser un número',
            'meses.gt' => 'La cantidad de meses debe ser mayor a 0',
            'diasdePlan.required' => 'La cantidad de dias requerido',
            'diasdePlan.integer' => 'La cantidad de dias debe ser un número',
            'diasdePlan.gt' => 'La cantidad de dias debe ser mayor a 0',
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

        /* Obtener al cliente con EL CELULAR */
        $cliente = Cliente::where('celular', $this->celular)
            ->get()
            ->first();

        DB::beginTransaction();
        try {
            if ($cliente) { /* Actualizar nombre del cliente por el telefono */
                if ($cliente->celular != $this->celular) {
                    $cliente->celular = $this->celular;
                    $cliente->save();
                }
            } else { /* Registrar un nuevo cliente */
                $cliente = Cliente::create([
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
            }

            if ($this->cuentaperfil == 'ENTERA') {
                /* SI SE SELECCIONÓ CUENTA ENTERA */
                foreach ($this->accounts as $accp) {

                    $importeIndividual = $this->importe / $this->accounts->count();
                    /* CREAR EL MOVIMIENTO */
                    $mv = Movimiento::create([
                        'type' => 'TERMINADO',
                        'status' => 'ACTIVO',
                        'import' => $importeIndividual,
                        'user_id' => Auth()->user()->id,
                    ]);
                    /* PONER LA CUENTA EN OCUPADO */
                    $accp->availability = 'OCUPADO';
                    $accp->save();

                    $date_now = date("Y-m-d H:i");

                    CuentaInversion::create([
                        'tipo' => 'INGRESO',
                        'cantidad' => $importeIndividual,
                        'tipoPlan' => 'ENTERA',
                        'tipoTransac' => 'VENTA',
                        'num_meses' => $this->meses,
                        'fecha_realizacion' => $date_now,
                        'account_id' => $accp->id
                    ]);

                    /* CREAR EL PLAN */
                    $plan = Plan::create([
                        'importe' => $importeIndividual,
                        'plan_start' => $this->fecha_inicio,
                        'expiration_plan' => $this->expiration_plan,
                        'meses' => $this->meses,
                        'ready' => 'NO',
                        'status' => 'VIGENTE',
                        'type_plan' => 'CUENTA',
                        'type_pay' => $this->tipopago,
                        'observations' => $this->observaciones,
                        'movimiento_id' => $mv->id,
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
                        'account_id' => $accp->id
                    ]);
                    if ($this->tipopago == 'EFECTIVO') {
                        $cajaFisica = Cartera::where('tipo', 'CajaFisica')
                            ->where('caja_id', $cccc->id)->get()->first();
                        CarteraMov::create([
                            'type' => 'INGRESO',
                            'tipoDeMovimiento' => 'STREAMING',
                            'comentario' => '',
                            'cartera_id' => $cajaFisica->id,
                            'movimiento_id' => $mv->id
                        ]);
                        /* $tigoStreaming = Cartera::where('tipo', 'TigoStreaming')
                            ->where('caja_id', '1')->get()->first();
                        CarteraMov::create([
                            'type' => 'INGRESO',
                            'tipoDeMovimiento' => 'STREAMING',
                            'comentario' => '',
                            'cartera_id' => $tigoStreaming->id,
                            'movimiento_id' => $mv->id
                        ]);
                        $carteraTelefono = Cartera::where('tipo', 'Telefono')
                            ->where('caja_id', $cccc->id)->get()->first();
                        CarteraMov::create([
                            'type' => 'EGRESO',
                            'tipoDeMovimiento' => 'STREAMING',
                            'comentario' => '',
                            'cartera_id' => $carteraTelefono->id,
                            'movimiento_id' => $mv->id
                        ]); */
                    } /* elseif ($this->tipopago == 'Banco') {
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
                    } */
                    ClienteMov::create([
                        'movimiento_id' => $mv->id,
                        'cliente_id' => $cliente->id
                    ]);
                    $this->condicional = 'cuentas';
                }
            } elseif ($this->cuentaperfil == 'PERFIL') {
                /* SI SE SELECCIONÓ PERFIL */
                foreach ($this->profiles as $accp) {

                    $importeIndividual = $this->importe / $this->profiles->count();
                    /* CREAR EL MOVIMIENTO */
                    $mv = Movimiento::create([
                        'type' => 'TERMINADO',
                        'status' => 'ACTIVO',
                        'import' => $importeIndividual,
                        'user_id' => Auth()->user()->id,
                    ]);

                    foreach ($accp->CuentaPerfil as  $value) {
                        if ($value->status == 'SinAsignar') {
                            // Poner la cuenta en dividida
                            $account = Account::find($value->Cuenta->id);
                            $account->whole_account = 'DIVIDIDA';
                            $account->save();

                            $date_now = date("Y-m-d H:i");

                            CuentaInversion::create([
                                'tipo' => 'INGRESO',
                                'cantidad' => $importeIndividual,
                                'tipoPlan' => 'PERFIL',
                                'tipoTransac' => 'VENTA',
                                'num_meses' => $this->meses,
                                'fecha_realizacion' => $date_now,
                                'account_id' => $account->id
                            ]);
                        }
                    }

                    /* PONER EL PERFIL EN OCUPADO */
                    $accp->availability = 'OCUPADO';
                    $accp->save();

                    /* CREAR EL PLAN */
                    $plan = Plan::create([
                        'importe' => $importeIndividual,
                        'plan_start' => $this->fecha_inicio,
                        'expiration_plan' => $this->expiration_plan,
                        'meses' => $this->meses,
                        'ready' => 'NO',
                        'status' => 'VIGENTE',
                        'type_plan' => 'PERFIL',
                        'type_pay' => $this->tipopago,
                        'observations' => $this->observaciones,
                        'movimiento_id' => $mv->id
                    ]);

                    if ($this->comprobante) {
                        $customFileName = uniqid() . '_.' . $this->comprobante->extension();
                        $this->comprobante->storeAs('public/planesComprobantes', $customFileName);
                        $plan->comprobante = $customFileName;
                        $plan->save();
                    }

                    /* crear plan account  */
                    foreach ($accp->CuentaPerfil as  $value) {
                        if ($value->status == 'SinAsignar') {
                            PlanAccount::create([
                                'status' => 'ACTIVO',
                                'plan_id' => $plan->id,
                                'account_id' => $value->Cuenta->id,
                            ]);
                        }
                    }

                    /* MODIFICAR REGISTRO ACCONNTPROFILE Y DARLE EL ID DEL PLAN*/
                    foreach ($accp->CuentaPerfil as  $value) {
                        if ($value->status == 'SinAsignar') {
                            $cuentaPerfil = $value;
                            $cuentaPerfil->plan_id = $plan->id;
                            $cuentaPerfil->status = 'ACTIVO';
                            $cuentaPerfil->save();
                        }
                    }

                    if ($this->tipopago == 'EFECTIVO') {
                        $cajaFisica = Cartera::where('tipo', 'CajaFisica')
                            ->where('caja_id', $cccc->id)->get()->first();
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
                        'cliente_id' => $cliente->id
                    ]);

                    $this->condicional = 'perfiles';
                }
            }
            $this->telefonoAnterior = $this->celular;
            $this->NombreAnterior = $this->nombre;
            DB::commit();
            $this->resetUI();
            $this->emit('item-added', 'Plan Registrado');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

    /* Anular una transacción DE PERFIL */
    public function AnularPerfil(Plan $plan, PlanAccount $planAccount, Account $cuenta, AccountProfile $accountProfile, Profile $perfil)
    {
        DB::beginTransaction();
        try {
            /* PONER EN INACTIVO EL MOVIMIENTO */
            $movimiento = Movimiento::find($plan->movimiento_id);
            $movimiento->status = 'INACTIVO';
            $movimiento->save();

            /* ANULAR PLAN */
            $plan->status = 'ANULADO';
            $plan->save();

            /* PONER EN ANULADO PLANACCOUNT */
            $planAccount->status = 'ANULADO';
            $planAccount->save();

            /* PONER EN ANULADO ACCOUNTPROFILE */
            $accountProfile->status = 'ANULADO';
            $accountProfile->save();

            /* PONER EN ANULADO E INACTIVO EL PERFIL */
            $perfil->status = 'INACTIVO';
            $perfil->availability = 'ANULADO';
            $perfil->save();

            /* crear un nuevo perfil libre en la cuenta donde se anula el plan */
            $perfilNuevo = Profile::create([
                'nameprofile' => 'emanuel' . rand(100, 999),
                'pin' => rand(1000, 9999),
            ]);
            AccountProfile::create([
                'status' => 'SinAsignar',
                'account_id' => $cuenta->id,
                'profile_id' => $perfilNuevo->id,
            ]);

            /* CONTAR LOS PERFILES ACTIVOS DE ESA CUENTA */
            $PERFocupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $cuenta->id)
                ->where('ap.status', 'ACTIVO')
                ->where('p.availability', 'OCUPADO')->get();
            if ($PERFocupados->count() == 0) {
                $cuenta->whole_account = 'ENTERA';
                $cuenta->save();
            }

            DB::commit();
            $this->resetUI();
            $this->emit('item-anulado', 'Se anuló el plan');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

    /* Anular una transacción DE ENTERA */
    public function AnularEntera(Plan $plan, PlanAccount $planAccount, Account $cuenta)
    {
        DB::beginTransaction();
        try {
            $movimiento = Movimiento::find($plan->movimiento_id);
            $movimiento->status = 'INACTIVO';
            $movimiento->save();

            /* PONER EN ANULADO EL PLAN */
            $plan->status = 'ANULADO';
            $plan->save();

            /* PONER EN INACTIVO EL PLANACCOUNT */
            $planAccount->status = 'ANULADO';
            $planAccount->save();

            /* PONER LA CUENTA EN LIBRE Y PONER NUEVA CONTRASEÑA */
            $cuenta->availability = 'LIBRE';
            $cuenta->save();

            DB::commit();
            $this->resetUI();
            $this->emit('item-anulado', 'Se anuló el plan');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

    /* Anular una transacción DE COMBO */
    public function AnularCombo(Plan $plan, PlanAccount $planAccount1, PlanAccount $planAccount2, PlanAccount $planAccount3, Account $cuenta1, Account $cuenta2, Account $cuenta3, AccountProfile $accountProfile1, AccountProfile $accountProfile2, AccountProfile $accountProfile3, Profile $perfil1, Profile $perfil2, Profile $perfil3)
    {
        DB::beginTransaction();
        try {
            /* PONER EN INACTIVO EL MOVIMIENTO */
            $movimiento = Movimiento::find($plan->movimiento_id);
            $movimiento->status = 'INACTIVO';
            $movimiento->save();

            /* ANULAR PLAN */
            $plan->status = 'ANULADO';
            $plan->save();

            /* PONER EN ANULADO PLANACCOUNT 1 */
            $planAccount1->status = 'ANULADO';
            $planAccount1->save();
            /* PONER EN ANULADO PLANACCOUNT 2 */
            $planAccount2->status = 'ANULADO';
            $planAccount2->save();
            /* PONER EN ANULADO PLANACCOUNT 2 */
            $planAccount3->status = 'ANULADO';
            $planAccount3->save();

            /* PONER EN ANULADO ACCOUNTPROFILE 1 */
            $accountProfile1->status = 'ANULADO';
            $accountProfile1->save();
            /* PONER EN ANULADO ACCOUNTPROFILE 2 */
            $accountProfile2->status = 'ANULADO';
            $accountProfile2->save();
            /* PONER EN ANULADO ACCOUNTPROFILE 3 */
            $accountProfile3->status = 'ANULADO';
            $accountProfile3->save();

            /* PONER EN ANULADO E INACTIVO EL PERFIL 1 */
            $perfil1->status = 'INACTIVO';
            $perfil1->availability = 'ANULADO';
            $perfil1->save();
            /* PONER EN ANULADO E INACTIVO EL PERFIL 2 */
            $perfil2->status = 'INACTIVO';
            $perfil2->availability = 'ANULADO';
            $perfil2->save();
            /* PONER EN ANULADO E INACTIVO EL PERFIL 3 */
            $perfil3->status = 'INACTIVO';
            $perfil3->availability = 'ANULADO';
            $perfil3->save();

            /* crear un nuevo perfil libre en la cuenta 1 donde se anula el plan */
            $perfilNuevo = Profile::create([
                'nameprofile' => 'emanuel' . rand(100, 999),
                'pin' => rand(1000, 9999),
            ]);
            AccountProfile::create([
                'status' => 'SinAsignar',
                'account_id' => $cuenta1->id,
                'profile_id' => $perfilNuevo->id,
            ]);
            /* crear un nuevo perfil libre en la cuenta 2 donde se anula el plan */
            $perfilNuevo = Profile::create([
                'nameprofile' => 'emanuel' . rand(100, 999),
                'pin' => rand(1000, 9999),
            ]);
            AccountProfile::create([
                'status' => 'SinAsignar',
                'account_id' => $cuenta2->id,
                'profile_id' => $perfilNuevo->id,
            ]);
            /* crear un nuevo perfil libre en la cuenta 3 donde se anula el plan */
            $perfilNuevo = Profile::create([
                'nameprofile' => 'emanuel' . rand(100, 999),
                'pin' => rand(1000, 9999),
            ]);
            AccountProfile::create([
                'status' => 'SinAsignar',
                'account_id' => $cuenta3->id,
                'profile_id' => $perfilNuevo->id,
            ]);

            /* CONTAR LOS PERFILES ACTIVOS DE LA CUENTA 1 */
            $PERFocupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $cuenta1->id)
                ->where('ap.status', 'ACTIVO')
                ->where('p.availability', 'OCUPADO')->get();
            if ($PERFocupados->count() == 0) {
                $cuenta1->whole_account = 'ENTERA';
                $cuenta1->save();
            }
            /* CONTAR LOS PERFILES ACTIVOS DE LA CUENTA 2 */
            $PERFocupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $cuenta2->id)
                ->where('ap.status', 'ACTIVO')
                ->where('p.availability', 'OCUPADO')->get();
            if ($PERFocupados->count() == 0) {
                $cuenta2->whole_account = 'ENTERA';
                $cuenta2->save();
            }
            /* CONTAR LOS PERFILES ACTIVOS DE LA CUENTA 3 */
            $PERFocupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                ->join('profiles as p', 'ap.profile_id', 'p.id')
                ->where('accounts.id', $cuenta3->id)
                ->where('ap.status', 'ACTIVO')
                ->where('p.availability', 'OCUPADO')->get();
            if ($PERFocupados->count() == 0) {
                $cuenta3->whole_account = 'ENTERA';
                $cuenta3->save();
            }
            DB::commit();
            $this->resetUI();
            $this->emit('item-anulado', 'Se anuló el plan');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

    // MODIFICAR DATOS DEL PLAN SELECCIONADO Y DATOS CLIENTE
    public function VerObservacionesPerfil(Plan $plan, Profile $perfil, Cliente $cliente)
    {
        $this->resetUI();

        $this->selected_plan = $plan->id;
        $this->observaciones = $plan->observations;
        $this->fecha_inicio = $plan->plan_start;
        $this->expiration_plan = $plan->expiration_plan;
        $this->comprobante = $plan->comprobante;

        $this->selected_cliente = $cliente->id;
        $this->nombre = $cliente->nombre;
        $this->celular = $cliente->celular;

        $this->selected_perfil = $perfil->id;
        $this->PerfilCliente = $perfil->nameprofile;
        $this->PinCliente = $perfil->pin;

        $this->emit('show-modal3', 'open modal');
    }

    public function VerObservacionesCuenta(Plan $plan, Cliente $cliente)
    {
        $this->resetUI();

        $this->selected_plan = $plan->id;
        $this->observaciones = $plan->observations;
        $this->fecha_inicio = $plan->plan_start;
        $this->expiration_plan = $plan->expiration_plan;
        $this->comprobante = $plan->comprobante;

        $this->selected_cliente = $cliente->id;
        $this->nombre = $cliente->nombre;
        $this->celular = $cliente->celular;

        $this->emit('show-modal3', 'open modal');
    }

    public function VerObservacionesCombo(Plan $plan, Cliente $cliente, Profile $perfil1, Profile $perfil2, Profile $perfil3, Platform $plataforma1, Platform $plataforma2, Platform $plataforma3)
    {
        $this->resetUI();

        $this->selected_cliente = $cliente->id;
        $this->nombre = $cliente->nombre;
        $this->celular = $cliente->celular;

        $this->plataforma1Nombre = $plataforma1->nombre;
        $this->perfil1COMBO =  $perfil1->nameprofile;
        $this->PIN1COMBO = $perfil1->pin;
        $this->perfil1ID = $perfil1->id;

        $this->plataforma2Nombre = $plataforma2->nombre;
        $this->perfil2COMBO =  $perfil2->nameprofile;
        $this->PIN2COMBO = $perfil2->pin;
        $this->perfil2ID = $perfil2->id;

        $this->plataforma3Nombre = $plataforma3->nombre;
        $this->perfil3COMBO =  $perfil3->nameprofile;
        $this->PIN3COMBO = $perfil3->pin;
        $this->perfil3ID = $perfil3->id;

        $this->selected_plan = $plan->id;
        $this->observaciones = $plan->observations;
        $this->fecha_inicio = $plan->plan_start;
        $this->expiration_plan = $plan->expiration_plan;
        $this->comprobante = $plan->comprobante;

        $this->emit('show-modal3', 'open modal');
    }

    public function Modificar()
    {
        if ($this->condicional == 'perfiles') {
            $rules = [
                'PerfilCliente' => 'required',
                'PinCliente' => 'required',
                'nombre' => 'required|min:4',
                'celular' => 'required|integer|min:8',
                'fecha_inicio' => 'required|not_in:0000-00-00',
                'expiration_plan' => 'required|not_in:0000-00-00',
            ];
            $messages = [
                'PerfilCliente.required' => 'El nombre del perfil es requerido',
                'PinCliente.required' => 'El pin es requerido',
                'nombre.required' => 'El nombre del cliente es requerido',
                'nombre.min' => 'El nombre debe tener al menos 4 caracteres',
                'celular.required' => 'El número de celular del cliente es requerido',
                'celular.integer' => 'El celular debe ser un número',
                'celular.min' => 'El celular debe tener 8 dígitos',
                'fecha_inicio.required' => 'Seleccione una fecha valida',
                'fecha_inicio.not_in' => 'Seleccione una fecha valida',
                'expiration_plan.required' => 'Seleccione una fecha valida',
                'expiration_plan.not_in' => 'Seleccione una fecha valida',
            ];
        } elseif ($this->condicional == 'cuentas') {
            $rules = [
                'nombre' => 'required|min:4',
                'celular' => 'required|integer|min:8',
                'fecha_inicio' => 'required|not_in:0000-00-00',
                'expiration_plan' => 'required|not_in:0000-00-00',
            ];
            $messages = [
                'nombre.required' => 'El nombre del cliente es requerido',
                'nombre.min' => 'El nombre debe tener al menos 4 caracteres',
                'celular.required' => 'El número de celular del cliente es requerido',
                'celular.integer' => 'El celular debe ser un número',
                'celular.min' => 'El celular debe tener 8 dígitos',
                'fecha_inicio.required' => 'Seleccione una fecha valida',
                'fecha_inicio.not_in' => 'Seleccione una fecha valida',
                'expiration_plan.required' => 'Seleccione una fecha valida',
                'expiration_plan.not_in' => 'Seleccione una fecha valida',
            ];
        } elseif ($this->condicional == 'combos') {
            $rules = [
                'perfil1COMBO' => 'required',
                'PIN1COMBO' => 'required',
                'perfil2COMBO' => 'required',
                'PIN2COMBO' => 'required',
                'perfil3COMBO' => 'required',
                'PIN3COMBO' => 'required',
                'nombre' => 'required|min:4',
                'celular' => 'required|integer|min:8',
                'fecha_inicio' => 'required|not_in:0000-00-00',
                'expiration_plan' => 'required|not_in:0000-00-00',
            ];
            $messages = [
                'perfil1COMBO.required' => 'El nombre del perfil es requerido',
                'PIN1COMBO.required' => 'El pin del perfil es requerido',
                'perfil2COMBO.required' => 'El nombre del perfil es requerido',
                'PIN2COMBO.required' => 'El pin del perfil es requerido',
                'perfil3COMBO.required' => 'El nombre del perfil es requerido',
                'PIN3COMBO.required' => 'El pin del perfil es requerido',
                'nombre.required' => 'El nombre del cliente es requerido',
                'nombre.min' => 'El nombre debe tener al menos 4 caracteres',
                'celular.required' => 'El número de celular del cliente es requerido',
                'celular.integer' => 'El celular debe ser un número',
                'celular.min' => 'El celular debe tener 8 dígitos',
                'fecha_inicio.required' => 'Seleccione una fecha valida',
                'fecha_inicio.not_in' => 'Seleccione una fecha valida',
                'expiration_plan.required' => 'Seleccione una fecha valida',
                'expiration_plan.not_in' => 'Seleccione una fecha valida',
            ];
        }
        $this->validate($rules, $messages);

        DB::beginTransaction();
        try {
            $plan = Plan::find($this->selected_plan);
            $plan->observations = $this->observaciones;
            $plan->plan_start = $this->fecha_inicio;
            $plan->expiration_plan = $this->expiration_plan;
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

            $cliente = Cliente::find($this->selected_cliente);
            $cliente->nombre = $this->nombre;
            $cliente->celular = $this->celular;
            $cliente->save();

            if ($this->condicional == 'perfiles') {
                $perfil = Profile::find($this->selected_perfil);
                $perfil->nameprofile = $this->PerfilCliente;
                $perfil->pin = $this->PinCliente;
                $perfil->save();
            } elseif ($this->condicional == 'combos') {
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
            }

            $this->resetUI();
            $this->emit('item-actualizado', 'Se actualizó la información');
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }
    // FIN MODIFICAR DATOS DEL PLAN SELECCIONADO Y DATOS CLIENTE

    public function EditarPerf(Profile $perf)
    {
        $this->selected_perf = $perf->id;
        $this->nombrePerfil = $perf->nameprofile;
        $this->pinPerfil = $perf->pin;
        $this->emit('show-modalPerf', 'open modal');
    }

    public function ModificarPerfil()
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

        DB::beginTransaction();
        try {
            $perfil = Profile::find($this->selected_perf);
            $perfil->nameprofile = $this->nombrePerfil;
            $perfil->pin = $this->pinPerfil;
            $perfil->save();
            $this->nombrePerfil = '';
            $this->pinPerfil = '';
            $this->profiles = Profile::find($this->arrayPerfiles);
            DB::commit();
            $this->emit('perf-actualizado', 'Se actualizó el perfil');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

    protected $listeners = [
        'AnularPerfil' => 'AnularPerfil',
        'AnularEntera' => 'AnularEntera',
        'AnularCombo' => 'AnularCombo',
        'Realizado' => 'Realizado'
    ];

    public function Realizado(Plan $plan)
    {
        DB::beginTransaction();
        try {
            $plan->ready = 'SI';
            $plan->done = 'SI';
            $plan->save();
            $this->resetUI();
            DB::commit();
            $this->emit('perf-actualizado', 'Se cambió a realizado');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

    public function resetUI()
    {
        $this->plataforma = 'Elegir';
        $this->cuentaperfil = 'Elegir';
        $this->nombre = '';
        $this->celular = '';
        $this->nit = 0;
        $this->importe = '';
        $this->mostrartabla = 0;
        $this->tipopago = 'EFECTIVO';
        $this->meses = 1;
        $this->observaciones = '';
        $this->BuscarCliente = 0;
        $this->ClienteSelect = 0;
        $this->nombrePerfil = '';
        $this->pinPerfil = '';
        $this->search = '';
        $this->cuentasEnteras = [];
        $this->plataforma1 = 'Elegir';
        $this->plataforma2 = 'Elegir';
        $this->plataforma3 = 'Elegir';
        $this->cuentasp1 = [];
        $this->cuentasp2 = [];
        $this->cuentasp3 = [];

        $this->perfil1id = null;
        $this->perfilNombre1 = '';
        $this->perfilPin1 = '';
        $this->perfil2id = null;
        $this->perfilNombre2 = '';
        $this->perfilPin2 = '';
        $this->perfil3id = null;
        $this->perfilNombre3 = '';
        $this->perfilPin3 = '';
        $this->perfiles_si_no = '';
        $this->plataformaReset = 'INICIO';
        $this->plataforma1Require = 'NO';
        $this->plataforma2Require = 'NO';
        $this->plataforma3Require = 'NO';
        /* $this->fecha_inicio = Carbon::parse(Carbon::now())->format('Y-m-d'); */
        $this->fecha_inicio = null;
        $this->expiration_plan = null;
        $this->PerfilCliente = '';
        $this->PinCliente = '';
        $this->Reset1Platf = 'INICIO';
        $this->Reset2Platf = 'INICIO';
        $this->Reset3Platf = 'INICIO';
        $this->mostrartablaCuenta = 'NO';
        $this->mostrartablaPerfiles = 'NO';
        $this->arrayCuentas = array();
        $this->arrayPerfiles = array();
        $this->diasdePlan = 30;
        $this->perfilId = 0;
        $this->clienteId = 0;
        $this->plataforma1Nombre = '';
        $this->perfil1COMBO =  0;
        $this->PIN1COMBO = 0;
        $this->perfil1ID = 0;
        $this->plataforma2Nombre = '';
        $this->perfil2COMBO =  0;
        $this->PIN2COMBO = 0;
        $this->perfil2ID = 0;
        $this->plataforma3Nombre = '';
        $this->perfil3COMBO =  0;
        $this->PIN3COMBO = 0;
        $this->perfil3ID = 0;
        $this->comprobante = null;
        $this->selected_plan = 0;
        $this->selected_planAccount = 0;
        $this->selected_account = 0;
        $this->selected_accountProf = 0;
        $this->selected_perfil = 0;
        $this->selected_platf = 0;
        $this->selected_cliente = 0;

        $this->resetValidation();
    }
}