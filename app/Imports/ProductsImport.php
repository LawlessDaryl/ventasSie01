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
        //dd($this->categories);
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'nombre'=>$row['nombre'],
            'costo'=>$row['costo'],
            'caracteristicas'=>$row['caracteristicas'],
            'codigo'=>$row['codigo'],
            'lote'=>$row['lote'],
            'unidad'=>$row['unidad'],
            'marca'=>$row['marca'],
            'garantia'=>$row['garantia'],
            'cantidad_minima'=>$row['cantidad_minima'],
            'industria'=>$row['industria'],
            'precio_venta'=>$row['precio_venta'],
            'status'=>$row['status'],
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
