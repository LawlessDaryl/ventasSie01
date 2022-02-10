<?php

namespace Database\Seeders;

use App\Models\CatProdService;
use Illuminate\Database\Seeder;

class CatProdServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CatProdService::create([
            'nombre' => 'Tv',
            'estado' => 'Activo'
        ]);
        CatProdService::create([
            'nombre' => 'Portatil',
            'estado' => 'Activo'
        ]);
        CatProdService::create([
            'nombre' => 'Celular',
            'estado' => 'Activo'
        ]);
    }
}
