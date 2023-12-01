<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Daftar;
use Illuminate\Http\Request;

class DaftarController extends Controller
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
        $dataDaftar = new Daftar;
        $dataDaftar->name = $request->name;
        $dataDaftar->username = $request->username;
        $dataDaftar->number_phone = $request->number_phone;
        $dataDaftar->email = $request->email;
        $dataDaftar->password = $request->password;

        $post = $dataDaftar->save();

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
