<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\DaftarController;
use App\Http\Controllers\api\MasterDataController;
use App\Http\Controllers\Api\TopUpController;
use App\Http\Controllers\Api\WithdrawController;
use Illuminate\Http\Request;
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

Route::get('test', function() {
    return 'Wellcome to Api Bakulpay';
});

Route::post('daftar', [DaftarController::class,'store']);

//AUTHENTICATION
Route::post('register', [AuthController::class,'Register']);
Route::post('login', [AuthController::class,'Login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::get('users', [AuthController::class, 'index']);

// MAIN API BANK
Route::get('/payment/{type}', [MasterDataController::class, 'showByType']);
Route::get('/bankwd',[MasterDataController::class,'BankWd']);

//TOPUP
Route::get('/top_up', [TopUpController::class, 'index']);
Route::post('/top_up', [TopUpController::class,'Store']);
Route::post('/payment/top_up/{id_pembayaran}', [TopUpController::class, 'payment_topup']);

//WITHDRAW
Route::get('/withdraw', [WithdrawController::class, 'index']);
Route::post('/withdraw', [WithdrawController::class,'Store']);
Route::post('/payment/withdraw/{id_pembayaran}', [WithdrawController::class, 'payment_withdraw']);


Route::get('rate',[MasterDataController::class,'rate']);
Route::get('metode_pembayaran',[MasterDataController::class,'metode_pembayaran']);

Route::get('history',[MasterDataController::class,'index']);