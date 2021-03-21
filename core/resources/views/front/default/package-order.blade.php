
    <div class="single-pricing-table package-order">
        <span class="title">{{convertUtf8($package->title)}}</span>
        <div class="price">
        <h1>{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$package->price}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</h1>
        </div>
        <div class="features">
        {!! replaceBaseUrl(convertUtf8($package->description)) !!}
        </div>
    </div>
