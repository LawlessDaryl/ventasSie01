<?php

namespace App\Http\Livewire;

use App\Models\Comision;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use App\Models\Motivo;
use App\Models\Origen;
use App\Models\OrigenMotivo;
use App\Models\OrigenMotivoComision;

class OrigenMotivoComisionController extends Component
{
    use WithPagination;
    public $origen_motivo, $origen, $tipo, $motivo, $omcomi, $componentName;
    private $pagination = 10;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->omcomi = 0;
        $this->origen = 'Elegir';
        $this->motivo = 'Elegir';
        $this->tipo = 'Elegir';
        $this->componentName = 'Asignar comision a Origen-Motivo';
    }

    public function render()
    {
        if ($this->tipo != 'Elegir') {
            $comisiones = Comision::select('nombre', 'id', 'tipo', 'monto_a', 'monto_inicial', 'monto_final', 'porcentaje', 'comision', DB::raw('0 as checked'))
                ->where('tipo', $this->tipo)
                ->orderBy('nombre', 'asc')
                ->paginate($this->pagination);
        } else {
            $comisiones = Comision::select('nombre', 'id', 'tipo', 'monto_a', 'monto_inicial', 'monto_final', 'porcentaje', 'comision', DB::raw('0 as checked'))
                ->orderBy('nombre', 'asc')
                ->paginate($this->pagination);
        }


        if ($this->origen != 'Elegir') {
            $mot = OrigenMotivo::join('motivos as m', 'm.id', 'origen_motivos.motivo_id')
                ->where('origen_motivos.origen_id', $this->origen)->pluck('m.id')->toArray();
            $motivos = Motivo::find($mot);
        } else {
            $this->motivo = 'Elegir';
            $motivos = 'Elegir';
        }


        $idsOrigesMots = OrigenMotivo::join('motivos as m', 'origen_motivos.motivo_id', 'm.id')
            ->join('origens as o', 'origen_motivos.origen_id', 'o.id')
            ->where('o.id', $this->origen)
            ->where('m.id', $this->motivo)->pluck('origen_motivos.id')->toArray();

        /*  $this->omcomi=(int)$idsOrigesMots.value(0); */
        if ($this->tipo != 'Elegir' && $this->origen != 'Elegir' && $this->motivo != 'Elegir') {
            /* dd($this->motivo); */
            /* dd($idsOrigesMots); */
            $origenMotivoComi = OrigenMotivoComision::where('origen_motivos_id', $idsOrigesMots)
                ->pluck('origen_motivo_comisions.comision_id')->toArray();
            foreach ($origenMotivoComi as $OMC) {
                foreach ($comisiones as $comi) {
                    if ($comi->id == $OMC) {
                        $comi->checked = 1;
                    }
                }
            }
        }


        return view('livewire.origen_motivo_comision.component', [
            'origenes' => Origen::orderBy('nombre', 'asc')->get(),
            'motivos' => $motivos,
            'comisiones' => $comisiones
        ])->extends('layouts.theme.app')->section('content');
    }

    public function SyncPermiso($state, $id)
    {
        if ($this->tipo != 'Elegir' && $this->origen != 'Elegir' && $this->motivo != 'Elegir') {
            $idsOrigesMots = OrigenMotivo::where('motivo_id', $this->motivo)
                ->where('origen_id', $this->origen)
                ->get();
            if ($state) {
                $comis = Comision::find($id);
                /* dd($idsOrigesMots[0]->id); */
                $lista = OrigenMotivoComision::join('comisions as c', 'origen_motivo_comisions.comision_id', 'c.id')

                    ->where('c.tipo', $comis->tipo)
                    ->where('origen_motivo_comisions.origen_motivos_id', $idsOrigesMots[0]->id)

                    ->pluck('c.id')->toArray();
                $variable = false;


                foreach ($lista as $li) {
                    $coo = Comision::find($li);
                    /* dd($comis->monto_inicial,$comis->monto_final,$coo->monto_inicial,$coo->monto_final); */
                    if ($comis->monto_inicial >= $coo->monto_inicial && $comis->monto_inicial <= $coo->monto_final) {
                        $variable = true;
                    }
                    if ($comis->monto_final >= $coo->monto_inicial &&  $comis->monto_final <= $coo->monto_final) {
                        $variable = true;
                    }
                }
                if ($variable) {
                    $this->redirect('origen-motivo-comision');
                    $this->emit('no_sincronizar', 'Este registro ya tiene asignado una comision entre esos rangos');
                } else {
                    OrigenMotivoComision::create([
                        'origen_motivos_id' => $idsOrigesMots[0]->id,
                        'comision_id' => $id
                    ]);
                    $this->emit('permi', 'Comision asignado correctamente');
                }
            } else {
                OrigenMotivoComision::where('origen_motivos_id', $idsOrigesMots[0]->id)
                    ->where('comision_id', $id)->delete();
                $this->emit('permi', "Comision eliminado correctamente");
            }
        } else {
            $this->redirect('origen-motivo-comision');
            $this->emit('sync-error', 'Seleccione un origen válido');
        }
    }
}
