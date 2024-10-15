<?php

use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\DailySalesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Login\LoginController;
use App\Http\Controllers\Admin\ProductReportController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\SupplierController;
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
            Route::get('/fetch', 'fetch')->name('admin.fetch.sales');
            Route::get('/add', 'add')->name('admin.add.sales');
            Route::get('/customer/{id}', 'getCustomerDetails')->name('customer.details');
            Route::post('/insert', 'insert')->name('insert.sales');
            Route::get('/{id}/items', 'getSalesItems');
            Route::get('/edit/{id}', 'edit')->name('admin.edit.sales');
            Route::delete('/delete-sales-item/{id}', 'deleteSalesItem');
            Route::post('/update-sales-item/{id}', 'updateSalesItem');
            Route::post('/update/{id}', 'update')->name('update.sales');
            Route::get('/delete/{id}', 'delete')->name('admin.sales.delete');
            Route::get('/invoice/{id}', 'generateInvoice')->name('admin.sales.invoice');
            Route::post('/send-invoice-pdf', 'sendInvoicePdf');
            Route::get('/item/price/{id}', 'getItemPrice')->name('item.price');
        });

        Route::prefix('purchase')->controller(PurchaseController::class)->group(function () {
            Route::get('/', 'index')->name('admin.purchase');
            Route::get('/fetch', 'fetch')->name('fetch.purchase');
            Route::get('/add', 'add')->name('admin.add.purchase');
            Route::post('/insert', 'insert')->name('insert.purchase');
            Route::get('/edit/{id}', 'edit')->name('admin.edit.purchase');
            Route::post('/update/{id}', 'update')->name('update.purchase');
            Route::get('/delete/{id}', 'delete')->name('delete.purchase');
            Route::get('/{id}/items', 'getPurchaseItems');
            Route::get('/item/price/{id}', 'getItemPrice')->name('item.purchase.cost');
            Route::delete('/delete-purchase-item/{id}', 'deletePurchaseItem');
            Route::post('/update-purchase-item/{id}', 'updatePurchaseItem');
            Route::get('/delete/{id}', 'delete')->name('admin.purchase.producta.delete');
        });

        route::prefix('supplier')->controller(SupplierController::class)->group(function () {
            Route::get('/', 'index')->name('admin.supplier');
            Route::get('/fetch', 'fetch')->name('admin.fetch.supplier');
            Route::get('/add', 'add')->name('admin.add.supplier');
            Route::post('/insert', 'insert')->name('insert.supplier');
            Route::get('/edit/{id}', 'edit')->name('admin.edit.supplier');
            Route::post('/update/{id}', 'update')->name('update.supplier');
            Route::get('/delete/{id}', 'delete')->name('delete.supplier');
        });

        Route::prefix('customers')->controller(CustomersController::class)->group(function () {
            Route::get('/', 'index')->name('admin.customer');
            Route::get('/fetch', 'fetch')->name('admin.fetch.customers');
            Route::get('/add', 'add')->name('admin.add.customers');
            Route::post('/insert', 'insert')->name('insert.customers');
            Route::get('/edit/{id}', 'edit')->name('admin.edit.customers');
            Route::post('/update/{id}', 'update')->name('update.customers');
            Route::get('/delete/{id}', 'delete')->name('admin.customers.delete');
        });

        Route::prefix('products')->controller(ProductsController::class)->group(function () {
            Route::get('/', 'index')->name('admin.products');
            Route::get('/fetch', 'fetch')->name('admin.fetch.products');
            Route::get('/add', 'add')->name('admin.add.products');
            Route::post('/insert', 'insert')->name('insert.products');
            Route::get('/edit/{id}', 'edit')->name('admin.edit.products');
            Route::post('/update/{id}', 'update')->name('update.products');
            Route::get('/delete/{id}', 'delete')->name('admin.products.delete');
        });

        Route::prefix('reports')->group(function () {
            Route::prefix('/product-report')->controller(ProductReportController::class)->group(function () {
                Route::get('/', 'index')->name('products.report');
                Route::get('/fetch', 'fetch')->name('fetch.product.report.data');
            });

            Route::prefix('/daily-sales')->controller(DailySalesController::class)->group(function () {
                Route::get('/', 'index')->name('daily.sales');
                Route::get('/sales/{date}', 'fetch');
            });
        });
    });
});
