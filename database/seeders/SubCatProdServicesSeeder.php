<?php

namespace Database\Seeders;

use App\Models\SubCatProdService;
use Illuminate\Database\Seeder;

class SubCatProdServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubCatProdService::create([
            'name' => 'Lg',
            'price' => '30',
            'status' => 'Active',
            'cat_prod_service_id' => '1',
        ]);
        SubCatProdService::create([
            'name' => 'Apple',
            'price' => '30',
            'status' => 'Active',
            'cat_prod_service_id' => '2',
        ]);
        SubCatProdService::create([
            'name' => 'Samsung',
            'price' => '30',
            'status' => 'Active',
            'cat_prod_service_id' => '3',
        ]);
        SubCatProdService::create([
            'name' => 'Huawei',
            'price' => '30',
            'status' => 'Active',
            'cat_prod_service_id' => '3',
        ]);
    }
}
