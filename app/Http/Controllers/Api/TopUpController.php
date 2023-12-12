<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
    //         'email' => 'required',
    //         'jumlah' => 'required',
    //         'total_pembayaran' => 'required',
    //         'nama_bank' => 'required',
    //         'kode_bank_client' => 'required',
    //         'nama' => 'required',
    //         'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }
    //     $image = $request->file('bukti_pembayaran');
    //     $imagePath = $image->store('bukti_pembayaran', 'public');


    //     $post = new TopUp();
    //     $post->email = $request->email;
    //     $post->jumlah = $request->jumlah;
    //     $post->total_pembayaran = $request->total_pembayaran;
    //     $post->nama_bank = $request->nama_bank;
    //     $post->kode_bank_client = $request->kode_bank_client;
    //     $post->nama = $request->nama;
    //     $post->bukti_pembayaran = $imagePath;

    //     // Set status secara otomatis
    //     $post->status = 'Pending';

    //     $post->tanggal = now();


    //     $post->save();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Berhasil memasukkan data'
    //     ]);
    // }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'rek_client' => 'required',
            'jumlah' => 'required',
            'total_pembayaran' => 'required',
            'nama_bank' => 'required',
            // 'kode_bank_client' => 'required',
            // 'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post = new TopUp();
        $post->user_id = $request->user_id;
        $post->rek_client = $request->rek_client;
        $post->jumlah = $request->jumlah;
        $post->total_pembayaran = $request->total_pembayaran;
        $post->nama_bank = $request->nama_bank;
        // $post->nama = $request->nama;

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

        // Update nama
        $payment_topup->update(['nama' => $request->nama]);

        if ($request->hasFile('bukti_pembayaran')) {
            // Hapus file bukti pembayaran yang sudah ada
            if ($payment_topup->bukti_pembayaran) {
                Storage::delete($payment_topup->bukti_pembayaran);
            }

            // Simpan bukti pembayaran yang baru
            $buktiPath = $request->file('bukti_pembayaran')->storeAs('bukti_pembayaran/topup', uniqid() . '.' . $request->file('bukti_pembayaran')->getClientOriginalExtension(), 'public');

            $buktiURL = URL::to('/') . Storage::url($buktiPath);

            // Update kolom bukti_pembayaran di database
            // Update bukti_pembayaran
            $payment_topup->update(['bukti_pembayaran' => $buktiURL, 'status' => 'Pending']);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil memasukkan bukti pembayaran.'
        ]);
    }
}
