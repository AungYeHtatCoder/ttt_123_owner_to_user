@extends('frontend.layouts.app')
@section('style')
<link rel="stylesheet" href="{{ asset('user_app/assets/css/balance.css') }}">

@endsection
@section('content')
<div class="row">
    <div
      class="col-lg-4 col-md-4 offset-lg-4 offset-md-4 mt-4 pt-5 headers"
      style="padding-bottom:100px"
    >
    <div class="d-flex justify-content-between align-items-center mt-2">

      <a href="./wallet.html" class="d-flex justify-content-start align-items-center text-decoration-none ">
          <img src="{{ asset('user_app/assets/images/wallet.png') }}"  alt="" style="width: 40px; height:40px">
          {{-- <p class="fw-bold pt-2 ps-2 text-white">0 ကျပ်</p> --}}
          <p class="fw-bold pt-2 ps-2 text-white" id="userBalance" data-balance="{{ Auth::user()->balance }}">{{ Auth::user()->balance }} MMK</p>
      </a>
      <div class="mt-1 me-2 text-white" style="line-height: 10px;">
          <p class="d-block">ထီပိတ်ချိန် </p>
          <small>01-12-2023 2:45 PM</small>
      </div>
    </div>

    {{-- <div class="d-flex justify-content-between align-items-center mt-5">
      <button type="button" class="py-2 px-3 mx-2 border border-none outline outline-none bg-transparent" data-toggle="modal" data-target="#quickSelectModal">အမြန်ရွေး</button>
      <button type="button"  id="toggleButton" class="py-2 px-3 mx-2 border border-none outline outline-none toggle-btn"  onclick="toggleState()">R</button>
      <i class="fa-regular fa-circle-question px-3 my-3" style="cursor: pointer;" data-toggle="modal" data-target="#colorModal">အရောင်ရှင်းလင်းချက်</i>
      
    </div> --}}

  <div class="d-flex justify-content-between mt-3 custom-btn">
    <button class="fs-6 px-3" id="permuteButton" onclick="permuteDigits()">ပတ်လည်</button>
    -
    <a href="{{ url('/user/three-d-dream-book') }}" class="btn h-50 text-white p-2" style="background-color: #c50408; border: 2px solid #ebc03c; box-shadow: 3px 5px 10px 0 rgba(0, 0, 0, 0.2), 3px 5px 10px 0 rgba(0, 0, 0, 0.19)">
        <span class="material-icons text-white icons">menu_book</span>  အိမ်မက်</a>
    

    <input type="text" name="amount" id="all_amount" placeholder="ငွေပမာဏ" class="form-control w-75 text-center border-black ms-1" autocomplete="off"/>
    <input type="text" name="amount" id="input_new_digit" placeholder="Enter 3 Digit" class="form-control w-75 ms-1 text-center border-black" autocomplete="off"/>

  </div>

    <div class="mx-auto ms-2">
      {{-- <input type="number" id="numberInput" class="p-2 my-3 border bg-transparent text-white" maxlength="3" placeholder="Input 3 Digit" required/> --}}
      {{-- <input type="number"  class="p-2 border border-none text-white bg-transparent" style="outline: none;" minlength="3" placeholder="၁၀၀ ကျပ်အထက်" required/> --}}
    </div>


    {{-- <div class="ms-2 my-3">
      <a href="" class="py-2 px-3 rounded  bg-transparent border border-none text-white">အိမ်မက်</a>
    </div> --}}


    

    <div id="outputDiv" class="my-3">

    </div>
    {{-- form start --}}
      <div class="dream-form mt-3">
    <div class="row">
       <div class="col-md-12">
        
        
       </div>
    </div>
    <div class="">
        <div class="ms-3">
         @if ($lottery_matches->is_active == 1)
          <div class="p-1">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <label for="selected_digits" style="font-size: 14px; color: #f5bd02;">ရွှေးချယ်ထားသောဂဏန်းများ</label>
                <input type="text" name="selected_digits" id="selected_digits" class="form-control mt-1" placeholder="Selected Digits" >
              </div>
              <div class="col-md-12 mt-2">
                <label for="totalAmount" style="font-size: 14px; color: #f5bd02;">ပတ်လည်ဂဏန်းများ</label>
                <input type="text" id="permulated_digit" class="form-control" readonly>
              </div>
              <div id="amountInputs" class="col-md-12 mb-3 d-none"></div>
              <div class="col-md-12 mt-2">
                <label for="totalAmount" style="font-size: 14px; color: #f5bd02;">စုစုပေါင်းထိုးကြေး</label>
                <input type="text" id="totalAmount" name="totalAmount" class="form-control mt-1" readonly>
              </div>
              <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

            </div>
           </div>
            @else
          <div class="row">
            <div class="col-md-12">
            <div class="text-center p-4">
            <h4 style="color: aliceblue" class="badge bg-primary">ယခု ပွဲချိန်မှာ ထိုး၍ မရတော့ပါ ! နောက်ပွဲစဉ်စောင့်ပေးပါ အားပေးမှုကို ကျေးဇူးတင်ပါသည်။ </h4>
        </div>
            </div>
          </div>
          @endif

        </div>
    </div>
  </div>
    {{-- form end --}}
      {{-- three d start  --}}
        <div class="box-container mt-3" id="boxContainer">
       
        <div class="main-row">
          @foreach ($threeDigits as $digit)
          <div class="column">

            @php
            $totalBetAmountForTwoDigit = DB::table('lotto_three_digit_pivot')
            ->where('three_digit_id', $digit->id)
            ->sum('sub_amount');
            @endphp

            @if ($totalBetAmountForTwoDigit < 50000) 
            <div class="text-center fs-6 digit" style="background-color: {{ 'javascript:getRandomColor();' }};" onclick="selectDigit('{{ $digit->three_digit }}', this)">
             <p style="font-size: 20px">
               {{ $digit->three_digit }}
             </p>
              {{-- <small class="d-none" style="font-size: 10px">{{ $remainingAmounts[$digit->id] }}</small> --}}
              <div class="progress">
                @php
                $totalAmount = 50000;
                $betAmount = $totalBetAmountForTwoDigit; // the amount already bet
                $remainAmount = $totalAmount - $betAmount; // the amount remaining that can be bet
                $percentage = ($betAmount / $totalAmount) * 100;
                @endphp

                <div class="progress-bar" style="width: {{ $percentage }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                 <small class="d-none" style="font-size: 10px">{{ $remainingAmounts[$digit->id] }}</small>
                </div>
              </div>
          </div>
          @else
          <div class="col-2 text-center digit disabled" style="background-color: {{ 'javascript:getRandomColor();' }}" style="width:100%" onclick="showLimitFullAlert()">
            {{ $digit->three_digit }}
          </div>
          @endif

        </div>
        @endforeach
      
    </div>
      {{-- three d end --}}
    </div>
</div>

<div class="row">

  <div class="col-lg-4 col-md-6 offset-lg-4 offset-md-3 py-3 submitbtns footers" style="background-color: #000;">
    <div class="d-flex justify-content-around mt-2" >
      <a href="" class="btn remove-btn me-2" style="font-size: 14px;">ဖျက်မည်</a>
      <a href="{{ url('/user/three-d-choice-play-confirm') }}" onclick="storeSelectionsInLocalStorage()" class="btn play-btn me-1" style="font-size: 14px;">ထိုးမည်</a>
    </div> 
  
  </div>
</div>


{{-- @include('frontend.layouts.footer') --}}
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    @if(session('SuccessRequest'))
    Swal.fire({
      icon: 'success',
      title: 'Success! သင့်ကံစမ်းမှုအောင်မြင်ပါသည် ! သိန်းထီးဆုကြီးပေါက်ပါစေ',
      text: '{{ session('
      SuccessRequest ') }}',
      timer: 3000,
      showConfirmButton: false
    });
    @endif
  });
</script>
<script>
  function showLimitFullAlert() {
    Swal.fire({
      icon: 'info',
      title: 'Limit Reached',
      text: 'This two digit\'s amount limit is full.'
    });
  }
document.querySelectorAll('.digit-box').forEach(box => {
  box.addEventListener('click', function() {
    const num = this.textContent.trim();
    selectDigit(num, this); // Pass the digit and the element
   // permuteDigits(); // Call permuteDigits after selecting a digit
  });
});

// Event listener for the manual input field
document.getElementById('input_new_digit').addEventListener('input', function() {
  const manualInputValue = this.value.trim();

  // Validate if the input is a 3-digit number
  if(manualInputValue.length === 3 && /^\d{3}$/.test(manualInputValue)) {
    selectDigit(manualInputValue); // Pass only the digit for manual input
    //permuteDigits(); // Call permuteDigits after input
  }
});
// function selectDigit(num, element = null) {
//   const selectedInput = document.getElementById('selected_digits');
//   const amountInputsDiv = document.getElementById('amountInputs');

//   // Ensure that the digits are handled as strings
//   let selectedDigits = selectedInput.value ? selectedInput.value.split(",") : [];
//   num = num.toString(); // Convert num to a string to ensure "00" is not treated as 0

//   // Check if the digit is already selected
//   if (selectedDigits.includes(num)) {
//     // If it is, remove the digit, its style, and its input field
//     selectedInput.value = selectedDigits.filter(digit => digit !== num).join(',');
//     if (element) {
//       element.classList.remove('selected');
//     }
//     const inputToRemove = document.getElementById('amount_' + num);
//     if (inputToRemove) {
//       amountInputsDiv.removeChild(inputToRemove);
//     }
//   } else {
//     // Otherwise, add the digit, its style, and its input field
//     selectedDigits.push(num);
//     selectedInput.value = selectedDigits.join(',');
//     if (element) {
//       element.classList.add('selected');
//     }
//     const amountInput = document.createElement('input');
//     amountInput.setAttribute('type', 'number');
//     amountInput.setAttribute('name', 'amounts[' + num + ']');
//     amountInput.setAttribute('id', 'amount_' + num);
//     amountInput.setAttribute('placeholder', 'Amount for ' + num);
//     amountInput.setAttribute('min', '100');
//     amountInput.setAttribute('max', '50000');
//     amountInput.setAttribute('class', 'form-control mt-2');
//     amountInputsDiv.appendChild(amountInput);
//   }

//   // Store the current selections to local storage
//   storeSelectionsInLocalStorage();
// }

function selectDigit(num, element) {
    const selectedInput = document.getElementById('selected_digits');
    const amountInputsDiv = document.getElementById('amountInputs');

    // Ensure that the digits are handled as strings
    let selectedDigits = selectedInput.value ? selectedInput.value.split(",") : [];
    num = num.toString(); // Convert num to a string to ensure "00" is not treated as 0

    // Check if the digit is already selected
    if (selectedDigits.includes(num)) {
        // If it is, remove the digit, its style, and its input field
        selectedInput.value = selectedDigits.filter(digit => digit !== num).join(',');
        element.classList.remove('selected');
        const inputToRemove = document.getElementById('amount_' + num);
        if (inputToRemove) {
            amountInputsDiv.removeChild(inputToRemove);
        }
    } else {
        // Otherwise, add the digit, its style, and its input field
        selectedDigits.push(num);
        selectedInput.value = selectedDigits.join(',');
        //element.classList.add('selected');
        if (element) {
              element.classList.add('selected');
            }
        const amountInput = document.createElement('input');
        amountInput.setAttribute('type', 'number');
        amountInput.setAttribute('name', 'amounts[' + num + ']');
        amountInput.setAttribute('id', 'amount_' + num);
        amountInput.setAttribute('placeholder', 'Amount for ' + num);
        amountInput.setAttribute('min', '100');
        amountInput.setAttribute('max', '50000');
        amountInput.setAttribute('class', 'form-control mt-2');
        // amountInputsDiv.appendChild(amountLabel);
        amountInputsDiv.appendChild(amountInput);
    }

    // Store the current selections to local storage
    storeSelectionsInLocalStorage();
}

function storeSelectionsInLocalStorage() {
    let selections = {};
    document.querySelectorAll('input[name^="amounts["]').forEach(input => {
        let digit = input.name.match(/\[(.*?)\]/)[1];
        let amount = input.value;
        if (amount) { // only add to selections if an amount is entered
            selections[digit] = amount;
        }
    });
    localStorage.setItem('twoDigitSelections', JSON.stringify(selections));
    //window.location.href = "{{ url('/user/two-d-play-9-30-early-morning-confirm') }}";
}
function permuteDigits() {
  const outputField = document.getElementById('selected_digits');
  const permulatedField = document.getElementById('permulated_digit');

  if (!outputField || !permulatedField) {
    console.error('Required field not found');
    return;
  }

  let selectedDigits = outputField.value.split(",").map(s => s.trim());

  // Permute the digits only if they are three digits long
  let permutedDigits = [];
  if (selectedDigits.some(num => num.length === 3)) {
    selectedDigits.forEach(num => {
      if (num.length === 3) {
        // Get all permutations for a three-digit number
        let permutations = permute(num.split(''));
        // Filter permutations for twin cases
        if (isTwin(num)) {
          permutations = permutations.filter((val, index, self) =>
            index === self.findIndex((t) => t.join('') === val.join(''))
          );
        }
        permutedDigits.push(...permutations.map(arr => arr.join('')));
      }
    });
  }

  // Update the outputField with both selected and permuted digits
  outputField.value = `${selectedDigits.join(", ")}`;

  // Update the permulatedField with the permuted digits only
  permulatedField.value = permutedDigits.join(", ");

  // Combine selectedDigits and permutedDigits while removing duplicates
  const allUniqueDigits = Array.from(new Set([...selectedDigits, ...permutedDigits]));

  // Recreate the amount inputs for all unique digits
  // Assuming createAmountInputs is a function you have defined elsewhere
  createAmountInputs(allUniqueDigits);
}

function isTwin(number) {
  // A number is considered a twin if it has two identical digits
  const digits = number.split('');
  return digits.some(digit => digits.filter(d => d === digit).length === 2);
}

function permute(inputArr) {
  let result = [];

  // The function that does the actual permutation
  const doPermute = (arr, m = []) => {
    if (arr.length === 0) {
      result.push(m);
    } else {
      for (let i = 0; i < arr.length; i++) {
        let curr = arr.slice();
        let next = curr.splice(i, 1);
        doPermute(curr.slice(), m.concat(next));
     }
   }
  }

  doPermute(inputArr);

  return result;
}

  function createAmountInputs(digits) {
    const amountInputsDiv = document.getElementById('amountInputs');
    amountInputsDiv.innerHTML = ''; // Clear existing amount inputs

    // Create a new input field for each unique digit
    digits.forEach(digit => {
      const amountInput = document.createElement('input');
      amountInput.type = 'number';
      amountInput.name = `amounts[${digit}]`;
      amountInput.id = `amount_${digit}`;
      amountInput.placeholder = `Amount for ${digit}`;
      amountInput.value = '100'; // Set a default value or retrieve the existing value
      amountInput.classList.add('form-control', 'mt-2');
      amountInput.onchange = updateTotalAmount;
      amountInputsDiv.appendChild(amountInput);
    });

    updateTotalAmount(); // Update the total amount to reflect changes
  }


  function checkBetAmount(inputElement, num) {
    // Replace the problematic line with the following code
    const digits = document.querySelectorAll('.digit');
    let digitElement = null;

    for (let i = 0; i < digits.length; i++) {
      if (digits[i].textContent.includes(num)) {
        digitElement = digits[i];
        break;
      }
    }

    // Ensure that the digitElement was found before proceeding
    if (!digitElement) {
      console.error('Could not find the digit element for', num);
      return;
    }

    // Continue with the rest of your function as before
    const remainingAmount = Number(digitElement.querySelector('small').innerText.split(' ')[1]);

    // Check if the entered bet amount exceeds the remaining amount
    if (Number(inputElement.value) > remainingAmount) {
      Swal.fire({
        icon: 'error',
        title: 'Bet Limit Exceeded',
        text: `You can only bet up to ${remainingAmount} for the digit ${num}.`
      });
      inputElement.value = ""; // Reset the input value
    }
  }

  function setAmountForAllDigits(amount) {
    const inputs = document.querySelectorAll('input[name^="amounts["]');
    inputs.forEach(input => {
      input.value = amount;
    });
    updateTotalAmount(); // Update the total amount after setting the new amounts
  }

  // Event listener for the amount input field
  document.getElementById('all_amount').addEventListener('input', function() {
    const amount = this.value; // Get the current value of the input field
    setAmountForAllDigits(amount); // Set this amount for all digit inputs
  });
  // New function to calculate and display the total amount
  function updateTotalAmount() {
    let total = 0;
    const inputs = document.querySelectorAll('input[name^="amounts["]');
    inputs.forEach(input => {
      total += Number(input.value);
    });

    // Get the user's current balance from the data attribute
    const userBalanceSpan = document.getElementById('userBalance');
    let userBalance = Number(userBalanceSpan.getAttribute('data-balance'));

    // Check if user balance is less than total amount
    if (userBalance < total) {
      //alert('Your balance is not enough to play two digit.');
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Your balance is not enough to play two digit. - သင်၏လက်ကျန်ငွေ မလုံလောက်ပါ - ကျေးဇူးပြု၍ ငွေဖြည့်ပါ။',
        footer: `<a href=
         "{{ url('user/wallet-deposite') }}" style="background-color: #007BFF; color: #FFFFFF; padding: 5px 10px; border-radius: 5px; text-decoration: none;">Fill Balance - ငွေဖြည့်သွင်းရန် နိုပ်ပါ </a>`
      });
      return; // Exit the function to prevent further changes
    }
    // Decrease the user balance by the total
    userBalance -= total;

    // Update the displayed balance and the data attribute
    userBalanceSpan.textContent = userBalance;
    userBalanceSpan.setAttribute('data-balance', userBalance);

    document.getElementById('totalAmount').value = total;
  }
  
</script>
<script>
  function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
      color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
  }

  document.querySelectorAll('.digit.disabled').forEach(el => {
    el.style.backgroundColor = getRandomColor();
  });
</script>
@endsection