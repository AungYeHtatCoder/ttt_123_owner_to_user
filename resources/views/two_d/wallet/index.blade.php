@extends('frontend.layouts.app')
@section('content')
<div class="row">
    <div
      class="col-lg-4 col-md-4 offset-lg-4 offset-md-4 mt-4 pt-5 headers"
      style="padding-bottom:200px;"
    >
      
    <div class="row parent-div">
      <div class="col">
        <div class="d-flex py-2">
          <div>
            <i class="fa-regular fa-circle-user fs-1 profile-icon"></i>
          </div>
          <div class="ms-3 text-white">
            <p class="mb-0 pb-1">User Name</p>
            <p>လက်ကျန်ငွေ: 0 ကျပ်</p>
          </div>
        </div>
      </div>
    </div>
    <!-- profile section -->
    <div class="card child-div">
      <div class="row pt-2 text-center">
        <div class="col">
          <a
            href="{{ url('/user/fill-balance') }}"
            style="color: black; text-decoration: none"
          >
            <i class="fa-solid fa-money-bill-1"></i>
            <p style="font-size: 11px">ငွေဖြည့်</p>
          </a>
        </div>
        <div class="col">
          <a
            href="{{ url('/user/withdraw-money') }}"
            style="color: black; text-decoration: none"
          >
            <i class="fa-solid fa-money-bill-transfer"></i>
            <p style="font-size: 11px">ငွေထုတ်</p>
          </a>
        </div>
        <!-- <div class="col">
          <i class="fa-solid fa-coins"></i>
          <p style="font-size: 11px">ဂိမ်းပိုက်ဆံအိတ်</p>
        </div> -->
        <div class="col">
          <i class="fa-solid fa-pen-to-square"></i>
          <p style="font-size: 11px">မှတ်တမ်း</p>
        </div>
      </div>
    </div>
    <div class="row m-2">
      <div class="wallet-card">
        <h5 class="text-white text-center">ငွေဖြည့်လိုပါက</h5>
        <div class="p-3 text-left text-white">
          <p>၁။ "ငွေဖြည့်" ကို နှိပ်ပါ။</p>
          <p>
            ၂။ KBZ Pay, Wave Pay, CB Pay နှင့် AYA Pay တို့မှ
            မိမိငွေဖြည့်မည့် ဘဏ်ကို ရွေးပါ။
          </p>
          <p>
            ၃။ သက်ဆိုင်ရာ Pay ဖြင့် ငွေသွင်းနိုင်သော အကောင့်များ
            ပေါ်လာပါလိမ့်မည်။
          </p>
        </div>
      </div>
    </div> 

  
      
    </div>
</div>


@include('frontend.layouts.footer')
@endsection
