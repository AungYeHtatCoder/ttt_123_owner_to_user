<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Home\CashInRequest;
use App\Models\Home\TransferLog;
use App\Models\User;
use Illuminate\Http\Request;

class CashInRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cashes = CashInRequest::latest()->get();
        return view('admin.cash_requests.cash_in', compact('cashes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function deposit(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
            'last_6_num' => 'required|max:6|min:6',
            'amount' => 'required|numeric',
            'phone' => 'required|numeric',
        ]);
        CashInRequest::create([
            'payment_method' => $request->payment_method,
            'last_6_num' => $request->last_6_num,
            'amount' => $request->amount,
            'phone' => $request->phone,
            'user_id' => auth()->user()->id,
        ]);
        TransferLog::create([
            'user_id' => auth()->user()->id,
            'amount' => $request->amount,
            'type' => 'Deposit',
            'created_by' => null
        ]);
        return redirect()->back()->with('success', 'Cash In Request Submitted Successfully');
    }

    public function show($id)
    {
        $cash = CashInRequest::find($id);
        return view('admin.cash_requests.cash_in_detail', compact('cash'));
    }

    public function accept($id)
    {
        $cash = CashInRequest::find($id);
        $amount = $cash->amount;
        User::where('id', $cash->user_id)->increment('balance', $amount);
        
        $cash->status = 1;
        $cash->save();

        $log = TransferLog::where('user_id', $cash->user_id)
        ->where('created_at', $cash->created_at)
        ->first();

        $log->update([
            'status' => 1,
            'created_by' => auth()->user()->id,
        ]);
        return redirect()->back()->with('success', 'Filled the cash into user successfully');
    }

    public function reject($id)
    {
        $cash = CashInRequest::find($id);
        $cash->status = 2;
        $cash->save();

        $log = TransferLog::where('user_id', $cash->user_id)
        ->where('created_at', $cash->created_at)
        ->first();

        $log->update([
            'status' => 2,
            'created_by' => auth()->user()->id,
        ]);
        return redirect()->back()->with('success', 'Filled the cash into user successfully');
    }

    // public function transfer(Request $request, $id)
    // {
    //     $request->validate([
    //         'amount' => 'required|numeric',
    //         'currency' => 'required|string'
    //     ]);
    //     $user = User::find($id);
    //     if($request->currency == 'kyat')
    //     {
    //         $user->balance += $request->amount;
    //         TransferLog::create([
    //             'user_id' => $user->id,
    //             'amount' => $request->amount,
    //             'status' => "deposit",
    //             'created_by' => auth()->user()->id,
    //         ]);
    //     }else{
    //         $rate = Currency::latest()->first()->rate;
    //         $user->balance += $request->amount * $rate;
    //         TransferLog::create([
    //             'user_id' => $user->id,
    //             'amount' => $request->amount * $rate,
    //             'status' => "deposit",
    //             'created_by' => auth()->user()->id,
    //         ]);
    //     }
    //     $user->save();
    //     return redirect()->back()->with('success', 'Transfered the cash into user successfully');
    // }
}
