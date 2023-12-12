<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

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
            'email' => 'required',
            'jumlah' => 'required',
            'total_pembayaran' => 'required',
            'nama_bank' => 'required',
            'kode_bank_client' => 'required',
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post = new TopUp();
        $post->user_id = $request->user_id;
        $post->email = $request->email;
        $post->jumlah = $request->jumlah;
        $post->total_pembayaran = $request->total_pembayaran;
        $post->nama_bank = $request->nama_bank;
        $post->kode_bank_client = $request->kode_bank_client;
        $post->nama = $request->nama;

        $post->status = 'Un Payment';

        $post->tanggal = now();

        $post->save();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil memasukkan data'
        ]);
    }
    
}
