<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function activate($id)
    {
        $bankWithdraw = Admin::findOrFail($id);
        $bankWithdraw->active = 'false'; // Note: Use string 'true'
        $bankWithdraw->save();

        return redirect()->back()->with('success', 'Bank withdrawal activated successfully.');
    }

    public function deactivate($id)
    {
        $bankWithdraw = Admin::findOrFail($id);
        $bankWithdraw->active = 'true'; // Note: Use string 'false'
        $bankWithdraw->save();

        return redirect()->back()->with('success', 'Bank withdrawal deactivated successfully.');
    }
}
