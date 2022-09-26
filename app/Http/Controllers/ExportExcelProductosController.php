<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductosDestino;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportExcelProductosController implements FromView,ShouldAutoSize
{
    public function view():View
    {
        return view ('products.export',['data'=>Product::join('categories as c', 'products.category_id','c.id')
        ->select('products.*', 'c.name as cate')->get()
       
        ]);

      
        
    }
    

}

