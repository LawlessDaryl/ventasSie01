<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contrato;
use App\Models\Employee;
use Carbon\Carbon;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

class ContratoController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $fechaFin, $descripcion, $nota, $salario, $estado, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 10;

    public function mount(){
        $this -> pageTitle = 'Listado';
        $this -> componentName = 'Contrato';
        $this->estado = 'Elegir';

        //$this->fechaFin=Carbon::parse(Carbon::now())->format('Y-m-d');
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $data = Contrato::select('contratos.id as idContrato','contratos.fechaFin as fechaFin','contratos.descripcion as descripcion',
            'contratos.nota as nota','contratos.salario as salario','contratos.estado as estado',
            DB::raw('0 as verificar'))
            ->orderBy('id','desc')
            ->where('contratos.descripcion', 'like', '%' . $this->search . '%')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idContrato);
            }
        }
        else
        {
            $data = Contrato::select('contratos.id as idContrato','contratos.fechaFin as fechaFin','contratos.descripcion as descripcion',
            'contratos.nota as nota','contratos.salario as salario','contratos.estado as estado',
            DB::raw('0 as verificar'))
            ->orderBy('id','desc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio idContrato
                $os->verificar = $this->verificar($os->idContrato);
            }
        }

        return view('livewire.contrato.component', ['contratos' => $data]) // se envia contratos
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // verificar 
    public function verificar($idContrato)
    {
        $consulta = Contrato::join('employees as e', 'e.contrato_id', 'contratos.id')
        ->select('contratos.*')
        ->where('contratos.id', $idContrato)
        ->get();
       
        if($consulta->count() > 0)
        {
            return "no";
        }
        else
        {
            return "si";
        }
    }

    // editar 
    public function Edit($id){
        $record = Contrato::find($id, ['id', 'fechaFin', 'descripcion', 'nota', 'salario','estado']);
        //dd(\Carbon\Carbon::parse($record->fechaFin)->format('Y-m-d'));
        $this->fechaFin = \Carbon\Carbon::parse($record->fechaFin)->format('Y-m-d');
        //Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->descripcion = $record->descripcion;
        $this->nota = $record->nota;
        $this->salario = $record->salario;
        $this->estado = $record->estado;
        $this->selected_id = $record->id;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules = [
            //'fechaFin' => 'required',
            'estado' => 'required|not_in:Elegir',
        ];
        $messages =  [
            //'fechaFin.required' => 'la fecha Final de contrato es requerido',
            'estado.required' => 'seleccione estado de contrato',
            'estado.not_in' => 'selecciona estado de contrato',
        ];

        $this->validate($rules, $messages);
       
        $contrato = Contrato::create([
            'fechaFin'=>$this->fechaFin,
            'descripcion'=>$this->descripcion,
            'nota'=>$this->nota,
            'salario'=>$this->salario,
            'estado'=>$this->estado
        ]);

        $this->resetUI();
        $this->emit('tcontrato-added', 'Contrato Registrado');
    }

    // actualizar
    public function Update(){
        $rules = [
            'estado' => 'required|not_in:Elegir',
        ];

        $messages = [
            'estado.required' => 'seleccione estado de contrato',
            'estado.not_in' => 'selecciona estado de contrato',
        ];
        $this->validate($rules,$messages);

        $contrato = Contrato::find($this->selected_id);
        $contrato -> update([
            'fechaFin'=>$this->fechaFin,
            'descripcion'=>$this->descripcion,
            'nota'=>$this->nota,
            'salario'=>$this->salario,
            'estado'=>$this->estado
        ]);

        $this->resetUI();
        $this->emit('tcontrato-updated','Contrato Actualizada');
    }

    public function resetUI(){
        $this->fechaFin='';
        $this->descripcion='';
        $this->nota='';
        $this->salario='';
        $this->estado = 'Elegir';
        $this->search='';
        $this->selected_id=0;
        $this->resetValidation(); // resetValidation para quitar los smg Rojos
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    // eliminar
    public function Destroy($id)
    {
        $contrato = Contrato::find($id);
        $contrato->delete();
        $this->resetUI();
        $this->emit('tcontrato-deleted','Contrato Eliminada');
    }
}
