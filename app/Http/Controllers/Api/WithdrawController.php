<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blockchain;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class WithdrawController extends Controller
{

    public function index()
    {
        $withdraw = Withdraw::all();
        return response()->json($withdraw);
    }

    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'user_id' => 'required',
    //         'product' => 'required',
    //         'price_rate' => 'required',
    //         'rek_client' => 'required',
    //         'jumlah' => 'required',
    //         'total_pembayaran' => 'required',
    //         'nama_bank' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }

    //     $post = new Withdraw();
    //     $post->user_id = $request->user_id;
    //     $post->product = $request->product;
    //     $post->price_rate = $request->price_rate;
    //     $post->rek_client = $request->rek_client;
    //     $post->jumlah = $request->jumlah;
    //     $post->total_pembayaran = $request->total_pembayaran;
    //     $post->nama_bank = $request->nama_bank;

    //     $post->status = 'Un Payment';

    //     $post->id_pembayaran = Str::random(10);

    //     $post->tanggal = now();

    //     $post->save();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Berhasil memasukkan data',
    //         'id_pembayaran' => $post->id_pembayaran,
    //     ]);
    // }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'product' => 'required',
            'price_rate' => 'required',
            'rek_client' => 'required',
            'jumlah' => 'required',
            'total_pembayaran' => 'required',
            'nama_bank' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Check if the product exists in the Blockchain table
        $productExistsInBlockchain = Blockchain::where('nama_bank', $request->product)->exists();

        if ($productExistsInBlockchain) {
            // Validate that nama_blockchain is present if product exists in Blockchain
            $validator = Validator::make($request->all(), [
                'nama_blockchain' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $namaBlockchain = $request->nama_blockchain;
        } else {
            // No need for nama_blockchain if product doesn't exist in Blockchain
            $namaBlockchain = null;
        }

        $post = new Withdraw();
        $post->user_id = $request->user_id;
        $post->product = $request->product;
        $post->price_rate = $request->price_rate;
        $post->rek_client = $request->rek_client;
        $post->jumlah = $request->jumlah;
        $post->total_pembayaran = $request->total_pembayaran;
        $post->nama_bank = $request->nama_bank;

        $post->status = 'Un Payment';

        $post->id_pembayaran = Str::random(10);

        $post->tanggal = now();
        // Set nama_blockchain based on the condition
        $post->nama_blockchain = $namaBlockchain;

        $post->save();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil memasukkan data',
            'id_pembayaran' => $post->id_pembayaran,
        ]);
    }

    // public function payment_withdraw(Request $request, $id_pembayaran)
    // {
    //     $request->validate([
    //         'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'nama' => 'required',
    //     ]);

    //     $payment_topup = Withdraw::where('id_pembayaran', $id_pembayaran)->first();

    //     if (!$payment_topup) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Withdraw tidak ditemukan.'
    //         ], 404);
    //     }

    //     $payment_topup->update(['nama' => $request->nama]);

    //     if ($request->hasFile('bukti_pembayaran')) {
    //         if ($payment_topup->bukti_pembayaran) {
    //             Storage::delete($payment_topup->bukti_pembayaran);
    //         }

    //         $buktiPath = $request->file('bukti_pembayaran')->storeAs('bukti_pembayaran/withdraw', uniqid() . '.' . $request->file('bukti_pembayaran')->getClientOriginalExtension(), 'public');

    //         $buktiURL = URL::to('/') . Storage::url($buktiPath);

    //         $payment_topup->update(['bukti_pembayaran' => $buktiURL, 'status' => 'Pending']);
    //     }

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Berhasil memasukkan bukti pembayaran.'
    //     ]);
    // }

    public function payment_withdraw(Request $request, $id_pembayaran)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama' => 'required',
        ]);

        // Menggunakan findOrFail untuk memastikan exception jika data tidak ditemukan
        $payment_topup = Withdraw::where('id_pembayaran', $id_pembayaran)->first();

        if (!$payment_topup) {
            return response()->json([
                'status' => false,
                'message' => 'TopUp tidak ditemukan.'
            ], 404);
        }


        // Menggunakan update langsung tanpa memeriksa ketersediaan data
        $payment_topup->update(['nama' => $request->nama]);

        if ($request->hasFile('bukti_pembayaran')) {
            if ($payment_topup->bukti_pembayaran) {
                Storage::delete($payment_topup->bukti_pembayaran);
            }

            $buktiPath = $request->file('bukti_pembayaran')->storeAs('bukti_pembayaran/withdraw', uniqid() . '.' . $request->file('bukti_pembayaran')->getClientOriginalExtension(), 'public');

            $buktiURL = URL::to('/') . Storage::url($buktiPath);

            $payment_topup->update(['bukti_pembayaran' => $buktiURL, 'status' => 'Pending']);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil memasukkan bukti pembayaran.'
        ]);
    }


    public function edit_withdraw($id)
    {
        // Fetch the payment data based on the $id
        $withdraw = Withdraw::find($id);


        if (!$withdraw) {
            return redirect()->route('withdraw')->with('error', 'Data not found');
        }

        return view('transactions.edit_withdraw', compact('withdraw'));
    }

    public function update_withdraw(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'bukti_tf' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $withdraw = Withdraw::find($request->input('id'));

        if ($withdraw) {
            $data = [
                'status' => $request->input('status'),
            ];

            // Handle file upload for bukti_tf
            if ($request->hasFile('bukti_tf')) {
                // Delete old bukti_tf if exists
                if ($withdraw->bukti_tf) {
                    Storage::delete($withdraw->bukti_tf);
                }

                $buktiPath = $request->file('bukti_tf')->storeAs('bukti_tf/withdraw', uniqid() . '.' . $request->file('bukti_tf')->getClientOriginalExtension(), 'public');

                $buktiURL = URL::to('/') . Storage::url($buktiPath);

                // Update the 'bukti_tf' column with the file URL
                $data['bukti_tf'] = $buktiURL;
            }

            // Update the withdraw data
            $withdraw->update($data);

            return redirect()->route('withdraw')->with('success', 'Data berhasil diperbarui');
        } else {
            return redirect()->route('edit_withdraw', ['id' => $request->input('id')])->with('error', 'Data tidak ditemukan');
        }
    }
}
