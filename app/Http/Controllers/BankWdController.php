<?php

namespace App\Http\Controllers;

use App\Models\BankWd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class BankWdController extends Controller
{
    public function createFormBankWd()
    {
        $bank_wd_data = BankWd::all();

        return view('master_data.form_bankwd', ['bank_wd_data' => $bank_wd_data]);
    }

    public function submitForm(Request $request)
    {
        // Validasi form
        $request->validate([
            'nama_bank' => 'required|string',
            'icons' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $iconPath = $request->file('icons')->storeAs('bankwd/icons', uniqid() . '.' . $request->file('icons')->extension(), 'public');

        $iconURL = URL::to('/') . Storage::url($iconPath);

        $paymentMD = new BankWd();
        $paymentMD->nama_bank = $request->nama_bank;
        $paymentMD->icons = $iconURL;
        $paymentMD->save();

        return redirect()->route('bank_wd')
            ->with('success', 'Data transaksi master berhasil ditambahkan!')
            ->with('iconURL', $iconURL);
    }
}
