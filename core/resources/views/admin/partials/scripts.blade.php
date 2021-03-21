<!--   Core JS Files   -->
<script src="{{asset('assets/admin/js/core/jquery.3.2.1.min.js')}}"></script>
<script src="{{asset('assets/admin/js/core/vue.js')}}"></script>
<script src="{{asset('assets/admin/js/core/popper.min.js')}}"></script>
<script src="{{asset('assets/admin/js/core/bootstrap.min.js')}}"></script>

<!-- jQuery UI -->
<script src="{{asset('assets/admin/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

<!-- jQuery Scrollbar -->
<script src="{{asset('assets/admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

<!-- Bootstrap Notify -->
<script src="{{asset('assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

<!-- Sweet Alert -->
<script src="{{asset('assets/admin/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

<!-- Bootstrap Tag Input -->
<script src="{{asset('assets/admin/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js')}}"></script>

<!-- Bootstrap Datepicker -->
<script src="{{asset('assets/admin/js/plugin/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>

<!-- Dropzone JS -->
<script src="{{asset('assets/admin/js/plugin/dropzone/jquery.dropzone.min.js')}}"></script>

<!-- DM Uploader JS -->
<script src="{{asset('assets/admin/js/plugin/jquery.dm-uploader/jquery.dm-uploader.min.js')}}"></script>

<!-- Summernote JS -->
<script src="{{asset('assets/admin/js/plugin/summernote/summernote-bs4.js')}}"></script>

<!-- JS color JS -->
<script src="{{asset('assets/admin/js/plugin/jscolor/jscolor.js')}}"></script>

<!-- Atlantis JS -->
<script src="{{asset('assets/admin/js/atlantis.min.js')}}"></script>

<!-- Fontawesome Icon Picker JS -->
<script src="{{asset('assets/admin/js/plugin/fontawesome-iconpicker/fontawesome-iconpicker.min.js')}}"></script>

<script>
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
</script>

<script>
    var imgupload = "{{route('admin.summernote.upload')}}";
</script>

<!-- Custom JS -->
<script src="{{asset('assets/admin/js/custom.js')}}"></script>

@yield('scripts')

@yield('vuescripts')

@if (session()->has('success'))
<script>
  var content = {};

  content.message = '{{session('success')}}';
  content.title = 'Success';
  content.icon = 'fa fa-bell';

  $.notify(content,{
    type: 'success',
    placement: {
      from: 'top',
      align: 'right'
    },
    showProgressbar: true,
    time: 1000,
    delay: 4000,
  });
</script>
@endif


@if (session()->has('warning'))
<script>
  var content = {};

  content.message = '{{session('warning')}}';
  content.title = 'Warning!';
  content.icon = 'fa fa-bell';

  $.notify(content,{
    type: 'warning',
    placement: {
      from: 'top',
      align: 'right'
    },
    showProgressbar: true,
    time: 1000,
    delay: 4000,
  });
</script>
@endif
