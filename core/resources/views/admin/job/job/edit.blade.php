@extends('admin.layout')

@if(!empty($job->language) && $job->language->rtl == 1)
@section('styles')
<style>
    form input,
    form textarea,
    form select {
        direction: rtl;
    }
    form .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif

@section('content')
  <div class="page-header">
    <h4 class="page-title">Edit Job</h4>
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
        <a href="#">Edit Job</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Job</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.job.index') . '?language=' . request()->input('language')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-12">

                <form id="ajaxForm" class="" action="{{route('admin.job.update')}}" method="post">
                    @csrf
                    <input type="hidden" name="job_id" value="{{$job->id}}">
                    <div id="sliders"></div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Title **</label>
                                <input type="text" class="form-control" name="title" value="{{$job->title}}"
                                    placeholder="Enter title">
                                <p id="errtitle" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Category **</label>
                                <select class="form-control" name="jcategory_id">
                                    <option value="" selected disabled>Select a category</option>
                                    @foreach ($jcats as $key => $jcat)
                                    <option value="{{$jcat->id}}" {{$job->jcategory_id == $jcat->id ? 'selected' : ''}}>{{$jcat->name}}</option>
                                    @endforeach
                                </select>
                                <p id="errjcategory_id" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Employment Status **</label>
                                <input type="text" class="form-control" name="employment_status" value="{{$job->employment_status}}"
                                    data-role="tagsinput">
                                <p class="text-warning mb-0"><small>Use comma (,) to seperate statuses. eg: full-time, part-time, contractual</small></p>
                                <p id="erremployment_status" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Vacancy **</label>
                                <input type="number" class="form-control" name="vacancy" value="{{$job->vacancy}}"
                                    placeholder="Enter number of vacancy" min="1">
                                <p id="errvacancy" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Application Deadline **</label>
                                <input id="deadline" type="text" class="form-control datepicker ltr" name="deadline" value="{{$job->deadline}}" placeholder="Enter application deadline" autocomplete="off">
                                <p id="errdeadline" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Experience in Years **</label>
                                <input type="text" class="form-control" name="experience" value="{{$job->experience}}"
                                    placeholder="Enter years of experience">
                                <p id="errexperience" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Job Responsibilities **</label>
                                <textarea class="form-control summernote" id="jobRes" name="job_responsibilities" data-height="150"
                                    placeholder="Enter job responsibilities">{{replaceBaseUrl($job->job_responsibilities)}}</textarea>
                                <p id="errjob_responsibilities" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Educational Requirements **</label>
                                <textarea class="form-control summernote" id="eduReq" name="educational_requirements" data-height="150"
                                    placeholder="Enter educational requirements">{{replaceBaseUrl($job->educational_requirements)}}</textarea>
                                <p id="erreducational_requirements" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Experience Requirements **</label>
                                <textarea class="form-control summernote" id="expReq" name="experience_requirements" data-height="150"
                                    placeholder="Enter experience requirements">{{replaceBaseUrl($job->experience_requirements)}}</textarea>
                                <p id="errexperience_requirements" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Additional Requirements</label>
                                <textarea class="form-control summernote" id="addReq" name="additional_requirements" data-height="150"
                                    placeholder="Enter additional requirements">{{replaceBaseUrl($job->additional_requirements)}}</textarea>
                                <p id="erradditional_requirements" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Salary **</label>
                                <textarea class="form-control summernote" id="salary" name="salary" data-height="150"
                                    placeholder="Enter salary">{{replaceBaseUrl($job->salary)}}</textarea>
                                <p id="errsalary" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Benefits</label>
                                <textarea class="form-control summernote" id="benefits" name="benefits" data-height="150"
                                    placeholder="Enter compensation & other benefits">{{replaceBaseUrl($job->benefits)}}</textarea>
                                <p id="errbenefits" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Job Location **</label>
                                <input type="text" class="form-control" name="job_location" value="{{$job->job_location}}"
                                    placeholder="Enter job location">
                                <p id="errjob_location" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Email <span class="text-warning">(Where applicatints will send their CVs)</span> **</label>
                                <input type="email" class="form-control ltr" name="email" value="{{$job->email}}"
                                    placeholder="Enter email address">
                                <p id="erremail" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Read Before Apply</label>
                                <textarea class="form-control summernote" id="read_before_apply" name="read_before_apply" data-height="150"
                                    placeholder="Enter read before apply">{{replaceBaseUrl($job->read_before_apply)}}</textarea>
                                <p id="errread_before_apply" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Serial Number **</label>
                                <input type="number" class="form-control ltr" name="serial_number" value="{{$job->serial_number}}" placeholder="Enter Serial Number">
                                <p id="errserial_number" class="mb-0 text-danger em"></p>
                                <p class="text-warning"><small>The higher the serial number is, the later the job will be shown.</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Meta Keywords</label>
                                <input class="form-control" name="meta_keywords" value="{{$job->meta_keywords}}" placeholder="Enter meta keywords" data-role="tagsinput">
                             </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Meta Description</label>
                                <textarea class="form-control" name="meta_description" rows="3" placeholder="Enter meta description">{{$job->meta_description}}</textarea>
                             </div>
                        </div>
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

@section('scripts')
<script>
$(document).ready(function() {
    var today = new Date();
    $("#deadline").datepicker({
      autoclose: true,
      endDate : today,
      todayHighlight: true
    });
});
</script>
@endsection
