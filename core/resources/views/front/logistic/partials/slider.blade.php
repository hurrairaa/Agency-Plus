    <!-- Start logistics_banner section -->
    <section class="logistics_banner banner_v1">
        <div class="hero_slide_v1">
            @if (!empty($sliders))
                @foreach ($sliders as $key => $slider)
                    <div class="single_slider bg_image" style="background-image: url('{{asset('assets/front/img/sliders/'.$slider->image)}}');">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="banner_content">
                                        <span style="font-size: {{$slider->title_font_size}}px" data-animation="fadeInUp" data-delay=".3s">{{$slider->title}}</span>
                                        <h1 data-animation="fadeInUp" data-delay=".3s" style="font-size: {{$slider->text_font_size}}px">{{$slider->text}}</h1>
                                        @if (!empty($slider->button_url) && !empty($slider->button_text))
                                            <a href="{{$slider->button_url}}" class="logistics_btn" data-animation="fadeInUp" data-delay=".3s" style="font-size: {{$slider->button_text_font_size}}px">{{$slider->button_text}}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>
    <!-- End logistics_banner section -->
