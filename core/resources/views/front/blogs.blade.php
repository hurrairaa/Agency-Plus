@extends("front.$version.layout")

@section('pagename')
 -
 @if (empty($category))
 {{__('All')}}
 @else
 {{convertUtf8($category->name)}}
 @endif
 {{__('Blogs')}}
@endsection

@section('meta-keywords', "$be->blogs_meta_keywords")
@section('meta-description', "$be->blogs_meta_description")

@section('content')
  <!--   hero area start   -->
  <div class="breadcrumb-area blogs" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
     <div class="container">
        <div class="breadcrumb-txt">
           <div class="row">
              <div class="col-xl-7 col-lg-8 col-sm-10">
                 <span>{{convertUtf8($bs->blog_title)}}</span>
                 <h1>{{convertUtf8($bs->blog_subtitle)}}</h1>
                 <ul class="breadcumb">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                    <li>{{__('Latest Blogs')}}</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
     <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
  </div>
  <!--   hero area end    -->


  <!--    blog lists start   -->
  <div class="blog-lists section-padding">
     <div class="container">
        <div class="row">
           <div class="col-lg-8">
              <div class="row">
                @if (count($blogs) == 0)
                  <div class="col-md-12">
                    <div class="bg-light py-5">
                      <h3 class="text-center">{{__('NO BLOG FOUND')}}</h3>
                    </div>
                  </div>
                @else
                  @foreach ($blogs as $key => $blog)
                    <div class="col-md-6">
                       <div class="single-blog">
                          <div class="blog-img-wrapper">
                             <img src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}" alt="">
                          </div>
                          <div class="blog-txt">
                            @php
                                if (!empty($currentLang)) {
                                    $blogDate = \Carbon\Carbon::parse($blog->created_at)->locale("$currentLang->code");
                                } else {
                                    $blogDate = \Carbon\Carbon::parse($blog->created_at)->locale("en");
                                }

                                $blogDate = $blogDate->translatedFormat('jS F, Y');
                            @endphp
                             <p class="date"><small>{{__('By')}} <span class="username">{{__('Admin')}}</span></small> | <small>{{$blogDate}}</small> </p>

                             <h4 class="blog-title"><a href="{{route('front.blogdetails', [$blog->slug, $blog->id])}}">{{convertUtf8(strlen($blog->title)) > 40 ? convertUtf8(substr($blog->title, 0, 40)) . '...' : convertUtf8($blog->title)}}</a></h4>

                             <p class="blog-summary">{!! (strlen(strip_tags(convertUtf8($blog->content))) > 100) ? substr(strip_tags(convertUtf8($blog->content)), 0, 100) . '...' : strip_tags(convertUtf8($blog->content)) !!}</p>

                             <a href="{{route('front.blogdetails', [$blog->slug, $blog->id])}}" class="readmore-btn"><span>{{__('Read More')}}</span></a>

                          </div>
                       </div>
                    </div>
                  @endforeach
                @endif
              </div>
              @if ($blogs->total() > 6)
                <div class="row">
                   <div class="col-md-12">
                      <nav class="pagination-nav {{$blogs->total() > 6 ? 'mb-4' : ''}}">
                        {{$blogs->appends(['term'=>request()->input('term'), 'month'=>request()->input('month'), 'year'=>request()->input('year'), 'category' => request()->input('category')])->links()}}
                      </nav>
                   </div>
                </div>
              @endif
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
  <!--    blog lists end   -->
@endsection
