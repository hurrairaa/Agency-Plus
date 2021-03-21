@extends('admin.layout')

@if(!empty($data->language) && $data->language->rtl == 1)
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
    <h4 class="page-title">Edit Product</h4>
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
        <a href="#">Product Page</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Edit Product</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Product</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.product.index') . '?language=' . request()->input('language')}}">
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
                <form action="{{route('admin.product.sliderupdate')}}" id="my-dropzone" enctype="multipart/formdata" class="dropzone">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$data->id}}">
                    <div class="fallback">
                      <input name="file" type="file" multiple  />
                    </div>
                </form>
                <p class="em text-danger mb-0" id="errslider_images"></p>
              </div>
              {{-- Slider images upload end --}}


              {{-- Featured image upload start --}}
              <div class="mt-4">
                <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data" action="{{route('admin.product.uploadUpdate', $data->id)}}" method="POST">
                  <div class="form-row px-2">
                    <div class="col-12 mb-2">
                      <label for=""><strong>Featured Image **</strong></label>
                    </div>
                    <div class="col-md-12 d-md-block d-sm-none mb-3">
                      <img src="{{asset('assets/front/img/product/featured/'.$data->feature_image)}}" alt="..." class="img-thumbnail" width="200">
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
                        <p class="em text-danger mb-0" id="errfeature_image"></p>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              {{-- Featured image upload end --}}
              <form id="ajaxForm" class="" action="{{route('admin.product.update')}}" method="post">
                @csrf
                <input type="hidden"  name="product_id" value="{{$data->id}}">
                <div id="sliders"></div>
                <div class="row">

                   <div class="col-lg-6">
                       <div class="form-group">
                          <label for="">Status **</label>
                          <select class="form-control ltr" name="status">
                             <option value="" selected disabled>Select a status</option>
                             <option value="1" {{$data->status == 1 ? 'selected' : ''}}>Show</option>
                             <option value="0" {{$data->status == 0 ? 'selected' : ''}}>Hide</option>
                          </select>
                          <p id="errstatus" class="mb-0 text-danger em"></p>
                       </div>
                    </div>
                    <div class="col-lg-6">
                       <div class="form-group">
                          <label for="">Title **</label>
                          <input type="text" class="form-control" name="title"  placeholder="Enter title" value="{{$data->title}}">
                          <p id="errtitle" class="mb-0 text-danger em"></p>
                       </div>
                    </div>

                </div>

                <div class="row">
                   <div class="col-lg-6">
                       <div class="form-group">
                          <label for="category">Category **</label>
                          <select  class="form-control categoryData" name="category_id" id="category">
                             <option value="" selected disabled>Select a category</option>
                             @foreach ($categories as $categroy)
                             <option value="{{$categroy->id}}" {{$data->category_id == $categroy->id ? 'selected' : ''}}>{{$categroy->name}}</option>
                             @endforeach
                          </select>
                          <p id="errcategory_id" class="mb-0 text-danger em"></p>
                       </div>
                    </div>
                   <div class="col-lg-6">
                      <div class="form-group">
                         <label for="">Stock Product **</label>
                         <input type="number" class="form-control ltr" name="stock"  placeholder="Enter Product Stock" value="{{$data->stock}}">
                         <p id="errstock" class="mb-0 text-danger em"></p>
                      </div>
                   </div>
                </div>

                <div class="row">
                   <div class="col-lg-6">
                      <div class="form-group">
                        <label for=""> Product Sku **</label>
                        <input type="text" class="form-control ltr" name="sku"  placeholder="Enter Product sku" value="{{$data->sku}}">
                          <p id="errsku" class="mb-0 text-danger em"></p>
                      </div>
                   </div>
                   <div class="col-lg-6">
                      <div class="form-group">
                         <label for="">Tags **</label>
                         <input type="text" class="form-control" name="tags" value="{{$data->tags}}" data-role="tagsinput" placeholder="Enter tags">
                         <p id="errtags" class="mb-0 text-danger em"></p>
                      </div>
                   </div>
                </div>

                <div class="row">
                   <div class="col-lg-6">
                      <div class="form-group">
                         <label for=""> Current Price (in {{$abx->base_currency_text}}) **</label>
                      <input type="number" class="form-control ltr" name="current_price" value="{{$data->current_price}}"  placeholder="Enter Current Price">
                         <p id="errcurrent_price" class="mb-0 text-danger em"></p>
                      </div>
                   </div>
                   <div class="col-lg-6">
                      <div class="form-group">
                         <label for="">Previous Price (in {{$abx->base_currency_text}})</label>
                         <input type="number" class="form-control ltr" name="previous_price" value="{{$data->previous_price}}" placeholder="Enter Previous Price">
                         <p id="errprevious_price" class="mb-0 text-danger em"></p>
                      </div>
                   </div>
                </div>

                <div class="row">
                   <div class="col-lg-12">
                      <div class="form-group">
                         <label for="summary">Summary **</label>
                         <textarea name="summary" id="summary" class="form-control" rows="4" placeholder="Enter Product Summary">{{$data->summary}}</textarea>
                         <p id="errsubmission_date" class="mb-0 text-danger em"></p>
                      </div>
                   </div>
                </div>

                <div class="row">
                   <div class="col-lg-12">
                      <div class="form-group">
                         <label for="">Description **</label>
                         <textarea class="form-control summernote" name="description" placeholder="Enter description" data-height="300">{{replaceBaseUrl($data->description)}}</textarea>
                         <p id="errdescription" class="mb-0 text-danger em"></p>
                      </div>
                   </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                       <div class="form-group">
                           <label>Meta Keywords</label>
                           <input class="form-control" name="meta_keywords" value="{{$data->meta_keywords}}" placeholder="Enter meta keywords" data-role="tagsinput">
                       </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                       <div class="form-group">
                           <label>Meta Description</label>
                           <textarea class="form-control" name="meta_description" rows="5" placeholder="Enter meta description">{{$data->meta_description}}</textarea>
                       </div>
                    </div>
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
      url: "{{route('admin.product.sliderstore')}}",
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
            url: "{{route('admin.product.sliderrmv')}}",
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
    $.get("{{route('admin.product.images', $data->id)}}", function(data){
        for (var i = 0; i < data.length; i++) {
          $("#imgtable").append('<tr class="trdb" id="trdb'+data[i].id+'"><td><div class="thumbnail"><img style="width:150px;" src="{{asset('assets/front/img/product/sliders/')}}/'+data[i].image+'" alt="Ad Image"></div></td><td><button type="button" class="btn btn-danger pull-right rmvbtndb" onclick="rmvdbimg('+data[i].id+')"><i class="fa fa-times"></i></button></td></tr>');
        }
    });
  });

  function rmvdbimg(indb) {
    $(".request-loader").addClass("show");
    $.ajax({
      url: "{{route('admin.product.sliderrmv')}}",
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


  </script>

@endsection
