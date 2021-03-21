@extends('front.cleaning.layout')

@section('meta-keywords', "$be->home_meta_keywords")
@section('meta-description', "$be->home_meta_description")


@section('content')
    <!--   hero area start   -->
    @if ($bs->home_version == 'static')
        @includeif('front.cleaning.partials.static')
    @elseif ($bs->home_version == 'slider')
        @includeif('front.cleaning.partials.slider')
    @elseif ($bs->home_version == 'video')
        @includeif('front.cleaning.partials.video')
    @elseif ($bs->home_version == 'particles')
        @includeif('front.cleaning.partials.particles')
    @elseif ($bs->home_version == 'water')
        @includeif('front.cleaning.partials.water')
    @elseif ($bs->home_version == 'parallax')
        @includeif('front.cleaning.partials.parallax')
    @endif
    <!--   hero area end    -->



    <!-- CATAGORIES PART START -->
    @if ($bs->feature_section == 1)
    <section class="catagories-area pt-100 pb-100">
        <div class="container">
            <div class="catagories-carousel-active">
                <div class="row">
                    @foreach ($features as $key => $feature)
                        <div class="col-lg-3 col-md-6">
                            <div class="single-catagories-item text-center">
                                <span style="background: #{{$feature->color}}2a;"><i style="color: #{{$feature->color}};" class="{{$feature->icon}}"></i></span>
                                <h4>{{convertUtf8($feature->title)}}</h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- CATAGORIES PART END -->

    <!-- SERVICE PART START -->
    @if ($bs->service_section == 1)
    <section class="service-area pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title-one text-center">
                        <span>{{convertUtf8($bs->service_section_title)}}</span>
                        <h1>{{convertUtf8($bs->service_section_subtitle)}}</h1>
                    </div>
                </div>
            </div>
            <div class="service-carousel-active service-slick">
                @if (hasCategory($be->theme_version))
                    @foreach ($scategories as $key => $scat)
                        <div class="single-service-item">
                            @if (!empty($scat->image))
                                <div class="single-service-bg">
                                    <img src="{{asset('assets/front/img/service_category_icons/'.$scat->image)}}" class="img-fluid" alt="">
                                    <span><i class="fas fa-quidditch"></i></span>
                                    <div class="single-service-link">
                                        <a href="{{route('front.services', ['category'=>$scat->id])}}" class="main-btn service-btn">{{__('View Services')}}</a>
                                    </div>
                                </div>
                                <div class="single-service-content">
                                    <h4>{{convertUtf8($scat->name)}}</h4>
                                    <p>
                                        @if (strlen(convertUtf8($scat->short_text)) > 100)
                                           {{substr(convertUtf8($scat->short_text), 0, 100)}}<span style="display: none;">{{substr(convertUtf8($scat->short_text), 100)}}</span>
                                           <a href="#" class="see-more">see more...</a>
                                        @else
                                           {{convertUtf8($scat->short_text)}}
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @elseif (!hasCategory($be->theme_version))
                    @foreach ($services as $key => $service)
                        <div class="single-service-item">
                            @if (!empty($service->main_image))
                                <div class="single-service-bg">
                                    <img src="{{asset('assets/front/img/services/' . $service->main_image)}}" alt="">
                                    <span><i class="fas fa-quidditch"></i></span>
                                    @if($service->details_page_status == 1)
                                        <div class="single-service-link">
                                            <a href="{{route('front.servicedetails', [$service->slug, $service->id])}}" class="main-btn service-btn">{{__('View More')}}</a>
                                        </div>
                                    @endif
                                </div>
                                <div class="single-service-content">
                                    <h4>{{convertUtf8($service->title)}}</h4>
                                    <p>
                                        @if (strlen(convertUtf8($service->summary)) > 100)
                                           {{substr(convertUtf8($service->summary), 0, 100)}}<span style="display: none;">{{substr(convertUtf8($service->summary), 100)}}</span>
                                           <a href="#" class="see-more">see more...</a>
                                        @else
                                           {{convertUtf8($service->summary)}}
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>
    @endif
    <!-- SERVICE PART END -->

    <!-- ABOUT PART START -->
    @if ($bs->approach_section == 1)
    <section class="about-area pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title-two">
                        <span>{{convertUtf8($bs->approach_title)}}</span>
                        <h1>{{convertUtf8($bs->approach_subtitle)}}</h1>
                    </div>
                    @if (!empty($bs->approach_button_url) && !empty($bs->approach_button_text))
                        <div class="button_box">
                            <a href="{{$bs->approach_button_url}}" class="main-btn about-btn">{{convertUtf8($bs->approach_button_text)}}</a>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6">
                    @foreach ($points as $key => $point)
                        <div class="single-about-item">
                            <p  class="bg-1" style="color: #{{$point->color}}; background: #{{$point->color}}2a;"><span><i class="{{$point->icon}}"></i></span></p>
                            <h4>{{convertUtf8($point->title)}}
                                <span>
                                    @if (strlen(convertUtf8($point->short_text)) > 150)
                                        {{substr(convertUtf8($point->short_text), 0, 150)}}<span style="display: none;">{{substr(convertUtf8($point->short_text), 150)}}</span>
                                        <a href="#" class="see-more">see more...</a>
                                    @else
                                        {{convertUtf8($point->short_text)}}
                                    @endif
                                </span>
                            </h4>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- ABOUT PART END -->

    <!-- PROJECT COUNTER PART START -->
    @if ($bs->statistics_section == 1)
    <section class="project-counter-area" style="background-image: url('{{asset('assets/front/img/'.$be->statistics_bg)}}'); background-size:cover; @if($bs->home_version == 'parallax') background-attachment: fixed; @endif">
        <div class="project-counter-overlay" style="background: #{{$be->statistics_overlay_color}}; opacity: {{$be->statistics_overlay_opacity}};"></div>
        <div class="container">
            <div class="row">
                @foreach ($statistics as $key => $statistic)
                    <div class="col-lg-3 col-md-6">
                        <div class="single-counter-item">
                            <span><i class="{{$statistic->icon}}"></i></span>
                            <h1><span class="count">{{convertUtf8($statistic->quantity)}}</span>   +</h1>
                            <p>{{convertUtf8($statistic->title)}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <!-- PROJECT COUNTER PART END -->

    <!-- PROJECT VIDEO PART START -->
    @if ($bs->intro_section == 1)
    <section class="project-video-area pt-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title-one text-center">
                        <span>{{convertUtf8($bs->intro_section_title)}}</span>
                        <h1>{{convertUtf8($bs->intro_section_text)}}</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="video-content" style="background-image: url('{{asset('assets/front/img/'.$bs->intro_bg)}}');background-size:cover;">
                        <div class="video-content-overlay" style="background: #{{$be->intro_overlay_color}}; opacity: {{$be->intro_overlay_opacity}};"></div>
                        <a href="{{$bs->intro_section_video_link}}" class="play-btn video-popup"><i class="fa fa-play"></i></a>
                    </div>
                    @if (!empty($bs->intro_section_button_url) && !empty($bs->intro_section_button_text))
                        <div class="video-btn-area">
                            <a href="{{$bs->intro_section_button_url}}" class="main-btn video-btn" target="_blank">{{convertUtf8($bs->intro_section_button_text)}}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- PROJECT VIDEO PART END -->

    <!-- TESTIMONIAL PART START -->
    @if ($bs->testimonial_section == 1)
    <section class="testimonial-area pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title-one text-center">
                        <span>{{convertUtf8($bs->testimonial_title)}}</span>
                        <h1>{{convertUtf8($bs->testimonial_subtitle)}}</h1>
                    </div>
                </div>
            </div>
            <div class="testimonial-active">
                @foreach ($testimonials as $key => $testimonial)
                    <div class="single-testimonial-item">
                        <div class="testimonial-author-img">
                            <img src="{{asset('assets/front/img/testimonials/'.$testimonial->image)}}" class="img-fluid" alt="">
                        </div>
                        <div class="testimonial-author-details">
                            <h4>{{convertUtf8($testimonial->name)}} <span>{{convertUtf8($testimonial->rank)}}</span></h4>
                            <p>{{convertUtf8($testimonial->comment)}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <!-- TESTIMONIAL PART END -->

    <!-- PROJECT PART START -->
    @if ($bs->portfolio_section == 1)
    <section class="project-area pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="section-title-two">
                        <span>{{convertUtf8($bs->portfolio_section_title)}}</span>
                        <h1>{{convertUtf8($bs->portfolio_section_text)}}</h1>
                    </div>
                </div>
                <div class="col-lg-4 text-right">
                    <a href="{{route('front.portfolios')}}" class="project-btn">{{__('View More')}} <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="project-slider-active project-slick">
                @foreach ($portfolios as $key => $portfolio)
                    <div class="single-project-item">
                        <img src="{{asset('assets/front/img/portfolios/featured/'.$portfolio->featured_image)}}" alt="">
                        <div class="project-link text-center">
                            <h4>{{convertUtf8(strlen($portfolio->title)) > 36 ? convertUtf8(substr($portfolio->title, 0, 36)) . '...' : convertUtf8($portfolio->title)}}</h4>
                            @if (!empty($portfolio->service))
                                <span>{{convertUtf8($portfolio->service->title)}}</span>
                            @endif
                            <a href="{{route('front.portfoliodetails', [$portfolio->slug, $portfolio->id])}}" class="main-btn project-link-btn">{{__('View Details')}}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <!-- PROJECT PART END -->

    <!-- TEAM PART START -->
    @if ($bs->team_section == 1)
    <section class="team-area pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title-one text-center">
                        <span>{{convertUtf8($bs->team_section_title)}}</span>
                        <h1>{{convertUtf8($bs->team_section_subtitle)}}</h1>
                    </div>
                </div>
            </div>
            <div class="team-carousel-active team-slick">
                @foreach ($members as $key => $member)
                    <div class="single-team-item">
                        <img src="{{asset('assets/front/img/members/'.$member->image)}}" alt="">
                        <div class="single-team-content">
                            <div class="single-team-member-details">
                                <h4>{{convertUtf8($member->name)}}</h4>
                                <p>{{convertUtf8($member->rank)}}</p>
                            </div>
                            <ul class="team-social-links">
                                @if (!empty($member->facebook))
                                    <li><a href="{{$member->facebook}}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                @endif
                                @if (!empty($member->twitter))
                                    <li><a href="{{$member->twitter}}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                @endif
                                @if (!empty($member->linkedin))
                                    <li><a href="{{$member->linkedin}}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                @endif
                                @if (!empty($member->instagram))
                                    <li><a href="{{$member->instagram}}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <!-- TEAM PART END -->

    <!-- CTA PART START -->
    @if ($bs->call_to_action_section == 1)
    <section class="cta-area" style="background-image: url('{{asset('assets/front/img/'.$bs->cta_bg)}}'); background-size:cover; @if($bs->home_version == 'parallax') background-attachment: fixed; @endif">
        <div class="cta-overlay" style="background: #{{$be->cta_overlay_color}}; opacity: {{$be->cta_overlay_opacity}};"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1>{{convertUtf8($bs->cta_section_text)}}</h1>
                </div>
                <div class="col-lg-4 text-center">
                    <a href="{{$bs->cta_section_button_url}}" class="main-btn cta-btn">{{convertUtf8($bs->cta_section_button_text)}}</a>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- CTA PART END -->

    <!-- PRICING PART START -->
    @if ($be->pricing_section == 1)
    <section class="price-area pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title-one text-center">
                        <span>{{convertUtf8($be->pricing_title)}}</span>
                        <h1>{{convertUtf8($be->pricing_subtitle)}}</h1>
                    </div>
                </div>
            </div>
            <div class="price-carousel-active pricing-slick">
                @foreach ($packages as $key => $package)
                    <div class="single-price-item text-center">
                        <div class="price-heading">
                            <h3>{{convertUtf8($package->title)}}</h3>
                            <span>{{__('Featured Package')}}</span>
                        </div>
                        <h1 class="bg-1" style="background: #{{$package->color}};">{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$package->price}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</h1>
                        <div class="price-cata mb-4">
                            {!! replaceBaseUrl(convertUtf8($package->description)) !!}
                        </div>
                        @if ($package->order_status == 1)
                            <a href="{{route('front.packageorder.index', $package->id)}}" class="main-btn price-btn">{{__('Place Order')}}</a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <!-- PRICING PART END -->


    <!-- BLOG PART START -->
    @if ($bs->news_section == 1)
    <section class="blog-area pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="section-title-two">
                        <span>{{convertUtf8($bs->blog_section_title)}}</span>
                        <h1>{{convertUtf8($bs->blog_section_subtitle)}}</h1>
                    </div>
                </div>
                <div class="col-lg-5 text-right">
                    <a href="{{route('front.blogs')}}" class="blog-link">{{__('View More')}} <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="blog-carousel-active blog-slick">
                @foreach ($blogs as $key => $blog)

                    <div class="single-blog-item">
                        <div class="single-blog-img">
                            <img src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}" alt="">
                        </div>
                        <div class="single-blog-details">
                            @php
                                $blogDate = \Carbon\Carbon::parse($blog->created_at)->locale("$currentLang->code");
                                $blogDate = $blogDate->translatedFormat('d M. Y');
                            @endphp
                            <span><i class="fa fa-arrow-right"></i>{{__('By')}} {{__('Admin')}}</span>
                            <span><i class="fa fa-arrow-right"></i>{{$blogDate}}</span>
                            <h4>{{convertUtf8(strlen($blog->title)) > 40 ? convertUtf8(substr($blog->title, 0, 40)) . '...' : convertUtf8($blog->title)}}</h4>
                            <p>{!! convertUtf8(strlen(strip_tags($blog->content)) > 100) ? convertUtf8(substr(strip_tags($blog->content), 0, 100)) . '...' : convertUtf8(strip_tags($blog->content)) !!}</p>
                            <a href="{{route('front.blogdetails', [$blog->slug, $blog->id])}}" class="blog-btn">{{__('Read More')}} <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <!-- BLOG PART END -->


    <!-- BRAND PART START -->
    @if ($bs->partner_section == 1)
    <section class="bran-area pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="brand-container brand-carousel-active">
                        @foreach ($partners as $key => $partner)
                            <div class="single-brand-logo">
                                <a class="d-block" href="{{$partner->url}}" target="_blank"><img src="{{asset('assets/front/img/partners/'.$partner->image)}}" class="img-fluid" alt=""></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- BRAND PART END -->


@endsection
