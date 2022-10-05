<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReporteGeneralExport implements WithMultipleSheets
{
    use Exportable;

    function __construct($userId, $reportType, $f1, $f2)
    {
        $this->userId = $userId;
        $this->reportType = $reportType;
        $this->dateFrom = $f1;
        $this->dateTo = $f2;
        
    }


    /**
     * @return array
     */
    //este reporte general unira las 2 export de administraicon y tecnica
    //para luego unirlos en un multisheet con el siguiente metodo
    public function sheets(): array
    {
        $sheets = [];
        // Agregas las controlador para agregar al multisheet
        array_push($sheets, new AdministrationExport($this->userId, $this->reportType, $this->dateFrom, $this->dateTo));
        array_push($sheets, new TechnicalExport($this->userId, $this->reportType, $this->dateFrom, $this->dateTo));
        
        return $sheets;
    }
}
