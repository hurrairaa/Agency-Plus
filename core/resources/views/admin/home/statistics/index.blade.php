@extends('admin.layout')

@if(!empty($selLang) && $selLang->rtl == 1)
@section('styles')
<style>
    select[name='language'] {
        direction: rtl;
    }
</style>
@endsection
@endif

@section('content')
  <div class="page-header">
    <h4 class="page-title">Statistics Section</h4>
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
        <a href="#">Statistics Section</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      @if (getVersion($be->theme_version) != 'car')
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card-title">Background Image</div>
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
            <div class="card-body">
                <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data" action="{{route('admin.statistics.upload', $lang_id)}}" method="POST">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <div class="form-row">
                                <div class="col-12 mb-2">
                                    <label for=""><strong>Background Image **</strong></label>
                                </div>
                                <div class="col-md-6 d-md-block mb-3">
                                    @if (!empty($abe->statistics_bg))
                                        <img src="{{asset('assets/front/img/'.$abe->statistics_bg)}}" alt="..." class="img-thumbnail">
                                    @else
                                        <img src="{{asset('assets/admin/img/noimage.jpg')}}" alt="..." class="img-thumbnail">
                                    @endif
                                </div>
                                <div class="col-md-12">
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
                                        <input type="file" title='Click to add Files' />
                                        </div>
                                        <small class="status text-muted">Select a file or drag it over this area..</small>
                                        <p class="text-warning mb-0">Only jpg, jpeg, png image is allowed.</p>
                                        <p class="text-danger mb-0 em" id="errstatistics_bg"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      @endif

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-title d-inline-block">Statistics</div>
                </div>
                <div class="col-lg-6 mt-2 mt-lg-0">
                    <a href="#" class="btn btn-primary float-lg-right float-left" data-toggle="modal" data-target="#createStatisticModal"><i class="fas fa-plus"></i> Add Statistic</a>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($statistics) == 0)
                <h2 class="text-center">NO STATISTIC ADDED</h2>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Title</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Serial Number</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($statistics as $key => $statistic)
                        <tr>
                          <td>{{$loop->iteration}}</td>
                          <td><i class="{{ $statistic->icon }}"></i></td>
                          <td>{{convertUtf8($statistic->title)}}</td>
                          <td>{{$statistic->quantity}}</td>
                          <td>{{$statistic->serial_number}}</td>
                          <td>
                            <a class="btn btn-secondary btn-sm" href="{{route('admin.statistics.edit', $statistic->id) . '?language=' . request()->input('language')}}">
                            <span class="btn-label">
                              <i class="fas fa-edit"></i>
                            </span>
                            Edit
                            </a>
                            <form class="d-inline-block deleteform" action="{{route('admin.statistics.delete')}}" method="post">
                              @csrf
                              <input type="hidden" name="statisticid" value="{{$statistic->id}}">
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

  {{-- Statistic Create Modal --}}
  @includeif('admin.home.statistics.create')
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
                    $("form .input-group").each(function() {
                        if (!$(this).hasClass('ltr')) {
                            $(this).addClass('rtl');
                        }
                    });
                    $("form .nicEdit-main").each(function() {
                        $(this).addClass('rtl text-right');
                    });

                } else {
                    $("form input, form select, form textarea, form .input-group").removeClass('rtl');
                    $("form .nicEdit-main").removeClass('rtl text-right');
                }
            })
        });
    });
  </script>
@endsection
