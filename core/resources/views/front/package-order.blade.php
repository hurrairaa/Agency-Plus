@extends("front.$version.layout")

@section('pagename')
 - {{__('Order of') . ' ' . $package->title}}
@endsection

@section('meta-keywords', "$package->meta_keywords")
@section('meta-description', "$package->meta_description")

@section('content')
  <!--   breadcrumb area start   -->
  <div class="breadcrumb-area" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
     <div class="container">
        <div class="breadcrumb-txt">
           <div class="row">
              <div class="col-xl-7 col-lg-8 col-sm-10">
                 <span>{{__('Package Order')}}</span>
                 <h1>{{__('Place Order for')}} <p class="d-inline-block" style="color:#{{$bs->base_color}};">{{convertUtf8($package->title)}}</p></h1>
                 <ul class="breadcumb">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                    <li>{{__('Package Order')}}</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
     <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
  </div>
  <!--   breadcrumb area end    -->


  <!--   quote area start   -->
  <div class="quote-area pt-110 pb-115">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <form class="pay-form" action="
            @if(count($gateways) == 0)
            {{route('front.packageorder.submit')}}
            @endif"
            enctype="multipart/form-data" method="POST">

            @csrf
            <input type="hidden" name="package_id" value="{{$package->id}}">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-element mb-4">
                        <label>{{__('Name')}} <span>**</span></label>
                        <input name="name" type="text" value="{{old("name")}}" placeholder="{{__('Enter Name')}}">

                        @if ($errors->has("name"))
                        <p class="text-danger mb-0">{{$errors->first("name")}}</p>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-element mb-4">
                        <label>{{__('Email')}} <span>**</span></label>
                        <input name="email" type="text" value="{{old("email")}}" placeholder="{{__('Enter Email Address')}}">

                        @if ($errors->has("email"))
                        <p class="text-danger mb-0">{{$errors->first("email")}}</p>
                        @endif
                    </div>
                </div>

                @foreach ($inputs as $input)

                    <div class="{{$input->type == 4 || $input->type == 3 ? 'col-lg-12' : 'col-lg-6'}}">
                        <div class="form-element mb-4">
                            @if ($input->type == 1)
                                <label>{{convertUtf8($input->label)}} @if($input->required == 1) <span>**</span> @endif</label>
                                <input name="{{$input->name}}" type="text" value="{{old("$input->name")}}" placeholder="{{convertUtf8($input->placeholder)}}">
                            @endif

                            @if ($input->type == 2)
                                <label>{{convertUtf8($input->label)}} @if($input->required == 1) <span>**</span> @endif</label>
                                <select name="{{$input->name}}">
                                    <option value="" selected disabled>{{convertUtf8($input->placeholder)}}</option>
                                    @foreach ($input->package_input_options as $option)
                                        <option value="{{convertUtf8($option->name)}}" {{old("$input->name") == convertUtf8($option->name) ? 'selected' : ''}}>{{convertUtf8($option->name)}}</option>
                                    @endforeach
                                </select>
                            @endif

                            @if ($input->type == 3)
                                <label>{{convertUtf8($input->label)}} @if($input->required == 1) <span>**</span> @endif</label>
                                @foreach ($input->package_input_options as $option)
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" id="customCheckboxInline{{$option->id}}" name="{{$input->name}}[]" class="custom-control-input" value="{{convertUtf8($option->name)}}" {{is_array(old("$input->name")) && in_array(convertUtf8($option->name), old("$input->name")) ? 'checked' : ''}}>
                                        <label class="custom-control-label" for="customCheckboxInline{{$option->id}}">{{convertUtf8($option->name)}}</label>
                                    </div>
                                @endforeach
                            @endif

                            @if ($input->type == 4)
                                <label>{{convertUtf8($input->label)}} @if($input->required == 1) <span>**</span> @endif</label>
                                <textarea name="{{$input->name}}" id="" cols="30" rows="10" placeholder="{{convertUtf8($input->placeholder)}}">{{old("$input->name")}}</textarea>
                            @endif

                            @if ($errors->has("$input->name"))
                            <p class="text-danger mb-0">{{$errors->first("$input->name")}}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($ndaIn->active == 1)
            <div class="row mb-4">
              <div class="col-lg-12">
                <div class="form-element mb-2">
                  <label>{{__('NDA File')}} @if($ndaIn->required == 1) <span>**</span> @endif</label>
                  <input type="file" name="nda" value="">
                </div>
                <p class="text-warning mb-0">** {{__('Only doc, docx, pdf, rtf, txt, zip, rar files are allowed')}}</p>
                @if ($errors->has('nda'))
                  <p class="text-danger mb-0">{{$errors->first('nda')}}</p>
                @endif
              </div>
            </div>
            @endif


            @if (count($gateways) + count($ogateways) > 0)
            <div class="row mb-4">
                <div class="col-lg-6">
                    <div class="form-element mb-2">
                        <label>{{__('Pay Via')}}  <span>**</span></label>
                        <select name="method" id="method" class="option input-field" required="">
                            @foreach($gateways as $paydata)
                                <option value="{{ $paydata->name }}" data-form="{{ $paydata->showCheckoutLink() }}" data-show="{{ $paydata->showForm() }}" data-href="{{ route('front.load.payment',['slug' => $paydata->showKeyword(),'id' => $paydata->id]) }}" data-val="{{ $paydata->keyword }}">

                                    {{$paydata->name}}

                                </option>
                             @endforeach

                             @if (!empty($ogateways))
                                @foreach($ogateways as $ogateway)
                                    <option value="{{ $ogateway->name }}" data-form="{{ route('front.offline.submit', $ogateway->id) }}" data-show="yes" data-href="{{ route('front.load.payment',['slug' => "offline",'id' => $ogateway->id]) }}" data-val="offline">

                                        {{ $ogateway->name }}

                                    </option>
                                @endforeach
                             @endif

                        </select>

                        @if ($errors->has('receipt'))
                            <p class="text-danger">{{$errors->first('receipt')}}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- show payment form here if available --}}
            <div id="payments" class="d-none">

            </div>


            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="no_note" value="1">
            <input type="hidden" name="lc" value="UK">
            <input type="hidden" name="currency_code" id="currency_name" value="USD">
            <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest">
            <input type="hidden" name="sub" id="sub" value="0">

            <div class="row">
              <div class="col-lg-12">
                <button type="submit" name="button">{{__('Submit')}}</button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0">
            @includeIf("front.$version.package-order")
        </div>
      </div>
    </div>
  </div>
  <!--   quote area end   -->
@endsection


@section('scripts')

<script src="https://js.paystack.co/v1/inline.js"></script>

@if (count($gateways) + count($ogateways) > 0)
<script>
$(document).ready(function() {
    changeGateway();
})
</script>
@endif


<script>

function changeGateway() {
    var val  = $('#method').find(':selected').attr('data-val');
    var form = $('#method').find(':selected').attr('data-form');
    var show = $('#method').find(':selected').attr('data-show');
    var href = $('#method').find(':selected').attr('data-href');


    if(show == "yes") {
        $('#payments').removeClass('d-none');
    } else {
        $('#payments').addClass('d-none');
    }

    if(val == 'paystack'){
        $('.pay-form').prop('id','paystack');
    }

    $('#payments').load(href);
    $('.pay-form').attr('action',form);
}

$('#method').on('change',function() {
    changeGateway();
});

$(document).on('submit','#paystack',function(){
    var val = $('#sub').val();
    if(val == 0){
        var total = {{$package->price}};
        var curr =  "{{$bex->base_currency_text}}";
        total = Math.round(total);
        var handler = PaystackPop.setup({
        key: "{{ $paystack['key']}}",
        email: "{{ $paystack['email']}}",
        amount: total * 100,
        currency: curr,
        ref: ''+Math.floor((Math.random() * 1000000000) + 1),
            callback: function(response){
                $('#ref_id').val(response.reference);
                $('#sub').val('1');
                $('#paystack button[type="submit"]').click();
            },
            onClose: function(){
                window.location.reload();
            }
        });
        handler.openIframe();
        return false;

    } else {
        return true;
    }
});

</script>
@endsection
