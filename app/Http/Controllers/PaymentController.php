<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createFormPayment()
    {
        $payment = Payment::all();

        return view('transactions.form_payment', ['payment' => $payment]);
    }

    public function submitFormPay(Request $request)
    {
        // Validasi form
        $request->validate([
            'number_whatsapp' => 'required|string',
            'customer' => 'required|string',
            'tanggal' => 'required|string',
        ]);

        // Simpan data ke dalam model TransactionMD
        $payment = new Payment();
        $payment->number_whatsapp = $request->number_whatsapp;
        $payment->customer = $request->customer;
        $payment->tanggal = $request->tanggal;
        $payment->save();

        return redirect()->route('payment')
            ->with('success', 'Data transaksi master berhasil ditambahkan!');
    }

    public function edit_payment($id)
    {
        // Fetch the payment data based on the $id
        $payment = Payment::find($id);


        if (!$payment) {
            return redirect()->route('payment')->with('error', 'Data not found');
        }

        return view('transactions.edit_payment', compact('payment'));

        // Return the view with the payment data
        // return view('transactions.edit_payment', ['payment' => $payment]);
    }

    public function update_payment(Request $request)
    {
        $request->validate([
            'number_whatsapp' => 'required',
            'customer' => 'required',
            'tanggal' => 'required',
        ]);

        $payment = Payment::find($request->input('id'));

        if ($payment) {
            $data = [
                'number_whatsapp' => $request->input('number_whatsapp'),
                'customer' => $request->input('customer'),
                'tanggal' => $request->input('tanggal'),
            ];

            $payment->update($data);

            return redirect()->route('payment')->with('success', 'Data berhasil diperbarui');
        } else {
            return redirect()->route('edit_payment', ['id' => $request->input('id')])->with('error', 'Data tidak ditemukan');
        }
    }

    public function getPaymentDetails($id)
    {
        $payment = Payment::find($id);

        // Pastikan $payment tidak null atau handle jika null
        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        // Kembalikan data JSON
        return response()->json([
            'id' => $payment->id,
            'date' => $payment->tanggal,
            'number_whatsapp' => $payment->number_whatsapp,
            'customer' => $payment->customer,
            // tambahkan properti lain yang diperlukan
        ]);
    }
}
