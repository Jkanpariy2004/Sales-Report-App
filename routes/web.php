<?php

use App\Http\Controllers\Admin\CacheClearController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Login\LoginController;
use App\Http\Controllers\Admin\SalesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::prefix('admin')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('/', 'index')->name('admin.login');
        Route::post('/LoginCheck', 'Login')->name('Login.Check');
        Route::get('/logout', 'Logout')->name('admin.logout');
    });

    Route::middleware('auth.admin')->group(function () {
        Route::prefix('dashboard')->controller(DashboardController::class)->group(function () {
            Route::get('/', 'index')->name('admin.dashboard');
        });

        Route::prefix('sales')->controller(SalesController::class)->group(function () {
            Route::get('/', 'index')->name('admin.sales');
            Route::get('/fetch','fetch')->name('admin.fetch.sales');
            Route::get('/add','add')->name('admin.add.sales');
            Route::get('/customer/{id}', 'getCustomerDetails')->name('customer.details');
            Route::post('/insert', 'insert')->name('insert.sales');
            Route::get('/{id}/items', 'getSalesItems');
            Route::get('/edit/{id}','edit')->name('admin.edit.sales');
            Route::get('/delete-sales-item/{id}','deleteSalesItem')->name('delete.sales.item');
            Route::delete('/delete-sales-item/{id}','deleteSalesItem');
            Route::post('/update-sales-item/{id}', 'updateSalesItem');
            Route::post('/update/{id}','update')->name('update.sales');
            Route::get('/delete/{id}','delete')->name('admin.sales.delete');
            Route::get('/invoice/{id}', 'generateInvoice')->name('admin.sales.invoice');
            Route::post('/send-invoice-pdf', 'sendInvoicePdf');
        });

        Route::prefix('customers')->controller(CustomersController::class)->group(function () {
            Route::get('/', 'index')->name('admin.customer');
            Route::get('/fetch','fetch')->name('admin.fetch.customers');
            Route::get('/add','add')->name('admin.add.customers');
            Route::post('/insert','insert')->name('insert.customers');
            Route::get('/edit/{id}','edit')->name('admin.edit.customers');
            Route::post('/update/{id}','update')->name('update.customers');
            Route::get('/delete/{id}','delete')->name('admin.customers.delete');
        });

        Route::prefix('cache')->controller(CacheClearController::class)->group(function () {
            Route::get('/', 'index')->name('cache');
            Route::get('/cache-clear', 'clearCache')->name('cache.clear');
            Route::get('/route-cache-clear', 'clearRouteCache')->name('route.cache.clear');
            Route::get('/config-cache-clear', 'clearConfigCache')->name('config.cache.clear');
            Route::get('/view-cache-clear', 'clearViewCache')->name('view.cache.clear');
            Route::get('/compiled-cache-clear', 'clearCompiledCache')->name('compiled.cache.clear');
            Route::get('/optimize-cache-clear', 'optimizeCache')->name('optimize.cache.clear');
        });
    });
});
