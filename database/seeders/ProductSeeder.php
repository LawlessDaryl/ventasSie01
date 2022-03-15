<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ID=1
        Product::create([
            'nombre' => 'Cable Usb C Huawei 0.5 Metros',
            'costo' => 40,
            'barcode' => '11',
            'garantia' => '2',
            'stock' => '10',
            'precio_venta' => 70,
            'image' => 'Cable_Usb_C_Huawei_0.5_Metros.png',
            'category_id' => 7,
        ]);
        //ID=2
        Product::create([
            'nombre' => 'Cargador Lapto',
            'costo' => 100,
            'barcode' => '22',
            'garantia' => '2',
            'stock' => '7',
            'precio_venta' => 150,
            'image' => 'Cargador_Lapto.png',
            'category_id' => 5,
        ]);
        //ID=3
        Product::create([
            'nombre' => 'Iphone 11',
            'costo' => 4000,
            'barcode' => '33',
            'garantia' => '2',
            'stock' => '5',
            'precio_venta' => 6500,
            'image' => 'Iphone_11.png',
            'category_id' => 8,
        ]);
        //ID=4
        Product::create([
            'nombre' => 'PC Gammer',
            'costo' => 5000,
            'barcode' => '44',
            'garantia' => '2',
            'stock' => '12',
            'precio_venta' => 7000,
            'image' => 'PC_Gammer.png',
            'category_id' => 3,
        ]);
        //ID=5
        Product::create([
            'nombre' => 'Vidrio Templado j5 Prime',
            'costo' => 7,
            'barcode' => '55',
            'garantia' => '2',
            'stock' => '15',
            'precio_venta' => 10,
            'image' => 'Vidrio_Templado_j5_Prime.png',
            'category_id' => 6,
        ]);
        //ID=6
        Product::create([
            'nombre' => 'Mouse Gammer',
            'costo' => 70,
            'barcode' => '66',
            'garantia' => '2',
            'stock' => '4',
            'precio_venta' => 100,
            'image' => 'Mouse_Gammer.png',
            'category_id' => 5,
        ]);
        //ID=7
        Product::create([
            'nombre' => 'Teclado Pc',
            'costo' => 60,
            'barcode' => '77',
            'garantia' => '2',
            'stock' => '20',
            'precio_venta' => 80,
            'image' => 'Teclado_Pc.png',
            'category_id' => 5,
        ]);
        //ID=8
        Product::create([
            'nombre' => 'SSD Kingston 240GB',
            'costo' => 270,
            'barcode' => '88',
            'garantia' => '2',
            'stock' => '30',
            'precio_venta' => 320,
            'image' => 'SSD_Kingston_240GB.png',
            'category_id' => 5,
        ]);
        //ID=9
        Product::create([
            'nombre' => 'Monitor LG 15 Pulgadas',
            'costo' => 1700,
            'barcode' => '99',
            'garantia' => '2',
            'stock' => '5',
            'precio_venta' => 2000,
            'image' => 'Monitor_LG_15_Pulgadas.png',
            'category_id' => 5,
        ]);
    }
}
