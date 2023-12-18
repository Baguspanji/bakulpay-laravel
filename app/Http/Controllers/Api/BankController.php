<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankWd;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BankController extends Controller
{

    public function BankWd()
    {
        $bank_wd = BankWd::all();
        return response()->json($bank_wd);
    }
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
            'logo_bank'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_bank'=>'required',
            'type_payment'=>'required|in:TopUp,withdraw',
            'price'=>'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(),422);
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
