<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\DetalleEntradaProductos;
use App\Models\IngresoProductos;
use App\Models\Lote;
use App\Models\Product;
use App\Models\ProductosDestino;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StockImport implements ToModel,WithHeadingRow,WithBatchInserts,WithChunkReading,WithValidation
{
    private $products,$ingreso,$destino,$concepto,$observacion;
    public function __construct($destino,$concepto,$observacion)
    {
        $this->products = Product::pluck('id', 'nombre');
        $this->ingreso= IngresoProductos::create([
            'destino'=>$destino,
            'user_id'=>Auth()->user()->id,
            'concepto'=>$concepto,
            'observacion'=>$observacion
           ]);
        $this->destino=$destino;
        $this->concepto=$concepto;
        $this->observacion=$observacion;

       
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $lot= Lote::create([
            'existencia'=>$row['stock'],
            'costo'=>$row['costo'],
            'status'=>'Activo',
            'product_id'=>$this->products[$row['nombre']]
        ]);

           DetalleEntradaProductos::create([
                'product_id'=>$this->products[$row['nombre']],
                'cantidad'=>$row['stock'],
                'costo'=>$row['costo'],
                'id_entrada'=>$this->ingreso->id,
                'lote_id'=>$lot->id
           ]);

         $q=ProductosDestino::where('product_id',$this->products[$row['nombre']])
           ->where('destino_id',$this->destino)->value('stock');

           ProductosDestino::updateOrCreate(['product_id' => $this->products[$row['nombre']], 'destino_id'=>$this->destino],['stock'=>$q+$row['stock']]);

      
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
                'required'
            ],
            '*.stock' =>[
                'required'
            ],
            '*.costo' =>[
                'required'
            ]

            

        ];
    }

}
