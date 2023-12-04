<?php

namespace App\Http\Controllers;

use App\Models\PaymentMasterData;
use Illuminate\Http\Request;

class PaymentMasterDataController extends Controller
{
    public function createFormPaymentMasterData()
    {
        $payment_master_data = PaymentMasterData::all();

        return view('master_data.form_paymentmd', ['payment_master_data' => $payment_master_data]);
    }

    public function submitForm(Request $request)
    {
        // Validasi form
        $request->validate([
            'nama_bank' => 'required|string',
            'no_rekening' => 'required|string',
            'nama' => 'required|string',
            'icons' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Penanganan penyimpanan file icons
        $iconPath = $request->file('icons')->store('icons', 'public');

        // Simpan data ke dalam model TransactionMD
        $paymentMD = new PaymentMasterData();
        $paymentMD->nama_bank = $request->nama_bank;
        $paymentMD->no_rekening = $request->no_rekening;
        $paymentMD->nama = $request->nama;
        $paymentMD->icons = $iconPath;
        $paymentMD->save();

        return redirect()->route('pay_md')
            ->with('success', 'Data transaksi master berhasil ditambahkan!');
    }

}
