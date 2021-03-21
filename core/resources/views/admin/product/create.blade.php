@extends('admin.layout')
@section('content')
<div class="page-header">
   <h4 class="page-title">Create Product</h4>
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
         <a href="#">Product Page</a>
      </li>
      <li class="separator">
         <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
         <a href="#">Create Product</a>
      </li>
   </ul>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <div class="card-title d-inline-block">Create Product</div>
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.product.index') . '?language=' . request()->input('language')}}">
            <span class="btn-label">
            <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
            </a>
         </div>
         <div class="card-body pt-5 pb-5">
            <div class="row">
               <div class="col-lg-8 offset-lg-2">
                  {{-- Slider images upload start --}}
                  <div class="px-2">
                     <label for="" class="mb-2"><strong>Slider Images **</strong></label>
                     <form action="{{route('admin.product.sliderstore')}}" id="my-dropzone" enctype="multipart/formdata" class="dropzone create">
                        @csrf
                        <div class="fallback">
                           <input name="file" type="file" multiple  />
                        </div>
                     </form>
                     <p class="em text-danger mb-0" id="errslider_images"></p>
                  </div>
                  {{-- Slider images upload end --}}
                  {{-- Featured image upload start --}}
                  <div class="mt-4">
                     <form class="mb-3 dm-uploader drag-and-drop-zone create-form" enctype="multipart/form-data" action="{{route('admin.product.upload')}}" method="POST">
                        <div class="form-row px-2">
                           <div class="col-12 mb-2">
                              <label for=""><strong>Featured Image **</strong></label>
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
                                    <input type="file" title='Click to add Files' />
                                 </div>
                                 <small class="status text-muted">Select a file or drag it over this area..</small>
                                 <p class="em text-danger mb-0" id="errportfolio"></p>
                                 <p class="em text-danger mb-0" id="errfeatured_image"></p>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
                  {{-- Featured image upload end --}}
                  <form id="ajaxForm" class="" action="{{route('admin.product.store')}}" method="post">
                     @csrf
                     <input type="hidden" id="image" name="" value="">
                     <div id="sliders"></div>
                     <div class="row">
                        <div class="col-lg-6">
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
                        <div class="col-lg-6">
                            <div class="form-group">
                               <label for="">Status **</label>
                               <select class="form-control ltr" name="status">
                                  <option value="" selected disabled>Select a status</option>
                                  <option value="1">Show</option>
                                  <option value="0">Hide</option>
                               </select>
                               <p id="errstatus" class="mb-0 text-danger em"></p>
                            </div>
                         </div>
                     </div>
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="form-group">
                              <label for="">Title **</label>
                              <input type="text" class="form-control" name="title" value="" placeholder="Enter title">
                              <p id="errtitle" class="mb-0 text-danger em"></p>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                               <label for="category">Category **</label>
                               <select  class="form-control categoryData" name="category_id" id="category">
                                  <option value="" selected disabled>Select a category</option>
                                  @foreach ($categories as $categroy)
                                  <option value="{{$categroy->id}}">{{$categroy->name}}</option>
                                  @endforeach
                               </select>
                               <p id="errcategory_id" class="mb-0 text-danger em"></p>
                            </div>
                         </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">Stock Product **</label>
                              <input type="number" class="form-control ltr" name="stock" value="" placeholder="Enter Product Stock">
                              <p id="errstock" class="mb-0 text-danger em"></p>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for=""> Product Sku **</label>
                              <input type="text" class="form-control" name="sku" value="{{rand(1000000,9999999)}}"  placeholder="Enter Product sku">
                              <p id="errsku" class="mb-0 text-danger em"></p>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">Tags **</label>
                              <input type="text" class="form-control" name="tags" value="" data-role="tagsinput" placeholder="Enter tags">
                              <p id="errtags" class="mb-0 text-danger em"></p>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for=""> Current Price (in {{$abx->base_currency_text}}) **</label>
                              <input type="number" class="form-control ltr" name="current_price" value=""  placeholder="Enter Current Price">
                              <p id="errcurrent_price" class="mb-0 text-danger em"></p>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">Previous Price (in {{$abx->base_currency_text}})</label>
                              <input type="number" class="form-control ltr" name="previous_price" value="" placeholder="Enter Previous Price">
                              <p id="errprevious_price" class="mb-0 text-danger em"></p>
                           </div>
                        </div>
                     </div>
                     <div class="row">

                        <div class="col-lg-12">
                           <div class="form-group">
                              <label for="summary">Summary **</label>
                              <textarea name="summary" id="summary" class="form-control" rows="4" placeholder="Enter Product Summary"></textarea>
                              <p id="errsummary" class="mb-0 text-danger em"></p>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="form-group">
                              <label for="">Description **</label>
                              <textarea class="form-control summernote" name="description" placeholder="Enter description" data-height="300"></textarea>
                              <p id="errdescription" class="mb-0 text-danger em"></p>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                         <div class="col-lg-12">
                            <div class="form-group">
                                <label>Meta Keywords</label>
                                <input class="form-control" name="meta_keywords" value="" placeholder="Enter meta keywords" data-role="tagsinput">
                            </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-lg-12">
                            <div class="form-group">
                                <label>Meta Description</label>
                                <textarea class="form-control" name="meta_description" rows="5" placeholder="Enter meta description"></textarea>
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
@section('scripts')
<script>
   $(document).ready(function() {
       // services load according to language selection
       $("select[name='language_id']").on('change', function() {

           $("#category").removeAttr('disabled');

           let langid = $(this).val();
           let url = "{{url('/')}}/admin/product/" + langid + "/getcategory";
           // console.log(url);
           $.get(url, function(data) {
               // console.log(data);
               let options = `<option value="" disabled selected>Select a category</option>`;
               for (let i = 0; i < data.length; i++) {
                   options += `<option value="${data[i].id}">${data[i].name}</option>`;
               }

               $(".categoryData").html(options);

           });
       });


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

       // translatable portfolios will be available if the selected language is not 'Default'
       $("#language").on('change', function() {
           let language = $(this).val();
           // console.log(language);
           if (language == 0) {
               $("#translatable").attr('disabled', true);
           } else {
               $("#translatable").removeAttr('disabled');
           }
       });
   });


   // myDropzone is the configuration for the element that has an id attribute
   // with the value my-dropzone (or myDropzone)
   Dropzone.options.myDropzone = {
     acceptedFiles: '.png, .jpg, .jpeg',
     url: "{{route('admin.product.sliderstore')}}",
     success : function(file, response){
         console.log(response.file_id);
         $("#sliders").append(`<input type="hidden" name="slider_images[]" id="slider${response.file_id}" value="${response.file_id}">`);

         // Create the remove button
         var removeButton = Dropzone.createElement("<button class='rmv-btn'><i class='fa fa-times'></i></button>");


         // Capture the Dropzone instance as closure.
         var _this = this;

         // Listen to the click event
         removeButton.addEventListener("click", function(e) {
           // Make sure the button click doesn't submit the form:
           e.preventDefault();
           e.stopPropagation();

           _this.removeFile(file);

           rmvimg(response.file_id);
         });

         // Add the button to the file preview element.
         file.previewElement.appendChild(removeButton);

         if(typeof response.error != 'undefined') {
           if (typeof response.file != 'undefined') {
             document.getElementById('errpreimg').innerHTML = response.file[0];
           }
         }
     }
   };

   function rmvimg(fileid) {
       // If you want to the delete the file on the server as well,
       // you can do the AJAX request here.

         $.ajax({
           url: "{{route('admin.product.sliderrmv')}}",
           type: 'POST',
           data: {
             _token: "{{csrf_token()}}",
             fileid: fileid
           },
           success: function(data) {
             $("#slider"+fileid).remove();
           }
         });

   }

   var today = new Date();
   $("#submissionDate").datepicker({
     autoclose: true,
     endDate : today,
     todayHighlight: true
   });
   $("#startDate").datepicker({
     autoclose: true,
     endDate : today,
     todayHighlight: true
   });
</script>
@endsection
