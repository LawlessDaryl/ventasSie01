<?php

namespace Database\Seeders;

use App\Models\OrigenMotivoComision;
use Illuminate\Database\Seeder;

class OrigenMotivoComisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($x = 1; $x < 14; $x++) {
            OrigenMotivoComision::create([
                'origen_motivo_id' => '1',
                'comision_id' => $x,
            ]);
        }
        for ($x = 1; $x < 14; $x++) {
            OrigenMotivoComision::create([
                'origen_motivo_id' => '2',
                'comision_id' => $x,
            ]);
        }
        
        for ($x = 1; $x < 14; $x++) {
            OrigenMotivoComision::create([
                'origen_motivo_id' => '4',
                'comision_id' => $x,
            ]);
        }
        OrigenMotivoComision::create([
            'origen_motivo_id' => '5',
            'comision_id' => 14,
        ]);
        for ($x = 1; $x < 14; $x++) {
            OrigenMotivoComision::create([
                'origen_motivo_id' => '6',
                'comision_id' => $x,
            ]);
        }
        for ($x = 17; $x < 30; $x++) {
            OrigenMotivoComision::create([
                'origen_motivo_id' => '6',
                'comision_id' => $x,
            ]);
        }
        OrigenMotivoComision::create([
            'origen_motivo_id' => '7',
            'comision_id' => '16',
        ]);

    }
}
