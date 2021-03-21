@extends('admin.layout')
@section('content')
<div class="page-header">
   <h4 class="page-title">Conversations</h4>
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
         <a href="#">Conversations</a>
      </li>
   </ul>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <div class="row">
               <div class="col-lg-4">
               <div class="card-title d-inline-block">Ticket Details - #{{$ticket->ticket_number}}</div>
               </div>
               <div class="col-lg-3 offset-lg-5 mt-2 mt-lg-0 text-right">
                  <a href="{{route('admin.tickets.all')}}" class="btn btn-primary btn-md">Back to Lists</a>
               </div>
            </div>
         </div>
         <div class="card-body">
            <div class="row text-center">
               <div class="col-lg-12">
                  <div class="row">
                     <div class="col-lg-12">
                        <h3 class="text-white">{{$ticket->subject}}</h3>
                        @if($ticket->status != 'close')
                        <button class="close-ticket btn btn-success btn-md" data-href="{{route('admin.ticket.close',$ticket->id)}}"><i class="fas fa-check mr-1"></i> Close Ticket</button>
                        @endif
                     </div>
                     <div class="col-lg-12 my-3">
                        @if($ticket->status == 'pending')
                        <span class="badge badge-warning">Pending</span>
                        @elseif($ticket->status == 'open')
                        <span class="badge badge-primary">Open</span>
                        @else
                        <span class="badge badge-danger">Closed</span>
                        @endif
                        <span class="badge badge-secondary">{{$ticket->created_at->format('d-m-Y')}} {{date("h.i A", strtotime($ticket->created_at))}}</span>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-12">
                        <p style="font-size: 16px;">{!! replaceBaseUrl($ticket->message) !!}</p>
                        @if($ticket->zip_file)
                        <a href="{{asset('assets/front/user-suppor-file/'.$ticket->zip_file)}}" download="{{__('support_file')}}" class="btn btn-primary"><i class="fas fa-download"></i> Download Attachment</a>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="{{$ticket->status == 'close' ? 'col-lg-12' : 'col-lg-6'}}">
    <div class="card card-round">
        <div class="card-body">
           <div class="card-title fw-mediumbold">Replies</div>
           <div class="card-list">
               <div class="messages-container">
                @if(count($ticket->messages) > 0)
                @foreach ($ticket->messages as $reply)
                    @if(!$reply->user_id)
                    @php
                        $admin = App\Admin::find($ticket->admin_id);
                    @endphp
                   <div class="item-list">
                      <div class="avatar">
                         <img src="{{$admin->image ? asset('assets/admin/img/propics/'.$admin->image) : asset('assets/admin/img/propics/blank_user.jpg')}}" alt="..." class="avatar-img rounded-circle">
                      </div>
                      <div class="info-user ml-3">
                         <div class="username">{{$admin->username}}</div>
                         <div class="status">{{$admin->id == 1 ? 'Super Admin' : $admin->role->name}}</div>
                         <p>{!! replaceBaseUrl($reply->reply) !!}</p>
                         @if($reply->file)
                         <a href="{{asset('assets/front/user-suppor-file/'.$ticket->zip_file)}}" download="support_file" class="btn btn-rounded btn-info btn-sm">Download</a>
                         @endif
                      </div>
                   </div>
                  @else
                  @php
                  $user = App\User::findOrFail($ticket->user_id);
                   @endphp
                   <div class="item-list">
                      <div class="avatar">
                         <img src="{{asset('assets/front/img/user/'.$user->photo)}}" alt="..." class="avatar-img rounded-circle">
                      </div>
                      <div class="info-user ml-3">
                         <div class="username">{{$user->username}}</div>
                         <div class="status">{{__('Customer')}}</div>
                         <p>{!! replaceBaseUrl($reply->reply) !!}</p>
                         @if($reply->file)
                         <a href="{{asset('assets/front/user-suppor-file/'.$ticket->zip_file)}}" download="support_file" class="btn btn-rounded btn-info btn-sm">Download</a>
                         @endif
                      </div>
                   </div>
                  @endif
                  @endforeach
                  @endif
               </div>
           </div>
        </div>
     </div>
   </div>


 @if($ticket->status != 'close')
 <div class="col-lg-6 message-type">
   <div class="card card-round">
       <div class="card-body">
           <div class="card-title fw-mediumbold mb-2">Reply to Ticket</div>
           <form action="{{route('admin.ticket.reply',$ticket->id)}}" id="ajaxform" method="POST" enctype="multipart/form-data">@csrf
               <div class="form-group">
                   <label for="">Message **</label>
                   <textarea name="reply" class="summernote" data-height="200"></textarea>
                   <p class="em text-danger mb-0" id="errreply"></p>
                 </div>
               <div class="form-group">
                   <label for="">Attachment</label>
                   <div class="input-group">
                       <div class="custom-file">
                         <input type="file" name="file" class="custom-file-input" data-href="{{route('admin.zip_file.upload')}}" name="file" id="zip_file">
                         <label class="custom-file-label" for="zip_file">Choose file</label>
                       </div>
                   </div>
                   <p class="em text-danger mb-0" id="errfile"></p>
                   <p class="mb-0 show-name"><small></small></p>
                   <div class="progress progress-sm d-none">
                       <div class="progress-bar bg-success " role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax=""></div>
                   </div>
                   <p class="text-warning">Upload only ZIP Files, Max File Size is 5 MB</p>
               </div>
               <div class="form-group">
                   <button type="submit" class="btn btn-success">Message</button>
               </div>
           </form>
       </div>
    </div>
  </div>
 @endif
</div>
@endsection
@section('scripts')
    <script>
            $(document).on('change','#zip_file', function(){
      var formdata = new FormData();
      var file = event.target.files[0];
      var name = event.target.files[0].name;
        formdata.append('file', file);
      $.ajax({
            url: $(this).attr('data-href'),
            type: 'post',
            data: formdata,
            xhr: function() {
                var appXhr = $.ajaxSettings.xhr();
                if (appXhr.upload) {
                    if ('#zip_file') {
                        appXhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                                currentMainProgress = (e.loaded / e.total) * 100;
                                currentMainProgress = parseInt(currentMainProgress);
                                $(".progress").removeClass('d-none');
                                $(".progress-bar").html(currentMainProgress + '%');
                                $(".progress-bar").width(currentMainProgress + '%');
                                if (currentMainProgress == 100)
                                $(".progress-bar").addClass('bg-success');
                                }
                                $('.show-name small').text(name);
                        }, false);
                    }
                  }

                return appXhr;
            },
            success: function(data) {
                if(data.errors){
                    $(".progress").addClass('d-none');
                    $('#errfile').text(data.errors.file[0]).removeClass('d-none');
                }else{
                    $('#errfile').text('').addClass('d-none');
                }
            },


            contentType: false,
            processData: false
    });

    });

    let redirecturl = '{{url('/')}}';

    $(document).on('click','.close-ticket',function(){
       $('.swal-button--confirm').attr('data-href',$(this).attr('data-href'));
    })
    $(document).on('click','.swal-button--confirm',function(){
       $.get($(this).attr('data-href'),function(res){
         $('.message-type').remove();
         location.reload();
       });
    })
    </script>
@endsection
