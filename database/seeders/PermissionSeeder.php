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
        Permission::create([
            'name' => 'Asignar_Tecnico_Servicio',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'Boton_Entregar_Servicio',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'admin_estancia_almacen',
            'guard_name' =>'web'
        ]);

        //Ventas
        //Poder Ver Lista de las Ventas realizados por el usuario logeado
        Permission::create([
            'name' => 'VentasLista_Index',
            'guard_name' =>'web'
        ]);
        //Poder ver las Listas de las Ventas de todos los usuarios + anular venta
        Permission::create([
            'name' => 'VentasListaMasFiltros',
            'guard_name' =>'web'
        ]);
        //Poder recibir las notificaciones de movimiento de inventario de cualquier destino 
        //dentro de la propia sucursal a la tienda
        Permission::create([
            'name' => 'VentasNotificacionesMovInv',
            'guard_name' =>'web'
        ]);
        //Poder ver el movimiento Diario de Ventas (Sin poder filtrar por Sucursal y ver Utilidad)
        Permission::create([
            'name' => 'VentasMovDia_Index',
            'guard_name' =>'web'
        ]);
        //Poder ver el movimiento Diario de Ventas filtrando por sucursal y poder ver la utilidad
        Permission::create([
            'name' => 'VentasMovDiaSucursalUtilidad',
            'guard_name' =>'web'
        ]);
        //Poder filtrar y Anular una devolucion
        Permission::create([
            'name' => 'VentasDevolucionesFiltrar',
            'guard_name' =>'web'
        ]);





        Permission::create([
            'name' => 'Inventarios_Registros',
            'guard_name' =>'web'
        ]);
        Permission::create([
            'name' => 'Compras_Index',
            'guard_name' =>'web'
        ]);
        Permission::create([
            'name' => 'Almacen_Index',
            'guard_name' =>'web'
        ]);
        Permission::create([
            'name' => 'Transferencia_Index',
            'guard_name' =>'web'
        ]);
        Permission::create([
            'name' => 'Reportes_Inventarios_Export',
            'guard_name' =>'web'
        ]);
      
    }
}
