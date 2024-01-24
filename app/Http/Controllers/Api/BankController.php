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
use App\Models\TopUp;
use App\Models\Withdraw;
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


    // public function rate()
    // {
    //     try {
    //         $rate = RateMasterData::all();

    //         if ($rate->isEmpty()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data rate tidak ditemukan'
    //             ], 404);
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data rate ditemukan',
    //             'data' => $rate
    //         ], 200);
    //     } catch (\Exception $e) {
    //         // Tangkap exception jika terjadi error
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function rate()
    {
        try {
            // Fetch data using get() method
            $rate = RateMasterData::all();

            if ($rate->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data rate tidak ditemukan'
                ], 404);
            }

            // Modify the response data without using map
            foreach ($rate as $item) {
                foreach ($item->getAttributes() as $key => $value) {
                    $item->$key = $value !== null && $value !== '' ? $value : 'n/a';
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Data rate ditemukan',
                'data' => $rate
            ], 200);
        } catch (\Exception $e) {
            // Handle exception if an error occurs
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

    // public function getBlockchainByBank($nama_bank)
    // {
    //     $blockchainData = Blockchain::where('nama_bank', $nama_bank)->get();

    //     if ($blockchainData->isEmpty()) {
    //         return response()->json(['message' => 'Data tidak ditemukan'], 404);
    //     }

    //     return response()->json($blockchainData);
    // }

    public function getBlockchainByBank($nama_bank)
    {
        $blockchainData = Blockchain::where('nama_bank', $nama_bank)
            ->where('type', 'withdraw')
            ->get();

        if ($blockchainData->isEmpty()) {
            return response()->json(['message' => 'Data withdraw tidak ditemukan'], 404);
        }

        return response()->json($blockchainData);
    }


    // public function history(Request $request)
    // {
    //     $userId = $request->user_id;

    //     $withdraws = Withdraw::where('user_id', $userId)->get();
    //     $topups = TopUp::where('user_id', $userId)->get();

    //     $history = [
    //         'withdraws' => $withdraws,
    //         'topups' => $topups,
    //     ];

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'History retrieved successfully',
    //         'data' => $history,
    //     ]);
    // }

    public function history(Request $request)
    {
        $userId = $request->user_id;

        $withdraws = Withdraw::where('user_id', $userId)
            ->whereNotIn('status', ['un payment'])
            ->get();

        $topups = TopUp::where('user_id', $userId)
            ->whereNotIn('status', ['un payment'])
            ->get();

        $history = [];

        if (!$withdraws->isEmpty()) {
            $modifiedWithdraws = $withdraws->map(function ($withdraw) {
                $withdraw['type'] = 'Withdraw';
                return $withdraw;
            });

            $history = $modifiedWithdraws->toArray();
        }

        if (!$topups->isEmpty()) {
            $modifiedTopups = $topups->map(function ($topup) {
                $topup['type'] = 'Top-Up';
                return $topup;
            });

            $history = array_merge($history, $modifiedTopups->toArray());
        }

        if (empty($history)) {
            return response()->json([
                'success' => false,
                'message' => 'No history found',
                'data' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'History retrieved successfully',
            'data' => $history,
        ]);
    }
}
