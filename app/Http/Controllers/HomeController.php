<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BankWd;
use App\Models\Payment;
use App\Models\PaymentMasterData;
use App\Models\RateMasterData;
use App\Models\TopUp;
use App\Models\Withdraw;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        // Calculate the date one month ago from today
        $lastMonth = Carbon::now()->subMonth();

        // Fetch new users registered in the last month
        $newUsersLastMonth = Admin::where('created_at', '>=', $lastMonth)->get();

        // Calculate the total count of new users
        $totalNewUsers = $newUsersLastMonth->count();

        // Fetch pending topup and withdraw records
        $pendingTopups = TopUp::where('status', 'pending')->get();
        $pendingWithdraws = Withdraw::where('status', 'pending')->get();

        // Fetch pending topup and withdraw records
        $statusTopups = TopUp::where('status', 'success')->get();
        $statusWithdraws = Withdraw::where('status', 'success')->get();

        // Calculate the total sum of total_pembayaran from both tables
        $totalPembayaran = $this->sumTotalPembayaran($statusTopups) + $this->sumTotalPembayaran($statusWithdraws);

        // Calculate total pending transactions
        $totalPending = $pendingTopups->count() + $pendingWithdraws->count();

        // Pass the data to the view
        return view('home', [
            'pendingTopups' => $pendingTopups,
            'pendingWithdraws' => $pendingWithdraws,
            'totalPembayaran' => $totalPembayaran,
            'totalPending' => $totalPending,
            'totalNewUsers' => $totalNewUsers,
        ]);
    }

    private function sumTotalPembayaran($items)
    {
        // Calculate the sum of total_pembayaran from the given items
        return $items->sum(function ($item) {
            // Extract the numeric part from the string (assuming it's always in the format "Rp.xxx")
            $numericPart = filter_var($item->total_pembayaran, FILTER_SANITIZE_NUMBER_INT);

            // Convert the string to a numeric value
            return intval($numericPart);
        });
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

    public function bankwd()
    {
        $bank_wd_data = BankWd::all();

        return view('master_data.bank_wd', ['bank_wd_data' => $bank_wd_data]);
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
