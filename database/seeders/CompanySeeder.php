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
            'name' => 'Nombre Compañia',
            'adress' => 'Av. XXXXXXX',
            'phone' => '7777777',
            'nit_id' => '0'
        ]);
    }
}
