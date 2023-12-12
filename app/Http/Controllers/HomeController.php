<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentMasterData;
use App\Models\RateMasterData;
use App\Models\TopUp;
use App\Models\Withdraw;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('/home');
        return abort(403);
    }

    // public function dashboard()
    // {
    //     return view('/login');
    //     return abort(403);
    // }

    public function payment()
    {
        $payment = Payment::all();

        return view('transactions.payment', ['payment' => $payment]);
    }
    public function topup()
    {
        $top_up = TopUp::all();

        return view('transactions.topup', ['top_up' => $top_up]);
    }
    public function withdraw()
    {
        $withdraw = Withdraw::all();

        return view('transactions.withdraw', ['withdraw' => $withdraw]);
    }

    public function wallet()
    {
        return view('wallet.wallet');
    }

    public function pay_md()
    {
        $payment_master_data = PaymentMasterData::all();

        return view('master_data.paymentmd', ['payment_master_data' => $payment_master_data]);
    }

    public function transactionmd()
    {
        $rate_master_data = RateMasterData::all();

        return view('master_data.transactionmd', ['rate_master_data' => $rate_master_data]);
    }

    public function rate()
    {
        $rate_master_data = RateMasterData::all();

        return view('settings.rate', ['rate_master_data' => $rate_master_data]);
    }

    public function cs_management()
    {
        return view('settings.cs_management');
    }
}
