<!DOCTYPE html>
<html lang="en">
   <head>
      <!--Start of Google Analytics script-->
      @if ($bs->is_analytics == 1)
      {!! $bs->google_analytics_script !!}
      @endif
      <!--End of Google Analytics script-->

      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <meta name="description" content="@yield('meta-description')">
      <meta name="keywords" content="@yield('meta-keywords')">

      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{$bs->website_title}} @yield('pagename')</title>
      <!-- favicon -->
      <link rel="shortcut icon" href="{{asset('assets/front/img/'.$bs->favicon)}}" type="image/x-icon">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="{{asset('assets/front/css/bootstrap.min.css')}}">
      <!-- plugin css -->
      <link rel="stylesheet" href="{{asset('assets/front/css/plugin.min.css')}}">

      @yield('styles')
      <!-- main css -->
      <link rel="stylesheet" href="{{asset('assets/front/css/style.css')}}">

      @if ($bs->is_tawkto == 1)
      <style>
      .back-to-top {
          bottom: 50px;
      }
      .back-to-top.show {
          right: 20px;
      }
      </style>
      @endif
      @if (count($langs) == 0)
      <style media="screen">
      .support-bar-area ul.social-links li:last-child {
          margin-right: 0px;
      }
      .support-bar-area ul.social-links::after {
          display: none;
      }
      </style>
      @endif
      @if($bs->feature_section == 0)
      <style media="screen">
      .hero-txt {
          padding-bottom: 160px;
      }
      </style>
      @endif

      <!-- responsive css -->
      <link rel="stylesheet" href="{{asset('assets/front/css/responsive.css')}}">
      <!-- base color change -->
      <link href="{{url('/')}}/assets/front/css/base-color.php?color={{$bs->base_color}}{{!isDark($be->theme_version) ? "&color1=" . $bs->secondary_base_color : ""}}" rel="stylesheet">

      @if (isDark($be->theme_version))
        <!-- dark version css -->
        <link rel="stylesheet" href="{{asset('assets/front/css/dark.css')}}">
        <!-- dark version base color change -->
        <link href="{{url('/')}}/assets/front/css/dark-base-color.php?color={{$bs->base_color}}" rel="stylesheet">
      @endif

      @if ($rtl == 1)
      <!-- RTL css -->
      <link rel="stylesheet" href="{{asset('assets/front/css/rtl.css')}}">
      @endif
      <!-- jquery js -->
      <script src="{{asset('assets/front/js/jquery-3.3.1.min.js')}}"></script>

      @if ($bs->is_appzi == 1)
      <!-- Start of Appzi Feedback Script -->
      <script async src="https://app.appzi.io/bootstrap/bundle.js?token={{$bs->appzi_token}}"></script>
      <!-- End of Appzi Feedback Script -->
      @endif

      <!-- Start of Facebook Pixel Code -->
      @if ($be->is_facebook_pexel == 1)
        {!! $be->facebook_pexel_script !!}
      @endif
      <!-- End of Facebook Pixel Code -->

      <!--Start of Appzi script-->
      @if ($bs->is_appzi == 1)
      {!! $bs->appzi_script !!}
      @endif
      <!--End of Appzi script-->
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

                     @guest
                     <ul class="login">
                         <li><a href="{{route('user.login')}}">{{__('Login')}}</a></li>
                     </ul>
                     @endguest
                     @auth
                     <ul class="login">
                         <li><a href="{{route('user-dashboard')}}">{{__('Dashboard')}}</a></li>
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


      <!--    announcement banner section start   -->
      <a class="announcement-banner" href="{{asset('assets/front/img/'.$bs->announcement)}}"></a>
      <!--    announcement banner section end   -->


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
                     <p class="footer-txt">
                        @if (strlen(convertUtf8($bs->footer_text)) > 194)
                           {{substr(convertUtf8($bs->footer_text), 0, 194)}}<span style="display: none;">{{substr(convertUtf8($bs->footer_text), 194)}}</span>
                           <a href="#" class="see-more">see more...</a>
                        @else
                           {{convertUtf8($bs->footer_text)}}
                        @endif
                    </p>
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


      {{-- Cookie alert dialog start --}}
      @if ($be->cookie_alert_status == 1)
      @include('cookieConsent::index')
      @endif
      {{-- Cookie alert dialog end --}}

      @php
        $mainbs = [];
        $mainbs['is_announcement'] = $bs->is_announcement;
        $mainbs['announcement_delay'] = $bs->announcement_delay;
        $mainbs = json_encode($mainbs);
      @endphp
      <script>
        var lat = {{$bs->latitude}};
        var lng = {{$bs->longitude}};
        var mainbs = {!! $mainbs !!};

        var rtl = {{ $rtl }};
      </script>
      <!-- popper js -->
      <script src="{{asset('assets/front/js/popper.min.js')}}"></script>
      <!-- bootstrap js -->
      <script src="{{asset('assets/front/js/bootstrap.min.js')}}"></script>
      <!-- Plugin js -->
      <script src="{{asset('assets/front/js/plugin.min.js')}}"></script>
      @if (request()->path() == 'contact')
      <!-- google map api -->
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7eALQrRUekFNQX71IBNkxUXcz-ALS-MY&callback=initMap" async defer></script>
      <!-- google map activate js -->
      <script src="{{asset('assets/front/js/google-map-activate.min.js')}}"></script>
      @endif
      <!-- main js -->
      <script src="{{asset('assets/front/js/main.js')}}"></script>

      @yield('scripts')

      @if (session()->has('success'))
      <script>
         toastr["success"]("{{__(session('success'))}}");
      </script>
      @endif

      @if (session()->has('error'))
      <script>
         toastr["error"]("{{__(session('error'))}}");
      </script>
      @endif

      <!--Start of subscribe functionality-->
      <script>
        $(document).ready(function() {
          $("#subscribeForm, #footerSubscribeForm").on('submit', function(e) {
            // console.log($(this).attr('id'));

            e.preventDefault();

            let formId = $(this).attr('id');
            let fd = new FormData(document.getElementById(formId));
            let $this = $(this);

            $.ajax({
              url: $(this).attr('action'),
              type: $(this).attr('method'),
              data: fd,
              contentType: false,
              processData: false,
              success: function(data) {
                // console.log(data);
                if ((data.errors)) {
                  $this.find(".err-email").html(data.errors.email[0]);
                } else {
                  toastr["success"]("You are subscribed successfully!");
                  $this.trigger('reset');
                  $this.find(".err-email").html('');
                }
              }
            });
          });
        });
      </script>
      <!--End of subscribe functionality-->

      <!--Start of Tawk.to script-->
      @if ($bs->is_tawkto == 1)
      {!! $bs->tawk_to_script !!}
      @endif
      <!--End of Tawk.to script-->

      <!--Start of AddThis script-->
      @if ($bs->is_addthis == 1)
      {!! $bs->addthis_script !!}
      @endif
      <!--End of AddThis script-->
   </body>
</html>
