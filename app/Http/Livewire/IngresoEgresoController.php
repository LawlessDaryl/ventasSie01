<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\Movimiento;
use App\Models\Sucursal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class IngresoEgresoController extends Component
{

    public $fromDate,$toDate,$caja,$data,$search,$sucursal;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Movimientos';
        $this->selected_id = 0;
        $this->opciones = 'TODAS';
        $this->cartera_id = 'Elegir';
        $this->type = 'Elegir';
        $this->cantidad = '';
        $this->comentario = '';
        $this->fromDate= Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->toDate=  Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->caja=1;


    }

    public function render()
    {



        if (Auth::user()->hasPermissionTo('Admin_Views'))
        {
            $sucursals= Sucursal::all();
            if ($this->sucursal == 'TODAS')
            {
                $cajab=Caja::where('cajas.nombre','!=','Caja General')->get();
            }
            else
            {
                $cajab=Caja::where('cajas.sucursal_id',$this->sucursal)->where('cajas.nombre','!=','Caja General')->get();

            }
        }
        else
        {
            $sucursals=User::join('sucursal_users as su', 'su.user_id', 'users.id')
                        ->join('sucursals as s', 's.id', 'su.sucursal_id')
                        ->where('users.id', Auth()->user()->id)
                        ->where('su.estado', 'ACTIVO')
                        ->select('s.*')
                        ->get();
            //dd($sucursales);

            $cajab=Caja::where('cajas.sucursal_id',$this->sucursal)->where('cajas.nombre','!=','Caja General')->get();
        }



        // $carterasSucursal = Cartera::join('cajas as c', 'carteras.caja_id', 'c.id')
        // ->join('sucursals as s', 's.id', 'c.sucursal_id')
        // ->where('s.id', $this->sucursalid)
        // ->select('carteras.id', 'carteras.nombre as carteraNombre', 'c.nombre as cajaNombre', 'carteras.tipo as tipo', DB::raw('0 as monto'))->get();
 

        $SucursalUsuario = User::join('sucursal_users as su', 'su.user_id', 'users.id')
        ->join('sucursals as s', 's.id', 'su.sucursal_id')
        ->where('users.id', Auth()->user()->id)
        ->where('su.estado', 'ACTIVO')
        ->select('s.*')
        ->get()->first();
    /* MOSTRAR CARTERAS DE LA CAJA EN LA QUE SE ENCUENTRA */
        $carterasSucursal = Cartera::join('cajas as c', 'carteras.caja_id', 'c.id')
        ->join('sucursals as s', 's.id', 'c.sucursal_id')
        ->where('s.id', $SucursalUsuario->id)
        ->select('carteras.id', 'carteras.nombre as carteraNombre', 'c.nombre as cajaNombre', 'carteras.tipo as tipo')->get();

        foreach ($carterasSucursal as $c) {
            /* SUMAR TODO LOS INGRESOS DE LA CARTERA */
            $INGRESOS = Cartera::join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
                ->join('movimientos as m', 'm.id', 'cm.movimiento_id')
                ->where('cm.type','INGRESO')
                ->where('m.status', 'ACTIVO')
                ->whereBetween('m.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
                ->where('carteras.id', $c->id)->sum('m.import');
            /* SUMAR TODO LOS EGRESOS DE LA CARTERA */
            $EGRESOS = Cartera::join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
                ->join('movimientos as m', 'm.id', 'cm.movimiento_id')
                ->where('cm.type', 'EGRESO')
                ->where('m.status','ACTIVO')
                ->whereBetween('m.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
                ->where('carteras.id', $c->id)->sum('m.import');
            /* REALIZAR CALCULO DE INGRESOS - EGRESOS */
            $c->monto = $INGRESOS - $EGRESOS;
        }

        if ($this->search != null) 
        {
           
            $this->data = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
            ->join('carteras as c', 'c.id', 'crms.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('users as u', 'u.id', 'movimientos.user_id')
            ->select(
                'movimientos.type as movimientotype',
                'movimientos.import as import',
                'crms.type as carteramovtype',
                'crms.tipoDeMovimiento',
                'crms.comentario',
                'c.nombre as nombre',
                'c.descripcion',
                'c.tipo',
                'c.telefonoNum',
                'ca.nombre as cajaNombre',
                'u.name as usuarioNombre',
                'movimientos.created_at as movimientoCreacion',
            )
            ->where('ca.id', $this->caja)
            ->whereBetween('movimientos.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
            ->where(function($querys){
                $querys->where( 'crms.tipoDeMovimiento', 'like', '%' . $this->search . '%')
                ->orWhere('u.name', 'like', '%' . $this->search .'%')
                ->orWhere('crms.comentario','like','%' . $this->search . '%');
            })
            ->orderBy('movimientos.id', 'desc')
            ->get();
        
        }
        else{

    
    
            $this->data = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
            ->join('carteras as c', 'c.id', 'crms.cartera_id')
            ->join('cajas as ca', 'ca.id', 'c.caja_id')
            ->join('users as u', 'u.id', 'movimientos.user_id')
            ->select(
                'movimientos.type as movimientotype',
                'movimientos.import as import',
                'crms.type as carteramovtype',
                'crms.tipoDeMovimiento',
                'crms.comentario',
                'c.nombre as nombre',
                'c.descripcion',
                'c.tipo',
                'c.telefonoNum',
                'ca.nombre as cajaNombre',
                'u.name as usuarioNombre',
                'movimientos.created_at as movimientoCreacion',
            )
            ->where('ca.id', $this->caja)
            ->whereBetween('movimientos.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
            ->orderBy('movimientos.id', 'desc')
            ->get();
        }

     


        return view('livewire.reportemovimientoresumen.ingresoegreso',[
            'carterasSucursal'=>$carterasSucursal,
            'cajas2'=> Caja::all(),
            'data'=>$this->data
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function viewDetails()
    {
        $this->emit('show-modal', 'open modal');
    }

    public function Generar()
    {
        $rules = [ /* Reglas de validacion */
            'type' => 'required|not_in:Elegir',
            'cartera_id' => 'required|not_in:Elegir',
            'cantidad' => 'required|not_in:0',
            'comentario' => 'required',
        ];
        $messages = [ /* mensajes de validaciones */
            'type.not_in' => 'Seleccione un valor distinto a Elegir',
            'type.not_in' => 'Seleccione un valor distinto a Elegir',
            'cartera_id.not_in' => 'Seleccione un valor distinto a Elegir',
            'cartera_id.not_in' => 'Seleccione un valor distinto a Elegir',
            'cantidad.required' => 'Ingrese un monto válido',
            'cantidad.not_in' => 'Ingrese un monto válido',
            'comentario.required' => 'El comentario es obligatorio',
        ];

        $this->validate($rules, $messages);

        $mvt = Movimiento::create([
            'type' => 'TERMINADO',
            'status' => 'ACTIVO',
            'import' => $this->cantidad,
            'user_id' => Auth()->user()->id,
        ]);

        CarteraMov::create([
            'type' => $this->type,
            'tipoDeMovimiento' => 'EGRESO/INGRESO',
            'comentario' => $this->comentario,
            'cartera_id' => $this->cartera_id,
            'movimiento_id' => $mvt->id
        ]);

        $this->emit('hide-modal', 'Se generó el ingreso/egreso');
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->cartera_id = 'Elegir';
        $this->type = 'Elegir';
        $this->cantidad = '';
        $this->comentario = '';
    }

}

//datos de apertura

// apertura        10441.28
// recaudo 1900


// ferrufino
// apertura 2729
// recaudo 510

// peru
//  apertura  731.5
// recaudo 260