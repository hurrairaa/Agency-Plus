@extends('admin.layout')

@if(!empty($abs->language) && $abs->language->rtl == 1)
@section('styles')
<style>
    form:not(.modal-form) input,
    form:not(.modal-form)  textarea,
    form:not(.modal-form)  select {
        direction: rtl;
    }
    form:not(.modal-form)  .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif

@section('content')
  <div class="page-header">
    <h4 class="page-title">Approach Section</h4>
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
        <a href="#">Home</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Approach Section</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card-title">Title & Subtitle</div>
                </div>
                <div class="col-lg-2">
                    @if (!empty($langs))
                        <select name="language" class="form-control" onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                            <option value="" selected disabled>Select a Language</option>
                            @foreach ($langs as $lang)
                                <option value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
        </div>
        <form class="" action="{{route('admin.approach.update', $lang_id)}}" method="post">
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-lg-3">
                <div class="form-group">
                  <label>Title **</label>
                  <input class="form-control" name="approach_section_title" value="{{$abs->approach_title}}" placeholder="Enter Title">
                  @if ($errors->has('approach_section_title'))
                    <p class="mb-0 text-danger">{{$errors->first('approach_section_title')}}</p>
                  @endif
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group">
                  <label>Subtitle **</label>
                  <input class="form-control" name="approach_section_subtitle" value="{{$abs->approach_subtitle}}" placeholder="Enter Subtitle">
                  @if ($errors->has('approach_section_subtitle'))
                    <p class="mb-0 text-danger">{{$errors->first('approach_section_subtitle')}}</p>
                  @endif
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group">
                  <label>Button Text</label>
                  <input class="form-control" name="approach_section_button_text" value="{{$abs->approach_button_text}}" placeholder="Enter Button Text">
                  @if ($errors->has('approach_section_button_text'))
                    <p class="mb-0 text-danger">{{$errors->first('approach_section_button_text')}}</p>
                  @endif
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group">
                  <label>Button URL</label>
                  <input class="form-control ltr" name="approach_section_button_url" value="{{$abs->approach_button_url}}" placeholder="Enter Button URL">
                  @if ($errors->has('approach_section_button_url'))
                    <p class="mb-0 text-danger">{{$errors->first('approach_section_button_url')}}</p>
                  @endif
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

      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Points</div>
          <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#createPointModal"><i class="fas fa-plus"></i> Add Point</a>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($points) == 0)
                <h2 class="text-center">NO POINT ADDED</h2>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Title</th>
                        <th scope="col">Serial Number</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($points as $key => $point)
                        <tr>
                          <td>{{$loop->iteration}}</td>
                          <td><i class="{{ $point->icon }}"></i></td>
                          <td>{{convertUtf8($point->title)}}</td>
                          <td>{{$point->serial_number}}</td>
                          <td>
                            <a class="btn btn-secondary btn-sm" href="{{route('admin.approach.point.edit', $point->id) . '?language=' . request()->input('language')}}">
                            <span class="btn-label">
                              <i class="fas fa-edit"></i>
                            </span>
                            Edit
                            </a>
                            <form class="d-inline-block deleteform" action="{{route('admin.approach.pointdelete')}}" method="post">
                              @csrf
                              <input type="hidden" name="pointid" value="{{$point->id}}">
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

  {{-- Point Create Modal --}}
  @includeif('admin.home.approach.create')
@endsection


@section('scripts')
  <script>
    $(document).ready(function() {
        $('.icp').on('iconpickerSelected', function(event){
            $("#inputIcon").val($(".iconpicker-component").find('i').attr('class'));
        });

        // make input fields RTL
        $("select[name='language_id']").on('change', function() {
            $(".request-loader").addClass("show");
            let url = "{{url('/')}}/admin/rtlcheck/" + $(this).val();
            console.log(url);
            $.get(url, function(data) {
                $(".request-loader").removeClass("show");
                if (data == 1) {
                    $("form.modal-form input").each(function() {
                        if (!$(this).hasClass('ltr')) {
                            $(this).addClass('rtl');
                        }
                    });
                    $("form.modal-form select").each(function() {
                        if (!$(this).hasClass('ltr')) {
                            $(this).addClass('rtl');
                        }
                    });
                    $("form.modal-form textarea").each(function() {
                        if (!$(this).hasClass('ltr')) {
                            $(this).addClass('rtl');
                        }
                    });
                    $("form.modal-form .nicEdit-main").each(function() {
                        $(this).addClass('rtl text-right');
                    });

                } else {
                    $("form.modal-form input, form.modal-form select, form.modal-form textarea").removeClass('rtl');
                    $("form.modal-form .nicEdit-main").removeClass('rtl text-right');
                }
            })
        });
    });
  </script>
@endsection
