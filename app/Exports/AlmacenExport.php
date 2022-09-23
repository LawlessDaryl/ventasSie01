<?php

namespace App\Exports;

use App\Models\Almacen;
use Maatwebsite\Excel\Concerns\FromCollection;

class AlmacenExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Almacen::all();
    }
}
