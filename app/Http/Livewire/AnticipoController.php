<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Anticipo;
use App\Models\Employee;
use App\Models\Contrato;
use App\Models\Discountsv;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

class AnticipoController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $empleadoid, $anticipo, $motivo, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 5;


    public function mount(){
        $this -> pageTitle = 'Lista';
        $this -> componentName = 'Adelantos de Sueldo';

        $this->empleadoid = 'Elegir';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $data = Anticipo::join('employees as at', 'at.id', 'anticipos.empleado_id')
            ->join('contratos as ct', 'ct.id', 'at.contrato_id')
            ->join('discountsvs as dc', 'dc.ci', 'at.ci')
            ->select('anticipos.*', 'at.name as empleado', 'ct.salario', 'dc.descuento as descuento', 'anticipos.id as idAnticipo',
                DB::raw('0 as verificar'))
            ->where('at.name', 'like', '%' . $this->search . '%')   
            //->orWhere('at.contrato_id', 'like', '%' . $this->search . '%')         
            ->orderBy('at.name', 'asc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idAnticipo);
            }
        }
        else
        {
            $data = Anticipo::join('employees as at', 'at.id', 'anticipos.empleado_id')
            ->join('contratos as ct', 'ct.id', 'at.contrato_id')
            ->join('discountsvs as dc', 'dc.ci', 'at.ci')
            ->select('anticipos.*', 'at.name as empleado', 'ct.salario as salario', 'dc.descuento as descuento', 'anticipos.id as idAnticipo',
                DB::raw('0 as verificar'))
            ->orderBy('at.name', 'asc')
            ->paginate($this->pagination);

            foreach ($data as $os)
            {
                //Obtener los servicios de la orden de servicio
                $os->verificar = $this->verificar($os->idAnticipo);
            }
        }




        return view('livewire.anticipos.component', [
            'anticipos' => $data,        // se envia anticipos
            'empleados' => Employee::orderBy('name', 'asc')->get(),
            ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // verificar 
    public function verificar($idAnticipo)
    {
        $consulta = Anticipo::where('anticipos.id', $idAnticipo);
        
        if($consulta->count() > 0)
        {
            return "si";
        }
        else
        {
            return "no";
        }
    }

    // crear y guardar
    public function Store(){
        $rules = [
            'empleadoid' => 'required|not_in:Elegir',
            'anticipo' => 'required',
        ];
        $messages =  [
            'empleadoid.required' => 'Elija un Empleado',
            'empleadoid.not_in' => 'Elije un nombre de empleado diferente de elegir',
            'anticipo.required' => 'Este espacio es requerida',
        ];

        $this->validate($rules, $messages);

        $anticipo = Anticipo::create([
            'empleado_id' => $this->empleadoid,
            'anticipo'=>$this->anticipo,
            'motivo'=>$this->motivo,
        ]);

        $this->resetUI();
        $this->emit('asist-added', 'Anticipo Registrado');
    }

    // editar datos
    public function Edit(Anticipo $anticipo){
        $this->selected_id = $anticipo->id;
        $this->empleadoid = $anticipo->empleado_id;
        $this->anticipo = $anticipo->anticipo;
        $this->motivo = $anticipo->motivo;

        $this->emit('show-modal', 'show modal!');
    }

    // Actualizar datos
    public function Update(){
        $rules = [
            'empleadoid' => 'required|not_in:Elegir',
            'anticipo' => 'required',
        ];
        $messages =  [
            'empleadoid.required' => 'Elija un Empleado',
            'empleadoid.not_in' => 'Elije un nombre de empleado diferente de elegir',
            'anticipo.required' => 'Este espacio es requerida',
        ];
        $this->validate($rules,$messages);

        $assistance = Anticipo::find($this->selected_id);
        $assistance -> update([
            'empleado_id' => $this->empleadoid,
            'anticipo'=>$this->anticipo,
            'motivo'=>$this->motivo,
        ]);

        $this->resetUI();
        $this->emit('asist-updated','Anticipo Actualizar');
    }

    // vaciar formulario
    public function resetUI(){
        $this->empleadoid = 'Elegir';
        $this->anticipo='';
        $this->motivo='';
        $this->search='';
        $this->selected_id=0;
        $this->resetValidation(); // resetValidation para quitar los smg Rojos
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    // eliminar
    public function Destroy(Anticipo $anticipo){
        $anticipo->delete();
        $this->resetUI();
        $this->emit('asist-deleted','Anticipo Eliminada');
    }
}
