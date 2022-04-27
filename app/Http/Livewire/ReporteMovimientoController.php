<?php

namespace App\Http\Livewire;

use App\Models\Movimiento;
use Livewire\Component;

class ReporteMovimientoController extends Component
{
    public  $search, $selected_id;
    public  $pageTitle, $componentName, $opciones;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Movimientos';
        $this->selected_id = 0;
        $this->opciones = 'TODAS';
    }
    public function render()
    {
        $this->Cargar();
        return view('livewire.reporte_movimientos.component', [])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function Cargar()
    {
        if ($this->opciones == 'TODAS') {
            $this->data = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
                ->join('carteras as c', 'c.id', 'crms.cartera_id')
                ->join('cajas as ca', 'ca.id', 'c.caja_id')
                ->join('users as u', 'u.id', 'movimientos.user_id')
                ->select(
                    'movimientos.type as movimientotype',
                    'movimientos.import',
                    'crms.type as carteramovtype',
                    'crms.tipoDeMovimiento',
                    'crms.comentario',
                    'c.nombre',
                    'c.descripcion',
                    'c.tipo',
                    'c.telefonoNum',
                    'ca.nombre as cajaNombre',
                    'u.name as usuarioNombre',
                    'movimientos.created_at as movimientoCreacion',
                )
                ->orderBy('movimientos.id', 'desc')
                ->get();
        } else {
            $this->data = Movimiento::join('cartera_movs as crms', 'crms.movimiento_id', 'movimientos.id')
                ->join('carteras as c', 'c.id', 'crms.cartera_id')
                ->join('cajas as ca', 'ca.id', 'c.caja_id')
                ->join('users as u', 'u.id', 'movimientos.user_id')
                ->select(
                    'movimientos.type as movimientotype',
                    'movimientos.import',
                    'crms.type as carteramovtype',
                    'crms.tipoDeMovimiento',
                    'crms.comentario',
                    'c.nombre',
                    'c.descripcion',
                    'c.tipo',
                    'c.telefonoNum',
                    'ca.nombre as cajaNombre',
                    'u.name as usuarioNombre',
                    'movimientos.created_at as movimientoCreacion',
                )
                ->where('crms.tipoDeMovimiento', $this->opciones)
                ->orderBy('movimientos.id', 'desc')
                ->get();
        }
    }
}
