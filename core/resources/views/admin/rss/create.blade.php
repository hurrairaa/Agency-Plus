@extends('admin.layout')

@php
$selLang = \App\Language::where('code', request()->input('language'))->first();
@endphp
@if(!empty($selLang->language) && $selLang->language->rtl == 1)
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
    <h4 class="page-title">Import RSS feed</h4>
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
        <a href="#">RSS feeds</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Import RSS feed</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Import RSS feed</div>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              <form id="ajaxForm" class="" action="{{route('admin.rss.store')}}" method="post">
                @csrf

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

                <div class="form-group">
                  <label for="">Feed Name **</label>
                  <input type="text" class="form-control" name="feed_name" placeholder="Enter Feed Name">
                  <p id="errfeedname" class="mb-0 text-danger em"></p>
                </div>

                <div class="form-group">
                  <label for="">Feed Url **</label>
                  <input type="text" class="form-control ltr" name="feed_url" placeholder="Enter Feed Url">
                  <p id="errfeedurl" class="mb-0 text-danger em"></p>
                </div>

                <div class="form-group">
                  <label for="">Number of Posts to Import **</label>
                  <input type="number" class="form-control ltr" name="post_limit" placeholder="Enter Post Limit">
                  <p id="errpostlimit" class="mb-0 text-danger em"></p>
                </div>

                <div class="form-group">
                  <label for="">Read More Button Text **</label>
                  <input type="text" class="form-control" name="read_more_button" value="Read More">
                  <p id="errreadmore" class="mb-0 text-danger em"></p>
                </div>

              </form>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="form">
            <div class="form-group from-show-notify row">
              <div class="col-12 text-center">
                <button type="submit" id="submitBtn" class="btn btn-success">Import RSS feed</button>
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
</script>
@endsection
