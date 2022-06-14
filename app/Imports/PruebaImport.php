<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PruebaImport implements ToCollection,WithHeadingRow,WithBatchInserts,WithChunkReading
{
    private $categories;

    public function __construct()
    {
        $this->categories = Category::pluck('id', 'name');
        $this->products = Product::pluck('id', 'nombre');
       
       
    }
    /**
    * @param array $rows
    * @param Collection $rows
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {

            if ($row['categoria'] != 'No definido') {
                if (condition) {
                    # code...
                }
                $detail1 = $this->products[$row['nombre']];
                $detail= Product::find($detail1);
                $detail->category_id =$this->categories[$row['categoria']];
                $detail->save();
            }

           
        }
    }
    public function batchSize(): int
    {
        return 4000;
    }

    public function chunkSize(): int
    {
        return 4000;
    }

    

}
