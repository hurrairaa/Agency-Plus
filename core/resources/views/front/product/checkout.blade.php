@extends("front.$version.layout")

@section('pagename')
 -
 {{__('Checkout')}}
@endsection

@section('meta-keywords', "$be->checkout_meta_keywords")
@section('meta-description', "$be->checkout_meta_description")

@section('content')
<!--   hero area start   -->
<div class="breadcrumb-area services service-bg" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
    <div class="container">
        <div class="breadcrumb-txt">
            <div class="row">
                <div class="col-xl-7 col-lg-8 col-sm-10">
                    <span>{{convertUtf8($be->checkout_title)}}</span>
                    <h1>{{convertUtf8($be->checkout_subtitle)}}</h1>
                    <ul class="breadcumb">
                        <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                        <li>{{__('Checkout')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-area-overlay"></div>
</div>
<!--   hero area end    -->



    <!--====== CHECKOUT PART START ======-->
    <section class="checkout-area">
        <form action="{{route('product.paypal.submit')}}" method="POST" id="payment" enctype="multipart/form-data">
            @csrf
            @if(Session::has('stock_error'))
            <p class="text-danger text-center my-3">{{Session::get('stock_error')}}</p>
            @endif
        <div class="container">

            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="form billing-info">
                        <div class="shop-title-box">
                            <h3>{{__('Billing Address')}}</h3>
                        </div>
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="field-label">{{__('Country')}} *</div>
                                    <div class="field-input">
                                        <input type="text" name="billing_country" value="{{convertUtf8($user->billing_country)}}">
                                    </div>
                                    @error('billing_country')
                                        <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="field-label">{{__('First Name')}} *</div>
                                    <div class="field-input">
                                        <input type="text" name="billing_fname" value="{{convertUtf8($user->billing_fname)}}">
                                    </div>
                                    @error('billing_fname')
                                        <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="field-label">{{__('Last Name')}} *</div>
                                    <div class="field-input">
                                        <input type="text" name="billing_lname" value="{{convertUtf8($user->billing_lname)}}">
                                    </div>
                                    @error('billing_lname')
                                        <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="field-label">{{__('Address')}} *</div>
                                    <div class="field-input">
                                        <input type="text" name="billing_address" value="{{convertUtf8($user->billing_address)}}">
                                    </div>
                                    @error('billing_address')
                                        <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <div class="field-label">{{__('Town / City')}} *</div>
                                    <div class="field-input">
                                        <input type="text" name="billing_city" value="{{convertUtf8($user->billing_city)}}">
                                    </div>
                                    @error('billing_city')
                                    <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="field-label">{{__('Contact Email')}} *</div>
                                    <div class="field-input">
                                        <input type="text" name="billing_email" value="{{convertUtf8($user->billing_email)}}">
                                    </div>
                                    @error('billing_email')
                                    <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="field-label">{{__('Phone')}} *</div>
                                    <div class="field-input">
                                        <input type="text" name="billing_number" value="{{convertUtf8($user->billing_number)}}">
                                    </div>
                                    @error('billing_number')
                                    <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                                    @enderror
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="form shipping-info">
                        <div class="shop-title-box">
                            <h3>{{__('Shipping Address')}}</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="field-label">{{__('Country')}} *</div>
                                <div class="field-input">
                                    <input type="text" name="shpping_country" value="{{convertUtf8($user->shpping_country)}}">
                                </div>
                                @error('shpping_country')
                                    <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="field-label">{{__('First Name')}} *</div>
                                <div class="field-input">
                                    <input type="text" name="shpping_fname" value="{{convertUtf8($user->shpping_fname)}}">
                                </div>
                                @error('shpping_fname')
                                <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="field-label">{{__('Last Name')}} *</div>
                                <div class="field-input">
                                    <input type="text" name="shpping_lname" value="{{convertUtf8($user->shpping_lname)}}">
                                </div>
                                @error('shpping_lname')
                                <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="field-label">{{__('Address')}} *</div>
                                <div class="field-input">
                                    <input type="text" name="shpping_address" value="{{convertUtf8($user->shpping_address)}}">
                                </div>
                                @error('shpping_address')
                                <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="field-label">{{__('Town / City')}} *</div>
                                <div class="field-input">
                                    <input type="text" name="shpping_city" value="{{convertUtf8($user->shpping_city)}}">
                                </div>
                                @error('shpping_city')
                                <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="field-label">{{__('Contact Email')}} *</div>
                                <div class="field-input">
                                    <input type="text" name="shpping_email" value="{{convertUtf8($user->shpping_email)}}">
                                </div>
                                @error('shpping_email')
                                <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="field-label">{{__('Phone')}} *</div>
                                <div class="field-input">
                                    <input type="text" name="shpping_number" value="{{convertUtf8($user->shpping_number)}}">
                                </div>
                                @error('shpping_number')
                                <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12 mb-5">
                        <div class="table">
                            <div class="shop-title-box">
                                <h3>{{__('Shipping Methods')}}</h3>
                            </div>
                            <table class="cart-table shipping-method">
                                <thead class="cart-header">
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('Method')}}</th>
                                        <th class="price">{{__('Cost')}}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if($shippings)
                                    @foreach ($shippings as $key => $charge)
                                    <tr>
                                        <td>
                                            <input type="radio" {{$key == 0 ? 'checked' : ''}} name="shipping_charge" {{$cart == null ? 'disabled' : ''}} data="{{$charge->charge}}"   class="shipping-charge"  value="{{$charge->id}}">
                                        </td>
                                        <td>
                                        <p class="mb-2"><strong>{{convertUtf8($charge->title)}}</strong></p>
                                            <p><small>{{convertUtf8($charge->text)}}</small></p>
                                        </td>
                                        <td>{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} <span>{{$charge->charge}}</span> {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td>
                                            <input type="radio" checked name="shipping_charge" {{$cart == null ? 'disabled' : ''}} data="0"   class="shipping-charge"  value="0">
                                        </td>
                                        <td>
                                        <p class="mb-2"><strong>{{__('Free Shipping')}}</strong></p>
                                            <p><small>{{__('10 to 15 days')}}</small></p>
                                        </td>
                                        <td>$ <span>0</span></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="table">
                            <div class="shop-title-box">
                                <h3>{{__('Order Summary')}}</h3>
                            </div>
                            <table class="cart-table">
                                <thead class="cart-header">
                                    <tr>
                                        <th class="product-column">{{__('Product')}}</th>
                                        <th>&nbsp;</th>
                                        <th>{{__('Quantity')}}</th>
                                        <th class="price">{{__('Total')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total = 0;
                                    @endphp
                                    @if($cart)
                                    @foreach ($cart as $key => $item)
                                    <input type="hidden" name="product_id[]" value="{{$key}}" >
                                    @php
                                        $total += $item['price'] * $item['qty'];
                                        $product = App\Product::findOrFail($key);

                                    @endphp
                                    <tr>
                                        <td colspan="2" class="product-column">
                                            <div class="column-box">
                                                <div class="prod-thumb">
                                                   <img src="{{asset('assets/front/img/product/featured/'.$item['photo'])}}" alt="">
                                                </div>
                                                <div class="product-title">
                                                    <a target="_blank" href="{{route('front.product.details',$product->slug)}}"><h3 class="prod-title">{{convertUtf8($item['name'])}}</h3></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="qty">
                                            <input class="quantity-spinner" disabled type="text" value="{{$item['qty']}}" name="quantity">
                                        </td>
                                        <td class="price">{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$item['qty'] * $item['price']}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr class="text-center">
                                    <td colspan="4">{{__('Cart is empty')}}</td>
                                    </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="cart-total">
                            <div class="shop-title-box">
                                <h3>{{__('Cart Totals')}}</h3>
                            </div>
                            <ul class="cart-total-table">
                                <li class="clearfix">
                                    <span class="col col-title">{{__('Cart Subtotal')}}</span>
                                    <span class="col">{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} <span data="{{round($total,2)}}" class="subtotal">{{round($total,2)}}</span> {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</span>
                                </li>


                                @if (sizeof($shippings) > 0)
                                    <li class="clearfix">
                                        <span class="col col-title">{{__('Shipping Charge')}}</span>
                                        <span class="col">{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} <span data="{{$shippings ? round($shippings[0]->charge,2) : 0}}" class="shipping">{{$shippings ? round($shippings[0]->charge,2) : 0}}</span> {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</span>
                                    </li>
                                    <li class="clearfix">
                                        <span class="col col-title">{{__('Order Total')}}</span>
                                        <span class="col">{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} <span data="{{$shippings ? round($total + $shippings[0]->charge,2) : $total }}" class="grandTotal">{{$shippings ? round($total + $shippings[0]->charge,2) : $total }}</span> {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</span>
                                    </li>
                                @endif


                            </ul>

                            <div class="payment-options">
                                <h4 class="mb-4">{{__('Pay Via')}}</h4>


                                @includeIf('front.product.payment-gateways')


                                <div class="placeorder-button text-left">
                                    <button {{$cart ? '' : 'disabled' }}  class="main-btn" type="submit"><span class="btn-title">{{__('Place Order')}}</span></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </section>

    <!--====== CHECKOUT PART ENDS ======-->
@endsection


@section('scripts')
<script src="https://js.stripe.com/v2/"></script>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    $('.shipping-charge').on('click','',function(){
        let total = 0;
        let subtotal  = 0;
        let grantotal  = 0;
        let shipping  = 0;

        subtotal = parseFloat($('.subtotal').attr('data'));
        grantotal = parseFloat($('.grandTotal').attr('data'));
        shipping = parseFloat($('.shipping').attr('data'));

        let shipCharge = parseFloat($(this).attr('data'));

        shipping = parseFloat(shipCharge);
        total = parseFloat(parseFloat(grantotal) + parseFloat(shipCharge));
        $('.shipping').text(shipping);
        $('.grandTotal').text(total);


    })

    $(document).ready(function() {
        $(".input-check").first().attr('checked', true);

        let tabid = $(".input-check:checked").data('tabid');

        $('#payment').attr('action', $(".input-check:checked").data('action'));

        showDetails(tabid);
    });

    // this function will decide which form to show...
    function showDetails(tabid) {

        $(".gateway-details").removeClass("d-flex");
        $(".gateway-details").addClass("d-none");

        if ($("#tab-"+tabid).length > 0) {
            $("#tab-"+tabid).addClass("d-flex");
        }

        if(tabid == 'paystack'){
            $('#payment').prop('id','paystack');
        }

    }

    // on gateway change...
    $(document).on('click','.input-check',function(){
        // change form action
        $('#payment').attr('action', $(this).data('action'));
        // show relevant form (if any)
        showDetails($(this).data('tabid'));
    });

    // after paystack form is submitted
    $(document).on('submit','#paystack',function(){
        var val = $('#sub').val();
        if(val == 0){
            var total = $(".grandTotal").text();
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


    var cnstatus = false;
    var dateStatus = false;
    var cvcStatus = false;

    function validateCard(cn) {
    cnstatus = Stripe.card.validateCardNumber(cn);
    if (!cnstatus) {
        $("#errCard").html('Card number not valid<br>');
    } else {
        $("#errCard").html('');
    }
    //   btnStatusChange();


    }

    function validateCVC(cvc) {
        cvcStatus = Stripe.card.validateCVC(cvc);
        if (!cvcStatus) {
            $("#errCVC").html('CVC number not valid');
        } else {
            $("#errCVC").html('');
        }
        //   btnStatusChange();
    }
</script>
@endsection
