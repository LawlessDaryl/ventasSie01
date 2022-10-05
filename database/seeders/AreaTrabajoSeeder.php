<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AreaTrabajo;

class AreaTrabajoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AreaTrabajo::create([
            //1
            'nameArea' => 'Area Administrativa',
            'descriptionArea' => 'Admin',
        ]);
        AreaTrabajo::create([
            //2
            'nameArea' => 'Area Tecnica',
            'descriptionArea' => 'Tec',
        ]);
        AreaTrabajo::create([
            //3
            'nameArea' => 'No Definido',
            'descriptionArea' => 'null',
        ]);
    }
}
