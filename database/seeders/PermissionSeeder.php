<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'Category_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Product_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Coins_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Sales_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Roles_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Permission_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Asignar_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Empresa_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Sucursal_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Caja_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Cartera_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Corte_Caja_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Plataforma_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Proveedor_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Usuarios_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Cashout_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Reportes_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Comision_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Motivo_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Origen_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Origen_Mot_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Origen_Mot_Com_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Tigo_Money_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Reportes_Tigo_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Rep_Gan_Tigo_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Arqueos_Tigo_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Cliente_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Cat_Prod_Service_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'SubCat_Prod_Service_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Orden_Servicio_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Service_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Report_Sales_Export',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Report_Tigo_Export',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Report_Ganancia_Tigo_Export',
            'guard_name' => 'web'
        ]);
    }
}
