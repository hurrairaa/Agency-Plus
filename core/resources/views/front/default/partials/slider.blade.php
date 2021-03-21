<div class="hero-area hero2-carousel owl-carousel owl-theme">
  @if (!empty($sliders))
    @foreach ($sliders as $key => $slider)
      <div class="hero-bg-2" style="background-image: url('{{asset('assets/front/img/sliders/'.$slider->image)}}')">
         <div class="container">
            <div class="hero-txt">
               <div class="row">
                  <div class="col-12">
                     <span>{{convertUtf8($slider->title)}}</span>
                     <h1>{{convertUtf8($slider->text)}}</h1>
                     @if (!empty($slider->button_url) && !empty($slider->button_text))
                     <a href="{{$slider->button_url}}" class="hero-boxed-btn">{{convertUtf8($slider->button_text)}}</a>
                     @endif
                  </div>
               </div>
            </div>
         </div>
         <div class="hero-area-overlay" style="background-color: #{{$be->hero_overlay_color}};opacity: {{$be->hero_overlay_opacity}};"></div>
      </div>
    @endforeach
  @endif
</div>
