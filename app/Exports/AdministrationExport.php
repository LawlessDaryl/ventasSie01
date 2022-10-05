<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Anticipo;
use App\Models\Discountsv;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;          // para trabajar con colecciones y obtener la data
use Maatwebsite\Excel\Concerns\WithHeadings;          //para definir los titulos de encabezado
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;       //para interactuar con el libro
use Maatwebsite\Excel\Concerns\WithCustomStartCell;     //para definir la celda donde inicia el reporte
use Maatwebsite\Excel\Concerns\WithTitle;               //para colocar el nombre a las hojas del libro
use Maatwebsite\Excel\Concerns\WithStyles;              //para dar formato a las celdas

use PhpOffice\PhpSpreadsheet\Style\Fill;                //desde aca hasta eventos son lo que usaremos
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithEvents;              //para que funcionen los eventos enviados
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;    // el ancho de celdas
use Maatwebsite\Excel\Concerns\WithDrawings;        //agregar imagenes
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;  //todos los eventos
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;

class AdministrationExport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithStyles, WithDefaultStyles, WithEvents, WithColumnWidths, WithDrawings, WithColumnFormatting
{
    
    protected $userId, $dateFrom, $dateTo, $reportType;
    public $cell;
    //calcular cuantas filas se tiene
    public $data2, $Allemployee;
    //para agregar los tatales
    public $horitas, $Dtrabajados,$tganado;
    //Mes
    public $mes;
    
    function __construct($userId, $reportType, $f1, $f2)
    {
        $this->userId = $userId;
        $this->reportType = $reportType;
        $this->dateFrom = $f1;
        $this->dateTo = $f2;
        
    }


    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('assets/img/logo.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('B1');

        $drawing2 = new Drawing();
        $drawing2->setName('direccion');
        $drawing2->setDescription('This is my direccion');
        $drawing2->setPath(public_path('assets/img/direccion.png'));
        $drawing2->setHeight(90);
        $drawing2->setCoordinates('H1');

        return [$drawing, $drawing2];
    }
    public function Mes($m)
    {
        switch ($m) {
            case 'January':
                return 'ENERO';
                break;
            case 'February':
                return 'FEBRERO';
                break;
            case 'March':
                return 'MARZO';
                break;
            case 'April':
                return 'ABRIL';
                break;
            case 'May':
                return 'MAYO';
                break;
            case 'June':
                return 'JUNIO';
                break;
            case 'July':
                return 'JULIO';
                break;
            case 'August':
                return 'AGOSTO';
                break;
            case 'September':
                return 'SEPTIEMBRE';
                break;
            case 'Octuber':
                return 'OCTUBRE';
                break;
            case 'November':
                return 'NOVIEMBRE';
                break;
            case 'December':
                return 'DICIEMBRE';
                break;
            default:
                return "no se encontro resultado";
        }
    }
    public function collection()
    {
        
        $data = [];
        //validar el tipo de reporte
        if($this->reportType == 1)
        {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59';
        } else {
             //fecha de ahora 
             $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
             $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        }
        //mostrar el dia de la fecha en letras
        
        //$date = Carbon::parse($this->dateFrom)->format('F');
        $date = new Carbon('today');
        $date = $date->format('F');
        //dd($date);
        $this->mes=$this->Mes($date);
        //dd($this->mes);

        

        $num=1;
        //esto tendria que ser los datos que mandaremos para el excel
        $reporte = Employee::join('area_trabajos as at', 'at.id', 'employees.area_trabajo_id')
        ->join('contratos as ct', 'ct.id', 'employees.contrato_id')
        ->join('cargos as pt', 'pt.id', 'employees.cargo_id')
        ->select('employees.id', DB::raw("CONCAT(employees.name,' ',employees.lastname) AS Nombre"), 'pt.name as cargo', DB::raw('0 as Horas') , 'ct.salario', DB::raw('0 as Adelanto' ) ,DB::raw('0 as Descuento'), DB::raw('0 as Bonificaciones'),DB::raw('0 as Total_pagado'),DB::raw('0 as retrasos'))
        ->where('at.id',1)
        ->get();
        //dd($reporte);
        //calcular las horas totateles, retrasdos, dias de cada empleado
        foreach ($reporte as $h) {
            $data3 = Attendance::join('employees as e','e.id','attendances.employee_id')
            ->select('attendances.fecha',  'attendances.entrada', 'attendances.salida',DB::raw('0 as retraso'), DB::raw('0 as hcumplida'))
            ->whereBetween('attendances.fecha', [$from,$to])
            ->where('employee_id', $h->id)
            ->get();
            foreach ($data3 as $os)
             {   
                 
                 //validar el horario conformado y enviarlo a unfuncion para calcular
                 //if($os->turno=='medio turno TARDE' || $os->permiso =='tarde')
                 if($os->entrada>'14:00:00') {
                     //dd('hola');
                 $timestamp = $this->strtotime($os->entrada,"14:00:00");
                 //dd($timestamp);
                 $os->retraso = $timestamp;
                 }
                 //if($os->turno=='medio turno mañana' || $os->permiso =='mañana')
                     elseif($os->entrada >'08:00:00' && $os->entrada < '13:00:00')
                     {
                         
                         $timestamp = $this->restar_horas($os->entrada,"08:05:00");
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
             //sumar horas, minutos de retraso y dias
            //dd($data3);
            $horasum='00:00:00';
            $retrasomin = '00:00:00';
            $dias = 0;
            foreach ($data3 as $x) {
                //$fechasD=carbon::parse($mergeAM);
                $e = Carbon::parse($x->entrada);
                $s = Carbon::parse($x->salida);
                
                if($x->entrada != "00:00:00" && $x->salida != "00:00:00")
                {  
                    $diferencia = $e->diff($s)->format('%H:%I:%S');
                }
                
                if($x->name == "Yazmin")
                {
                    //dump($diferencia);
                }
               //$hora= $diferencia->format('%H:%I:%S');
                //dump($e);
                //dump($s);

                //dd($diferencia);
                $horasum=$this->suma_horas($horasum,$diferencia);
                if($x->retraso != "Ninguno" && $x->retraso != "No marco entrada")
                {
                    //dd($x->retraso);
                    $retrasomin=$this->suma_horas($retrasomin,$x->retraso);
                }
                
                $dias++;
                //dd($retrasomin);
                //dd($horasum);
            }
            //$h->retrasos=$retrasomin;
            $h->Horas=$horasum;

            //Descuento varios
                $fecfrom = Carbon::parse($this->dateFrom)->format('Y-m-d');
                $fecto = Carbon::parse($this->dateTo)->format('Y-m-d');
                $descuento = Discountsv::select('discountsvs.*')
                ->where('discountsvs.ci',$h->id)
                ->whereBetween('discountsvs.fecha', [$fecfrom,'2022-09-30'])
                ->get(); 
                //dd($descuento);
                $desctotal=0;
                foreach ($descuento as $d) {
                    $desctotal=$desctotal+$d->descuento;
                }
            $h->Descuento= number_format($desctotal,2) ;

            //Adelantos o Anticipos
                $adelantos = Anticipo::select('anticipos.*')
                ->where('anticipos.empleado_id',$h->id)
                ->get();
                //dd($adelantos);
                $adelantototal=0;
                foreach ($adelantos as $d) {
                    $adelantototal=$adelantototal+$d->anticipo;
                }

            $h->Adelanto= number_format($adelantototal,2);
            $h->Total_pagado=$h->salario - ($h->Descuento + $h->Adelantos);

            $h->id=$num;
            $num++;
            //$h->Dias_trabajados=$dias;
        }


        //sumar columnas para agregar a los totales
        $this->horitas = '00:00:00';
        $this->tganado = 0;
       
        foreach ($reporte as $x) {
                $this->horitas = $this->suma_horas($this->horitas,$x->Horas);
                $this->tganado = $this->tganado + $x->salario;
            
        }
        //dd($horitas);
        //dd($reporte);
        //empleados
        $data2 = Employee::join('area_trabajos as at', 'at.id', 'employees.area_trabajo_id')
        ->select('employees.id', 'employees.name', 'at.nameArea as area')
        ->where('at.id',1)
        ->get();
        //dd($data2);
        //dd($data);
        //retornar datos para el exel
        return $reporte;
    }
    

    //CABECERAS DEL REPORTE
    public function headings(): array
    {
        $date = Carbon::parse($this->dateFrom)->format('F');
        //$date = new Carbon('today');
        //$date = $date->format('F');
        //dd($date);

            //FECHA
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d');
            $to = Carbon::parse($this->dateTo)->format('Y-m-d');
       
        $this->mes=$this->Mes($date);
        //dd($this->mes);
        
           //dd($this->mes);

            return [
                 ["SOLUCIONES INFORMATICAS EMANUEL"],
                 ["PLANILLA DE SUELDOS Y SALARIOS PERSONAL ADMINISTRATIVO"],
                 ["MES DE ".$this->mes], //AGREGAR MES DE EMEISION
                 ["DESDE EL ".$from." HASTA EL ".$to],
                 [""],
                ["N", "NOMBRE", "CARGO", "HORAS TRABAJADAS", "TOTAL GANADO", "ADELANTOS", "DESCUENTOS", "BONIFICACION", "TOTAL PAGADO"],
            ];
        

        
    }
    /*public function headingRow(): int
    {
        return 3;
    }*/
    //el ancho de una cell
    public function columnWidths(): array
    {
        return [
            'A' => 3,
            'B' => 25,
            'C' => 15,
            'D' => 10,
            'E' => 11,
            'F' => 11,
            'G' => 12,
            'H' => 10,
            'I' => 11,         
        ];
    }
    //WithColumnFormatting
    //formato que se mostraran los datos
    public function columnFormats(): array
    {
        return [
            'E' => '0.00',
            'F' => '0.00',
            'G' => '0.00',
            'H' => '0.00',
            'I'=> '0.00',
        ];
    }
    
    //Definiendo en que cel se imprimira el reporte
    public function startCell(): string
    {
        return 'A3';
    }

    //Estilos para el excel
    public function styles(Worksheet $sheet)
    {
        return [
            /*'A2' => ['font' => ['bold' => true, 'size' => 15,'color' => array('rgb' => 'blue')],
            /*'background' => [
                'color'=>  array('rgb' => 'red')
            ]
            ],*/

            

            3    => ['font' => [
                'size' => 14,
                'bold' => true],
                    ],

            6  => ['font' => [
                'size' => 14,
                'bold' => true],
                    ],
            
        ];
        
    }

    //Titulo del Excel
    public function title(): string
    {
        return 'Reporte de Salarios Administracion';
    }
    

    public function defaultStyles(Style $defaultStyle)
    {
        
    
        
    }
    

    public static function afterSheet(AfterSheet $event){
        $event->sheet->appendRows(array(
            array('test1', 'test2'),
            array('test3', 'test4'),
            //....
        ), $event);
    }
    //PINTAR CELDAS AL COLOR QUE QUERAMOS
    public function registerEvents(): array
    {
        
        
        //contar los resultados existentes para el bordeado del excel
        $this->Allemployee = Employee::join('area_trabajos as at', 'at.id', 'employees.area_trabajo_id')
        ->select('employees.id', 'employees.name', 'at.nameArea as area')
        ->where('at.id',1)
        ->get()
        ->count();
            //dd($this->Allemployee);

            //dd($Allemployee);
            //estilos para el excel para todos
            $i=8;
            $this->cell='A'.$i.':I'.($this->Allemployee+9);
            $this->B='B8:B'.($this->Allemployee+9);
            $this->C='C8:C'.($this->Allemployee+9);
            $this->D='D8:D'.($this->Allemployee+9);
            $this->E='E8:E'.($this->Allemployee+9);
            $this->F='F8:F'.($this->Allemployee+9);
            $this->H='H8:H'.($this->Allemployee+9);

            $this->total='A'.($this->Allemployee+9).':C'.($this->Allemployee+9);
            //dd($this->total);
            //dd($cell);
            return [ 
                
                AfterSheet::class    => function(AfterSheet $event) {
                    Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
                        $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
                    });
                    //footer total y suma de totales
                    
                    $event->sheet->appendRows(array(
                        array('Total','','',$this->horitas,$this->tganado),
                        
                        //....
                    ), $event);
                    $event->sheet->mergeCells($this->total);
                     $event->sheet->getDelegate()->getStyle($this->total)
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    /*$event->sheet->appendRows(1, array(
                        'prepended', 'prepended'
                    ));*/
                    //alto de las columnas
                    $event->sheet->getDelegate()->getRowDimension('8')->setRowHeight(40);
                    /*$event->sheet->setHeight(array(
                        1     =>  50
                    ));*/
                    //ajustar el texto al tamaño de la columna
                    //$event->sheet->getStyle('A6:B' . $event->sheet->getHighestRow())->getAlignment()->setWrapText(true);
                    $event->sheet->getStyle('A8:I12')->getAlignment()->setWrapText(true);
                     //centrear A3 hasta l3
                     $event->sheet->mergeCells('A3:I3');
                     $event->sheet->getDelegate()->getStyle('A3:I3')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            //centrear A3 hasta l3
                     $event->sheet->mergeCells('A4:I4');
                     $event->sheet->getDelegate()->getStyle('A4:I4')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            //centrear A3 hasta l3
                     $event->sheet->mergeCells('A5:I5');
                     $event->sheet->getDelegate()->getStyle('A5:I5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    //centrar A6 hasta I6
                    $event->sheet->mergeCells('A6:I6');
                    $event->sheet->getDelegate()->getStyle('A6:I6')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    
                            

                            $event->sheet->getDelegate()->getStyle('B8:B12')
                            ->getAlignment()
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

                            $event->sheet->getDelegate()->getStyle('A8:I8')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    //para el color de fondo de una celda o varias ejm:('A:C')
                    //PARA LAS FILAS PRINCIPALES DEL ENCABEZADO
                    
                  
                            
                            $event->sheet->styleCells(
                                $this->cell,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                $this->B,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                $this->D,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                $this->F,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                $this->H,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                                        ],
                                    ]
                                ]
                            );
                            for ($i=9; $i < $this->Allemployee+9 ; $i++) { 
                                $this->pintar='A'.$i.':I'.$i;
                                //dd($this->pintar);
                                $event->sheet->styleCells(
                                    $this->pintar,
                                    [
                                        'borders' => [
                                            'outline' => [
                                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                                            ],
                                        ]
                                    ]
                                );
                            }
                            
                            $event->sheet->styleCells(
                                'A8:I8',
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                                        ],
                                    ]
                                ]
                            );
                
                            $event->sheet->styleCells(
                                'A8:I8',
                                [
                                    'font' => [
                                        'name'      =>  'Times New Roman',
                                        'size'      =>  8,
                                        'bold'      =>  true,
                                        'color' => ['rgb' => 'black'],
                                    ],
                                ]
                            );

                            //darle tamaño, tipo letra y negrilla en la columna
                            $event->sheet->styleCells(
                                'B',
                                [
                                    'font' => [
                                        'name'      =>  'Times New Roman',
                                        'size'      =>  11,
                                        'bold'      =>  true,
                                        'color' => ['rgb' => 'black'],
                                    ],
                                ]
                            );

                           
                            
    
                                
                    
                },
    
            ];
        
        
        

       
            
        
       
    }

    //Función que resta horas Ahi que tenerla por si a caso
 
    function restar_horas($hora1,$hora2){
 
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
         $minutoconformada=(int)  substr($horaconformada,3,2);
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
    //sumar horas
    function suma_horas($hora1,$hora2){
        
        $hora1=explode(":",$hora1);
        $hora2=explode(":",$hora2);
        $temp=0;
        //sumo segundos 
        $segundos=(int)$hora1[2]+(int)$hora2[2];
        while($segundos>=60){
            $segundos=$segundos-60;
            $temp++;
        }
     
        //sumo minutos 
        $minutos=(int)$hora1[1]+(int)$hora2[1]+$temp;
        $temp=0;
        while($minutos>=60){
            $minutos=$minutos-60;
            $temp++;
        }
     
        //sumo horas 
        $horas=(int)$hora1[0]+(int)$hora2[0]+$temp;
     
        if($horas<10)
            $horas= '0'.$horas;
     
        if($minutos<10)
            $minutos= '0'.$minutos;
     
        if($segundos<10)
            $segundos= '0'.$segundos;
     
        $sum_hrs = $horas.':'.$minutos.':'.$segundos;
     
        return ($sum_hrs);
     
        }
}
