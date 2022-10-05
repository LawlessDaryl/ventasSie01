<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Anticipo;

class AnticipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Anticipo::create([
            //1
            'empleado_id' => 8693177,
            'anticipo' => '500',
            'motivo' => 'Emergencia',
            //'fecha' => '2022-09-28',
        ]);
    }
}
