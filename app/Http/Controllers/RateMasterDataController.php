<?php

namespace App\Http\Controllers;

use App\Models\RateMasterData;
use Illuminate\Http\Request;

class RateMasterDataController extends Controller
{


    public function createFormRateMasterData()
    {
        $rate_master_data = RateMasterData::all();

        return view('master_data.form_transactionmd', ['rate_master_data' => $rate_master_data]);
    }

    public function submitForm(Request $request)
    {
        // Validasi form
        $request->validate([
            'nama_bank' => 'required|string',
            'type' => 'required|in:Top Up,Withdraw',
            'icons' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Penanganan penyimpanan file icons
        $iconPath = $request->file('icons')->store('icons', 'public');

        // Simpan data ke dalam model TransactionMD
        $transactionMD = new RateMasterData();
        $transactionMD->nama_bank = $request->nama_bank;
        $transactionMD->type = $request->type;
        $transactionMD->icons = $iconPath;
        $transactionMD->save();

        return redirect()->route('transactionmd')
            ->with('success', 'Data transaksi master berhasil ditambahkan!');
    }

    public function edit_rate($id)
    {
        // Fetch the rate data based on the $id
        $rate = RateMasterData::find($id);

        // Return the view with the rate data
        return view('settings.edit_rate', ['rate' => $rate]);
    }

    public function update_rate(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'price' => 'required|numeric', // Add any other validation rules you need
        ]);

        // Update the rate based on the provided ID
        $rate = RateMasterData::find($id);

        if ($rate) {
            $rate->update([
                'price' => $request->input('price'),
                // Update other fields as needed
            ]);

            // Redirect back or to a success page
            return redirect()->route('rate')->with('success', 'Rate updated successfully');
        } else {
            // Handle case where rate with the given ID is not found
            return redirect()->route('edit_rate')->with('error', 'Rate not found');
        }
    }

}
