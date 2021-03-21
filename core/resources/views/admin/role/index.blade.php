@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Roles</h4>
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
        <a href="#">Roles Management</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Roles</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Roles</div>
          <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Add Role</a>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($roles) == 0)
                <h3 class="text-center">NO ROLE FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Permissions</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($roles as $key => $role)
                        <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$role->name}}</td>
                          <td>
                            <a class="btn btn-info btn-sm editbtn" href="{{route('admin.role.permissions.manage', $role->id)}}">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                              Manage
                            </a>
                          </td>
                          <td>
                            <a class="btn btn-secondary btn-sm editbtn" href="#editModal" data-toggle="modal" data-role_id="{{$role->id}}" data-name="{{$role->name}}">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                              Edit
                            </a>
                            <form class="deleteform d-inline-block" action="{{route('admin.role.delete')}}" method="post">
                              @csrf
                              <input type="hidden" name="role_id" value="{{$role->id}}">
                              <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                <span class="btn-label">
                                  <i class="fas fa-trash"></i>
                                </span>
                                Delete
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Create Roles Modal -->
  @includeif('admin.role.create')

  <!-- Edit Roles Modal -->
  @includeif('admin.role.edit')

@endsection
