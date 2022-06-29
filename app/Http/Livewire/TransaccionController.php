<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\Cliente;
use App\Models\ClienteMov;
use App\Models\Comision;
use App\Models\Transaccion;
use Exception;
use Illuminate\Support\Carbon;
use Livewire\Component;
use App\Models\Motivo;
use App\Models\Movimiento;
use App\Models\MovTransac;
use App\Models\Origen;
use App\Models\OrigenMotivo;
use App\Models\OrigenMotivoComision;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class TransaccionController extends Component
{
    use WithPagination;

    public $pageTitle, $componentName, $selected_id, $search, $montoCobrarPagar,

        $origen, $motivo,

        $montoB, $montoR, $importe,

        $cedula, $celular, $codigo_transf, $observaciones,

        $mostrarCI, $mostrartelf, $mostrarTelfCodigo,

        $igualarMontos,

        $ResetRadioButton, $requerimientoComision,

        $condicionalOrigen, $condicionalMotivo,

        $origMotID, $OrigenMotivoObjeto,

        $ClienteSelect, $TelfSelect, $MostrarRadioButton,

        $transaccion,

        $origenAnterior = 'Elegir', $motivoAnterior = 'Elegir', $telefonoAnterior, $cedulaAnterior, $destinoAnterior;

    public $identificador, $identificador2;

    public $datosPorCedula, $datosPorTelefono;

    private $pagination = 10;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->identificador = rand();
        $this->identificador2 = rand();

        $this->pageTitle = 'Transacciones del día';
        $this->componentName = 'TIGO MONEY';
        $this->montoCobrarPagar = 'Monto a cobrar/pagar';

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
        $this->condicionalOrigen = 'asd';
        $this->condicionalMotivo = 'asd';
        $this->requerimientoComision = '';

        $this->origenAnterior = '';
        $this->motivoAnterior = '';
        $this->telefonoAnterior = '';
        $this->cedulaAnterior = '';
        $this->destinoAnterior = '';

        $this->datosPorCedula = [];
        $this->datosPorTelefono = [];
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
                ->where('c.cedula', 'like', '%' . $this->search . '%')
                ->orWhere('ori.nombre', 'like', '%' . $this->search . '%')
                ->orWhere('mot.nombre', 'like', '%' . $this->search . '%')
                ->where('ca.id', $cajausuario->id)
                ->orderBy('transaccions.created_at', 'desc')
                ->paginate($this->pagination);
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
                ->where('ca.id', $cajausuario->id)
                ->orderBy('transaccions.created_at', 'desc')
                ->paginate($this->pagination);
        }
        try {
            /* LISTADO DE MOTIVOS DE ESE ORIGEN */
            if ($this->origen != 'Elegir') {
                $motivos = OrigenMotivo::join('motivos as m', 'm.id', 'origen_motivos.motivo_id')
                    ->select('m.*')->where('origen_motivos.origen_id', $this->origen)->get();
            } else {
                $motivos = [];
            }
        } catch (Exception $e) {
            $this->emit('item-error', 'ERROR linea 1' . $e->getMessage());
        }
        try {
            /* BUSCAR CLIENTE POR CEDULA EN EL INPUT DEL MODAL */
            if ($this->cedula != '' && $this->ClienteSelect == 0) {
                $this->datosPorCedula = Cliente::where('cedula', 'like', $this->cedula . '%')->orderBy('cedula', 'desc')->get();
            } else {
                $this->datosPorCedula = [];
            }
        } catch (Exception $e) {
            $this->emit('item-error', 'ERROR linea 2' . $e->getMessage());
        }
        try {
            /* BUSCAR CLIENTE POR TELEFONO EN EL INPUT DEL MODAL */
            if ($this->celular != '' && $this->TelfSelect == 0) {
                $this->datosPorTelefono = Cliente::where('celular', 'like', $this->celular . '%')->orderBy('celular', 'desc')->get();
            } else {
                $this->datosPorTelefono = [];
            }
        } catch (Exception $e) {
            $this->emit('item-error', 'ERROR linea 3' . $e->getMessage());
        }

        try {
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
        } catch (Exception $e) {
            $this->emit('item-error', 'ERROR linea 4' . $e->getMessage());
        }
        try {
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
        } catch (Exception $e) {
            $this->emit('item-error', 'ERROR linea 5' . $e->getMessage());
        }

        try {
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
        } catch (Exception $e) {
            $this->emit('item-error', 'ERROR linea 6' . $e->getMessage());
        }
        try {
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
        } catch (Exception $e) {
            $this->emit('item-error', 'ERROR linea 7' . $e->getMessage());
        }

        try {
            /* Monto a registrar igual a importe si variable igualarMontos es igual a 0
        (cambia a 1 cuando se ejecutan las comisiones) */
            if ($this->igualarMontos == 0) {
                $this->montoR = $this->montoB;
                $this->importe = $this->montoB;
            }
        } catch (Exception $e) {
            $this->emit('item-error', 'ERROR linea 8' . $e->getMessage());
        }
        try {
            /* Calcular comision cuando cuando comision_si_no de origen_motivo es nopreguntar pero si son afectados los montos */
            if ($this->origMotID != 0 && $this->montoB != '' && $this->igualarMontos == 0) {
                if ($this->OrigenMotivoObjeto->comision_si_no == 'nopreguntar' && ($this->OrigenMotivoObjeto->suma_resta_si != 'mantiene' || $this->OrigenMotivoObjeto->suma_resta_no != 'mantiene')) {
                    $this->importe = $this->montoB;
                    $this->montoR = $this->montoB;
                    $this->ComisionSi();
                }
            }
        } catch (Exception $e) {
            $this->emit('item-error', 'ERROR linea 9' . $e->getMessage());
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


        return view('livewire.transaccion.component', [
            'data' => $data,
            'origenes' => $carterasDe,
            'motivos' => $motivos,
            'carterasCaja' => $carterasCaja,
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    /* Cargar los datos seleccionados de la tabla a los label */
    public function Seleccionar($cedula, $celular)
    {
        $this->cedula = $cedula;
        $this->celular = $celular;
        $this->ClienteSelect = 1;
        $this->TelfSelect = 1;
    }
    /* Cargar los datos seleccionados de la tabla a los label */
    public function SeleccionarTelf($celular)
    {
        $this->celular = $celular;
        $this->ClienteSelect = 1;
        $this->TelfSelect = 1;
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

    public function nuevatransaccion()
    {
        $this->resetUI();
        $this->emit('show-modal', '');
    }

    /* REGISTRAR TRANSACCION */
    public function Store()
    {
        $rules = [ /* Reglas de validacion */
            'cedula' => 'required_if:mostrarCI,1',
            'celular' => 'required_if:mostrartelf,1',
            'codigo_transf' => 'required_if:mostrarTelfCodigo,1',
            'motivo' => 'required|not_in:Elegir',
            'origen' => 'required|not_in:Elegir',
            'montoB' => 'required|numeric|min:1|not_in:0',
        ];
        $messages = [ /* mensajes de validaciones */
            'cedula.required_if' => 'Ingrese la cedula del solicitante',
            'celular.required_if' => 'Ingrese el teléfono del solicitante',
            'codigo_transf.required_if' => 'Ingresa el telefono de transferencia/codigo del solicitate',
            'motivo.required' => 'Seleccione un valor distinto a Elegir',
            'motivo.not_in' => 'Seleccione un valor distinto a Elegir',
            'origen.required' => 'Seleccione un valor distinto a Elegir',
            'origen.not_in' => 'Seleccione un valor distinto a Elegir',
            'montoB.required' => 'Ingrese un monto válido',
            'montoB.min' => 'Ingrese un monto mayor a 0',
            'montoB.not_in' => 'Ingrese un monto válido',
            'montoB.integer' => 'El monto debe ser un número',
        ];

        $this->validate($rules, $messages);

        /* Obtener al cliente con la cedula */
        $listaCL = Cliente::where('cedula', $this->cedula)
            ->get()
            ->first();

        /* obtener id de la caja en la cual se encuentra el usuario */
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

        /* obtener cartera fisica de la caja en la cual esta el usuario */
        $CajaFisica = Cartera::where('tipo', 'cajafisica')
            ->where('caja_id', $cccc->id)
            ->get()->first();

        /* obtener origen */
        $origen = Origen::find($this->origen);

        /* obtener la cartera con el mismo nombre del origen */
        $cartera = Cartera::where('tipo', $origen->nombre)
            ->where('caja_id', $cccc->id)->get()->first();

        DB::beginTransaction();
        try {
            if ($listaCL) { /* Actualizar telefono del cliente */
                if ($listaCL->celular != $this->celular) {
                    $listaCL->celular = $this->celular;
                    $listaCL->save();
                }
            } else { /* Registrar un nuevo cliente */
                $listaCL = Cliente::create([
                    'cedula' => $this->cedula,
                    'celular' => $this->celular,
                    'procedencia_cliente_id' => 1,
                ]);
            }
            $motiv = Motivo::find($this->motivo);
            if ($motiv->tipo == 'Retiro') { /* crear movimientos y cartera-movimiento cuando es un retiro */
                $mv = Movimiento::create([
                    'type' => 'TERMINADO',
                    'status' => 'ACTIVO',
                    'import' => $this->montoR,
                    'user_id' => Auth()->user()->id,
                ]);

                CarteraMov::create([
                    'type' => 'INGRESO',
                    'tipoDeMovimiento' => 'TIGOMONEY',
                    'comentario' => '',
                    'cartera_id' => $cartera->id,
                    'movimiento_id' => $mv->id
                ]);

                $mvt = Movimiento::create([
                    'type' => 'TERMINADO',
                    'status' => 'ACTIVO',
                    'import' => $this->importe,
                    'user_id' => Auth()->user()->id,
                ]);

                CarteraMov::create([
                    'type' => 'EGRESO',
                    'tipoDeMovimiento' => 'TIGOMONEY',
                    'comentario' => '',
                    'cartera_id' => $CajaFisica->id,
                    'movimiento_id' => $mvt->id
                ]);

                $lista = OrigenMotivoComision::join('comisions as c', 'origen_motivo_comisions.comision_id', 'c.id')
                    ->where('c.monto_inicial', '<=', $this->montoB)
                    ->where('c.monto_final', '>=', $this->montoB)
                    ->where('origen_motivo_comisions.origen_motivo_id', $this->origMotID)
                    ->where('c.tipo', 'Propia')
                    ->select('c.id')->get()->first();

                if ($lista) {

                    $comis = Comision::find($lista->id);

                    if ($comis->porcentaje == 'Desactivo') {
                        $ganancia = $comis->comision;
                    } else {
                        $ganancia = ($this->montoB * $comis->comision) / 100;
                    }

                    $this->transaccion = Transaccion::create([
                        'codigo_transf' => $this->codigo_transf,
                        'importe' => $this->importe,
                        'observaciones' => $this->observaciones,
                        'telefono' => $this->celular,
                        'ganancia' => $ganancia,
                        'origen_motivo_id' => $this->origMotID
                    ]);
                } else {
                    $this->emit('item-error', "Esta transacción no tiene una comision de ganancia");
                    $ganancia = 0;
                    $this->transaccion = Transaccion::create([
                        'codigo_transf' => $this->codigo_transf,
                        'importe' => $this->importe,
                        'observaciones' => $this->observaciones,
                        'telefono' => $this->celular,
                        'ganancia' => $ganancia,
                        'origen_motivo_id' => $this->origMotID
                    ]);
                }
            } elseif ($motiv->nombre == 'Abono por CI') {   /* si es abono por ci */
                $mv = Movimiento::create([
                    'type' => 'TERMINADO',
                    'status' => 'ACTIVO',
                    'import' => $this->importe,
                    'user_id' => Auth()->user()->id,
                ]);

                CarteraMov::create([
                    'type' => 'INGRESO',
                    'tipoDeMovimiento' => 'TIGOMONEY',
                    'comentario' => '',
                    'cartera_id' => $CajaFisica->id,
                    'movimiento_id' => $mv->id,
                ]);

                $mvt = Movimiento::create([
                    'type' => 'TERMINADO',
                    'status' => 'ACTIVO',
                    'import' => $this->importe,
                    'user_id' => Auth()->user()->id,
                ]);

                CarteraMov::create([
                    'type' => 'EGRESO',
                    'tipoDeMovimiento' => 'TIGOMONEY',
                    'comentario' => '',
                    'cartera_id' => $cartera->id,
                    'movimiento_id' => $mvt->id
                ]);

                $lista = OrigenMotivoComision::join('comisions as c', 'origen_motivo_comisions.comision_id', 'c.id')
                    ->where('c.monto_inicial', '<=', $this->montoB)
                    ->where('c.monto_final', '>=', $this->montoB)
                    ->where('origen_motivo_comisions.origen_motivo_id', $this->origMotID)
                    ->where('c.tipo', 'Propia')
                    ->select('c.id')->get()->first();

                if ($lista) {

                    $comis = Comision::find($lista->id);

                    if ($comis->porcentaje == 'Desactivo') {
                        $ganancia = $comis->comision;
                    } else {
                        $ganancia = ($this->montoB * $comis->comision) / 100;
                    }

                    $this->transaccion = Transaccion::create([
                        'codigo_transf' => $this->codigo_transf,
                        'importe' => $this->importe,
                        'observaciones' => $this->observaciones,
                        'telefono' => $this->celular,
                        'ganancia' => $ganancia,
                        'origen_motivo_id' => $this->origMotID
                    ]);
                } else {
                    $this->emit('item-error', "Esta transacción no tiene una comision de ganancia");
                    $ganancia = 0;
                    $this->transaccion = Transaccion::create([
                        'codigo_transf' => $this->codigo_transf,
                        'importe' => $this->importe,
                        'observaciones' => $this->observaciones,
                        'telefono' => $this->celular,
                        'ganancia' => $ganancia,
                        'origen_motivo_id' => $this->origMotID
                    ]);
                }
            } else { /* Si es un abono */
                $mv = Movimiento::create([
                    'type' => 'TERMINADO',
                    'status' => 'ACTIVO',
                    'import' => $this->montoR,
                    'user_id' => Auth()->user()->id,
                ]);

                CarteraMov::create([
                    'type' => 'INGRESO',
                    'tipoDeMovimiento' => 'TIGOMONEY',
                    'comentario' => '',
                    'cartera_id' => $CajaFisica->id,
                    'movimiento_id' => $mv->id
                ]);

                if ($motiv->nombre == 'Recarga') {
                    $importeEgresoRecarga = $this->importe - ($this->importe * 8) / 100;
                    $mvt = Movimiento::create([
                        'type' => 'TERMINADO',
                        'status' => 'ACTIVO',
                        'import' => $importeEgresoRecarga,
                        'user_id' => Auth()->user()->id,
                    ]);
                } else {
                    $mvt = Movimiento::create([
                        'type' => 'TERMINADO',
                        'status' => 'ACTIVO',
                        'import' => $this->importe,
                        'user_id' => Auth()->user()->id,
                    ]);
                }

                CarteraMov::create([
                    'type' => 'EGRESO',
                    'tipoDeMovimiento' => 'TIGOMONEY',
                    'comentario' => '',
                    'cartera_id' => $cartera->id,
                    'movimiento_id' => $mvt->id
                ]);

                $lista = OrigenMotivoComision::join('comisions as c', 'origen_motivo_comisions.comision_id', 'c.id')
                    ->where('c.monto_inicial', '<=', $this->montoB)
                    ->where('c.monto_final', '>=', $this->montoB)
                    ->where('origen_motivo_comisions.origen_motivo_id', $this->origMotID)
                    ->where('c.tipo', 'Propia')
                    ->select('c.id')->get()->first();
                if ($lista) {

                    $comis = Comision::find($lista->id);

                    if ($comis->porcentaje == 'Desactivo') {
                        $ganancia = $comis->comision;
                    } else {
                        $ganancia = ($this->montoB * $comis->comision) / 100;
                    }

                    $this->transaccion = Transaccion::create([
                        'codigo_transf' => $this->codigo_transf,
                        'importe' => $this->importe,
                        'observaciones' => $this->observaciones,
                        'telefono' => $this->celular,
                        'ganancia' => $ganancia,
                        'origen_motivo_id' => $this->origMotID
                    ]);
                } else {
                    $this->emit('item-error', "Esta transacción no tiene una comision de ganancia");
                    $ganancia = 0;
                    $this->transaccion = Transaccion::create([
                        'codigo_transf' => $this->codigo_transf,
                        'importe' => $this->importe,
                        'observaciones' => $this->observaciones,
                        'telefono' => $this->celular,
                        'ganancia' => $ganancia,
                        'origen_motivo_id' => $this->origMotID
                    ]);
                }
            }

            ClienteMov::create([
                'movimiento_id' => $mvt->id,
                'cliente_id' => $listaCL->id
            ]);
            /* crear movimientos-transaccion de la transaccion */
            MovTransac::create([
                'movimiento_id' => $mvt->id,
                'transaccion_id' => $this->transaccion->id
            ]);
            MovTransac::create([
                'movimiento_id' => $mv->id,
                'transaccion_id' => $this->transaccion->id
            ]);
            DB::commit();
            $this->origenAnterior = $this->origen;
            $this->motivoAnterior = $this->motivo;
            $this->telefonoAnterior = $this->celular;
            $this->cedulaAnterior = $this->cedula;
            $this->destinoAnterior = $this->codigo_transf;
            $this->resetUI();
            $this->emit('item-added', 'Transacción Registrada');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

    /* LISTENERS */
    protected $listeners = ['deleteRow' => 'Anular'];
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

    public function VerObservaciones(Transaccion $tr)
    {
        $this->selected_id = $tr->id;
        $this->observaciones = $tr->observaciones;
        $this->emit('show-modal3', 'open modal');
    }

    public function Modificar()
    {
        $tr = Transaccion::find($this->selected_id);
        $tr->observaciones = $this->observaciones;
        $tr->save();
        $this->resetUI();
        $this->emit('item-actualizado', 'Se actulizaron las observaciones');
    }

    public function CargarAnterior()
    {
        $this->origen = $this->origenAnterior;
        $this->motivo = $this->motivoAnterior;
        $this->celular = $this->telefonoAnterior;
        $this->cedula = $this->cedulaAnterior;
        $this->codigo_transf = $this->destinoAnterior;
        $this->ClienteSelect = 1;
        $this->TelfSelect = 1;
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
}
