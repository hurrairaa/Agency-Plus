
    <div class="logistics_pricing pricing_v1">
        <div class="pricing_slide">
            <div class="pricing_box text-center">
                <div class="pricing_title">
                    <h3>{{convertUtf8($package->title)}}</h3>
                </div>
                <div class="pricing_price">
                    <h3>{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$package->price}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</h3>
                </div>
                <div class="pricing_body">
                    {!! replaceBaseUrl(convertUtf8($package->description)) !!}
                </div>
            </div>
        </div>
    </div>
