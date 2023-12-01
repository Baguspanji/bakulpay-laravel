<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('/home');
        return abort(403);
    }

    public function payment()
    {
        return view('transactions.payment');
    }
    public function topup()
    {
        return view('transactions.topup');
    }
    public function withdraw()
    {
        return view('transactions.withdraw');
    }

    public function wallet()
    {
        return view('wallet.wallet');
    }

    public function pay_md()
    {
        return view('master_data.paymentmd');
    }

    public function transactionmd()
    {
        return view('master_data.transactionmd');
    }

    public function rate()
    {
        return view('settings.rate');
    }

    public function cs_management()
    {
        return view('settings.cs_management');
    }
}
