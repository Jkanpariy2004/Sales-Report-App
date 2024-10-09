<?php

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
    });
});
