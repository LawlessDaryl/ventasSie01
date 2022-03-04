<?php

use App\Http\Controllers\ExportController;
use App\Http\Livewire\ArqueosTigoController;
use App\Http\Livewire\UnidadesController;
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

use App\Http\Livewire\SubCatProdServiceController;
use App\Http\Livewire\OrderServiceController;
use App\Http\Livewire\ServiciosController;
use App\Http\Livewire\LocalizacionController;
use App\Http\Livewire\StrProveedorController;
use App\Http\Livewire\MarcasController;
use App\Http\Livewire\ProvidersController;
use App\Http\Livewire\TransaccionesController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::middleware(['auth'])->group(function () {
   
    Route::get('coins', CoinsController::class)->name('monedas');
    Route::get('pos', PosController::class)->name('ventas');

    Route::group(['middleware' => ['role:ADMIN']], function () {
        Route::get('roles', RolesController::class)->name('roles');
        Route::get('permisos', PermisosController ::class)->name('permisos');
        Route::get('asignar', AsignarController::class)->name('asignar');
        Route::get('companies', CompaniesController::class)->name('empresa');
        Route::get('sucursales', SucursalController::class)->name('sucursal');
        Route::get('cajas', CajasController::class)->name('caja');
        Route::get('carteras', CarteraController::class)->name('cartera');
        Route::get('cortecajas', CorteCajaController::class)->name('cortecaja');
        Route::get('plataformas', PlataformasController::class)->name('plataforma');
        Route::get('strproveedores', StrProveedorController::class)->name('proveedor');
        
    });
    
    Route::get('users', UsersController::class)->name('usuarios');
    Route::get('cashout', CashoutController::class)->name('cashout');
    Route::get('reports', ReportsController::class)->name('reportes');

    Route::get('comisiones', ComisionesController ::class)->name('comision');
    Route::get('motivos', MotivoController ::class)->name('motivo');
    Route::get('origenes', OrigenController ::class)->name('origen');
    Route::get('origen-motivo', OrigenMotivoController ::class)->name('origenmot');
    Route::get('origen-motivo-comision', OrigenMotivoComisionController ::class)->name('origenmotcom');

    Route::get('tigomoney', TransaccionController::class)->name('tigomoney');
    Route::get('reportestigo', ReportesTigoController::class)->name('reportestigo');
    Route::get('arqueostigo', ArqueosTigoController::class)->name('arqueostigo');

    Route::get('clientes', ClienteController::class)->name('cliente');
    Route::get('catprodservice', CatProdServiceController::class)->name('cps');
    Route::get('subcatprodservice', SubCatProdServiceController::class)->name('scps');
    Route::get('orderservice', OrderServiceController::class)->name('os');
    Route::get('service', ServiciosController::class)->name('serv');

    Route::get('categories', CategoriesController::class)->name('categorias');
    Route::get('products', ProductsController::class)->name('productos');


    Route::get('locations', LocalizacionController::class)->name('locations');
    Route::get('unidades', UnidadesController::class)->name('unities');
    Route::get('marcas', MarcasController::class)->name('brands');
    Route::get('proveedores', ProvidersController::class)->name('supliers');
    Route::get('compras', ComprasController::class)->name('buys');
    Route::get('transacciones', TransaccionesController::class)->name('transactions');

    

    //reportes PDDF
    Route::get('report/pdf/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reportPDF']);
    Route::get('report/pdf/{user}/{type}', [ExportController::class, 'reportPDF']);
});






//reportes EXCEL jslfajdklfjkajfdjfkdkddks