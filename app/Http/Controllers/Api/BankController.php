<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankWd;
use App\Http\Resources\PostResource;
use App\Models\Blockchain;
use App\Models\Payment;
use App\Models\PaymentMasterData;
use App\Models\RateMasterData;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BankController extends Controller
{

    public function BankWd()
    {
        try {
            $bank_wd = BankWd::all();

            if ($bank_wd->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data BankWd tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data BankWd ditemukan',
                'data' => $bank_wd
            ], 200);
        } catch (\Exception $e) {
            // Tangkap exception jika terjadi error
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function rate()
    {
        try {
            $rate = RateMasterData::all();

            if ($rate->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data rate tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data rate ditemukan',
                'data' => $rate
            ], 200);
        } catch (\Exception $e) {
            // Tangkap exception jika terjadi error
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function metode_pembayaran()
    {
        try {
            $payment = PaymentMasterData::all();

            if ($payment->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data metode pembayaran tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data metode pembayaran ditemukan',
                'data' => $payment
            ], 200);
        } catch (\Exception $e) {
            // Tangkap exception jika terjadi error
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
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

    // public function showByType(string $type)
    // {
    //     $data = RateMasterData::where('type', $type)->first();

    //     if (!$data) {
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'logo_bank' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_bank' => 'required',
            'type_payment' => 'required|in:TopUp,withdraw',
            'price' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $image = $request->file('logo_bank');
        $imagePath = $image->store('logo_banks', 'public');

        $post = new Bank;
        $post->logo_bank = $imagePath;
        $post->nama_bank = $request->nama_bank;
        $post->type_payment = $request->type_payment;
        $post->price = $request->price;

        $post->save();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil memasukkan data'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showByType_Payment(string $type_payment)
    {
        $data = Bank::where('type_payment', $type_payment)->get();

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

    public function createFormPayment()
    {
        $payment = Payment::all();

        return view('transactions.form_payment', ['payment' => $payment]);
    }

    public function getBlockchainByBank($nama_bank)
    {
        $blockchainData = Blockchain::where('nama_bank', $nama_bank)->get();

        if ($blockchainData->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($blockchainData);
    }
}
