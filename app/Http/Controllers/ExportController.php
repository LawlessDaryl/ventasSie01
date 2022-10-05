<?php

namespace App\Http\Controllers;

use App\Exports\AdministrationExport;
use App\Exports\AttendancesExport;
use App\Exports\ReporteGeneralExport;
use App\Exports\TechnicalExport;
use App\Imports\AttendancesImport;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

//importar para el excel
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    //exportar en excel Sueldos del mes
    
    public function reporteExcel($userId, $reportType, $dateFrom = null, $dateTo = null)
    {
        $date = Carbon::parse($dateFrom)->format('F');
        $this->mes=$this->Mes($date);
        ///dd($this->mes);
        $reportName = 'Reporte de Sueldos Mes de '. $this->mes.'_' . uniqid() . '.xlsx';
        return Excel::download(new ReporteGeneralExport($userId, $reportType, $dateFrom, $dateTo),$reportName );
    }
    //exportar en excel del area tecnica
    public function reporteExcelTecnico($userId, $reportType, $dateFrom = null, $dateTo = null)
    {
        $reportName = 'Reporte de Sueldos_' . uniqid() . '.xlsx';
        return Excel::download(new TechnicalExport($userId, $reportType, $dateFrom, $dateTo),$reportName );
    }
    //exportar en excel del area administrativo
    public function reporteExcelAdministrativo($userId, $reportType, $dateFrom = null, $dateTo = null)
    {
        $reportName = 'Reporte de Sueldos_' . uniqid() . '.xlsx';
        return Excel::download(new AdministrationExport($userId, $reportType, $dateFrom, $dateTo),$reportName );
    }
    
            /*public function download() 
        {
            return (new ReporteGeneralExport())->download('reporte-general.xlsx');
        }*/

    //mandar el archivo para importar desde un excel
    public function store(Request $request)
    {
        //en el $file tenemos el archivo excel para agregar todos los datos dentro del excel
        $file = $request->file('import_file');
        
        //dd($file);
        //redirecciona a import para agregar los datos
       $aux= Excel::import(new AttendancesImport, $file);
       //dd($aux);
        //retorna a la vista attendances con el back
        return redirect()->back();
                
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
}
