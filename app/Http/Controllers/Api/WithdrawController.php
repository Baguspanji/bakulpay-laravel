<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        $post->save();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil memasukkan data',
            'id_pembayaran' => $post->id_pembayaran,
        ]);
    }

    public function payment_withdraw(Request $request, $id_pembayaran)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama' => 'required',
        ]);

        $payment_topup = Withdraw::where('id_pembayaran', $id_pembayaran)->first();

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

            $buktiPath = $request->file('bukti_pembayaran')->storeAs('bukti_pembayaran/withdraw', uniqid() . '.' . $request->file('bukti_pembayaran')->getClientOriginalExtension(), 'public');

            $buktiURL = URL::to('/') . Storage::url($buktiPath);

            $payment_topup->update(['bukti_pembayaran' => $buktiURL, 'status' => 'Pending']);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil memasukkan bukti pembayaran.'
        ]);
    }
}
