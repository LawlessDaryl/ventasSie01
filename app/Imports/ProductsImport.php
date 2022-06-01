<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'nombre'=>$row;
            'costo'=>;
            'caracteristicas'=>;
            'codigo'=>;
            'lote'=>;
            'unidad'=>;
            'marca'=>;
            'garantia'=>;
            'cantidad_minima'=>;
            'industria'=>;
            'precio_venta'=>;
             'status'=>;
        'category_id'=>;
    
        ]);
    }
}
