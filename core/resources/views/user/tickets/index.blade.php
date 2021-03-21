@extends('user.layout')

@section('pagename')
 - {{__('Tickets')}}
@endsection

@section('content')
  <!--   hero area start   -->
  <div class="breadcrumb-area services service-bg" style="background-image: url('{{asset  ('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
    <div class="container">
        <div class="breadcrumb-txt">
            <div class="row">
                <div class="col-xl-7 col-lg-8 col-sm-10">
                    <h1>{{__('My Tickets')}}</h1>
                    <ul class="breadcumb">
                        <li><a href="{{route('user-dashboard')}}">{{__('Dashboard')}}</a></li>
                        <li>{{__('Tickets')}}</li>
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
                            <div class="account-info">
                                <div class="title">
                                    <h4>{{__('My Tickets')}}</h4>
                                    <a href="{{route('user-ticket-create')}}" class="btn btn-primary btn-sm border-0"><i class="fas fa-plus"></i> {{__('Submit Ticket')}}</a>
                                </div>
                                <div class="main-info">
                                    <div class="main-table">
                                    <div class="table-responsiv">
                                        <table id="ticketTable" class="dataTables_wrapper dt-responsive table-striped dt-bootstrap4" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>{{__('Ticket Number')}}</th>
                                                    <th>{{__('Subject')}}</th>
                                                    <th>{{__('Status')}}</th>
                                                    <th>{{__('Messages')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($tickets)

                                                    @foreach ($tickets as $ticket)

                                                    <tr>
                                                        <td># {!! $ticket->ticket_number !!}</td>
                                                        <td>{{convertUtf8($ticket->subject)}}</td>
                                                        <td>
                                                            @if($ticket->status == 'pending')
                                                            <h2 class="d-inline-block badge badge-warning">{{convertUtf8($ticket->status)}}</h2>
                                                            @elseif($ticket->status == 'open')
                                                            <h2 class="d-inline-block badge badge-primary">{{convertUtf8($ticket->status)}}</h2>
                                                            @else
                                                            <h2 class="d-inline-block badge badge-success">{{convertUtf8($ticket->status)}}</h2>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{route('user-ticket-messages',$ticket->ticket_number)}}" class="btn btn-primary border-0 btn-sm">
                                                                <i class="fas fa-comments"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                <tr class="text-center">
                                                    <td colspan="5">{{__('No Tickets')}}</td>
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
                </div>
            </div>
        </div>
    </div>
</section>
<!--    footer section start   -->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#ticketTable').DataTable({
            responsive: true,
            ordering: false
        });
    });
</script>
@endsection
