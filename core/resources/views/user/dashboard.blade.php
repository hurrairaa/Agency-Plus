@extends('user.layout')

@section('pagename')
 - {{__('Dashboard')}}
@endsection

@section('content')

    <!--   hero area start   -->
    <div class="breadcrumb-area services service-bg" style="background-image: url('{{asset  ('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
        <div class="container">
            <div class="breadcrumb-txt">
                <div class="row">
                    <div class="col-xl-7 col-lg-8 col-sm-10">
                        <h1>{{__('Dashboard')}}</h1>
                        <ul class="breadcumb">
                            <li>{{__('Dashboard')}}</li>
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
                <div class="row mb-5">
                    <div class="col-lg-6">
                        <div class="user-profile-details">
                            <div class="account-info">
                                <div class="title">
                                    <h4>{{__('Account Information')}}</h4>
                                </div>
                                <div class="main-info">
                                    <h5>{{convertUtf8($user->username)}}</h5>
                                    <ul class="list">
                                        <li><span>{{__('Email')}}:</span></li>
                                        <li><span>{{__('Phone')}}:</span></li>
                                        <li><span>{{__('City')}}:</span></li>
                                        <li><span>{{__('State')}}:</span></li>
                                        <li><span>{{__('Address')}}:</span></li>
                                        <li><span>{{__('Country')}}:</span></li>
                                    </ul>
                                    <ul class="list">
                                        <li>{{convertUtf8($user->email)}}</li>
                                        <li>{{convertUtf8($user->number)}}</li>
                                        <li>{{convertUtf8($user->fax)}}</li>
                                        <li>{{convertUtf8($user->city)}}</li>
                                        <li>{{convertUtf8($user->state)}}</li>
                                        <li>{{convertUtf8($user->address)}}</li>
                                        <li>{{convertUtf8($user->country)}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            @if ($bex->is_shop == 1)
                            <div class="col-md-12">
                                <a class="card card-box box-1 mb-4" href="{{route('user-orders')}}">
                                    <div class="card-info">
                                        <h4>{{__('Total Orders')}}</h4>
                                        <p>{{App\ProductOrder::where('user_id',Auth::user()->id)->count()}}</p>
                                    </div>
                                </a>
                            </div>
                            @endif

                            @if ($bex->is_ticket == 1)
                            <div class="col-md-12">
                                <a class="card card-box box-2" href="{{route('user-tickets')}}">
                                    <div class="card-info">
                                        <h4>{{__('Total Tickets')}}</h4>
                                        <p>{{App\Ticket::where('user_id',Auth::user()->id)->count()}}</p>
                                    </div>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($bex->is_shop == 1)
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="account-info">
                                <div class="title">
                                    <h4>{{__('Recent Orders')}}</h4>
                                </div>
                                <div class="main-info">
                                    <div class="main-table">
                                        <div class="table-responsiv">
                                            <table id="ordersTable" class="dataTables_wrapper dt-responsive table-striped dt-bootstrap4" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>{{__('Order number')}}r</th>
                                                        <th>{{__('Date')}}</th>
                                                        <th>{{__('Total Price')}}</th>
                                                        <th>{{__('Action')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        @if($orders)
                                                        @foreach ($orders as $order)
                                                        <tr>
                                                        <td>{{$order->order_number}}</td>
                                                            <td>{{$order->created_at->format('d-m-Y')}}</td>
                                                            <td>{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} {{$order->total}} {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</td>
                                                            <td><a href="{{route('user-orders-details',$order->id)}}" class="btn">{{__('Details')}}</a></td>
                                                        </tr>
                                                        @endforeach
                                                        @else
                                                        <tr class="text-center">
                                                            <td colspan="4">
                                                                {{__('No Orders')}}
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#ordersTable').DataTable({
            responsive: true,
            ordering: false
        });
    });
</script>
@endsection
