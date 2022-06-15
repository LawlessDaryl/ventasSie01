<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel,WithHeadingRow,WithBatchInserts,WithChunkReading,WithValidation
{
    private $categories;

    public function __construct()
    {
        $this->categories = Category::pluck('id', 'name');
       
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'nombre'=>preg_replace('/\s+/', ' ',trim($row['nombre'])),
            'costo'=>preg_replace('/\s+/', ' ',trim($row['costo'])),
            'caracteristicas'=>preg_replace('/\s+/', ' ',trim($row['caracteristicas'])),
            'codigo'=>preg_replace('/\s+/', ' ',trim($row['codigo'])),
            'lote'=>preg_replace('/\s+/', ' ',trim($row['lote'])),
            'unidad'=>preg_replace('/\s+/', ' ',trim($row['unidad'])),
            'marca'=>preg_replace('/\s+/', ' ',trim($row['marca'])),
            'garantia'=>preg_replace('/\s+/', ' ',trim($row['garantia'])),
            'cantidad_minima'=>preg_replace('/\s+/', ' ',trim($row['cantidad_minima'])),
            'industria'=>preg_replace('/\s+/', ' ',trim($row['industria'])),
            'precio_venta'=>preg_replace('/\s+/', ' ',trim($row['precio_venta'])),
            'status'=>preg_replace('/\s+/', ' ',trim($row['status'])),
            'category_id'=>$this->categories[$row['categoria']]
        ]);


    }
    public function batchSize(): int
    {
        return 4000;
    }

    public function chunkSize(): int
    {
        return 4000;
    }

    public function rules(): array
    {
        return [             // Above is alias for as it always validates in batches
            '*.nombre' =>[
                'distinct','required'
            ],
            '*.costo' =>[
                'numeric','required'
            ],
            '*.precio_venta' =>[
                'numeric','required'
            ]
            

        ];
    }

}
