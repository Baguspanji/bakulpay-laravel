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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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

    // public function rate()
    // {
    //     try {
    //         // Fetch data using get() method
    //         $rate = RateMasterData::all();

    //         if ($rate->isEmpty()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data rate tidak ditemukan'
    //             ], 404);
    //         }

    //         // Modify the response data without using map
    //         foreach ($rate as $item) {
    //             foreach ($item->getAttributes() as $key => $value) {
    //                 $item->$key = $value !== null && $value !== '' ? $value : 'n/a';
    //             }
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data rate ditemukan',
    //             'data' => $rate
    //         ], 200);
    //     } catch (\Exception $e) {
    //         // Handle exception if an error occurs
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function rate()
    // {
    //     try {
    //         // Fetch data using get() method
    //         $rateData = RateMasterData::all();

    //         if ($rateData->isEmpty()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data rate tidak ditemukan'
    //             ], 404);
    //         }

    //         // Modify the response data without using map
    //         foreach ($rateData as $item) {
    //             foreach ($item->getAttributes() as $key => $value) {
    //                 $item->$key = $value !== null && $value !== '' ? $value : 'n/a';
    //             }

    //             // Check if there is a corresponding blockchain entry
    //             $blockchainEntry = Blockchain::where('id_rate', $item->id)->first();

    //             if ($blockchainEntry) {
    //                 // If there is a matching entry in blockchain, add a 'range' field
    //                 $item->range = $blockchainEntry->calculateRange(); // You may need to define a method to calculate the range in your Blockchain model
    //             } else {
    //                 $item->range = 'n/a'; // Set a default value if no matching entry is found
    //             }
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data rate ditemukan',
    //             'data' => $rateData
    //         ], 200);
    //     } catch (\Exception $e) {
    //         // Handle exception if an error occurs
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function rate()
    // {
    //     try {
    //         // Fetch data using join() method
    //         $rateData = RateMasterData::leftJoin('blockchain', function ($join) {
    //             $join->on('rate_master_data.id', '=', 'blockchain.id_rate')
    //                 ->on('rate_master_data.nama_bank', '=', 'blockchain.nama_bank');
    //         })
    //             ->select('rate_master_data.*', 'blockchain.id_rate as blockchain_id_rate', 'blockchain.nama_bank as blockchain_nama_bank')
    //             ->get();

    //         if ($rateData->isEmpty()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data rate tidak ditemukan'
    //             ], 404);
    //         }

    //         // Modify the response data without using map
    //         foreach ($rateData as $item) {
    //             foreach ($item->getAttributes() as $key => $value) {
    //                 $item->$key = $value !== null && $value !== '' ? $value : 'n/a';
    //             }

    //             // Check if there is a corresponding blockchain entry
    //             if ($item->blockchain_id_rate !== null) {
    //                 // If there is a matching entry in blockchain, add a 'range' field
    //                 $blockchainEntry = Blockchain::where('id_rate', $item->blockchain_id_rate)
    //                     ->where('nama_bank', $item->blockchain_nama_bank)
    //                     ->first();

    //                 if ($blockchainEntry) {
    //                     $item->range = $blockchainEntry->calculateRange(); // You may need to define a method to calculate the range in your Blockchain model
    //                 } else {
    //                     $item->range = 'n/a'; // Set a default value if no matching entry is found
    //                 }
    //             } else {
    //                 $item->range = 'n/a'; // Set a default value if no matching entry is found
    //             }
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data rate ditemukan',
    //             'data' => $rateData
    //         ], 200);
    //     } catch (\Exception $e) {
    //         // Handle exception if an error occurs
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function rate()
    // {
    //     try {
    //         // Fetch data using join() method
    //         $rateData = RateMasterData::leftJoin('blockchain', function ($join) {
    //             $join->on('rate_master_data.id', '=', 'blockchain.id_rate')
    //                 ->on('rate_master_data.nama_bank', '=', 'blockchain.nama_bank');
    //         })
    //             ->select('rate_master_data.*', 'blockchain.id_rate as blockchain_id_rate', 'blockchain.nama_bank as blockchain_nama_bank')
    //             ->get();

    //         if ($rateData->isEmpty()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data rate tidak ditemukan'
    //             ], 404);
    //         }

    //         // Modify the response data using map
    //         $formattedRateData = $rateData->map(function ($item) {
    //             $formattedItem = [
    //                 'id' => $item->id,
    //                 'nama_bank' => $item->nama_bank,
    //                 'icons' => $item->icons,
    //                 'type' => $item->type,
    //                 'price' => $item->price,
    //                 'nama' => $item->nama,
    //                 'no_rekening' => $item->no_rekening,
    //                 'active' => $item->active,
    //                 'created_at' => $item->created_at,
    //                 'updated_at' => $item->updated_at,
    //                 'blockchain' => $item->blockchain_id_rate !== null ? [
    //                     'id' => $item->blockchain_id,
    //                     'id_rate' => $item->blockchain_id_rate,
    //                     'nama_bank' => $item->blockchain_nama_bank,
    //                     'nama_blockchain' => $item->nama_blockchain,
    //                     'rekening_wallet' => $item->rekening_wallet,
    //                     'type' => $item->blockchain_type,
    //                     'price' => $item->blockchain_price,
    //                     'active' => $item->blockchain_active,
    //                     'created_at' => $item->blockchain_created_at,
    //                     'updated_at' => $item->blockchain_updated_at,
    //                 ] : null,
    //             ];

    //             return $formattedItem;
    //         });

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data rate ditemukan',
    //             'data' => $formattedRateData
    //         ], 200);
    //     } catch (\Exception $e) {
    //         // Handle exception if an error occurs
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }


    // public function rate()
    // {
    //     try {
    //         // Ambil semua data dari tabel RateMasterData
    //         $rates = RateMasterData::all();

    //         // Loop melalui setiap data RateMasterData
    //         foreach ($rates as $rate) {
    //             // Ambil data dari tabel Blockchain yang memiliki nama_bank yang sama
    //             $blockchainData = Blockchain::where('nama_bank', $rate->nama_bank)->get();

    //             // Tambahkan data blockchain ke dalam properti baru pada objek RateMasterData
    //             $rate->blockchain_data = $blockchainData;
    //         }

    //         return response()->json($rates);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Gagal mendapatkan data rate.'], 500);
    //     }
    // }

    public function rate()
    {
        try {
            // Ambil semua data dari tabel RateMasterData
            $rates = RateMasterData::all();

            // Loop melalui setiap data RateMasterData
            foreach ($rates as $rate) {
                // Ambil data dari tabel Blockchain yang memiliki nama_bank yang sama
                $blockchainData = Blockchain::where('nama_bank', $rate->nama_bank)->get();

                // Tambahkan data blockchain ke dalam properti baru pada objek RateMasterData
                $rate->blockchain_data = $blockchainData->map(function ($item) {
                    // Ubah nilai 'true' atau 'false' menjadi boolean
                    $item['active'] = ($item['active'] === 'true');
                    return $item;
                });
            }

            return response()->json($rates);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mendapatkan data rate.'], 500);
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

    // public function history(Request $request)
    // {
    //     $userId = $request->user_id;

    //     $withdraws = Withdraw::where('user_id', $userId)
    //         ->whereNotIn('status', ['un payment'])
    //         ->get();

    //     $topups = TopUp::where('user_id', $userId)
    //         ->whereNotIn('status', ['un payment'])
    //         ->get();

    //     $history = [];

    //     if (!$withdraws->isEmpty()) {
    //         $modifiedWithdraws = $withdraws->map(function ($withdraw) {
    //             $withdraw['type'] = 'Withdraw';
    //             return $withdraw;
    //         });

    //         $history = $modifiedWithdraws->toArray();
    //     }

    //     if (!$topups->isEmpty()) {
    //         $modifiedTopups = $topups->map(function ($topup) {
    //             $topup['type'] = 'Top-Up';
    //             return $topup;
    //         });

    //         $history = array_merge($history, $modifiedTopups->toArray());
    //     }

    //     if (empty($history)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No history found',
    //             'data' => null,
    //         ]);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'History retrieved successfully',
    //         'data' => $history,
    //     ]);
    // }

    public function history(Request $request, $userId)
    {
        $page = $request->query('page', 1);
        $limit = $request->query('limit', 10);

        $withdraws = Withdraw::where('user_id', $userId)
            ->whereNotIn('status', ['un payment'])
            ->get();

        $topups = TopUp::where('user_id', $userId)
            ->whereNotIn('status', ['un payment'])
            ->get();

        $modifiedWithdraws = $withdraws->map(function ($withdraw) {
            $withdraw['type'] = 'Withdraw';
            return $withdraw;
        });

        $modifiedTopups = $topups->map(function ($topup) {
            $topup['type'] = 'Top-Up';
            return $topup;
        });

        $history = $modifiedWithdraws->merge($modifiedTopups);

        $currentPage = Paginator::resolveCurrentPage('page');
        $items = $history->forPage($currentPage, $limit)->values();

        $paginatedHistory = new LengthAwarePaginator(
            $items,
            $history->count(),
            $limit,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        if ($paginatedHistory->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No history found',
                'data' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'History retrieved successfully',
            'data' => [
                'data' => $paginatedHistory->items(),
                'pagination' => [
                    'total' => $paginatedHistory->total(),
                    'per_page' => $paginatedHistory->perPage(),
                    'current_page' => $paginatedHistory->currentPage(),
                ],
            ],
        ]);
    }
}
