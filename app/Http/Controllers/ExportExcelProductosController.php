<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductosDestino;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportExcelProductosController implements FromCollection,WithHeadings,WithEvents
{
    public function collection()
    {

        return Product::all();
        
    }
    public function headings():array
    {
            return ['PRODUCTOS'];
        
        
    }
    public function registerevents():array
    {
            return ['PRODUCTOS'];
        
    }

}

