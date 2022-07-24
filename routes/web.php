<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\ReferralRegisterController;
use App\Http\Controllers\Admin\ReferralController as AdminReferralController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Public Routes
Route::get('/refer', ReferralRegisterController::class)->name('registerReferral');

// Auth Routes
Route::middleware(['auth'])
    ->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::resource('/referrals', ReferralController::class)->only(['index', 'store']);
    });

// Admin Routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['role:super-admin'])
    ->group(function () {
        Route::resource('/referrals', AdminReferralController::class)->only(['index']);
    });
