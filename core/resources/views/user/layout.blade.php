
<!DOCTYPE html>
<html lang="en">


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$bs->website_title}} @yield('pagename')</title>
       <!-- favicon -->
   <link rel="shortcut icon" href="{{asset('assets/front/img/'.$bs->favicon)}}" type="image/x-icon">
    <!-- bootstrap css -->
   <link rel="stylesheet" href="{{asset('assets/user/css/bootstrap.min.css')}}">
    <!-- fontawesome css -->
    <link rel="stylesheet" href="{{asset('assets/user/css/fontawesome.min.css')}}">
    <!-- flaticon css -->
    <link rel="stylesheet" href="{{asset('assets/user/css/flaticon.css')}}">
    <!-- magnific popup css -->
    <link rel="stylesheet" href="{{asset('assets/user/css/magnific-popup.css')}}">
    <!-- owl carousel css -->
    <link rel="stylesheet" href="{{asset('assets/user/css/owl.carousel.min.css')}}">
    <!-- owl carousel theme css -->
    <link rel="stylesheet" href="{{asset('assets/user/css/owl.theme.default.min.css')}}">
    <!-- slick css -->
    <link rel="stylesheet" href="{{asset('assets/user/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/user/css/nice-select.css')}}">
    <!-- slicknav css -->
    <link rel="stylesheet" href="{{asset('assets/user/css/toastr.min.css')}}">
    <!-- slicknav css -->
    <link rel="stylesheet" href="{{asset('assets/user/css/slicknav.css')}}">

    <!-- datatables css -->
    <link rel="stylesheet" href="{{asset('assets/user/css/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/user/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/summernote-bs4.css')}}">
    <!-- dashboard css -->
    <link rel="stylesheet" href="{{asset('assets/user/css/dashboard.css')}}">
    <!-- product css -->
    <link rel="stylesheet" href="{{asset('assets/user/css/product.css')}}">

   <!-- main css -->
   {{-- <link rel="stylesheet" href="{{asset('assets/user/css/style.css')}}"> --}}
   <link rel="stylesheet" href="{{asset('assets/front/css/style.css')}}">
    <!-- responsive css -->
    <link rel="stylesheet" href="{{asset('assets/user/css/responsive.css')}}">
    @if ($rtl == 1)
    <!-- RTL css -->
    <link rel="stylesheet" href="{{asset('assets/front/css/rtl.css')}}">
    @endif

    <!-- base color change -->
    <!-- <link href="{{url('/')}}/assets/front/css/base-color.php?color={{$bs->base_color}}{{!isDark($be->theme_version) ? "&color1=" . $bs->secondary_base_color : ""}}" rel="stylesheet"> -->

    @if (isDark($be->theme_version))
        <!-- dark version css -->
        <link rel="stylesheet" href="{{asset('assets/front/css/dark.css')}}">
        <!-- dark version base color change -->
        <link href="{{url('/')}}/assets/front/css/dark-base-color.php?color={{$bs->base_color}}" rel="stylesheet">
    @endif

    <!-- jquery js -->
    <script src="{{asset('assets/user/js/jquery-3.3.1.min.js')}}"></script>
</head>


<body @if($rtl == 1) dir="rtl" @endif>
    <!--   header area start   -->
    <div class="header-area header-absolute @yield('no-breadcrumb')">
        <div class="container">
           <div class="support-bar-area">
              <div class="row">
                 <div class="col-lg-6 support-contact-info">
                    <span class="address"><i class="far fa-envelope"></i> {{$bs->support_email}}</span>
                    <span class="phone"><i class="flaticon-chat"></i> {{$bs->support_phone}}</span>
                 </div>
                 <div class="col-lg-6 {{$rtl == 1 ? 'text-left' : 'text-right'}}">
                    <ul class="social-links">
                      @foreach ($socials as $key => $social)
                        <li><a target="_blank" href="{{$social->url}}"><i class="{{$social->icon}}"></i></a></li>
                      @endforeach
                    </ul>

                    @if (!empty($currentLang))
                      <div class="language">
                         <a class="language-btn" href="#"><i class="flaticon-worldwide"></i> {{convertUtf8($currentLang->name)}}</a>
                         <ul class="language-dropdown">
                           @foreach ($langs as $key => $lang)
                           <li><a href='{{ route('changeLanguage', $lang->code) }}'>{{convertUtf8($lang->name)}}</a></li>
                           @endforeach
                         </ul>
                      </div>
                    @endif

                    @auth
                    <ul class="login">
                        <li><a href="{{route('user-logout')}}">{{__('Logout')}}</a></li>
                    </ul>
                    @endauth

                 </div>
              </div>
           </div>
           @includeIf('front.default.partials.navbar')
        </div>
     </div>
     <!--   header area end   -->

     @yield('content')

      <!--    footer section start   -->
      <footer class="footer-section">
        <div class="container">
           @if ($bs->top_footer_section == 1)
           <div class="top-footer-section @if ($bs->copyright_section == 0) border-bottom-0 @endif">
              <div class="row">
                 <div class="col-lg-4 col-md-12">
                    <div class="footer-logo-wrapper">
                       <a href="{{route('front.index')}}">
                       <img src="{{asset('assets/front/img/'.$bs->footer_logo)}}" alt="">
                       </a>
                    </div>
                    <p class="footer-txt">{{convertUtf8($bs->footer_text)}}</p>
                 </div>
                 <div class="col-lg-2 col-md-3">
                    <h4>{{__('Useful Links')}}</h4>
                    <ul class="footer-links">
                       @foreach ($ulinks as $key => $ulink)
                         <li><a href="{{$ulink->url}}">{{convertUtf8($ulink->name)}}</a></li>
                       @endforeach
                    </ul>
                 </div>
                 <div class="col-lg-3 col-md-4">
                    <h4>{{__('Newsletter')}}</h4>
                    <form class="footer-newsletter" id="footerSubscribeForm" action="{{route('front.subscribe')}}" method="post">
                      @csrf
                      <p>{{convertUtf8($bs->newsletter_text)}}</p>
                      <input type="email" name="email" value="" placeholder="{{__('Enter Email Address')}}" />
                      <p id="erremail" class="text-danger mb-0 err-email"></p>
                      <button type="submit">{{__('Subscribe')}}</button>
                    </form>
                 </div>
                 <div class="col-lg-3 col-md-5">
                    <h4>{{__('Contact Us')}}</h4 >
                    <div class="footer-contact-info">
                       <ul>
                          <li><i class="fa fa-home"></i><span>{{convertUtf8($bs->contact_address)}}</span>
                          </li>
                          <li><i class="fa fa-phone"></i><span>{{convertUtf8($bs->contact_number)}}</span></li>
                          <li><i class="far fa-envelope"></i><span>{{convertUtf8($bs->contact_mail)}}</span></li>
                       </ul>
                    </div>
                 </div>
              </div>
           </div>
           @endif
           @if ($bs->copyright_section == 1)
           <div class="copyright-section">
              <div class="row">
                 <div class="col-sm-12 text-center">
                    {!! replaceBaseUrl(convertUtf8($bs->copyright_text)) !!}
                 </div>
              </div>
           </div>
           @endif
        </div>
     </footer>
     <!--    footer section end   -->


    <!-- preloader section start -->
    <div class="loader-container">
        <span class="loader">
            <span class="loader-inner"></span>
        </span>
    </div>
    <!-- preloader section end -->


    <!-- back to top area start -->
    <div class="back-to-top">
        <i class="fas fa-chevron-up"></i>
    </div>
    <!-- back to top area end -->


    {{-- Loader --}}
    <div class="request-loader">
        <img src="{{asset('assets/admin/img/loader.gif')}}" alt="">
    </div>
    {{-- Loader --}}

      <!-- popper js -->
      <script src="{{asset('assets/user/js/popper.min.js')}}"></script>
      <!-- bootstrap js -->
      <script src="{{asset('assets/user/js/bootstrap.min.js')}}"></script>
      <!-- owl carousel js -->
      <script src="{{asset('assets/user/js/owl.carousel.min.js')}}"></script>

      <!-- slicknav js -->
      <script src="{{asset('assets/user/js/jquery.slicknav.min.js')}}"></script>
      <!-- slick js -->
      <script src="{{asset('assets/user/js/slick.min.js')}}"></script>
      <!-- isotope js -->
      <script src="{{asset('assets/user/js/isotope.pkgd.min.js')}}"></script>

      <!-- magnific popup js -->
      <script src="{{asset('assets/user/js/jquery.magnific-popup.min.js')}}"></script>
      <!-- nice select js -->
      <script src="{{asset('assets/user/js/datatables.min.js')}}"></script>
      <script src="{{asset('assets/user/js/dataTables.bootstrap4.js')}}"></script>
      <script src="{{asset('assets/user/js/toastr.min.js')}}"></script>
      <!-- Summernote JS -->
      <script src="{{asset('assets/admin/js/plugin/summernote/summernote-bs4.js')}}"></script>

      <!-- main js -->
      <script src="{{asset('assets/user/js/main.js')}}"></script>

      <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      </script>

      <script>
          var imgupload = "{{route('user.summernote.upload')}}";
      </script>
      <!-- main js -->
      <script src="{{asset('assets/user/js/custom.js')}}"></script>

      @yield('scripts')

      @if (session()->has('success'))
      <script>
         toastr["success"]("{{__(session()->get('success'))}}");
      </script>
      @endif

      @if (Session::has('error'))
      <script>
         toastr["error"]("{{__(session('error'))}}");
      </script>
      @endif


        <script>
            $(document).ready(function() {
                $('#example').DataTable({
                    responsive: true
                });
            });
        </script>



</body>

</html>
