<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EkpayChaqueController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/validate', [AuthController::class, 'loginvalidate'])->name('loginvalidate');
Route::get('get/ekpay/payment', [EkpayChaqueController::class, 'paymentDetails']);
Route::get('get/ekpay/respose', [EkpayChaqueController::class, 'getEkpayResponse']);



    Route::middleware(['auth'])->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('dashboard', 'dashboard')->name('dashboard');
            Route::get('enroll', 'enroll')->name('enroll');
            Route::get('coursebatch/list/{id}', 'getPartnerCourse')->name('partnerCourse');


        });

    });
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
