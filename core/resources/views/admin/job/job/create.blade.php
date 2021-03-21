@extends('admin.layout')

@section('content')
<div class="page-header">
    <h4 class="page-title">Post Job</h4>
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
            <a href="#">Career Page</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Post Job</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title d-inline-block">Post Job</div>
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

                        <form id="ajaxForm" class="" action="{{route('admin.job.store')}}" method="post">
                            @csrf
                            <div id="sliders"></div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Language **</label>
                                        <select id="language" name="language_id" class="form-control">
                                            <option value="" selected disabled>Select a language</option>
                                            @foreach ($langs as $lang)
                                                <option value="{{$lang->id}}">{{$lang->name}}</option>
                                            @endforeach
                                        </select>
                                        <p id="errlanguage_id" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Title **</label>
                                        <input type="text" class="form-control" name="title" value=""
                                            placeholder="Enter title">
                                        <p id="errtitle" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Category **</label>
                                        <select id="jcategory" class="form-control" name="jcategory_id" disabled>
                                            <option value="" selected disabled>Select a category</option>
                                            @foreach ($jcats as $key => $jcat)
                                            <option value="{{$jcat->id}}">{{$jcat->name}}</option>
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
                                        <input type="text" class="form-control" name="employment_status" value=""
                                            data-role="tagsinput">
                                        <p class="text-warning mb-0"><small>Use comma (,) to seperate statuses. eg: full-time, part-time, contractual</small></p>
                                        <p id="erremployment_status" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Vacancy **</label>
                                        <input type="number" class="form-control" name="vacancy" value=""
                                            placeholder="Enter number of vacancy" min="1">
                                        <p id="errvacancy" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Application Deadline **</label>
                                        <input id="deadline" type="text" class="form-control datepicker ltr" name="deadline" value="" placeholder="Enter application deadline" autocomplete="off">
                                        <p id="errdeadline" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Experience in Years **</label>
                                        <input type="text" class="form-control" name="experience" value=""
                                            placeholder="Enter years of experience">
                                        <p id="errexperience" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Job Responsibilities **</label>
                                        <textarea class="form-control summernote" id="jobRes" name="job_responsibilities"
                                            placeholder="Enter job responsibilities" data-height="150"></textarea>
                                        <p id="errjob_responsibilities" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Educational Requirements **</label>
                                        <textarea class="form-control summernote" id="eduReq" name="educational_requirements"
                                            placeholder="Enter educational requirements" data-height="150"></textarea>
                                        <p id="erreducational_requirements" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Experience Requirements **</label>
                                        <textarea class="form-control summernote" id="expReq" name="experience_requirements"
                                            placeholder="Enter experience requirements" data-height="150"></textarea>
                                        <p id="errexperience_requirements" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Additional Requirements</label>
                                        <textarea class="form-control summernote" id="addReq" name="additional_requirements"
                                            placeholder="Enter additional requirements" data-height="150"></textarea>
                                        <p id="erradditional_requirements" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Salary **</label>
                                        <textarea class="form-control summernote" id="salary" name="salary"
                                            placeholder="Enter salary" data-height="150"></textarea>
                                        <p id="errsalary" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Benefits</label>
                                        <textarea class="form-control summernote" id="benefits" name="benefits"
                                            placeholder="Enter compensation & other benefits" data-height="150"></textarea>
                                        <p id="errbenefits" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Job Location **</label>
                                        <input type="text" class="form-control" name="job_location" value=""
                                            placeholder="Enter job location">
                                        <p id="errjob_location" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Email <span class="text-warning">(Where applicatints will send their CVs)</span> **</label>
                                        <input type="email" class="form-control ltr" name="email" value=""
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
                                            placeholder="Enter read before apply"></textarea>
                                        <p id="errread_before_apply" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Serial Number **</label>
                                        <input type="number" class="form-control ltr" name="serial_number" value="" placeholder="Enter Serial Number">
                                        <p id="errserial_number" class="mb-0 text-danger em"></p>
                                        <p class="text-warning"><small>The higher the serial number is, the later the job will be shown.</small></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Meta Keywords</label>
                                        <input class="form-control" name="meta_keywords" value="" placeholder="Enter meta keywords" data-role="tagsinput">
                                     </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        <textarea class="form-control" name="meta_description" placeholder="Enter meta description" rows="4"></textarea>
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
                            <button type="submit" id="submitBtn" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection


@section('type', 'no-modal')


@section('scripts')
<script>
$(document).ready(function() {
    var today = new Date();
    $("#deadline").datepicker({
      autoclose: true,
      endDate : today,
      todayHighlight: true
    });

    $("select[name='language_id']").on('change', function() {
        $("#jcategory").removeAttr('disabled');

        let langid = $(this).val();
        let url = "{{url('/')}}/admin/job/" + langid + "/getcats";
        // console.log(url);
        $.get(url, function(data) {
            console.log(data);
            let options = `<option value="" disabled selected>Select a category</option>`;
            for (let i = 0; i < data.length; i++) {
                options += `<option value="${data[i].id}">${data[i].name}</option>`;
            }
            $("#jcategory").html(options);

        });
    });


    // make input fields RTL
    $("select[name='language_id']").on('change', function() {
        $(".request-loader").addClass("show");
        let url = "{{url('/')}}/admin/rtlcheck/" + $(this).val();
        console.log(url);
        $.get(url, function(data) {
            $(".request-loader").removeClass("show");
            if (data == 1) {
                $("form input").each(function() {
                    if (!$(this).hasClass('ltr')) {
                        $(this).addClass('rtl');
                    }
                });
                $("form select").each(function() {
                    if (!$(this).hasClass('ltr')) {
                        $(this).addClass('rtl');
                    }
                });
                $("form textarea").each(function() {
                    if (!$(this).hasClass('ltr')) {
                        $(this).addClass('rtl');
                    }
                });
                $("form .summernote").each(function() {
                    $(this).siblings('.note-editor').find('.note-editable').addClass('rtl text-right');
                });

            } else {
                $("form input, form select, form textarea").removeClass('rtl');
                $("form .summernote").siblings('.note-editor').find('.note-editable').removeClass('rtl text-right');
            }
        })
    });

});
</script>
@endsection
