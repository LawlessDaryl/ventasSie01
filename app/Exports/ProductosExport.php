<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Productos;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductosExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::select('products.nombre','products.codigo','products.precio_venta','products.category_id')->get();
    }
}
