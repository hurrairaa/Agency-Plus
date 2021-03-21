<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/paytm/notify*',
        '/product/paytm/notify*',
        '/flutterwave/notify',
        '/mercadopago/notify',
        '/product/mercadopago/notify',
        '/product/flutterwave/notify',
        '/razorpay/notify',
        '/product/razorpay/notify',
        '/payumoney/notify',
        '/product/payumoney/notify'
    ];
}
