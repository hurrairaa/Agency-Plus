@extends('admin.layout')

@if(!empty($shipping->language) && $shipping->language->rtl == 1)
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
    <h4 class="page-title">Edit Category</h4>
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
          <a href="#">Shipping</a>
        </li>
        <li class="separator">
          <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
          <a href="#">Shipping Charge</a>
        </li>
        <li class="nav-item">
          <a href="#">Edit</a>
        </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Category</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.shipping.index') . '?language=' . request()->input('language')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">


          <form id="ajaxForm" class="modal-form" action="{{route('admin.shipping.update')}}" method="POST">
            @csrf
          <input type="hidden" value="{{$shipping->id}}" name="shipping_id">

            <div class="form-group">
              <label for="">Title **</label>
              <input type="text" class="form-control" name="title" value="{{$shipping->title}}" placeholder="Enter title">
              <p id="errtitle" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">Sort Text **</label>
              <input type="text" class="form-control" name="text" value="{{$shipping->text}}" placeholder="Enter text">
              <p id="errtext" class="mb-0 text-danger em"></p>
            </div>

            <div class="form-group">
              <label for="">Charge **</label>
              <input type="text" class="form-control ltr" name="charge" value="{{$shipping->charge}}" placeholder="Enter charge">
              <p id="errcharge" class="mb-0 text-danger em"></p>
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
