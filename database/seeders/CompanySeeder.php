<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name' => 'Soluciones Informaticas Emanuel',
            'adress' => 'America 453',
            'phone' => '4545562',
            'nit_id' => '95656555',
          
        ]);
    }
}

