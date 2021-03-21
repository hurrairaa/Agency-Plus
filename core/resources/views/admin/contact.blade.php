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
    <h4 class="page-title">Contact Page</h4>
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
        <a href="#">Contact Page</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data" action="{{route('admin.contact.update', $lang_id)}}" method="POST">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card-title">Contact Page</div>
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
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                @csrf
                <div class="form-group">
                  <label>Form Title **</label>
                  <input class="form-control" name="contact_form_title" value="{{$abs->contact_form_title}}" placeholder="Enter Titlte">
                  @if ($errors->has('contact_form_title'))
                    <p class="mb-0 text-danger">{{$errors->first('contact_form_title')}}</p>
                  @endif
                </div>
                <div class="form-group">
                  <label>Form Subtitle **</label>
                  <input class="form-control" name="contact_form_subtitle" value="{{$abs->contact_form_subtitle}}" placeholder="Enter Subtitlte">
                  @if ($errors->has('contact_form_subtitle'))
                    <p class="mb-0 text-danger">{{$errors->first('contact_form_subtitle')}}</p>
                  @endif
                </div>
                <div class="form-group">
                  <label>Address **</label>
                  <input class="form-control" name="contact_address" value="{{$abs->contact_address}}" placeholder="Enter Address">
                  @if ($errors->has('contact_address'))
                    <p class="mb-0 text-danger">{{$errors->first('contact_address')}}</p>
                  @endif
                </div>
                <div class="form-group">
                  <label>Phone **</label>
                  <input class="form-control" name="contact_number" value="{{$abs->contact_number}}" placeholder="Enter Phone Number">
                  @if ($errors->has('contact_number'))
                    <p class="mb-0 text-danger">{{$errors->first('contact_number')}}</p>
                  @endif
                </div>
                <div class="form-group">
                  <label>Email **</label>
                  <input class="form-control ltr" name="contact_mail" value="{{$abe->to_mail}}" readonly>
                  <div class="text-warning">You cannot upadate Email Address from here, you can update it from <a class="text-" href="{{route('admin.mailToAdmin')}}"><u>Basic Settings > Email Settings > Mail To Admin</u></a></p></div>
                </div>
                <div class="form-group">
                  <label>Latitude **</label>
                  <input class="form-control ltr" name="latitude" value="{{$abs->latitude}}" placeholder="Enter Latitude">
                  @if ($errors->has('latitude'))
                    <p class="mb-0 text-danger">{{$errors->first('latitude')}}</p>
                  @endif
                </div>
                <div class="form-group">
                  <label>Longitude **</label>
                  <input class="form-control ltr" name="longitude" value="{{$abs->longitude}}" placeholder="Enter Longitude">
                  @if ($errors->has('longitude'))
                    <p class="mb-0 text-danger">{{$errors->first('longitude')}}</p>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer pt-3">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button id="displayNotif" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection
