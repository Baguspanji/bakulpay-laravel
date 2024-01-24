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

    public function edit_bankwd($id)
    {
        // Fetch the rate data based on the $id
        $bankwd = BankWd::find($id);

        // Return the view with the rate data
        return view('master_data.edit_bankwd', ['bankwd' => $bankwd]);
    }

    public function update_bankwd(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'nama_bank' => 'required',
            'icons' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $bankwd = BankWd::find($id);

        if ($bankwd) {
            if ($request->hasFile('icons')) {
                if ($bankwd->icons) {
                    Storage::delete($bankwd->icons);
                }

                $iconPath = $request->file('icons')->storeAs('bankwd/icons', uniqid() . '.' . $request->file('icons')->getClientOriginalExtension(), 'public');

                $iconURL = URL::to('/') . Storage::url($iconPath);

                $bankwd->update(['icons' => $iconURL]);
            }

            $bankwd->update([
                'nama_bank' => $request->input('nama_bank'),
            ]);

            $successMessage = 'Bank Withdraw updated successfully';

            return redirect()->route('bank_wd')->with([
                'success' => $successMessage,
                'iconURL' => isset($iconURL) ? $iconURL : null,
            ]);
        } else {
            return redirect()->route('master_data.edit_bankwd', ['id' => $id])->with('error', 'payment not found');
        }
    }

    
    public function activate_bankwd($id)
    {
        $bankWithdraw = BankWd::findOrFail($id);
        $bankWithdraw->active = 'false'; // Note: Use string 'true'
        $bankWithdraw->save();

        return redirect()->back()->with('success', 'Bank withdrawal activated successfully.');
    }

    public function deactivate_bankwd($id)
    {
        $bankWithdraw = BankWd::findOrFail($id);
        $bankWithdraw->active = 'true'; // Note: Use string 'false'
        $bankWithdraw->save();

        return redirect()->back()->with('success', 'Bank withdrawal deactivated successfully.');
    }

}
