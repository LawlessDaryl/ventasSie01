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
            'costo' => 45,
            'caracteristicas'=>'Nuevo',
            'codigo' => '251214233',
            'lote'=>'2102',
            'unidad'=>'pieza',
            'marca'=>'no definido',
            'garantia' => '2',
            'cantidad_minima' => '10',
            'industria'=>'China',
            'precio_venta' => 60,
            'image' => 'Cable_Usb_C_Huawei_0.5_Metros.png',
            'category_id' => 7,
        ]);
        //ID=2
        Product::create([
            'nombre' => 'Cargador Lapto',
            'costo' => 148,
            'caracteristicas'=>'Usado',
            'codigo' => '251214235',
            'lote'=>'2122',
            'unidad'=>'pieza',
            'marca'=>'no definido',
            'garantia' => '2',
            'cantidad_minima' => '10',
            'industria'=>'China',
            'precio_venta' => 320,
            'image' => 'Cargador_Lapto.png',
            'category_id' => 5,
        ]);
        //ID=3
        Product::create([
            'nombre' => 'Iphone 11',
            'costo' => 240,
            'caracteristicas'=>'Usado',
            'codigo' => '251214239',
            'lote'=>'2182',
            'unidad'=>'pieza',
            'marca'=>'no definido',
            'garantia' => '2',
            'cantidad_minima' => '10',
            'industria'=>'China',
            'precio_venta' => 500,
            'image' => 'Iphone_11.png',
            'category_id' => 8,
        ]);
        //ID=4
        Product::create([
            'nombre' => 'PC Gammer',
            'costo' => 136,
            'caracteristicas'=>'Usado',
            'codigo' => '20221222',
            'lote'=>'21992',
            'unidad'=>'pieza',
            'marca'=>'no definido',
            'garantia' => '180',
            'cantidad_minima' => '10',
            'industria'=>'China',
            'precio_venta' => 200,
            'image' => 'PC_Gammer.png',
            'category_id' => 3,
        ]);
        //ID=5
        Product::create([
            'nombre' => 'Vidrio Templado j5 Prime',
            'costo' => 320,
            'caracteristicas'=>'Usado',
            'codigo' => '251214533',
            'lote'=>'24402',
            'unidad'=>'pieza',
            'marca'=>'no definido',
            'garantia' => '2',
            'cantidad_minima' => '10',
            'industria'=>'China',
            'precio_venta' =>800,
            'image' => 'Vidrio_Templado_j5_Prime.png',
            'category_id' => 6,
        ]);
        //ID=6
        Product::create([
            'nombre' => 'Mouse Gammer',
            'costo' => 53,
            'caracteristicas'=>'Nuevo',
            'codigo' => '261214233',
            'lote'=>'3102',
            'unidad'=>'pieza',
            'marca'=>'no definido',
            'garantia' => '2',
            'cantidad_minima' => '10',
            'industria'=>'China',
            'precio_venta' =>60,
            'image' => 'Mouse_Gammer.png',
            'category_id' => 5,
        ]);
        //ID=7
        Product::create([
            'nombre' => 'Teclado Pc',
            'costo' => 120,
            'caracteristicas'=>'Nuevo',
            'codigo' => '211214233',
            'lote'=>'21552',
            'unidad'=>'pieza',
            'marca'=>'no definido',
            'garantia' => '2',
            'cantidad_minima' => '10',
            'industria'=>'China',
            'precio_venta' =>240,
            'image' => 'Teclado_Pc.png',
            'category_id' => 5,
        ]);
        //ID=8
        Product::create([
            'nombre' => 'SSD Kingston 240GB',
            'costo' => 350,
            'caracteristicas'=>'Usado',
            'codigo' => '253214233',
            'lote'=>'20002',
            'unidad'=>'pieza',
            'marca'=>'no definido',
            'garantia' => '2',
            'cantidad_minima' => '10',
            'industria'=>'China',
            'precio_venta' => 368,
            'image' => 'SSD_Kingston_240GB.png',
            'category_id' => 5
        ]);
        //ID=9
        Product::create([
            'nombre' => 'Monitor LG 15 Pulgadas',
            'costo' => 130,
            'caracteristicas'=>'Nuevo',
            'codigo' => '256214233',
            'lote'=>'45102',
            'unidad'=>'pieza',
            'marca'=>'no definido',
            'garantia' => '2',
            'cantidad_minima' => '10',
            'industria'=>'China',
            'precio_venta' => 180,
            'image' => 'Monitor_LG_15_Pulgadas.png',
            'category_id' => 5,
        ]);
    }
}
