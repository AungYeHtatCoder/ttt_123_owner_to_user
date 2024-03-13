@extends('frontend.layouts.app')

@section('style')
<style>
  .fa-brands{
    color: #fff !important;
    background: transparent !important; 
  }
</style>
@endsection

@section('content')
<div class="row">
    <div
      class="col-lg-4 col-md-4 offset-lg-4 offset-md-4 mt-4 pt-5 headers"
      style="padding-bottom:300px"
    >
      
    <div class="row service  mt-3 text-center">
      <div class="col-6" id="first-block"><p>ကိုယ်စားလှယ်သို့</p></div>
      <div class="col-6 click1" id="second-block"><p>TTT Gamingသို့</p></div>
    </div>

    <!-- first block -->
    <div class="first-block d-none mt-3 pb-5">
      <p>လူကြီးမင်းသည် ကိုယ်စားလှယ်တစ်စုံတစ်ဦး၏မိတ်ဆက်ကုဒ်ကို ဖြည့်ထားခြင်းမရှိသေးပါ။</p>
      <a href="#" class="btn my-2 top-up-btn w-50" >မိတ်ဆက်ကုဒ်ဖြည့်ပါ</a>
    </div>
    <!-- first block -->

    <!-- second block -->
    <div class="second-block">
       <div class="container mt-3 text-center">
          <p class="text-white">အောက်ပါဖုန်းနံပါတ်သည် TTT Gaming ၏ ဝန်ဆောင်မှုဖုန်းနံပါတ်ဖြစ်သည်</p>
          <p class="text-white">နေ့စဉ်(၂၄) နာရီ ၊ ပိတ်ရက်မရှိ ဝန်ဆောင်ပေးနေပါသည်။</p>
       </div>
      <div class="second-card mt-5">
        <p>ဝန်ဆောင်မှု ဖုန်းနံပါတ်</p>
        <div class="d-flex justify-content-between mt-4">
          <p>+95 9 777 773 134</p>
          <div>
            <a href="viber://chat?number=09777773134" class="bg-transparent">
              <i class="fa-brands fa-viber" style="color: #fff !important; font-size: 30px;"></i>
            </a>
            <a href="https://t.me/TTTgaming" class="bg-transparent" target="_blank">
              <i class="fa-brands fa-telegram" style="color: #fff !important; font-size: 30px;"></i>
            </a>
          </div>
        </div>

        <div class="d-flex justify-content-between mt-4 mb-4">
          <p>+95 9 676 767 507</p>
          <div>
            <a href="viber://chat?number=09676767507" class="bg-transparent">
              <i class="fa-brands fa-viber" style="color: #fff !important; font-size: 30px;"></i>
            </a>
            <a href="https://t.me/TTTgaming" class="bg-transparent" target="_blank">
              <i class="fa-brands fa-telegram" style="color: #fff !important; font-size: 30px;"></i>
            </a>
          </div>
        </div>
      </div>
      {{-- <div class="second-card mt-3">
        <p>ကိုယ်စားလှယ်ဝင်ဖို့ စုံစမ်းရန်</p>
        <div class="d-flex justify-content-between mt-4">
          <p>+0912345678</p>
          <a href="" class="d-flex px-3 text-decoration-none">
            <i class="fa-brands fs-4 mt-2 pe-2 fa-viber" style="color: purple !important"></i><p class="mt-2">Viber</p>
          </a>
        </div>
      </div> --}}
    </div> 

    </div>
</div>


@include('frontend.layouts.footer')
@endsection
@section('script')
<script>
  $('#first-block').click(function () {
    $('#first-block').addClass('click');
    $('#second-block').removeClass('click1');
    
    $('.first-block').removeClass('d-none');
    $('.second-block').addClass('d-none');
  });
  $('#second-block').click(function () {
    $('#second-block').addClass('click1');
    $('#first-block').removeClass('click');
   

    $('.first-block').addClass('d-none');
    $('.second-block').removeClass('d-none');
  });
</script>
@endsection
