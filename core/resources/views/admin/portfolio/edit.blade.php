@extends('admin.layout')

@if(!empty($portfolio->language) && $portfolio->language->rtl == 1)
@section('styles')
<style>
    form input,
    form textarea,
    form select {
        direction: rtl;
    }
    .nicEdit-main {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif

@section('content')
  <div class="page-header">
    <h4 class="page-title">Edit Portfolio</h4>
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
        <a href="#">Portfolio Page</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Edit Portfolio</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Portfolio</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.portfolio.index') . '?language=' . request()->input('language')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">

              {{-- Slider images upload start --}}
              <div class="px-2">
                <label for="" class="mb-2"><strong>Slider Images **</strong></label>
                <div class="row">
                  <div class="col-12">
                    <table class="table table-striped" id="imgtable">

                    </table>
                  </div>
                </div>
                <form action="{{route('admin.portfolio.sliderupdate')}}" id="my-dropzone" enctype="multipart/formdata" class="dropzone">
                    @csrf
                    <input type="hidden" name="portfolio_id" value="{{$portfolio->id}}">
                    <div class="fallback">
                      <input name="file" type="file" multiple  />
                    </div>
                </form>
                <p class="em text-danger mb-0" id="errslider_images"></p>
              </div>
              {{-- Slider images upload end --}}


              {{-- Featured image upload start --}}
              <div class="mt-4">
                <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data" action="{{route('admin.portfolio.uploadUpdate', $portfolio->id)}}" method="POST">
                  <div class="form-row px-2">
                    <div class="col-12 mb-2">
                      <label for=""><strong>Featured Image **</strong></label>
                    </div>
                    <div class="col-md-12 d-md-block d-sm-none mb-3">
                      <img src="{{asset('assets/front/img/portfolios/featured/'.$portfolio->featured_image)}}" alt="..." class="img-thumbnail" width="200">
                    </div>
                    <div class="col-sm-12">
                      <div class="from-group mb-2">
                        <input type="text" class="form-control progressbar" aria-describedby="fileHelp" placeholder="No image uploaded..." readonly="readonly" />

                        <div class="progress mb-2 d-none">
                          <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                            role="progressbar"
                            style="width: 0%;"
                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="0">
                            0%
                          </div>
                        </div>

                      </div>

                      <div class="mt-4">
                        <div role="button" class="btn btn-primary mr-2">
                          <i class="fa fa-folder-o fa-fw"></i> Browse Files
                          <input type="file" title='Click to add Files' />
                        </div>
                        <small class="status text-muted">Select a file or drag it over this area..</small>
                        <p class="em text-danger mb-0" id="errportfolio"></p>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              {{-- Featured image upload end --}}


              <form id="ajaxForm" class="" action="{{route('admin.portfolio.update')}}" method="post">
                @csrf
                <input type="hidden" name="portfolio_id" value="{{$portfolio->id}}">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Title **</label>
                      <input type="text" class="form-control" name="title" value="{{$portfolio->title}}" placeholder="Enter title">
                      <p id="errtitle" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Client Name **</label>
                      <input type="text" class="form-control" name="client_name" value="{{$portfolio->client_name}}" placeholder="Enter client name">
                      <p id="errclient_name" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Service **</label>
                      <select class="form-control" name="service_id">
                        <option value="" selected disabled>Select a service</option>
                        @foreach ($services as $key => $service)
                          <option value="{{$service->id}}" {{$portfolio->service_id == $service->id ? 'selected' : ''}}>{{$service->title}}</option>
                        @endforeach
                      </select>
                      <p id="errservice_id" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Tags **</label>
                      <input type="text" class="form-control" name="tags" value="{{$portfolio->tags}}" data-role="tagsinput" placeholder="Enter tags">
                      <p id="errtags" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Start Date **</label>
                      <input id="startDate" type="text" class="form-control datepicker" name="start_date" value="{{$portfolio->start_date}}" placeholder="Enter start date" autocomplete="off">
                      <p id="errstart_date" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Submission Date **</label>
                      <input id="submissionDate" type="text" class="form-control datepicker" name="submission_date" value="{{$portfolio->submission_date}}" placeholder="Enter submission date" autocomplete="off">
                      <p id="errsubmission_date" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Status **</label>
                      <select class="form-control ltr" name="status">
                        <option value="" selected disabled>Select a status</option>
                        <option value="In Progress" {{$portfolio->status == 'In Progress' ? 'selected' : ''}}>In Progress</option>
                        <option value="Completed" {{$portfolio->status == 'Completed' ? 'selected' : ''}}>Completed</option>
                      </select>
                      <p id="errstatus" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Serial Number **</label>
                        <input type="number" class="form-control ltr" name="serial_number" value="{{$portfolio->serial_number}}" placeholder="Enter Serial Number">
                        <p id="errserial_number" class="mb-0 text-danger em"></p>
                        <p class="text-warning mb-0"><small>The higher the serial number is, the later the portfolio will be shown.</small></p>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label for="">Content **</label>
                      <textarea class="form-control summernote" name="content" rows="8" placeholder="Enter content" data-height="300">{{replaceBaseUrl($portfolio->content)}}</textarea>
                      <p id="errcontent" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                   <label>Meta Keywords</label>
                   <input class="form-control" name="meta_keywords" value="{{$portfolio->meta_keywords}}" placeholder="Enter meta keywords" data-role="tagsinput">
                </div>
                <div class="form-group">
                   <label>Meta Description</label>
                   <textarea class="form-control" name="meta_description" rows="5" placeholder="Enter meta description">{{$portfolio->meta_description}}</textarea>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="form">
            <div class="form-group from-show-notify row">
              <div class="col-12 text-center">
                <button type="submit" id="submitBtn" class="btn btn-success">Update</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

@endsection


@section('scripts')
  {{-- dropzone --}}
  <script>
    // myDropzone is the configuration for the element that has an id attribute
    // with the value my-dropzone (or myDropzone)
    Dropzone.options.myDropzone = {
      acceptedFiles: '.png, .jpg, .jpeg',
      url: "{{route('admin.portfolio.sliderstore')}}",
      success : function(file, response){
          console.log(response.file_id);

          // Create the remove button
          var removeButton = Dropzone.createElement("<button class='rmv-btn'><i class='fa fa-times'></i></button>");


          // Capture the Dropzone instance as closure.
          var _this = this;

          // Listen to the click event
          removeButton.addEventListener("click", function(e) {
            // Make sure the button click doesn't submit the form:
            e.preventDefault();
            e.stopPropagation();

            _this.removeFile(file);

            rmvimg(response.file_id);
          });

          // Add the button to the file preview element.
          file.previewElement.appendChild(removeButton);

          var content = {};

          content.message = 'Slider images added successfully!';
          content.title = 'Success';
          content.icon = 'fa fa-bell';

          $.notify(content,{
            type: 'success',
            placement: {
              from: 'top',
              align: 'right'
            },
            time: 1000,
            delay: 0,
          });
      }
    };

    function rmvimg(fileid) {
        // If you want to the delete the file on the server as well,
        // you can do the AJAX request here.

          $.ajax({
            url: "{{route('admin.portfolio.sliderrmv')}}",
            type: 'POST',
            data: {
              _token: "{{csrf_token()}}",
              fileid: fileid
            },
            success: function(data) {
              var content = {};

              content.message = 'Slider image deleted successfully!';
              content.title = 'Success';
              content.icon = 'fa fa-bell';

              $.notify(content,{
                type: 'success',
                placement: {
                  from: 'top',
                  align: 'right'
                },
                time: 1000,
                delay: 0,
              });
            }
          });

    }
  </script>


  <script>
  var el = 0;

  $(document).ready(function(){
    $.get("{{route('admin.portfolio.images', $portfolio->id)}}", function(data){
        for (var i = 0; i < data.length; i++) {
          $("#imgtable").append('<tr class="trdb" id="trdb'+data[i].id+'"><td><div class="thumbnail"><img style="width:150px;" src="{{asset('assets/front/img/portfolios/sliders/')}}/'+data[i].image+'" alt="Ad Image"></div></td><td><button type="button" class="btn btn-danger pull-right rmvbtndb" onclick="rmvdbimg('+data[i].id+')"><i class="fa fa-times"></i></button></td></tr>');
        }
    });
  });

  function rmvdbimg(indb) {
    $(".request-loader").addClass("show");
    $.ajax({
      url: "{{route('admin.portfolio.sliderrmv')}}",
      type: 'POST',
      data: {
        _token: "{{csrf_token()}}",
        fileid: indb
      },
      success: function(data) {
        $(".request-loader").removeClass("show");
        $("#trdb"+indb).remove();
        var content = {};

        content.message = 'Slider image deleted successfully!';
        content.title = 'Success';
        content.icon = 'fa fa-bell';

        $.notify(content,{
          type: 'success',
          placement: {
            from: 'top',
            align: 'right'
          },
          time: 1000,
          delay: 0,
        });
      }
    });

  }

    var today = new Date();
    $("#submissionDate").datepicker({
      autoclose: true,
      endDate : today,
      todayHighlight: true
    });
    $("#startDate").datepicker({
      autoclose: true,
      endDate : today,
      todayHighlight: true
    });
  </script>

@endsection
