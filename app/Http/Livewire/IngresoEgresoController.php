<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\CarteraMovCategoria;
use App\Models\Movimiento;
use App\Models\Sucursal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class IngresoEgresoController extends Component
{

    public $fromDate,$toDate,$caja,$data,$search,$sucursal,$sucursals,$sumaTotal,$cantidad,$mov_selected,$cantidad_edit,$comentario_edit;
    public $cot_dolar = 6.96;
    public $cartera_id_edit,$type_edit;

    //Para guardar el id de la categoria cartera movimiento
    public $categoria_id, $categoria_ie_id;
  

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
        $this->caja='TODAS';
        $this->sucursal= $this->usuarioSucursal();
        //Variable para guardar el id de una categoria en la tabla principal
        $this->categoria_id = 'Todos';
        //Variable para guardar el id de una categoria en la ventana modal modalDetails
        $this->categoria_ie_id = "Elegir";
       //$this->sucursal=collect();

    }

    public function render()
    {

        if (Auth::user()->hasPermissionTo('Admin_Views') or Auth::user()->hasPermissionTo('Caja_Index'))
        {
            $this->sucursals= Sucursal::all();
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
            $this->sucursals=User::join('sucursal_users as su', 'su.user_id', 'users.id')
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
 

     
        /* MOSTRAR CARTERAS DE LA CAJA EN LA QUE SE ENCUENTRA */
        //dd($this->sucursal);

        if ($this->caja== 'TODAS')
        {
            $carterasSucursal = Cartera::join('cajas as c', 'carteras.caja_id', 'c.id')
            ->join('sucursals as s', 's.id', 'c.sucursal_id')
            ->where('s.id', $this->sucursal)
            ->select('carteras.id', 'carteras.nombre as carteraNombre', 'c.nombre as cajaNombre', 'carteras.tipo as tipo')->get();
        }
        else
        {
            $carterasSucursal = Cartera::join('cajas as c', 'carteras.caja_id', 'c.id')
            ->join('sucursals as s', 's.id', 'c.sucursal_id')
            ->where('c.id', $this->caja)
            ->select('carteras.id', 'carteras.nombre as carteraNombre', 'c.nombre as cajaNombre', 'carteras.tipo as tipo')->get();
        }
        

        foreach ($carterasSucursal as $c)
        {
            /* SUMAR TODO LOS INGRESOS DE LA CARTERA */
            $INGRESOS = Cartera::join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
                ->join('movimientos as m', 'm.id', 'cm.movimiento_id')
                ->where('cm.type','INGRESO')
                ->where('m.status', 'ACTIVO')
                //->whereBetween('m.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
                ->where('carteras.id', $c->id)->sum('m.import');
            /* SUMAR TODO LOS EGRESOS DE LA CARTERA */
            $EGRESOS = Cartera::join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
                ->join('movimientos as m', 'm.id', 'cm.movimiento_id')
                ->where('cm.type', 'EGRESO')
                ->where('m.status','ACTIVO')
                //->whereBetween('m.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
                ->where('carteras.id', $c->id)->sum('m.import');
            /* REALIZAR CALCULO DE INGRESOS - EGRESOS */
            $c->monto = $INGRESOS - $EGRESOS;
        }

        if ($this->search != null) 
        {
            if($this->categoria_id == 'Todos')
            {
                if ($this->caja == "TODAS")
                {
                    $this->data = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
                    ->join('carteras as c', 'c.id', 'crms.cartera_id')
                    ->join('cajas as ca', 'ca.id', 'c.caja_id')
                    ->join('users as u', 'u.id', 'movimientos.user_id')
                    ->leftjoin('cartera_mov_categorias as cc', 'cc.id', 'crms.cartera_mov_categoria_id')
                    ->select(
                        'movimientos.type as movimientotype',
                        'movimientos.import as import',
                        'crms.type as carteramovtype',
                        'crms.tipoDeMovimiento',
                        'crms.comentario',
                        'cc.nombre as nombrecategoria',
                        'c.nombre as nombre',
                        'c.descripcion',
                        'c.tipo',
                        'c.telefonoNum',
                        'ca.nombre as cajaNombre',
                        'u.name as usuarioNombre',
                        'movimientos.created_at as movimientoCreacion',
                        'movimientos.id as movid',
                        'movimientos.status as movstatus'
                    )
                    ->where('ca.sucursal_id', $this->sucursal)
                    ->where('crms.tipoDeMovimiento','=', 'EGRESO/INGRESO')
                    ->whereBetween('movimientos.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
                    ->where(function($querys){
                        $querys->where( 'crms.tipoDeMovimiento', 'like', '%' . $this->search . '%')
                        ->orWhere('u.name', 'like', '%' . $this->search .'%')
                        ->orWhere('crms.comentario','like','%' . $this->search . '%');
            
                    })
                    ->orderBy('movimientos.id', 'desc')
                    ->get();
                    $this->sumaTotal=$this->data->sum('import');

                }
                else
                {
                        $this->data = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
                        ->join('carteras as c', 'c.id', 'crms.cartera_id')
                        ->join('cajas as ca', 'ca.id', 'c.caja_id')
                        ->join('users as u', 'u.id', 'movimientos.user_id')
                        ->leftjoin('cartera_mov_categorias as cc', 'cc.id', 'crms.cartera_mov_categoria_id')
                        ->select(
                            'movimientos.type as movimientotype',
                            'movimientos.import as import',
                            'crms.type as carteramovtype',
                            'crms.tipoDeMovimiento',
                            'crms.comentario',
                            'cc.nombre as nombrecategoria',
                            'c.nombre as nombre',
                            'c.descripcion',
                            'c.tipo',
                            'c.telefonoNum',
                            'ca.nombre as cajaNombre',
                            'u.name as usuarioNombre',
                            'movimientos.created_at as movimientoCreacion',
                            'movimientos.id as movid',
                            'movimientos.status as movstatus'
                        )
                        ->where('ca.id', $this->caja)
                        ->where('crms.tipoDeMovimiento','=', 'EGRESO/INGRESO')
                        ->whereBetween('movimientos.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
                        ->where(function($querys){
                            $querys->where( 'crms.tipoDeMovimiento', 'like', '%' . $this->search . '%')
                            ->orWhere('u.name', 'like', '%' . $this->search .'%')
                            ->orWhere('crms.comentario','like','%' . $this->search . '%');
                
                        })
                        ->orderBy('movimientos.id', 'desc')
                        ->get();
            
                        $this->sumaTotal=$this->data->sum('import');
                

                }
            }
            else
            {
                if ($this->caja == "TODAS")
                {
                    $this->data = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
                    ->join('carteras as c', 'c.id', 'crms.cartera_id')
                    ->join('cajas as ca', 'ca.id', 'c.caja_id')
                    ->join('users as u', 'u.id', 'movimientos.user_id')
                    ->leftjoin('cartera_mov_categorias as cc', 'cc.id', 'crms.cartera_mov_categoria_id')
                    ->select(
                        'movimientos.type as movimientotype',
                        'movimientos.import as import',
                        'crms.type as carteramovtype',
                        'crms.tipoDeMovimiento',
                        'crms.comentario',
                        'cc.nombre as nombrecategoria',
                        'c.nombre as nombre',
                        'c.descripcion',
                        'c.tipo',
                        'c.telefonoNum',
                        'ca.nombre as cajaNombre',
                        'u.name as usuarioNombre',
                        'movimientos.created_at as movimientoCreacion',
                        'movimientos.id as movid',
                        'movimientos.status as movstatus'
                    )
                    ->where('cc.id', $this->categoria_id)
                    ->where('ca.sucursal_id', $this->sucursal)
                    ->where('crms.tipoDeMovimiento','=', 'EGRESO/INGRESO')
                    ->whereBetween('movimientos.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
                    ->where(function($querys){
                        $querys->where( 'crms.tipoDeMovimiento', 'like', '%' . $this->search . '%')
                        ->orWhere('u.name', 'like', '%' . $this->search .'%')
                        ->orWhere('crms.comentario','like','%' . $this->search . '%');
            
                    })
                    ->orderBy('movimientos.id', 'desc')
                    ->get();
                    $this->sumaTotal=$this->data->sum('import');

                }
                else
                {
                        $this->data = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
                        ->join('carteras as c', 'c.id', 'crms.cartera_id')
                        ->join('cajas as ca', 'ca.id', 'c.caja_id')
                        ->join('users as u', 'u.id', 'movimientos.user_id')
                        ->leftjoin('cartera_mov_categorias as cc', 'cc.id', 'crms.cartera_mov_categoria_id')
                        ->select(
                            'movimientos.type as movimientotype',
                            'movimientos.import as import',
                            'crms.type as carteramovtype',
                            'crms.tipoDeMovimiento',
                            'crms.comentario',
                            'cc.nombre as nombrecategoria',
                            'c.nombre as nombre',
                            'c.descripcion',
                            'c.tipo',
                            'c.telefonoNum',
                            'ca.nombre as cajaNombre',
                            'u.name as usuarioNombre',
                            'movimientos.created_at as movimientoCreacion',
                            'movimientos.id as movid',
                            'movimientos.status as movstatus'
                        )
                        ->where('cc.id', $this->categoria_id)
                        ->where('ca.id', $this->caja)
                        ->where('crms.tipoDeMovimiento','=', 'EGRESO/INGRESO')
                        ->whereBetween('movimientos.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
                        ->where(function($querys){
                            $querys->where( 'crms.tipoDeMovimiento', 'like', '%' . $this->search . '%')
                            ->orWhere('u.name', 'like', '%' . $this->search .'%')
                            ->orWhere('crms.comentario','like','%' . $this->search . '%');
                
                        })
                        ->orderBy('movimientos.id', 'desc')
                        ->get();
            
                        $this->sumaTotal=$this->data->sum('import');
                

                }
            }
        }
        else
        {
            if($this->categoria_id == 'Todos')
            {
                if ($this->caja == 'TODAS')
                {
                    $this->data = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
                    ->join('carteras as c', 'c.id', 'crms.cartera_id')
                    ->join('cajas as ca', 'ca.id', 'c.caja_id')
                    ->join('users as u', 'u.id', 'movimientos.user_id')
                    ->leftjoin('cartera_mov_categorias as cc', 'cc.id', 'crms.cartera_mov_categoria_id')
                    ->select(
                        'movimientos.type as movimientotype',
                        'movimientos.import as import',
                        'crms.type as carteramovtype',
                        'crms.tipoDeMovimiento',
                        'crms.comentario',
                        'cc.nombre as nombrecategoria',
                        'c.nombre as nombre',
                        'c.descripcion',
                        'c.tipo',
                        'c.telefonoNum',
                        'ca.nombre as cajaNombre',
                        'u.name as usuarioNombre',
                        'movimientos.created_at as movimientoCreacion',
                        'movimientos.id as movid',
                        'movimientos.status as movstatus'
                    )
                    ->where('ca.sucursal_id', $this->sucursal)
                    ->where('crms.tipoDeMovimiento','=', 'EGRESO/INGRESO')
                    ->whereBetween('movimientos.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
                    ->orderBy('movimientos.id', 'desc')
                    ->get();   

                  
                    $this->sumaTotal=$this->data->sum('import');
                }
                else
                {
                    $this->data = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
                    ->join('carteras as c', 'c.id', 'crms.cartera_id')
                    ->join('cajas as ca', 'ca.id', 'c.caja_id')
                    ->join('users as u', 'u.id', 'movimientos.user_id')
                    ->leftjoin('cartera_mov_categorias as cc', 'cc.id', 'crms.cartera_mov_categoria_id')
                    ->select(
                        'movimientos.type as movimientotype',
                        'movimientos.import as import',
                        'crms.type as carteramovtype',
                        'crms.tipoDeMovimiento',
                        'crms.comentario',
                        'cc.nombre as nombrecategoria',
                        'c.nombre as nombre',
                        'c.descripcion',
                        'c.tipo',
                        'c.telefonoNum',
                        'ca.nombre as cajaNombre',
                        'u.name as usuarioNombre',
                        'movimientos.created_at as movimientoCreacion',
                        'movimientos.id as movid',
                        'movimientos.status as movstatus'
                    )
                    ->where('ca.id', $this->caja)
                    ->where('crms.tipoDeMovimiento','=', 'EGRESO/INGRESO')
                    ->whereBetween('movimientos.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
                    ->orderBy('movimientos.id', 'desc')
                    ->get();
                    $this->sumaTotal=$this->data->sum('import');
                }
            }
            else
            {
                if ($this->caja == 'TODAS')
                {
                    $this->data = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
                    ->join('carteras as c', 'c.id', 'crms.cartera_id')
                    ->join('cajas as ca', 'ca.id', 'c.caja_id')
                    ->join('users as u', 'u.id', 'movimientos.user_id')
                    ->leftjoin('cartera_mov_categorias as cc', 'cc.id', 'crms.cartera_mov_categoria_id')
                    ->select(
                        'movimientos.type as movimientotype',
                        'movimientos.import as import',
                        'crms.type as carteramovtype',
                        'crms.tipoDeMovimiento',
                        'crms.comentario',
                        'cc.nombre as nombrecategoria',
                        'c.nombre as nombre',
                        'c.descripcion',
                        'c.tipo',
                        'c.telefonoNum',
                        'ca.nombre as cajaNombre',
                        'u.name as usuarioNombre',
                        'movimientos.created_at as movimientoCreacion',
                        'movimientos.id as movid',
                        'movimientos.status as movstatus'
                    )
                    ->where('cc.id', $this->categoria_id)
                    ->where('ca.sucursal_id', $this->sucursal)
                    ->where('crms.tipoDeMovimiento','=', 'EGRESO/INGRESO')
                    ->whereBetween('movimientos.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
                    ->orderBy('movimientos.id', 'desc')
                    ->get();   
                  
                    $this->sumaTotal=$this->data->sum('import');
                }
                else
                {
    
                    $this->data = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
                    ->join('carteras as c', 'c.id', 'crms.cartera_id')
                    ->join('cajas as ca', 'ca.id', 'c.caja_id')
                    ->join('users as u', 'u.id', 'movimientos.user_id')
                    ->leftjoin('cartera_mov_categorias as cc', 'cc.id', 'crms.cartera_mov_categoria_id')
                    ->select(
                        'movimientos.type as movimientotype',
                        'movimientos.import as import',
                        'crms.type as carteramovtype',
                        'crms.tipoDeMovimiento',
                        'crms.comentario',
                        'cc.nombre as nombrecategoria',
                        'c.nombre as nombre',
                        'c.descripcion',
                        'c.tipo',
                        'c.telefonoNum',
                        'ca.nombre as cajaNombre',
                        'u.name as usuarioNombre',
                        'movimientos.created_at as movimientoCreacion',
                        'movimientos.id as movid',
                        'movimientos.status as movstatus'
                    )
                    ->where('cc.id', $this->categoria_id)
                    ->where('ca.id', $this->caja)
                    ->where('crms.tipoDeMovimiento','=', 'EGRESO/INGRESO')
                    ->whereBetween('movimientos.created_at',[ Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00',Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59'])
                    ->orderBy('movimientos.id', 'desc')
                    ->get();
                    $this->sumaTotal=$this->data->sum('import');
                }
            }
        }

        $grouped= $carterasSucursal->groupBy('cajaNombre');
       // dd($grouped);
     

        //Listando todas las categorias con estado activo
       $categorias = CarteraMovCategoria::select("cartera_mov_categorias.*")
       ->where("cartera_mov_categorias.status", "ACTIVO")
       ->get();

       $detalle = null;

       if($this->type != "Elegir")
       {
           $categorias_ie = CarteraMovCategoria::select("cartera_mov_categorias.*")
           ->where("cartera_mov_categorias.status", "ACTIVO")
           ->where("cartera_mov_categorias.tipo", $this->type)
           ->get();
            if($this->categoria_ie_id != "Elegir")
            {
                //Guardando el detalle de la categoria seleccionada
                $detalle = CarteraMovCategoria::find($this->categoria_ie_id)->detalle;
            }


       }
       else
       {
           $categorias_ie = [];
       }


        return view('livewire.reportemovimientoresumen.ingresoegreso',[
            'carterasSucursal'=>$carterasSucursal,
            'grouped'=>$grouped,
            'cajas2'=> $cajab,
            'data'=>$this->data,
            'categorias'=>$categorias,
            'categorias_ie'=>$categorias_ie,
            'detalle'=>$detalle


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
            'categoria_ie_id' => 'required|not_in:Elegir',
            'cantidad' => 'required|not_in:0',
            'comentario' => 'required',
        ];
        $messages = [ /* mensajes de validaciones */
            'type.not_in' => 'Seleccione un valor distinto a Elegir',
            'type.not_in' => 'Seleccione un valor distinto a Elegir',
            'cartera_id.not_in' => 'Seleccione un valor distinto a Elegir',
            'cartera_id.not_in' => 'Seleccione un valor distinto a Elegir',

            'categoria_ie_id.required' => 'Seleccione una Categoria',
            'categoria_ie_id.not_in' => 'Seleccione una Categoria distinto a Elegir',

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
            'movimiento_id' => $mvt->id,
            'cartera_mov_categoria_id' => $this->categoria_ie_id
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
        $this->emit('hide-modal');
    }

    public function usuarioSucursal(){
        $SucursalUsuario = User::join('sucursal_users as su', 'su.user_id', 'users.id')
        ->join('sucursals as s', 's.id', 'su.sucursal_id')
        ->where('users.id', Auth()->user()->id)
        ->where('su.estado', 'ACTIVO')
        ->select('s.*')
        ->get()->first();

        return $SucursalUsuario->id;
    }


    public function generarpdf($data)
    {
        session(['ingresos' => $data]);
 
        session(['ingresossumatotal' => $this->sumaTotal]);//
      

        //Sucursal, Caja, Fecha de Inicio y Fecha de Fin
        $caracteristicas = array($this->sucursal, $this->caja, $this->fromDate, $this->toDate);
        session(['caracteristicas' => $caracteristicas]);

        //Redireccionando para crear el comprobante con sus respectvas variables
        //return redirect::to('report/pdfmovdiaresumen');

        $this->emit('openothertap');
    }

    protected $listeners= ['eliminar_operacion'=>'anularOperacion'];

    public function anularOperacion(Movimiento $mov)
    {

        
        $mov->update([
            'status' => 'INACTIVO'
            ]);
        $mov->save();

    }
        
    public function editarOperacion(Movimiento $mov)
    {

    
        $this->cantidad_edit=$mov->import;
    
        $this->cartera_id_edit=$mov->cartmov[0]->cartera_id;
        $this->type_edit=$mov->cartmov[0]->type;
        $this->comentario_edit=$mov->cartmov[0]->comentario;
        $this->mov_selected=$mov;
        $this->emit('editar-movimiento');
    }

    public function guardarEdicion()
    {

        $mov=Movimiento::find($this->mov_selected->id);
        
        $mov->update([
            'import' => $this->cantidad_edit
            ]);
        $mov->save();


        CarteraMov::find($mov->cartmov[0]->id)->update([
            'comentario'=>$this->comentario_edit
        ]);

        $this->resetUIedit();

    }

    public function resetUIedit()
    {
        $this->cartera_id_edit = 'Elegir';
        $this->type_edit = 'Elegir';
        $this->cantidad_edit = '';
        $this->comentario_edit = '';
        $this->emit('hide_editar');
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