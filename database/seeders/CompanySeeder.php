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
            'name' => 'Soluciones informaticas Emanuel',
            'adress' => 'Av. America casi G.Rene Moreno',
            'phone' => '4408080',
            'nit_id' => '765645'
        ]);
    }
}
