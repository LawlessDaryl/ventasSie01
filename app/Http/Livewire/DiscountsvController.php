<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Discountsv;
use App\Models\Employee;
use App\Models\Contrato;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;


class DiscountsvController extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $empleadoid, $nuevoSalario, $anticipo, $fechaSolicitud, $motivo, $selected_id, $descuentoc, $fecha;
    public $pageTitle, $componentName, $search;
    private $pagination = 5;

    public function mount()
    {
        $this->componentName="Descuentos Varios";
        $this->pageTitle = "Lista";
        $this->empleadoid = "Elegir";
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {

        if(strlen($this->search) > 0)
        {
            $data = Discountsv::join('employees as at', 'at.id', 'discountsvs.ci') // se uno amabas tablas
            ->select('discountsvs.*','at.name as empleado')
            ->where('at.name', 'like', '%' . $this->search . '%')   
            //->orWhere('at.name', 'like', '%' . $this->search . '%')         
            ->orderBy('discountsvs.created_at', 'asc')
            ->paginate($this->pagination);

            
        }
        else
            $data = Discountsv::join('employees as at', 'at.id', 'discountsvs.ci')
            ->select('discountsvs.*','at.name as empleado')
            ->orderBy('discountsvs.created_at', 'asc')
            ->paginate($this->pagination);

    
        return view('livewire.discountsv.component', [
            'descuento' => $data,        // se envia anticipos
            'empleados' => Employee::orderBy('name', 'asc')->get(),
            ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    // crear y guardar
    public function Store(){
        $rules = [
            'empleadoid' => 'required|not_in:Elegir',
            'descuentoc' => 'required'
        ];
        $messages =  [
            'empleadoid.required' => 'Elija un Empleado',
            'empleadoid.not_in' => 'Elije un nombre de empleado diferente de elegir',
            'descuentoc.required' => 'Este espacio es requerida'
        ];
        //dd($this->descuentoc);
        $this->validate($rules, $messages);
        $this->fecha = Carbon::parse(Carbon::now())->format('Y-m-d');
        $anticipo = Discountsv::create([
            'id' => $this->empleadoid,
            'ci' => $this->empleadoid,
            'descuento'=>$this->descuentoc,
            'motivo'=>$this->motivo,
            'fecha' => $this->fecha,
        ]);

        $this->resetUI();
        $this->emit('asist-added', 'Adelanto Registrado');
    }

    // editar datos
    public function Edit(Discountsv $descontar){
        $this->selected_id = $descontar->id;
        $this->empleadoid = $descontar->ci;
        $this->descuentoc = $descontar->descuento;
        $this->motivo = $descontar->motivo;

        $this->emit('show-modal', 'show modal!');
    }

    // Actualizar datos
    public function Update(){
        $rules = [
            'empleadoid' => 'required|not_in:Elegir',
            'descuentoc' => 'required',

        ];
        $messages =  [
            'empleadoid.required' => 'Elija un Empleado',
            'empleadoid.not_in' => 'Elije un nombre de empleado diferente de elegir',
            'descuentoc.required' => 'Este espacio es requerida'
        ];
        $this->validate($rules,$messages);

        $assistance = Discountsv::find($this->selected_id);
        $assistance -> update([
            'ci' => $this->empleadoid,
            'descuento'=>$this->descuentoc,
            'motivo'=>$this->motivo,
        ]);

        $this->resetUI();
        $this->emit('asist-updated','Categoria Actualizar');
    }

     // vaciar formulario
     public function resetUI(){
        $this->empleadoid = 'Elegir';
        $this->descuentoc='';
        $this->anticipo='';
        $this->fechaSolicitud='';
        $this->motivo='';
        $this->search='';
        $this->selected_id=0;
        $this->resetValidation(); // resetValidation para quitar los smg Rojos
    }
}
