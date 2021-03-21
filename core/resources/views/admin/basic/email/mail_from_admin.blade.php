@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Mail From Admin</h4>
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
        <a href="#">Email Settings</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Mail From Admin</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form action="{{route('admin.mailfromadmin.update')}}" method="post">
          @csrf
          <div class="card-header">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="card-title">Mail From Admin</div>
                  </div>
              </div>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                <div class="alert alert-warning text-center" role="alert">
                    <strong>This mail addres will be used to send all mails from this website.</strong>
                </div>
                @csrf
                <div class="form-group">
                  <label>SMTP Status **</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="is_smtp" value="1" class="selectgroup-input" {{$abe->is_smtp == 1 ? 'checked' : ''}}>
                      <span class="selectgroup-button">Active</span>
                    </label>
                    <label class="selectgroup-item">
                      <input type="radio" name="is_smtp" value="0" class="selectgroup-input" {{$abe->is_smtp == 0 ? 'checked' : ''}}>
                      <span class="selectgroup-button">Deactive</span>
                    </label>
                  </div>
                  @if ($errors->has('is_smtp'))
                    <p class="mb-0 text-danger">{{$errors->first('is_smtp')}}</p>
                  @endif
                </div>
                <div class="form-group">
                    <label>SMTP Host **</label>
                    <input class="form-control" name="smtp_host" value="{{$abe->smtp_host}}">
                    @if ($errors->has('smtp_host'))
                        <p class="mb-0 text-danger">{{$errors->first('smtp_host')}}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>SMTP Port **</label>
                    <input class="form-control" name="smtp_port" value="{{$abe->smtp_port}}">
                    @if ($errors->has('smtp_port'))
                        <p class="mb-0 text-danger">{{$errors->first('smtp_port')}}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>Encryption **</label>
                    <input class="form-control" name="encryption" value="{{$abe->encryption}}">
                    @if ($errors->has('encryption'))
                        <p class="mb-0 text-danger">{{$errors->first('encryption')}}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>SMTP Username **</label>
                    <input class="form-control" name="smtp_username" value="{{$abe->smtp_username}}">
                    @if ($errors->has('smtp_username'))
                        <p class="mb-0 text-danger">{{$errors->first('smtp_username')}}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>SMTP Password **</label>
                    <input class="form-control" name="smtp_password" value="{{$abe->smtp_password}}">
                    @if ($errors->has('smtp_password'))
                        <p class="mb-0 text-danger">{{$errors->first('smtp_password')}}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>From Email **</label>
                    <input class="form-control" type="email" name="from_mail" value="{{$abe->from_mail}}">
                    @if ($errors->has('from_mail'))
                        <p class="mb-0 text-danger">{{$errors->first('from_mail')}}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>From Name **</label>
                    <input class="form-control" name="from_name" value="{{$abe->from_name}}">
                    @if ($errors->has('from_name'))
                        <p class="mb-0 text-danger">{{$errors->first('from_name')}}</p>
                    @endif
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection
