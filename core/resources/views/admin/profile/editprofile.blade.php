@extends('admin.layout')

@section('pagename')
 - {{__('Edit Profile')}}
@endsection

@section('content')
  <div class="page-header">
    <h4 class="page-title">Profile</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="#">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Profile Settings</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Profile</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Update Profile</div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              <form class="mb-3 dm-uploader drag-and-drop-zone px-4" enctype="multipart/form-data" action="{{route('admin.propic.update')}}" method="POST">
                <div class="form-row">
                  <div class="col-md-12 d-md-block d-sm-none mb-3">
                    @if (!empty(Auth::guard('admin')->user()->image))
                      <img src="{{asset('assets/admin/img/propics/'.Auth::guard('admin')->user()->image)}}" alt="..." class="img-thumbnail">
                    @else
                      <img src="{{asset('assets/admin/img/propics/blank_user.jpg')}}" alt="..." class="img-thumbnail">
                    @endif
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
                        <input type="file" title='Click to add Files' name="image" />
                      </div>
                      <small class="status text-muted">Select a file or drag it over this area..</small>
                      <p class="text-warning mb-0 mt-2">Upload squre size image for best quality.</p>
                      <p class="text-warning mb-0">Only jpg, jpeg, png image is allowed.</p>
                      <p class="text-danger mb-0 em" id="errimage"></p>
                    </div>
                  </div>
                </div>
              </form>

               <form action="{{route('admin.updateProfile')}}" method="post" role="form">
                 {{csrf_field()}}
                 <div class="form-body">
                    <div class="form-group">
                        <div class="col-md-12">
                          <label>Username</label>
                        </div>
                       <div class="col-md-12">
                          <input class="form-control input-lg" name="username" value="{{$admin->username}}" placeholder="Your Username" type="text">
                          @if ($errors->has('username'))
                            <p style="margin:0px;" class="text-danger">{{$errors->first('username')}}</p>
                          @endif
                       </div>
                    </div>
                     <div class="form-group">
                         <div class="col-md-12">
                           <label>Email</label>
                         </div>
                        <div class="col-md-12">
                           <input class="form-control input-lg" name="email" value="{{$admin->email}}" placeholder="Your Email" type="text">
                           @if ($errors->has('email'))
                             <p style="margin:0px;" class="text-danger">{{$errors->first('email')}}</p>
                           @endif
                        </div>
                     </div>
                    <div class="form-group">
                        <div class="col-md-12">
                          <label>First Name</label>
                        </div>
                       <div class="col-md-12">
                          <input class="form-control input-lg" name="first_name" value="{{$admin->first_name}}" placeholder="Your First Name" type="text">
                          @if ($errors->has('first_name'))
                            <p style="margin:0px;" class="text-danger">{{$errors->first('first_name')}}</p>
                          @endif
                       </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                       <label>Last Name</label>
                      </div>
                       <div class="col-md-12">
                          <input class="form-control input-lg" name="last_name" value="{{$admin->last_name}}" placeholder="Your Last Name" type="last_name">
                          @if ($errors->has('last_name'))
                            <p style="margin:0px;" class="text-danger">{{$errors->first('last_name')}}</p>
                          @endif
                       </div>
                    </div>
                    <div class="row">
                       <div class="col-md-12 text-center">
                          <button type="submit" class="btn btn-success">Submit</button>
                       </div>
                    </div>
                 </div>
               </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

@endsection
