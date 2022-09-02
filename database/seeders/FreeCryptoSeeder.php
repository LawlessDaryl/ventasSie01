<?php

namespace Database\Seeders;

use App\Models\FreeCrypto;
use Illuminate\Database\Seeder;

class FreeCryptoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FreeCrypto::create([ /* 1 */
            'cantidad' => '200000',
        ]);
    }
}
