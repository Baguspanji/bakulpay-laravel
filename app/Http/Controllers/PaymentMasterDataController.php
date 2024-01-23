<?php

namespace App\Http\Controllers;

use App\Models\PaymentMasterData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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

        $iconPath = $request->file('icons')->storeAs('payments/icons', uniqid() . '.' . $request->file('icons')->extension(), 'public');

        $iconURL = URL::to('/') . Storage::url($iconPath);

        $paymentMD = new PaymentMasterData();
        $paymentMD->nama_bank = $request->nama_bank;
        $paymentMD->no_rekening = $request->no_rekening;
        $paymentMD->nama = $request->nama;
        $paymentMD->icons = $iconURL;
        $paymentMD->save();

        return redirect()->route('pay_md')
            ->with('success', 'Data transaksi master berhasil ditambahkan!')
            ->with('iconURL', $iconURL);
    }

    public function edit_paymentmd($id)
    {
        // Fetch the rate data based on the $id
        $paymentMD = PaymentMasterData::find($id);

        // Return the view with the rate data
        return view('master_data.edit_paymentmd', ['paymentMD' => $paymentMD]);
    }

    public function update_paymentmd(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'nama_bank' => 'required',
            'no_rekening' => 'required',
            'nama' => 'required',
            'icons' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $paymentMD = PaymentMasterData::find($id);

        if ($paymentMD) {
            if ($request->hasFile('icons')) {
                if ($paymentMD->icons) {
                    Storage::delete($paymentMD->icons);
                }

                $iconPath = $request->file('icons')->storeAs('payments/icons', uniqid() . '.' . $request->file('icons')->getClientOriginalExtension(), 'public');

                $iconURL = URL::to('/') . Storage::url($iconPath);

                $paymentMD->update(['icons' => $iconURL]);
            }

            $paymentMD->update([
                'nama_bank' => $request->input('nama_bank'),
                'no_rekening' => $request->input('no_rekening'),
                'nama' => $request->input('nama'),
            ]);

            $successMessage = 'Payment updated successfully';

            return redirect()->route('pay_md')->with([
                'success' => $successMessage,
                'iconURL' => isset($iconURL) ? $iconURL : null,
            ]);
        } else {
            return redirect()->route('master_data.edit_paymentmd', ['id' => $id])->with('error', 'payment not found');
        }
    }

    public function activate($id)
    {
        $bankWithdraw = PaymentMasterData::findOrFail($id);
        $bankWithdraw->active = 'false'; // Note: Use string 'true'
        $bankWithdraw->save();

        return redirect()->back()->with('success', 'Bank withdrawal activated successfully.');
    }

    public function deactivate($id)
    {
        $bankWithdraw = PaymentMasterData::findOrFail($id);
        $bankWithdraw->active = 'true'; // Note: Use string 'false'
        $bankWithdraw->save();

        return redirect()->back()->with('success', 'Bank withdrawal deactivated successfully.');
    }
}
