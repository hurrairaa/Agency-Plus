		<!-- Start finlance_banner section -->
		<section class="finlance_banner banner_v1">
			<div class="hero_slide_v1">
                @php
                    $rgb = hex2rgb($be->hero_overlay_color);
                    $bgColor = "rgba(" . $rgb['red'] . "," . $rgb['green'] . "," . $rgb['blue'] . "," . $be->hero_overlay_opacity . ")";
                @endphp
				<div class="single_slider bg_image" data-parallax="scroll" data-speed="0.2" data-image-src="{{asset('assets/front/img/'.$bs->hero_bg)}}" style="background-color: {{$bgColor}};">
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<div class="banner_content text-center">
									<p data-animation="fadeInUp" data-delay=".1s" style="font-size: {{$be->hero_section_title_font_size}}px"><span>{{convertUtf8($bs->hero_section_title)}}</span></p>
									<h1 data-animation="fadeInUp" data-delay=".2s" style="font-size: {{$be->hero_section_bold_text_font_size}}px">{{convertUtf8($bs->hero_section_bold_text)}}</h1>
									<h2 data-animation="fadeInUp" data-delay=".3s" style="font-size: {{$be->hero_section_text_font_size}}px">{{convertUtf8($bs->hero_section_text)}}</h2>
                                    @if (!empty($bs->hero_section_button_url) && !empty($bs->hero_section_button_text))
									    <a href="{{$bs->hero_section_button_url}}" class="finlance_btn" data-animation="fadeInUp" data-delay=".4s" style="font-size: {{$be->hero_section_button_text_font_size}}px">{{convertUtf8($bs->hero_section_button_text)}}</a>
                                    @endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End finlance_banner section -->
