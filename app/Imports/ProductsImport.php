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
            $auxi= $this->categories->where('name',strtoupper($row['categoria']));
            if (count($auxi) == 0) {
               // dd("no esta nulo");
                $fg=Category::create([
                    'name' => strtoupper($row['categoria']),
                    'descripcion'=>'ninguna'
                ]);
                
                $product->category_id = $fg->id;
            }
            else{
                
                //dd($auxi);
                $product->category_id = $this->categories[strtoupper($row['categoria'])];
            }
        }

        if ($row['subcategoria'] == null) 
        {
            
        }
        else
        {
            $auxi= $this->categories->where('name',strtoupper($row['subcategoria']));
            if (count($auxi) == 0) {
               // dd("no esta nulo");
                $fg=Category::create([
                    'name' => strtoupper($row['categoria']),
                    'descripcion'=>'ninguna',
                    'cat_padre'=>
                ]);
                
                $product->category_id = $fg->id;
            }
            else{
                
                //dd($auxi);
                $product->category_id = $this->categories[strtoupper($row['categoria'])];
            }
        }





        'categoria_padre'=>$this->subcategories[$row['categoria_p']],




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
