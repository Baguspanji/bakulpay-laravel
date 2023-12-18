<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use App\Models\BankWd;
use App\Models\Payment;
use App\Models\PaymentMasterData;
use App\Models\RateMasterData;
use App\Models\TopUp;
use App\Models\Withdraw;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    // public function rate()
    // {
    //     $rate = RateMasterData::all();
    //     return response()->json($rate);
    // }

    // public function BankWd()
    // {
    //     $bank_wd = BankWd::all();
    //     return response()->json($bank_wd);
    // }

    // public function metode_pembayaran()
    // {
    //     $payment = PaymentMasterData::all();

    //     return response()->json($payment);
    // }

    // public function showByType(string $type)
    // {
    //     $data = RateMasterData::where('type', $type)->get();

    //     if ($data->isEmpty()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Data tidak ditemukan'
    //         ], 404);
    //     }

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Data ditemukan',
    //         'data' => $data
    //     ], 200);
    // }

    public function index()
    {
        // Mengambil data dari masing-masing tabel
        $topUps = TopUp::all();
        $withdraws = Withdraw::all();
        $payments = Payment::all();

        // Menggabungkan data dari tiga tabel ke dalam satu array
        $result = array_merge($topUps->toArray(), $withdraws->toArray(), $payments->toArray());

        // Mengembalikan response JSON dengan data gabungan
        return response()->json($result);
    }
}
