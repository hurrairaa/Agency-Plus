@extends('user.layout')

@section('pagename')
 - {{__('Ticket')}} [{{$ticket->ticket_number}}]
@endsection

@section('content')
  <!--   hero area start   -->
  <div class="breadcrumb-area services service-bg" style="background-image: url('{{asset  ('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
    <div class="container">
        <div class="breadcrumb-txt">
            <div class="row">
                <div class="col-xl-7 col-lg-8 col-sm-10">
                    <h1>{{__('Ticket Details')}}</h1>
                    <ul class="breadcumb">
                        <li><a href="{{route('user-dashboard')}}">{{__('Dashboard')}}</a></li>
                        <li>{{__('Ticket Details')}}</li>
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
                                    <h4>{{__('Ticket Details')}} - #{{$ticket->ticket_number}}</h4>
                                    <a href="{{route('user-tickets')}}" class="btn btn-primary btn-sm border-0"><i class="fas fa-angle-left"></i> {{__('Back to List')}}</a>
                                </div>

                                <div class="summary">
                                    <div class="subject">
                                        <h5>{{convertUtf8($ticket->subject)}}</h5>
                                        <div>
                                            @if($ticket->status == 'pending')
                                            <h6 class="d-inline-block badge badge-warning">{{convertUtf8($ticket->status)}}</h6>
                                            @elseif($ticket->status == 'open')
                                            <h6 class="d-inline-block badge badge-primary">{{convertUtf8($ticket->status)}}</h6>
                                            @else
                                            <h6 class="d-inline-block badge badge-success">{{convertUtf8($ticket->status)}}</h6>
                                            @endif
                                        <h6><span class="badge badge-light">{{$ticket->created_at->format('d-m-Y')}} {{date("h.i A", strtotime($ticket->created_at))}}</span></h6>
                                        </div>
                                    </div>

                                    <div class="description">
                                        {!! replaceBaseUrl(convertUtf8($ticket->message)) !!}
                                    </div>

                                    @if($ticket->zip_file)
                                    <a href="{{asset('assets/front/user-suppor-file/'.$ticket->zip_file)}}" download="support.zip" class="btn btn-primary"><i class="fas fa-download"></i> Download Attachment</a>
                                    @endif
                                </div>

                                <div class="message-section">
                                    <h5>{{__('Replies')}}</h5>
                                    <div class="message-lists">
                                        @if(count($ticket->messages) > 0)
                                            @foreach ($ticket->messages as $reply)
                                                @if(!$reply->user_id)
                                                @php
                                                    $admin = App\Admin::find($ticket->admin_id);
                                                @endphp
                                        <div class="single-message">
                                            <div class="user-details">
                                                <div class="user-img">
                                                    <img src="{{$admin->image ? asset('assets/admin/img/propics/'.$admin->image) : asset('assets/admin/img/propics/blank_user.jpg')}}" alt="">
                                                </div>
                                                <div class="user-infos">
                                                    <h6 class="name">{{convertUtf8($admin->username)}}</h6>
                                                    <span class="type"><i class="fas fa-user"></i> {{$admin->id == 1 ? 'Super Admin' : convertUtf8($admin->role->name)}}</span>
                                                    <span class="badge badge-secondary">{{$reply->created_at->format('d-m-Y')}} {{date("h.i A", strtotime($reply->created_at))}}</span>
                                                    @if($reply->file)
                                                        <a href="{{asset('assets/front/user-suppor-file/'.$reply->file)}}" download="support.zip" class="reply-download-btn"><i class="fas fa-download"></i> {{__('Download')}}</a>
                                                        @endif
                                                </div>
                                            </div>
                                        <div class="message">{!! replaceBaseUrl(convertUtf8($reply->reply)) !!}</div>
                                        </div>
                                        @else
                                                @php
                                                $user = Auth::user();
                                            @endphp
                                            <div class="single-message">
                                                <div class="user-details">
                                                    <div class="user-img">
                                                        <img src="{{asset('assets/front/img/user/'.$user->photo)}}" alt="user-photo">
                                                    </div>
                                                    <div class="user-infos">
                                                        <h6 class="name">{{convertUtf8($user->username)}}</h6>
                                                        <span class="type"><i class="fas fa-user"></i> {{__('Customer')}}</span>
                                                        <span class="badge badge-secondary">{{$reply->created_at->format('d-m-Y')}} {{date("h.i A", strtotime($reply->created_at))}}</span>
                                                        @if($reply->file)
                                                        <a href="{{asset('assets/front/user-suppor-file/'.$reply->file)}}" download="support.zip" class="reply-download-btn"><i class="fas fa-download"></i> {{__('Download')}}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="message">{!! replaceBaseUrl(convertUtf8($reply->reply))!!}</div>
                                            </div>
                                                @endif
                                            @endforeach
                                        @else
                                            {{__('NO Conversations')}}
                                        @endif
                                    </div>
                                </div>

                               @if($ticket->status != 'close')
                               <div class="reply-section">
                                <h5>{{__('Reply to Ticket')}}</h5>
                                <form action="{{route('user.ticket.reply',$ticket->id)}}" method="POST" enctype="multipart/form-data" class="reply-form">
                                    @csrf
                                    <label for="reply">{{__('Reply')}}</label>
                                    <div class="form-element">
                                        <textarea name="reply" class="summernote" id="reply" data-height="220"></textarea>
                                    @error('reply')
                                        <p class="text-danger mb-2">{!! convertUtf8($message) !!}</p>
                                    @enderror
                                    </div>
                                    <label for="">{{__('Attachment')}}</label>
                                    <div class="form-element">
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                              <input type="file" data-href="{{route('zip.upload')}}" class="custom-file-input" name="file" id="zip_file">
                                              <label class="custom-file-label"  for="zip_file">{{__('Choose file')}}</label>
                                            </div>

                                        </div>
                                        <div class="progress mt-3 d-none">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small class="show-name">{{__('Upload only ZIP Files, Max File Size is 5 MB')}}</small>
                                    @error('file')
                                        <p class="text-danger mb-2">{!! convertUtf8($message) !!}</p>
                                    @enderror
                                    <p class="text-danger mb-2 file-error d-none"></p>
                                    </div>
                                    <div class="form-element">
                                        <button type="submit" class="btn btn-success"><i class="fas fa-retweet"></i> {{__('Reply')}}</button>
                                    </div>
                                </form>
                            </div>
                               @endif
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
                                $('show-name').text(name);
                        }, false);
                    }
                  }

                return appXhr;
            },
            success: function(data) {
                if(data.errors){
                    $(".progress").addClass('d-none');
                    $('.file-error').text(data.errors.file[0]).removeClass('d-none');
                }else{
                    $('.file-error').text('').addClass('d-none');
                }
            },


            contentType: false,
            processData: false
    });

    });
    </script>
@endsection
