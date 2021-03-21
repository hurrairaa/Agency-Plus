@extends('admin.layout')

@if(!empty($package->language) && $package->language->rtl == 1)
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
    <h4 class="page-title">Edit Package</h4>
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
        <a href="#">Package Page</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Edit Package</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Package</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.package.index') . '?language=' . request()->input('language')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data" action="{{route('admin.package.uploadUpdate', $package->id)}}" method="POST">
                @csrf
                <div class="form-row px-2">
                  <div class="col-12 mb-2">
                    <label for=""><strong>Image **</strong></label>
                  </div>
                  <div class="col-md-12 d-md-block d-sm-none mb-3">
                    <img src="{{asset('assets/front/img/packages/'.$package->image)}}" alt="..." class="img-thumbnail">
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

              <form id="ajaxForm" class="modal-form" action="{{route('admin.package.update')}}" method="POST">
                @csrf
                <input type="hidden" name="package_id" value="{{$package->id}}">
                <div class="form-group">
                   <label for="">Title **</label>
                   <input type="text" class="form-control" name="title" placeholder="Enter title" value="{{$package->title}}">
                   <p id="errtitle" class="mb-0 text-danger em"></p>
                </div>

                <div class="form-group">
                    <label for="">Price (in {{$abx->base_currency_text}}) **</label>
                    <input type="text" class="form-control" name="price" placeholder="Enter price" value="{{$package->price}}">
                    <p id="errprice" class="mb-0 text-danger em"></p>
                </div>

                <div class="form-group">
                   <label for="">Description **</label>
                   <textarea class="form-control summernote" name="description" rows="8" cols="80" placeholder="Enter description" data-height="300">{{replaceBaseUrl($package->description)}}</textarea>
                   <p id="errdescription" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                     <label>Order Option **</label>
                     <div class="selectgroup w-100">
                         <label class="selectgroup-item">
                             <input type="radio" name="order_status" value="1" class="selectgroup-input" {{$package->order_status == 1 ? 'checked' : ''}}>
                             <span class="selectgroup-button">Active</span>
                         </label>
                         <label class="selectgroup-item">
                             <input type="radio" name="order_status" value="0" class="selectgroup-input" {{$package->order_status == 0 ? 'checked' : ''}}>
                             <span class="selectgroup-button">Deactive</span>
                         </label>
                     </div>
                     <p id="errorder_status" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                   <label for="">Serial Number **</label>
                   <input type="number" class="form-control ltr" name="serial_number" value="{{$package->serial_number}}" placeholder="Enter Serial Number">
                   <p id="errserial_number" class="mb-0 text-danger em"></p>
                   <p class="text-warning"><small>The higher the serial number is, the later the package will be shown everywhere.</small></p>
                </div>
                <div class="form-group">
                   <label>Meta Keywords</label>
                   <input class="form-control" name="meta_keywords" value="{{$package->meta_keywords}}" placeholder="Enter meta keywords" data-role="tagsinput">
                   <p id="errmeta_keywords" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                   <label>Meta Description</label>
                   <textarea class="form-control" name="meta_description" rows="5" placeholder="Enter meta description">{{$package->meta_description}}</textarea>
                   <p id="errmeta_description" class="mb-0 text-danger em"></p>
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
