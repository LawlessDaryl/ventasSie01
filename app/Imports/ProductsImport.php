<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel,WithHeadingRow,WithBatchInserts,WithChunkReading,WithValidation
{
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
            'category_id'=>$row['category_id']
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
        return [
            'email' => Rule::in(['patrick@maatwebsite.nl']),

             // Above is alias for as it always validates in batches
             '*.email' => Rule::in(['patrick@maatwebsite.nl']),
        ];
    }

}
