<?php

namespace Database\Seeders;

use App\Models\Category;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::fctory(10)->create();
        $this->call(DenominationSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(SucursalSeeder::class);
        $this->call(LocationSeeder::class);
      /*  $this->call(ProductSeeder::class);*/
        $this->call(UserSeeder::class);

       /*  Category::factory(20)->create(); */
    }
}
