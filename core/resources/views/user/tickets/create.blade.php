@extends('user.layout')

@section('pagename')
 - {{__('Submit Ticket')}}
@endsection

@section('content')
  <!--   hero area start   -->
  <div class="breadcrumb-area services service-bg" style="background-image: url('{{asset  ('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
    <div class="container">
        <div class="breadcrumb-txt">
            <div class="row">
                <div class="col-xl-7 col-lg-8 col-sm-10">
                    <h1>{{__('Create Ticket')}}</h1>
                    <ul class="breadcumb">
                        <li><a href="{{route('user-dashboard')}}">{{__('Dashboard')}}</a></li>
                        <li>{{__('Create Ticket')}}</li>
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
                                    <h4>{{__('Submit a Ticket')}}</h4>
                                    <a href="{{route('user-tickets')}}" class="btn btn-primary btn-sm border-0"><i class="fas fa-angle-left"></i> {{__('Back to List')}}</a>
                                </div>

                                <div class="reply-section">
                                    <form action="{{route('user.ticket.store')}}" method="POST" class="reply-form" enctype="multipart/form-data">
                                        @csrf
                                        <label for="email">{{__('Email')}} *</label>
                                        <div class="form-element">
                                            <input type="email" class="form-control" id="email" name="email" value="{{Auth::user()->email}}">
                                        @error('email')
                                            <p class="text-danger mb-2">{{ convertUtf8($message) }}</p>
                                        @enderror
                                        </div>
                                        <label for="subject">{{__('Subject')}} *</label>
                                        <div class="form-element">
                                            <input type="text" class="form-control" id="subject" name="subject">
                                        @error('subject')
                                            <p class="text-danger mb-2">{{ convertUtf8($message) }}</p>
                                        @enderror
                                        </div>
                                        <label for="description">{{__('Description')}} *</label>
                                        <div class="form-element">
                                            <textarea name="description" id="description" class="summernote" data-height="220"></textarea>
                                        @error('description')
                                            <p class="text-danger mb-2">{{ convertUtf8($message) }}</p>
                                        @enderror
                                        </div>
                                        <label for="">{{__('Attachment')}}</label>
                                        <div class="form-element">
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                  <input type="file" name="zip_file" data-href="{{route('zip.upload')}}" class="custom-file-input" id="zip_file">
                                                  <label class="custom-file-label" for="zip_file">{{__('Choose file')}}</label>
                                                </div>
                                                @error('zip_file')
                                                        <p class="text-danger mb-2">{{ convertUtf8($message) }}</p>
                                                @enderror
                                                <p class="text-danger mb-2 file-error d-none"></p>
                                            </div>
                                            <div class="progress mt-3 d-none">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <small class="show-name">{{__('Upload only ZIP Files, Max File Size is 5 MB')}}</small>
                                        </div>
                                        <div class="form-element">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-retweet"></i> {{__('Submit')}}</button>
                                        </div>
                                    </form>
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
                                $('.show-name').text(name);
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
