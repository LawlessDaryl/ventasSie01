<?php

namespace Database\Seeders;

use App\Models\CompraDetalle;
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
      $this->call(CompanySeeder::class);
      $this->call(SucursalSeeder::class);
      $this->call(UserSeeder::class);
      $this->call(SucursalUserSeeder::class);
      
        // \App\Models\User::fctory(10)->create();
      /*  $this->call(DenominationSeeder::class);
        $this->call(CategorySeeder::class);*/

       // $this->call(UserSeeder::class);

       /* $this->call(CompanySeeder::class);
        $this->call(SucursalSeeder::class);
        $this->call(SucursalUserSeeder::class);
        $this->call(CajaSeeder::class);
        $this->call(CarteraSeeder::class);*/

        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(ModelHasRolesSeeder::class);
       // $this->call(DestinoSeeder::class);
        $this->call(RoleHasPermissionSeeder::class);
      //  $this->call(ProcedenciaSeeder::class);
/*
        $this->call(TypeworkSeeder::class);
        $this->call(CatProdServiceSeeder::class);
        $this->call(SubCatProdServicesSeeder::class);
        /* TIGO MONEY */
       /* $this->call(OrigenSeeder::class);
        $this->call(MotivoSeeder::class);
        $this->call(ComisionSeeder::class);
        $this->call(OrigenMotivoSeeder::class);
        $this->call(OrigenMotivoComisionSeeder::class);
        /* STREAMING */
       /* $this->call(ProveedorSeeder::class);
        $this->call(PlatformSeeder::class);
        $this->call(EmailSeeder::class);
        $this->call(AccountSeeder::class);
        $this->call(CuentaInversionSeeder::class);
        $this->call(ProfileSeeder::class);
        $this->call(AccountProfileSeeder::class);
        $this->call(UnidadSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductoDestinoSeeder::class);
        $this->call(LocationSeeder::class);
        
        $this->call(ProviderSeeder::class);
       
       
       // $this->call(CompraSeeder::class);
        //$this->call(CompraDetalleSeeder::class);
        
        
       /*  Category::factory(20)->create(); */
    }
}
