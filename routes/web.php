<?php

use App\Http\Controllers\api\PaymentController;
use App\Http\Controllers\Api\TopUpController;
use App\Http\Controllers\Api\WithdrawController;
use App\Http\Controllers\BankWdController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentMasterDataController;
use App\Http\Controllers\RateMasterDataController;
use App\Models\RateMasterData;
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

Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/payment', [HomeController::class, 'payment'])->name('payment');
Route::get('/top-up', [HomeController::class, 'topUp'])->name('topup');
Route::get('/withdraw', [HomeController::class, 'withdraw'])->name('withdraw');
Route::get('/wallet', [HomeController::class, 'wallet'])->name('wallet');
Route::get('/pay_md', [HomeController::class, 'pay_md'])->name('pay_md');
Route::get('/transactionmd', [HomeController::class, 'transactionmd'])->name('transactionmd');
Route::get('/bank_wd', [HomeController::class, 'bankwd'])->name('bank_wd');
Route::get('/rate', [HomeController::class, 'rate'])->name('rate');
Route::get('/cs_management', [HomeController::class, 'cs_management'])->name('cs_management');

Route::get('/form_transactionmd', [RateMasterDataController::class, 'createFormRateMasterData']);
Route::post('submit/form_transactionmd', [RateMasterDataController::class, 'submitForm'])->name('submit.form_transactionmd');
Route::get('/edit-transactionmd/{id}', [RateMasterDataController::class, 'edit_transactionmd'])->name('edit_transactionmd');
Route::post('/update-transactionmd/{id}', [RateMasterDataController::class, 'update_transactionmd'])->name('update_transactionmd');

Route::get('/form_paymentmd', [PaymentMasterDataController::class, 'createFormPaymentMasterData']);
Route::post('submit/form_paymentmd', [PaymentMasterDataController::class, 'submitForm'])->name('submit.form_paymentmd');
Route::get('/edit-paymentmd/{id}', [PaymentMasterDataController::class, 'edit_paymentmd'])->name('edit_paymentmd');
Route::post('/update-paymentmd/{id}', [PaymentMasterDataController::class, 'update_paymentmd'])->name('update_paymentmd');

Route::get('/form_bankwd', [BankWdController::class, 'createFormBankWd']);
Route::post('submit/form_bankwd', [BankWdController::class, 'submitForm'])->name('submit.form_bankwd');
Route::get('/edit-bankwd/{id}', [BankWdController::class, 'edit_bankwd'])->name('edit_bankwd');
Route::post('/update-bankwd/{id}', [BankWdController::class, 'update_bankwd'])->name('update_bankwd');

Route::get('/edit-rate/{id}', [RateMasterDataController::class, 'edit_rate'])->name('edit_rate');
Route::post('/update-rate/{id}', [RateMasterDataController::class, 'update_rate'])->name('update_rate');

Route::get('/form_payment', [PaymentController::class, 'createFormPayment']);
Route::post('submit/form_payment', [PaymentController::class, 'submitForm'])->name('submit.form_payment');
Route::get('/edit_payment/{id}', [PaymentController::class, 'edit_payment'])->name('edit_payment');
Route::post('/update_payment/{id}', [PaymentController::class, 'update_payment'])->name('update_payment');

Route::get('/edit_topup/{id}', [TopUpController::class, 'edit_topup'])->name('edit_topup');
Route::post('/update_topup/{id}', [TopUpController::class, 'update_topup'])->name('update_topup');

Route::get('/edit_withdraw/{id}', [WithdrawController::class, 'edit_withdraw'])->name('edit_withdraw');
Route::post('/update_withdraw/{id}', [WithdrawController::class, 'update_withdraw'])->name('update_withdraw');

Route::get('/get_payment_details/{id}', [PaymentController::class, 'getPaymentDetails'])->name('get_payment_details');