<?php

namespace Database\Seeders;

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
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ComisionSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(SucursalSeeder::class);
        $this->call(SucursalUserSeeder::class);
        $this->call(CajaSeeder::class);
        $this->call(CarteraSeeder::class);
        $this->call(OrigenSeeder::class);
        $this->call(MotivoSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(ModelHasRolesSeeder::class);
        $this->call(RoleHasPermissionSeeder::class);
        $this->call(ProcedenciaSeeder::class);
        $this->call(TypeworkSeeder::class);
        $this->call(CatProdServiceSeeder::class);
        $this->call(SubCatProdServicesSeeder::class);
        $this->call(OrigenMotivoSeeder::class);
        $this->call(OrigenMotivoComisionSeeder::class);
        $this->call(ClientSeeder::class);


       /*  Category::factory(20)->create(); */
    }
}
