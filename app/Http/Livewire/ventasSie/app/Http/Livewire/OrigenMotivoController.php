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
    public $origen, $componentName, $origenNombre, $motivoNombre,
        $comision_si_no, $suma_resta_si, $suma_resta_no, $origenmotivo,
        $afectadoSi, $afectadoNo, $preguntar, $telefSolicitante,
        $condicionpreguntar, $CIdeCliente, $telefDestino_codigo;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->comision_si_no = '';
        $this->origenNombre = '';
        $this->preguntar = 'si';
        $this->motivoNombre = '';
        $this->origenmotivo = 0;
        $this->suma_resta_si = 0;
        $this->suma_resta_no = 0;
        $this->CIdeCliente = 'Elegir';
        $this->telefSolicitante = 'Elegir';
        $this->telefDestino_codigo = 'Elegir';
        $this->afectadoSi = 'Elegir';
        $this->afectadoNo = 'Elegir';
        $this->origen = 'Elegir';
        $this->condicionpreguntar = 0;
        $this->componentName = 'Asignar Motivos';
    }

    public function render()
    {
        $motivos = Motivo::select('nombre', 'id', DB::raw('0 as checked'), DB::raw('0 as condicional'))
            ->orderBy('nombre', 'asc')
            ->paginate($this->pagination);

        if ($this->origen != 'Elegir') {
            $origenMotivo = OrigenMotivo::where('origen_id', $this->origen)
                ->get();
            foreach ($origenMotivo as $OM) {
                foreach ($motivos as $motivo) {
                    if ($motivo->id == $OM->motivo_id) {
                        $motivo->condicional = $OM->comision_si_no;
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

    public function buscarom($o, $m)
    {
        $om = OrigenMotivo::all()->where('origen_id', $o)->where('motivo_id', $m);
        if ($om)
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
        $motivos = Motivo::select('nombre', 'id', DB::raw('0 as checked'))
            ->orderBy('nombre', 'asc')
            ->paginate($this->pagination);
        $origen = Origen::find($this->origen);
        foreach ($motivos as $mot) {
            if ($this->buscarom($origen->id, $mot->id))
                OrigenMotivo::create([
                    'origen_id' => $origen->id,
                    'motivo_id' => $mot->id
                ]);
        }
        $this->emit('syncall', "Se sincronizaron todos los motivos al rol $origen->nombre");
    }

    public $listeners = ['revokeall' => 'RemoveAll', 'deleteRow' => 'Condicion'];

    public function RemoveAll()
    {
        if ($this->origen == 'Elegir') {
            $this->emit('sync-error', 'Selecciona un orígen válido');
            return;
        }
        $motivos = Motivo::select('nombre', 'id', DB::raw('0 as checked'))
            ->orderBy('nombre', 'asc')
            ->paginate($this->pagination);
        $origen = Origen::find($this->origen);
        foreach ($motivos as $mot) {
            if ($this->buscarom($origen->id, $mot->id)) {
                OrigenMotivo::where('origen_id', $origen->id)->where('motivo_id', $mot->id)->delete();
            }
        }
        $this->emit('removeall', "Se revocaron todos los motivos al origen $origen->nombre");
    }

    public function SyncPermiso($state, $id)
    {
        if ($this->origen != 'Elegir') {
            $origen = Origen::find($this->origen);
            $origenMotivo = OrigenMotivo::where('origen_id', $this->origen)->where('motivo_id', $id)->get()->first();

            if ($state) {
                OrigenMotivo::create([
                    'origen_id' => $origen->id,
                    'motivo_id' => $id
                ]);
                $this->emit('permi', 'Motivo asignado correctamente');
            } else {
                //dd($origenMotivo->relaciontr->count());
                if ($origenMotivo->relaciontr->count() > 0) {
                    $this->redirect('origen-motivo');
                    $this->emit('sync-error', 'No se puede eliminar porque tiene comisiones relacionadas/ transacciones relacionadas.');
                } else {
                    OrigenMotivo::where('origen_id', $origen->id)
                        ->where('motivo_id', $id)->delete();
                    $this->emit('permi', "Motivo eliminado correctamente");
                }
            }
        } else {
            $this->redirect('origen-motivo');
            $this->emit('sync-error', 'Seleccione un origen válido');
        }
    }

    public function viewDetails($mot)
    {
        $this->origenmotivo = OrigenMotivo::where('motivo_id', $mot)->where('origen_id', $this->origen)->first()->id;
        $om = OrigenMotivo::find($this->origenmotivo);
        if ($om->comision_si_no == 'no') {
            $this->preguntar = 'si';
        } else {
            $this->preguntar = $om->comision_si_no;
        }
        if ($this->preguntar == 'nopreguntar') {
            $this->condicionpreguntar = 1;
        }
        $this->suma_resta_si = $om->suma_resta_si;
        $this->suma_resta_no = $om->suma_resta_no;
        $this->afectadoSi = $om->afectadoSi;
        $this->afectadoNo = $om->afectadoNo;
        $this->CIdeCliente = $om->CIdeCliente;
        $this->telefSolicitante = $om->telefSolicitante;
        $this->telefDestino_codigo = $om->telefDestino_codigo;

        $motivoNombre = Motivo::find($mot);
        $this->origenNombre = Origen::find($this->origen)->nombre;

        $this->motivoNombre = $motivoNombre->nombre;

        $this->emit('asignar', '');
    }
    public function Asignar()
    {
        if ($this->preguntar == 'si') {
            $rules = [
                'suma_resta_si' => 'required',
                'suma_resta_no' => 'required',
                'afectadoSi' => 'required|not_in:Elegir',
                'afectadoNo' => 'required|not_in:Elegir',
                'CIdeCliente' => 'required|not_in:Elegir',
                'telefSolicitante' => 'required|not_in:Elegir',
                'telefDestino_codigo' => 'required|not_in:Elegir',
            ];
            $messages = [
                'suma_resta_si.required' => 'Este campo es requerido',
                'suma_resta_no.required' => 'Este campo es requerido',
                'afectadoSi.required' => 'El valor afectado debe ser distinto a Elegir',
                'afectadoSi.not_in' => 'El valor afectado debe ser distinto a Elegir',
                'afectadoNo.required' => 'El valor afectado debe ser distinto a Elegir',
                'afectadoNo.not_in' => 'El valor afectado debe ser distinto a Elegir',
                'CIdeCliente.required' => 'El Ci de cliente debe ser distinto a Elegir',
                'CIdeCliente.not_in' => 'El Ci de cliente debe ser distinto a Elegir',
                'telefSolicitante.required' => 'El telefono solicitante debe ser distinto a Elegir',
                'telefSolicitante.not_in' => 'El telefono solicitante debe ser distinto a Elegir',
                'telefDestino_codigo.required' => 'El telefono destigo/codigo debe ser distinto a Elegir',
                'telefDestino_codigo.not_in' => 'El telefono destigo/codigo debe ser distinto a Elegir',
            ];
            $this->validate($rules, $messages);

            $om = OrigenMotivo::find($this->origenmotivo);

            $om->update([
                'comision_si_no' => $this->preguntar,
                'suma_resta_si' => $this->suma_resta_si,
                'suma_resta_no' => $this->suma_resta_no,
                'afectadoSi' => $this->afectadoSi,
                'afectadoNo' => $this->afectadoNo,
                'CIdeCliente' => $this->CIdeCliente,
                'telefSolicitante' => $this->telefSolicitante,
                'telefDestino_codigo' => $this->telefDestino_codigo
            ]);
            $om->save();
        } else {
            $rules = [
                'suma_resta_si' => 'required',

                'afectadoSi' => 'required|not_in:Elegir',

                'CIdeCliente' => 'required|not_in:Elegir',
                'telefSolicitante' => 'required|not_in:Elegir',
                'telefDestino_codigo' => 'required|not_in:Elegir',
            ];
            $messages = [
                'suma_resta_si.required' => 'Este campo es requerido',

                'afectadoSi.required' => 'El valor afectado debe ser distinto a Elegir',
                'afectadoSi.not_in' => 'El valor afectado debe ser distinto a Elegir',


                'CIdeCliente.required' => 'El Ci de cliente debe ser distinto a Elegir',
                'CIdeCliente.not_in' => 'El Ci de cliente debe ser distinto a Elegir',
                'telefSolicitante.required' => 'El telefono solicitante debe ser distinto a Elegir',
                'telefSolicitante.not_in' => 'El telefono solicitante debe ser distinto a Elegir',
                'telefDestino_codigo.required' => 'El telefono destigo/codigo debe ser distinto a Elegir',
                'telefDestino_codigo.not_in' => 'El telefono destigo/codigo debe ser distinto a Elegir',
            ];
            $this->validate($rules, $messages);

            $om = OrigenMotivo::find($this->origenmotivo);

            $om->update([
                'comision_si_no' => $this->preguntar,
                'suma_resta_si' => $this->suma_resta_si,
                'suma_resta_no' => $this->suma_resta_si,
                'afectadoSi' => $this->afectadoSi,
                'afectadoNo' => $this->afectadoSi,
                'CIdeCliente' => $this->CIdeCliente,
                'telefSolicitante' => $this->telefSolicitante,
                'telefDestino_codigo' => $this->telefDestino_codigo
            ]);
            $om->save();
        }
        $this->resetUI();
        $this->emit('asignado', 'Se asignó correctamente');
    }

    public function Condicion($mot)
    {
        $this->origenmotivo = OrigenMotivo::where('motivo_id', $mot)->where('origen_id', $this->origen)->first()->id;
        $om = OrigenMotivo::find($this->origenmotivo);
        $om->update([
            'comision_si_no' => 'no',
            'suma_resta_si' => null,
            'suma_resta_no' => null,
            'afectadoSi' => null,
            'afectadoNo' => null,
            'CIdeCliente' => null,
            'telefSolicitante' => null,
            'telefDestino_codigo' => null
        ]);
        $om->save();
        $this->resetUI();
        $this->emit('asignado', 'Se quitó correctamente');
    }
    public function resetUI()
    {
        $this->preguntar = 'si';
        $this->motivoNombre = '';
        $this->origenmotivo = 0;
        $this->suma_resta_si = 0;
        $this->suma_resta_no = 0;
        $this->CIdeCliente = 'Elegir';
        $this->telefSolicitante = 'Elegir';
        $this->telefDestino_codigo = 'Elegir';
        $this->afectadoSi = 'Elegir';
        $this->afectadoNo = 'Elegir';
        $this->resetValidation();
    }
}
