<?php

namespace Database\Seeders;

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
        ProductosDestino::create([
            'product_id'=> 1,
            'location_id' => 1,
            'stock' => '50',
        ]);
        ProductosDestino::create([
            'product_id'=> 1,
            'location_id' => 2,
            'stock' => '5',
        ]);


        ProductosDestino::create([
            'product_id'=> 2,
            'location_id' => 1,
            'stock' => '10',
        ]);
        ProductosDestino::create([
            'product_id'=> 2,
            'location_id' => 2,
            'stock' => '3',
        ]);


        ProductosDestino::create([
            'product_id'=> 3,
            'location_id' => 1,
            'stock' => '10',
        ]);
        ProductosDestino::create([
            'product_id'=> 3,
            'location_id' => 2,
            'stock' => '3',
        ]);


        ProductosDestino::create([
            'product_id'=> 4,
            'location_id' => 1,
            'stock' => '2',
        ]);
        ProductosDestino::create([
            'product_id'=> 4,
            'location_id' => 2,
            'stock' => '2',
        ]);


        ProductosDestino::create([
            'product_id'=> 5,
            'location_id' => 1,
            'stock' => '100',
        ]);
        ProductosDestino::create([
            'product_id'=> 5,
            'location_id' => 2,
            'stock' => '25',
        ]);


        ProductosDestino::create([
            'product_id'=> 6,
            'location_id' => 1,
            'stock' => '20',
        ]);
        ProductosDestino::create([
            'product_id'=> 6,
            'location_id' => 2,
            'stock' => '4',
        ]);


        ProductosDestino::create([
            'product_id'=> 7,
            'location_id' => 1,
            'stock' => '50',
        ]);
        ProductosDestino::create([
            'product_id'=> 7,
            'location_id' => 2,
            'stock' => '10',
        ]);


        ProductosDestino::create([
            'product_id'=> 8,
            'location_id' => 1,
            'stock' => '100',
        ]);
        ProductosDestino::create([
            'product_id'=> 8,
            'location_id' => 2,
            'stock' => '2',
        ]);


        ProductosDestino::create([
            'product_id'=> 9,
            'location_id' => 1,
            'stock' => '5',
        ]);
        ProductosDestino::create([
            'product_id'=> 9,
            'location_id' => 2,
            'stock' => '3',
        ]);






        //Agregando Productos a la Segunda Sucursal
        ProductosDestino::create([
            'product_id'=> 1,
            'location_id' => 3,
            'stock' => '9',
        ]);
        ProductosDestino::create([
            'product_id'=> 2,
            'location_id' => 3,
            'stock' => '1',
        ]);
        ProductosDestino::create([
            'product_id'=> 3,
            'location_id' => 3,
            'stock' => '2',
        ]);
        ProductosDestino::create([
            'product_id'=> 4,
            'location_id' => 3,
            'stock' => '11',
        ]);

    }
}