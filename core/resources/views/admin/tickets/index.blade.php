@extends('admin.layout')

@section('content')
@php
    $staffs = App\Admin::select('id','username')->get();
@endphp
<div class="page-header">
   <h4 class="page-title">
      @if (request()->path()=='admin/all/tickets')
        All
      @elseif (request()->path()=='admin/pending/tickets')
        Pending
      @elseif (request()->path()=='admin/open/tickets')
        Open
      @elseif (request()->path()=='admin/closed/tickets')
        Closed
      @endif
      Tickets
    </h4>
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
         <a href="#">Tickets</a>
      </li>
      <li class="separator">
         <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
         <a href="#">
          @if (request()->path()=='admin/all/tickets')
            All
          @elseif (request()->path()=='admin/pending/tickets')
            Pending
          @elseif (request()->path()=='admin/open/tickets')
            Open
          @elseif (request()->path()=='admin/closed/tickets')
            Closed
          @endif
         Tickets</a>
      </li>
   </ul>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <div class="row">
               <div class="col-lg-4">
                  <div class="card-title d-inline-block">
                     @if (request()->path()=='admin/all/tickets')
                     All
                   @elseif (request()->path()=='admin/pending/tickets')
                     Pending
                   @elseif (request()->path()=='admin/open/tickets')
                     Open
                   @elseif (request()->path()=='admin/closed/tickets')
                     Closed
                   @endif
                     Tickets
                  </div>
               </div>
               <div class="col-lg-3 offset-lg-5 mt-2 mt-lg-0">
                  <form action="{{url()->current()}}" method="GET">
                      <input class="form-control" type="text" name="search" value="{{request()->input('search') ? request()->input('search') : ''}}" placeholder="Enter ticket number / subject to seach">
                  </form>
               </div>
            </div>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-lg-12">
                  @if($tickets->count() == 0)
                  <h3 class="text-center">NO TICKET FOUND</h3>
                  @else
                  <div class="table-responsive">
                     <table class="table table-striped mt-3">
                        <thead>
                           <tr>
                              <th scope="col">Ticket Number</th>
                              <th scope="col">Username</th>
                              <th scope="col">Email</th>
                              <th scope="col">Subject</th>
                              <th scope="col">Status</th>
                              <th scope="col">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($tickets as $ticket)
                           <tr>
                              <td>
                                 #{{$ticket->ticket_number}}
                              </td>
                              <td>{{$ticket->user->username}}</td>
                              <td>{{$ticket->user->email}}</td>
                              <td>{{$ticket->subject}}</td>
                              <td>
                                 @if($ticket->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                                @elseif($ticket->status == 'open')
                                <span class="badge badge-primary">Open</span>
                                @else
                                <span class="badge badge-danger">Closed</span>
                                @endif
                              </td>
                              <td>

                                <div class="btn-group">
                                 <button type="button" class="btn btn-info dropdown-toggle btn btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                     Actions
                                 </button>
                                 <div class="dropdown-menu">
                                    @if(Auth::guard('admin')->user()->id == 1)
                                    @if($ticket->admin_id == 1 )
                                    <a class="dropdown-item click-modal-staff" href="{{$ticket->id}}" data-toggle="modal" data-target="#assignModal">Assign To</a>
                                    @else
                                    @if(Auth::guard('admin')->user()->id == 1)
                                    <a class="dropdown-item click-modal-staff" href="javascript:;" ><span class="badge badge-success">Assigned To {{$ticket->admin->username}}</span></a>
                                    @endif
                                    @endif
                                    <a class="dropdown-item" href="{{route('admin.ticket.messages',$ticket->id)}}">Messages</a>
                                    @else
                                       <a class="dropdown-item" href="{{route('admin.ticket.messages',$ticket->id)}}">Messages</a>
                                    @endif
                                 </div>
                             </div>
                              </td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
                  @endif
               </div>
            </div>
         </div>
         <div class="card-footer">
            <div class="row">
              <div class="d-inline-block mx-auto">
                {{$tickets->appends(['search' => request()->input('search')])->links()}}
              </div>
            </div>
          </div>
      </div>
   </div>
</div>

<!-- Create Ticket Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" role="dialog"                      aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Assign Staff</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="ajaxForm" class="modal-form" action="{{route('ticket.assign.staff')}}"  method="POST">
               @csrf
               <input type="hidden" name="ticket_id" class="ticket_id_get" value="">
               <div class="form-group">
                  <label for="">Staff **</label>
                  <select id="staff" name="staff" class="form-control">
                     <option value="1" selected disabled>Select Staff</option>
                     @foreach ($staffs as $staff)
                     <option value="{{$staff->id}}">{{$staff->username}}</option>
                     @endforeach
                  </select>
                  <p id="errstaff" class="mb-0 text-danger em"></p>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button id="submitBtn" type="button" class="btn btn-primary">Assign</button>
         </div>
      </div>
   </div>
</div>

@endsection
@section('scripts')

<script>
$(document).on('click','.click-modal-staff',function(){
   let ticketIdGet = $(this).attr('href');
   $('.ticket_id_get').val(ticketIdGet);
   console.log(ticketIdGet);
})
</script>

@endsection
