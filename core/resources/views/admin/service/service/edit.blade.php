@extends('admin.layout')

@if(!empty($service->language) && $service->language->rtl == 1)
@section('styles')
<style>
   form input,
   form textarea,
   form select {
   direction: rtl;
   }
   form .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif

@section('content')
<div class="page-header">
   <h4 class="page-title">Edit Service</h4>
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
         <a href="#">Service Page</a>
      </li>
      <li class="separator">
         <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
         <a href="#">Edit Service</a>
      </li>
   </ul>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <div class="card-title d-inline-block">Edit Service</div>
            @if ($service->language_id > 0)
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{ route('admin.service.index') . '?language=' . request()->input('language') }}">
            <span class="btn-label">
            <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
            </a>
            @else
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{ route('admin.service.index') }}">
            <span class="btn-label">
            <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
            </a>
            @endif
         </div>
         <div class="card-body pt-5 pb-5">
            <div class="row">
               <div class="col-lg-6 offset-lg-3">
                  <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data" action="{{route('admin.service.uploadUpdate', $service->id)}}" method="POST">
                     @csrf
                     <div class="form-row px-2">
                        <div class="col-12 mb-2">
                           <label for=""><strong>Image **</strong></label>
                        </div>
                        <div class="col-md-12 d-md-block d-sm-none mb-3">
                           <img src="{{asset('assets/front/img/services/'.$service->main_image)}}" alt="..." class="img-thumbnail">
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
                                 <input type="file" title='Click to add Files'  />
                              </div>
                              <small class="status text-muted">Select a file or drag it over this area..</small>
                           </div>
                        </div>
                     </div>
                  </form>
                  <form id="ajaxForm" class="" action="{{route('admin.service.update')}}" method="post">
                     @csrf
                     <input type="hidden" name="service_id" value="{{$service->id}}">
                     <div class="form-group">
                        <label for="">Title **</label>
                        <input type="text" class="form-control" name="title" value="{{$service->title}}" placeholder="Enter title">
                        <p id="errtitle" class="mb-0 text-danger em"></p>
                     </div>

                     @if (hasCategory($abe->theme_version))
                     <div class="form-group">
                        <label for="">Category **</label>
                        <select class="form-control" name="category">
                           <option value="" selected disabled>Select a category</option>
                           @foreach ($ascats as $key => $ascat)
                           <option value="{{$ascat->id}}" {{$ascat->id == $service->scategory_id ? 'selected' : ''}}>{{$ascat->name}}</option>
                           @endforeach
                        </select>
                        <p id="errcategory" class="mb-0 text-danger em"></p>
                     </div>
                     @endif

                    <div class="form-group">
                        <label for="">Summary **</label>
                        <textarea class="form-control" name="summary" placeholder="Enter summary" rows="3">{{$service->summary}}</textarea>
                        <p id="errsummary" class="mb-0 text-danger em"></p>
                    </div>


                    <div class="form-group">
                        <label>Details Page **</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="details_page_status" value="1" class="selectgroup-input" {{$service->details_page_status == 1 ? 'checked' : ''}}>
                                <span class="selectgroup-button">Enable</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="details_page_status" value="0" class="selectgroup-input" {{$service->details_page_status == 0 ? 'checked' : ''}}>
                                <span class="selectgroup-button">Disable</span>
                            </label>
                        </div>
                        <p id="errdetails_page_status" class="mb-0 text-danger em"></p>
                    </div>

                     <div class="form-group" id="contentFg">
                        <label for="">Content **</label>
                        <textarea class="form-control summernote" name="content" data-height="300" placeholder="Enter content">{{replaceBaseUrl($service->content)}}</textarea>
                        <p id="errcontent" class="mb-0 text-danger em"></p>
                     </div>
                     <div class="form-group">
                        <label for="">Serial Number **</label>
                        <input type="number" class="form-control ltr" name="serial_number" value="{{$service->serial_number}}" placeholder="Enter Serial Number">
                        <p id="errserial_number" class="mb-0 text-danger em"></p>
                        <p class="text-warning"><small>The higher the serial number is, the later the service will be shown everywhere.</small></p>
                     </div>
                     <div class="form-group">
                        <label>Meta Keywords</label>
                        <input class="form-control" name="meta_keywords" value="{{$service->meta_keywords}}" placeholder="Enter meta keywords" data-role="tagsinput">
                        @if ($errors->has('meta_keywords'))
                        <p class="mb-0 text-danger">{{$errors->first('meta_keywords')}}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        <label>Meta Description</label>
                        <textarea class="form-control" name="meta_description" rows="5" placeholder="Enter meta description">{{$service->meta_description}}</textarea>
                        @if ($errors->has('meta_description'))
                        <p class="mb-0 text-danger">{{$errors->first('meta_description')}}</p>
                        @endif
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
<script>
    function toggleDetails() {
        let val = $("input[name='details_page_status']:checked").val();

        // if 'details page' is 'enable', then show 'content' & hide 'summary'
        if (val == 1) {
            $("#contentFg").show();
        }
        // if 'details page' is 'disable', then show 'summary' & hide 'content'
        else if (val == 0) {
            $("#contentFg").hide();
        }
    }

    $(document).ready(function() {
        toggleDetails();

        $("input[name='details_page_status']").on('change', function() {
            toggleDetails();
        });
    });
</script>
@endsection
