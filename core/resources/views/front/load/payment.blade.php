@php

    if ($payment != 'offline') {
        $pay_data = $gateway->convertAutoData();
    }

@endphp


@if($payment == 'paypal')

  <input type="hidden" name="method" value="{{ $gateway->name }}">

@endif

@if($payment == 'stripe')

  <input type="hidden" name="method" value="{{ $gateway->name }}">

  <div class="row">

    <div class="col-lg-6 mb-4">
        <div class="form-element">
            <input class="input-field card-elements" name="cardNumber" type="text" placeholder="{{ __('Card Number') }}" autocomplete="off"  autofocus oninput="validateCard(this.value);" />
            <span id="errCard"></span>
        </div>
        @if ($errors->has('cardNumber'))
            <p class="text-danger mb-0">{{$errors->first('cardNumber')}}</p>
        @endif
    </div>

    <div class="col-lg-6 mb-4">
        <div class="form-element">
            <input class="input-field card-elements" name="cardCVC" type="text" placeholder="{{ __('CVV') }}" autocomplete="off"  oninput="validateCVC(this.value);" />
            <span id="errCVC"></span>
        </div>
        @if ($errors->has('cardCVC'))
            <p class="text-danger mb-0">{{$errors->first('cardCVC')}}</p>
        @endif
    </div>

    <div class="col-lg-6 mb-4">
        <div class="form-element">
            <input class="input-field card-elements" name="month" type="text" placeholder="{{ __('Month') }}"  />
        </div>
        @if ($errors->has('month'))
            <p class="text-danger mb-0">{{$errors->first('month')}}</p>
        @endif
    </div>

    <div class="col-lg-6 mb-4">
        <div class="form-element">
            <input class="input-field card-elements" name="year" type="text" placeholder="{{ __('Year')}}"  />
        </div>
        @if ($errors->has('year'))
            <p class="text-danger mb-0">{{$errors->first('year')}}</p>
        @endif
    </div>

  </div>

  {{-- <script type="text/javascript">

    var cnstatus = false;
    var dateStatus = false;
    var cvcStatus = false;

    function validateCard(cn) {
      cnstatus = Stripe.card.validateCardNumber(cn);
      if (!cnstatus) {
        $("#errCard").html('{{ __("Card number not valid") }}');
      } else {
        $("#errCard").html('');
      }
    }

    function validateCVC(cvc) {
      cvcStatus = Stripe.card.validateCVC(cvc);
      if (!cvcStatus) {
        $("#errCVC").html('{{ __("CVC number not valid") }}');
      } else {
        $("#errCVC").html('');
      }

    }

  </script> --}}

@endif

@if($payment == 'payumoney')

  <input type="hidden" name="method" value="{{ $gateway->name }}">

  <div class="row">

    <div class="col-lg-6 mb-4">
        <div class="form-element">
            <input class="input-field" name="payumoney_first_name" type="text" placeholder="{{ __('First Name') }}" />
        </div>
        @if ($errors->has('payumoney_first_name'))
            <p class="text-danger mb-0">{{$errors->first('payumoney_first_name')}}</p>
        @endif
    </div>

    <div class="col-lg-6 mb-4">
        <div class="form-element">
            <input class="input-field" name="payumoney_last_name" type="text" placeholder="{{ __('Last Name') }}" />
        </div>
        @if ($errors->has('payumoney_last_name'))
            <p class="text-danger mb-0">{{$errors->first('payumoney_last_name')}}</p>
        @endif
    </div>

    <div class="col-lg-6 mb-4">
        <div class="form-element">
            <input class="input-field" name="payumoney_phone" type="text" placeholder="{{ __('Phone') }}"  />
        </div>
        @if ($errors->has('payumoney_phone'))
            <p class="text-danger mb-0">{{$errors->first('payumoney_phone')}}</p>
        @endif
    </div>

  </div>

@endif

@if($payment == 'instamojo')

  <input type="hidden" name="method" value="{{ $gateway->name }}">

@endif

@if($payment == 'razorpay')

  <input type="hidden" name="method" value="{{ $gateway->name }}">
  <div class="row">
    <div class="col-lg-6 mb-4">
        <div class="form-element">
            <input class="input-field card-elements" name="razorpay_phone" type="text" placeholder="{{ __('Phone')}}"  />
        </div>
        @if ($errors->has('razorpay_phone'))
            <p class="text-danger mb-0">{{$errors->first('razorpay_phone')}}</p>
        @endif
    </div>
    <div class="col-lg-6 mb-4">
        <div class="form-element">
            <input class="input-field card-elements" name="razorpay_address" type="text" placeholder="{{ __('Address')}}"  />
        </div>
        @if ($errors->has('razorpay_address'))
            <p class="text-danger mb-0">{{$errors->first('razorpay_address')}}</p>
        @endif
    </div>
  </div>
@endif

@if($payment == 'flutterwave')

  <input type="hidden" name="method" value="{{ $gateway->name }}">

@endif


@if($payment == 'paystack')

  <input type="hidden" name="txnid" id="ref_id" value="">
  <input type="hidden" name="sub" id="sub" value="0">
	<input type="hidden" name="method" value="{{ $gateway->name }}">

@endif

@if($payment == 'mollie')

  <input type="hidden" name="method" value="{{ $gateway->name }}">

@endif

@if($payment == 'mercadopago')

  <input type="hidden" name="method" value="{{ $gateway->name }}">

@endif


@if($payment == 'offline')

  <div>
    <p class="gateway-desc">{{$gateway->short_description}}</p>
  </div>

  <div class="gateway-instruction">
    <p>{!! replaceBaseUrl($gateway->instructions) !!}</p>
  </div>

  @if ($gateway->is_receipt == 1)
  <div class="mb-4 form-element">
      <label for="" class="d-block mb-2">{{__('Receipt')}} **</label>
      <input type="file" name="receipt">
      <p class="mb-0 text-warning">** {{__('Receipt image must be .jpg / .jpeg / .png')}}</p>
  </div>
  @endif

@endif
