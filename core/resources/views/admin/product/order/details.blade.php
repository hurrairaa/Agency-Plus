@extends('admin.layout')
@section('content')
<div class="page-header">
   <h4 class="page-title">Order Details</h4>
   <ul class="breadcrumbs">
      <li class="nav-home">
         <a href="{{route('admin.dashboard')}}">
         <i class="flaticon-home"></i>
         </a>
      </li>
      <li class="separator">
         <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
         <a href="{{url()->previous()}}">Order</a>
      </li>
      <li class="separator">
         <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
         <a href="#">{{__('Order Details')}}</a>
      </li>
   </ul>
</div>
<div class="row">
    <div class="col-md-4">
       <div class="card">
          <div class="card-header">
             <div class="card-title d-inline-block">Order  [ {{ $order->order_number}} ]</div>

          </div>
          <div class="card-body pt-5 pb-5">
             <div class="payment-information">
                 <div class="row mb-2">
                     <div class="col-lg-6">
                         <strong>{{__('Payment Status')}} :</strong>
                     </div>
                     <div class="col-lg-6">
                         @if($order->payment_status =='Pending' || $order->payment_status == 'pending')
                         <span class="badge badge-danger">{{convertUtf8($order->payment_status)}}  </span>
                         @else
                         <span class="badge badge-success">{{convertUtf8($order->payment_status)}}  </span>
                         @endif
                     </div>
                 </div>

                 <div class="row mb-2">
                     <div class="col-lg-6">
                         <strong>{{__('Order Status')}} :</strong>
                     </div>
                     <div class="col-lg-6">
                         @if ($order->order_status == 'pending')
                         <span class="badge badge-warning">{{convertUtf8($order->order_status)}}  </span>
                         @elseif ($order->order_status == 'processing')
                         <span class="badge badge-primary">{{convertUtf8($order->order_status)}}  </span>
                         @elseif ($order->order_status == 'completed')
                         <span class="badge badge-success">{{convertUtf8($order->order_status)}}  </span>
                         @elseif ($order->order_status == 'reject')
                         <span class="badge badge-danger">{{convertUtf8($order->order_status)}}  </span>
                         @endif
                     </div>
                 </div>

                 <div class="row mb-2">
                     <div class="col-lg-6">
                         <strong>{{__('Paid amount')}} :</strong>
                     </div>
                     <div class="col-lg-6">
                        {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} {{$order->total}} {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}
                     </div>
                 </div>

                 <div class="row mb-2">
                     <div class="col-lg-6">
                         <strong>{{__('Shipping Charge')}} :</strong>
                     </div>
                     <div class="col-lg-6">
                        {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} {{$order->shipping_charge}} {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}
                     </div>
                 </div>

                 <div class="row mb-2">
                     <div class="col-lg-6">
                         <strong>{{__('Payment Method')}} :</strong>
                     </div>
                     <div class="col-lg-6">
                         {{convertUtf8($order->method)}}
                     </div>
                 </div>


                 <div class="row mb-0">
                     <div class="col-lg-6">
                         <strong>{{__('Order Date')}} :</strong>
                     </div>
                     <div class="col-lg-6">
                        {{convertUtf8($order->created_at->format('d-m-Y'))}}
                     </div>
                 </div>

             </div>
          </div>
       </div>

    </div>

    <div class="col-md-4">
       <div class="card">
          <div class="card-header">
             <div class="card-title d-inline-block">Shipping Details</div>

          </div>
          <div class="card-body pt-5 pb-5">
             <div class="payment-information">
                 <div class="row mb-2">
                     <div class="col-lg-6">
                         <strong>{{__('Email')}} :</strong>
                     </div>
                     <div class="col-lg-6">
                        {{convertUtf8($order->shpping_email)}}
                     </div>
                 </div>

                 <div class="row mb-2">
                     <div class="col-lg-6">
                         <strong>{{__('Phone')}} :</strong>
                     </div>
                     <div class="col-lg-6">
                        {{$order->shpping_number}}
                     </div>
                 </div>

                 <div class="row mb-2">
                     <div class="col-lg-6">
                         <strong>{{__('City')}} :</strong>
                     </div>
                     <div class="col-lg-6">
                        {{convertUtf8($order->shpping_city)}}
                     </div>
                 </div>

                 <div class="row mb-2">
                     <div class="col-lg-6">
                         <strong>{{__('Address')}} :</strong>
                     </div>
                     <div class="col-lg-6">
                        {{convertUtf8($order->shpping_address)}}
                     </div>
                 </div>

                 <div class="row mb-0">
                     <div class="col-lg-6">
                         <strong>{{__('Country')}} :</strong>
                     </div>
                     <div class="col-lg-6">
                         {{convertUtf8($order->billing_country)}}
                     </div>
                 </div>


             </div>
          </div>
       </div>

    </div>

    <div class="col-md-4">
       <div class="card">
          <div class="card-header">
             <div class="card-title d-inline-block">Billing Details</div>

          </div>
          <div class="card-body pt-5 pb-5">
             <div class="payment-information">
                 <div class="row mb-2">
                     <div class="col-lg-6">
                         <strong>{{__('Email')}} :</strong>
                     </div>
                     <div class="col-lg-6">
                        {{convertUtf8($order->billing_email)}}
                     </div>
                 </div>

                 <div class="row mb-2">
                     <div class="col-lg-6">
                         <strong>{{__('Phone')}} :</strong>
                     </div>
                     <div class="col-lg-6">
                        {{$order->billing_number}}
                     </div>
                 </div>

                 <div class="row mb-2">
                     <div class="col-lg-6">
                         <strong>{{__('City')}} :</strong>
                     </div>
                     <div class="col-lg-6">
                        {{convertUtf8($order->billing_city)}}
                     </div>
                 </div>

                 <div class="row mb-2">
                     <div class="col-lg-6">
                         <strong>{{__('Address')}} :</strong>
                     </div>
                     <div class="col-lg-6">
                        {{convertUtf8($order->billing_address)}}
                     </div>
                 </div>

                 <div class="row mb-0">
                     <div class="col-lg-6">
                         <strong>{{__('Country')}} :</strong>
                     </div>
                     <div class="col-lg-6">
                         {{convertUtf8($order->billing_country)}}
                     </div>
                 </div>


             </div>
          </div>
       </div>

    </div>

   <div class="col-lg-12">
    <div class="card">
       <div class="card-header">
          <h4 class="card-title">Order Product</h4>
       </div>
       <div class="card-body">
          <div class="table-responsive product-list">
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
                   @foreach ($order->orderitems as $key => $item)
                   <tr>
                      <td>{{$key+1}}</td>
                      <td><img src="{{asset('assets/front/img/product/featured/'.$item->image)}}" alt="product" width="100"></td>
                      <td>{{convertUtf8($item->title)}}</td>
                      <td>
                         <b>{{__('Quantity')}}:</b> <span>{{$item->qty}}</span><br>
                      </td>
                      <td>{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$item->price}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</td>
                      <td>{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$item->price * $item->qty}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</td>
                   </tr>
                   @endforeach
                </tbody>
             </table>
          </div>
       </div>
    </div>
 </div>
</div>
@endsection
