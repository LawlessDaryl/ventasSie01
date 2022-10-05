<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;          // para trabajar con colecciones y obtener la data
use Maatwebsite\Excel\Concerns\WithHeadings;          //para definir los titulos de encabezado
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;       //para interactuar con el libro
use Maatwebsite\Excel\Concerns\WithCustomStartCell;     //para definir la celda donde inicia el reporte
use Maatwebsite\Excel\Concerns\WithTitle;               //para colocar el nombre a las hojas del libro
use Maatwebsite\Excel\Concerns\WithStyles;              //para dar formato a las celdas
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithEvents;              //para que funcionen los eventos enviados
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;    // el ancho de celdas
use Illuminate\Contracts\View\View;


class AttendancesExport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithStyles, WithDefaultStyles, WithEvents, WithColumnWidths
{
    
    protected $userId, $dateFrom, $dateTo, $reportType;
    public $cell;
    
    function __construct($userId, $reportType, $f1, $f2)
    {
        $this->userId = $userId;
        $this->reportType = $reportType;
        $this->dateFrom = $f1;
        $this->dateTo = $f2;
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

        //validar si seleccionamos algun usuario
        if($this-> userId == 0){
            //consulta
            $data = Attendance::join('employees as e','e.id','attendances.employee_id')
            ->select('attendances.fecha', 'e.name', 'attendances.entrada', 'attendances.salida')
            ->whereBetween('attendances.fecha', [$from,$to])
            ->get();
        } else {
            $data = Attendance::join('employees as e','e.id','attendances.employee_id')
            ->select('attendances.fecha', 'e.name', 'attendances.entrada', 'attendances.salida')
            ->whereBetween('attendances.fecha', [$from,$to])
            ->where('employee_id', $this->userId)
            ->get();
        }
        //dd($data);
        //retornar datos para el exel
        return $data;
    }

    //CABECERAS DEL REPORTE
    public function headings(): array
    {
        
        if($this->userId==0)
        {
           

            return [
                'A1'=> ["REPORTE DE ASISTENCIA DESDE ".$this->dateFrom. ' Al '. $this->dateTo],
                'A2'=>["FECHA", "NOMBRE", "ENTRADA", "SALIDA", "HORARIO NORMAL", "HORAS TRABAJADAS"]
            ];
        }
        else{
            $employee = Attendance::join('employees as e','e.id','attendances.employee_id')
            ->select('e.name')
            ->where('employee_id', $this->userId)
            ->first();
            
            return
             
            [
                'A1'=> ["REPORTE DE ASISTENCIA DESDE ".$this->dateFrom. ' Al '. $this->dateTo],
                'A2'=> ["EMPLEADO:", $employee->name],
                ["FECHA", "NOMBRE", "ENTRADA", "SALIDA", "HORARIO NORMAL", "HORAS TRABAJADAS"]
            ];
        }

        
    }
    //el ancho de una cell
    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 25,
            'F' => 27,          
        ];
    }
    //Definiendo en que cel se imprimira el reporte
    public function startCell(): string
    {
        return 'A1';
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
            'A2' => ['background' => ['rgb' => Color::COLOR_YELLOW]]
            
        ];
        
    }

    //Titulo del Excel
    public function title(): string
    {
        return 'Reporte de Asistencia';
    }
    

    public function defaultStyles(Style $defaultStyle)
    {
        
    
        
    }
    //PINTAR CELDAS AL COLOR QUE QUERAMOS
    public function registerEvents(): array
    {
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

        //validar si es de un empleado o de todos
        if($this->userId == 0)
        {
            $Allemployee = Attendance::join('employees as e','e.id','attendances.employee_id')
            ->select('attendances.fecha', 'e.name', 'attendances.entrada', 'attendances.salida')
            ->whereBetween('attendances.fecha', [$from,$to])
            ->get()
            ->count();
            //dd($Allemployee);
            //estilos para el excel para todos
            $i=2;
            $this->cell='A'.$i.':F'.($Allemployee+2);
            $this->B='B2:B'.($Allemployee+2);
            $this->C='C2:C'.($Allemployee+2);
            $this->D='D2:D'.($Allemployee+2);
            $this->E='E2:E'.($Allemployee+2);
            $this->F='F2:F'.($Allemployee+2);
            //dd($cell);
            return [ 
                AfterSheet::class    => function(AfterSheet $event) {
                    Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
                        $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
                    });

                     //centrear A1 hasta F1
                     $event->sheet->mergeCells('A1:F1');
                     $event->sheet->getDelegate()->getStyle('A1:F1')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    //para el color de fondo de una celda o varias ejm:('A:C')
                    //PARA LAS FILAS PRINCIPALES DEL ENCABEZADO
                    
                    $event->sheet->getDelegate()->getStyle('E2')
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('FFDBE2F1');
                            
                    $event->sheet->getDelegate()->getStyle('F2')
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('yellow');
                            
                            $event->sheet->styleCells(
                                $this->cell,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                $this->B,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                $this->D,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                $this->F,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                'A2:F2',
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                
                            $event->sheet->styleCells(
                                'A2:F2',
                                [
                                    'font' => [
                                        'name'      =>  'Calibri',
                                        'size'      =>  15,
                                        'bold'      =>  true,
                                        'color' => ['rgb' => 'black'],
                                    ],
                                ]
                            );
                            
    
                                
                    
                },
    
            ];
        }
        else{
            $Oneemployee = Attendance::join('employees as e','e.id','attendances.employee_id')
            ->select('attendances.fecha', 'e.name', 'attendances.entrada', 'attendances.salida')
            ->whereBetween('attendances.fecha', [$from,$to])
            ->where('employee_id', $this->userId)
            ->get() 
            ->count();
            //dd($Oneemployee);
            $i=3;
            $this->cell='A'.$i.':F'.($Oneemployee+3);
            $this->B='B3:B'.($Oneemployee+3);
            $this->C='C3:C'.($Oneemployee+3);
            $this->D='D3:D'.($Oneemployee+3);
            $this->E='E3:E'.($Oneemployee+3);
            $this->F='F3:F'.($Oneemployee+3);
            return [ 
             
                AfterSheet::class    => function(AfterSheet $event) {
                    Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
                        $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
                    });
                    //centrear A1 hasta F1
                    $event->sheet->mergeCells('A1:F1');
                    $event->sheet->getDelegate()->getStyle('A1:F1')
                                    ->getAlignment()
                                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    //para el color de fondo de una celda o varias ejm:('A:C')
                    //PARA LAS FILAS PRINCIPALES DEL ENCABEZADO
                    $event->sheet->getDelegate()->getStyle('E3')
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('FFDBE2F1');
                            
                    $event->sheet->getDelegate()->getStyle('F3')
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('yellow');
                            
                            $event->sheet->styleCells(
                                $this->cell,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                $this->B,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                $this->D,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                $this->F,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                'A3:F3',
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                
                            $event->sheet->styleCells(
                                'A3:F3',
                                [
                                    'font' => [
                                        'name'      =>  'Calibri',
                                        'size'      =>  15,
                                        'bold'      =>  true,
                                        'color' => ['rgb' => 'black'],
                                    ],
                                ]
                            );
                            $event->sheet->styleCells(
                                'A2:F2',
                                [
                                    'font' => [
                                        'name'      =>  'Calibri',
                                        'size'      =>  15,
                                        'bold'      =>  true,
                                        'color' => ['rgb' => 'black'],
                                    ],
                                ]
                            );
                            $event->sheet->styleCells(
                                'A1:F1',
                                [
                                    'font' => [
                                        'name'      =>  'Calibri',
                                        'size'      =>  15,
                                        'bold'      =>  true,
                                        'text'      => 'center',
                                        'color' => ['rgb' => 'black'],
                                    ],
                                ]
                            );
                            
    
                                
                    
                },
    
            ];
        }
        

       
            
        
       
    }
}
