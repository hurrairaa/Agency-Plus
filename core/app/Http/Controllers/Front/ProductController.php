<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BasicSetting as BS;
use App\BasicExtended as BE;
use App\BasicExtra;
use App\Product;
use App\ShippingCharge;
use App\ProductReview;
use Auth;
use App\Pcategory;
use Session;
use App\Language;
use App\OfflineGateway;
use App\PaymentGateway;

class ProductController extends Controller
{

    public function __construct()
    {
        $bs = BS::first();
        $be = BE::first();
    }

    public function product(Request $request)
    {

        $bex = BasicExtra::first();
        if ($bex->is_shop == 0) {
            return back();
        }

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;
        $lang_id = $currentLang->id;

        $data['products'] = Product::where('status', 1)->where('language_id',$currentLang->id)->paginate(6);
        $data['categories'] = Pcategory::where('status', 1)->where('language_id',$currentLang->id)->get();

        $search = $request->search;
        $minprice = $request->minprice;
        $maxprice = $request->maxprice;
        $category = $request->category_id;
        $tag = $request->tag;

        if($request->type){
            $type = $request->type;
        }else{
            $type = 'new';
        }
        $tag = $request->tag;
        $review = $request->review;

        $data['products'] =
            Product::when($category, function ($query, $category) {
                return $query->where('category_id', $category);
            })
            ->when($lang_id, function ($query, $lang_id) {
                return $query->where('language_id', $lang_id);
            })
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%')->orwhere('summary', 'like', '%' . $search . '%')->orwhere('description', 'like', '%' . $search . '%');
            })
            ->when($minprice, function ($query, $minprice) {
                return $query->where('current_price', '>=', $minprice);
            })
            ->when($maxprice, function ($query, $maxprice) {
                return $query->where('current_price', '<=', $maxprice);
            })
            ->when($tag, function ($query, $tag) {
                return $query->where('tags', 'like', '%' . $tag . '%');
            })
            ->when($review, function ($query, $review) {
                return $query->where('rating', '>=', $review);
            })

            ->when($type, function ($query, $type) {
                if ($type == 'new') {
                    return $query->orderBy('id', 'DESC');
                } elseif ($type == 'old') {
                    return $query->orderBy('id', 'ASC');
                } elseif ($type == 'high-to-low') {
                    return $query->orderBy('current_price', 'DESC');
                } elseif ($type == 'low-to-high') {
                    return $query->orderBy('current_price', 'ASC');
                }
            })

            ->where('status', 1)->paginate(10);

            $version = getVersion($be->theme_version);

            if ($version == 'dark') {
                $version = 'default';
            }

            $data['version'] = $version;

            return view('front.product.product', $data);

    }

    public function productDetails($slug)
    {
        $bex = BasicExtra::first();
        if ($bex->is_shop == 0) {
            return back();
        }

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        Session::put('link', url()->current());
        $data['product'] = Product::where('slug', $slug)->where('language_id',$currentLang->id)->first();
        $data['categories'] = Pcategory::where('status', 1)->where('language_id',$currentLang->id)->get();

        $data['related_product'] = Product::where('category_id', $data['product']->category_id)->where('language_id',$currentLang->id)->where('id', '!=', $data['product']->id)->get();

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.product.details', $data);
    }

    public function cart()
    {
        $bex = BasicExtra::first();
        if ($bex->is_shop == 0) {
            return back();
        }

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        if (Session::has('cart')) {
            $cart = Session::get('cart');
        } else {
            $cart = null;
        }

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);
        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.product.cart', compact('cart', 'version'));
    }

    public function addToCart($id)
    {

        $cart = Session::get('cart');

        if (strpos($id, ',,,') == true) {
            $data = explode(',,,', $id);
            $id = $data[0];
            $qty = $data[1];

            $product = Product::findOrFail($id);

            if(!empty($cart) && array_key_exists($id, $cart)){
                if($product->stock < $cart[$id]['qty'] + $qty){
                    return response()->json(['error' => 'Out of Stock']);
                }
            }else{
                if($product->stock < $qty){
                    return response()->json(['error' => 'Out of Stock']);
                }
            }

            if (!$product) {
                abort(404);
            }
            $cart = Session::get('cart');
            // if cart is empty then this the first product
            if (!$cart) {

                $cart = [
                    $id => [
                        "name" => $product->title,
                        "qty" => $qty,
                        "price" => $product->current_price,
                        "photo" => $product->feature_image
                    ]
                ];

                Session::put('cart', $cart);
                return response()->json(['message' => 'Product added to cart successfully!']);
            }

            // if cart not empty then check if this product exist then increment quantity
            if (isset($cart[$id])) {
                $cart[$id]['qty'] +=  $qty;
                Session::put('cart', $cart);
                return response()->json(['message' => 'Product added to cart successfully!']);
            }

            // if item not exist in cart then add to cart with quantity = 1
            $cart[$id] = [
                "name" => $product->title,
                "qty" => $qty,
                "price" => $product->current_price,
                "photo" => $product->feature_image
            ];
        } else {

            $id = $id;
            $product = Product::findOrFail($id);
            if (!$product) {
                abort(404);
            }
            if(!empty($cart) && array_key_exists($id, $cart)){
                if($product->stock < $cart[$id]['qty'] + 1){
                    return response()->json(['error' => 'Out of Stock']);
                }
            }else{
                if($product->stock < 1){
                    return response()->json(['error' => 'Out of Stock']);
                }
            }


            $cart = Session::get('cart');
            // if cart is empty then this the first product
            if (!$cart) {

                $cart = [
                    $id => [
                        "name" => $product->title,
                        "qty" => 1,
                        "price" => $product->current_price,
                        "photo" => $product->feature_image
                    ]
                ];

                Session::put('cart', $cart);
                return response()->json(['message' => 'Product added to cart successfully!']);
            }

            // if cart not empty then check if this product exist then increment quantity
            if (isset($cart[$id])) {
                $cart[$id]['qty']++;
                Session::put('cart', $cart);
                return response()->json(['message' => 'Product added to cart successfully!']);
            }

            // if item not exist in cart then add to cart with quantity = 1
            $cart[$id] = [
                "name" => $product->title,
                "qty" => 1,
                "price" => $product->current_price,
                "photo" => $product->feature_image
            ];
        }

        Session::put('cart', $cart);
        return response()->json(['message' => 'Product added to cart successfully!']);
    }


    public function updatecart(Request $request)
    {
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            foreach ($request->product_id as $key => $id) {
            $product = Product::findOrFail($id);
                if($product->stock < $request->qty[$key]){
                    return response()->json(['error' => $product->title .' stock not available']);
                }
                if (isset($cart[$id])) {
                    $cart[$id]['qty'] =  $request->qty[$key];
                    Session::put('cart', $cart);
                }
            }
        }
        $total = 0;
        $count = 0;
        foreach ($cart as $i) {
            $total += $i['price'] * $i['qty'];
            $count += $i['qty'];
        }

        $total = round($total, 2);

        return response()->json(['message' => 'Cart Update Successfully.', 'total' => $total, 'count' => $count]);
    }


    public function cartitemremove($id)
    {
        if ($id) {
            $cart = Session::get('cart');
            if (isset($cart[$id])) {
                unset($cart[$id]);
                Session::put('cart', $cart);
            }

            $total = 0;
            $count = 0;
            foreach ($cart as $i) {
                $total += $i['price'] * $i['qty'];
                $count += $i['qty'];
            }
            $total = round($total, 2);

            return response()->json(['message' => 'Product removed successfully', 'count' => $count, 'total' => $total]);
        }
    }


    public function checkout()
    {
        $bex = BasicExtra::first();
        if ($bex->is_shop == 0) {
            return back();
        }
        $data['bex'] = $bex;

        if (!Session::get('cart')) {
            Session::flash('error', 'Your cart is empty.');
            return back();
        }

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $user = Auth::user();

        if ($user) {
            if (Session::has('cart')) {
                $data['cart'] = Session::get('cart');
            } else {
                $data['cart'] = null;
            }
            $data['shippings'] = ShippingCharge::where('language_id',$currentLang->id)->get();
            $data['user'] = Auth::user();
            $data['ogateways'] = $currentLang->offline_gateways()->where('product_checkout_status', 1)->orderBy('serial_number')->get();
            $data['stripe'] = PaymentGateway::find(14);
            $data['paypal'] = PaymentGateway::find(15);
            $data['paystackData'] = PaymentGateway::whereKeyword('paystack')->first();
            $data['paystack'] = $data['paystackData']->convertAutoData();
            $data['flutterwave'] = PaymentGateway::find(6);
            $data['razorpay'] = PaymentGateway::find(9);
            $data['instamojo'] = PaymentGateway::find(13);
            $data['paytm'] = PaymentGateway::find(11);
            $data['mollie'] = PaymentGateway::find(17);
            $data['mercadopago'] = PaymentGateway::find(19);
            $data['payumoney'] = PaymentGateway::find(18);

            // setting success URL & Fauilure URL for PayUmoney
            // $arr = ['INDIPAY_SUCCESS_URL' => 'product/payumoney/notify','INDIPAY_FAILURE_URL' => 'product/payumoney/notify'];
            // setEnvironmentValue($arr);
            // \Artisan::call('config:clear');

            // determining the theme version selected
            $be = $currentLang->basic_extended;
            $version = getVersion($be->theme_version);

            if ($version == 'dark') {
                $version = 'default';
            }

            $data['version'] = $version;

            return view('front.product.checkout', $data);

        } else {
            Session::put('link', url()->current());
            return redirect(route('user.login'));
        }


    }


    public function Prdouctcheckout(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();

        if (!$product) {
            abort(404);
        }

        if ($request->qty) {
            $qty = $request->qty;
        } else {
            $qty = 1;
        }


        $cart = Session::get('cart');
        $id = $product->id;
        // if cart is empty then this the first product
        if (!($cart)) {
            if($product->stock <  $qty){
                Session::flash('error','Out of stock');
                return back();
            }

            $cart = [
                $id => [
                    "name" => $product->title,
                    "qty" => $qty,
                    "price" => $product->current_price,
                    "photo" => $product->feature_image
                ]
            ];

            Session::put('cart', $cart);
            if (!Auth::user()) {
                Session::put('link', url()->current());
                return redirect(route('user.login'));
            }
            return redirect(route('front.checkout'));
        }

        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$id])) {

            if($product->stock < $cart[$id]['qty'] + $qty){
                Session::flash('error','Out of stock');
                return back();
            }
            $qt = $cart[$id]['qty'];
            $cart[$id]['qty'] = $qt + $qty;

            Session::put('cart', $cart);
                if (!Auth::user()) {
                Session::put('link', url()->current());
                return redirect(route('user.login'));
            }
            return redirect(route('front.checkout'));
        }

        if($product->stock <  $qty){
            Session::flash('error','Out of stock');
            return back();
        }


        $cart[$id] = [
            "name" => $product->title,
            "qty" => $qty,
            "price" => $product->current_price,
            "photo" => $product->feature_image
        ];
        Session::put('cart', $cart);



        if (!Auth::user()) {
            Session::put('link', url()->current());
            return redirect(route('user.login'));
        }
        return redirect(route('front.checkout'));
    }

}
