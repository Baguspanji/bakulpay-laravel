<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\DaftarController;
use App\Http\Controllers\api\MasterDataController;
use App\Http\Controllers\Api\TopUpController;
use App\Http\Controllers\Api\WithdrawController;
use App\Models\BankWd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test', function () {
    return 'Welcome to Api Bakulpay';
});

Route::post('daftar', [DaftarController::class, 'store']);

// ADMIN AUTHENTICATION
Route::post('register', [AdminController::class, 'Daftar']);
Route::post('login', [AdminController::class, 'Masuk'])->name('Masuk');
Route::post('login_gm', [AdminController::class, 'Login_GM'])->name('Login_GM');
Route::post('logout', [AdminController::class, 'logout']);
Route::get('admins', [AdminController::class, 'index']);

// MAIN API BANK
Route::get('/payment/{type}', [BankController::class, 'showByType']);
Route::get('bankwd', [BankController::class, 'BankWd'])->name('bankwd');

// TOPUP
Route::get('/top_up', [TopUpController::class, 'index']);
Route::post('/top_up', [TopUpController::class, 'Store']);
Route::post('/payment/top_up/{id_pembayaran}', [TopUpController::class, 'payment_topup']);

// WITHDRAW
Route::get('/withdraw', [WithdrawController::class, 'index']);
Route::post('/withdraw', [WithdrawController::class, 'Store']);
Route::post('/payment/withdraw/{id_pembayaran}', [WithdrawController::class, 'payment_withdraw']);

// Authenticated route for getting user's history
Route::middleware('auth:sanctum')->get('history/{user_id}', [BankController::class, 'history']);


Route::get('rate', [BankController::class, 'rate']);
Route::get('metode_pembayaran', [BankController::class, 'metode_pembayaran']);

Route::get('blockchain/{nama_bank}', [BankController::class, 'getBlockchainByBank']);
