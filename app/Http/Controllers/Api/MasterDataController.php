<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PaymentMasterData;
use App\Models\RateMasterData;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function rate()
    {
        $rate = RateMasterData::all();

        return response()->json($rate);
    }

    public function metode_pembayaran()
    {
        $payment = PaymentMasterData::all();

        return response()->json($payment);
    }

    public function showByType(string $type)
    {
        $data = RateMasterData::where('type', $type)->get();

        if ($data->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $data
        ], 200);

    }

}
