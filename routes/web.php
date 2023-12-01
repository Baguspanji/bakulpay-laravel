<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeController::class,'dashboard'])->name('dashboard');
Route::get('/payment', [HomeController::class, 'payment'])->name('payment');
Route::get('/top-up', [HomeController::class, 'topUp'])->name('topup');
Route::get('/withdraw', [HomeController::class, 'withdraw'])->name('withdraw');
Route::get('/wallet', [HomeController::class, 'wallet'])->name('wallet');
Route::get('/pay_md', [HomeController::class, 'pay_md'])->name('pay_md');
Route::get('/transactionmd', [HomeController::class, 'transactionmd'])->name('transactionmd');
Route::get('/rate', [HomeController::class, 'rate'])->name('rate');
Route::get('/cs_management', [HomeController::class, 'cs_management'])->name('cs_management');
