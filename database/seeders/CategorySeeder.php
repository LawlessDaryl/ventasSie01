<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ID = 1
        Category::create([
            'name' => 'Computadoras',
            'descripcion' => 'ninguna',
            'categoria_padre' => '0',
        ]);
        //ID = 2
        Category::create([
            'name' => 'Celulares',
            'descripcion' => 'ninguna',
            'categoria_padre' => '0',
        ]);
        //ID = 3
        Category::create([
            'name' => 'Pc',
            'descripcion' => 'ninguna',
            'categoria_padre' => '1',
        ]);
        //ID = 4
        Category::create([
            'name' => 'Cables',
            'descripcion' => 'ninguna',
            'categoria_padre' => '1',
        ]);
        //ID = 5
        Category::create([
            'name' => 'Articulos',
            'descripcion' => 'ninguna',
            'categoria_padre' => '1',
        ]);

        //ID = 6
        Category::create([
            'name' => 'Pantallas',
            'descripcion' => 'ninguna',
            'categoria_padre' => '2',
        ]);
        //ID = 7
        Category::create([
            'name' => 'Cables',
            'descripcion' => 'ninguna',
            'categoria_padre' => '2',
        ]);
        //ID = 8
        Category::create([
            'name' => 'Dispositivos',
            'descripcion' => 'ninguna',
            'categoria_padre' => '2',
        ]);


    }
}
