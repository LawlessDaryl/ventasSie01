<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cartera;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CarteraController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public  $search, $nombre, $descripcion, $tipo, $telefonoNum, $selected_id, $caja_id;
    public  $pageTitle, $componentName, $variable;
    private $pagination = 10;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Carteras';
        $this->caja_id = 'Elegir';
        $this->tipo = 'Elegir';
        $this->variable = 0;
        $this->telefonoNum = 0;
        $this->selected_id = 0;
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = Cartera::select(
                'carteras.*',
                DB::raw('0 as movimientos')
            )
                ->where('nombre', 'like', '%' . $this->search . '%')
                ->orwhere('tipo', 'like', '%' . $this->search . '%')
                ->paginate($this->pagination);
        } else {
            $data = Cartera::select(
                'carteras.*',
                DB::raw('0 as movimientos')
            )
                ->orderBy('id', 'desc')
                ->paginate($this->pagination);
        }
        // CONTAR MOVIMIENTOS DE LA CARTERA PARA PERMITIR O NO PERMITIR ELIMINARLA
        foreach ($data as $value) {
            $movimientos = Cartera::join('cartera_movs as cm', 'cm.cartera_id', 'carteras.id')
                ->where('carteras.id', $value->id)
                ->where('cm.tipoDeMovimiento', '!=', 'EGRESO/INGRESO')
                ->where('cm.tipoDeMovimiento', '!=', 'CORTE')
                ->get();
            $value->movimientos = $movimientos->count();
        }

        if ($this->tipo != 'Elegir') {
            if ($this->tipo == 'Telefono' || $this->tipo == 'Sistema') {
                $this->variable = 1;
            } else {
                $this->variable = 0;
            }
        }

        return view('livewire.cartera.component', [
            'data' => $data,
            'cajas' => Caja::orderBy('nombre', 'asc')->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Agregar()
    {
        $this->resetUI();
        $this->emit('show-modal', 'show modal!');
    }
    
    public function Store()
    {
        $rules = [
            'nombre' => 'required|unique:carteras',
            'caja_id' => 'required|not_in:Elegir',
            'tipo' => 'required|not_in:Elegir',
            'telefonoNum' => 'required_if:variable,==,1',
        ];
        $messages = [
            'nombre.required' => 'Nombre de la cartera requerido.',
            'nombre.unique' => 'Ese nombre de cartera ya existe.',
            'caja_id.required' => 'La caja es requerido.',
            'caja_id.not_in' => 'La caja debe ser distinto de Elegir.',
            'tipo.required' => 'El tipo es requerido.',
            'tipo.not_in' => 'El tipo debe ser distinto de Elegir.',
            'telefonoNum.required_if' => 'El teléfono es requerido.',
        ];
        $this->validate($rules, $messages);

        Cartera::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'tipo' => $this->tipo,
            'telefonoNum' => $this->telefonoNum,
            'caja_id' => $this->caja_id
        ]);

        $this->resetUI();
        $this->emit('item-added', 'Cartera Registrada');
    }
    public function Edit(Cartera $cartera)
    {
        $this->selected_id = $cartera->id;
        $this->nombre = $cartera->nombre;
        $this->descripcion = $cartera->descripcion;
        $this->tipo = $cartera->tipo;
        $this->telefonoNum = $cartera->telefonoNum;
        $this->caja_id = $cartera->caja_id;

        $this->emit('show-modal', 'show modal!');
    }
    public function Update()
    {
        $rules = [
            'nombre' => "required|unique:carteras,nombre,{$this->selected_id}",
            'caja_id' => 'required|not_in:Elegir',
            'tipo' => 'required|not_in:Elegir'
        ];
        $messages = [
            'nombre.required' => 'Nombre de la cartera requerido.',
            'nombre.unique' => 'Ese nombre de cartera ya existe.',
            'caja_id.required' => 'La caja es requerido.',
            'caja_id.not_in' => 'La caja debe ser distinto de Elegir.',
            'tipo.required' => 'El tipo es requerido.',
            'tipo.not_in' => 'El tipo debe ser distinto de Elegir.'
        ];
        $this->validate($rules, $messages);
        $cartera = Cartera::find($this->selected_id);
        $cartera->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'tipo' => $this->tipo,
            'telefonoNum' => $this->telefonoNum,
            'caja_id' => $this->caja_id
        ]);
        $cartera->save();

        $this->resetUI();
        $this->emit('item-updated', 'Cartera Actualizada');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Cartera $cartera)
    {
        $cartera->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Cartera Eliminada');
    }

    public function resetUI()
    {
        $this->nombre = '';
        $this->descripcion = '';
        $this->tipo = '';
        $this->search = '';
        $this->caja_id = 'Elegir';
        $this->tipo = 'Elegir';
        $this->telefonoNum = '';
        $this->selected_id = 0;
        $this->variable = 0;
        $this->resetValidation();
    }
}
