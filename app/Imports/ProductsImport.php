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
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ProductsImport implements ToModel,WithHeadingRow,WithBatchInserts,WithChunkReading,WithValidation,WithCalculatedFormulas
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
      
        $product = new Product();
        $product->nombre = preg_replace('/\s+/', ' ',trim($row['nombre']));
        $product->costo = preg_replace('/\s+/', ' ',trim($row['costo']));
        $product->caracteristicas = preg_replace('/\s+/', ' ',trim($row['caracteristicas']));
        $product->codigo = preg_replace('/\s+/', ' ',trim($row['codigo']));
        $product->lote = preg_replace('/\s+/', ' ',trim($row['lote']));
        $product->unidad = preg_replace('/\s+/', ' ',trim($row['unidad']));
        $product->marca = preg_replace('/\s+/', ' ',trim($row['marca']));
        $product->garantia = preg_replace('/\s+/', ' ',trim($row['garantia']));
        $product->cantidad_minima = preg_replace('/\s+/', ' ',trim($row['cantidad_minima']));
        $product->industria = preg_replace('/\s+/', ' ',trim($row['industria']));
        $product->precio_venta = preg_replace('/\s+/', ' ',trim($row['precio_venta']));
        $product->status = preg_replace('/\s+/', ' ',trim($row['status']));
        if ($row['categoria'] == null) 
        {
            $product->category_id =$this->categories['No definido'];
        }
        else
        {
            $product->category_id = $this->categories[$row['categoria']];
        }
        $product->save();

      




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
                'distinct','required','unique:products'
            ],
            '*.costo' =>[
                'numeric','required'
            ],
            '*.precio_venta' =>[
                'numeric','required'
            ]
            
        ];
    }

    public function customValidationMessages()
{
    return [
        'nombre.unique' => 'El nombre del producto ya existe, revise su archivo por favor  :attribute',
    ];
}

}
