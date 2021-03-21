@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Social Links</h4>
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
        <a href="#">Social Links</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form id="socialForm" action="{{route('admin.social.update')}}" method="post" onsubmit="update(event)">
          <div class="card-header">
            <div class="card-title d-inline-block">Edit Social Link</div>
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.social.index')}}">
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
                <input type="hidden" name="socialid" value="{{$social->id}}">
                <div class="form-group">
                  <label for="">Social Icon **</label>
                  <div class="btn-group d-block">
                      <button type="button" class="btn btn-primary iconpicker-component"><i class="{{$social->icon}}"></i></button>
                      <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                              data-selected="fa-car" data-toggle="dropdown">
                      </button>
                      <div class="dropdown-menu"></div>
                  </div>
                  <input id="inputIcon" type="hidden" name="icon" value="{{$social->icon}}">
                  @if ($errors->has('icon'))
                    <p class="mb-0 text-danger">{{$errors->first('icon')}}</p>
                  @endif
                  <div class="mt-2">
                    <small>NB: click on the dropdown icon to select a social link icon.</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="">URL **</label>
                  <input type="text" class="form-control" name="url" value="{{$social->url}}" placeholder="Enter URL of social media account">
                  @if ($errors->has('url'))
                    <p class="mb-0 text-danger">{{$errors->first('url')}}</p>
                  @endif
                </div>
                <div class="form-group">
                  <label for="">Serial Number **</label>
                  <input type="number" class="form-control ltr" name="serial_number" value="{{$social->serial_number}}" placeholder="Enter Serial Number">
                  @if ($errors->has('serial_number'))
                    <p class="mb-0 text-danger">{{$errors->first('serial_number')}}</p>
                  @endif
                  <p class="text-warning"><small>The higher the serial number is, the later the social link will be shown.</small></p>
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
    function update(e) {
      e.preventDefault();
      $("#inputIcon").val($(".iconpicker-component").find('i').attr('class'));
      document.getElementById('socialForm').submit();
    }
  </script>
@endsection
