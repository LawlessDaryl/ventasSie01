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
        /* ADMINISTRACION */
        Permission::create([    /* INGRESAR A ROLES */
            'name' => 'Roles_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A PERMISOS */
            'name' => 'Permission_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A ASIGNAR PERMISO */
            'name' => 'Asignar_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A USUARIOS CRUD */
            'name' => 'Usuarios_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A CLIENTE CRUD */
            'name' => 'Cliente_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A PROCEDENCIA CRUD */
            'name' => 'Procedencia_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A EMPRESA CRUD */
            'name' => 'Empresa_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A SUCURSAL CRUD */
            'name' => 'Sucursal_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A CAJA CRUD */
            'name' => 'Caja_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A CARTERA CRUD */
            'name' => 'Cartera_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A CORTE DE CAJA */
            'name' => 'Corte_Caja_Index',
            'guard_name' => 'web'
        ]);        


        /* TIGO MONEY */
        Permission::create([    /* INGRESAR A ORIGEN CRUD */
            'name' => 'Origen_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A MOTIVO CRUD */
            'name' => 'Motivo_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A COMISION CRUD */
            'name' => 'Comision_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A ORIGEN MOTIVO */
            'name' => 'Origen_Mot_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A ORIGEN MOTIVO COMISION */
            'name' => 'Origen_Mot_Com_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A LA TRANSACCION */
            'name' => 'Tigo_Money_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A LOS ARQUEOS */
            'name' => 'Arqueos_Tigo_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A REPORTES TIGO MONEY */
            'name' => 'Reportes_Tigo_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A REPORTE GANANCIAS TIGO MONEY */
            'name' => 'Rep_Gan_Tigo_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* PERMITIR SACAR PDF REPORTE DE TIGO MONEY*/
            'name' => 'Report_Tigo_Export',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* PERMITIR SACAR PDF REPORTE DE LAS GANANCIAS TIGO MONEY */
            'name' => 'Report_Ganancia_Tigo_Export',
            'guard_name' => 'web'
        ]);


        /* STREAMING */
        Permission::create([    /* INGRESAR A PLATAFORMA CRUD */
            'name' => 'Plataforma_Index',   
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A PROVEEDOR CRUD */
            'name' => 'Proveedor_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A CORREOS CRUD */
            'name' => 'Correos_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A CUENTAS  */
            'name' => 'Cuentas_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A PERFILES  */
            'name' => 'Perfiles_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A PLANES  */
            'name' => 'Planes_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A ARQUEOS  */
            'name' => 'Arqueos_Streaming_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A REPORTES  */
            'name' => 'Reportes_Streaming_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* PERMITIR SACAR PDF REPORTE DE STREAMING  */
            'name' => 'Reportes_Streaming_Export',
            'guard_name' => 'web'
        ]);


        /* SERVICIOS */
        Permission::create([    /* INGRESAR A CATEGORIA PRODUCTO SERVICIO CRUD */
            'name' => 'Cat_Prod_Service_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A SUB CATEGORIA PRODUCTO SERVICIO CRUD */
            'name' => 'SubCat_Prod_Service_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A TIPO DE TRABAJO CRUD */
            'name' => 'Type_Work_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A SERVICIO */
            'name' => 'Service_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A ORDEN DE SERVICIO */
            'name' => 'Orden_Servicio_Index',
            'guard_name' => 'web'
        ]);        
        Permission::create([    /* PERMITIR VER EL INICIO CON LOS SERVICIOS */
            'name' => 'Inicio_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* PERMITE IMPRIMIR LA ORDEN DE SERVICIO */
            'name' => 'Imprimir_Orden_Servicio_Index',
            'guard_name' => 'web'
        ]); 
        Permission::create([    /* INGRESAR A REPORTES DE SERVICIO */
            'name' => 'Reporte_Servicios_Index',
            'guard_name' => 'web'
        ]); 
        Permission::create([    /* PERMITE SACAR PDF DE REPORTES DE SERVICIO */
            'name' => 'Reporte_Servicios_Export',
            'guard_name' => 'web'
        ]); 
        Permission::create([    /* PERMITIR ASIGNAR UN TECNICO AL SERVICIO */
            'name' => 'Asignar_Tecnico_Servicio',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* PERMITIR ENTREGAR EL SERVICIO */
            'name' => 'Boton_Entregar_Servicio',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* PERMITIR VER BOTONES MODIFICAR ANULAR Y ELIMINAR EL SERVICIO */
            'name' => 'Ver_Modificar_Eliminar_Servicio',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* PERMITIR ANULAR EL SERVICIO */
            'name' => 'Anular_Servicio',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* PERMITIR ELIMINAR EL SERVICIO */
            'name' => 'Eliminar_Servicio',
            'guard_name' => 'web'
        ]);


        
        /* VENTAS */
        Permission::create([    /* INGRESAR A CATEGORIA CRUD */
            'name' => 'Category_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A PRODUCTOS CRUD */
            'name' => 'Product_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A COINS CRUD */
            'name' => 'Coins_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A VENTAS */
            'name' => 'Sales_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A ARQUEOS VENTAS */
            'name' => 'Cashout_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* INGRESAR A REPORTES VENTAS */
            'name' => 'Reportes_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* PERMITIR SACAR PDF REPORTE DE VENTAS */
            'name' => 'Report_Sales_Export',
            'guard_name' => 'web'
        ]);
        
        /* SIDEBAR */
        Permission::create([    /* PERMITIR VER TIGO MONEY EN EL SIDEBAR */
            'name' => 'Ver_TigoMoney_SideBar',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* PERMITIR VER STREAMING EN EL SIDEBAR */
            'name' => 'Ver_Streaming_SideBar',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* PERMITIR VER SERVICIOS EN EL SIDEBAR */
            'name' => 'Ver_Servicios_SideBar',
            'guard_name' => 'web'
        ]);
        
        
    }
}
