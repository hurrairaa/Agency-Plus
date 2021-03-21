    @php
        $links = json_decode($menus, true);
        //  dd($links);
    @endphp

    <!-- HEADER START -->
    <header class="@yield('no-breadcrumb')">
        <section class="top-header-area">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="top-header-address">
                            <span><i class="fas fa-headphones-alt"></i> {{$bs->support_phone}}</span>
                            <span><i class="fas fa-envelope-open-text"></i> {{$bs->support_email}}</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="top_right d-flex">
                            @if (!empty($currentLang))
                                <ul class="top-header-language">
                                    <li><a href="#"><i class="fas fa-globe"></i>{{convertUtf8($currentLang->name)}} <i class="fa fa-angle-down"></i></a>
                                        <ul class="language-dropdown">
                                            @foreach ($langs as $key => $lang)
                                                <li><a href='{{ route('changeLanguage', $lang->code) }}'>{{convertUtf8($lang->name)}}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            @endif
                            <div class="top-header-social-links">
                                <ul>
                                    @foreach ($socials as $key => $social)
                                        <li><a href="{{$social->url}}"><i class="{{$social->icon}}"></i></a></li>
                                    @endforeach
                                </ul>
                            </div>

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
            </div>
        </section>
        <section class="bottom-header-area">
            <div class="container-fluid">
                <div class="row align-items-center position-relative">
                    <div class="col-lg-2">
                        <div class="logo">
                            <a href="{{route('front.index')}}"><img src="{{asset('assets/front/img/'.$bs->logo)}}" class="img-fluid" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="header-menu-area">
                            <div class="primary_menu">
                                <nav class="main-menu {{$bs->is_quote == 0 ? 'mr-0' : ''}}">
                                    @php
                                        $links = json_decode($menus, true);
                                        //  dd($links);
                                    @endphp
                                    <ul>

                                        @foreach ($links as $link)
                                            @php
                                                $href = getHref($link);
                                            @endphp

                                            {{-- if the theme version has service category, then show megamenu --}}
                                            @if ($link["type"] == 'services' && hasCategory($be->theme_version))

                                                <li class="menu-item menu-item-has-children static"><a href="{{$href}}">{{$link["text"]}}</a>
                                                    <ul class="mega-menu">
                                                        <div class="row">
                                                            @if (count($scats) > 0)
                                                                @foreach ($scats as $key => $scat)
                                                                    <div class="col-lg-3">
                                                                        <li class="mega-item">
                                                                            <a>{{$scat->name}}</a>
                                                                            <ul>
                                                                                @foreach ($scat->services()->orderBy('serial_number', 'ASC')->get() as $key => $service)

                                                                                    <li><a href="{{route('front.servicedetails', [$service->slug, $service->id])}}">{{$service->title}}</a></li>

                                                                                @endforeach
                                                                            </ul>
                                                                        </li>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </ul>
                                                </li>


                                            @else

                                                @if (!array_key_exists("children",$link))
                                                    {{--- Level1 links which doesn't have dropdown menus ---}}
                                                    <li><a href="{{$href}}" target="{{$link["target"]}}">{{$link["text"]}}</a></li>

                                                @else
                                                    <li class="menu-item-has-children">
                                                        {{--- Level1 links which has dropdown menus ---}}
                                                        <a href="{{$href}}" target="{{$link["target"]}}">{{$link["text"]}}</a>

                                                        <ul class="sub-menu">



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
                                    </ul>
                                </nav>
                            </div>

                            @if ($bs->is_quote == 1)
                                <a href="{{route('front.quote')}}" class="main-btn header-bgn">{{__('Get Quote')}}</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12 position-static"><div class="mobile_menu"></div></div>
                </div>
            </div>
        </section>
    </header>
    <!-- HEADER END -->
