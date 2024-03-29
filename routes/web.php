<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PlayTwoDController;
use App\Http\Controllers\Admin\TwoDigitController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\TwoDLimitController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\TwoDWinnerController;
use App\Http\Controllers\Home\TransferLogController;
use App\Http\Controllers\Admin\ThreeDLimitController;
use App\Http\Controllers\Admin\TwoDLotteryController;
use App\Http\Controllers\Admin\TwoDMorningController;
use App\Http\Controllers\Home\CashInRequestController;
use App\Http\Controllers\Admin\ThreedHistoryController;
use App\Http\Controllers\Home\CashOutRequestController;
use App\Http\Controllers\Admin\TwoD\DataLejarController;
use App\Http\Controllers\Admin\TwoD\TwoDLagarController;
use App\Http\Controllers\Admin\ThreedMatchTimeController;
use App\Http\Controllers\Admin\FillBalanceReplyController;
use App\Http\Controllers\User\Threed\ThreeDPlayController;
use App\Http\Controllers\Admin\ThreeD\ThreeDCloseController;
use App\Http\Controllers\Admin\ThreeD\ThreeDLegarController;
use App\Http\Controllers\Admin\TwoD\CloseTwoDigitController;
use App\Http\Controllers\Admin\TwoD\TwodRoleLimitController;
use App\Http\Controllers\Admin\TwoD\HeadDigitCloseController;
use App\Http\Controllers\Admin\ThreeD\DailyThreeDIncomeOutComeController;


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [App\Http\Controllers\User\WelcomeController::class, 'index'])->name('welcome');

//auth routes
Route::get('/login', [App\Http\Controllers\User\WelcomeController::class, 'userLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\User\WelcomeController::class, 'login'])->name('login');
Route::post('/register', [App\Http\Controllers\User\WelcomeController::class, 'register'])->name('register');
Route::get('/register', [App\Http\Controllers\User\WelcomeController::class, 'userRegister'])->name('register');
//auth routes

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth']], function () {

  // Permissions
  Route::delete('permissions/destroy', [PermissionController::class, 'massDestroy'])->name('permissions.massDestroy');
  Route::resource('permissions', PermissionController::class);
  // Roles
  Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
  Route::resource('roles', RolesController::class);
  // Users
  Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
  Route::resource('users', UsersController::class);
  Route::get('/two-d-users', [App\Http\Controllers\Admin\TwoUsersController::class, 'index'])->name('two-d-users-index');
  // details route
  Route::get('/two-d-users/{id}', [App\Http\Controllers\Admin\TwoUsersController::class, 'show'])->name('two-d-users-details');
  //Banners
  Route::resource('banners', BannerController::class);
  //promotions
  Route::resource('/promotions', PromotionController::class);
  Route::resource('/banks', BankController::class);

  // profile resource rotues
  Route::resource('profiles', ProfileController::class);
  // admin update balance route
  Route::put('/super-admin-update-balance/{id}', [App\Http\Controllers\Admin\ProfileController::class, 'AdminUpdateBalance'])->name('admin-update-balance');
  // user profile route get method
  Route::put('/change-password', [ProfileController::class, 'newPassword'])->name('changePassword');
  // PhoneAddressChange route with auth id route with put method
  Route::put('/change-phone-address', [ProfileController::class, 'PhoneAddressChange'])->name('changePhoneAddress');
  Route::put('/change-kpay-no', [ProfileController::class, 'KpayNoChange'])->name('changeKpayNo');
  Route::put('/change-join-date', [ProfileController::class, 'JoinDate'])->name('addJoinDate');
  // two d commission route
    Route::get('/two-d-commission', [App\Http\Controllers\Admin\Commission\TwoDCommissionController::class, 'getTwoDTotalAmountPerUser'])->name('two-d-commission'); 

    // show details
    Route::get('/two-d-commission-show/{id}', [App\Http\Controllers\Admin\Commission\TwoDCommissionController::class, 'show'])->name('two-d-commission-show');
    Route::put('/two-d-commission-update/{id}', [App\Http\Controllers\Admin\Commission\TwoDCommissionController::class, 'update'])->name('two-d-commission-update');
    // commission update
   Route::post('two-d-transfer-commission/{id}', [App\Http\Controllers\Admin\Commission\TwoDCommissionController::class, 'TwoDtransferCommission'])->name('two-d-transfer-commission');
    
    // three d commission route
    Route::get('/three-d-commission', [App\Http\Controllers\Admin\Commission\ThreeDCommissionController::class, 'getThreeDTotalAmountPerUser'])->name('three-d-commission');
    // show details 
    Route::get('/three-d-commission-show/{id}', [App\Http\Controllers\Admin\Commission\ThreeDCommissionController::class, 'show'])->name('three-d-commission-show');
    // three_d_commission_update
    Route::put('/three-d-commission-update/{id}', [App\Http\Controllers\Admin\Commission\ThreeDCommissionController::class, 'update'])->name('three-d-commission-update');
    // transfer commission route
    Route::post('/three-d-transfer-commission/{id}', [App\Http\Controllers\Admin\Commission\ThreeDCommissionController::class, 'ThreeDtransferCommission'])->name('three-d-transfer-commission');
    // show transfer commission

  Route::resource('role-limits', TwodRoleLimitController::class);
    Route::resource('/two-digit-limit', TwoDLimitController::class);

    Route::resource('/three-digit-limit', ThreeDLimitController::class);

  // two digit close 
    Route::resource('two-digit-close', CloseTwoDigitController::class);
    Route::resource('head-digit-close', HeadDigitCloseController::class);

    // morning - lajar 
    Route::get('/morning-lajar', [TwoDLagarController::class, 'showData'])->name('morning-lajar');
    // two digit data
    Route::get('/two-digit-lejar-data', [DataLejarController::class, 'showData'])->name('two-digit-lejar-data');

    // morning - lajar 
    Route::get('/evening-lajar', [TwoDLagarController::class, 'showDataEvening'])->name('evening-lajar');
    // two digit data
    Route::get('/evening-two-digit-lejar-data', [DataLejarController::class, 'showDataEvening'])->name('evening-two-digit-lejar-data');
    // three digit close
    Route::resource('three-digit-close', ThreeDCloseController::class);
    // three digit legar
    Route::get('/three-digit-lejar', [ThreeDLegarController::class, 'showData'])->name('three-digit-lejar');
    
  Route::resource('play-twod', PlayTwoDController::class);
  Route::get('/get-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'GetTwoDigit'])->name('GetTwoDigit');
  Route::post('lotteries-two-d-play', [TwoDigitController::class, 'store'])->name('StorePlayTwoD');
  Route::get('/morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'MorningPlayTwoDigit'])->name('MorningPlayTwoDigit');

  Route::get('/evening-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'EveningPlayTwoDigit'])->name('EveningPlayTwoDigit');

  Route::post('lotteries-two-d-play', [TwoDigitController::class, 'store'])->name('StorePlayTwoD');

  Route::get('/get-three-d', [App\Http\Controllers\Admin\ThreeDPlayController::class, 'GetThreeDigit'])->name('GetThreeDigit');
  Route::get('/three-d-play', [App\Http\Controllers\Admin\ThreeDPlayController::class, 'ThreeDigitPlay'])->name('ThreeDigitPlay');
  Route::get('/three-d-play-confirm', [App\Http\Controllers\Admin\ThreeDPlayController::class, 'ThreeDigitPlayConfirm'])->name('ThreeDigitPlayConfirm');
  Route::get('/three-d-play-confirm-api-format', [App\Http\Controllers\Admin\ThreeDPlayController::class, 'ThreeDigitPlayConfirmApi'])->name('ThreeDigitPlayConfirmApi');
  Route::post('/three-digit-play-confirm', [App\Http\Controllers\Admin\ThreeDigitPlayController::class, 'ThreeDigitPlaystore'])->name('ThreeDigitPlaystore');
  Route::post('/two-d-play', [App\Http\Controllers\Admin\TwoDPlayController::class, 'store'])->name('two-d-play.store');

  Route::get('/quick-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickMorningPlayTwoDigit'])->name('QuickMorningPlayTwoDigit');
  Route::get('/quick-odd-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickOddMorningPlayTwoDigit'])->name('QuickOddMorningPlayTwoDigit');
  Route::get('/quick-even-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickEvenMorningPlayTwoDigit'])->name('QuickEvenMorningPlayTwoDigit');

  Route::get('/quick-odd-same-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickOddSameMorningPlayTwoDigit'])->name('QuickOddSameMorningPlayTwoDigit');

  Route::get('/quick-even-same-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickEvenSameMorningPlayTwoDigit'])->name('QuickEvenSameMorningPlayTwoDigit');
  Route::post('/quick-two-d-play', [App\Http\Controllers\Admin\TwoDPlayController::class, 'Quickstore'])->name('Quickstore');
  Route::get('/two-d-play-noti', [App\Http\Controllers\Admin\GetNotificationTwoDPlayUserController::class, 'index'])->name('two-d-play-noti');
  Route::post('/two-d-play-noti-mark-as-read', [App\Http\Controllers\Admin\GetNotificationTwoDPlayUserController::class, 'playTwoDmarkNotification'])->name('playTwoDmarkNotification');

  Route::get('/get-two-d-session-reset', [App\Http\Controllers\Admin\SessionResetControlller::class, 'index'])->name('SessionResetIndex');
  Route::post('/two-d-session-reset', [App\Http\Controllers\Admin\SessionResetControlller::class, 'SessionReset'])->name('SessionReset');
  Route::get('/close-two-d', [App\Http\Controllers\Admin\CloseTwodController::class, 'index'])->name('CloseTwoD');
  Route::put('/update-open-close-two-d', [App\Http\Controllers\Admin\CloseTwodController::class, 'update'])->name('OpenCloseTwoD');
  Route::resource('twod-records', TwoDLotteryController::class);
  Route::resource('tow-d-win-number', TwoDWinnerController::class);
  Route::resource('tow-d-morning-number', TwoDMorningController::class);
  // two d get early morning number
  Route::get('/get-two-d-early-morning-number', [App\Http\Controllers\Admin\TwoDMorningController::class, 'GetDigitEarlMorningindex'])->name('earlymorningNumber');
  Route::get('/get-two-d-early-evening-number', [App\Http\Controllers\Admin\TwoDMorningController::class, 'GetDigitEarlyEveningindex'])->name('earlyeveningNumber');

  // two d get early morning number over amount limit
  Route::get('/get-two-d-early-morning-number-over-amount-limit', [App\Http\Controllers\Admin\TwoDMorningController::class, 'GetDigitEarlyMorningOverAmountLimitindex'])->name('earlymorningNumberOverAmountLimit');
  // two d get 12:1 morning number over amount limit
  Route::get('/get-two-d-morning-number-over-amount-limit', [App\Http\Controllers\Admin\TwoDMorningController::class, 'GetDigitMorningOverAmountLimitindex'])->name('morningNumberOverAmountLimit');
  // two d get 2 early evening number over amount limit
  Route::get('/get-two-d-early-evening-number-over-amount-limit', [App\Http\Controllers\Admin\TwoDMorningController::class, 'GetDigitEarlyEveningOverAmountLimitindex'])->name('earlyeveningNumberOverAmountLimit');
  // two d get 4:30 evening number over amount limit
  Route::get('/get-two-d-evening-number-over-amount-limit', [App\Http\Controllers\Admin\TwoDMorningController::class, 'GetDigitEveningOverAmountLimitindex'])->name('eveningNumberOverAmountLimit');

  // early morning winner
  Route::get('/two-d-early-morning-winner', [App\Http\Controllers\Admin\TwoDMorningWinnerController::class, 'TwoDEarlyMorningWinner'])->name('earlymorningWinner');
  Route::get('/two-d-morning-winner', [App\Http\Controllers\Admin\TwoDMorningWinnerController::class, 'TwoDMorningWinner'])->name('morningWinner');
  Route::get('/two-d-evening-number', [App\Http\Controllers\Admin\TwoDMorningController::class, 'EveningTwoD'])->name('eveningNumber');

  Route::get('/two-d-early-evening-winner', [App\Http\Controllers\Admin\TwoDMorningController::class, 'TwoDEarlyEveningWinner'])->name('earlyeveningWinner');

  Route::get('/two-d-evening-winner', [App\Http\Controllers\Admin\TwoDMorningController::class, 'TwoDEveningWinner'])->name('eveningWinner');
  Route::get('/two-d-evening-winner', [App\Http\Controllers\Admin\TwoDEveningWinnerController::class, 'TwoDEveningWinner'])->name('eveningWinner');
  Route::get('profile/fill_money', [ProfileController::class, 'fillmoney']);
  // kpay fill money get route
  Route::get('profile/kpay_fill_money', [ProfileController::class, 'index'])->name('kpay_fill_money');
  Route::resource('fill-balance-replies', FillBalanceReplyController::class);
  Route::get('/daily-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmounts'])->name('dailyIncomeJson');
  Route::get('/with-draw-view', [App\Http\Controllers\Admin\WithDrawViewController::class, 'index'])->name('withdrawViewGet');
  Route::get('/with-draw-details/{id}', [App\Http\Controllers\Admin\WithDrawViewController::class, 'show'])->name('withdrawViewDetails');
  // withdraw update route
  Route::put('/with-draw-update/{id}', [App\Http\Controllers\Admin\WithDrawViewController::class, 'update'])->name('withdrawViewUpdate');
  Route::get('/daily-with-name-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmountsDaily'])->name('getTotalAmountsDaily');
  // week name route
  Route::get('/weekly-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmountsWeekly'])->name('getTotalAmountsWeekly');
  // month name route
  Route::get('/month-with-name-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmountsMonthly'])->name('getTotalAmountsMonthly');
  // year name route
  Route::get('/yearly-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmountsYearly'])->name('getTotalAmountsYearly');

  // 3d lottery routes
  // 3d daily income
  Route::get('/threed-lotteries-daily-income', [DailyThreeDIncomeOutComeController::class, 'getTotalAmountsDaily']);
  // 3d daily income weekly
  Route::get('/threed-lotteries-daily-income-money', [DailyThreeDIncomeOutComeController::class, 'getTotalAmounts']);

  // 3d daily income monthly
  Route::get('/threed-lotteries-daily-income-monthly', [DailyThreeDIncomeOutComeController::class, 'getTotalAmountsMonthly']);

  Route::get('/threed-lotteries-match-time', [ThreedMatchTimeController::class, 'index']);
  // 3d prize number create
  Route::get('/three-d-prize-number-create', [App\Http\Controllers\Admin\ThreeD\ThreeDPrizeNumberCreateController::class, 'index'])->name('three-d-prize-number-create');
  Route::post('/three-d-prize-number-create', [App\Http\Controllers\Admin\ThreeD\ThreeDPrizeNumberCreateController::class, 'store'])->name('three-d-prize-number-create.store');

  // 3d history
  Route::get('/three-d-history', [App\Http\Controllers\Admin\ThreeD\ThreeDRecordHistoryController::class, 'index'])->name('three-d-history');
  // 3d history show
  Route::get('/three-d-history-show/{id}', [App\Http\Controllers\Admin\ThreeD\ThreeDRecordHistoryController::class, 'show'])->name('three-d-history-show');
  // three d list index
  Route::get('/three-d-list-index', [App\Http\Controllers\Admin\ThreeD\ThreeDListController::class, 'index'])->name('three-d-list-index');
  // three d list show
  Route::get('/three-d-list-show/{id}', [App\Http\Controllers\Admin\ThreeD\ThreeDListController::class, 'show'])->name('three-d-list-show');
  // 3d winner list
  Route::get('/three-d-winner', [App\Http\Controllers\Admin\ThreeD\ThreeDWinnerController::class, 'index'])->name('three-d-winner');
  // three d winner history 
    Route::get('/three-d-winner-history', [App\Http\Controllers\Admin\ThreeD\ThreeDWinnerController::class, 'getWinnersHistoryForAdmin'])->name('ThreeDWinnersHistory');

    // Permissions
    Route::delete('permissions/destroy', [PermissionController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', PermissionController::class);
    // Roles
    Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', RolesController::class);
    // Users
    Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
    Route::resource('users', UsersController::class);
    Route::get('/two-d-users', [App\Http\Controllers\Admin\TwoUsersController::class, 'index'])->name('two-d-users-index');
    // details route
    Route::get('/two-d-users/{id}', [App\Http\Controllers\Admin\TwoUsersController::class, 'show'])->name('two-d-users-details');
    //Banners
    Route::resource('banners', BannerController::class);
    // profile resource rotues
    Route::resource('profiles', ProfileController::class);
    // user profile route get method
    Route::put('/change-password', [ProfileController::class, 'newPassword'])->name('changePassword');
    // PhoneAddressChange route with auth id route with put method
    Route::put('/change-phone-address', [ProfileController::class, 'PhoneAddressChange'])->name('changePhoneAddress');
    Route::put('/change-kpay-no', [ProfileController::class, 'KpayNoChange'])->name('changeKpayNo');
    Route::put('/change-join-date', [ProfileController::class, 'JoinDate'])->name('addJoinDate');
    Route::resource('play-twod', PlayTwoDController::class);
    Route::get('/get-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'GetTwoDigit'])->name('GetTwoDigit');
    Route::post('lotteries-two-d-play', [TwoDigitController::class, 'store'])->name('StorePlayTwoD');
    Route::get('/morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'MorningPlayTwoDigit'])->name('MorningPlayTwoDigit');

    Route::get('/evening-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'EveningPlayTwoDigit'])->name('EveningPlayTwoDigit');

    Route::post('lotteries-two-d-play', [TwoDigitController::class, 'store'])->name('StorePlayTwoD');
    Route::post('/two-d-play', [App\Http\Controllers\Admin\TwoDPlayController::class, 'store'])->name('two-d-play.store');

    Route::get('/quick-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickMorningPlayTwoDigit'])->name('QuickMorningPlayTwoDigit');
    Route::get('/quick-odd-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickOddMorningPlayTwoDigit'])->name('QuickOddMorningPlayTwoDigit');
    Route::get('/quick-even-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickEvenMorningPlayTwoDigit'])->name('QuickEvenMorningPlayTwoDigit');

    Route::get('/quick-odd-same-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickOddSameMorningPlayTwoDigit'])->name('QuickOddSameMorningPlayTwoDigit');

    Route::get('/quick-even-same-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickEvenSameMorningPlayTwoDigit'])->name('QuickEvenSameMorningPlayTwoDigit');
    Route::post('/quick-two-d-play', [App\Http\Controllers\Admin\TwoDPlayController::class, 'Quickstore'])->name('Quickstore');
    Route::get('/two-d-play-noti', [App\Http\Controllers\Admin\GetNotificationTwoDPlayUserController::class, 'index'])->name('two-d-play-noti');
    Route::post('/two-d-play-noti-mark-as-read', [App\Http\Controllers\Admin\GetNotificationTwoDPlayUserController::class, 'playTwoDmarkNotification'])->name('playTwoDmarkNotification');

    Route::get('/get-two-d-session-reset', [App\Http\Controllers\Admin\SessionResetControlller::class, 'index'])->name('SessionResetIndex');
    Route::post('/two-d-session-reset', [App\Http\Controllers\Admin\SessionResetControlller::class, 'SessionReset'])->name('SessionReset');

    Route::post('/two-d-session-over-amount-limit-reset', [App\Http\Controllers\Admin\SessionResetControlller::class, 'OverAmountLimitSessionReset'])->name('OverAmountLimitSessionReset');
    // three d reset
    Route::post('/three-d-reset', [App\Http\Controllers\Admin\ThreeD\ThreeDResetController::class, 'ThreeDReset'])->name('ThreeDReset');

    Route::get('/close-two-d', [App\Http\Controllers\Admin\CloseTwodController::class, 'index'])->name('CloseTwoD');
    Route::put('/update-open-close-two-d', [App\Http\Controllers\Admin\CloseTwodController::class, 'update'])->name('OpenCloseTwoD');
    // three d permutation winners history
        Route::get('/permutation-winners-history', [App\Http\Controllers\Admin\ThreeD\ThreeDWinnerController::class, 'getPermutationWinnersHistoryForAdmin'])->name('PermutationWinnersHistory');
        // store_permutations
        Route::post('/store-permutations', [App\Http\Controllers\Admin\ThreeD\ThreeDPrizeNumberCreateController::class, 'PermutationStore'])->name('storePermutations'); 
        //deletePermutation
        Route::delete('/delete-permutation/{id}', [App\Http\Controllers\Admin\ThreeD\ThreeDPrizeNumberCreateController::class, 'deletePermutation'])->name('deletePermutation');
        // greater than less than winner prize
        Route::resource('winner-prize', App\Http\Controllers\Admin\ThreeD\GreatherThanLessThanWinnerPrizeController::class);
        // three d permutation winner prize
        Route::get('/prize-winners', [App\Http\Controllers\Admin\ThreeD\ThreeDWinnerController::class, 'getPrizeWinnersHistoryForAdmin'])->name('getPrizeWinnersHistory');


    Route::get('/two-d-evening-number', [App\Http\Controllers\Admin\TwoDMorningController::class, 'EveningTwoD'])->name('eveningNumber');
    Route::get('/two-d-evening-winner', [App\Http\Controllers\Admin\TwoDMorningController::class, 'TwoDEveningWinner'])->name('eveningWinner');
    Route::get('/two-d-evening-winner', [App\Http\Controllers\Admin\TwoDEveningWinnerController::class, 'TwoDEveningWinner'])->name('eveningWinner');
    Route::get('profile/fill_money', [ProfileController::class, 'fillmoney']);
    // kpay fill money get route
    Route::get('profile/kpay_fill_money', [ProfileController::class, 'index'])->name('kpay_fill_money');
    Route::resource('fill-balance-replies', FillBalanceReplyController::class);
    Route::put('/fill-balance-replies-update/{id}', [App\Http\Controllers\Admin\FillBalanceReplyController::class, 'update'])->name('FillBalanceUpdate');
    Route::get('/daily-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmounts'])->name('dailyIncomeJson');
    Route::get('/with-draw-view', [App\Http\Controllers\Admin\WithDrawViewController::class, 'index'])->name('withdrawViewGet');
    Route::get('/with-draw-details/{id}', [App\Http\Controllers\Admin\WithDrawViewController::class, 'show'])->name('withdrawViewDetails');
    // withdraw update route
    Route::put('/with-draw-update/{id}', [App\Http\Controllers\Admin\WithDrawViewController::class, 'update'])->name('withdrawViewUpdate');
    Route::get('/daily-with-name-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmountsDaily'])->name('getTotalAmountsDaily');
    // week name route
    Route::get('/weekly-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmountsWeekly'])->name('getTotalAmountsWeekly');
    // month name route
    Route::get('/month-with-name-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmountsMonthly'])->name('getTotalAmountsMonthly');
    // year name route
    Route::get('/yearly-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmountsYearly'])->name('getTotalAmountsYearly');

    // 3d lottery routes
    Route::get('/threed-lotteries-history', [ThreedHistoryController::class, 'index']);
    Route::get('/threed-lotteries-match-time', [ThreedMatchTimeController::class, 'index']);

    //wallet management
        Route::get('/transferlogs', [TransferLogController::class, 'index'])->name('transferLog');
    //wallet management

      //accept and reject request
      Route::get('/cashIn', [CashInRequestController::class, 'index'])->name('cashIn');
      Route::get('/cashIn/{id}', [CashInRequestController::class, 'show'])->name('cashIn.show');
      Route::get('/cashOut', [CashOutRequestController::class, 'index'])->name('cashOut');
      Route::get('/cashOut/{id}', [CashOutRequestController::class, 'show'])->name('cashOut.show');
      Route::post('/deposit/reject/{id}', [CashInRequestController::class, "reject"])->name('deposite-reject');
      Route::post('/deposit/accept/{id}', [CashInRequestController::class, "accept"])->name('deposite-accept');
      Route::post('/withdraw/accept/{id}', [CashOutRequestController::class, "accept"])->name('withdraw-accept');
      Route::post('/withdraw/reject/{id}', [CashOutRequestController::class, "reject"])->name('withdraw-reject');

});



Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'App\Http\Controllers\User', 'middleware' => ['auth']], function () {

    //profile management
    Route::put('editProfile/{profile}', [ProfileController::class, 'update'])->name('editProfile');
    Route::post('editInfo', [ProfileController::class, 'editInfo'])->name('editInfo');
    Route::post('changePassword', [ProfileController::class, 'changePassword'])->name('changePassword');
    //profile management
    // winner history route
    Route::get('/threed-winners-histories', [App\Http\Controllers\User\WinnerAuthUserDisplayController::class, 'getWinnersHistoryForAuthUserOnly'])->name('threed_winners_histories');
    Route::get('/dashboard', [App\Http\Controllers\User\WelcomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/two-d-play-index', [App\Http\Controllers\User\TwodPlayIndexController::class, 'index'])->name('twod-play-index');
    // 9:00 am index
    Route::get('/two-d-play-index-9am', [App\Http\Controllers\User\AM9\TwoDplay9AMController::class, 'index'])->name('twod-play-index-9am');
    // 9:00 am confirm page
    Route::get('/two-d-play-9-30-early-morning-confirm', [App\Http\Controllers\User\AM9\TwoDplay9AMController::class, 'play_confirm'])->name('twod-play-confirm-9am');
    // store
    Route::post('/two-d-play-index-9am', [App\Http\Controllers\User\AM9\TwoDplay9AMController::class, 'store'])->name('twod-play-index-9am.store');
    // 12:00 pm index
    Route::get('/two-d-play-index-12pm', [App\Http\Controllers\User\PM12\TwodPlay12PMController::class, 'index'])->name('twod-play-index-12pm');
    // 12:00 pm confirm page
    Route::get('/two-d-play-12-1-morning-confirm', [App\Http\Controllers\User\PM12\TwodPlay12PMController::class, 'play_confirm'])->name('twod-play-confirm-12pm');
    // store
    Route::post('/two-d-play-index-12pm', [App\Http\Controllers\User\PM12\TwodPlay12PMController::class, 'store'])->name('twod-play-index-12pm.store');

    // 2:00 pm index
    Route::get('/two-d-play-index-2pm', [App\Http\Controllers\User\PM2\TwodPlay2PMController::class, 'index'])->name('twod-play-index-2pm');
    // 2:00 pm confirm page
    Route::get('/two-d-play-2-early-evening-confirm', [App\Http\Controllers\User\PM2\TwodPlay2PMController::class, 'play_confirm'])->name('twod-play-confirm-2pm');
    // store
    Route::post('/two-d-play-index-2pm', [App\Http\Controllers\User\PM2\TwodPlay2PMController::class, 'store'])->name('twod-play-index-2pm.store');

    // 4:00 pm index
    Route::get('/two-d-play-index-4pm', [App\Http\Controllers\User\PM4\TwodPlay4PMController::class, 'index'])->name('twod-play-index-4pm');
    // 2:00 pm confirm page
    Route::get('/two-d-play-4-30-evening-confirm', [App\Http\Controllers\User\PM4\TwodPlay4PMController::class, 'play_confirm'])->name('twod-play-confirm-4pm');
    // store
    Route::post('/two-d-play-index-4pm', [App\Http\Controllers\User\PM4\TwodPlay4PMController::class, 'store'])->name('twod-play-index-4pm.store');

    // qick play 9:00 am index
    Route::get('/two-d-quick-play-index', [App\Http\Controllers\User\TwodQuick\TwoDQicklyPlayController::class, 'index'])->name('twod-quick-play-index');

    Route::get('/two-d-play-quick-confirm', [App\Http\Controllers\User\TwodQuick\TwoDQicklyPlayController::class, 'play_confirm'])->name('twod-play-confirm-quick');
    // store
    Route::post('/twod-play-quick-confirm', [App\Http\Controllers\User\TwodQuick\TwoDQicklyPlayController::class, 'store'])->name('twod-play-quickly-confirm.store');
    // money transfer
    Route::get('/wallet-deposite', [App\Http\Controllers\User\FillBalance\FillBalanceController::class, 'index'])->name('deposite-wallet');

    //deposit
    Route::get('/fill-balance', [App\Http\Controllers\User\FillBalance\FillBalanceController::class, 'topUpWallet'])->name('topUpWallet');
    Route::get('/fill-balance-top-up-submit/{id}', [App\Http\Controllers\User\FillBalance\FillBalanceController::class, 'topUpSubmit'])->name('topUpSubmit');
    Route::post('/deposit', [CashInRequestController::class, 'deposit'])->name('deposit');
    //deposit

    //withdraw
    Route::get('/withdraw-money', [App\Http\Controllers\User\FillBalance\FillBalanceController::class, 'withdrawBalance'])->name('withdrawBalance');
    Route::get('/withdraw/{id}', [App\Http\Controllers\User\FillBalance\FillBalanceController::class, 'withdrawBank'])->name('withdrawBank');
    Route::post('/withdraw', [CashOutRequestController::class, 'withdraw'])->name('withdraw');
    //withdraw

    //transferlog
    Route::get('/transferlogs', [TransferLogController::class, 'log'])->name('transferLog');






  // money transfer end

  // two d winner history
  Route::get('/two-d-winners-history', [App\Http\Controllers\User\WinHistory\TwoDWinnerHistoryController::class, 'winnerHistory'])->name('winnerHistory');

  // twod-dream-book
  Route::get('/two-d-dream-book', [App\Http\Controllers\User\Dream\TwodDreamBookController::class, 'index'])->name('two-d-dream-book-index');

  // three d
  Route::get('/three-d-play-index', [ThreeDPlayController::class, 'index'])->name('three-d-play-index');
  // three d choice play
  Route::get('/three-d-choice-play-index', [ThreeDPlayController::class, 'choiceplay'])->name('three-d-choice-play');
  // three d choice play confirm
  Route::get('/three-d-choice-play-confirm', [ThreeDPlayController::class, 'confirm_play'])->name('three-d-choice-play-confirm');
  // three d choice play store
  Route::post('/three-d-choice-play-store', [ThreeDPlayController::class, 'store'])->name('three-d-choice-play-store');
  // display three d play
  Route::get('/three-d-display', [ThreeDPlayController::class, 'user_play'])->name('display');
  // three d dream book
  Route::get('/three-d-dream-book', [App\Http\Controllers\User\Threed\ThreeDreamBookController::class, 'index'])->name('three-d-dream-book-index');
  // three d winner history
  Route::get('/three-d-winners-history', [App\Http\Controllers\User\Threed\ThreedWinnerHistoryController::class, 'index'])->name('three-d-winners-history');
   
});

Route::get('/register', [App\Http\Controllers\User\WelcomeController::class, 'userRegister'])->name('register');
Route::get('/service', [App\Http\Controllers\User\WelcomeController::class, 'servicePage'])->name('service');
Route::get('/twoDPrize', [App\Http\Controllers\User\WelcomeController::class, 'twoDPrize'])->name('twoDPrize');
Route::get('/twod-live', [App\Http\Controllers\User\WelcomeController::class, 'twodLive']);
Route::get('/twod-calendar', [App\Http\Controllers\User\WelcomeController::class, 'twodCalendar']);
Route::get('/twod-holiday', [App\Http\Controllers\User\WelcomeController::class, 'twodHoliday']);
Route::get('/comment', [App\Http\Controllers\User\WelcomeController::class, 'comment']);
Route::get('/inviteCode', [App\Http\Controllers\User\WelcomeController::class, 'inviteCode']);
Route::get('/changePassword', [App\Http\Controllers\User\WelcomeController::class, 'changePassword']);
// promotion route
Route::get('/promotion', [App\Http\Controllers\User\WelcomeController::class, 'promotion']);
// promotion detail
Route::get('/promotion-detail/{id}', [App\Http\Controllers\User\WelcomeController::class, 'promotionDetail'])->name('promotionDetail');
// Route::get('/promotion-detail/{id}', [App\Http\Controllers\User\WelcomeController::class, 'promotionDetail'])->name('promotionDetail');



// Route::get('/myBank', [App\Http\Controllers\User\WelcomeController::class, 'myBank']);

// Route::get('/3d', [App\Http\Controllers\User\WelcomeController::class, 'threeD']);
// Route::get('/3dBet', [App\Http\Controllers\User\WelcomeController::class, 'threedBet']);
Route::get('/3dHistory', [App\Http\Controllers\User\WelcomeController::class, 'threedHistory']);

//Route::get('/3dWinnerHistory', [App\Http\Controllers\User\WelcomeController::class, 'threedWinner']);