@php
    $links = json_decode($menus, true);
    //  dd($links);
@endphp

<div class="header-navbar">
    <div class="row">
       <div class="col-lg-2 col-6">
          <div class="logo-wrapper">
             <a href="{{route('front.index')}}"><img src="{{asset('assets/front/img/'.$bs->logo)}}" alt=""></a>
          </div>
       </div>
       <div class="col-lg-10 col-6 {{$rtl == 1 ? 'text-left' : 'text-right'}} position-static">
          <ul class="main-menu" id="mainMenu">
             @foreach ($links as $link)
                 @php
                     $href = getHref($link);
                 @endphp


                 @if ($link["type"] == 'services' && hasCategory($be->theme_version))


                     <li class="dropdown mega @if(request()->is('service/*')) active @endif">
                         <a class="dropdown-btn" href="{{$href}}">{{$link["text"]}}</a>
                         <ul class="dropdown-lists">
                             @if (count($scats) > 0)
                                 @foreach ($scats as $key => $scat)
                                     <h5 class="service-title">{{$scat->name}}</h5>
                                     @foreach ($scat->services()->orderBy('serial_number', 'ASC')->get() as $key => $service)

                                         <li><a href="{{route('front.servicedetails', [$service->slug, $service->id])}}">{{$service->title}}</a></li>

                                     @endforeach
                                 @endforeach
                             @endif
                         </ul>
                     </li>
                     <li class="mega-dropdown">
                         <a class="dropbtn @if(request()->is('service/*') || request()->path() == 'services') active @endif" href="{{$href}}">{{$link["text"]}} <i class="fas fa-angle-down"></i></a>
                         <div class="mega-dropdown-content">
                             <div class="row">
                                 @if (count($scats) > 0)
                                     @foreach ($scats as $key => $scat)
                                         <div class="col-lg-3">
                                             <div class="service-category">
                                                 <h3>{{$scat->name}}</h3>
                                                 @foreach ($scat->services()->orderBy('serial_number', 'ASC')->get() as $key => $service)

                                                     <a class="@if(Request::route('slug') == $service->slug) active @endif" href="{{route('front.servicedetails', [$service->slug, $service->id])}}">{{$service->title}}</a>

                                                 @endforeach
                                             </div>
                                         </div>
                                     @endforeach
                                 @endif
                             </div>
                         </div>
                     </li>



                 {{-- if the link is not services OR theme version doesn't have service category --}}
                 @else
                     @if (!array_key_exists("children",$link))

                         {{--- Level1 links which doesn't have dropdown menus ---}}
                         <li><a href="{{$href}}" target="{{$link["target"]}}">{{$link["text"]}}</a></li>

                     @else
                         <li class="dropdown">
                             {{--- Level1 links which has dropdown menus ---}}
                             <a class="dropdown-btn" href="{{$href}}" target="{{$link["target"]}}">{{$link["text"]}}</a>

                             <ul class="dropdown-lists">
                                 {{-- START: 2nd level links --}}
                                 @foreach ($link["children"] as $level2)
                                     @php
                                         $l2Href = getHref($level2);
                                     @endphp

                                     <li @if(array_key_exists("children", $level2)) class="submenus" @endif>
                                         <a  href="{{$l2Href}}" target="{{$level2["target"]}}">{{$level2["text"]}}</a>

                                         {{-- START: 3rd Level links --}}
                                         @php
                                             if (array_key_exists("children", $level2)) {
                                                 create_menu($level2);
                                             }
                                         @endphp
                                         {{-- END: 3rd Level links --}}

                                     </li>
                                 @endforeach
                                 {{-- END: 2nd level links --}}
                             </ul>

                         </li>
                     @endif
                 @endif

             @endforeach

             @if ($bs->is_quote == 1)
             <li><a href="{{route('front.quote')}}" class="boxed-btn">{{__('Request A Quote')}}</a></li>
             @endif
          </ul>
          <div id="mobileMenu"></div>
       </div>
    </div>
 </div>

