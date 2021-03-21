@extends('front.default.layout')

@section('pagename')
 -
 @if (empty($category))
 {{__('All')}}
 @else
 {{convertUtf8($category->name)}}
 @endif
 {{__('Portfolios')}}
@endsection

@section('meta-keywords', "$be->portfolios_meta_keywords")
@section('meta-description', "$be->portfolios_meta_description")

@section('content')
  <!--   breadcrumb area start   -->
  <div class="breadcrumb-area cases" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
     <div class="container">
        <div class="breadcrumb-txt">
           <div class="row">
              <div class="col-xl-7 col-lg-8 col-sm-10">
                 <span>{{convertUtf8($bs->portfolio_title)}}</span>
                 <h1>{{convertUtf8($bs->portfolio_subtitle)}}</h1>
                 <ul class="breadcumb">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                    <li>{{__('Portfolios')}}</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
     <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
  </div>
  <!--   breadcrumb area end    -->


  <!--    case lists start   -->
  <div class="case-lists section-padding case-page">
     <div class="container">
        @if (hasCategory($be->theme_version))
            <div class="row">
            <div class="col-xl-12">
                <div class="case-types">
                    <ul class="text-center">
                        <li class="@if(empty(request()->input('category'))) active @endif"><a href="{{route('front.portfolios')}}">{{__('All')}}</a></li>

                        @foreach ($scats as $key => $scat)
                            <li class="@if(request()->input('category') == $scat->id) active @endif"><a href="{{route('front.portfolios', ['category'=>$scat->id])}}">{{convertUtf8($scat->name)}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            </div>
        @endif
        <div class="cases">
           <div class="row">
             @if (count($portfolios) == 0)
               <div class="col-lg-12 py-5 bg-light text-center mb-4">
                 <h3>{{__('NO PORTFOLIO FOUND')}}</h3>
               </div>
             @else
               @foreach ($portfolios as $key => $portfolio)
                 <div class="col-lg-4 col-md-6">
                   <div class="single-case" style="background-image: url('{{asset('assets/front/img/portfolios/featured/'.$portfolio->featured_image)}}')">
                      <div class="outer-container">
                         <div class="inner-container">
                            <h4>{{convertUtf8(strlen($portfolio->title)) > 36 ? convertUtf8(substr($portfolio->title, 0, 36)) . '...' : convertUtf8($portfolio->title)}}</h4>
                            @if (!empty($portfolio->service))
                            <p>{{$portfolio->service->title}}</p>
                            @endif

                            <a href="{{route('front.portfoliodetails', [$portfolio->slug, $portfolio->id])}}" class="readmore-btn"><span>{{__('Read More')}}</span></a>

                         </div>
                      </div>
                   </div>
                 </div>
               @endforeach
             @endif
           </div>
        </div>
        @if ($portfolios->total() > 6)
          <div class="row">
             <div class="col-md-12">
                <nav class="pagination-nav {{$portfolios->total() > 6 ? 'mb-4' : ''}}">
                  {{$portfolios->appends(['category' => request()->input('category')])->links()}}
                </nav>
             </div>
          </div>
        @endif
     </div>
  </div>
  <!--    case lists end   -->
@endsection
