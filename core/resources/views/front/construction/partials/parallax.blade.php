    <!-- Start finlance_banner section -->
    <section class="finlance_banner banner_v1">
        <div class="hero_slide_v1">
            <div class="single_slider bg_image" data-parallax="scroll" data-speed="0.2" data-image-src="{{asset('assets/front/img/'.$bs->hero_bg)}}">
                <div class="bg_overlay" style="background-color: #{{$be->hero_overlay_color}};opacity: {{$be->hero_overlay_opacity}};"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="banner_content text-center">
                                <span style="font-size: {{$be->hero_section_title_font_size}}px" data-animation="fadeInUp" data-delay=".3s">{{convertUtf8($bs->hero_section_title)}}</span>
                                <h1 data-animation="fadeInUp" data-delay=".3s" style="font-size: {{$be->hero_section_text_font_size}}px">{{convertUtf8($bs->hero_section_text)}}</h1>
                                @if (!empty($bs->hero_section_button_url) && !empty($bs->hero_section_button_text))
                                    <a href="{{$bs->hero_section_button_url}}" class="finlance_btn" data-animation="fadeInUp" data-delay=".3s" style="font-size: {{$be->hero_section_button_text_font_size}}px">{{convertUtf8($bs->hero_section_button_text)}}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End finlance_banner section -->
