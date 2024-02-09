<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Home\TransferLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferLogController extends Controller
{
    public function index()
    {
        $logs = TransferLog::latest()->get();
        return view('admin.cash_requests.transferlog', compact('logs'));
    }

    public function log()
    {
        $logs = TransferLog::where('user_id', Auth::user()->id)->latest()->get();
        return view('two_d.wallet.log', compact('logs'));
    }
}
