<?php

namespace App\Http\Controllers;

use App\Models\ProductosDestino;
use Maatwebsite\Excel\Concerns\FromCollection;


class ExportExcelAlmacenController implements FromCollection
{
    public function collection()
    {
        return ProductosDestino::all();
    }
}
