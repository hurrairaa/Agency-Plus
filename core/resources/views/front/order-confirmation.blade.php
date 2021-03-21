@extends("front.$version.layout")

@section('pagename')
 - {{__('Order Confirmation')}}
@endsection

@section('no-breadcrumb', 'no-breadcrumb')

@section('content')

<div class="order-comfirmation pt-80 pb-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="confirmation-message">
                    <h2 class="text-center">{{__('Thank you for your purchase')}} !</h2>
                    <p class="text-center">
                        <a href="{{route('front.index')}}">{{__('Get Back To Our Homepage')}}</a>
                    </p>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <table class="table">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col" colspan="2">{{__('Order Details')}}</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row">{{__('Order Number')}}:</th>
                                <td>#{{$packageOrder->order_number}}</td>
                              </tr>
                              <tr>
                                <th scope="row">{{__('Order Date')}}:</th>
                                <td>{{$packageOrder->created_at}}</td>
                              </tr>
                              <tr>
                                <th scope="row">{{__('Payment Method')}}:</th>
                                <td class="text-capitalize">
                                    @if (!empty($packageOrder->method))
                                        {{$packageOrder->method}}
                                    @else
                                    -
                                    @endif
                                </td>
                              </tr>
                            </tbody>
                        </table>

                        <table class="table">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col" colspan="2">{{__('Package Details')}}</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row">{{__('Title')}}:</th>
                                <td>{{$packageOrder->package_title}}</td>
                              </tr>
                              <tr>
                                <th scope="row">{{__('Price')}}:</th>
                                <td>{{$bex->base_currency_text_position == 'left' ? $bex->base_currency_text : ''}} {{$packageOrder->package_price}} {{$bex->base_currency_text_position == 'right' ? $bex->base_currency_text : ''}}</td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <table class="table">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col" colspan="2">{{__('Client Details')}}</th>
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">{{__('Client Name')}}:</th>
                                    <td>{{$packageOrder->name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{__('Client Email')}}:</th>
                                    <td>{{$packageOrder->email}}</td>
                                </tr>
                                @foreach ($fields as $key => $field)
                                    @php
                                    if (is_array($field)) {
                                        $str = implode(", ", $field);
                                        $value = $str;
                                    } else {
                                        $value = $field;
                                    }
                                    @endphp

                                    <tr>
                                        <th scope="row" class="text-capitalize">{{str_replace("_"," ",$key)}}:</th>
                                        <td>{{$value}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
