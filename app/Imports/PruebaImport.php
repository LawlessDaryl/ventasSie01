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
    public $arr=[];

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
      /*  foreach ($collection as $row) {

            if ($row['categoria'] != 'No definido') {

                $mm=Product::where('nombre',$row['nombre'])->value('nombre');
                if ($mm != null) {
                   
                    $detail1 = $this->products[$row['nombre']];
                    $detail= Product::find($detail1);
                    $detail->category_id =$this->categories[$row['categoria']];
                    $detail->save();
                }
         
            }

           
        }*/
      /*  if ($row['categoria'] != 'No definido') {

            $mm=Product::where('nombre',$row['nombre'])->pluck('nombre');
            if ($mm == null) {
                array_push($this->arr, $row['nombre'] );
            }

          /*  $detail1 = $this->products[$row['nombre']];
            
            if ($detail1 != null) 
            {
                $detail= Product::find($detail1);
                $detail->category_id =$this->categories[$row['categoria']];
                $detail->save();
            }
            
            
           
        }*/

          foreach ($collection as $row) {

                $mm=Product::where('nombre',$row['nombre'])->value('nombre');
                if ($mm != null) {
                   
                    $detail1 = $this->products[$row['nombre']];
                    $detail= Product::find($detail1);
                    $detail->industria= $this->categories[$row['industria']];
                    $detail->unidad= $this->categories[$row['unidad']];
                    $detail->marca= $this->categories[$row['marca']];
                    $detail->precio_venta= $this->categories[$row['precio venta']];
                    $detail->caracteristicas= $this->categories[$row['caracteristica']];
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
