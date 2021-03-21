
    <div class="single-price-item text-center">
        <div class="price-heading">
            <h3>{{convertUtf8($package->title)}}</h3>
            @if ($package->feature == 1)
                <span>{{__('Featured Package')}}</span>
            @else
                <span>{{__('Package')}}</span>
            @endif
        </div>
        <h1 class="bg-1" style="background: #{{$package->color}};">{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$package->price}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</h1>
        <div class="price-cata mb-4">
            {!! replaceBaseUrl(convertUtf8($package->description)) !!}
        </div>
    </div>
