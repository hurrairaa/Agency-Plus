		<!-- Start finlance_banner section -->
		<section class="finlance_banner banner_v1">
			<div class="hero_slide_v1">
                @if (!empty($sliders))
                    @foreach ($sliders as $key => $slider)
                        @php
                            $heroOc = empty($be->hero_overlay_color) ? '0A0137' : $be->hero_overlay_color;
                            $rgb = hex2rgb($heroOc);
                            $bgColor = "rgba(" . $rgb['red'] . "," . $rgb['green'] . "," . $rgb['blue'] . "," . $be->hero_overlay_opacity . ")";
                        @endphp
                        <div class="single_slider bg_image" style="background-image: url('{{asset('assets/front/img/sliders/'.$slider->image)}}');background-color: {{$bgColor}};">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="banner_content text-center">
                                            <p data-animation="fadeInUp" data-delay=".1s" style="font-size: {{$slider->title_font_size}}px"><span>{{$slider->title}}</span></p>
                                            <h1 data-animation="fadeInUp" data-delay=".2s" style="font-size: {{$slider->bold_text_font_size}}px">{{$slider->bold_text}}</h1>
                                            <h2 data-animation="fadeInUp" data-delay=".3s" style="font-size: {{$slider->text_font_size}}px">{{$slider->text}}</h2>
                                            @if (!empty($slider->button_url) && !empty($slider->button_text))
                                                <a href="{{$slider->button_url}}" class="finlance_btn" data-animation="fadeInUp" data-delay=".4s" style="font-size: {{$slider->button_text_font_size}}px">{{$slider->button_text}}</a>
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
		<!-- End finlance_banner section -->
