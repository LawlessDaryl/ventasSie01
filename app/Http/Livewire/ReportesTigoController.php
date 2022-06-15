<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cartera;
use App\Models\Cliente;
use App\Models\Comision;
use App\Models\Motivo;
use App\Models\Movimiento;
use App\Models\OrigenMotivo;
use App\Models\OrigenMotivoComision;
use App\Models\Transaccion;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReportesTigoController extends Component
{
    public $componentName, $data, $details, $sumDetails, $countDetails, $reportType,
        $userId, $dateFrom, $dateTo, $transaccionId, $tipotr, $origenfiltro;


    public $search, $origen, $cedula, $celular, $condicionalOrigen, $motivo, $condicionalMotivo, $ResetRadioButton, $a, $b,
     $mostrarunavez1, $mostrarunavez2;

    public function mount()
    {
        $this->componentName = 'Reportes Tigo Money';
        $this->data = [];
        $this->details = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->reportType = 0;
        $this->userId = 0;
        $this->transaccionId = 0;
        $this->tipotr = 0;
        $this->origenfiltro = 0;
        $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');













        $this->mostrarunavez1 = true;
        $this->mostrarunavez2 = true;
        $this->motivo = 'Elegir';
    }

    public function render()
    {
        $this->trsbydate();








        
        


























        //VARIABLES COPIADAS DE TRANSACCION CONTROLLER
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

        if (strlen($this->search) > 0) {
            $data = Transaccion::join('origen_motivos as om', 'transaccions.origen_motivo_id', 'om.id')
                ->join('origens as ori', 'ori.id', 'om.origen_id')
                ->join('motivos as mot', 'mot.id', 'om.motivo_id')
                ->join('mov_transacs as mt', 'transaccions.id', 'mt.transaccion_id')
                ->join('movimientos as m', 'm.id', 'mt.movimiento_id')
                ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                ->join('cartera_movs as cmvs', 'm.id', 'cmvs.movimiento_id')
                ->join('carteras as cart', 'cart.id', 'cmvs.cartera_id')
                ->join('cajas as ca', 'ca.id', 'cart.caja_id')
                ->select(
                    'c.cedula as codCliente',
                    'transaccions.telefono as TelCliente',
                    'c.nombre as nomClient',
                    'transaccions.codigo_transf as codigotrans',
                    'ori.nombre as origen_nombre',
                    'transaccions.id as id',
                    'mot.nombre as motivo_nombre',
                    'transaccions.importe',
                    'transaccions.created_at as hora',
                    'transaccions.observaciones',
                    'transaccions.estado as estado'
                )
                ->whereBetween('transaccions.created_at', [$from, $to])
                ->where('m.user_id', $user_id)
                ->where('c.cedula', 'like', '%' . $this->search . '%')
                ->orWhere('ori.nombre', 'like', '%' . $this->search . '%')
                ->orWhere('mot.nombre', 'like', '%' . $this->search . '%')
                ->where('ca.id', $cajausuario->id)
                ->orderBy('transaccions.created_at', 'desc')
                ->paginate(5);
        } else {
            $data = Transaccion::join('origen_motivos as om', 'transaccions.origen_motivo_id', 'om.id')
                ->join('origens as ori', 'ori.id', 'om.origen_id')
                ->join('motivos as mot', 'mot.id', 'om.motivo_id')
                ->join('mov_transacs as mt', 'transaccions.id', 'mt.transaccion_id')
                ->join('movimientos as m', 'm.id', 'mt.movimiento_id')
                ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                ->join('cartera_movs as cmvs', 'm.id', 'cmvs.movimiento_id')
                ->join('carteras as cart', 'cart.id', 'cmvs.cartera_id')
                ->join('cajas as ca', 'ca.id', 'cart.caja_id')
                ->select(
                    'c.cedula as codCliente',
                    'transaccions.telefono as TelCliente',
                    'c.nombre as nomClient',
                    'transaccions.codigo_transf as codigotrans',
                    'ori.nombre as origen_nombre',
                    'transaccions.id as id',
                    'mot.nombre as motivo_nombre',
                    'transaccions.importe',
                    'transaccions.created_at as hora',
                    'transaccions.observaciones',
                    'transaccions.estado as estado'
                )
                ->whereBetween('transaccions.created_at', [$from, $to])
                ->where('m.user_id', $user_id)
                ->where('ca.id', $cajausuario->id)
                ->orderBy('transaccions.created_at', 'desc')
                ->paginate(5);
        }

        /* LISTADO DE MOTIVOS DE ESE ORIGEN */
        if ($this->origen != 'Elegir') {
            $motivos = OrigenMotivo::join('motivos as m', 'm.id', 'origen_motivos.motivo_id')
                ->select('m.*')->where('origen_motivos.origen_id', $this->origen)->get();
        } else {
            $motivos = [];
        }


        /* BUSCAR CLIENTE POR CEDULA EN EL INPUT DEL MODAL */
        if ($this->cedula != '' && $this->ClienteSelect == 0) {
            $this->datosPorCedula = Cliente::where('cedula', 'like', $this->cedula . '%')->orderBy('cedula', 'desc')->get();
        } else {
            $this->datosPorCedula = [];
        }

        /* BUSCAR CLIENTE POR TELEFONO EN EL INPUT DEL MODAL */
        if ($this->celular != '' && $this->TelfSelect == 0) {
            $this->datosPorTelefono = Cliente::where('celular', 'like', $this->celular . '%')->orderBy('celular', 'desc')->get();
        } else {
            $this->datosPorTelefono = [];
        }


        /* RESET DE CAMPOS AL CAMBIAR ORIGEN */
        if ($this->origen != 'Elegir' && $this->condicionalOrigen == 'asd') {
            $this->condicionalOrigen = $this->origen;
        } elseif ($this->origen != $this->condicionalOrigen) {
            $this->identificador = rand();
            $this->identificador2 = rand();
            $this->montoCobrarPagar = 'Monto a cobrar/pagar';

            $this->motivo = 'Elegir';

            $this->origMotID = 0;
            $this->OrigenMotivoObjeto = [];
            $this->transaccion = [];

            $this->mostrarCI = 0;
            $this->mostrartelf = 0;
            $this->mostrarTelfCodigo = 0;

            $this->montoR = 0;
            $this->importe = '';

            $this->ClienteSelect = 0;
            $this->TelfSelect = 0;

            $this->igualarMontos = 0;
            $this->MostrarRadioButton = 0;

            $this->ResetRadioButton = 0;
            $this->condicionalOrigen = 'asd';
            $this->condicionalMotivo = 'asd';
            $this->requerimientoComision = '';
        }


        /* RESET DE CAMPOS AL CAMBIAR MOTIVO */
        if ($this->motivo != 'Elegir' && $this->condicionalMotivo == 'asd') {
            $this->condicionalMotivo = $this->motivo;
        } elseif ($this->motivo != $this->condicionalMotivo) {
            $this->identificador = rand();
            $this->identificador2 = rand();
            $this->montoCobrarPagar = 'Monto a cobrar/pagar';

            $this->origMotID = 0;
            $this->OrigenMotivoObjeto = [];
            $this->transaccion = [];

            $this->montoB = '';
            $this->montoR = 0;
            $this->importe = '';

            $this->mostrarCI = 0;
            $this->mostrartelf = 0;
            $this->mostrarTelfCodigo = 0;

            $this->ClienteSelect = 0;
            $this->TelfSelect = 0;

            $this->igualarMontos = 0;
            $this->MostrarRadioButton = 0;

            $this->ResetRadioButton = 0;
            $this->condicionalMotivo = 'asd';
            $this->requerimientoComision = '';
        }



        /* RESET DE RADIO BUTTONS AL CAMBIAR IMPORTE */
        if ($this->ResetRadioButton != 0) {
            if ($this->ResetRadioButton != $this->montoB) {
                $this->identificador = rand();
                $this->identificador2 = rand();
                $this->igualarMontos = 0;
                $this->importe = $this->montoB;
                $this->montoR = $this->montoB;
                $this->requerimientoComision = '';
                $this->MostrarRadioButton = 0;
                $this->ResetRadioButton = 0;
            }
        }


        /* OBTENER ORIGEN-MOTIVO DE LOS CAMPOS SELECCIONADOS */
        if ($this->origen != 'Elegir' && $this->motivo != 'Elegir') {
            /* CARGAR ORIGEN MOTIVO OBJETO */
            $this->OrigenMotivoObjeto = OrigenMotivo::where('motivo_id', $this->motivo)
                ->where('origen_id', $this->origen)
                ->get()->first();
            /* CARGAR ORIGEN MOTIVO ID */
            $this->origMotID = $this->OrigenMotivoObjeto->id;
            if ($this->OrigenMotivoObjeto->comision_si_no == 'si') {
                $this->MostrarRadioButton = 1;
            } else {
                $this->MostrarRadioButton = 0;
            }
            /* Mostrar label e imput (CI CLIENTE) solo si el origen motivo lo requiere */
            if ($this->OrigenMotivoObjeto->CIdeCliente == 'SI') {
                $this->mostrarCI = 1;
            } else {
                $this->cedula = '';
                $this->mostrarCI = 0;
            }
            /* Mostrar label e imput (Telf Solicitante) solo si el origen motivo lo requiere */
            if ($this->OrigenMotivoObjeto->telefSolicitante == 'SI') {
                $this->mostrartelf = 1;
            } else {
                $this->celular = '';
                $this->mostrartelf = 0;
            }
            /* Mostrar label e imput (Telf destino) solo si el origen motivo lo requiere */
            if ($this->OrigenMotivoObjeto->telefDestino_codigo == 'SI') {
                $this->mostrarTelfCodigo = 1;
            } else {
                $this->codigo_transf = '';
                $this->mostrarTelfCodigo = 0;
            }
            /* Monto a cobrar o pagar */
            $motiv = Motivo::find($this->motivo);
            if ($motiv->tipo == 'Retiro') {
                $this->montoCobrarPagar = 'Monto a pagar';
            } elseif ($motiv->tipo == 'Abono') {
                $this->montoCobrarPagar = 'Monto a cobrar';
            }
        }


        /* Monto a registrar igual a importe si variable igualarMontos es igual a 0
        (cambia a 1 cuando se ejecutan las comisiones) */
        if ($this->igualarMontos == 0) {
            $this->montoR = $this->montoB;
            $this->importe = $this->montoB;
        }


        /* Calcular comision cuando cuando comision_si_no de origen_motivo es nopreguntar pero si son afectados los montos */
        if ($this->origMotID != 0 && $this->montoB != '' && $this->igualarMontos == 0) {
            if ($this->OrigenMotivoObjeto->comision_si_no == 'nopreguntar' && ($this->OrigenMotivoObjeto->suma_resta_si != 'mantiene' || $this->OrigenMotivoObjeto->suma_resta_no != 'mantiene')) {
                $this->importe = $this->montoB;
                $this->montoR = $this->montoB;
                $this->ComisionSi();
            }
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



        /* MOSTRAR SOLO TELEFONO O SOLO SISTEMA O AMBOS SI ES QUE EXISTEN EN ESA CAJA */
        $carterasDe = Cartera::join('origens as ori', 'carteras.tipo', 'ori.nombre')
            ->select('ori.nombre as nombre', 'ori.id as id')
            ->where('caja_id', $cajausuario->id)->get();













        return view('livewire.reportes_tigo.component', [
            'users' => User::orderBy('name', 'asc')->get(),


            
            'origenes' => $carterasDe,
            'motivos' => $motivos,
            'carterasCaja' => $carterasCaja,
        ])->extends('layouts.theme.app')
            ->section('content');
    }

    public function trsbydate()
    {
        if ($this->reportType == 0) {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        } else {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d')     . ' 23:59:59';
        }


        if ($this->reportType == 1 && ($this->dateFrom == '' || $this->dateTo == '')) {
            $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
            $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
            $this->emit('item', 'Reportes de Hoy');
        }

        if ($this->dateFrom == "" || $this->dateTo == "") {
            $this->reportType = 0;
        }

        if ($this->userId == 0) {
            if ($this->tipotr == '0') {
                if ($this->origenfiltro == '0') {
                    $this->data = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
                        ->join('movimientos as m', 'm.id', 'mt.movimiento_id')
                        ->join('users as u', 'm.user_id', 'u.id')
                        ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'm.id')
                        ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                        ->join('origen_motivos as om', 'transaccions.origen_motivo_id', 'om.id')
                        ->join('origens as ori', 'ori.id', 'om.origen_id')
                        ->join('motivos as mot', 'mot.id', 'om.motivo_id')
                        ->select(
                            'c.cedula as cedula',
                            'transaccions.*',
                            'ori.nombre as origen_nombre',
                            'mot.nombre as motivo_nombre',
                        )
                        ->whereBetween('transaccions.created_at', [$from, $to])

                        ->orderBy('transaccions.id', 'desc')
                        ->get();
                } else {
                    $this->data = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
                        ->join('movimientos as m', 'm.id', 'mt.movimiento_id')
                        ->join('users as u', 'm.user_id', 'u.id')
                        ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'm.id')
                        ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                        ->join('origen_motivos as om', 'transaccions.origen_motivo_id', 'om.id')
                        ->join('origens as ori', 'ori.id', 'om.origen_id')
                        ->join('motivos as mot', 'mot.id', 'om.motivo_id')
                        ->select(
                            'c.cedula as cedula',
                            'transaccions.*',
                            'ori.nombre as origen_nombre',
                            'mot.nombre as motivo_nombre',
                        )
                        ->whereBetween('transaccions.created_at', [$from, $to])
                        ->where('ori.nombre', $this->origenfiltro)
                        ->orderBy('transaccions.id', 'desc')
                        ->get();
                }
            } else {
                if ($this->origenfiltro == '0') {
                    $this->data = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
                        ->join('movimientos as m', 'm.id', 'mt.movimiento_id')
                        ->join('users as u', 'm.user_id', 'u.id')
                        ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'm.id')
                        ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                        ->join('origen_motivos as om', 'transaccions.origen_motivo_id', 'om.id')
                        ->join('origens as ori', 'ori.id', 'om.origen_id')
                        ->join('motivos as mot', 'mot.id', 'om.motivo_id')
                        ->select(
                            'c.cedula as cedula',
                            'transaccions.*',
                            'ori.nombre as origen_nombre',
                            'mot.nombre as motivo_nombre',
                        )
                        ->whereBetween('transaccions.created_at', [$from, $to])
                        ->where('mot.tipo', $this->tipotr)
                        ->orderBy('transaccions.id', 'desc')
                        ->get();
                } else {
                    $this->data = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
                        ->join('movimientos as m', 'm.id', 'mt.movimiento_id')
                        ->join('users as u', 'm.user_id', 'u.id')
                        ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'm.id')
                        ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                        ->join('origen_motivos as om', 'transaccions.origen_motivo_id', 'om.id')
                        ->join('origens as ori', 'ori.id', 'om.origen_id')
                        ->join('motivos as mot', 'mot.id', 'om.motivo_id')
                        ->select(
                            'c.cedula as cedula',
                            'transaccions.*',
                            'ori.nombre as origen_nombre',
                            'mot.nombre as motivo_nombre',
                        )
                        ->whereBetween('transaccions.created_at', [$from, $to])
                        ->where('mot.tipo', $this->tipotr)
                        ->where('ori.nombre', $this->origenfiltro)
                        ->orderBy('transaccions.id', 'desc')
                        ->get();
                }
            }
        } else {
            if ($this->tipotr == '0') {
                if ($this->origenfiltro == '0') {
                    $this->data = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
                        ->join('movimientos as m', 'm.id', 'mt.movimiento_id')
                        ->join('users as u', 'm.user_id', 'u.id')
                        ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'm.id')
                        ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                        ->join('origen_motivos as om', 'transaccions.origen_motivo_id', 'om.id')
                        ->join('origens as ori', 'ori.id', 'om.origen_id')
                        ->join('motivos as mot', 'mot.id', 'om.motivo_id')
                        ->select(
                            'c.cedula as cedula',
                            'transaccions.*',
                            'ori.nombre as origen_nombre',
                            'mot.nombre as motivo_nombre',
                        )
                        ->whereBetween('transaccions.created_at', [$from, $to])
                        ->where('m.user_id', $this->userId)
                        ->orderBy('transaccions.id', 'desc')
                        ->get();
                } else {
                    $this->data = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
                        ->join('movimientos as m', 'm.id', 'mt.movimiento_id')
                        ->join('users as u', 'm.user_id', 'u.id')
                        ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'm.id')
                        ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                        ->join('origen_motivos as om', 'transaccions.origen_motivo_id', 'om.id')
                        ->join('origens as ori', 'ori.id', 'om.origen_id')
                        ->join('motivos as mot', 'mot.id', 'om.motivo_id')
                        ->select(
                            'c.cedula as cedula',
                            'transaccions.*',
                            'ori.nombre as origen_nombre',
                            'mot.nombre as motivo_nombre',
                        )
                        ->whereBetween('transaccions.created_at', [$from, $to])
                        ->where('m.user_id', $this->userId)
                        ->where('ori.nombre', $this->origenfiltro)
                        ->orderBy('transaccions.id', 'desc')
                        ->get();
                }
            } else {
                if ($this->origenfiltro == '0') {
                    $this->data = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
                        ->join('movimientos as m', 'm.id', 'mt.movimiento_id')
                        ->join('users as u', 'm.user_id', 'u.id')
                        ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'm.id')
                        ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                        ->join('origen_motivos as om', 'transaccions.origen_motivo_id', 'om.id')
                        ->join('origens as ori', 'ori.id', 'om.origen_id')
                        ->join('motivos as mot', 'mot.id', 'om.motivo_id')
                        ->select(
                            'c.cedula as cedula',
                            'transaccions.*',
                            'ori.nombre as origen_nombre',
                            'mot.nombre as motivo_nombre',
                        )
                        ->whereBetween('transaccions.created_at', [$from, $to])
                        ->where('m.user_id', $this->userId)
                        ->where('mot.tipo', $this->tipotr)
                        ->orderBy('transaccions.id', 'desc')
                        ->get();
                }else{
                    $this->data = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
                        ->join('movimientos as m', 'm.id', 'mt.movimiento_id')
                        ->join('users as u', 'm.user_id', 'u.id')
                        ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'm.id')
                        ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                        ->join('origen_motivos as om', 'transaccions.origen_motivo_id', 'om.id')
                        ->join('origens as ori', 'ori.id', 'om.origen_id')
                        ->join('motivos as mot', 'mot.id', 'om.motivo_id')
                        ->select(
                            'c.cedula as cedula',
                            'transaccions.*',
                            'ori.nombre as origen_nombre',
                            'mot.nombre as motivo_nombre',
                        )
                        ->whereBetween('transaccions.created_at', [$from, $to])
                        ->where('m.user_id', $this->userId)
                        ->where('mot.tipo', $this->tipotr)
                        ->where('ori.nombre', $this->origenfiltro)
                        ->orderBy('transaccions.id', 'desc')
                        ->get();
                }
            }
        }
    }

    public function getDetails($idtransaccion)
    {
        $this->details = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
            ->join('movimientos as m', 'm.id', 'mt.movimiento_id')

            ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'm.id')
            ->join('carteras as c', 'cmv.cartera_id', 'c.id')

            ->select(
                'cmv.type as tipo',
                'm.import as importe',
                'transaccions.observaciones as observaciones',
                'c.nombre as nombreCartera',
            )
            ->where('transaccions.id', $idtransaccion)
            ->get();

        $this->transaccionId = $idtransaccion;

        $this->emit('show-modal', 'details loaded');
    }















    //Llamar modal y cargar los datos para editar una transaccion ya realizada
    public function editartransaccion($idtransaccion)
    {
        $adata = Transaccion::join('mov_transacs as mt', 'mt.transaccion_id', 'transaccions.id')
                        ->join('movimientos as m', 'm.id', 'mt.movimiento_id')
                        ->join('users as u', 'm.user_id', 'u.id')
                        ->join('cartera_movs as cmv', 'cmv.movimiento_id', 'm.id')
                        ->join('cliente_movs as cmovs', 'm.id', 'cmovs.movimiento_id')
                        ->join('clientes as c', 'c.id', 'cmovs.cliente_id')
                        ->join('origen_motivos as om', 'transaccions.origen_motivo_id', 'om.id')
                        ->join('origens as ori', 'ori.id', 'om.origen_id')
                        ->join('motivos as mot', 'mot.id', 'om.motivo_id')
                        ->select(
                            'c.cedula as cedula',
                            'transaccions.*',
                            'ori.id as idorigen',
                            'ori.nombre as origen_nombre',
                            'mot.id as idmotivo',
                            'mot.nombre as motivo_nombre',
                            'c.cedula as cedula',
                            'c.cedula as celular'
                        )
                        ->where('transaccions.id', $idtransaccion)
                        ->get();

       
        $this->resetUI();
        $this->origen = $adata->first()->idorigen;
        $this->motivo = $adata->first()->idmotivo;
        $this->montoB = $adata->first()->importe;
        $this->b = 'checked';

        $this->cedula = $adata->first()->cedula;
        $this->celular = $adata->first()->celular;
        $this->codigo_transf = $adata->first()->codigo_transf;
        $this->observaciones = $adata->first()->observaciones;

        $this->emit('mostrareditarmodal', '');



    }
    /* CALCULAR COMISION SI SELECCIONA SI EN RADIO BUTTON */
    public function ComisionSi()
    {
        $this->importe = $this->montoB;
        $this->montoR = $this->montoB;

        $lista = OrigenMotivoComision::join('comisions as c', 'origen_motivo_comisions.comision_id', 'c.id')
            ->where('c.monto_inicial', '<=', $this->montoB)
            ->where('c.monto_final', '>=', $this->montoB)
            ->where('origen_motivo_comisions.origen_motivo_id', $this->origMotID)
            ->where('c.tipo', 'Cliente')
            ->select('c.id')->get()->first();

        try {
            $comis = Comision::find($lista->id);
        } catch (Exception $e) {
            $this->emit('item-error', "Este tipo de transacción no tiene una comisio o el campo esta en blanco");
            return;
        }

        if ($comis->porcentaje == 'Desactivo') {
            if ($this->OrigenMotivoObjeto->afectadoSi == 'montoR') {

                if ($this->OrigenMotivoObjeto->suma_resta_si == 'suma') {
                    $this->montoR = $this->montoB + $comis->comision;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_si == 'resta') {
                    $this->montoR = $this->montoB - $comis->comision;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_si == 'mantiene') {
                    $this->importe = $this->montoB;
                    $this->montoR = $this->montoB;
                }
            }
            if ($this->OrigenMotivoObjeto->afectadoSi == 'montoC') {

                if ($this->OrigenMotivoObjeto->suma_resta_si == 'suma') {
                    $this->importe = $this->montoB + $comis->comision;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_si == 'resta') {
                    $this->importe = $this->montoB - $comis->comision;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_si == 'mantiene') {
                    $this->importe = $this->montoB;
                    $this->montoR = $this->montoB;
                }
            }
            if ($this->OrigenMotivoObjeto->afectadoSi == 'ambos') {
                if ($this->OrigenMotivoObjeto->suma_resta_si == 'suma') {
                    $this->montoR = $this->montoB + $comis->comision;
                    $this->importe = $this->montoB + $comis->comision;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_si == 'resta') {
                    $this->montoR = $this->montoB - $comis->comision;
                    $this->importe = $this->montoB - $comis->comision;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_si == 'mantiene') {
                    $this->importe = $this->montoB;
                    $this->montoR = $this->montoB;
                }
            }
        } else {/* porcentajes */

            if ($this->OrigenMotivoObjeto->afectadoSi == 'montoR') {
                if ($this->OrigenMotivoObjeto->suma_resta_si == 'suma') {
                    $this->montoR = ($this->montoB * $comis->comision) / 100 + $this->montoB;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_si == 'resta') {
                    $this->montoR = - (($this->montoB * $comis->comision) / 100) + $this->montoB;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_si == 'mantiene') {
                    $this->importe = $this->montoB;
                    $this->montoR = $this->montoB;
                }
            }
            if ($this->OrigenMotivoObjeto->afectadoSi == 'montoC') {

                if ($this->OrigenMotivoObjeto->suma_resta_si == 'suma') {
                    $this->importe = ($this->montoB * $comis->comision) / 100 + $this->montoB;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_si == 'resta') {
                    $this->importe = - (($this->montoB * $comis->comision) / 100) + $this->montoB;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_si == 'mantiene') {
                    $this->importe = $this->montoB;
                    $this->montoR = $this->montoB;
                }
            }
            if ($this->OrigenMotivoObjeto->afectadoSi == 'ambos') {
                if ($this->OrigenMotivoObjeto->suma_resta_si == 'suma') {
                    $this->montoR = ($this->montoB * $comis->comision) / 100 + $this->montoB;
                    $this->importe = ($this->montoB * $comis->comision) / 100 + $this->montoB;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_si == 'resta') {
                    $this->montoR = - (($this->montoB - $comis->comision) / 100) + $this->montoB;
                    $this->importe = - (($this->montoB - $comis->comision) / 100) + $this->montoB;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_si == 'mantiene') {
                    $this->importe = $this->montoB;
                    $this->montoR = $this->montoB;
                }
            }
        }
        $this->igualarMontos = 1;
        $this->ResetRadioButton = $this->montoB;
        $this->requerimientoComision = 'LISTO';
    }
    /* CALCULAR COMISION SI SELECCIONA NO EN RADIO BUTTON */
    public function ComisionNo()
    {
        $this->importe = $this->montoB;
        $this->montoR = $this->montoB;

        $lista = OrigenMotivoComision::join('comisions as c', 'origen_motivo_comisions.comision_id', 'c.id')
            ->where('c.monto_inicial', '<=', $this->montoB)
            ->where('c.monto_final', '>=', $this->montoB)
            ->where('origen_motivo_comisions.origen_motivo_id', $this->origMotID)
            ->where('c.tipo', 'Cliente')
            ->select('c.id')->get()->first();

        try {
            $comis = Comision::find($lista->id);
        } catch (Exception $e) {
            $this->emit('item-error', "Este tipo de transacción no tiene una comisio o el campo esta en blanco");
            return;
        }

        if ($comis->porcentaje == 'Desactivo') {
            if ($this->OrigenMotivoObjeto->afectadoNo == 'montoR') {
                if ($this->OrigenMotivoObjeto->suma_resta_no == 'suma') {
                    $this->montoR = $this->montoB + $comis->comision;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_no == 'resta') {
                    $this->montoR = $this->montoB - $comis->comision;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_no == 'mantiene') {
                    $this->importe = $this->montoB;
                    $this->montoR = $this->montoB;
                }
            }
            if ($this->OrigenMotivoObjeto->afectadoNo == 'montoC') {
                if ($this->OrigenMotivoObjeto->suma_resta_no == 'suma') {
                    $this->importe = $this->montoB + $comis->comision;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_no == 'resta') {
                    $this->importe = $this->montoB - $comis->comision;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_no == 'mantiene') {
                    $this->importe = $this->montoB;
                    $this->montoR = $this->montoB;
                }
            }
            if ($this->OrigenMotivoObjeto->afectadoNo == 'ambos') {
                if ($this->OrigenMotivoObjeto->suma_resta_no == 'suma') {
                    $this->montoR = $this->montoB + $comis->comision;
                    $this->importe = $this->montoB + $comis->comision;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_no == 'resta') {
                    $this->montoR = $this->montoB - $comis->comision;
                    $this->importe = $this->montoB - $comis->comision;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_no == 'mantiene') {
                    $this->importe = $this->montoB;
                    $this->montoR = $this->montoB;
                }
            }
        } else {/* porcentajes */
            if ($this->OrigenMotivoObjeto->afectadoNo == 'montoR') {
                if ($this->OrigenMotivoObjeto->suma_resta_no == 'suma') {
                    $this->montoR = ($this->montoB * $comis->comision) / 100 + $this->montoB;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_no == 'resta') {
                    $this->montoR = - (($this->montoB * $comis->comision) / 100) + $this->montoB;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_no == 'mantiene') {
                    $this->importe = $this->montoB;
                    $this->montoR = $this->montoB;
                }
            }
            if ($this->OrigenMotivoObjeto->afectadoNo == 'montoC') {
                if ($this->OrigenMotivoObjeto->suma_resta_no == 'suma') {
                    $this->importe = ($this->montoB * $comis->comision) / 100 + $this->montoB;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_no == 'resta') {
                    $this->importe = - (($this->montoB - $comis->comision) / 100) + $this->montoB;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_no == 'mantiene') {
                    $this->importe = $this->montoB;
                    $this->montoR = $this->montoB;
                }
            }
            if ($this->OrigenMotivoObjeto->afectadoNo == 'ambos') {
                if ($this->OrigenMotivoObjeto->suma_resta_no == 'suma') {
                    $this->montoR = ($this->montoB * $comis->comision) / 100 + $this->montoB;
                    $this->importe = ($this->montoB * $comis->comision) / 100 + $this->montoB;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_no == 'resta') {
                    $this->montoR = - (($this->montoB * $comis->comision) / 100) + $this->montoB;
                    $this->importe = - (($this->montoB * $comis->comision) / 100) + $this->montoB;
                }
                if ($this->OrigenMotivoObjeto->suma_resta_no == 'mantiene') {
                    $this->importe = $this->montoB;
                    $this->montoR = $this->montoB;
                }
            }
        }
        $this->igualarMontos = 1;
        $this->ResetRadioButton = $this->montoB;
        $this->requerimientoComision = 'LISTO';
    }
     /* RESET DE INPUT Y DEMAS */
     public function resetUI()
     {
         $this->identificador = rand();
         $this->identificador2 = rand();
 
         $this->selected_id = 0;
         $this->origen = 'Elegir';
         $this->motivo = 'Elegir';
 
         $this->montoB = '';
         $this->montoR = 0;
         $this->importe = '';
 
         $this->cedula = '';
         $this->celular = '';
         $this->codigo_transf = '';
         $this->observaciones = '';
 
         $this->origMotID = 0;
         $this->OrigenMotivoObjeto = [];
         $this->transaccion = [];
 
         $this->mostrarCI = 0;
         $this->mostrartelf = 0;
         $this->mostrarTelfCodigo = 0;
 
         $this->ClienteSelect = 0;
         $this->TelfSelect = 0;
 
         $this->igualarMontos = 0;
         $this->MostrarRadioButton = 0;
 
         $this->ResetRadioButton = 0;
         $this->condicionalComisiones = 'ABC';
         $this->condicionalOrigen = 'asd';
         $this->condicionalMotivo = 'asd';
         $this->requerimientoComision = '';
 
         $this->origenAnterior = '';
         $this->motivoAnterior = '';
         $this->telefonoAnterior = '';
         $this->cedulaAnterior = '';
         $this->destinoAnterior = '';
 
         $this->resetValidation();
     }
    /* ANULAR TRANSACCION */
    public function Anular(Transaccion $tran)
    {
        $anular = Transaccion::join('mov_transacs as mtr', 'mtr.transaccion_id', 'transaccions.id')
            ->join('movimientos as m', 'mtr.movimiento_id', 'm.id')
            ->select('m.*')
            ->where('transaccions.id', $tran->id)
            ->get();

        foreach ($anular as $mov) {
            $movimiento = Movimiento::find($mov->id);
            $movimiento->status = 'INACTIVO';
            $movimiento->save();
        }
        $tran->estado = 'Anulada';
        $tran->save();
        $this->emit('item-anulado', 'Se anuló la transacción');
    }

    public function cambiarafalse1()
    {
        $this->mostrarunavez1 = false;
    }
    public function cambiarafalse2()
    {
        $this->mostrarunavez2 = false;
    }
    /* Cargar los datos seleccionados de la tabla a los label */
    public function Seleccionar($cedula, $celular)
    {
        $this->cedula = $cedula;
        $this->celular = $celular;
        $this->ClienteSelect = 1;
        $this->TelfSelect = 1;

        $this->mostrarunavez1 = false;
        $this->mostrarunavez2 = false;

    }

}
