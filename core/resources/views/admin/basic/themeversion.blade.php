@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Theme Version</h4>
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
        <a href="#">Basic Settings</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Theme Version</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-title">Update Theme Version</div>
                </div>
            </div>
        </div>
        <div class="card-body pt-3 pb-4">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">

              <form id="ajaxForm" action="{{route('admin.themeversion.update')}}" method="post">
                @csrf
                <div class="form-group">
                  <label for="">Select a Theme **</label>
                  <select class="form-control" name="theme_version" id="">
                      <option value="default_service_category" {{$abe->theme_version == 'default_service_category' ? 'selected' : ''}}>Default Version (With Service Category)</option>
                      <option value="default_no_category" {{$abe->theme_version == 'default_no_category' ? 'selected' : ''}}>Default Version (Without Service Category)</option>
                      <option value="dark_service_category" {{$abe->theme_version == 'dark_service_category' ? 'selected' : ''}}>Dark Version (With Service Category)</option>
                      <option value="dark_no_category" {{$abe->theme_version == 'dark_no_category' ? 'selected' : ''}}>Dark Version (Without Service Category)</option>
                      <option value="gym_service_category" {{$abe->theme_version == 'gym_service_category' ? 'selected' : ''}}>Gym Version (With Service Category)</option>
                      <option value="gym_no_category" {{$abe->theme_version == 'gym_no_category' ? 'selected' : ''}}>Gym Version (Without Service Category)</option>
                      <option value="car_service_category" {{$abe->theme_version == 'car_service_category' ? 'selected' : ''}}>Car Version (With Service Category)</option>
                      <option value="car_no_category" {{$abe->theme_version == 'car_no_category' ? 'selected' : ''}}>Car Version (Without Service Category)</option>
                      <option value="cleaning_service_category" {{$abe->theme_version == 'cleaning_service_category' ? 'selected' : ''}}>Cleaning Version (With Service Category)</option>
                      <option value="cleaning_no_category" {{$abe->theme_version == 'cleaning_no_category' ? 'selected' : ''}}>Cleaning Version (Without Service Category)</option>
                      <option value="construction_service_category" {{$abe->theme_version == 'construction_service_category' ? 'selected' : ''}}>Construction Version (With Service Category)</option>
                      <option value="construction_no_category" {{$abe->theme_version == 'construction_no_category' ? 'selected' : ''}}>Construction Version (Without Service Category)</option>
                      <option value="logistic_service_category" {{$abe->theme_version == 'logistic_service_category' ? 'selected' : ''}}>Logistic Version (With Service Category)</option>
                      <option value="logistic_no_category" {{$abe->theme_version == 'logistic_no_category' ? 'selected' : ''}}>Logistic Version (Without Service Category)</option>
                      <option value="lawyer_service_category" {{$abe->theme_version == 'lawyer_service_category' ? 'selected' : ''}}>Lawyer Version (With Service Category)</option>
                      <option value="lawyer_no_category" {{$abe->theme_version == 'lawyer_no_category' ? 'selected' : ''}}>Lawyer Version (Without Service Category)</option>
                  </select>
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
