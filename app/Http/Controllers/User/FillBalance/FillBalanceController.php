<?php

namespace App\Http\Controllers\User\FillBalance;

use App\Http\Controllers\Controller;
use App\Models\Admin\FillBalance;
use App\Models\Home\Bank;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FillBalanceController extends Controller
{
    public function index()
    {
        return view('two_d.wallet.index');
    }

    // top up wallet
    public function topUpWallet()
    {
        $banks = Bank::all();
        return view('two_d.wallet.top_up', compact('banks'));
    }
    // topup submit blade
    public function topUpSubmit($id)
    {
        $bank = Bank::find($id);
        return view('two_d.kpay.top_up_submit', compact('bank'));
    }


    public function withdrawBalance()
    {
        $banks = Bank::all();
        return view('two_d.wallet.with_draw_index', compact('banks'));
    }

    public function withdrawBank($id)
    {
        $bank = Bank::find($id);
        return view('two_d.kpay.withdraw', compact('bank'));
    }
    
}