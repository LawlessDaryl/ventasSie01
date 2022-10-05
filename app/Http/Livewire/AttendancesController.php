<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AttendancesController extends Component
{
    use WithPagination;
    public $reportType, $userId, $dateFrom, $dateTo, $horaentrada,$horaconformada, $componentName, $title, $fechahoy, $total, $archivo ,$verfiarchivo;
    //datos para fallo

    public $fechaf, $empleadoid, $entradaf, $salidaf, $prueba;

    protected $pagination;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }


    //paginador de collections
    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        //dd('hola');
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);
        
        $pg= new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        //dd($this->data);
        //retornamos lo obtenido en el pg que manda los datos para el paginador
        return $pg;
    }
    //propiedades de las vistas
    public function mount(){
    
        $this->reportType = 0;
        $this->userId = 0;
        $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->componentName = "Fallo de Sistema";
        $this->title = "algo";
        $this->fechahoy = Carbon::parse(Carbon::now())->format('Y-m-d');
      // 
    }

    public function render()
    {
        //hacemos el llamando a la funcion SalesByDate y luego usamos la funcion paginate para obtener 
        //el total de paginas para la vista
        $paginador=$this->paginate($this->SalesByDate());
        return view('livewire.attendances.component',[
            'employees' => Employee::orderBy('name','asc')->get(),
            'datos' => $paginador,
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
    
    public function archivo()
    {
        $this->verfiarchivo=1;
    }
    //metodo retornar reporte de la fecha
    public function SalesByDate()
    {
        //mostrar el dia de la fecha en letras
        /*$date = new Carbon('today');
        
        $date = $date->format('l jS \\of F Y h:i:s A');
        dd($date);*/
        //obtener las entradas del dia
        if($this->reportType == 0)// entradas del dia
        {
            //obtener fecha de hoy
            $from = Carbon::parse(Carbon::now())->format('Y-m-d');
            $to = Carbon::parse(Carbon::now())->format('Y-m-d');
        } else {
            //obtener fechas especificadas por el usuario
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d');
            $to = Carbon::parse($this->dateTo)->format('Y-m-d');
            //dd($this->archivo);
            //$file = $this->archivo->file('import_file');
            //dd($this->file);
            
        }   
        
        //validar si el usuario esta usando un tipo de reporte
        // if($this->reportType == 1 && ($this->dateFrom == '' || $this->dateTo == '')) {
        //     dd("Hola");
        //     return;
        // }
        //validar si seleccionamos algun usuario
        if($this->userId == 0){
            $emplo=Employee::orderBy('name','asc')->get();
            //dd($emplo);
            //consulta
            $xd=Attendance::select('attendances.*')->get();
            //dd($xd);
            $this->data = Attendance::join('employees as e','e.id','attendances.employee_id')
            ->join('shifts as s', 's.ci', 'attendances.employee_id')
            ->select('attendances.*','e.name as employee',DB::raw('0 as retraso'), DB::raw('0 as hcumplida'),'s.monday','s.tuesday','s.wednesday','s.thursday','s.friday','s.saturday', DB::raw('0 as Salida_Normal'), DB::raw('0 as dia') )
            ->whereBetween('attendances.fecha', [$from,$to])
            //->groupBy("e.id")
            ->orderBy('attendances.fecha','asc')
            ->get();
            
           
            //agregar el tiempo de retrasa del empleado
            foreach ($this->data as $os)
                                {   //dd($os);
                                    
                                    //validar el horario conformado y enviarlo a unfuncion para calcular
                                    //if($os->turno=='medio turno TARDE' || $os->permiso =='tarde')
                                    if($os->entrada>'14:00:00') {
                                        //validar si su entrada fue en otro turno
                                        if($this->dia($os->employee_id,$os->fecha)<$os->entrada && $os->entrada>'13:00:00')
                                        {
                                            
                                            $timestamp = $this->restar_horas($os->entrada,'14:05:00');
                                        }else
                                        {
                                            $timestamp = $this->restar_horas($os->entrada,$this->dia($os->employee_id,$os->fecha));
                                        }
                                           // $timestamp = $this->strtotime($os->entrada,'14:00:00');
                                        
                                    //dump($timestamp);
                                        $os->retraso = $timestamp;
                                    }
                                    //if($os->turno=='medio turno mañana' || $os->permiso =='mañana')
                                        elseif($os->entrada >'08:00:00' && $os->entrada < '13:00:00')
                                        {
                                            //validar si su entrada fue en otro turno
                                            if($this->dia($os->employee_id,$os->fecha)>$os->entrada && $os->entrada<'13:00:00')
                                            {
                                            
                                                $timestamp = $this->restar_horas($os->entrada,'08:05:00');
                                            }else
                                            {
                                                $timestamp = $this->restar_horas($os->entrada,$this->dia($os->employee_id,$os->fecha));
                                            }
                                           // $timestamp = $this->strtotime($os->entrada,'08:00:00');
                                            //dd($timestamp);
                                            $os->retraso = $timestamp;
                                        }   else{
                                                if($os->salida=='00:00:00')
                                                {
                                                    $os->retraso = 'No marco salida';
                                                }
                                                else
                                                $os->retraso = 'Ninguno';
                                                if($os->entrada == '00:00:00')
                                                {
                                                    $os->retraso = 'No marco entrada';
                                                }
                                                else
                                                $os->retraso = 'Ninguno';

                                               
                                            }
                                    
                                }
            //agregar las horas cumplidas del usuario
            foreach ($this->data as $os)
            {
                //validacion del dia de hoy
                
                $fec=Carbon::parse($os->fecha)->format('l');
                $os->dia=$this->fecha_dia($fec);
                //validacion de no marco salida
                if($os->salida=="00:00:00")
                {
                    $os->Salida_Normal = "No marco salida";
                }
                else{
                    $os->Salida_Normal = "Normal";
                }
                $timeacumleted= $this->horascumplidas($os->entrada, $os->salida);
                if($os->employee=='Carlos')
                {
                    //dd($timeacumleted);
                }
                if($timeacumleted>'04:40:00' && $os->entrada > '08:00:00')
                {
                    
                    $os->hcumplida='Cumplio';
                    
                }
                else{
                    $os->hcumplida='No Cumplio';
                }

            }
                                
            
        } else {

            $this->data = Attendance::join('employees as e','e.id','attendances.employee_id')
            ->join('shifts as s', 's.ci', 'attendances.employee_id')
            ->select('attendances.*','e.name as employee',DB::raw('0 as retraso'), DB::raw('0 as hcumplida'),'s.monday','s.tuesday','s.wednesday','s.thursday','s.friday','s.saturday', DB::raw('0 as Salida_Normal'), DB::raw('0 as dia'))
            ->whereBetween('attendances.fecha', [$from,$to])
            ->where('employee_id', $this->userId)
            ->orderBy('attendances.fecha','asc')
            ->get();
            //dd($this->data);
            $this->data2 = Attendance::join('employees as e','e.id','attendances.employee_id')
            ->join('shifts as s', 's.id', 'attendances.employee_id')
            ->select('attendances.*','e.name as employee',DB::raw('0 as retraso'),'s.monday','s.tuesday')
            ->whereBetween('attendances.fecha', [$from,$to])
            ->where('employee_id', $this->userId)
            ->orderBy('attendances.fecha','asc')
            ->get();
            //dd($this->data);
             //agregar el tiempo de retrasa del empleado
             foreach ($this->data as $os)
             {   
                
               
                 //validar el horario conformado y enviarlo a unfuncion para calcular
                 //if($os->turno=='medio turno TARDE' || $os->permiso =='tarde')
                if($os->entrada>'14:00:00') {
                   
                     //validar si su entrada fue en otro turno
                        if($this->dia($os->employee_id,$os->fecha)<$os->entrada && $os->entrada>'13:00:00')
                        {
                            
                            $timestamp = $this->restar_horas($os->entrada,'14:05:00');
                        }else
                        {
                            $timestamp = $this->restar_horas($os->entrada,$this->dia($os->employee_id,$os->fecha));
                        }
                    
                 //dd($timestamp);
                    $os->retraso = $timestamp;
                 }
                 //if($os->turno=='medio turno mañana' || $os->permiso =='mañana')
                     elseif($os->entrada >'08:00:00' && $os->entrada < '13:00:00')
                     {
                        
                        //validar si su entrada fue en otro turno
                        if($this->dia($os->employee_id,$os->fecha)>'13:00:00' && $this->dia($os->employee_id,$os->fecha)>$os->entrada && $os->entrada<'13:00:00')
                        {
                            /*if($os->employee_id==8693177){
                                dd($os);
                            }*/
                           
                            $timestamp = $this->restar_horas($os->entrada,'08:05:00');
                        }else
                        {
                            /*if($os->employee_id==11267379 && $os->fecha=='2022-08-02'){
                                dd($os);
                            }*/
                            $timestamp = $this->restar_horas($os->entrada,$this->dia($os->employee_id,$os->fecha));
                        }
                        
                         //dd($timestamp);
                         $os->retraso = $timestamp;
                     }   else{
                            
                             if($os->salida == '00:00:00')
                             {
                                 $os->retraso = 'No marco salida';
                             }
                             else
                                $os->retraso = 'Ninguno';
                                
                            
                             
                             if($os->entrada == '00:00:00')
                             {
                                //dd('hola');
                                 $os->retraso = 'No marco entrada';
                             }
                             else
                             $os->retraso = 'Ninguno';

                            
                         }
                 
             }
        //agregar las horas cumplidas del usuario
        foreach ($this->data as $os)
        {
            //agregar dia que fue
            
            $fec=Carbon::parse($os->fecha)->format('l');
            $os->dia = $this->fecha_dia($fec);
            //no marco salida validacion
            if($os->salida=="00:00:00"){
                $os->Salida_Normal="Se Quedo a Dormir";
            }
            else{
                $os->Salida_Normal = "Normal";
            }

        $timeacumleted= $this->horascumplidas($os->entrada, $os->salida);
        if($os->employee=='Carlos')
        {
        //dd($timeacumleted);
        }
        if($timeacumleted>'04:40:00' && $os->entrada > '08:00:00')
        {
        
        $os->hcumplida='Cumplio';
        
        }
        else{
        $os->hcumplida='No Cumplio';
        }

        }
            }
            return $this->data;
    }
    //calcular el horario cumplido del empleado
    public function horascumplidas($horaentrada, $horasalida)
    {
        $timeacumleted='';
        //hora que entro el empleado
        $horaE=(int)  substr($horaentrada,0,2);
        $minutoE=(int)  substr($horaentrada,3,2);
        $segundoE=(int)  substr($horaentrada,6,2);
        //hora que salio el empleado
        $horaS=(int)  substr($horasalida,0,2);
        $minutoS=(int)  substr($horasalida,3,2);
        $segundoS=(int)  substr($horasalida,6,2);
        
        $horaretraso=abs($horaS-$horaE);
        $minutoretraso=abs($minutoS-$minutoE);
        $segundosretraso=abs($segundoS-$segundoE);

        if($minutoE > $minutoS)
        {
            $horaretraso= abs($horaretraso-1);
        }
        
        //validar el time para que retorne valor ordenado
        if($segundosretraso<10 && $minutoretraso<10 && $horaretraso<10){
            $timeacumleted='0'.$horaretraso.':0'.$minutoretraso.':0'.$segundosretraso;
        }
        //para ver si funciona a o no
        /*if($horaentrada=='14:25:17')
        {
            dd($minutoretraso);
            dd($horataconformada.':'.$minutoconformada.':'.$segundoconformada);
        }*/
        if($segundosretraso>9 && $minutoretraso>9 && $horaretraso>9){
            $timeacumleted=$horaretraso.':'.$minutoretraso.':'.$segundosretraso;
        }

        if($segundosretraso<10 && $minutoretraso<10 && $horaretraso>9){
            $timeacumleted=$horaretraso.':0'.$minutoretraso.':0'.$segundosretraso;
        }

        if($segundosretraso<10 && $minutoretraso>9 && $horaretraso<10){
            $timeacumleted='0'.$horaretraso.':'.$minutoretraso.':0'.$segundosretraso;
        }
        if($segundosretraso>9 && $minutoretraso<10 && $horaretraso<10)
        {
            $timeacumleted='0'.$horaretraso.':0'.$minutoretraso.':'.$segundosretraso;
        }
        if($segundosretraso>9 && $minutoretraso>9 && $horaretraso<10)
        {
            $timeacumleted='0'.$horaretraso.':'.$minutoretraso.':'.$segundosretraso;
        }
        
        //dd($retraso);
        return $timeacumleted;
    }

    //Función que resta horas Ahi que tenerla por si a caso
 
    function restar_horas($hora1,$hora2)
    {
 
        if($hora1<=$hora2)
        {
            $timestamp = 'Ninguno';
            return $timestamp;
        }
        $temp1 = explode(":",$hora1);
        $temp_h1 = (int)$temp1[0];
        $temp_m1 = (int)$temp1[1];
        $temp_s1 = (int)$temp1[2];
        $temp2 = explode(":",$hora2);
        $temp_h2 = (int)$temp2[0];
        $temp_m2 = (int)$temp2[1];
        $temp_s2 = (int)$temp2[2];
     
        // si $hora2 es mayor que la $hora1, invierto 
        if( $temp_h1 < $temp_h2 ){
            $temp  = $hora1;
            $hora1 = $hora2;
            $hora2 = $temp;
        }
        /* si $hora2 es igual $hora1 y los minutos de 
           $hora2 son mayor que los de $hora1, invierto*/
        elseif( $temp_h1 == $temp_h2 && $temp_m1 < $temp_m2){
            $temp  = $hora1;
            $hora1 = $hora2;
            $hora2 = $temp;
        }
        /* horas y minutos iguales, si los segundos de  
           $hora2 son mayores que los de $hora1,invierto*/
        elseif( $temp_h1 == $temp_h2 && $temp_m1 == $temp_m2 && $temp_s1 < $temp_s2){
            $temp  = $hora1;
            $hora1 = $hora2;
            $hora2 = $temp;
        }
     
        $hora1=explode(":",$hora1);
        $hora2=explode(":",$hora2);
        $temp_horas = 0;
        $temp_minutos = 0;
     
        //resto segundos 
        $segundos;
        if( (int)$hora1[2] < (int)$hora2[2] ){
            $temp_minutos = -1;
            $segundos = ( (int)$hora1[2] + 60 ) - (int)$hora2[2];
        }
        else
            $segundos = (int)$hora1[2] - (int)$hora2[2];
     
        //resto minutos 
        $minutos;
        if( (int)$hora1[1] < (int)$hora2[1] ){
            $temp_horas = -1;
            $minutos = ( (int)$hora1[1] + 60 ) - (int)$hora2[1] + $temp_minutos;
        }
        else
            $minutos =  (int)$hora1[1] - (int)$hora2[1] + $temp_minutos;
     
        //resto horas     
        $horas = (int)$hora1[0]  - (int)$hora2[0] + $temp_horas;
     
        if($horas<10)
            $horas= '0'.$horas;
     
        if($minutos<10)
            $minutos= '0'.$minutos;
     
        if($segundos<10)
            $segundos= '0'.$segundos;
     
        $rst_hrs = $horas.':'.$minutos.':'.$segundos;
     
        return ($rst_hrs);
     
    }

    //calcular el tiempo del retraso del empleado
    public function strtotime($horaentrada,$horaconformada)
    {
        if($horaentrada<=$horaconformada)
        {
            $timestamp = 'Ninguno';
            return $timestamp;
        }
       //dd($horaconformada.' '.$horaentrada);
        $timestamp='';
        //hora que entro el empleado
        $hora=(int)  substr($horaentrada,0,2);
        $minuto=(int)  substr($horaentrada,3,2);
        $segundo=(int)  substr($horaentrada,6,2);
        //horaconfomada asginada para entrar
        $horataconformada=(int)  substr($horaconformada,0,2);
        $minutoconformada=(int)  substr($horaconformada,3,2)+5;
        $segundoconformada=(int)  substr($horaconformada,6,2);
        //calculamos el retrasa
        $horaretraso=$hora-$horataconformada;
        $minutoretraso=$minuto-$minutoconformada;
        $segundosretraso=$segundo-$segundoconformada;
        //validar el time para que retorne valor ordenado
        if($segundosretraso<10 && $minutoretraso<10 && $horaretraso<10){
            $timestamp='0'.$horaretraso.':0'.$minutoretraso.':0'.$segundosretraso;
        }
        //para ver si funciona a o no
        /*if($horaentrada=='14:25:17')
        {
            dd($minutoretraso);
            dd($horataconformada.':'.$minutoconformada.':'.$segundoconformada);
        }*/
        if($segundosretraso>9 && $minutoretraso>9 && $horaretraso>9){
            $timestamp=$horaretraso.':'.$minutoretraso.':'.$segundosretraso;
        }

        if($segundosretraso<10 && $minutoretraso<10 && $horaretraso>9){
            $timestamp=$horaretraso.':0'.$minutoretraso.':0'.$segundosretraso;
        }

        if($segundosretraso<10 && $minutoretraso>9 && $horaretraso<10){
            $timestamp='0'.$horaretraso.':'.$minutoretraso.':0'.$segundosretraso;
        }
        if($segundosretraso>9 && $minutoretraso<10 && $horaretraso<10)
        {
            $timestamp='0'.$horaretraso.':0'.$minutoretraso.':'.$segundosretraso;
        }
        if($segundosretraso>9 && $minutoretraso>9 && $horaretraso<10)
        {
            $timestamp='0'.$horaretraso.':'.$minutoretraso.':'.$segundosretraso;
        }
        
        //dd($retraso);
        return $timestamp;
        
    }

    //fallo de sistema agregar manualmente
    public function fallo()
    {
       //validar la fecha dentro del empleado
       $fechap=Attendance::select('attendances.*')
       ->where('attendances.employee_id', $this->empleadoid)
       ->where('fecha','=', $this->fechaf)
       ->get();
       $fechav=$fechap->first();
       //validar para el msg de error
        if($fechav==null){
            $this->prueba=1;
        }
        else{
            $this->prueba=null;
        }
        
        //required_if verifica 
        $rules = [
            'empleadoid' => 'required|not_in:Elegir',
            'fechaf' => "required",
            'prueba' => "required_if:prueba,null"
        
        ];
        $messages =  [
            'empleadoid.required' => 'Elija un Empleado',
            'empleadoid.not_in' => 'Elije un nombre de empleado diferente de elegir',
            'prueba.required_if' => 'Elija una fecha no asignada',
            'fechaf.required' => 'Este espacio es requerida'
        ];
        $this->validate($rules,$messages);
       // dd($this->entradaf);
        $anticipo = Attendance::create([
            'fecha' => $this->fechaf,
            'entrada' => $this->entradaf.':00',
            'salida'=>$this->salidaf.':00',
            'employee_id'=>$this->empleadoid
        ]);

        $this->resetUI();
        $this->emit('asist-fallo','Actualizar Fallo');
    }

    // vaciar formulario
    public function resetUI(){
        
        $this->empleadoid = 'Elegir';
        $this->fechaf = '';
        $this->entradaf='';
        $this->salidaf='';
        $this->resetValidation(); // resetValidation para quitar los smg Rojos
    }

    //metodo que mandara el horario del dia 
    public function dia($id, $fecha)
    {
        //dd($id);
        
        $dia = new Carbon('today');
        $dia = $dia->format('l');
        $fec=Carbon::parse($fecha)->format('l');
        //dd($fec);
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d');
            $to = Carbon::parse($this->dateTo)->format('Y-m-d');

                $this->data2 = Attendance::join('employees as e','e.id','attendances.employee_id')
            ->join('shifts as s', 's.ci', 'attendances.employee_id')
            ->select('attendances.*','e.name as employee',DB::raw('0 as retraso'), DB::raw('0 as hcumplida'),'s.monday','s.tuesday','s.wednesday','s.thursday','s.friday','s.saturday')
            ->where('employee_id', $id)
            ->where('attendances.fecha' , $fecha)
            ->get();
            
            //dd($this->data2);
                foreach ($this->data2 as $os) {
                    # code...
                    if($os->employee_id==11267379 && $os->fecha=='2022/08/02'){
                        dd($os);
                    }
                switch ($fec) {
                    case 'Monday':
                        $minuto=(int)  substr($os->monday,3,2)+5;
                        $hora=substr($os->monday,0,2);
                        $segundo=substr($os->monday,6,2);
                        if($minuto<10)
                        {
                            $os->monday=$hora.':0'.$minuto.':'.$segundo;
                        }else
                        {
                            $os->monday=$hora.':'.$minuto.':'.$segundo;
                        }
                        
                        return $os->monday;
                        break;
                    case 'Tuesday':
                        $minuto=(int)  substr($os->tuesday,3,2)+5;
                        $hora=substr($os->tuesday,0,2);
                        $segundo=substr($os->tuesday,6,2);
                        if($minuto<10)
                        {
                            $os->tuesday=$hora.':0'.$minuto.':'.$segundo;
                        }else
                        {
                            $os->tuesday=$hora.':'.$minuto.':'.$segundo;
                        }
                        
                        return $os->tuesday;
                        break;
                    case 'Wednesday':
                        $minuto=(int)  substr($os->wednesday,3,2)+5;
                        $hora=substr($os->wednesday,0,2);
                        $segundo=substr($os->wednesday,6,2);
                        if($minuto<10)
                        {
                            $os->wednesday=$hora.':0'.$minuto.':'.$segundo;
                        }else
                        {
                            $os->wednesday=$hora.':'.$minuto.':'.$segundo;
                        }
                        
                        return $os->wednesday;
                        break;
                    case 'Thursday':

                        $minuto=(int)  substr($os->thursday,3,2)+5;
                        $hora=substr($os->thursday,0,2);
                        $segundo=substr($os->thursday,6,2);
                        if($minuto<10)
                        {
                            $os->thursday=$hora.':0'.$minuto.':'.$segundo;
                        }else
                        {
                            $os->thursday=$hora.':'.$minuto.':'.$segundo;
                        }

                        return $os->thursday;
                        break;
                    case 'Friday':

                        $minuto=(int)  substr($os->friday,3,2)+5;
                        $hora=substr($os->friday,0,2);
                        $segundo=substr($os->friday,6,2);
                        if($minuto<10)
                        {
                            $os->friday=$hora.':0'.$minuto.':'.$segundo;
                        }else
                        {
                            $os->friday=$hora.':'.$minuto.':'.$segundo;
                        }

                        return $os->friday;
                        break;
                    case 'Saturday':

                        $minuto=(int)  substr($os->saturday,3,2)+5;
                        $hora=substr($os->saturday,0,2);
                        $segundo=substr($os->saturday,6,2);
                        if($minuto<10)
                        {
                            $os->saturday=$hora.':0'.$minuto.':'.$segundo;
                        }else
                        {
                            $os->saturday=$hora.':'.$minuto.':'.$segundo;
                        }

                        return $os->saturday;
                        break;
                    default:
                        return "no se encontro resultado";
                }
            }
    }

    //dia
    public function fecha_dia($dia)
    {
        switch ($dia) {
            case 'Monday':
                
                return "Lunes";
                break;
            case 'Tuesday':
                
                return "Martes";
                break;
            case 'Wednesday':
                
                return "Miercoles";
                break;
            case 'Thursday':

                return "Jueves";
                break;
            case 'Friday':


                return "Viernes";
                break;
            case 'Saturday':

                return "Sabado";
                break;
            default:
                return "no se encontro resultado";
        }
    }
}