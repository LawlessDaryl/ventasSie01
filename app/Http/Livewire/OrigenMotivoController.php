<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use App\Models\Motivo;
use App\Models\Origen;
use App\Models\OrigenMotivo;

class OrigenMotivoController extends Component
{
    use WithPagination;
    public $origen, $componentName;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->origen = 'Elegir';
        $this->componentName = 'Asignar Motivos';
    }

    public function render()
    {
        $motivos = Motivo::select('nombre_motivo', 'id', DB::raw('0 as checked'))
            ->orderBy('nombre_motivo', 'asc')
            ->paginate($this->pagination);

        if ($this->origen != 'Elegir') {
            $origenMotivo = OrigenMotivo::where('origen_id', $this->origen)
                ->pluck('origen_motivos.motivo_id')->toArray();
            foreach ($origenMotivo as $OM) {
                foreach ($motivos as $motivo) {
                    if ($motivo->id == $OM) {
                        $motivo->checked = 1;
                    }
                }
            }
        }
        return view('livewire.origen_motivo.component', [
            'origenes' => Origen::orderBy('nombre', 'asc')->get(),
            'motivos' => $motivos
        ])->extends('layouts.theme.app')->section('content');
    }

    public function buscarom($o,$m)
    {
        $om = OrigenMotivo::all()->where('origen_id', $o)->where('motivo_id', $m);
        if($om)
        return true;
        else
        return false;
    }
    public function SyncAll()
    {
        if ($this->origen == 'Elegir') {
            $this->emit('sync-error', 'Selecciona un origen válido');
            return;
        }
        $motivos = Motivo::select('nombre_motivo', 'id', DB::raw('0 as checked'))
        ->orderBy('nombre_motivo', 'asc')
        ->paginate($this->pagination);   
        $origen = Origen::find($this->origen);
        foreach ($motivos as $mot) {
         if($this->buscarom($origen->id, $mot->id))
            OrigenMotivo::create([
                'origen_id' => $origen->id,
                'motivo_id' => $mot->id
            ]);
        }
        $this->emit('syncall', "Se sincronizaron todos los motivos al rol $origen->nombre");
    }

    public $listeners = ['revokeall' => 'RemoveAll'];

    public function RemoveAll()
    {
        if ($this->origen == 'Elegir') {
            $this->emit('sync-error', 'Selecciona un orígen válido');
            return;
        }
        $motivos = Motivo::select('nombre_motivo', 'id', DB::raw('0 as checked'))
        ->orderBy('nombre_motivo', 'asc')
        ->paginate($this->pagination);
        $origen = Origen::find($this->origen);
        foreach ($motivos as $mot) {
            if($this->buscarom($origen->id, $mot->id)){
               OrigenMotivo::where('origen_id', $origen->id)->where('motivo_id', $mot->id)->delete();
            }
           }
        $this->emit('removeall', "Se revocaron todos los motivos al origen $origen->nombre");
    }

    public function SyncPermiso($state, $id)
    {
        if ($this->origen != 'Elegir') {
            $origen = Origen::find($this->origen);
            if ($state) {
                OrigenMotivo::create([
                    'origen_id' => $origen->id,
                    'motivo_id' => $id
                ]);
                $this->emit('permi', 'Motivo asignado correctamente');
            } else {
                OrigenMotivo::where('origen_id', $origen->id)
                ->where('motivo_id',$id)->delete();
                $this->emit('permi', "Motivo eliminado correctamente");
            }
        } else {
            $this->redirect('origen-motivo');
            $this->emit('sync-error', 'Seleccione un origen válido');
        }
    }
}
