@extends('admin.layout')

@if(!empty($statistic->language) && $statistic->language->rtl == 1)
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
    <h4 class="page-title">Statistics Section</h4>
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
        <a href="#">Home Page</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Statistics Section</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form id="statisticForm" action="{{route('admin.statistics.update')}}" method="post">
          <div class="card-header">
            <div class="card-title d-inline-block">Edit Statistic</div>
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.statistics.index') . '?language=' . request()->input('language')}}">
                <span class="btn-label">
                    <i class="fas fa-backward" style="font-size: 12px;"></i>
                </span>
                Back
            </a>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                @csrf
                <input type="hidden" name="statisticid" value="{{$statistic->id}}">
                <div class="form-group">
                  <label for="">Social Icon **</label>
                  <div class="btn-group d-block">
                      <button type="button" class="btn btn-primary iconpicker-component"><i class="{{$statistic->icon}}"></i></button>
                      <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                              data-selected="fa-car" data-toggle="dropdown">
                      </button>
                      <div class="dropdown-menu"></div>
                  </div>
                  <input id="inputIcon" type="hidden" name="icon" value="{{$statistic->icon}}">
                  @if ($errors->has('icon'))
                    <p class="mb-0 text-danger">{{$errors->first('icon')}}</p>
                  @endif
                  <div class="mt-2">
                    <small>NB: click on the dropdown sign to select an icon.</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Title **</label>
                  <input type="text" class="form-control" name="title" value="{{$statistic->title}}" placeholder="Enter Title">
                  @if ($errors->has('title'))
                    <p class="mb-0 text-danger">{{$errors->first('title')}}</p>
                  @endif
                </div>
                <div class="form-group">
                   <label for="">Quantity **</label>
                   <div class="input-group @if(!empty($selLang) && $selLang->rtl == 1) rtl @endif">
                      <input type="text" class="form-control" name="quantity" value="{{$statistic->quantity}}" placeholder="Enter Quantity" aria-describedby="basic-addon2">
                      <div class="input-group-append">
                         <span class="input-group-text" id="basic-addon2">+</span>
                      </div>
                   </div>
                   @if ($errors->has('quantity'))
                     <p class="mb-0 text-danger">{{$errors->first('quantity')}}</p>
                   @endif
                </div>
                <div class="form-group">
                  <label for="">Serial Number **</label>
                  <input type="number" class="form-control ltr" name="serial_number" value="{{$statistic->serial_number}}" placeholder="Enter Serial Number">
                  @if ($errors->has('serial_number'))
                    <p class="mb-0 text-danger">{{$errors->first('serial_number')}}</p>
                  @endif
                  <p class="text-warning"><small>The higher the serial number is, the later the statistic will be shown.</small></p>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer pt-3">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-lg-3 col-md-3 col-sm-12">

                </div>
                <div class="col-12 text-center">
                  <button type="submit" id="displayNotif" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection


@section('scripts')
  <script>
    $(document).ready(function() {
      $('.icp').on('iconpickerSelected', function(event){
        $("#inputIcon").val($(".iconpicker-component").find('i').attr('class'));
      });
    });
  </script>
@endsection
