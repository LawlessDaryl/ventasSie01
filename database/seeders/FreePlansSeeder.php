<?php

namespace Database\Seeders;
use App\Models\FreePlans;

use Illuminate\Database\Seeder;

class FreePlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FreePlans::create([
            'nameplan' => 'Plan 1',
            'nameoffer' => '100 mas 10 diamantes',
            'cryptocurrencies' => 3000,
            'cost' => 8,
        ]);
        FreePlans::create([
            'nameplan' => 'Plan 2',
            'nameoffer' => '310 mas 31 diamantes',
            'cryptocurrencies' => 9000,
            'cost' => 22,
        ]);
        FreePlans::create([
            'nameplan' => 'Plan 3',
            'nameoffer' => '520 mas 52 diamantes',
            'cryptocurrencies' => 15000,
            'cost' => 35,
        ]);
        FreePlans::create([
            'nameplan' => 'Plan 4',
            'nameoffer' => '1050 mas 105 diamantes',
            'cryptocurrencies' => 30000,
            'cost' => 65,
        ]);
        FreePlans::create([
            'nameplan' => 'Plan 5',
            'nameoffer' => '2160 mas 216 diamantes',
            'cryptocurrencies' => 60000,
            'cost' => 130,
        ]);
        FreePlans::create([
            'nameplan' => 'Plan 6',
            'nameoffer' => '5580 mas 558 diamantes',
            'cryptocurrencies' => 150000,
            'cost' => 330,
        ]);
        FreePlans::create([
            'nameplan' => 'Plan 7',
            'nameoffer' => 'tarjeta semanal 450 diamantes 100 al instante mas 50 diamantes cada dia',
            'cryptocurrencies' => 59000,
            'cost' => 17,
        ]);
        FreePlans::create([
            'nameplan' => 'Plan 8',
            'nameoffer' => 'Tarjeta mensual 2600 diamantes 70 diamantes por dia DIA 1, 70 + 500 diamantes',
            'cryptocurrencies' => 28699,
            'cost' => 59,
        ]);
    }
}
