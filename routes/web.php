<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\ExportServicioEntregPdfController;
use App\Http\Controllers\ExportSaleController;
use App\Http\Controllers\ExportServicioPdfController;
use App\Http\Controllers\ExportStreamingPdfController;
use App\Http\Controllers\ExportTigoPdfController;
use App\Http\Controllers\ExportMovimientoController;
use App\Http\Controllers\ImprimirController;
use App\Http\Controllers\ExportComprasController;
use App\Http\Controllers\ExportIngresosController;
use App\Http\Controllers\ExportSaleMovDiaController;
use App\Http\Controllers\ExportTransferenciaController;
use App\Http\Controllers\ExportMovDiaGenController;
use App\Http\Controllers\ExportMovDiaResController;
use App\Http\Controllers\ServicioInformeTecnicoController;
use App\Http\Livewire\ArqueosStreamingController;
use App\Http\Livewire\ArqueosTigoController;
use App\Http\Livewire\AsignarController;
use App\Http\Livewire\CajasController;
use App\Http\Livewire\CarteraController;
use App\Http\Livewire\CarteraMovCategoriaController;
use App\Http\Livewire\CashoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\CategoriesController;
use App\Http\Livewire\ClienteController;
use App\Http\Livewire\ProductsController;
use App\Http\Livewire\CoinsController;
use App\Http\Livewire\ComisionesController;
use App\Http\Livewire\MotivoController;
use App\Http\Livewire\OrigenController;
use App\Http\Livewire\OrigenMotivoComisionController;
use App\Http\Livewire\OrigenMotivoController;
use App\Http\Livewire\PosController;
use App\Http\Livewire\RolesController;
use App\Http\Livewire\PermisosController;
use App\Http\Livewire\ReportesTigoController;
use App\Http\Livewire\IngresoEgresoController;
use App\Http\Livewire\ReporteMovimientoResumenController;
use App\Http\Livewire\ReportsController;
use App\Http\Livewire\TransaccionController;
use App\Http\Livewire\UsersController;
use App\Http\Livewire\CompaniesController;
use App\Http\Livewire\CorteCajaController;
use App\Http\Livewire\PlataformasController;
use App\Http\Livewire\SucursalController;
use App\Http\Livewire\CatProdServiceController;
use App\Http\Livewire\ComprasController;
use App\Http\Livewire\DetalleComprasController;
use App\Http\Livewire\EditarCompraDetalleController;
use App\Http\Livewire\MercanciaController;
use App\Http\Livewire\CuentasController;
use App\Http\Livewire\EmailsController;
use App\Http\Livewire\InicioController;
use App\Http\Livewire\LocalizacionController;
use App\Http\Livewire\MarcasController;
use App\Http\Livewire\ModulosController;
use App\Http\Livewire\SubCatProdServiceController;
use App\Http\Livewire\OrderServiceController;
use App\Http\Livewire\PerfilesController;
use App\Http\Livewire\ServiciosController;
use App\Http\Livewire\PhonesController;
use App\Http\Livewire\PlanesController;
use App\Http\Livewire\ReportStreamingController;
use App\Http\Livewire\StrProveedorController;
use App\Http\Livewire\ReporGananciaTgController;
use App\Http\Livewire\ProcedenciaController;
use App\Http\Livewire\ProvidersController;
use App\Http\Livewire\ReporteGananciaStr;
use App\Http\Livewire\ReporteGananciaStrController;
use App\Http\Livewire\ReporteJornadaTMController;
use App\Http\Livewire\ReporteMovimientoController;
use App\Http\Livewire\ReportEntregadoServController;
use App\Http\Livewire\ReporteServiceController;
use App\Http\Livewire\TransaccionesController;
use App\Http\Livewire\TransferenciasController;
use App\Http\Livewire\EditTransferenceController;
use App\Http\Livewire\TypeWorkController;
use App\Http\Livewire\UnidadesController;
use App\Http\Livewire\SaleListController;
use App\Http\Livewire\NotificationController;
use App\Http\Livewire\DestinoProductoController;
use App\Http\Livewire\TransferirProductoController;
use App\Http\Livewire\DestinoController;
use App\Http\Livewire\SaleDailyMovementController;
use App\Http\Livewire\SaleDevolutionController;
use App\Http\Livewire\SaleStatisticController;
use App\Http\Livewire\SaleReporteCantidadController;
use App\Models\Product;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', InicioController::class)->name('home');
    Route::get('/home', InicioController::class);
    // Route::group(['middleware' => ['role:ADMIN']], function () {
    // });

    /* ADMINISTRACION */
    Route::get('roles', RolesController::class)->name('roles')->middleware('permission:Roles_Index');
    Route::get('permisos', PermisosController::class)->name('permisos')->middleware('permission:Permission_Index');
    Route::get('asignar', AsignarController::class)->name('asignar')->middleware('permission:Asignar_Index');
    Route::get('users', UsersController::class)->name('usuarios')->middleware('permission:Usuarios_Index');
    Route::get('clientes', ClienteController::class)->name('cliente')->middleware('permission:Cliente_Index');
    Route::get('procedenciaCli', ProcedenciaController::class)->middleware('permission:Procedencia_Index');
    Route::get('companies', CompaniesController::class)->name('empresa')->middleware('permission:Empresa_Index');
    Route::get('sucursales', SucursalController::class)->name('sucursal')->middleware('permission:Sucursal_Index');
    Route::get('cajas', CajasController::class)->name('caja')->middleware('permission:Caja_Index');
    Route::get('carteras', CarteraController::class)->name('cartera')->middleware('permission:Cartera_Index');
    Route::get('cortecajas', CorteCajaController::class)->name('cortecaja')->middleware('permission:Corte_Caja_Index');

    Route::group(['middleware' => ['permission:Reporte_Movimientos_General']], function () {
        Route::get('movimientos', ReporteMovimientoController::class)->name('movimiento');
        Route::get('resumenmovimientos', ReporteMovimientoResumenController::class)->name('r_movimiento');
        Route::get('ingresoegreso', IngresoEgresoController::class)->name('ingreso_egreso');
        Route::get('carteramovcategoria', CarteraMovCategoriaController::class)->name('carteramovcategoria');
        //aaaaa
        Route::get('report/pdfmovdiageneral', [ExportMovDiaGenController::class, 'reportPDFMovDiaGeneral']);
    
        Route::get('report/pdfmovdiaresumen', [ExportMovDiaResController::class, 'reportPDFMovDiaResumen']);
        Route::get('report/pdfingresos', [ExportIngresosController::class, 'reportPDFIngresos']);
    });

   

    /* TIGO MONEY */
    Route::get('origenes', OrigenController::class)->name('origen')->middleware('permission:Origen_Index');
    Route::get('motivos', MotivoController::class)->name('motivo')->middleware('permission:Motivo_Index');
    Route::get('comisiones', ComisionesController::class)->name('comision')->middleware('permission:Comision_Index');
    Route::get('origen-motivo', OrigenMotivoController::class)->name('origenmot')->middleware('permission:Origen_Mot_Index');
    Route::get('origen-motivo-comision', OrigenMotivoComisionController::class)->name('origenmotcom')->middleware('permission:Origen_Mot_Com_Index');
    Route::get('tigomoney', TransaccionController::class)->name('tigomoney')->middleware('permission:Tigo_Money_Index');
    Route::get('arqueostigo', ArqueosTigoController::class)->name('arqueostigo')->middleware('permission:Arqueos_Tigo_Index');
    Route::get('reportestigo', ReportesTigoController::class)->name('reportestigo')->middleware('permission:Reportes_Tigo_Index');
    Route::get('Movimientodiario/pdf', [ExportMovimientoController::class, 'printPdf'])->name('movimiento.pdf');
    Route::get('ReporteGananciaTg', ReporGananciaTgController::class)->name('ReporteGananciaTg')->middleware('permission:Rep_Gan_Tigo_Index');
    Route::group(['middleware' => ['permission:Report_Tigo_Export']], function () {
        Route::get('reporteTigo/pdf/{user}/{type}/{origen}/{motivo}/{f1}/{f2}', [ExportTigoPdfController::class, 'reporteTigoPDF']);
        Route::get('reporteTigo/pdf/{user}/{type}/{origen}/{motivo}', [ExportTigoPdfController::class, 'reporteTigoPDF']);
    });
    Route::group(['middleware' => ['permission:Report_Ganancia_Tigo_Export']], function () {
        // Route::get('reporteGananciaTigoM/pdf/{user}/{type}/{f1}/{f2}', [TigoGananciaPdfController::class, 'reporte']);
        // Route::get('reporteGananciaTigoM/pdf/{user}/{type}', [TigoGananciaPdfController::class, 'reporte']);
    });
    Route::get('ReporteJornalTM', ReporteJornadaTMController::class)->name('reportejornadatm');

    /* Streaming */
    Route::get('plataformas', PlataformasController::class)->name('plataforma')->middleware('permission:Plataforma_Index');
    Route::get('strproveedores', StrProveedorController::class)->name('proveedor')->middleware('permission:Proveedor_Index');
    Route::get('emails', EmailsController::class)->name('email')->middleware('permission:Correos_Index');
    Route::get('cuentas', CuentasController::class)->name('cuentas')->middleware('permission:Cuentas_Index');
    Route::get('perfiles', PerfilesController::class)->name('perfiles')->middleware('permission:Perfiles_Index');
    Route::get('planes', PlanesController::class)->name('planes')->middleware('permission:Planes_Index');
    Route::get('arqueosStreaming', ArqueosStreamingController::class)->name('arqueosStreaming')->middleware('permission:Arqueos_Streaming_Index');
    Route::get('reportStreaming', ReportStreamingController::class)->name('reportStreaming')->middleware('permission:Reportes_Streaming_Index');
    Route::group(['middleware' => ['permission:Reportes_Streaming_Export']], function () {
        Route::get('reporteStreaming/pdf/{user}/{cuePerf}/{vencVig}/{fechas}/{f1}/{f2}', [ExportStreamingPdfController::class, 'reporteStrPDF']);
        Route::get('reporteStreaming/pdf/{user}/{cuePerf}/{vencVig}/{fechas}', [ExportStreamingPdfController::class, 'reporteStrPDF']);
    });
    Route::get('reportGananciaStreaming', ReporteGananciaStrController::class)->name('reportGananciaStr');

    /* NOTIFICACIONES */
    Route::get('telefonos', PhonesController::class)->name('telefonos');
    Route::get('modulos', ModulosController::class)->name('modulos');

    /* INVENTARIOS */
    Route::group(['middleware' => ['permission:Inventarios_Registros']], function () {
        Route::get('categories', CategoriesController::class)->name('categorias');
        Route::post('importar-cat',[ CategoriesController::class,'import'])->name('importar_cat');
        Route::post('importar-subcat',[ CategoriesController::class,'importsub'])->name('importar_subcat');
        Route::get('products', ProductsController::class)->name('productos');
        Route::get('locations', LocalizacionController::class)->name('locations');
        Route::get('unidades', UnidadesController::class)->name('unities');
        Route::get('marcas', MarcasController::class)->name('brands');
        Route::get('proveedores', ProvidersController::class)->name('supliers');
        Route::post('importar',[ ProductsController::class,'import'])->name('importar');
        Route::get('operacionesinv',MercanciaController::class)->name('operacionesinv');
       
    });
        Route::group(['middleware' => ['permission:Compras_Index']], function () {
        Route::get('compras', ComprasController::class)->name('compras');
        Route::get('detalle_compras', DetalleComprasController::class)->name('detalle_compra');
        Route::get('editar_compra',EditarCompraDetalleController::class)->name('editcompra');
    });
   // Route::get('transacciones', TransaccionesController::class)->name('transactions')->middleware('permission:Coins_Index');
        Route::get('destino_prod', DestinoProductoController::class)->name('destination')->middleware('permission:Almacen_Index');
      
        Route::group(['middleware' => ['permission:Transferencia_Index']], function () {   
        Route::get('transferencia', TransferirProductoController::class)->name('operacionTransferencia');
        Route::get('destino', DestinoController::class)->name('dest');
        Route::get('all_transferencias', TransferenciasController::class);
        Route::get('trans', EditTransferenceController::class)->name('editdest');
    });
        Route::group(['middleware' => ['permission:Reportes_Inventarios_Export']], function () {
        Route::get('Compras/pdf/{id}', [ExportComprasController::class, 'PrintCompraPdf']);
        Route::get('Transferencia/pdf', [ExportTransferenciaController::class, 'printPdf'])->name('transferencia.pdf');
        Route::get('reporteCompras/pdf/{filtro}/{fecha}/{fromDate}/{toDate}/{data?}', [ExportComprasController::class, 'reporteComprasPdf']);
        Route::get('productos/export/', [ProductsController::class, 'export']);
        });
    
    

    /* VENTAS */
    Route::get('coins', CoinsController::class)->name('monedas')->middleware('permission:Coins_Index');
    Route::get('pos', PosController::class)->name('ventas')->middleware('permission:Sales_Index');
    Route::get('cashout', CashoutController::class)->name('cashout')->middleware('permission:Cashout_Index');
    Route::get('reports', ReportsController::class)->name('reportes')->middleware('permission:Reportes_Index');
    Route::get('ventasreportecantidad', SaleReporteCantidadController::class)->name('ventasreportecantidad')->middleware('permission:Reportes_Sale_Index');
    Route::group(['middleware' => ['permission:Report_Sales_Export']], function () {
    Route::get('report/pdf/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reportPDF']);
    Route::get('report/pdf/{user}/{type}', [ExportController::class, 'reportPDF']);
    Route::get('report/pdf/{total}/{idventa}/{totalitems}', [ExportSaleController::class, 'reportPDFVenta']);
    Route::get('report/pdfmovdia', [ExportSaleMovDiaController::class, 'reportPDFMovDiaVenta']);
    });



    /* SERVICIOS */
    Route::get('catprodservice', CatProdServiceController::class)->name('cps')->middleware('permission:Cat_Prod_Service_Index');
    Route::get('subcatprodservice', SubCatProdServiceController::class)->name('scps')->middleware('permission:SubCat_Prod_Service_Index');
    Route::get('typework', TypeWorkController::class)->name('tw')->middleware('permission:Type_Work_Index');
    Route::get('service', ServiciosController::class)->name('serv')->middleware('permission:Service_Index');
    Route::get('orderservice', OrderServiceController::class)->name('os')->middleware('permission:Orden_Servicio_Index');
    Route::get('inicio', InicioController::class)->name('in')->middleware('permission:Inicio_Index');
    Route::get('idorderservice/{id}', [OrderServiceController::class, 'buscarid'])->name('buscarid')->middleware('permission:Orden_Servicio_Index');
    Route::get('abrirnuevo/{id}', [OrderServiceController::class, 'abrirventana'])->name('abrirventana')->middleware('permission:Orden_Servicio_Index');
    Route::get('reporte/pdf/{id}', [ImprimirController::class, 'print'])->middleware('permission:Imprimir_Orden_Servicio_Index');
    Route::get('informetecnico/pdf/{id}', [ServicioInformeTecnicoController::class, 'print']);
    Route::get('reporteservices', ReporteServiceController::class)->name('tw2')->middleware('permission:Reporte_Servicios_Index');
    Route::group(['middleware' => ['permission:Reporte_Servicios_Export']], function () {
        Route::get('reporteServicio/pdf/{user}/{estado}/{sucursal}/{type}/{f1}/{f2}', [ExportServicioPdfController::class, 'reporteServPDF']);
        Route::get('reporteServicio/pdf/{user}/{estado}/{sucursal}/{type}', [ExportServicioPdfController::class, 'reporteServPDF']);
    });
    Route::get('reportentregservices', ReportEntregadoServController::class)->name('res')->middleware('permission:Boton_Entregar_Servicio');
    Route::get('reporteServicEntreg/pdf/{type}/{f1}/{f2}/{sucursal}/{sE}/{sB}/{caja}', [ExportServicioEntregPdfController::class, 'reporteServPDF']);
    Route::get('reporteServicEntreg/pdf/{type}/{sucursal}', [ExportServicioEntregPdfController::class, 'reporteServPDF']);
    //Lista de Ventas
    Route::get('salelist', SaleListController::class)->name('salelist')->middleware('permission:VentasLista_Index');
    Route::get('estadisticas', SaleStatisticController::class)->name('estadisticas');
    Route::get('devolucionventa', SaleDevolutionController::class)->name('devolucionventa');
    Route::get('salemovimientodiario', SaleDailyMovementController::class)->name('salemovimientodiario')->middleware('permission:VentasMovDia_Index');
    // Route::get('notificaciones', NotificationController::class)->name('notificaciones');
    // Route::get('notificaciones/{idnotificacion}', [NotificacionController::class,'mostrarnotificacion']);


    //Vaciar la cache
    // Route::get('/clear-cache', function() {
    //     Artisan::call('route:clear');
    //     return "Cache is cleared";
    // });

});






//reportes EXCEL
