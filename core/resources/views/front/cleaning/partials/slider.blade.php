    <!-- HERO PART START -->
    <section class="hero-area">
        <div class="hero-carousel-active">
            @if (!empty($sliders))
                @foreach ($sliders as $key => $slider)
                    <div class="single-carousel-active" style="background-image: url('{{asset('assets/front/img/sliders/'.$slider->image)}}');background-size: cover;">
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-6 col-lg-8">
                                    <div class="hero-content">
                                        <span data-animation="fadeInUp" data-delay=".2s" style="font-size: {{$slider->title_font_size}}px">{{convertUtf8($slider->title)}} </span>
                                        <h1 data-animation="fadeInUp" data-delay=".3s" style="font-size: {{$slider->bold_text_font_size}}px; color: #{{$slider->bold_text_color}};">{{convertUtf8($slider->bold_text)}}</h1>
                                        @if (!empty($slider->button_url) && !empty($slider->button_text))
                                            <a href="{{$slider->button_url}}" class="main-btn hero-btn" style="font-size: {{$slider->button_text_font_size}}px" data-animation="fadeInUp" data-delay=".4s">{{convertUtf8($slider->button_text)}}</a>
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
    <!-- HERO PART END -->
