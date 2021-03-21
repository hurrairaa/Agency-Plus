@extends("front.$version.layout")

@section('pagename')
 - {{__('Gallery')}}
@endsection

@section('meta-keywords', "$be->gallery_meta_keywords")
@section('meta-description', "$be->gallery_meta_description")

@section('content')
<!--   breadcrumb area start   -->
<div class="breadcrumb-area" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
   <div class="container">
      <div class="breadcrumb-txt">
         <div class="row">
            <div class="col-xl-7 col-lg-8 col-sm-10">
               <span>{{$bs->gallery_title}}</span>
               <h1>{{$bs->gallery_subtitle}}</h1>
               <ul class="breadcumb">
                  <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                  <li>{{__('GALLERY')}}</li>
               </ul>
            </div>
         </div>
      </div>
   </div>
   <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
</div>
<!--   breadcrumb area end    -->


<!--    Gallery section start   -->
<div class="gallery-section masonry clearfix">
   <div class="container">
      <div class="grid">
         <div class="grid-sizer"></div>
         @foreach ($galleries as $key => $gallery)
           <div class="single-pic">
              <img src="{{asset('assets/front/img/gallery/'.$gallery->image)}}" alt="">
              <div class="single-pic-overlay"></div>
              <div class="txt-icon">
                 <div class="outer">
                    <div class="inner">
                       <h4>{{convertUtf8(strlen($gallery->title)) > 20 ? convertUtf8(substr($gallery->title, 0, 20)) . '...' : convertUtf8($gallery->title)}}</h4>
                       <a class="icon-wrapper" href="{{asset('assets/front/img/gallery/'.$gallery->image)}}" data-lightbox="single-pic" data-title="{{convertUtf8($gallery->title)}}">
                       <i class="fas fa-search-plus"></i>
                       </a>
                    </div>
                 </div>
              </div>
           </div>
         @endforeach
      </div>
      <div class="row mt-5">
         <div class="col-md-12">
            <nav class="pagination-nav">
              {{$galleries->links()}}
            </nav>
         </div>
      </div>
   </div>
</div>
<!--    Gallery section end   -->
@endsection
