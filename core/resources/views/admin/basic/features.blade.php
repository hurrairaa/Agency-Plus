@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Features Settings</h4>
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
        <a href="#">Features Settings</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="" action="{{route('admin.featuresettings.update')}}" method="post">
          @csrf
          <div class="card-header">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-title">Features Settings</div>
                </div>
            </div>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                @csrf
                <div class="form-group">
                  <label>Shop **</label>
                  <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="is_shop" value="1" class="selectgroup-input" {{$abex->is_shop == 1 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Active</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="is_shop" value="0" class="selectgroup-input" {{$abex->is_shop == 0 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Deactive</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                  <label>Support Ticket **</label>
                  <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="is_ticket" value="1" class="selectgroup-input" {{$abex->is_ticket == 1 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Active</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="is_ticket" value="0" class="selectgroup-input" {{$abex->is_ticket == 0 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Deactive</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                  <label>User Panel **</label>
                  <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="is_user_panel" value="1" class="selectgroup-input" {{$abex->is_user_panel == 1 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Active</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="is_user_panel" value="0" class="selectgroup-input" {{$abex->is_user_panel == 0 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Deactive</span>
                        </label>
                    </div>
                </div>

              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="form">
              <div class="form-group from-show-notify row">
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
