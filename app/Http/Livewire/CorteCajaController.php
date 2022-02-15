<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\Movimiento;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class CorteCajaController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public  $search, $monto, $tipocorte, $caja_id, $user_id, $selected_id;
    public  $pageTitle, $componentName, $data, $habilitado, $carteras;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Corte Caja';
        $this->tipocorte = 'Elegir';
        $this->data = [];
        $this->carteras = [];
        $this->selected_id = 0;
        $this->habilitado = 0;
    }
    public function render()
    {
        $this->Cargar();
        return view('livewire.cortecaja.component', [
            'data' => $this->data
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function Cargar()
    {
        /* TUPLA DE LA TABLA SUCURSAL-USER PARA OBTENER SU ID */
        $idsu = User::join('sucursal_users as su', 'su.user_id', 'users.id')
            ->where('su.user_id', Auth()->user()->id)
            ->select('su.id')
            ->orderBy('su.id', 'desc')
            ->first();
        /* Verificar si el usuario tiene un corte de caja en estado activo */
        $datas = User::join('movimientos as m', 'users.id', 'm.user_id')
            ->where('m.user_id', Auth()->user()->id)
            ->where('m.status', 'ACTIVO')
            ->where('m.type', 'APERTURA')
            ->get();

        if ($datas->count() > 0) { /* SI TIENE UNA CAJA ABIERTA */
            $this->data = Caja::join('sucursals as s', 's.id', 'cajas.sucursal_id')
                ->join('sucursal_users as su', 'su.sucursal_id', 's.id')
                ->join('carteras as car', 'cajas.id', 'car.caja_id')
                ->join('cartera_movs as cartmovs', 'car.id', 'cartmovs.cartera_id')
                ->join('movimientos as mov', 'mov.id', 'cartmovs.movimiento_id')
                ->where('mov.user_id', Auth()->user()->id)
                ->where('mov.status', 'ACTIVO')
                ->where('mov.type', 'APERTURA')
                ->select('cajas.*', 's.name as sucursal')
                ->get()->take(1);
            $this->habilitado = 1;
        } else { /* SI NO TIENE UNA CAJA ABIERTA */
            $this->data = Caja::join('sucursals as s', 's.id', 'cajas.sucursal_id')
                ->join('sucursal_users as su', 'su.sucursal_id', 's.id')
                ->where('su.id', $idsu->id)
                ->where('cajas.estado', 'Cerrado')
                ->select('cajas.*', 's.name as sucursal')
                ->get();
        }
    }

    public function getDetails(Caja $caja) /* MOSTRAR O NO MOSTRAR MODAL */
    {

        $this->selected_id = $caja->id;
        $this->carteras = Cartera::where('caja_id', $caja->id)
            ->select('id', 'nombre', 'descripcion', DB::raw('0 as monto'))->get();
        if ($this->carteras->count()) {

            foreach ($this->carteras as $c) {
                /* SUMAR TODO LOS INGRESOS DE LA CARTERA */
                $MONTO = Cartera::join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
                    ->join('movimientos as m', 'm.id', 'cm.movimiento_id')
                    ->where('cm.type', 'INGRESO')
                    ->where('m.status', 'ACTIVO')
                    ->where('carteras.id', $c->id)->sum('m.import');
                /* SUMAR TODO LOS EGRESOS DE LA CARTERA */
                $MONTO2 = Cartera::join('cartera_movs as cm', 'carteras.id', 'cm.cartera_id')
                    ->join('movimientos as m', 'm.id', 'cm.movimiento_id')
                    ->where('cm.type', 'EGRESO')
                    ->where('m.status', 'ACTIVO')
                    ->where('carteras.id', $c->id)->sum('m.import');
                /* REALIZAR CALCULO DE INGRESOS - EGRESOS */
                $c->monto = $MONTO - $MONTO2;
            }

            $this->emit('show-modal', 'details loaded');
        } else {
            $this->emit('no-carteras', 'Esta caja no tiene carteras');
        }
    }
    public function CrearCorte()
    {
        /* PONER EN INACTIVO TODOS LOS MOVIMIENTOS DE CIERRE DEL USUARIO */
        $cortes = Movimiento::where('status', 'ACTIVO')
            ->where('type', 'CIERRE')
            ->where('user_id', Auth()->user()->id)->get();
        foreach ($cortes as $cor) {
            $cor->update([
                'status' => 'INACTIVO',
            ]);
            $cor->save();
        }
        /*  CREAR MOVIMIENTOS DE APERTURA CON ESTADO ACTIVO POR CADA CARTERA */
        $carteras = Cartera::where('caja_id', $this->selected_id)->get();
        foreach ($carteras as $cart) {
            $mbv = Movimiento::create([
                'type' => 'APERTURA',
                'status' => 'ACTIVO',
                'import' => 0,
                'user_id' => Auth()->user()->id
            ]);
            CarteraMov::create([
                'type' => 'INGRESO',
                'comentario' => '',
                'cartera_id' => $cart->id,
                'movimiento_id' => $mbv->id,
            ]);
        }
        /* DESABILITAR CAJA */
        $caja = Caja::find($this->selected_id);
        $caja->update([
            'estado' => 'Abierto',
        ]);
        $caja->save();
        $this->habilitado = 1;

        session(['sesionCaja' => $caja->nombre]);

        $this->emit('caja_funcion', 'Corte de caja Apertura realizado Exitosamente');
        $this->Cargar();
    }
    public function CerrarCaja()
    {
        /* PONER EN INACTIVO TODOS LOS MOVIMIENTOS DE APERTURA DEL USUARIO */
        $cortes = Movimiento::where('status', 'ACTIVO')
            ->where('type', 'APERTURA')
            ->where('user_id', Auth()->user()->id)->get();
        foreach ($cortes as $cor) {
            $cor->update([
                'status' => 'INACTIVO',
            ]);
            $cor->save();
        }
        /* CREAR CORTES DE CIERRE CON ESTADO ACTIVO */
        $carteras = Cartera::where('caja_id', $this->selected_id)->get();
        foreach ($carteras as $cart) {
            $mbv = Movimiento::create([
                'type' => 'CIERRE',
                'status' => 'ACTIVO',
                'import' => 0,
                'user_id' => Auth()->user()->id
            ]);
            CarteraMov::create([
                'type' => 'INGRESO',
                'comentario' => '',
                'cartera_id' => $cart->id,
                'movimiento_id' => $mbv->id,
            ]);
        }
        /* HABILITAR CAJA */
        $caja = Caja::find($this->selected_id);
        $caja->update([
            'estado' => 'Cerrado',
        ]);
        $caja->save();
        $this->habilitado = 0;
        session(['sesionCaja' => null]);
        $this->emit('caja_funcion', 'Corte de caja CIERRE realizado Exitosamente');
        $this->Cargar();
    }
}
