		<!-- Start lawyer_header area -->
		<header class="lawyer_header header_v1 @yield('no-breadcrumb')">
			<div class="container-fluid">
				<div class="header_navigation">
					<div class="site_menu">
						<div class="row align-items-center">
							<div class="col-lg-2 col-sm-12">
								<div class="brand">
									<a href="{{route('front.index')}}"><img src="{{asset('assets/front/img/'.$bs->logo)}}" class="img-fluid" alt=""></a>
								</div>
							</div>
							<div class="{{$bs->is_quote == 0 ? 'col-lg-10' : 'col-lg-8'}}">
                                <div class="primary_menu">
                                    <nav class="main-menu {{$bs->is_quote == 0 ? 'text-right' : ''}}">
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
							</div>
                            @if ($bs->is_quote == 1)
                                <div class="col-lg-2">
                                    <div class="button_box">
                                        <a href="{{route('front.quote')}}" class="lawyer_btn">{{__('Consultation')}}</a>
                                    </div>
                                </div>
                            @endif
							<div class="col-sm-12">
								<div class="mobile_menu"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header><!-- End lawyer_header area -->
