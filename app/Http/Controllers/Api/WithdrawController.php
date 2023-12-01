<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class WithdrawController extends Controller
{
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
        $validator = Validator::make($request->all(),[
            'email'=>'required',
            'jumlah'=>'required',
            'total_pembayaran'=>'required',
            'bank'=>'required',
            'kode_bank'=>'required',
            'nama'=>'required',
            'bukti_pembayaran'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        $image = $request->file('bukti_pembayaran');
        $imagePath = $image->store('bukti_pembayaran', 'public');


        $post = new Withdraw();
        $post->email = $request->email;
        $post->jumlah = $request->jumlah;
        $post->total_pembayaran = $request->total_pembayaran;
        $post->bank = $request->bank;
        $post->kode_bank = $request->kode_bank;
        $post->nama = $request->nama;
        $post->bukti_pembayaran = $imagePath;


        $post->save();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil memasukkan data'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
