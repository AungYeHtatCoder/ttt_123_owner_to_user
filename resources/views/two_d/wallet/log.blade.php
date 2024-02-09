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
            <p class="mb-0 pb-1">{{ Auth::user()->name }}</p>
            <p>လက်ကျန်ငွေ: {{ number_format(Auth::user()->balance) }} ကျပ်</p>
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
          <a
            href="{{ url('/user/transferlogs') }}"
            style="color: black; text-decoration: none"
          >
            <i class="fa-solid fa-pen-to-square"></i>
            <p style="font-size: 11px">မှတ်တမ်း</p>
          </a>
        </div>
      </div>
    </div>
    <div class="row mt-4 mb-3 mx-auto text-center">
      <div class="col-3">
        <small class="text-white">နေ့စွဲ</small>
      </div>
      <div class="col-3">
        <small class="text-white">အမျိုးအစား</small>
      </div>
      <div class="col-3">
        <small class="text-white">ပမာဏ</small>
      </div>
      <div class="col-3">
        <small class="text-white">အခြေအနေ</small>
      </div>
    </div> 
    @foreach ($logs as $log)
      <div class="row text-center mx-auto mb-2">
        <div class="col-3">
          <small class="text-white">{{ $log->created_at->format('j/m/Y') }}</small>
        </div>
        <div class="col-3">
          <small class="text-white">{{ $log->type == "Withdraw" ? "ထုတ်ငွေ" : "သွင်းငွေ" }}</small>
        </div>
        <div class="col-3">
          <small class="text-white">{{ number_format($log->amount) }} ကျပ်</small>
        </div>
        <div class="col-3">
          <small class="badge text-bg-{{ $log->status == 0 ? 'warning' :($log->status == 1 ? 'success' : 'danger') }}">{{ $log->status == 2 ? "ပယ်ချ" : ($log->status == 1 ? "အောင်မြင်" : "စောင့်ဆိုင်း") }}</small>
        </div>
      </div>
    @endforeach

  
      
    </div>
</div>


@include('frontend.layouts.footer')
@endsection
