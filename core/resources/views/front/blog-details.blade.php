@extends("front.$version.layout")

@section('pagename')
 - {{convertUtf8($blog->title)}}
@endsection

@section('meta-keywords', "$blog->meta_keywords")
@section('meta-description', "$blog->meta_description")

@section('content')
  <!--   hero area end   -->
  <div class="blog-details breadcrumb-area" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
     <div class="container">
        <div class="breadcrumb-txt">
           <div class="row">
              <div class="col-xl-7 col-lg-8 col-sm-10">
                 <span>{{convertUtf8($bs->blog_details_title)}}</span>
                 <h1>{{strlen(convertUtf8($blog->title)) > 30 ? substr(convertUtf8($blog->title), 0, 30) . '...' : convertUtf8($blog->title)}}</h1>
                 <ul class="breadcumb">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                    <li>{{__('Blog Details')}}</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
     <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
  </div>
  <!--   hero area end    -->


  <!--    blog details section start   -->
  <div class="blog-details-section section-padding">
     <div class="container">
        <div class="row">
           <div class="col-lg-7">
              <div class="blog-details">
                 <img class="blog-details-img-1" src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}" alt="">
                 <small class="date">{{date('F d, Y', strtotime($blog->created_at))}}  -  {{__('BY')}} {{__('Admin')}}</small>
                 <h2 class="blog-details-title">{{convertUtf8($blog->title)}}</h2>
                 <div class="blog-details-body">
                   {!! replaceBaseUrl(convertUtf8($blog->content)) !!}
                 </div>
              </div>
              <div class="blog-share mb-5">
                 <ul>
                    <li><a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(url()->current()) }}" class="facebook-share"><i class="fab fa-facebook-f"></i> {{__('Share')}}</a></li>
                    <li><a href="https://twitter.com/intent/tweet?text=my share text&amp;url={{urlencode(url()->current()) }}" class="twitter-share"><i class="fab fa-twitter"></i> {{__('Tweet')}}</a></li>
                    <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{urlencode(url()->current()) }}&amp;title={{convertUtf8($blog->title)}}" class="linkedin-share"><i class="fab fa-linkedin-in"></i> {{__('Linkedin')}}</a></li>
                 </ul>
              </div>

              <div class="comment-lists">
                <div id="disqus_thread"></div>
              </div>
           </div>
           <!--    blog sidebar section start   -->
           <div class="col-lg-4">
              <div class="sidebar">
                 <div class="blog-sidebar-widgets">
                    <div class="searchbar-form-section">
                       <form action="{{route('front.blogs', ['category' => request()->input('category'), 'month' => request()->input('month'), 'year' => request()->input('year')])}}" method="GET">
                          <div class="searchbar">
                             <input name="category" type="hidden" value="{{request()->input('category')}}">
                             <input name="month" type="hidden" value="{{request()->input('month')}}">
                             <input name="year" type="hidden" value="{{request()->input('year')}}">
                             <input name="term" type="text" placeholder="{{__('Search Blogs')}}" value="{{request()->input('term')}}">
                             <button type="submit"><i class="fa fa-search"></i></button>
                          </div>
                       </form>
                    </div>
                 </div>
                 <div class="blog-sidebar-widgets category-widget">
                    <div class="category-lists job">
                       <h4>{{__('Categories')}}</h4>
                       <ul>
                          @foreach ($bcats as $key => $bcat)
                            <li class="single-category @if(request()->input('category') == $bcat->slug) active @endif"><a href="{{route('front.blogs', ['term'=>request()->input('term'), 'category'=>$bcat->slug, 'month' => request()->input('month'), 'year' => request()->input('year')])}}">{{convertUtf8($bcat->name)}}</a></li>
                          @endforeach
                       </ul>
                    </div>
                 </div>
                 <div class="blog-sidebar-widgets category-widget">
                    <div class="category-lists job">
                       <h4>{{__('Archives')}}</h4>
                       <ul>
                          @foreach ($archives as $key => $archive)
                            @php
                              $myArr = explode('-', $archive->date);
                              $monthNum  = $myArr[0];
                              $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                              $monthName = $dateObj->format('F');
                            @endphp
                            <li class="single-category @if(request()->input('month') == $myArr[0] && request()->input('year') == $myArr[1]) active @endif">
                                <a href="{{route('front.blogs', ['term'=>request()->input('term'), 'category'=>request()->input('category'),'month'=>$myArr[0], 'year'=>$myArr[1]])}}">

                                    @php
                                        if (!empty($currentLang)) {
                                            $monthName = \Carbon\Carbon::parse($monthName)->locale("$currentLang->code");
                                            $year = \Carbon\Carbon::parse($myArr[1])->locale("$currentLang->code");
                                        } else {
                                            $monthName = \Carbon\Carbon::parse($monthName)->locale("en");
                                            $year = \Carbon\Carbon::parse($myArr[1])->locale("en");
                                        }

                                        $monthName = $monthName->translatedFormat('F');
                                        $year = $year->translatedFormat('Y');
                                    @endphp

                                    {{$monthName}} {{$year}}
                                </a>
                            </li>
                          @endforeach
                       </ul>
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
           <!--    blog sidebar section end   -->
        </div>
     </div>
  </div>
  <!--    blog details section end   -->

@endsection

@section('scripts')
@if($bs->is_disqus == 1)
{!! $bs->disqus_script !!}
@endif
@endsection
