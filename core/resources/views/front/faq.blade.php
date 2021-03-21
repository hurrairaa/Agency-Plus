@extends("front.$version.layout")

@section('pagename')
 - {{__('FAQ')}}
@endsection

@section('meta-keywords', "$be->faq_meta_keywords")
@section('meta-description', "$be->faq_meta_description")

@section('content')
<!--   breadcrumb area start   -->
<div class="breadcrumb-area" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
   <div class="container">
      <div class="breadcrumb-txt">
         <div class="row">
            <div class="col-xl-7 col-lg-8 col-sm-10">
               <span>{{convertUtf8($bs->faq_title)}}</span>
               <h1>{{convertUtf8($bs->faq_subtitle)}}</h1>
               <ul class="breadcumb">
                  <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                  <li>{{__('FAQS')}}</li>
               </ul>
            </div>
         </div>
      </div>
   </div>
   <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
</div>
<!--   breadcrumb area end    -->


<!--   FAQ section start   -->
<div class="faq-section">
   <div class="container">
      <div class="row">
         <div class="col-lg-6">
            <div class="accordion" id="accordionExample1">
               @for ($i=0; $i < ceil(count($faqs)/2); $i++)
               <div class="card">
                  <div class="card-header" id="heading{{$faqs[$i]->id}}">
                     <h2 class="mb-0">
                        <button class="btn btn-link collapsed btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{$faqs[$i]->id}}" aria-expanded="false" aria-controls="collapse{{$faqs[$i]->id}}">
                        {{convertUtf8($faqs[$i]->question)}}
                        </button>
                     </h2>
                  </div>
                  <div id="collapse{{$faqs[$i]->id}}" class="collapse" aria-labelledby="heading{{$faqs[$i]->id}}" data-parent="#accordionExample1">
                     <div class="card-body">
                        {{convertUtf8($faqs[$i]->answer)}}
                     </div>
                  </div>
               </div>
               @endfor
            </div>
         </div>
         <div class="col-lg-6">
            <div class="accordion" id="accordionExample2">
               @for ($i=ceil(count($faqs)/2); $i < count($faqs); $i++)
               <div class="card">
                  <div class="card-header" id="heading{{$faqs[$i]->id}}">
                     <h2 class="mb-0">
                        <button class="btn btn-link collapsed btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{$faqs[$i]->id}}" aria-expanded="false" aria-controls="collapse{{$faqs[$i]->id}}">
                        {{convertUtf8($faqs[$i]->question)}}
                        </button>
                     </h2>
                  </div>
                  <div id="collapse{{$faqs[$i]->id}}" class="collapse" aria-labelledby="heading{{$faqs[$i]->id}}" data-parent="#accordionExample2">
                     <div class="card-body">
                        {{convertUtf8($faqs[$i]->answer)}}
                     </div>
                  </div>
               </div>
               @endfor
            </div>
         </div>
      </div>
   </div>
</div>
<!--   FAQ section end   -->
@endsection
