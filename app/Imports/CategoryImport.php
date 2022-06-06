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

class CategoryImport implements ToModel,WithHeadingRow,WithBatchInserts,WithChunkReading,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Category([
            'name'=>$row['nombre'],
            'descripcion'=>$row['descripcion'],
            
        ]);
    }
    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        return [             // Above is alias for as it always validates in batches
            '*.nombre' =>[
                'distinct','required'
            ],
            '*.descripcion' =>[
                'required'
            ]
            

        ];
    }

}
