@extends('admin.layout')

@if(!empty($page->language) && $page->language->rtl == 1)
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
    <h4 class="page-title">Pages</h4>
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
        <a href="#">Edit Page</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Pages</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Page</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.page.index') . '?language=' . request()->input('language')}}">
						<span class="btn-label">
							<i class="fas fa-backward" style="font-size: 12px;"></i>
						</span>
						Back
					</a>
        </div>
        <div class="card-body pt-5 pb-4">
          <div class="row">
            <div class="col-lg-10 offset-lg-1">
              <form id="ajaxForm" action="{{route('admin.page.update')}}" method="post">
                @csrf
                <input type="hidden" name="pageid" value="{{$page->id}}">
                <div class="row">
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label for="">Name **</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{$page->name}}">
                      <p id="errname" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label for="">Title **</label>
                      <input type="text" class="form-control" name="title" placeholder="Enter Title" value="{{$page->title}}">
                      <p id="errtitle" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label for="">Subtitle **</label>
                      <input type="text" class="form-control" name="subtitle" placeholder="Enter Subtitle" value="{{$page->subtitle}}">
                      <p id="errsubtitle" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label for="">Status **</label>
                      <select class="form-control ltr" name="status">
                        <option value="1" {{$page->status == 1 ? 'selected' : ''}}>Active</option>
                        <option value="0" {{$page->status == 0 ? 'selected' : ''}}>Deactive</option>
                      </select>
                      <p id="errstatus" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Body **</label>
                  <textarea id="body" class="form-control summernote" name="body" data-height="500">{{replaceBaseUrl($page->body)}}</textarea>
                  <p id="errbody" class="em text-danger mb-0"></p>
                </div>
                <div class="form-group">
                  <label for="">Serial Number **</label>
                  <input type="number" class="form-control ltr" name="serial_number" value="{{$page->serial_number}}" placeholder="Enter Serial Number">
                  <p id="errserial_number" class="mb-0 text-danger em"></p>
                  <p class="text-warning"><small>The higher the serial number is, the later the page will be shown in menu.</small></p>
                </div>
                <div class="form-group">
                   <label>Meta Keywords</label>
                   <input class="form-control" name="meta_keywords" value="{{$page->meta_keywords}}" placeholder="Enter meta keywords" data-role="tagsinput">
                </div>
                <div class="form-group">
                   <label>Meta Description</label>
                   <textarea class="form-control" name="meta_description" rows="5" placeholder="Enter meta description">{{$page->meta_description}}</textarea>
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
