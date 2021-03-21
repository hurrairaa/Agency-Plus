@extends("front.$version.layout")

@section('pagename')
 - {{__('Product')}} - {{convertUtf8($product->title)}}
@endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/front/css/slick.css')}}">
@endsection

@section('meta-keywords', "$product->meta_keywords")
@section('meta-description', "$product->meta_description")

@php
    $reviews = App\ProductReview::where('product_id', $product->id)->get();
    $avarage_rating = App\ProductReview::where('product_id',$product->id)->avg('review');
    $avarage_rating =  round($avarage_rating,2);

@endphp

@section('content')
 <!--   hero area start   -->
 <div class="breadcrumb-area services service-bg" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
    <div class="container">
        <div class="breadcrumb-txt">
            <div class="row">
                <div class="col-xl-7 col-lg-8 col-sm-10">
                    <span>{{$be->product_details_title}}</span>
                    <h1>{{strlen(convertUtf8($product->title)) > 40 ? substr(convertUtf8($product->title), 0, 40) . '...' : convertUtf8($product->title)}}</h1>
                    <ul class="breadcumb">
                        <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                        <li>{{convertUtf8($product->title)}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-area-overlay"></div>
</div>
<!--   hero area end    -->


<!--====== PRODUCT DETAILS PART START ======-->

<div class="product-details-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="product-item-slide ">
                    @foreach ($product->product_images as $image)
                    <div class="item pt-30">
                        <a class="image-popup" href="{{asset('assets/front/img/product/sliders/'.$image->image)}}"><img src="{{asset('assets/front/img/product/sliders/'.$image->image)}}" alt=""></a>
                    </div>
                    @endforeach
                </div>
                <div class="product-details-slide-item mt-30">
                    <ul class="d-flex">
                        @foreach ($product->product_images as $image)
                        <li><img src="{{asset('assets/front/img/product/sliders/'.$image->image)}}" alt=""></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="product-details-content ml-60 mt-30">
                    <div class="product-details-content-item">
                        <h4 class="title">{{convertUtf8($product->title)}}</h4>
                        <div class="d-flex justify-content-between">
                            <div class="rate">
                                <div class="rating" style="width:{{$product->rating * 20}}%"></div>
                            </div>
                            @if ($product->stock > 0)
                                <h4 class="badge badge-success">
                                    <i class="far fa-check-circle"></i> {{__('In Stock')}}
                                </h4>
                            @else
                                <h4 class="badge badge-danger">
                                    <i class="far fa-times-circle"></i> {{__('Out of Stock')}}
                                </h4>
                            @endif
                        </div>
                        <span>{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$product->current_price}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}
                        @if (!empty($product->previous_price))
                            <del>  <span class="prepice"> {{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}{{$product->previous_price}}{{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }}</span></del>
                        @endif
                        </span>

                    <p>{{convertUtf8($product->summary)}}</p>
                    </div>
                    <div class="product-btns d-block d-sm-flex align-items-center mt-40">
                        <div class="product-quantity  d-flex" id="quantity">
                            <button type="button" id="sub" class="sub subclick">-</button>
                            <input type="text" class="cart-amount" id="1" value="1" />
                            <button type="button" id="add" class="add addclick">+</button>
                        </div>
                    </div>

                    <div class="actions">
                        <a class="main-btn cart-btn cart-link d-inline-block" data-href="{{route('add.cart',$product->id)}}">{{__('Add To Cart')}}</a>
                        <form class="d-inline-block ml-2" method="GET" action="{{route('front.product.checkout',$product->slug)}}">
                            <input type="hidden" value="" name="qty" id="order_click_with_qty">
                            <button type="submit" class="main-btn checkout-btn" >{{__('Order Now')}}</button>
                        </form>
                    </div>

                    <div class="product-social-icon social-link a2a_kit a2a_kit_size_32">
                        <ul class="social-share">
                            <li>
                                <a class="facebook a2a_button_facebook" href="">
                                  <i class="fab fa-facebook-f"></i>
                                </a>
                              </li>
                                <li>
                                    <a class="twitter a2a_button_twitter" href="">
                                      <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="linkedin a2a_button_linkedin" href="">
                                      <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="pinterest a2a_button_pinterest" href="">
                                      <i class="fab fa-pinterest"></i>
                                    </a>
                                </li>
                                <li>

                                <a class="a2a_dd plus" href="https://www.addtoany.com/share">
                                    <i class="fas fa-plus"></i>
                                  </a>
                                </li>
                        </ul>
                    </div>
                    <script async src="https://static.addtoany.com/menu/page.js"></script>
                    <div class="product-details-tags">
                        <ul>
                            <li><span>{{__('SKU')}}:</span> {{$product->sku}} </li>
                            @if(!empty($product->category))
                            <li><span>{{__('Category')}}:</span> <a href="{{route('front.product').'?category_id='.$product->category_id}}">{{$product->category ? convertUtf8($product->category->name) : ''}}</a> </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--====== PRODUCT DETAILS PART ENDS ======-->

<!--====== SHOP TAB PART START ======-->

<div class="shop-tab-area" @if($related_product->count() == 0) style="padding-bottom:120px;" @endif>
    <div class="container">
        <div class="row">
            <div class="col-lg-11">
                <div class="shop-tab-area">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">{{__('Description')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">{{__('Reviews')}} ({{count($reviews)}})</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                {!! replaceBaseUrl(convertUtf8($product->description)) !!}

                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                            <div class="shop-review-area">
                                <div class="shop-review-title">
                                    <h3 class="title">{{convertUtf8($product->title)}}</h3>
                                </div>
                                    @foreach ($reviews as $review)
                                    <div class="shop-review-user">
                                        <img  src="{{ $review->user->photo ? asset('assets/front/img/user/'.$review->user->photo) : asset('assets/user/img/profile.jpg') }}" width="60">
                                        <ul>
                                            <div class="rate">
                                                <div class="rating" style="width:{{$review->review * 20}}%"></div>
                                            </div>
                                        </ul>
                                        <span><span>{{convertUtf8($review->user->username)}}</span> – {{$review->created_at->format('d-m-Y')}}</span>
                                        <p>{{convertUtf8($review->comment)}}</p>
                                    </div>
                                    @endforeach
                                    @if(Auth::user())
                                        @if(App\OrderItem::where('user_id',Auth::user()->id)->where('product_id',$product->id)->exists())
                                    <div class="shop-review-form">
                                        @error('error')
                                        <p class="text-danger my-2">{{Session::get('error')}}</p>
                                        @enderror
                                        <form class="mt-5" action="{{route('product.review.submit')}}" method="POST">@csrf
                                            <div class="input-box">
                                                <span>{{__('Comment')}}</span>
                                                <textarea name="comment"  cols="30" rows="10" placeholder="{{__('Comment')}}"></textarea>
                                            </div>
                                            <input type="hidden" value="" id="reviewValue" name="review">
                                            <input type="hidden" value="{{$product->id}}" name="product_id">
                                            <div class="input-box">
                                                <span>{{__('Rating')}} *</span>
                                                <div class="review-content ">
                                                <ul class="review-value review-1">
                                                    <li><a class="cursor-pointer" data-href="1"><i class="far fa-star"></i></a></li>
                                                </ul>
                                                <ul class="review-value review-2">
                                                    <li><a class="cursor-pointer" data-href="2"><i class="far fa-star"></i></a></li>
                                                    <li><a class="cursor-pointer" data-href="2"><i class="far fa-star"></i></a></li>
                                                </ul>
                                                <ul class="review-value review-3">
                                                    <li><a class="cursor-pointer" data-href="3"><i class="far fa-star"></i></a></li>
                                                    <li><a class="cursor-pointer" data-href="3"><i class="far fa-star"></i></a></li>
                                                    <li><a class="cursor-pointer" data-href="3"><i class="far fa-star"></i></a></li>
                                                </ul>
                                                <ul class="review-value review-4">
                                                    <li><a class="cursor-pointer" data-href="4"><i class="far fa-star"></i></a></li>
                                                    <li><a class="cursor-pointer" data-href="4"><i class="far fa-star"></i></a></li>
                                                    <li><a class="cursor-pointer" data-href="4"><i class="far fa-star"></i></a></li>
                                                    <li><a class="cursor-pointer" data-href="4"><i class="far fa-star"></i></a></li>
                                                </ul>
                                                <ul class="review-value review-5">
                                                    <li><a class="cursor-pointer" data-href="5"><i class="far fa-star"></i></a></li>
                                                    <li><a class="cursor-pointer" data-href="5"><i class="far fa-star"></i></a></li>
                                                    <li><a class="cursor-pointer" data-href="5"><i class="far fa-star"></i></a></li>
                                                    <li><a class="cursor-pointer" data-href="5"><i class="far fa-star"></i></a></li>
                                                    <li><a class="cursor-pointer" data-href="5"><i class="far fa-star"></i></a></li>
                                                </ul>
                                            </div>
                                            </div>
                                            <div class="input-btn mt-3">
                                                <button type="submit">{{__('Submit')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                    @endif
                                    @else
                                    <div class="review-login mt-5">
                                        <a class="boxed-btn d-inline-block mr-2" href="{{route('user.login')}}">{{__('Login')}}</a> {{__('to leave a rating')}}
                                    </div>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--====== SHOP TAB PART ENDS ======-->


@if($related_product->count() > 0)
<!--====== product items PART ENDS ======-->
<div class="product-items">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <span class="section-title">{{__('Related Products')}}</span>
                <h2 class="section-summary"{{__('>Have a look at the finlance latest Product')}}></h2>
            </div>
        </div>

        <div class="owl-carousel shop-item-slide-2">

             @foreach ($related_product as $product)
                 <div class="shop-item">
                    <div class="shop-thumb">
                        <img src="{{asset('assets/front/img/product/featured/'.$product->feature_image)}}" alt="">
                        <ul>
                            <li><a href="{{route('front.product.checkout',$product->slug)}}" data-toggle="tooltip" data-placement="top" title="{{__('Order Now')}}"><i class="far fa-credit-card"></i></a></li>
                            <li><a class="cart-link" data-href="{{route('add.cart',$product->id)}}" data-toggle="tooltip" data-placement="top" title="{{__('Add to Cart')}}"><i class="fas fa-shopping-cart"></i></a></li>
                            <li><a href="{{route('front.product.details',$product->slug)}}" data-toggle="tooltip" data-placement="top" title="{{__('View Details')}}"><i class="fas fa-eye"></i></a></li>
                        </ul>
                    </div>
                    <div class="shop-content text-center">
                        <div class="rate">
                            <div class="rating" style="width:{{$product->rating * 20}}%"></div>
                        </div>
                        <a href="{{route('front.product.details',$product->slug)}}">{{convertUtf8($product->title)}}</a> <br>
                        <span>
                            {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$product->current_price}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}
                            @if (!empty($product->previous_price))
                                <del>  <span class="prepice"> {{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}{{$product->previous_price}}{{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }}</span></del>
                            @endif
                        </span>
                    </div>
                </div>
             @endforeach


        </div>

    </div>
</div>
@endif
<!--====== product items PART ENDS ======-->

@endsection

@section('scripts')

<script src="{{asset('assets/front/js/slick.min.js')}}"></script>
<script src="{{asset('assets/front/js/product.js')}}"></script>
<script src="{{asset('assets/front/js/cart.js')}}"></script>
<script>
    $('.image-popup').magnificPopup({
        type: 'image',
        gallery:{
            enabled:true
        }
    });

</script>

<script>
    $(document).on('click','.review-value li a',function(){
        $('.review-value li a i').removeClass('text-primary');
        let reviewValue = $(this).attr('data-href');
         parentClass = `review-${reviewValue}`;
        $('.'+parentClass+ ' li a i').addClass('text-primary');
        $('#reviewValue').val(reviewValue);
    })
</script>

@endsection
