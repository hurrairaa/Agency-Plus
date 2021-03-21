<div class="hero-area" data-parallax="scroll" data-speed="0.2" data-image-src="{{asset('assets/front/img/'.$bs->hero_bg)}}">
   <div class="container">
      <div class="hero-txt">
         <div class="row">
           <div class="col-12">
              <span>{{convertUtf8($bs->hero_section_title)}}</span>
              <h1>{{convertUtf8($bs->hero_section_text)}}</h1>
              @if (!empty($bs->hero_section_button_url) && !empty($bs->hero_section_button_text))
              <a href="{{$bs->hero_section_button_url}}" class="hero-boxed-btn" target="_blank">{{convertUtf8($bs->hero_section_button_text)}}</a>
              @endif
           </div>
         </div>
      </div>
   </div>
   <div class="hero-area-overlay" style="background-color: #{{$be->hero_overlay_color}};opacity: {{$be->hero_overlay_opacity}};"></div>
</div>
