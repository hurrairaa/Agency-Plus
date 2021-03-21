@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Sliders</h4>
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
        <a href="#">Home Page</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Hero Section</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Sliders</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-title d-inline-block">Sliders</div>
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
                    <a href="#" class="btn btn-primary float-lg-right float-left" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Add Slider</a>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              @if (count($sliders) == 0)
                <h3 class="text-center">NO SLIDER FOUND</h3>
              @else
                <div class="row">
                  @foreach ($sliders as $key => $slider)
                    <div class="col-md-3">
                      <div class="card">
        								<div class="card-body">
                          <img src="{{asset('assets/front/img/sliders/'.$slider->image)}}" alt="" style="width:100%;">
        								</div>
        								<div class="card-footer text-center">
                          <a class="btn btn-secondary btn-sm mr-2" href="{{route('admin.slider.edit', $slider->id) . '?language=' . request()->input('language')}}">
                          <span class="btn-label">
                            <i class="fas fa-edit"></i>
                          </span>
                          Edit
                          </a>
                          <form class="deleteform d-inline-block" action="{{route('admin.slider.delete')}}" method="post">
                            @csrf
                            <input type="hidden" name="slider_id" value="{{$slider->id}}">
                            <button type="submit" class="btn btn-danger btn-sm deletebtn">
                              <span class="btn-label">
                                <i class="fas fa-trash"></i>
                              </span>
                              Delete
                            </button>
                          </form>
        								</div>
        							</div>
                    </div>
                  @endforeach
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Create Slider Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Slider</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="mb-3 dm-uploader drag-and-drop-zone modal-form" enctype="multipart/form-data" action="{{route('admin.slider.upload')}}" method="POST">
            <div class="form-row px-2">
              <div class="col-12 mb-2">
                <label for=""><strong>Image **</strong></label>
              </div>
              <div class="col-md-12 d-md-block d-sm-none mb-3">
                <img src="{{asset('assets/admin/img/noimage.jpg')}}" alt="..." class="img-thumbnail">
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
                    <input type="file" title='Click to add Files' name="logo" />
                  </div>
                  <small class="status text-muted">Select a file or drag it over this area..</small>
                  <p class="em text-danger mb-0" id="errslider_image"></p>
                </div>
              </div>
            </div>
          </form>
          <form class="modal-form" id="ajaxForm" action="{{route('admin.slider.store')}}" method="post">
            @csrf
            <input type="hidden" id="image" name="slider_image" value="">
            <div class="form-group">
                <label for="">Language **</label>
                <select name="language_id" class="form-control">
                    <option value="" selected disabled>Select a language</option>
                    @foreach ($langs as $lang)
                        <option value="{{$lang->id}}">{{$lang->name}}</option>
                    @endforeach
                </select>
                <p id="errlanguage_id" class="mb-0 text-danger em"></p>
            </div>


            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Title </label>
                      <input type="text" class="form-control" name="title" value="" placeholder="Enter Title">
                      <p id="errtitle" class="mb-0 text-danger em"></p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Title Font Size **</label>
                      <input type="number" class="form-control ltr" name="title_font_size" value="">
                      <p id="errtitle_font_size" class="em text-danger mb-0"></p>
                    </div>
                </div>
            </div>


            @if (getVersion($be->theme_version) == 'gym' || getVersion($be->theme_version) == 'car' || getVersion($be->theme_version) == 'cleaning')
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Bold Text </label>
                            <input type="text" class="form-control" name="bold_text" value="" placeholder="Enter Bold Text">
                            <p id="errbold_text" class="mb-0 text-danger em"></p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Bold Text Font Size **</label>
                            <input type="number" class="form-control ltr" name="bold_text_font_size" value="">
                            <p id="errbold_text_font_size" class="em text-danger mb-0"></p>
                        </div>
                    </div>
                </div>
            @endif



            @if (getVersion($be->theme_version) == 'cleaning')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Bold Text Color **</label>
                            <input type="text" class="form-control jscolor" name="bold_text_color" value="#13287e">
                            <p id="errbold_text_color" class="em text-danger mb-0"></p>
                        </div>
                    </div>
                </div>
            @endif


            @if (getVersion($be->theme_version) != 'cleaning')
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="">Text </label>
                        <input type="text" class="form-control" name="text" value="" placeholder="Enter Text">
                        <p id="errtext" class="mb-0 text-danger em"></p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Text Font Size **</label>
                            <input type="number" class="form-control ltr" name="text_font_size" value="">
                            <p id="errtext_font_size" class="em text-danger mb-0"></p>
                        </div>
                    </div>
                </div>
            @endif


            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Button Text </label>
                      <input type="text" class="form-control" name="button_text" value="" placeholder="Enter Button Text">
                      <p id="errbutton_text" class="mb-0 text-danger em"></p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Button Text Font Size **</label>
                        <input type="number" class="form-control ltr" name="button_text_font_size" value="">
                        <p id="errbutton_text_font_size" class="em text-danger mb-0"></p>
                    </div>
                </div>
            </div>


            <div class="form-group">
              <label for="">Button URL </label>
              <input type="text" class="form-control ltr" name="button_url" value="" placeholder="Enter Button URL">
              <p id="errbutton_url" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">Serial Number **</label>
              <input type="number" class="form-control ltr" name="serial_number" value="" placeholder="Enter Serial Number">
              <p id="errserial_number" class="mb-0 text-danger em"></p>
              <p class="text-warning"><small>The higher the serial number is, the later the slider will be shown.</small></p>
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

@section('scripts')
<script>
$(document).ready(function() {

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
                $("form .nicEdit-main").each(function() {
                    $(this).addClass('rtl text-right');
                });

            } else {
                $("form input, form select, form textarea").removeClass('rtl');
                $("form .nicEdit-main").removeClass('rtl text-right');
            }
        })
    });
});
</script>
@endsection
