        <!-- Start lawyer_banner section -->
        <section class="lawyer_banner banner_v1">
            <div class="hero_slide_v1">
                <div class="single_slider bg_image" data-parallax="scroll" data-speed="0.2" data-image-src="{{asset('assets/front/img/'.$bs->hero_bg)}}">
                    <div class="bg_overlay" style="background-color: #{{$be->hero_overlay_color}};opacity: {{$be->hero_overlay_opacity}};"></div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="banner_content">
                                    <span style="font-size: {{$be->hero_section_title_font_size}}px" data-animation="fadeInUp" data-delay=".3s">{{convertUtf8($bs->hero_section_title)}}</span>
                                    <h1 data-animation="fadeInUp" data-delay=".3s" style="font-size: {{$be->hero_section_text_font_size}}px">{{convertUtf8($bs->hero_section_text)}}</h1>
                                    @if (!empty($bs->hero_section_button_url) && !empty($bs->hero_section_button_text))
                                        <a href="{{$bs->hero_section_button_url}}" class="lawyer_btn" data-animation="fadeInUp" data-delay=".3s" style="font-size: {{$be->hero_section_button_text_font_size}}px">{{convertUtf8($bs->hero_section_button_text)}}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="scroll_down">
                        <a href="#about_v1" class="page_scroll">{{__('Scroll Down')}} <span class="line"></span></a>
                    </div>
                    <div class="line_info_box">
                        <a href="mailto:{{$bs->support_email}}">{{$bs->support_email}}</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- End lawyer_banner section -->
