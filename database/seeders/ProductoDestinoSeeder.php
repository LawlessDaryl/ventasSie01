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
        ProductosDestino::create([
            'product-id'=> 1,
            'destino-id' => 1,
            'stock' => '50',
            'cantidad_minima' => 2,
            'alertas' => 2
        ]);
        ProductosDestino::create([
            'product-id'=> 1,
            'destino-id' => 2,
            'stock' => '5',
            'cantidad_minima' => 2,
            'alertas' => 2
        ]);




        ProductosDestino::create([
            'product-id'=> 2,
            'destino-id' => 1,
            'stock' => '10',
            'cantidad_minima' => 2,
            'alertas' => 2
        ]);
        ProductosDestino::create([
            'product-id'=> 2,
            'destino-id' => 2,
            'stock' => '3',
            'cantidad_minima' => 2,
            'alertas' => 2
        ]);





        ProductosDestino::create([
            'product-id'=> 3,
            'destino-id' => 1,
            'stock' => '1',
            'cantidad_minima' => 2,
            'alertas' => 2
        ]);
        ProductosDestino::create([
            'product-id'=> 3,
            'destino-id' => 2,
            'stock' => '3',
            'cantidad_minima' => 2,
            'alertas' => 2
        ]);








        ProductosDestino::create([
            'product-id'=> 4,
            'destino-id' => 1,
            'stock' => '1',
            'cantidad_minima' => 2,
            'alertas' => 2
        ]);
        ProductosDestino::create([
            'product-id'=> 4,
            'destino-id' => 2,
            'stock' => '2',
            'cantidad_minima' => 2,
            'alertas' => 2
        ]);





        ProductosDestino::create([
            'product-id'=> 5,
            'destino-id' => 1,
            'stock' => '50',
            'cantidad_minima' => 2,
            'alertas' => 2
        ]);
        ProductosDestino::create([
            'product-id'=> 5,
            'destino-id' => 3,
            'stock' => '10',
            'cantidad_minima' => 2,
            'alertas' => 2
        ]);





        ProductosDestino::create([
            'product-id'=> 6,
            'destino-id' => 1,
            'stock' => '20',
            'cantidad_minima' => 2,
            'alertas' => 2
        ]);
        ProductosDestino::create([
            'product-id'=> 6,
            'destino-id' => 2,
            'stock' => '4',
            'cantidad_minima' => 2,
            'alertas' => 2
        ]);






        ProductosDestino::create([
            'product-id'=> 7,
            'destino-id' => 1,
            'stock' => '50',
            'cantidad_minima' => 2,
            'alertas' => 2
        ]);
        ProductosDestino::create([
            'product-id'=> 7,
            'destino-id' => 2,
            'stock' => '10',
            'cantidad_minima' => 2,
            'alertas' => 2
        ]);





        ProductosDestino::create([
            'product-id'=> 8,
            'destino-id' => 1,
            'stock' => '100',
            'cantidad_minima' => 2,
            'alertas' => 2
        ]);
        ProductosDestino::create([
            'product-id'=> 8,
            'destino-id' => 2,
            'stock' => '2',
            'cantidad_minima' => 2,
            'alertas' => 2
        ]);





        ProductosDestino::create([
            'product-id'=> 9,
            'destino-id' => 1,
            'stock' => '5',
            'cantidad_minima' => 2,
            'alertas' => 2
        ]);
        ProductosDestino::create([
            'product-id'=> 9,
            'destino-id' => 2,
            'stock' => '1',
            'cantidad_minima' => 2,
            'alertas' => 2
        ]);
    }
}