@extends("front.$version.layout")

@section('pagename')
 - {{convertUtf8($portfolio->title)}}
@endsection

@section('meta-keywords', "$portfolio->meta_keywords")
@section('meta-description', "$portfolio->meta_description")

@section('content')
  <!--   breadcrumb area start   -->
  <div class="breadcrumb-area" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
     <div class="container">
        <div class="breadcrumb-txt">
           <div class="row">
              <div class="col-xl-7 col-lg-8 col-sm-10">
                 <span>{{convertUtf8($bs->portfolio_details_title)}}</span>
                 <h1>{{convertUtf8($portfolio->title)}}</h1>
                 <ul class="breadcumb">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                    <li>{{__('Portfolio Details')}}</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
     <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
  </div>
  <!--   breadcrumb area end    -->


  <!--    case details section start   -->
  <div class="case-details-section">
     <div class="container">
        <div class="row">
           <div class="col-lg-7 col-xl-7">
             <div class="project-ss-carousel owl-carousel owl-theme common-carousel">
                 @foreach ($portfolio->portfolio_images as $key => $pi)
                   <a href="#" class="single-ss" data-id="{{$pi->id}}">
                      <img src="{{asset('assets/front/img/portfolios/sliders/'.$pi->image)}}" alt="">
                   </a>
                 @endforeach
              </div>
              @foreach ($portfolio->portfolio_images as $key => $pi)
                <a id="singleMagnificSs{{$pi->id}}" class="single-magnific-ss d-none" href="{{asset('assets/front/img/portfolios/sliders/'.$pi->image)}}"></a>
              @endforeach
              <div class="case-details">
                 {!! replaceBaseUrl(convertUtf8($portfolio->content)) !!}
              </div>
           </div>
           <!--    appoint section start   -->
           <div class="col-lg-5 offset-xl-1 col-xl-4">
             <div class="right-side">
                <div class="row">
                   <div class="col-xl-12 col-lg-12 col-md-12">
                      <div class="project-infos">
                          <h3>{{convertUtf8($portfolio->title)}}</h3>
                          <div class="row mb-2">
                              <div class="col-5 {{$rtl == 1 ? 'pl-0' : 'pr-0'}}"><strong>{{__('Client Name')}}</strong></div>
                              <div class="col-7"><span>:</span> {{convertUtf8($portfolio->client_name)}}</div>
                          </div>
                          <div class="row mb-2">
                              <div class="col-5 {{$rtl == 1 ? 'pl-0' : 'pr-0'}}"><strong>{{__('Service')}}</strong></div>
                              @if (!empty($portfolio->service->title))
                              <div class="col-7"><span>:</span> {{convertUtf8($portfolio->service->title)}}</div>
                              @endif
                          </div>
                            @php
                            if (!empty($currentLang)) {
                                $start = \Carbon\Carbon::parse($portfolio->start_date)->locale("$currentLang->code");
                            } else {
                                $start = \Carbon\Carbon::parse($portfolio->start_date)->locale("en");
                            }
                            $start = $start->translatedFormat('jS F, Y');
                            @endphp


                            @php
                            if (!empty($currentLang)) {
                                $submission = \Carbon\Carbon::parse($portfolio->submission_date)->locale("$currentLang->code");
                            } else {
                                $submission = \Carbon\Carbon::parse($portfolio->submission_date)->locale("en");
                            }
                            $submission = $submission->translatedFormat('jS F, Y');
                            @endphp
                          <div class="row mb-2">
                              <div class="col-5 {{$rtl == 1 ? 'pl-0' : 'pr-0'}}"><strong>{{__('Start Date')}}</strong></div>
                              <div class="col-7"><span>:</span> {{$start}}</div>
                          </div>
                          <div class="row mb-2">
                              <div class="col-5 {{$rtl == 1 ? 'pl-0' : 'pr-0'}}"><strong>{{__('End Date')}}</strong></div>
                              <div class="col-7"><span>:</span> {{$submission}}</div>
                          </div>
                          <div class="row mb-0">
                              <div class="col-5 {{$rtl == 1 ? 'pl-0' : 'pr-0'}}"><strong>{{__('Status')}}</strong></div>
                              <div class="col-7"><span>:</span> {{$portfolio->status}}</div>
                          </div>
                      </div>
                      <div class="subscribe-section">
                         <span>{{__('SUBSCRIBE')}}</span>
                         <h3>{{__('SUBSCRIBE FOR NEWSLETTER')}}</h3>
                         <form id="subscribeForm" class="subscribe-form" action="{{route('front.subscribe')}}" method="POST">
                            @csrf
                            <div class="form-element"><input name="email" type="email" placeholder="{{__('Email')}}"></div>
                            <p id="erremail" class="text-danger mb-3 err-email"></p>
                            <div class="form-element"><input type="submit" value="{{__('Subscribe')}}"></div>
                         </form>
                      </div>
                   </div>
                </div>
             </div>
           </div>
           <!--    appoint section end   -->
        </div>
     </div>
  </div>
  <!--    case details section end   -->

@endsection
