<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\ExportSaleController;
use App\Http\Controllers\ExportServicioPdfController;
use App\Http\Controllers\ExportStreamingPdfController;
use App\Http\Controllers\ExportTigoPdfController;
use App\Http\Controllers\ImprimirController;
use App\Http\Livewire\ArqueosStreamingController;
use App\Http\Livewire\ArqueosTigoController;
use App\Http\Livewire\AsignarController;
use App\Http\Livewire\CajasController;
use App\Http\Livewire\CarteraController;
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
use App\Http\Livewire\ReportsController;
use App\Http\Livewire\TransaccionController;
use App\Http\Livewire\UsersController;
use App\Http\Livewire\CompaniesController;
use App\Http\Livewire\CorteCajaController;
use App\Http\Livewire\PlataformasController;
use App\Http\Livewire\SucursalController;
use App\Http\Livewire\CatProdServiceController;
use App\Http\Livewire\ComprasController;
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
use App\Http\Livewire\ReporteServiceController;
use App\Http\Livewire\TransaccionesController;
use App\Http\Livewire\TypeWorkController;
use App\Http\Livewire\UnidadesController;
use App\Http\Livewire\SaleListController;
use App\Http\Livewire\NotificacionController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth'])->group(function () {

    Route::group(['middleware' => ['role:ADMIN']], function () {
    });
    /* ADMINISTRACION */
    Route::get('users', UsersController::class)->name('usuarios')->middleware('permission:Usuarios_Index');
    Route::get('procedenciaCli', ProcedenciaController::class)->name('proced');
    Route::get('clientes', ClienteController::class)->name('cliente')->middleware('permission:Cliente_Index');
    Route::get('roles', RolesController::class)->name('roles')->middleware('permission:Roles_Index');
    Route::get('permisos', PermisosController::class)->name('permisos')->middleware('permission:Permission_Index');
    Route::get('asignar', AsignarController::class)->name('asignar')->middleware('permission:Asignar_Index');
    Route::get('companies', CompaniesController::class)->name('empresa')->middleware('permission:Empresa_Index');
    Route::get('sucursales', SucursalController::class)->name('sucursal')->middleware('permission:Sucursal_Index');
    Route::get('cajas', CajasController::class)->name('caja')->middleware('permission:Caja_Index');
    Route::get('carteras', CarteraController::class)->name('cartera')->middleware('permission:Cartera_Index');
    Route::get('cortecajas', CorteCajaController::class)->name('cortecaja')->middleware('permission:Corte_Caja_Index');

    /* Streaming */
    Route::get('plataformas', PlataformasController::class)->name('plataforma')->middleware('permission:Plataforma_Index');
    Route::get('strproveedores', StrProveedorController::class)->name('proveedor')->middleware('permission:Proveedor_Index');
    Route::get('emails', EmailsController::class)->name('email');
    Route::get('cuentas', CuentasController::class)->name('cuentas');
    Route::get('perfiles', PerfilesController::class)->name('perfiles');
    Route::get('planes', PlanesController::class)->name('planes');
    Route::get('reportStreaming', ReportStreamingController::class)->name('reportStreaming');
    Route::get('arqueosStreaming', ArqueosStreamingController::class)->name('arqueosStreaming');
    Route::get('reporteStreaming/pdf/{user}/{tipo}/{type}/{f1}/{f2}', [ExportStreamingPdfController::class, 'reporteStrPDF']);
    Route::get('reporteStreaming/pdf/{user}/{tipo}/{type}', [ExportStreamingPdfController::class, 'reporteStrPDF']);

    /* NOTIFICACIONES */
    Route::get('telefonos', PhonesController::class)->name('telefonos');
    Route::get('modulos', ModulosController::class)->name('modulos');

    /* TIGO MONEY */
    Route::get('comisiones', ComisionesController::class)->name('comision')->middleware('permission:Comision_Index');
    Route::get('motivos', MotivoController::class)->name('motivo')->middleware('permission:Motivo_Index');
    Route::get('origenes', OrigenController::class)->name('origen')->middleware('permission:Origen_Index');
    Route::get('origen-motivo', OrigenMotivoController::class)->name('origenmot')->middleware('permission:Origen_Mot_Index');
    Route::get('origen-motivo-comision', OrigenMotivoComisionController::class)->name('origenmotcom')->middleware('permission:Origen_Mot_Com_Index');
    Route::get('tigomoney', TransaccionController::class)->name('tigomoney')->middleware('permission:Tigo_Money_Index');
    Route::get('reportestigo', ReportesTigoController::class)->name('reportestigo')->middleware('permission:Reportes_Tigo_Index');
    Route::get('ReporteGananciaTg', ReporGananciaTgController::class)->name('ReporteGananciaTg')->middleware('permission:Rep_Gan_Tigo_Index');
    Route::get('arqueostigo', ArqueosTigoController::class)->name('arqueostigo')->middleware('permission:Arqueos_Tigo_Index');
    Route::group(['middleware' => ['permission:Report_Tigo_Export']], function () {
        Route::get('reporteTigo/pdf/{user}/{type}/{f1}/{f2}', [ExportTigoPdfController::class, 'reporteTigoPDF']);
        Route::get('reporteTigo/pdf/{user}/{type}', [ExportTigoPdfController::class, 'reporteTigoPDF']);
    });
    Route::group(['middleware' => ['permission:Report_Ganancia_Tigo_Export']], function () {
        Route::get('reporteGananciaTigoM/pdf/{user}/{type}/{f1}/{f2}', [TigoGananciaPdfController::class, 'reporte']);
        Route::get('reporteGananciaTigoM/pdf/{user}/{type}', [TigoGananciaPdfController::class, 'reporte']);
    });

    /* SERVICIOS */
    Route::get('catprodservice', CatProdServiceController::class)->name('cps')->middleware('permission:Cat_Prod_Service_Index');
    Route::get('subcatprodservice', SubCatProdServiceController::class)->name('scps')->middleware('permission:SubCat_Prod_Service_Index');
    Route::get('orderservice', OrderServiceController::class)->name('os')->middleware('permission:Orden_Servicio_Index');
    Route::get('service', ServiciosController::class)->name('serv')->middleware('permission:Service_Index');
    Route::get('inicio', InicioController::class)->name('in')->middleware('permission:Asignar_Tecnico_Servicio');
    Route::get('typework', TypeWorkController::class)->name('tw');
    Route::get('reporteservices', ReporteServiceController::class)->name('tw');
    Route::get('idorderservice/{id}', [OrderServiceController::class, 'buscarid'])->name('buscarid');
    Route::get('reporte/pdf/{id}', [ImprimirController::class, 'print']);
    Route::get('reporteServicio/pdf/{user}/{estado}/{type}/{f1}/{f2}', [ExportServicioPdfController::class, 'reporteServPDF']);
    Route::get('reporteServicio/pdf/{user}/{estado}/{type}', [ExportServicioPdfController::class, 'reporteServPDF']);

    /* INVENTARIOS */
    Route::get('categories', CategoriesController::class)->name('categorias');
    Route::get('products', ProductsController::class)->name('productos');
    Route::get('locations', LocalizacionController::class)->name('locations');
    Route::get('unidades', UnidadesController::class)->name('unities');
    Route::get('marcas', MarcasController::class)->name('brands');
    Route::get('proveedores', ProvidersController::class)->name('supliers');
    Route::get('compras', ComprasController::class)->name('compras');
    Route::get('transacciones', TransaccionesController::class)->name('transactions');

    /* VENTAS */
    Route::get('coins', CoinsController::class)->name('monedas')->middleware('permission:Coins_Index');
    Route::get('pos', PosController::class)->name('ventas')->middleware('permission:Sales_Index');
    Route::get('cashout', CashoutController::class)->name('cashout')->middleware('permission:Cashout_Index');
    Route::get('reports', ReportsController::class)->name('reportes')->middleware('permission:Reportes_Index');
    Route::group(['middleware' => ['permission:Report_Sales_Export']], function () {
        Route::get('report/pdf/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reportPDF']);
        Route::get('report/pdf/{user}/{type}', [ExportController::class, 'reportPDF']);
        Route::get('report/pdf/{total}/{idventa}/{totalitems}', [ExportSaleController::class, 'reportPDFVenta']);
    });
    //Lista de Ventas
    Route::get('salelist', SaleListController::class)->name('salelist');
    Route::get('notificaciones', NotificacionController::class)->name('notificaciones');

});






//reportes EXCEL