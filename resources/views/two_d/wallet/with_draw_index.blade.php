@extends('frontend.layouts.app')
@section('content')
<div class="row">
 <div
      class="col-lg-4 col-md-4 offset-lg-4 offset-md-4 mt-4 pt-5 headers"
      style="padding-bottom:110px"
    >
    <h6 class="text-center mt-2 pb-2" style="color: #fff">ငွေထုတ်မည်</h6>

    <p style="color: #fff">မိမိ ငွေထုတ်ယူမည့်ဘဏ်တစ်ခုရွေးပါ</p>
   <div class="top-up-card">
    @foreach ($banks as $bank)
    <div class="banks blur-image">
      <img src="{{ $bank->img_url }}" onclick="showForm()" class="w-100" alt="" />
    </div>
    @endforeach

    <div class="text-center mt-3">
      <p style="color: #fff">လက်ကျန်ငွေ: {{ Auth::user()->balance }} ကျပ်</p>
    </div>
    <hr class="my-custom-line" />

    <div class="row">
      <div class="container" id="top-up-form" style="display: none">
       <form action="">
      @foreach ($banks as $bank)
      <div class="form-group mt-2">
        <a href="{{ url('/user/withdraw/'.$bank->id) }}" class="btn top-up-btn">{{ $bank->bank }} - ဆက်လုပ်ရန်</a>
      </div>
      @endforeach
        </form>
      </div>
    </div>
  </div>
</div>


@include('frontend.layouts.footer')
@endsection
@section('script')
<script>
  function showForm() {
    const blurImages = document.querySelectorAll('.blur-image');

    blurImages.forEach((image) => {
      image.addEventListener('click', function() {
        // Remove the 'active' class from all images
        blurImages.forEach((otherImage) => {
          otherImage.classList.remove('active');
        });

        // Add the 'active' class to the clicked image
        this.classList.add('active');
      });
    });
    let form = document.getElementById('top-up-form');
    form.style.display = 'block';
  }
</script>
<script>
  function fillInputBox(element) {
    let value = element.getAttribute('data-value');
    console.log(value);
    let inputField = document.getElementById('inputField');
    inputField.value = value;
  }
</script>
@endsection