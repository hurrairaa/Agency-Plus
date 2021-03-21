@extends('user.layout')

@section('pagename')
 - {{__('Order')}} [{{$data->order_number}}]
@endsection

@section('content')
    <!--   hero area start   -->
    <div class="breadcrumb-area services service-bg" style="background-image: url('{{asset  ('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
        <div class="container">
            <div class="breadcrumb-txt">
                <div class="row">
                    <div class="col-xl-7 col-lg-8 col-sm-10">
                        <h1>{{__('Order Details')}}</h1>
                        <ul class="breadcumb">
                            <li><a href="{{route('user-dashboard')}}">{{__('Dashboard')}}</a></li>
                            <li>{{__('Order Details')}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb-area-overlay"></div>
    </div>
    <!--   hero area end    -->

    <!--====== CHECKOUT PART START ======-->
    <section class="user-dashbord">
        <div class="container">
            <div class="row">
                @include('user.inc.site_bar')
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="user-profile-details">
                                <div class="order-details">
                                    <div class="progress-area-step">
                                        <ul class="progress-steps">
                                            <li class="{{$data->order_status == 'pending' ? 'active' : ''}}">
                                                <div class="icon"></div>
                                                <div class="progress-title">{{__('Pending')}}</div>
                                            </li>
                                            <li class="{{$data->order_status == 'processing' ? 'active' : ''}}">
                                                <div class="icon"></div>
                                                <div class="progress-title">{{__('Processing')}}</div>
                                            </li>
                                            <li class="{{$data->order_status == 'completed' ? 'active' : ''}}">
                                                <div class="icon"></div>
                                                <div class="progress-title">{{__('Completed')}}</div>
                                            </li>
                                            <li class="{{$data->order_status == 'reject' ? 'active' : ''}}">
                                                <div class="icon"></div>
                                                <div class="progress-title">{{__('Rejected')}}</div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="title">
                                        <h4>{{__('Order Details')}}</h4>
                                    </div>
                                    <div id="print">
                                    <div class="view-order-page">
                                        <div class="order-info-area">
                                            <div class="row align-items-center">
                                                <div class="col-lg-8">
                                                   <div class="order-info">
                                                       <h3>{{__('Order')}} {{$data->order_id}} [{{$data->order_number}}]</h3>
                                                   <p><strong>{{__('Order Date')}}</strong> {{$data->created_at->format('d-m-Y')}}</p>
                                                   </div>
                                                </div>
                                                <div class="col-lg-4 print-btn">
                                                    <div class="prinit">
                                                        <a href="{{asset('assets/front/invoices/product/' . $data->invoice_number)}}" download="invoice.pdf" id="print-click" class="btn"><i class="fas fa-print"></i>{{__('Download Invoice')}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="billing-add-area">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="main-info">
                                                    <h5>{{__('Shipping Details')}}</h5>
                                                    <ul class="list">
                                                        <li><p><span>{{__('Email')}}:</span>{{$data->shpping_email}}</p></li>
                                                        <li><p><span>{{__('Phone')}}:</span>{{$data->shpping_number}}</p></li>
                                                        <li><p><span>{{__('City')}}:</span>{{$data->shpping_city}}</p></li>
                                                        <li><p><span>{{__('Address')}}:</span>{{$data->shpping_address}}</p></li>
                                                        <li><p><span>{{__('Country')}}:</span>{{$data->shpping_country}}</p></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="main-info">
                                                    <h5>{{__('Billing Details')}}</h5>
                                                    <ul class="list">
                                                        <li><p><span>{{__('Email')}}:</span>{{$data->billing_email}}</p></li>
                                                        <li><p><span>{{__('Phone')}}:</span>{{$data->billing_number}}</p></li>
                                                        <li><p><span>{{__('City')}}:</span>{{$data->billing_city}}</p></li>
                                                        <li><p><span>{{__('Address')}}:</span>{{$data->billing_address}}</p></li>
                                                        <li><p><span>{{__('Country')}}:</span>{{$data->billing_country}}</p></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="col-md-4 ">
                                                <div class="payment-information">
                                                    <h5>{{__('Payment Information')}} : </h5>
                                                    <p>{{__('Payment Status')}} :
                                                        @if($data->payment_status =='Pending' || $data->payment_status == 'pending')
                                                        <span class="badge badge-danger">{{$data->payment_status}}  </span>
                                                        @else
                                                        <span class="badge badge-success">{{$data->payment_status}}  </span>
                                                        @endif
                                                    </p>
                                                    <p>{{__('Paid Amount')}} : <span class="amount">{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}

                                                    {{$data->total}}

                                                    {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</span></p>

                                                    <p>
                                                        {{__('Shipping Charge')}} :
                                                        {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}

                                                        {{$data->shipping_charge}}

                                                        {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}
                                                    </p>

                                                    <p>{{__('Payment Method')}} : {{$data->method}}</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive product-list">
                                        <h5>{{__('Ordered Products')}}</h5>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{__('Image')}}</th>
                                                    <th>{{__('Name')}}</th>
                                                    <th>{{__('Details')}}</th>
                                                    <th>{{__('Price')}}</th>
                                                    <th>{{__('Total')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data->orderitems as $key => $order)
                                                @php
                                                    $product = App\Product::findOrFail($order->product_id);
                                                @endphp
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td><img src="{{asset('assets/front/img/product/featured/'.$order->product->feature_image)}}" alt="product" width="100"></td>
                                                    <td><a href="{{route('front.product.details',$product->slug)}}">{{$order->title}}</a></td>
                                                    <td>
                                                        <b>{{__('Quantity')}}:</b> <span>{{$order->qty}}</span><br>
                                                    </td>
                                                    <td>{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$order->price}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</td>
                                                    <td>{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$order->price * $order->qty}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
                                    <div class="edit-account-info">
                                        <a href="{{ URL::previous() }}" class="btn btn-primary">{{__('Back')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

