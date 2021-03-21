{{-- Start: Paypal Area --}}
@if ($paypal->status == 1)
<div class="option-block">
    <div class="radio-block">
        <div class="checkbox">
            <label>
                <input name="method" type="radio" class="input-check" value="paypal" data-tabid="paypal" data-action="{{route('product.paypal.submit')}}">
                <span>{{__('Paypal')}}</span>
            </label>
        </div>
    </div>
</div>
@endif
{{-- End: Paypal Area --}}


{{-- Start: Stripe Area --}}
@if ($stripe->status == 1)
<div class="option-block">
    <div class="checkbox">
        <label>
            <input name="method" class="input-check" type="radio" value="stripe" data-tabid="stripe" data-action="{{route('product.stripe.submit')}}">
            <span>{{__('Stripe')}}</span>
        </label>
    </div>
</div>


<div class="row gateway-details" id="tab-stripe">

    <div class="col-md-6 mb-4">
        <div class="field-label">{{__('Card Number')}} *</div>
        <div class="field-input">
            <input type="text" class="card-elements" name="cardNumber" placeholder="{{ __('Card Number')}}" autocomplete="off" oninput="validateCard(this.value);" />
        </div>
        @error('cardNumber')
        <p class="text-danger">{{convertUtf8($message)}}</p>
        @enderror
        <span id="errCard" class="text-danger"></span>
    </div>
    <div class="col-md-6 mb-4">
        <div class="field-label">{{__('CVC')}} *</div>
        <div class="field-input">
            <input type="text" class="card-elements" placeholder="{{ __('CVC') }}" name="cardCVC" oninput="validateCVC(this.value);">
        </div>
        @error('cardCVC')
        <p class="text-danger">{{convertUtf8($message)}}</p>
        @enderror
        <span id="errCVC text-danger"></span>
    </div>
    <div class="col-md-6 mb-4">
        <div class="field-label">{{__('Month')}} *</div>
        <div class="field-input">
            <input type="text" class="card-elements" placeholder="{{__('Month')}}" name="month">
        </div>
        @error('month')
        <p class="text-danger">{{convertUtf8($message)}}</p>
        @enderror
    </div>
    <div class="col-md-6 mb-4">
        <div class="field-label">{{__('Year')}} *</div>
        <div class="field-input">
            <input type="text" class="card-elements" placeholder="{{__('Year')}}" name="year">
        </div>
        @error('year')
        <p class="text-danger">{{convertUtf8($message)}}</p>
        @enderror
    </div>
</div>
@endif
{{-- End: Stripe Area --}}



{{-- Start: Paystack Area --}}
@if ($paystackData->status == 1)
<div class="option-block">
    <div class="radio-block">
        <div class="checkbox">
            <label>
                <input name="method" type="radio" class="input-check" value="paystack" data-tabid="paystack" data-action="{{route('product.paystack.submit')}}">
                <span>{{__('Paystack')}}</span>
            </label>
        </div>
    </div>
</div>

<div class="row gateway-details" id="tab-paystack">
    <input type="hidden" name="txnid" id="ref_id" value="">
    <input type="hidden" name="sub" id="sub" value="0">
    <input type="hidden" name="method" value="Paystack">
</div>
@endif
{{-- End: Paystack Area --}}




{{-- Start: Flutterwave Area --}}
@if ($flutterwave->status == 1)
<div class="option-block">
    <div class="radio-block">
        <div class="checkbox">
            <label>
                <input name="method" type="radio" class="input-check" value="flutterwave" data-tabid="flutterwave" data-action="{{route('product.flutterwave.submit')}}">
                <span>{{__('Flutterwave')}}</span>
            </label>
        </div>
    </div>
</div>

<div class="row gateway-details" id="tab-flutterwave">
    <input type="hidden" name="method" value="Flutterwave">
</div>
@endif
{{-- End: Flutterwave Area --}}



{{-- Start: Razorpay Area --}}
@if ($razorpay->status == 1)
<div class="option-block">
    <div class="radio-block">
        <div class="checkbox">
            <label>
                <input name="method" type="radio" class="input-check" value="razorpay" data-tabid="razorpay" data-action="{{route('product.razorpay.submit')}}">
                <span>{{__('Razorpay')}}</span>
            </label>
        </div>
    </div>
</div>

<div class="row gateway-details" id="tab-razorpay">
    <input type="hidden" name="method" value="Razorpay">
</div>
@endif
{{-- End: Razorpay Area --}}



{{-- Start: Instamojo Area --}}
@if ($instamojo->status == 1)
<div class="option-block">
    <div class="radio-block">
        <div class="checkbox">
            <label>
                <input name="method" type="radio" class="input-check" value="instamojo" data-tabid="instamojo" data-action="{{route('product.instamojo.submit')}}">
                <span>{{__('Instamojo')}}</span>
            </label>
        </div>
    </div>
</div>

<div class="row gateway-details" id="tab-instamojo">
    <input type="hidden" name="method" value="Instamojo">
</div>
@endif
{{-- End: Instamojo Area --}}



{{-- Start: Paytm Area --}}
@if ($paytm->status == 1)
<div class="option-block">
    <div class="radio-block">
        <div class="checkbox">
            <label>
                <input name="method" type="radio" class="input-check" value="paytm" data-tabid="paytm" data-action="{{route('product.paytm.submit')}}">
                <span>{{__('Paytm')}}</span>
            </label>
        </div>
    </div>
</div>
@endif
{{-- End: Paytm Area --}}



{{-- Start: PayUmoney Area --}}
@if ($payumoney->status == 1)
<div class="option-block">
    <div class="checkbox">
        <label>
            <input name="method" class="input-check" type="radio" value="payumoney" data-tabid="payumoney" data-action="{{route('product.payumoney.submit')}}">
            <span>{{__('PayUmoney')}}</span>
        </label>
    </div>
</div>


<div class="row gateway-details" id="tab-payumoney">

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
{{-- End: PayUmoney Area --}}





{{-- Start: Mollie Payment Area --}}
@if ($mollie->status == 1)
<div class="option-block">
    <div class="radio-block">
        <div class="checkbox">
            <label>
                <input name="method" type="radio" class="input-check" value="mollie" data-tabid="mollie" data-action="{{route('product.mollie.submit')}}">
                <span>{{__('Mollie Payment')}}</span>
            </label>
        </div>
    </div>
</div>
@endif
{{-- End: Mollie Payment Area --}}




{{-- Start:Mercadopago Area --}}
@if ($mercadopago->status == 1)
<div class="option-block">
    <div class="radio-block">
        <div class="checkbox">
            <label>
                <input name="method" type="radio" class="input-check" value="mercadopago" data-tabid="mercadopago" data-action="{{route('product.mercadopago.submit')}}">
                <span>{{__('Mercadopago')}}</span>
            </label>
        </div>
    </div>
</div>
@endif
{{-- End:Mercadopago Area --}}




{{-- Start: Offline Gateways Area --}}
@foreach ($ogateways as $ogateway)
    <div class="option-block">
        <div class="checkbox">
            <label>
            <input name="method" class="input-check" type="radio" value="{{$ogateway->id}}" data-tabid="{{$ogateway->id}}" data-action="{{route('product.offline.submit', $ogateway->id)}}">
                <span>{{$ogateway->name}}</span>
            </label>
        </div>
    </div>

    <p class="gateway-desc">{{$ogateway->short_description}}</p>

    <div class="gateway-details row" id="tab-{{$ogateway->id}}">
        <div class="col-12">
            <div class="gateway-instruction">
                {!! replaceBaseUrl($ogateway->instructions) !!}
            </div>
        </div>

        @if ($ogateway->is_receipt == 1)
            <div class="col-12 mb-4">
                <label for="" class="d-block">{{__('Receipt')}} **</label>
                <input type="file" name="receipt">
                <p class="mb-0 text-warning">** {{__('Receipt image must be .jpg / .jpeg / .png')}}</p>
            </div>
        @endif
    </div>
@endforeach


@if ($errors->has('receipt'))
    <p class="text-danger mb-4">{{$errors->first('receipt')}}</p>
@endif
{{-- End: Offline Gateways Area --}}



<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="lc" value="UK">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="ref_id" id="ref_id" value="">
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest">
<input type="hidden" name="user_id" value="{{$user->id}}">
<input type="hidden" name="currency_sign" value="$">

