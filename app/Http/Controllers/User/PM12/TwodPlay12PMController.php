<?php

namespace App\Http\Controllers\User\PM12;

use App\Models\Lottery;
use App\Models\RoleLimit;
use Illuminate\Http\Request;
use App\Models\Admin\TwoDigit;
use App\Models\Admin\HeadDigit;
use App\Models\Admin\TwoDLimit;
use App\Models\Admin\LotteryMatch;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\CloseTwoDigit;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\LotteryTwoDigitPivot;
use Illuminate\Support\Facades\Auth;
use App\Models\LotteryTwoDigitOverLimit;

class TwodPlay12PMController extends Controller
{
    public function index()
    {
        $twoDigits = TwoDigit::all();

    // Calculate remaining amounts for each two-digit
    $remainingAmounts = [];
    foreach ($twoDigits as $digit) {
        $totalBetAmountForTwoDigit = DB::table('lottery_two_digit_copy')
            ->where('two_digit_id', $digit->id)
            ->sum('sub_amount');

        $remainingAmounts[$digit->id] = 50000 - $totalBetAmountForTwoDigit; // Assuming 5000 is the session limit
    }
    $lottery_matches = LotteryMatch::where('id', 1)->whereNotNull('is_active')->first();

    return view('two_d.12_pm.index', compact('twoDigits', 'remainingAmounts', 'lottery_matches'));
    }

    public function play_confirm()
    {
        $twoDigits = TwoDigit::all();

    // Calculate remaining amounts for each two-digit
    $remainingAmounts = [];
    foreach ($twoDigits as $digit) {
        $totalBetAmountForTwoDigit = DB::table('lottery_two_digit_copy')
            ->where('two_digit_id', $digit->id)
            ->sum('sub_amount');

        $remainingAmounts[$digit->id] = 50000 - $totalBetAmountForTwoDigit; // Assuming 5000 is the session limit
    }
    $lottery_matches = LotteryMatch::where('id', 1)->whereNotNull('is_active')->first();

    return view('two_d.12_pm.play_confirm', compact('twoDigits', 'remainingAmounts', 'lottery_matches'));
    } 

    public function store(Request $request)
    {
        //dd($request->all());
        //Log::info($request->all());
        $validatedData = $request->validate([
            'selected_digits' => 'required|string',
            'amounts' => 'required|array',
            'amounts.*' => 'required|integer|min:1',
            'totalAmount' => 'required|numeric|min:1',
            'user_id' => 'required|exists:users,id',
        ]);

        // Fetch all head digits not allowed
         $headDigitsNotAllowed = HeadDigit::pluck('digit_one', 'digit_two', 'digit_three')->flatten()->unique()->toArray();

    // Check if any selected digit starts with the head digits not allowed
    foreach ($request->amounts as $two_digit_string => $sub_amount) {
        $headDigitOfSelected = substr($two_digit_string, 0, 1); // Extract the head digit
        if (in_array($headDigitOfSelected, $headDigitsNotAllowed)) {
            session()->flash('SuccessRequest', " ထိပ်ဂဏန်း - '{$headDigitOfSelected}' - ကိုပိတ်ထားသောကြောင့် ကံစမ်း၍ မရနိုင်ပါ ၊ ကျေးဇူးပြု၍ ဂဏန်းပြန်ရွှေးချယ်ပါ။");
            return redirect()->back()->with('error', "Bets on numbers starting with '{$headDigitOfSelected}' are not allowed.");
        }
    }

         
            $closedDigits = CloseTwoDigit::all()->pluck('digit')->map(function ($digit) {
                return sprintf('%02d', $digit);
            })->toArray();

    // Iterate over submitted bets
    foreach ($request->input('amounts') as $bet => $amount) {
        $betDigit = sprintf('%02d', $bet); // Format the bet number

        // Check if the bet is on a closed digit
        if (in_array($betDigit, $closedDigits)) {
            session()->flash('SuccessRequest', "2D -'{$betDigit}' -ဂဏန်းကိုပိတ်ထားသောကြောင့် ကံစမ်း၍ မရနိုင်ပါ ၊ ကျေးဇူးပြု၍ ဂဏန်းပြန်ရွှေးချယ်ပါ။");

            return redirect()->back()->with('error', "Bets on number '{$betDigit}' are not allowed.");
        }
    }
        $currentSession = $this->determineSession();
        $user = Auth::user();

        // Initialize default limit
        $defaultLimitAmount = TwoDLimit::latest()->first()->two_d_limit;
        
        // Adjust limit based on the user's role
        $userRole = $user->roles()->first();
        $roleLimitAmount = optional(RoleLimit::where('role_id', $userRole->id)->first())->limit ?? $defaultLimitAmount;
        $limitAmount = max($defaultLimitAmount, $roleLimitAmount);

        DB::beginTransaction();
        try {
            $user->decrement('balance', $request->totalAmount);

            $lottery = Lottery::create([
                'pay_amount' => $request->totalAmount,
                'total_amount' => $request->totalAmount,
                'user_id' => $user->id,
                'session' => $currentSession,
            ]);

            foreach ($request->amounts as $two_digit_string => $sub_amount) {
                $this->processBet($two_digit_string, $sub_amount, $limitAmount, $lottery);
            }

            DB::commit();
            // session()->flash('SuccessRequest', 'Successfully placed bet.');
            // return redirect()->route('user.two-digit-user-data.afternoon')->with('success', 'အောင်မြင်ပါသည်။');
            session()->flash('SuccessRequest', 'Successfully placed bet.');
            return redirect()->route('home')->with('message', 'Data stored successfully!');
            //return redirect()->back()->with('message', 'Bet placed successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in store method: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    

    private function determineSession()
    {
        $currentTime = date('H:i');
        return ($currentTime >= '06:30' && $currentTime < '12:00') ? 'morning' : 'evening';
    }

    private function determineLimitAmount($user)
    {
        $defaultLimitAmount = TwoDLimit::latest()->first()->two_d_limit;
        $role = $user->roles()->first();
        $roleLimitAmount = optional(RoleLimit::where('role_id', $role->id)->first())->limit ?? $defaultLimitAmount;
        return max($defaultLimitAmount, $roleLimitAmount);
    }

    private function createLotteryRecord($request, $currentSession)
    {
        return Lottery::create([
            'pay_amount' => $request->totalAmount,
            'total_amount' => $request->totalAmount,
            'user_id' => $request->user_id,
            'session' => $currentSession,
        ]);
    }

    // new logic 
    private function processBet($betDigit, $subAmount, $limitAmount, $lottery)
{
    // Assuming $betDigit comes directly from the user input and represents the two-digit number they're betting on
    $twoDigit = TwoDigit::where('two_digit', sprintf('%02d', $betDigit))->first();

    if (!$twoDigit) {
        // Optionally handle the case where the two-digit number doesn't exist in the database
        throw new \Exception("Invalid bet digit: {$betDigit}");
    }

    $totalBetAmount = DB::table('lottery_two_digit_copy')->where('two_digit_id', $twoDigit->id)->sum('sub_amount');

    if ($totalBetAmount + $subAmount > $limitAmount) {
        throw new \Exception('The betting limit has been reached.');
    }

    LotteryTwoDigitPivot::create([
        'lottery_id' => $lottery->id,
        'two_digit_id' => $twoDigit->id,
        'bet_digit' => $betDigit, // Assuming bet_digit is a string representation of the bet
        'sub_amount' => $subAmount,
        'prize_sent' => false,
    ]);
}

    //     public function store(Request $request)
    // {
        
    //     Log::info($request->all());
    //     $validatedData = $request->validate([
    //         'selected_digits' => 'required|string',
    //         'amounts' => 'required|array',
    //         'amounts.*' => 'required|integer|min:100|max:50000',
    //         //'totalAmount' => 'required|integer|min:100',
    //         'totalAmount' => 'required|numeric|min:100', // Changed from integer to numeric
    //         'user_id' => 'required|exists:users,id',
    //     ]);

    //     $currentSession = date('H') < 12 ? 'morning' : 'evening';
    //     $limitAmount = 50000; // Define the limit amount

    //     DB::beginTransaction();

    //     try {

    //         $user = Auth::user();
    //         $user->balance -= $request->totalAmount;

    //         if ($user->balance < 0) {
    //             throw new \Exception('Insufficient balance.');
    //         }
    //         $user->save();

    //         $lottery = Lottery::create([
    //             'pay_amount' => $request->totalAmount,
    //             'total_amount' => $request->totalAmount,
    //             'user_id' => $request->user_id,
    //             'session' => $currentSession
    //         ]);

    //         foreach ($request->amounts as $two_digit_string => $sub_amount) {
    //             $two_digit_id = $two_digit_string === '00' ? 1 : intval($two_digit_string, 10) + 1;

    //             $totalBetAmountForTwoDigit = DB::table('lottery_two_digit_copy')
    //                 ->where('two_digit_id', $two_digit_id)
    //                 ->sum('sub_amount');

    //             if ($totalBetAmountForTwoDigit + $sub_amount <= $limitAmount) {
    //                 $pivot = new LotteryTwoDigitPivot([
    //                     'lottery_id' => $lottery->id,
    //                     'two_digit_id' => $two_digit_id,
    //                     'sub_amount' => $sub_amount,
    //                     'prize_sent' => false
    //                 ]);
    //                 $pivot->save();
    //             } else {
    //                 $withinLimit = $limitAmount - $totalBetAmountForTwoDigit;
    //                 $overLimit = $sub_amount - $withinLimit;

    //                 if ($withinLimit > 0) {
    //                     $pivotWithin = new LotteryTwoDigitPivot([
    //                         'lottery_id' => $lottery->id,
    //                         'two_digit_id' => $two_digit_id,
    //                         'sub_amount' => $withinLimit,
    //                         'prize_sent' => false
    //                     ]);
    //                     $pivotWithin->save();
    //                 }

    //                 if ($overLimit > 0) {
    //                     $pivotOver = new LotteryTwoDigitOverLimit([
    //                         'lottery_id' => $lottery->id,
    //                         'two_digit_id' => $two_digit_id,
    //                         'sub_amount' => $overLimit,
    //                         'prize_sent' => false
    //                     ]);
    //                     $pivotOver->save();
    //                 }
    //             }
    //         }

    //         DB::commit();
    //         session()->flash('SuccessRequest', 'Successfully placed bet.');
    //         return redirect()->route('home')->with('message', 'Data stored successfully!');
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         Log::error('Error in store method: ' . $e->getMessage());
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }

}