@extends('admin.layout')
@section('content')
<div class="page-header">
   <h4 class="page-title">Pages</h4>
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
         <a href="#">Create Page</a>
      </li>
      <li class="separator">
         <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
         <a href="#">Pages</a>
      </li>
   </ul>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <div class="card-title">Create Page</div>
         </div>
         <div class="card-body pt-5 pb-4">
            <div class="row">
               <div class="col-lg-10 offset-lg-1">
                  <form id="ajaxForm" action="{{route('admin.page.store')}}" method="post">
                     @csrf
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
                              <label for="">Name **</label>
                              <input type="text" name="name" class="form-control" placeholder="Enter Name" value="">
                              <p id="errname" class="em text-danger mb-0"></p>
                           </div>
                        </div>
                        <div class="col-lg-4">
                           <div class="form-group">
                              <label for="">Title **</label>
                              <input type="text" class="form-control" name="title" placeholder="Enter Title" value="">
                              <p id="errtitle" class="em text-danger mb-0"></p>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">Subtitle **</label>
                              <input type="text" class="form-control" name="subtitle" placeholder="Enter Subtitle" value="">
                              <p id="errsubtitle" class="em text-danger mb-0"></p>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">Status **</label>
                              <select class="form-control ltr" name="status">
                                 <option value="1">Active</option>
                                 <option value="0">Deactive</option>
                              </select>
                              <p id="errstatus" class="em text-danger mb-0"></p>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="">Body **</label>
                        <textarea id="body" class="form-control summernote" name="body" data-height="500"></textarea>
                        <p id="errbody" class="em text-danger mb-0"></p>
                     </div>
                     <div class="form-group">
                        <label for="">Serial Number **</label>
                        <input type="number" class="form-control ltr" name="serial_number" value="" placeholder="Enter Serial Number">
                        <p id="errserial_number" class="mb-0 text-danger em"></p>
                        <p class="text-warning"><small>The higher the serial number is, the later the page will be shown in menu.</small></p>
                     </div>
                     <div class="form-group">
                        <label>Meta Keywords</label>
                        <input class="form-control" name="meta_keywords" value="" placeholder="Enter meta keywords" data-role="tagsinput">
                     </div>
                     <div class="form-group">
                        <label>Meta Description</label>
                        <textarea class="form-control" name="meta_description" rows="5" placeholder="Enter meta description"></textarea>
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
