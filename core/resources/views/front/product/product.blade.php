@extends("front.$version.layout")

@section('pagename')
 -
 @if (empty($category))
 {{__('All')}}
 @else
 {{convertUtf8($category->name)}}
 @endif
 {{__('Products')}}
@endsection

@section('meta-keywords', "$be->products_meta_keywords")
@section('meta-description', "$be->products_meta_description")


@section('styles')
<link rel="stylesheet" href="{{asset('assets/front/css/jquery-ui.min.css')}}">
@endsection


@section('content')
  <!--   breadcrumb area start   -->
  <div class="breadcrumb-area services service-bg" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
    <div class="container">
        <div class="breadcrumb-txt">
            <div class="row">
                <div class="col-xl-7 col-lg-8 col-sm-10">
                    <span>{{convertUtf8($be->product_title)}}</span>
                    <h1>{{convertUtf8($be->product_subtitle)}}</h1>
                    <ul class="breadcumb">
                        <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                        <li>{{__('Our Product')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-area-overlay"></div>
  </div>
  <!--   breadcrumb area end    -->


<!--    product section start    -->
<div class="product-area">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-3 col-md-6">
                <div class="shop-search mt-30">
                    <input type="text" placeholder="Search Keywords" class="input-search" name="search" value="{{request()->input('search') ? request()->input('search') : ''}}">
                    <i  class="fas fa-search input-search-btn cursor-pointer"></i>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="shop-dropdown mt-30 text-right">
                    <select name="type" id="type_sort">
                        <option value="new" {{ request()->input('type') == 'new' ? 'selected' : '' }}>{{__('Newest Product')}}</option>
                        <option value="old" {{ request()->input('type') == 'old' ? 'selected' : '' }}>{{__('Oldest Product')}}</option>
                        <option value="hight-to-low" {{ request()->input('type') == 'high-to-low' ? 'selected' : '' }}>{{__('High To Low')}}</option>
                        <option value="low-to-high" {{ request()->input('type') == 'low-to-high' ? 'selected' : '' }}>{{__('Low To High')}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-5 col-sm-7 order-2 order-lg-1">
                <div class="shop-sidebar">
                    <div class="shop-box shop-category">
                        <div class="sidebar-title">
                            <h4 class="title">{{__('Category')}}</h4>
                        </div>
                        <div class="category-item">
                            <ul>
                            <li class="{{ request()->input('category_id') == '' ? 'active-search' : '' }}" ><a data-href="0" class="category-id cursor-pointer">{{__('All')}}</a></li>
                                @foreach ($categories as $category)
                                <li class="{{ request()->input('category_id') == $category->id ? 'active-search' : '' }}"><a data-href="{{$category->id}}" class="category-id cursor-pointer">{{convertUtf8($category->name)}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @if($be->popular_tags)
                    <div class="shop-box shop-tag mt-30">
                        <div class="sidebar-title">
                            <h4 class="title">{{__('Populer Tags')}}</h4>
                        </div>
                        <div class="tag-item">
                            <ul>
                                <li class="{{ request()->input('tag') == '' ? 'active-search' : '' }}"><a data-href="" class="tag-id cursor-pointer">{{__('All')}}</a></li>
                                @foreach (explode(',',$be->popular_tags) as $tag)
                                <li class="{{ request()->input('tag') == $tag ? 'active-search' : '' }}"><a data-href="{{$tag}}" class="tag-id cursor-pointer">{{convertUtf8($tag)}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                    <div class="shop-box shop-filter mt-30">
                        <div class="sidebar-title">
                            <h4 class="title">{{__('Filter Products')}}</h4>
                        </div>
                        <div class="filter-item">
                             <ul class="checkbox_common checkbox_style2">
                                <li>
                                    <input type="radio" class="review_val" name="review_value"
                                    {{request()->input('review') == '' ? 'checked' : ''}}
                                    id="checkbox4" value="">
                                    <label for="checkbox4"><span></span> {{__('Show All')}}</label>
                                </li>

                                <li>
                                    <input type="radio" class="review_val" name="review_value" id="checkbox5" value="4" {{request()->input('review') == 4 ? 'checked' : ''}}
                                    id="checkbox4" value="all">
                                    <label for="checkbox5"><span></span>4 {{__('Star and higher')}}</label>
                                </li>

                                <li>
                                    <input type="radio" class="review_val" name="review_value" id="checkbox6" value="3" {{request()->input('review') == 3 ? 'checked' : ''}}
                                    id="checkbox4" value="all">
                                    <label for="checkbox6"><span></span>3 {{__('Star and higher')}}</label>
                                </li>

                                <li>
                                    <input type="radio" class="review_val" name="review_value" id="checkbox7" value="2" {{request()->input('review') == 2 ? 'checked' : ''}}
                                    id="checkbox4" value="all">
                                    <label for="checkbox7"><span></span>2 {{__('Star and higher')}}</label>
                                </li>

                                <li>
                                    <input type="radio" class="review_val" name="review_value" id="checkbox8" value="1" {{request()->input('review') == 1 ? 'checked' : ''}}
                                    id="checkbox4" value="all">
                                    <label for="checkbox8"><span></span>1 {{__('Star and higher')}}</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="shop-box shop-price mt-30">
                        <div class="sidebar-title">
                            <h4 class="title">{{__('Filter By Price')}}</h4>
                        </div>
                        <div class="price-item">
                            <div class="price-range-box ">
                            <form action="#">
                                <div id="slider-range"></div>
                                <span>{{__('Price')}}: </span>
                                <input type="text" name="text" id="amount" />
                                <button class="btn filter-button" type="button">{{__('Filter')}}</button>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 order-1 order-lg-2">
                <div class="row">
                    @if($products->count() > 0)

                  @foreach ($products as $product)
                  <div class="col-lg-4 col-md-4 col-sm-6">
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
                </div>
                  @endforeach
                  @else
                    <div class="col-12 text-center py-5 bg-light" style="margin-top: 30px;">
                        <h4 class="text-center">{{__('Product Not Found')}}</h4>
                    </div>
                  @endif
              </div>
                <div class="row">
                    <div class="col-md-12">
                        <nav class="pagination-nav {{$products->count() > 6 ? 'mb-4' : ''}}">
                            {{ $products->appends(['minprice' => request()->input('minprice'), 'maxprice' => request()->input('maxprice'), 'category_id' => request()->input('category_id'), 'type' => request()->input('type'), 'tag' => request()->input('tag'), 'review' => request()->input('review')])->links() }}
                        </nav>
                    </div>
                </div>
           </div>
        </div>
    </div>
</div>
<!--    product section ends    -->
@php
    $maxprice = App\Product::max('current_price');
    $minprice = 0;
@endphp

<form id="searchForm" class="d-none"  action="{{ route('front.product') }}" method="get">
    <input type="hidden" id="search" name="search" value="{{ !empty(request()->input('search')) ? request()->input('search') : '' }}">
    <input type="hidden" id="minprice" name="minprice" value="{{ !empty(request()->input('minprice')) ? request()->input('minprice') : $minprice }}">
    <input type="hidden" id="maxprice" name="maxprice" value="{{ !empty(request()->input('maxprice')) ? request()->input('maxprice') : $maxprice }}">
    <input type="hidden" name="category_id" id="category_id" value="{{ !empty(request()->input('category_id')) ? request()->input('category_id') : null }}">
    <input type="hidden" name="type" id="type" value="{{ !empty(request()->input('type')) ? request()->input('type') : 'new' }}">
    <input type="hidden" name="tag" id="tag" value="{{ !empty(request()->input('tag')) ? request()->input('tag') : '' }}">
    <input type="hidden" name="review" id="review" value="{{ !empty(request()->input('review')) ? request()->input('review') : '' }}">
    <button id="search-button" type="submit"></button>
</form>




@endsection


@section('scripts')
<script src="{{asset('assets/front/js/jquery.ui.js')}}"></script>
<script src="{{asset('assets/front/js/cart.js')}}"></script>
<script>
    var position = "{{$bex->base_currency_symbol_position}}";
    var symbol = "{{$bex->base_currency_symbol}}";

    console.log(position,symbol);
    $( "#slider-range" ).slider({
        range: true,
        min: 0,
        max: '{{$maxprice }}',
        values: [ '{{ !empty(request()->input('minprice')) ? request()->input('minprice') : $minprice }}', {{ !empty(request()->input('maxprice')) ? request()->input('maxprice') : $maxprice }} ],
        slide: function( event, ui ) {
        $( "#amount" ).val( (position == 'left' ? symbol : '') + ui.values[ 0 ] + (position == 'right' ? symbol : '') + " - " + (position == 'left' ? symbol : '') + ui.values[ 1 ] + (position == 'right' ? symbol : '') );
       }
    });
    $( "#amount" ).val( (position == 'left' ? symbol : '') + $( "#slider-range" ).slider( "values", 0 ) + (position == 'right' ? symbol : '') + " - " + (position == 'left' ? symbol : '') + $( "#slider-range" ).slider( "values", 1 ) + (position == 'right' ? symbol : '') );

</script>


<script>

    let maxprice = 0;
    let minprice = 0;
    let typeSort = '';
    let category = '';
    let tag = '';
    let review = '';
    let search = '';


    $(document).on('click','.filter-button',function(){
        let filterval = $('#amount').val();
        filterval = filterval.split('-');
        maxprice = filterval[1].replace('$','');
        minprice = filterval[0].replace('$','');
        maxprice = parseInt(maxprice);
        minprice = parseInt(minprice);
        $('#maxprice').val(maxprice);
        $('#minprice').val(minprice);
        $('#search-button').click();
    });

$(document).on('change','#type_sort',function(){
    typeSort = $(this).val();
    $('#type').val(typeSort);
    $('#search-button').click();
})
$(document).ready(function(){
    typeSort = $('#type_sort').val();
    $('#type').val(typeSort);
})

$(document).on('click','.category-id',function(){
    category = '';
    if($(this).attr('data-href') != 0){
        category = $(this).attr('data-href');
    }
    $('#category_id').val(category);
    $('#search-button').click();
})
$(document).on('click','.tag-id',function(){
    tag = '';
    if($(this).attr('data-href') != 0){
        tag = $(this).attr('data-href');
    }
   $('#tag').val(tag);
   $('#search-button').click();
})

$(document).on('click','.review_val',function(){
    review = $(".review_val:checked").val();
    $('#review').val(review);
    $('#search-button').click();
})

$(document).on('click','.input-search-btn',function(){
    search = $('.input-search').val();
    $('#search').val(search);
    $('#search-button').click();
})

</script>
@endsection
