<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blockchain;
use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;


class TopUpController extends Controller
{

    public function index()
    {
        $top_up = TopUp::all();
        return response()->json($top_up);
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

    //     $post = new TopUp();
    //     $post->user_id = $request->user_id;
    //     $post->rek_client = $request->rek_client;
    //     $post->jumlah = $request->jumlah;
    //     $post->total_pembayaran = $request->total_pembayaran;
    //     $post->nama_bank = $request->nama_bank;
    //     $post->product = $request->product;
    //     $post->price_rate = $request->price_rate;
    //     // $post->nama = $request->nama;

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

        $post = new TopUp();
        $post->user_id = $request->user_id;
        $post->rek_client = $request->rek_client;
        $post->jumlah = $request->jumlah;
        $post->total_pembayaran = $request->total_pembayaran;
        $post->nama_bank = $request->nama_bank;
        $post->product = $request->product;
        $post->price_rate = $request->price_rate;
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


    public function payment_topup(Request $request, $id_pembayaran)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama' => 'required',
        ]);

        $payment_topup = TopUp::where('id_pembayaran', $id_pembayaran)->first();

        if (!$payment_topup) {
            return response()->json([
                'status' => false,
                'message' => 'TopUp tidak ditemukan.'
            ], 404);
        }

        $payment_topup->update(['nama' => $request->nama]);

        if ($request->hasFile('bukti_pembayaran')) {
            if ($payment_topup->bukti_pembayaran) {
                Storage::delete($payment_topup->bukti_pembayaran);
            }

            $buktiPath = $request->file('bukti_pembayaran')->storeAs('bukti_pembayaran/topup', uniqid() . '.' . $request->file('bukti_pembayaran')->getClientOriginalExtension(), 'public');

            $buktiURL = URL::to('/') . Storage::url($buktiPath);

            $payment_topup->update(['bukti_pembayaran' => $buktiURL, 'status' => 'Pending']);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil memasukkan bukti pembayaran.'
        ]);
    }

    public function edit_topup($id)
    {
        // Fetch the payment data based on the $id
        $topup = TopUp::find($id);


        if (!$topup) {
            return redirect()->route('topup')->with('error', 'Data not found');
        }

        return view('transactions.edit_topup', compact('topup'));
    }

    public function update_topup(Request $request)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $topup = TopUp::find($request->input('id'));

        if ($topup) {
            $data = [
                'status' => $request->input('status'),
            ];

            $topup->update($data);

            return redirect()->route('topup')->with('success', 'Data berhasil diperbarui');
        } else {
            return redirect()->route('edit_topup', ['id' => $request->input('id')])->with('error', 'Data tidak ditemukan');
        }
    }

    public function getPaymentDetails($id)
    {
        $topup = TopUp::find($id);
        if (!$topup) {
            return response()->json(['error' => 'Payment not found'], 404);
        }
        return response()->json([
            'id' => $topup->id,
            'user_id' => $topup->user_id,
            'id_pembayaran' => $topup->id_pembayaran,
            'date' => $topup->tanggal,
            'rek_client' => $topup->rek_client,
            'jumlah' => $topup->jumlah,
            'total_pembayaran' => $topup->total_pembayaran,
            'nama_bank' => $topup->nama_bank,
            'nama' => $topup->nama,
            'bukti_pembayaran' => $topup->bukti_pembayaran,
            'product' => $topup->product,
            'price_rate' => $topup->price_rate,
            'status' => $topup->status,
        ]);
    }
}
