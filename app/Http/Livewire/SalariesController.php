<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Salarie;
use App\Models\Contrato;
use App\Models\Employee;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class SalariesController extends Component
{
    use WithPagination;
    public $shiftName, $search, $selected_id, $pageTitle, $componentName, $horaentrada, $horasalida, $minuto, $horario, $detallempleado;
    //pagos mensual y año
    public $pagototalmes, $pagototalaño;
    private $pagination = 10;
    //vista detalles de pago del empleado
    public $sueldo, $Dtranscurridos,$pagarD, $Mtranscurridos, $pagarM, $nombre;  
    //unimos las horas en un string
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->detallempleado = [];
        $this->pageTitle = 'Listado';
        $this->componentName = 'Salarios';
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            
            $salaries = Employee::join('contratos as ct', 'ct.id', 'employees.contrato_id')
            ->select('employees.name', 'employees.fechaInicio', 'ct.descripcion', 'ct.salario as salarioMes', 'ct.fechaFin', DB::raw('0 as salarioAño') )
            ->where('id', 'like', '%' . $this->search . '%')->get();
        } else {
            $salaries = Employee::join('contratos as ct', 'ct.id', 'employees.contrato_id')
            ->select('employees.id', 'employees.name', 'employees.fechaInicio', 'ct.descripcion', 'ct.salario as salarioMes', DB::raw('0 as salarioAño')  )->orderBy('id', 'asc')->get();
        }
       
        
        //agregar el proximo pago del mes
        foreach ($salaries as $salario) {
            $mergeAM=Carbon::parse(Carbon::now())->format('Y-m');
            $mergeAM=$mergeAM.substr($salario['fechaInicio'],7,3);
            //dd($mergeAM);
            //dd($salario->salarioMes);
            $addAño=$salario->salarioMes;
            
            if($addAño != 'null')
            {
                
                $salario->salarioAño= $salario->salarioMes * 12;
            }
            $salario->fechaFin=$mergeAM;
        }

         //pagos total
         foreach ($salaries as $salario) {
            $mergeAM=Carbon::parse(Carbon::now())->format('Y-m');
            $mergeAM=$mergeAM.substr($salario['fechaInicio'],7,3);
            //dd($mergeAM);
            //dd($salario->salarioMes);
            $addAño=$salario->salarioMes;
            
            if($addAño != 'null')
            {
                
                $salario->salarioAño= $salario->salarioMes * 12;
            }
            $salario->fechaFin=$mergeAM;
        }
        //crear total de salarios x mes y x año            
        foreach ($salaries as $mes) {
            if($mes->salarioMes != 'null')
            {
                $this->pagototalmes = $this->pagototalmes + $mes->salarioMes;
                $this->pagototalaño = $this->pagototalaño + $mes->salarioAño;
                
            }
        }
        
        
        
        //dd($this->pagototalmes);
        //dd($pagototalmes);
        
        //crear detalle de vista para mostrar cuando se le debe pagar pos los dias del mes trabajado y por todo el mes
        
        return view('livewire.salaries.component',[
            'data' => $salaries,
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
    //total del mes y el año
    public function Total()
    {
        $pagototal = Employee::join('contratos as ct', 'ct.id', 'employees.contrato_id')
                    ->select('employees.id', 'employees.name', 'employees.fechaInicio', 'ct.descripcion', 'ct.salario as salarioMes', DB::raw('0 as salarioAño')  )->orderBy('id', 'asc')->get();
        
        //pagos total
        foreach ($pagototal as $salario) {
            $mergeAM=Carbon::parse(Carbon::now())->format('Y-m');
            $mergeAM=$mergeAM.substr($salario['fechaInicio'],7,3);
            //dd($mergeAM);
            //dd($salario->salarioMes);
            $addAño=$salario->salarioMes;
            
            if($addAño != 'null')
            {
                
                $salario->salarioAño= $salario->salarioMes * 12;
            }
            $salario->fechaFin=$mergeAM;
        }
        //crear total de salarios x mes y x año            
        foreach ($pagototal as $mes) {
            if($mes->salarioMes != 'null')
            {
                $this->pagototalmes = $this->pagototalmes + $mes->salarioMes;
                $this->pagototalaño = $this->pagototalaño + $mes->salarioAño;
                
            }
        }

    }
    //vista del detalle de dias, meses pagados
    public function Detailspago( $id)
    {
        //$category = Category::find($id);
        $emplo = Employee::join('contratos as ct', 'ct.id', 'employees.contrato_id')
            ->select('employees.id', 'employees.name', 'employees.fechaInicio', 'ct.descripcion', 'ct.salario as salarioMes', DB::raw('0 as salarioAño'))
            ->find($id);
        //dd($emplo);
        //calcular el salario por dias, por mes, por años

        //calcular por dias donde se actualice cada mes la fecha de inicio
        //agarrar la fecha de hoy y juntarla con el dia de inicio
        $mergeAM=Carbon::parse(Carbon::now())->format('Y-m');
        $mergeAM=$mergeAM.substr($emplo['fechaInicio'],7,3);
        $fechasD=carbon::parse($mergeAM);
        $fechasM=carbon::parse($emplo['fechaInicio']);
        $fechaf=carbon::parse(Carbon::now());
        //calculamos la diferencia de dias
        $diasDiferencia = $fechaf->diffInDays($fechasD);
        //calcular por mes
        $mesDiferencia = $fechaf->diffInMonths($fechasM);
        //calcular por año
        $añoDiferencia = $fechaf->diffInYears($fechasM);
        //dd($diasDiferencia.' '.$mesDiferencia.' '.$añoDiferencia);
        //sueldo a pagar x los dias transcurridos
        $pagoDias=($emplo['salarioMes']/24) * $diasDiferencia;
        //sueldo parago x los meses transcurridos
        $pagoMes=($emplo['salarioMes'] * $mesDiferencia);

        //dd($pagoMes);
        //mandar datos
        $this->sueldo=$emplo->salarioMes;
        $this->Dtranscurridos=$diasDiferencia;
        $this->pagarD=$pagoDias;
        $this->Mtranscurridos=$mesDiferencia;
        if($mesDiferencia < 1)
        $this->pagarM=0;
        else
        $this->pagarM=$pagoMes;
        //$this->nombre=$ejemplo['name'];
        //dd($this->detallempleado);
        $this->emit('detalles', 'show modal!');
    }
}
