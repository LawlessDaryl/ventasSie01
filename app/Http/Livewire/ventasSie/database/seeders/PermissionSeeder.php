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
        Permission::create([    /* PERMITIR FILTRAR POR SUCURSAL LOS REPORTES DE SERVICIOS */
            'name' => 'Filtrar_sucursal_Reporte_Servicio',
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

        /* TIGO MONEY */
        Permission::create([    /* PERMITIR VER LOS REPORTES DE JORNADA DE TIGO MONEY */
            'name' => 'Jornada_Tigo_Index',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* PERMITIR MODIFICAR LA SUCURSAL Y LA CAJA EN REPORTE JORNADA */
            'name' => 'Modificar_Sucursal_Caja_Jornada_Tigo_Money',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* PERMITIR VER LA GANANCIA DE LAS TRANSACCIONES DE TIGO MONEY */
            'name' => 'Ver_Ganancia_Tigo_Money',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* PERMITIR GENERAR INGRESO Y EGRESO */
            'name' => 'Ver_Generar_Ingreso_Egreso_Boton',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* PERMITIR ANULAR TRANSACCION TIGO MONEY */
            'name' => 'Anular_trans_tigomoney_Boton',
            'guard_name' => 'web'
        ]);

        /* SERVICIOS */
        Permission::create([    /* PERMITIR RECEPCIONAR SERVICIOS */
            'name' => 'Recepcionar_Servicio',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* PERMITIR VER COSTOS EN REPORTES ENTREGADOS SERVICIOS */
            'name' => 'Ver_Costo_Reportes_Entregados',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* PERMITIR MODIFICAR LOS SERVICIOS ENTREGADOS */
            'name' => 'Modificar_Detalle_Serv_Entregado',
            'guard_name' => 'web'
        ]);
        Permission::create([    /* PERMITIR MODIFICAR LOS SERVICIOS */
            'name' => 'Modificar_Detalle_Serv',
            'guard_name' => 'web'
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
