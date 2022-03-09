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
        Category::create([
            'name' => 'Dispositivos Moviles',
            'descripcion' => 'ninguna',
            'categoria_padre' => '0',
            
          
        ]);
        Category::create([
            'name' => 'Celulares',
            'descripcion' => 'ninguna',
            'categoria_padre' => '1',
            
          
        ]);
    }
}
