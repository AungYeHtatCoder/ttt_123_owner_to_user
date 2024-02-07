<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Home\TransferLog;
use Illuminate\Http\Request;

class TransferLogController extends Controller
{
    public function index()
    {
        $logs = TransferLog::latest()->get();
        return view('admin.cash_requests.transferlog', compact('logs'));
    }
}
