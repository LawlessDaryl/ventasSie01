<?php

namespace Database\Seeders;

use App\Models\DetalleEntradaProductos;
use App\Models\IngresoProductos;
use App\Models\Lote;
use Illuminate\Database\Seeder;
use App\Models\ProductosDestino;
class ProductoDestinoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Agregando Productos a la Primera Sucursal


        for ($i=1; $i < 7 ; $i++) { 

            ProductosDestino::create([
                'product_id'=> $i,
                'destino_id' => 2,
                'stock' => '50',
            ]);
        }

        $pd=ProductosDestino::all();

        foreach ($pd as $data) {

            $rs=IngresoProductos::create([
                'destino'=>$data->destino_id,
                'user_id'=>1,
                'concepto'=>'INICIAL',
                'observacion'=> 'Inventario inicial'
               ]);

               $lot= Lote::create([
                'existencia'=>$data->stock,
                'costo'=>10,
                'status'=>'Activo',
                'product_id'=>$data->product_id
            ]);

               DetalleEntradaProductos::create([
                    'product_id'=>$data->product_id,
                    'cantidad'=>$data->stock,
                    'costo'=>10,
                    'id_entrada'=>$rs->id,
                    'lote_id'=>$lot->id
               ]);

        }


        // ProductosDestino::create([
        //     'product_id'=> 1,
        //     'destino_id' => 1,
        //     'stock' => '50',
        // ]);

        

        // ProductosDestino::create([
        //     'product_id'=> 1,
        //     'destino_id' => 2,
        //     'stock' => '5',
        // ]);


        // ProductosDestino::create([
        //     'product_id'=> 2,
        //     'destino_id' => 1,
        //     'stock' => '10',
        // ]);
        // ProductosDestino::create([
        //     'product_id'=> 2,
        //     'destino_id' => 2,
        //     'stock' => '3',
        // ]);


        // ProductosDestino::create([
        //     'product_id'=> 3,
        //     'destino_id' => 1,
        //     'stock' => '1',
            
        
        // ]);
        // ProductosDestino::create([
        //     'product_id'=> 3,
        //     'destino_id' => 2,
        //     'stock' => '3',
        // ]);


        // ProductosDestino::create([
        //     'product_id'=> 4,
        //     'destino_id' => 1,
        //     'stock' => '70',
        
        // ]);
        // ProductosDestino::create([
        //     'product_id'=> 4,
        //     'destino_id' => 2,
        //     'stock' => '1',
        // ]);


        // ProductosDestino::create([
        //     'product_id'=> 5,
        //     'destino_id' => 1,
        //     'stock' => '50',
        
        // ]);


        // ProductosDestino::create([
        //     'product_id'=> 6,
        //     'destino_id' => 1,
        //     'stock' => '20',
        // ]);
        // ProductosDestino::create([
        //     'product_id'=> 6,
        //     'destino_id' => 2,
        //     'stock' => '4',
        // ]);


        // ProductosDestino::create([
        //     'product_id'=> 7,
        //     'destino_id' => 1,
        //     'stock' => '50',
        // ]);
        // ProductosDestino::create([
        //     'product_id'=> 7,
        //     'destino_id' => 2,
        //     'stock' => '10',
        // ]);


        // ProductosDestino::create([
        //     'product_id'=> 8,
        //     'destino_id' => 1,
        //     'stock' => '100',
        // ]);
        // ProductosDestino::create([
        //     'product_id'=> 8,
        //     'destino_id' => 2,
        //     'stock' => '2',
        // ]);


        // ProductosDestino::create([
        //     'product_id'=> 9,
        //     'destino_id' => 1,
        //     'stock' => '5',
        // ]);
        // ProductosDestino::create([
        //     'product_id'=> 9,
        //     'destino_id' => 4,
        //     'stock' => '1',
        // ]);

        // //Agregando Productos a la Segunda Sucursal
      
        // ProductosDestino::create([
        //     'product_id'=> 4,
        //     'destino_id' => 4,
        //     'stock' => '13',
        // ]);
        // ProductosDestino::create([
        //     'product_id'=> 4,
        //     'destino_id' => 5,
        //     'stock' => '50',
        // ]);

    }
}
