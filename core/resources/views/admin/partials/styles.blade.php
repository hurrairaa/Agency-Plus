<!-- Fonts and icons -->
<script src="{{asset('assets/admin/js/plugin/webfont/webfont.min.js')}}"></script>
<script>
  WebFont.load({
    google: {"families":["Lato:300,400,700,900"]},
    custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{asset('assets/admin/css/fonts.min.css')}}']},
    active: function() {
      sessionStorage.fonts = true;
    }
  });
</script>

<!-- CSS Files -->
<link href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/admin/css/fontawesome-iconpicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/dropzone.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/jquery.dm-uploader.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap-datepicker.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/jquery.timepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/summernote-bs4.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/atlantis.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/custom.css')}}">

@yield('styles')
