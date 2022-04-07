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
use Livewire\WithPagination;

class PlanesController extends Component
{
    use WithPagination;

    public $expiration_plan, $status,  $importe, $pageTitle, $componentName, $selected_id, $hora, $search,
        $condicion, $type, $nombre, $celular, $plataforma, $cuentaperfil, $accounts, $profiles, $cantidaperf,
        $mostrartabla, $tipopago, $condicional, $meses, $observaciones, $ready, $selected_perf, $totalCobrar,
        $BuscarCliente, $ClienteSelect, $cuentasEnteras, $nombrePerfil, $pinPerfil, $CantidadPerfilesCrear,
        $fecha_inicio, $plataforma1, $plataforma2, $plataforma3, $perfilplataforma1, $perfilplataforma2,
        $perfilplataforma3;

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
        $this->ready = 'NINGUNA';
        $this->totalCobrar = 0;
        $this->BuscarCliente = 0;
        $this->ClienteSelect = 0;
        $this->nombrePerfil = '';
        $this->pinPerfil = '';
        $this->search = '';
        $this->cuentasEnteras = [];
        $this->CantidadPerfilesCrear = 0;
        $this->plataforma1 = 'Elegir';
        $this->plataforma2 = 'Elegir';
        $this->plataforma3 = 'Elegir';
        $this->cuentasp1 = [];
        $this->cuentasp2 = [];
        $this->cuentasp3 = [];
        $this->perfilplataforma1 = 0;
        $this->perfilplataforma2 = 0;
        $this->perfilplataforma3 = 0;
        $this->perfil1id = 0;
        $this->perfilNombre1 = '';
        $this->perfilPin1 = '';
        $this->perfil2id = 0;
        $this->perfilNombre2 = '';
        $this->perfilPin2 = '';
        $this->perfil3id = 0;
        $this->perfilNombre3 = '';
        $this->perfilPin3 = '';
        $this->perfiles_si_no = '';
        $this->plataformaReset = 'INICIO';
    }

    public function render()
    {
        /* $array = [1, 2, 3, 4];
        $psserfiles = Profile::find($array);
        dd($psserfiles); */
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
                    ->join('cartera_movs as cmvs', 'm.id', 'cmvs.movimiento_id')
                    ->join('carteras as cart', 'cart.id', 'cmvs.cartera_id')
                    ->join('cajas as ca', 'ca.id', 'cart.caja_id')
                    ->select(
                        'plat.nombre as plataforma',
                        'acc.expiration_account as accexp',
                        'c.nombre as cliente',
                        'c.celular as celular',
                        'e.content as correo',
                        'e.pass as passCorreo',
                        'acc.password_account as password_account',
                        'prof.nameprofile as nameprofile',
                        'prof.pin as pin',
                        'plans.id as id',
                        'plans.created_at as planinicio',
                        'plans.expiration_plan as planfin',
                        'plans.observations as obs',
                        'plans.importe as importe',
                        'plans.status as estado',
                        'plans.ready as ready',
                    )   /* BUSCAR POR PLATAFORMA */
                    ->where('plat.nombre', 'like', '%' . $this->search . '%')
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'PERFIL')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')
                    /* BUSCAR POR NOMBRE CLIENTE */
                    ->orWhere('c.nombre', 'like', '%' . $this->search . '%')
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'PERFIL')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')
                    /* BUSCAR POR CORREO */
                    ->orWhere('e.content', 'like', '%' . $this->search . '%')
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'PERFIL')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')
                    /* BUSCAR POR NOMBRE PERFILES */
                    ->orWhere('prof.nameprofile', 'like', '%' . $this->search . '%')
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'PERFIL')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')

                    ->orderBy('plans.created_at', 'desc')
                    ->distinct()
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
                        'plat.nombre as plataforma',
                        'acc.expiration_account as accexp',
                        'c.nombre as cliente',
                        'c.celular as celular',
                        'e.content as correo',
                        'e.pass as passCorreo',
                        'acc.password_account as password_account',
                        'prof.nameprofile as nameprofile',
                        'prof.pin as pin',
                        'plans.id as id',
                        'plans.created_at as planinicio',
                        'plans.expiration_plan as planfin',
                        'plans.observations as obs',
                        'plans.importe as importe',
                        'plans.status as estado',
                        'plans.ready as ready',
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
                        'plat.nombre as plataforma',
                        'acc.expiration_account as accexp',
                        'c.nombre as cliente',
                        'c.celular as celular',
                        'e.content as correo',
                        'e.pass as passCorreo',
                        'plans.importe as importe',
                        'acc.account_name as account_name',
                        'acc.password_account as password_account',
                        'acc.status as accstatus',
                        'plans.id as id',
                        'plans.created_at as planinicio',
                        'plans.expiration_plan as planfin',
                        'plans.observations as obs',
                        'plans.status as estado',
                        'plans.ready as ready',
                    )
                    ->where('plat.nombre', 'like', '%' . $this->search . '%')
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'CUENTA')
                    ->where('m.status', 'ACTIVO')
                    ->whereBetween('plans.created_at', [$from, $to])

                    ->orWhere('c.celular', 'like', '%' . $this->search . '%')
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'CUENTA')
                    ->where('m.status', 'ACTIVO')
                    ->whereBetween('plans.created_at', [$from, $to])

                    ->orWhere('c.nombre', 'like', '%' . $this->search . '%')
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'CUENTA')
                    ->where('m.status', 'ACTIVO')
                    ->whereBetween('plans.created_at', [$from, $to])

                    ->orWhere('acc.account_name', 'like', '%' . $this->search . '%')
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'CUENTA')
                    ->where('m.status', 'ACTIVO')
                    ->whereBetween('plans.created_at', [$from, $to])

                    ->orderBy('plans.created_at', 'desc')
                    ->distinct()
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
                        'plat.nombre as plataforma',
                        'acc.expiration_account as accexp',
                        'c.nombre as cliente',
                        'c.celular as celular',
                        'e.content as correo',
                        'e.pass as passCorreo',
                        'plans.importe as importe',
                        'acc.account_name as account_name',
                        'acc.password_account as password_account',
                        'acc.status as accstatus',
                        'plans.id as id',
                        'plans.created_at as planinicio',
                        'plans.expiration_plan as planfin',
                        'plans.observations as obs',
                        'plans.status as estado',
                        'plans.ready as ready',
                    )
                    ->whereBetween('plans.created_at', [$from, $to])
                    ->where('m.user_id', $user_id)
                    ->where('plans.type_plan', 'CUENTA')
                    ->where('m.status', 'ACTIVO')
                    ->orderBy('plans.created_at', 'desc')
                    ->paginate($this->pagination);
            }
        } else {
            $data = Plan::join('movimientos as m', 'm.id', 'plans.movimiento_id')
                ->select(
                    'plans.*'
                )
                ->whereBetween('plans.created_at', [$from, $to])
                ->where('m.user_id', $user_id)
                ->where('plans.type_plan', 'COMBO')
                /* ->whereColumn('plans.id', '=', 'ap.plan_id') */
                ->orderBy('plans.created_at', 'desc')
                ->paginate($this->pagination);
        }

        /* CALCULAR LA FECHA DE EXPIRACION SEGUN LA CANTIDAD DE MESES */
        if ($this->meses > 0) {
            $date_now = date('Y-m-d h:i:s', time());
            $dias = $this->meses * 30;
            $this->expiration_plan = strtotime('+' . $dias . ' day', strtotime($this->fecha_inicio));
            $this->expiration_plan = date('Y-m-d', $this->expiration_plan);
        } else {
            $this->meses = 1;
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

        /* MOSTRAR SOLO CUENTA ENTERA O CUENTA ENTERA Y PERFILES SEGUN LA PLATAFORMA SELECCIONADA */
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
            $this->accounts = [];
            $this->profiles = [];
        }


        /* MOSTRAR CUENTAS ENTERAS O PERFILES SEGUN ELIGE EL USUARIO */
        if ($this->plataforma != 'Elegir') {
            if ($this->cuentaperfil == 'ENTERA') {  /* MOSTRAR TODAS LAS CUENTAS ENTERAS LIBRES */
                $this->mostrartabla = 0;
                $this->accounts = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
                    ->join('emails as e', 'accounts.email_id', 'e.id')
                    ->select(
                        'accounts.*',
                        'p.precioEntera'
                    )
                    ->where('accounts.whole_account', 'ENTERA')
                    ->where('accounts.availability', 'LIBRE')
                    ->where('accounts.status', 'ACTIVO')
                    ->where('p.id', $this->plataforma)
                    ->orderBy('accounts.expiration_account', 'desc')
                    ->get()->take($this->cantidaperf);
                $this->mostrartabla = 1;
            } elseif ($this->cuentaperfil == 'PERFIL') {  /* MOSTRAR LOS PERFILES LIBRES */
                $this->mostrartabla = 0;
                $this->profiles = Profile::join('account_profiles as ap', 'ap.profile_id', 'profiles.id')
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
                    ->where('p.id', $this->plataforma)
                    ->get()->take($this->cantidaperf);
                $this->mostrartabla = 2;
                /* CUENTAS ENTERAS PARA CREAR UN PERFIL SI ES QUE NO TIENE CREADOS */
                $this->cuentasEnteras = Account::join('platforms as p', 'accounts.platform_id', 'p.id')
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
                        DB::raw('0 as perfOcupados'),
                        DB::raw('0 as espacios'),
                    )
                    ->where('accounts.status', 'ACTIVO')
                    ->where('accounts.availability', 'LIBRE')
                    ->where('p.id', $this->plataforma)
                    ->orderBy('accounts.expiration_account', 'asc')
                    ->get();

                foreach ($this->cuentasEnteras as $c) {
                    $perfilesOcupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                        ->join('profiles as p', 'ap.profile_id', 'p.id')
                        ->where('accounts.id', $c->id)
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

        $platforms1 = Platform::where('estado', 'Activo')->get();
        /* mostrar cuentas de la plataforma 1 */
        if ($this->plataforma1 != 'Elegir') {
            $platforms2 = Platform::where('estado', 'Activo')
                ->where('id', '!=', $this->plataforma1)
                ->get();
            $this->cuentasp1 = Account::where('status', 'ACTIVO')
                ->where('availability', 'LIBRE')->where('platform_id', $this->plataforma1)->get();
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
                ->where('id', '!=', $this->plataforma1)
                ->where('id', '!=', $this->plataforma2)->get();
            $this->cuentasp2 = Account::where('status', 'ACTIVO')
                ->where('availability', 'LIBRE')->where('platform_id', $this->plataforma2)->get();
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
                ->where('availability', 'LIBRE')->where('platform_id', $this->plataforma3)->get();
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

    public function PrimerPerfil(Account $cuenta1)
    {
        $perfil1 = Account::join('account_profiles as ap', 'accounts.id', 'ap.account_id')
            ->join('profiles as p', 'p.id', 'ap.profile_id')
            ->select('p.*')
            ->where('accounts.id', $cuenta1->id)
            ->where('p.availability', 'LIBRE')->get()->first();
        $this->perfil1id = $perfil1->id;
        $this->perfilNombre1 = $perfil1->nameprofile;
        $this->perfilPin1 = $perfil1->pin;
    }
    public function SegundoPerfil(Account $cuenta2)
    {
        $perfil2 = Account::join('account_profiles as ap', 'accounts.id', 'ap.account_id')
            ->join('profiles as p', 'p.id', 'ap.profile_id')
            ->select('p.*')
            ->where('accounts.id', $cuenta2->id)
            ->where('p.availability', 'LIBRE')->get()->first();
        $this->perfil2id = $perfil2->id;
        $this->perfilNombre2 = $perfil2->nameprofile;
        $this->perfilPin2 = $perfil2->pin;
    }
    public function TercerPerfil(Account $cuenta3)
    {
        $perfil3 = Account::join('account_profiles as ap', 'accounts.id', 'ap.account_id')
            ->join('profiles as p', 'p.id', 'ap.profile_id')
            ->select('p.*')
            ->where('accounts.id', $cuenta3->id)
            ->where('p.availability', 'LIBRE')->get()->first();
        $this->perfil3id = $perfil3->id;
        $this->perfilNombre3 = $perfil3->nameprofile;
        $this->perfilPin3 = $perfil3->pin;
    }
    public function venderCombo()
    {
        /* actualizar los datos de los perfiles si los cambio el usuario segun lo que pidio el cliente */
        $perfil1 = Profile::find($this->perfil1id);
        $perfil1->update([
            'nameprofile' => $this->perfilNombre1,
            'pin' => $this->perfilPin1,
        ]);
        $perfil1->save();

        $perfil2 = Profile::find($this->perfil2id);
        $perfil2->update([
            'nameprofile' => $this->perfilNombre2,
            'pin' => $this->perfilPin2,
        ]);
        $perfil2->save();

        $perfil3 = Profile::find($this->perfil3id);
        $perfil3->update([
            'nameprofile' => $this->perfilNombre3,
            'pin' => $this->perfilPin3,
        ]);
        $perfil3->save();

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

            $this->importe = 35;

            /* CREAR EL MOVIMIENTO */
            $mv = Movimiento::create([
                'type' => 'TERMINADO',
                'status' => 'ACTIVO',
                'import' => $this->importe,
                'user_id' => Auth()->user()->id,
            ]);

            // Poner la cuenta del perfil 1 en dividida
            $account1 = Account::find($perfil1->CuentaPerfil->Cuenta->id);
            $account1->whole_account = 'DIVIDIDA';
            $account1->save();
            // Poner la cuenta del perfil 2 en dividida
            $account2 = Account::find($perfil2->CuentaPerfil->Cuenta->id);
            $account2->whole_account = 'DIVIDIDA';
            $account2->save();
            // Poner la cuenta del perfil 3 en dividida
            $account3 = Account::find($perfil3->CuentaPerfil->Cuenta->id);
            $account3->whole_account = 'DIVIDIDA';
            $account3->save();

            // PONER EL PERFIL 1 EN OCUPADO 
            $perfil1->availability = 'OCUPADO';
            $perfil1->save();
            // PONER EL PERFIL 2 EN OCUPADO 
            $perfil2->availability = 'OCUPADO';
            $perfil2->save();
            // PONER EL PERFIL 3 EN OCUPADO 
            $perfil3->availability = 'OCUPADO';
            $perfil3->save();

            /* ENCONTRAR INVERSION de la cuenta del perfil 1 */
            $inversioncuenta = CuentaInversion::where('start_date', '<=', $mv->created_at)
                ->where('expiration_date', '>=', $mv->created_at)
                ->where('account_id', $account1->id)
                ->get()->first();

            $inversioncuenta->type = 'PERFILES';
            $inversioncuenta->sale_profiles += 1;
            $inversioncuenta->imports = $this->importe / 3;
            $inversioncuenta->ganancia = $inversioncuenta->imports - $inversioncuenta->price;
            $inversioncuenta->save();

            /* ENCONTRAR INVERSION de la cuenta del perfil 2 */
            $inversioncuenta2 = CuentaInversion::where('start_date', '<=', $mv->created_at)
                ->where('expiration_date', '>=', $mv->created_at)
                ->where('account_id', $account2->id)
                ->get()->first();

            $inversioncuenta2->type = 'PERFILES';
            $inversioncuenta2->sale_profiles += 1;
            $inversioncuenta2->imports = $this->importe / 3;
            $inversioncuenta2->ganancia = $inversioncuenta2->imports - $inversioncuenta2->price;
            $inversioncuenta2->save();

            /* ENCONTRAR INVERSION de la cuenta del perfil 3 */
            $inversioncuenta3 = CuentaInversion::where('start_date', '<=', $mv->created_at)
                ->where('expiration_date', '>=', $mv->created_at)
                ->where('account_id', $account3->id)
                ->get()->first();

            $inversioncuenta3->type = 'PERFILES';
            $inversioncuenta3->sale_profiles += 1;
            $inversioncuenta3->imports = $this->importe / 3;
            $inversioncuenta3->ganancia = $inversioncuenta3->imports - $inversioncuenta3->price;
            $inversioncuenta3->save();

            /* OBTENER FECHA ACTUAL */
            $DateAndTime = date('Y-m-d h:i:s', time());
            /* CREAR EL PLAN */
            $plan = Plan::create([
                'importe' => $this->importe,
                'plan_start' => $DateAndTime,
                'expiration_plan' => $this->expiration_plan,
                'ready' => 'NO',
                'status' => 'VIGENTE',
                'type_plan' => 'COMBO',
                'type_pay' => $this->tipopago,
                'observations' => $this->observaciones,
                'movimiento_id' => $mv->id
            ]);
            /* crear plan account para los 3 perfiles con las 3 cuentas */
            PlanAccount::create([
                'status' => 'ACTIVO',
                'plan_id' => $plan->id,
                'account_id' => $account1->id,
            ]);
            PlanAccount::create([
                'status' => 'ACTIVO',
                'plan_id' => $plan->id,
                'account_id' => $account2->id,
            ]);
            PlanAccount::create([
                'status' => 'ACTIVO',
                'plan_id' => $plan->id,
                'account_id' => $account3->id,
            ]);

            /* MODIFICAR REGISTRO ACCONNTPROFILE Y DARLE EL ID DEL PLAN*/
            $cuentaPerfil = $perfil1->CuentaPerfil;
            $cuentaPerfil->plan_id = $plan->id;
            $cuentaPerfil->status = 'ACTIVO';
            $cuentaPerfil->save();

            $cuentaPerfil2 = $perfil2->CuentaPerfil;
            $cuentaPerfil2->plan_id = $plan->id;
            $cuentaPerfil2->status = 'ACTIVO';
            $cuentaPerfil2->save();

            $cuentaPerfil3 = $perfil3->CuentaPerfil;
            $cuentaPerfil3->plan_id = $plan->id;
            $cuentaPerfil3->status = 'ACTIVO';
            $cuentaPerfil3->save();

            if ($this->tipopago == 'EFECTIVO') {
                $cajaFisica = Cartera::where('tipo', 'CajaFisica')
                    ->where('caja_id', $cccc->id)->get()->first();
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
                    ->where('caja_id', $cccc->id)->get()->first();
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
                'cliente_id' => $cliente->id
            ]);

            $this->condicional = 'perfiles';


            DB::commit();
            $this->resetUI();
            $this->emit('item-added', 'Plan Registrado');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }


    public function VerCuentas()
    {
        $this->emit('show-crearPerfil', 'show modal!');
    }

    public function SeleccionarCuenta(Account $cuenta)
    {
        $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
            ->join('profiles as p', 'ap.profile_id', 'p.id')
            ->where('accounts.id', $cuenta->id)
            ->where('p.status', 'ACTIVO')->get();
        $cantidadActivos = $perfilesActivos->count();
        $cantiadadQueSePuedeCrear = $cuenta->number_profiles - $cantidadActivos;

        if ($this->CantidadPerfilesCrear <= $cantiadadQueSePuedeCrear) {
            for ($i = 0; $i < $this->CantidadPerfilesCrear; $i++) {
                $perfil = Profile::create([
                    'nameprofile' => $this->nombre . rand(1000, 9999),
                    'pin' => rand(1000, 9999),
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

                /* ACTUALIZAR LISTADO PERFILES Y MOSTAR EL CREADO */
                $this->profiles = Profile::join('account_profiles as ap', 'ap.profile_id', 'profiles.id')
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
                    ->where('p.id', $this->plataforma)
                    ->get()->take($this->cantidaperf);
            }
            $this->emit('mensajeCrearPerf', 'Se crearon los ' . $this->CantidadPerfilesCrear . ' Perfiles');
        } else {
            $this->emit('mensajeCrearPerf', 'No tiene la cantidad suficiente de perfiles que usted quiere crear');
        }


        /* $this->emit('crearperfil-cerrar', 'Se creó el perfil en la cuenta seleccionada'); */
    }

    public function Agregar()
    {
        if ($this->selected_id != 0) {
            $this->resetUI();
        }
        $this->emit('show-modal', 'show modal!');
    }
    /* Cargar los datos seleccionados de la tabla a los label */
    public function Seleccionar($celular, $nombre)
    {
        $this->celular = $celular;
        $this->nombre = $nombre;
        $this->ClienteSelect = 0;
    }

    /* Registrar una transaccion */
    public function Store()
    {
        $rules = [
            'plataforma' => 'required|not_in:Elegir',
            'cuentaperfil' => 'required|not_in:Elegir',
            'nombre' => 'required|min:4',
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
                    /* CALCULAR EL IMPORTE SEGUN LA PLATAFORMA Y SI ES ENTERA O PERFIL */
                    $this->importe += $accp->Plataforma->precioEntera;
                    $this->importe *= $this->meses;
                    /* CREAR EL MOVIMIENTO */
                    $mv = Movimiento::create([
                        'type' => 'TERMINADO',
                        'status' => 'ACTIVO',
                        'import' => $this->importe,
                        'user_id' => Auth()->user()->id,
                    ]);
                    /* PONER LA CUENTA EN OCUPADO */
                    $accp->availability = 'OCUPADO';
                    $accp->save();
                    /* ENCONTRAR INVERSION */
                    $inversioncuenta = CuentaInversion::where('start_date', '<=', $mv->created_at)
                        ->where('expiration_date', '>=', $mv->created_at)
                        ->where('account_id', $accp->id)
                        ->get()->first();

                    $inversioncuenta->type = 'CUENTA';
                    $inversioncuenta->imports = $this->importe;
                    $inversioncuenta->ganancia = $this->importe - $inversioncuenta->price;
                    $inversioncuenta->save();

                    /* OBTENER FECHA ACTUAL */
                    $DateAndTime = date('Y-m-d h:i:s', time());
                    /* CREAR EL PLAN */
                    $plan = Plan::create([
                        'importe' => $this->importe,
                        'plan_start' => $DateAndTime,
                        'expiration_plan' => $this->expiration_plan,
                        'ready' => 'NO',
                        'status' => 'VIGENTE',
                        'type_plan' => 'CUENTA',
                        'type_pay' => $this->tipopago,
                        'observations' => $this->observaciones,
                        'movimiento_id' => $mv->id,
                    ]);
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
                            ->where('caja_id', $cccc->id)->get()->first();
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
                        'cliente_id' => $cliente->id
                    ]);
                    $this->importe = 0;
                    $this->condicional = 'cuentas';
                }
            } elseif ($this->cuentaperfil == 'PERFIL') {
                /* SI SE SELECCIONÓ PERFIL */
                foreach ($this->profiles as $accp) {
                    /* CALCULAR EL IMPORTE SEGUN LA PLATAFORMA Y SI ES ENTERA O PERFIL */
                    $this->importe += $accp->CuentaPerfil->Cuenta->Plataforma->precioPerfil;
                    $this->importe *= $this->meses;

                    /* CREAR EL MOVIMIENTO */
                    $mv = Movimiento::create([
                        'type' => 'TERMINADO',
                        'status' => 'ACTIVO',
                        'import' => $this->importe,
                        'user_id' => Auth()->user()->id,
                    ]);

                    // Poner la cuenta en dividida
                    $account = Account::find($accp->CuentaPerfil->Cuenta->id);
                    $account->whole_account = 'DIVIDIDA';
                    $account->save();

                    /* PONER EL PERFIL EN OCUPADO */
                    $accp->availability = 'OCUPADO';
                    $accp->save();

                    /* ENCONTRAR INVERSION */
                    $inversioncuenta = CuentaInversion::where('start_date', '<=', $mv->created_at)
                        ->where('expiration_date', '>=', $mv->created_at)
                        ->where('account_id', $accp->CuentaPerfil->account_id)
                        ->get()->first();

                    $inversioncuenta->type = 'PERFILES';
                    $inversioncuenta->sale_profiles += 1;
                    $inversioncuenta->imports += $this->importe;
                    $inversioncuenta->ganancia = $inversioncuenta->imports - $inversioncuenta->price;
                    $inversioncuenta->save();

                    /* OBTENER FECHA ACTUAL */
                    $DateAndTime = date('Y-m-d h:i:s', time());
                    /* CREAR EL PLAN */
                    $plan = Plan::create([
                        'importe' => $this->importe,
                        'plan_start' => $DateAndTime,
                        'expiration_plan' => $this->expiration_plan,
                        'ready' => 'NO',
                        'status' => 'VIGENTE',
                        'type_plan' => 'PERFIL',
                        'type_pay' => $this->tipopago,
                        'observations' => $this->observaciones,
                        'movimiento_id' => $mv->id
                    ]);

                    PlanAccount::create([
                        'status' => 'ACTIVO',
                        'plan_id' => $plan->id,
                        'account_id' => $accp->CuentaPerfil->account_id,
                    ]);

                    /* MODIFICAR REGISTRO ACCONNTPROFILE Y DARLE EL ID DEL PLAN*/
                    $cuentaPerfil = $accp->CuentaPerfil;
                    $cuentaPerfil->plan_id = $plan->id;
                    $cuentaPerfil->status = 'ACTIVO';
                    $cuentaPerfil->save();

                    /* CONTAR PERFILES OCUPADOS */
                    /* $perfilesOcupados = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                        ->join('profiles as p', 'ap.profile_id', 'p.id')
                        ->where('accounts.id', $accp->CuentaPerfil->Cuenta->id)
                        ->where('p.availability', 'OCUPADO')
                        ->where('p.status', 'ACTIVO')->get(); */
                    /* SI LA CUENTA TIENE TODOS LOS PERFILES DISPONIBLES OCUPADOS LA CUENTA PASA A ESTAR OCUPADA */
                    /* if (($perfilesOcupados->count() / 2) == $accp->CuentaPerfil->Cuenta->number_profiles) {
                        $cuenta = $accp->CuentaPerfil->Cuenta;
                        $cuenta->availability = 'OCUPADO';
                        $cuenta->save();
                    } */

                    if ($this->tipopago == 'EFECTIVO') {
                        $cajaFisica = Cartera::where('tipo', 'CajaFisica')
                            ->where('caja_id', $cccc->id)->get()->first();
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
                            ->where('caja_id', $cccc->id)->get()->first();
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
                        'cliente_id' => $cliente->id
                    ]);

                    $this->importe = 0;
                    $this->condicional = 'perfiles';
                }
            }
            DB::commit();
            $this->resetUI();
            $this->emit('item-added', 'Plan Registrado');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

    /* Anular una transacción */
    public function Anular(Plan $plan)
    {
        /* SABER SI ES UN PERFIL O UNA CUENTA */
        $cuentaPerf = AccountProfile::where('plan_id', $plan->id)->get();

        DB::beginTransaction();
        try {
            if ($cuentaPerf->count() > 0) {  /* CUANDO ES UN PERFIL */
                /* OBTENER IDS */
                $anular = Plan::join('movimientos as m', 'plans.movimiento_id', 'm.id')
                    ->join('plan_accounts as pa', 'pa.plan_id', 'plans.id')
                    ->join('accounts as a', 'pa.account_id', 'a.id')
                    ->join('account_profiles as ap', 'ap.account_id', 'a.id')
                    ->join('profiles as p', 'ap.profile_id', 'p.id')
                    ->select('m.*', 'pa.id as paid', 'a.id as cuentaid', 'p.id as perfilid', 'ap.id as apid')
                    ->whereColumn('plans.id', '=', 'ap.plan_id')
                    ->where('plans.id', $plan->id)
                    ->get()->first();
                /* PONER EN INACTIVO EL MOVIMIENTO */
                $movimiento = Movimiento::find($anular->id);
                $movimiento->status = 'INACTIVO';
                $movimiento->save();
                /* ANULAR PLAN */
                $plan->status = 'ANULADO';
                $plan->save();
                /* PONER EN INACTIVO PLANACCOUNT */
                $planCuenta = PlanAccount::find($anular->paid);
                $planCuenta->status = 'ANULADO';
                $planCuenta->save();

                $cuenta = Account::find($anular->cuentaid);
                /* PONER EN NULL PLAN_ID DE ACCOUNTPROFILE */
                $CuentaPerf = AccountProfile::find($anular->apid);
                $CuentaPerf->plan_id = null;
                $CuentaPerf->save();
                /* PONER EN LIBRE EL PERFIL Y PONER NUEVA CONTRASEÑA */
                $perf = Profile::find($anular->perfilid);
                $perf->availability = 'LIBRE';
                $perf->pin = $perf->pin . rand(100, 999);
                $perf->save();

                /* CONTAR LOS PERFILES ACTIVOS DE ESA CUENTA */
                /* $perfilesActivos = Account::join('account_profiles as ap', 'ap.account_id', 'accounts.id')
                    ->join('profiles as p', 'ap.profile_id', 'p.id')
                    ->where('accounts.id', $anular->cuentaid)
                    ->where('ap.status', 'ACTIVO')
                    ->where('p.status', 'ACTIVO')->get(); */
                /* SI LA CUENTA NO TIENE PERFILES REGRESA A SER ENTERA */
                /* if ($perfilesActivos->count() == 0) {
                    $cuenta->whole_account = 'ENTERA';
                    $cuenta->save();
                } */
            } else {  /* CUANDO ES UNA CUENTA */
                /* OBTENER IDS */
                $anular = Plan::join('movimientos as m', 'plans.movimiento_id', 'm.id')
                    ->join('plan_accounts as pa', 'pa.plan_id', 'plans.id')
                    ->join('accounts as a', 'pa.account_id', 'a.id')
                    ->select('m.*', 'pa.id as paid', 'a.id as cuentaid')
                    ->where('plans.id', $plan->id)
                    ->get()->first();
                /* PONER EN INACTIVO EL MOVIMIENTO */
                $movimiento = Movimiento::find($anular->id);
                $movimiento->status = 'INACTIVO';
                $movimiento->save();
                /* PONER EN ANULADO EL PLAN */
                $plan->status = 'ANULADO';
                $plan->save();
                /* PONER EN INACTIVO EL PLANACCOUNT */
                $planCuenta = PlanAccount::find($anular->paid);
                $planCuenta->status = 'ANULADO';
                $planCuenta->save();
                /* PONER LA CUENTA EN LIBRE Y PONER NUEVA CONTRASEÑA */
                $cuenta = Account::find($anular->cuentaid);
                $cuenta->availability = 'LIBRE';
                $cuenta->password_account = $cuenta->password_account . rand(100, 999);
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

    public function viewDetails()
    {
        $this->emit('show-modal2', 'open modal');
    }

    public function VerObservaciones(Plan $plan)
    {
        $this->selected_id = $plan->id;
        $this->ready = $plan->ready;
        $this->observaciones = $plan->observations;
        $this->emit('show-modal3', 'open modal');
    }

    public function Modificar()
    {
        $plan = Plan::find($this->selected_id);
        $plan->observations = $this->observaciones;
        $plan->save();
        $this->resetUI();
        $this->emit('item-actualizado', 'Se actulizó la información');
    }

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
        $perfil = Profile::find($this->selected_perf);
        $perfil->nameprofile = $this->nombrePerfil;
        $perfil->pin = $this->pinPerfil;
        $perfil->save();
        $this->nombrePerfil = '';
        $this->pinPerfil = '';
        $this->emit('perf-actualizado', 'Se actulizó el perfil');
    }

    protected $listeners = ['deleteRow' => 'Anular', 'Realizado' => 'Realizado'];

    public function Realizado(Plan $plan)
    {
        $plan->ready = 'SI';
        $plan->done = 'SI';
        $plan->save();
        $this->resetUI();
        $this->emit('perf-actualizado', 'Se cambió a realizado');
    }

    public function CrearCombo()
    {
        $this->emit('show-modalCombos', '');
    }

    public function resetUI()
    {
        $this->selected_id = 0;
        $this->hora = date("d-m-Y H:i:s ");
        $this->status = 'Vigente';
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
        $this->meses = 1;
        $this->observaciones = '';
        $this->ready = 'NINGUNA';
        $this->totalCobrar = 0;
        $this->BuscarCliente = 0;
        $this->ClienteSelect = 0;
        $this->nombrePerfil = '';
        $this->pinPerfil = '';
        $this->cuentasEnteras = [];
        $this->resetValidation();
    }
}
