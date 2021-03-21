<div class="main-header">
  <!-- Logo Header -->
  <div class="logo-header" data-background-color="dark2">

    <a href="{{route('front.index')}}" class="logo" target="_blank">
      <img src="{{asset('assets/front/img/'.$bs->logo)}}" alt="navbar brand" class="navbar-brand" width="120">
    </a>
    <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon">
        <i class="icon-menu"></i>
      </span>
    </button>
    <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
    <div class="nav-toggle">
      <button class="btn btn-toggle toggle-sidebar">
        <i class="icon-menu"></i>
      </button>
    </div>
  </div>
  <!-- End Logo Header -->

  <!-- Navbar Header -->
  <nav class="navbar navbar-header navbar-expand-lg" data-background-color="dark">

    <div class="container-fluid">

      <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">

        <li class="nav-item dropdown hidden-caret">
          <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
            <div class="avatar-sm">
              @if (!empty(Auth::guard('admin')->user()->image))
                <img src="{{asset('assets/admin/img/propics/'.Auth::guard('admin')->user()->image)}}" alt="..." class="avatar-img rounded-circle">
              @else
                <img src="{{asset('assets/admin/img/propics/blank_user.jpg')}}" alt="..." class="avatar-img rounded-circle">
              @endif
            </div>
          </a>
          <ul class="dropdown-menu dropdown-user animated fadeIn">
            <div class="dropdown-user-scroll scrollbar-outer">
              <li>
                <div class="user-box">
                  <div class="avatar-lg">
                    @if (!empty(Auth::guard('admin')->user()->image))
                      <img src="{{asset('assets/admin/img/propics/'.Auth::guard('admin')->user()->image)}}" alt="..." class="avatar-img rounded">
                    @else
                      <img src="{{asset('assets/admin/img/propics/blank_user.jpg')}}" alt="..." class="avatar-img rounded">
                    @endif
                  </div>
                  <div class="u-text">
                    <h4>{{Auth::guard('admin')->user()->first_name}}</h4>
                    <p class="text-muted">{{Auth::guard('admin')->user()->email}}</p><a href="{{route('admin.editProfile')}}" class="btn btn-xs btn-secondary btn-sm">Edit Profile</a>
                  </div>
                </div>
              </li>
              <li>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('admin.editProfile')}}">Edit Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('admin.changePass')}}">Change Password</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('admin.logout')}}">Logout</a>
              </li>
            </div>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
  <!-- End Navbar -->
</div>
