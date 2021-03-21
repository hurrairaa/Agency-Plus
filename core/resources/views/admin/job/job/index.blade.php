@extends('admin.layout')

@php
$selLang = \App\Language::where('code', request()->input('language'))->first();
@endphp
@if(!empty($selLang) && $selLang->rtl == 1)
@section('styles')
<style>
    form:not(.modal-form) input,
    form:not(.modal-form) textarea,
    form:not(.modal-form) select,
    select[name='language'] {
        direction: rtl;
    }
    form:not(.modal-form) .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif

@section('content')
  <div class="page-header">
    <h4 class="page-title">Jobs</h4>
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
        <a href="#">Career Page</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Jobs</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-title d-inline-block">Jobs</div>
                </div>
                <div class="col-lg-3">
                    @if (!empty($langs))
                        <select name="language" class="form-control" onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                            <option value="" selected disabled>Select a Language</option>
                            @foreach ($langs as $lang)
                                <option value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
                <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                    <a href="{{route('admin.job.create') . '?language=' . request()->input('language')}}" class="btn btn-primary float-lg-right float-left btn-sm"><i class="fas fa-plus"></i> Post Job</a>
                    <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.job.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                </div>
            </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($jobs) == 0)
                <h3 class="text-center">NO JOB FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">Title</th>
                        <th scope="col">Category</th>
                        <th scope="col">Vacancy</th>
                        <th scope="col">Serial Number</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($jobs as $key => $job)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{$job->id}}">
                          </td>
                          <td>{{strlen(convertUtf8($job->title)) > 70 ? convertUtf8(substr($job->title, 0, 70)) . '...' : convertUtf8($job->title)}}</td>
                          <td>
                              @if (!empty($job->jcategory))
                              {{convertUtf8($job->jcategory->name)}}
                              @endif
                          </td>
                          <td>{{$job->vacancy}}</td>
                          <td>{{$job->serial_number}}</td>
                          <td>
                            <a class="btn btn-secondary btn-sm" href="{{route('admin.job.edit', $job->id) . '?language=' . request()->input('language')}}">
                            <span class="btn-label">
                              <i class="fas fa-edit"></i>
                            </span>
                            Edit
                            </a>
                            <form class="deleteform d-inline-block" action="{{route('admin.job.delete')}}" method="post">
                              @csrf
                              <input type="hidden" name="job_id" value="{{$job->id}}">
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
        <div class="card-footer">
          <div class="row">
            <div class="d-inline-block mx-auto">
              {{$jobs->links()}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Create Job Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Post Job</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxForm" class="" action="{{route('admin.job.store')}}" method="POST">
            @csrf
            <input type="hidden" id="image" name="" value="">
            <div class="form-group">
              <label for="">Title **</label>
              <input type="text" class="form-control" name="title" placeholder="Enter title" value="">
              <p id="errtitle" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">Category **</label>
              <select class="form-control" name="category">
                <option value="" selected disabled>Select a category</option>
                @foreach ($scats as $key => $scat)
                  <option value="{{$scat->id}}">{{$scat->name}}</option>
                @endforeach
              </select>
              <p id="errcategory" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">Content **</label>
              <textarea id="nicContent" class="form-control nic-edit" name="content" rows="8" cols="80" placeholder="Enter content"></textarea>
              <p id="errcontent" class="mb-0 text-danger em"></p>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="submitBtn" type="button" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>
@endsection
