<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Cable Usb C Huawei 0.5 Metros',
            'cost' => 40,
            'price' => 70,
            'barcode' => '11',
            'stock' => 20,
            'alerts' => 2,
            'category_id' => 1,
            'image' => 'Cable_Usb _C_Huawei_0.5_Metros.png',
        ]);
        Product::create([
            'name' => 'Cargador Lapto',
            'cost' => 100,
            'price' => 150,
            'barcode' => '22',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 2,
            'image' => 'Cargador_Lapto.png',
        ]);
        Product::create([
            'name' => 'Iphone 11',
            'cost' => 900,
            'price' => 1400,
            'barcode' => '33',
            'stock' => 7,
            'alerts' => 2,
            'category_id' => '3',
            'image' => 'Iphone_11.png',
        ]);
        Product::create([
            'name' => 'PC Gammer',
            'cost' => 790,
            'price' => 1350,
            'barcode' => '44',
            'stock' => 5,
            'alerts' => 1,
            'category_id' => 4,
            'image' => 'PC_Gammer.png',
        ]);
        Product::create([
            'name' => 'Vidrio Templado j5 Prime',
            'cost' => 5,
            'price' => 10,
            'barcode' => '55',
            'stock' => 9,
            'alerts' => 2,
            'category_id' => 1,
            'image' => 'Vidrio_Templado_j5_Prime.png',
        ]);
        Product::create([
            'name' => 'Mouse Gammer',
            'cost' => 35,
            'price' => 50,
            'barcode' => '66',
            'stock' => 20,
            'alerts' => 2,
            'category_id' => 2,
            'image' => 'Mouse_Gammer.png',
        ]);
        Product::create([
            'name' => 'Teclado Pc',
            'cost' => 50,
            'price' => 80,
            'barcode' => '77',
            'stock' => 50,
            'alerts' => 5,
            'category_id' => 2,
            'image' => 'Teclado_Pc.png',
        ]);
        Product::create([
            'name' => 'SSD Kingston 240GB',
            'cost' => 200,
            'price' => 300,
            'barcode' => '88',
            'stock' => 10,
            'alerts' => 2,
            'category_id' => 2,
            'image' => 'SSD_Kingston_240GB.png',
        ]);
        Product::create([
            'name' => 'Monitor LG 15 Pulgadas',
            'cost' => 120,
            'price' => 150,
            'barcode' => '99',
            'stock' => 7,
            'alerts' => 2,
            'category_id' => 2,
            'image' => 'Monitor_LG_15_Pulgadas.png',
        ]);
    }
}
