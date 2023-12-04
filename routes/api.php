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

Route::post('daftar', [DaftarController::class,'store']);

//AUTHENTICATION
Route::post('register', [AuthController::class,'Register']);
Route::post('login', [AuthController::class,'Login']);

// MAIN API BANK
Route::get('/payment/{type}', [MasterDataController::class, 'showByType']);

//TOPUP
Route::post('/top_up', [TopUpController::class,'Store']);


//WITHDRAW
Route::post('/withdraw', [WithdrawController::class,'Store']);

Route::get('rate',[MasterDataController::class,'rate']);
Route::get('metode_pembayaran',[MasterDataController::class,'metode_pembayaran']);