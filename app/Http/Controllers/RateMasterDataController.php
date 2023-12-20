<?php

namespace App\Http\Controllers;

use App\Models\RateMasterData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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

        $iconPath = $request->file('icons')->storeAs('rate/icons', uniqid() . '.' . $request->file('icons')->extension(), 'public');

        $iconURL = URL::to('/') . Storage::url($iconPath);

        $transactionMD = new RateMasterData();
        $transactionMD->nama_bank = $request->nama_bank;
        $transactionMD->type = $request->type;
        $transactionMD->icons = $iconURL; // Simpan URL gambar lengkap ke dalam kolom 'icons'
        $transactionMD->save();

        return redirect()->route('transactionmd')
            ->with('success', 'Data transaksi master berhasil ditambahkan!')
            ->with('iconURL', $iconURL);
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

    public function edit_transactionmd($id)
    {
        // Fetch the rate data based on the $id
        $rate = RateMasterData::find($id);

        // Return the view with the rate data
        return view('master_data.edit_transactionmd', ['rate' => $rate]);
    }

    public function update_transactionmd(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'nama_bank' => 'required',
            'type' => 'required',
            // 'icons' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk file gambar
            'icons' => 'required|file|max:2048',
        ]);

        $rate = RateMasterData::find($id);

        if ($rate) {
            if ($request->hasFile('icons')) {
                if ($rate->icons) {
                    Storage::delete($rate->icons);
                }

                $iconPath = $request->file('icons')->storeAs('rate/icons', uniqid() . '.' . $request->file('icons')->getClientOriginalExtension(), 'public');

                $iconURL = URL::to('/') . Storage::url($iconPath);

                $rate->update(['icons' => $iconURL]);
            }

            $rate->update([
                'nama_bank' => $request->input('nama_bank'),
                'type' => $request->input('type'),
            ]);

            $successMessage = 'Rate updated successfully';

            return redirect()->route('transactionmd')->with([
                'success' => $successMessage,
                'iconURL' => isset($iconURL) ? $iconURL : null,
            ]);
        } else {
            return redirect()->route('edit_transactionmd', ['id' => $id])->with('error', 'Rate not found');
        }
    }
}
