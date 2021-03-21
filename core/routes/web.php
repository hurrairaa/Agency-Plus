<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/backup', 'Front\FrontendController@backup');

/*=======================================================
******************** Front Routes **********************
=======================================================*/

Route::group(['middleware' => 'setlang'], function() {
  Route::get('/', 'Front\FrontendController@index')->name('front.index');
  Route::get('/services', 'Front\FrontendController@services')->name('front.services');
  Route::get('/service/{slug}/{id}', 'Front\FrontendController@servicedetails')->name('front.servicedetails');
  Route::get('/packages', 'Front\FrontendController@packages')->name('front.packages');
  Route::get('/portfolios', 'Front\FrontendController@portfolios')->name('front.portfolios');
  Route::get('/portfolio/{slug}/{id}', 'Front\FrontendController@portfoliodetails')->name('front.portfoliodetails');

  Route::get('/blogs', 'Front\FrontendController@blogs')->name('front.blogs');
  Route::get('/blog-details/{slug}/{id}', 'Front\FrontendController@blogdetails')->name('front.blogdetails');

  Route::get('/rss', 'Front\FrontendController@rss')->name('front.rss');
  Route::get('/rss/category/{id}', 'Front\FrontendController@rcatpost')->name('front.rcatpost');
  Route::get('/rss-details/{slug}/{id}', 'Front\FrontendController@rssdetails')->name('front.rssdetails');

  Route::get('/contact', 'Front\FrontendController@contact')->name('front.contact');
  Route::post('/sendmail', 'Front\FrontendController@sendmail')->name('front.sendmail');
  Route::post('/subscribe', 'Front\FrontendController@subscribe')->name('front.subscribe');
  Route::get('/quote', 'Front\FrontendController@quote')->name('front.quote');
  Route::post('/sendquote', 'Front\FrontendController@sendquote')->name('front.sendquote');


  Route::get('/checkout/payment/{slug1}/{slug2}','Front\FrontendController@loadpayment')->name('front.load.payment');


  Route::get('/package-order/{id}', 'Front\FrontendController@packageorder')->name('front.packageorder.index');
  Route::post('/package-order', 'Front\FrontendController@submitorder')->name('front.packageorder.submit');
  Route::get('/order-confirmation/{packageid}/{packageOrderId}', 'Front\FrontendController@orderConfirmation')->name('front.packageorder.confirmation');
  Route::get('/payment/{packageid}/cancle', 'Front\FrontendController@paycancle')->name('front.payment.cancle');
  //Paypal Routes
  Route::post('/paypal/submit', 'Payment\PaypalController@store')->name('front.paypal.submit');
  Route::get('/paypal/{packageid}/notify', 'Payment\PaypalController@notify')->name('front.paypal.notify');
  //Stripe Routes
  Route::post('/stripe/submit', 'Payment\StripeController@store')->name('front.stripe.submit');
  //Paystack Routes
  Route::post('/paystack/submit', 'Payment\PaystackController@store')->name('front.paystack.submit');
  //PayTM Routes
  Route::post('/paytm/submit', 'Payment\PaytmController@store')->name('front.paytm.submit');
  Route::post('/paytm/notify', 'Payment\PaytmController@notify')->name('front.paytm.notify');
  //Flutterwave Routes
  Route::post('/flutterwave/submit', 'Payment\FlutterWaveController@store')->name('front.flutterwave.submit');
  Route::post('/flutterwave/notify', 'Payment\FlutterWaveController@notify')->name('front.flutterwave.notify');
  //Instamojo Routes
  Route::post('/instamojo/submit', 'Payment\InstamojoController@store')->name('front.instamojo.submit');
  Route::get('/instamojo/notify', 'Payment\InstamojoController@notify')->name('front.instamojo.notify');
  //Mollie Routes
  Route::post('/mollie/submit', 'Payment\MollieController@store')->name('front.mollie.submit');
  Route::get('/mollie/notify', 'Payment\MollieController@notify')->name('front.mollie.notify');
  // RazorPay
  Route::post('razorpay/submit', 'Payment\RazorpayController@store')->name('front.razorpay.submit');
  Route::post('razorpay/notify', 'Payment\RazorpayController@notify')->name('front.razorpay.notify');
  // Mercado Pago
  Route::post('mercadopago/submit', 'Payment\MercadopagoController@store')->name('front.mercadopago.submit');
  Route::post('mercadopago/notify', 'Payment\MercadopagoController@notify')->name('front.mercadopago.notify');
  // Payu
  Route::post('/payumoney/submit', 'Payment\PayumoneyController@store')->name('front.payumoney.submit');
  Route::post('/payumoney/notify', 'Payment\PayumoneyController@notify')->name('front.payumoney.notify');
  //Offline Routes
  Route::post('/offline/{oid}/submit', 'Payment\OfflineController@store')->name('front.offline.submit');


  Route::get('/team', 'Front\FrontendController@team')->name('front.team');
  Route::get('/career', 'Front\FrontendController@career')->name('front.career');
  Route::get('/career-details/{slug}/{id}', 'Front\FrontendController@careerdetails')->name('front.careerdetails');
  Route::get('/calendar', 'Front\FrontendController@calendar')->name('front.calendar');
  Route::get('/gallery', 'Front\FrontendController@gallery')->name('front.gallery');
  Route::get('/faq', 'Front\FrontendController@faq')->name('front.faq');
  // Dynamic Page Routes
  Route::get('/{slug}/{id}/page', 'Front\FrontendController@dynamicPage')->name('front.dynamicPage');
  Route::get('/changelanguage/{lang}', 'Front\FrontendController@changeLanguage')->name('changeLanguage');

// Product
  Route::get('/product','Front\ProductController@product')->name('front.product');
  Route::get('/product/{slug}','Front\ProductController@productDetails')->name('front.product.details');
  Route::get('/cart', 'Front\ProductController@cart')->name('front.cart');
  Route::get('/add-to-cart/{id}', 'Front\ProductController@addToCart')->name('add.cart');
  Route::post('/cart/update', 'Front\ProductController@updatecart')->name('cart.update');
  Route::get('/cart/item/remove/{id}', 'Front\ProductController@cartitemremove')->name('cart.item.remove');
  Route::get('/checkout', 'Front\ProductController@checkout')->name('front.checkout');
  Route::get('/checkout/{slug}', 'Front\ProductController@Prdouctcheckout')->name('front.product.checkout');

  // review
  Route::post('product/review/submit','Front\ReviewController@reviewsubmit')->name('product.review.submit');

  // review end

  // CHECKOUT SECTION
  Route::get('/product/payment/return', 'Payment\product\PaymentController@payreturn')->name('product.payment.return');
  Route::get('/product/payment/cancle', 'Payment\product\PaymentController@paycancle')->name('product.payment.cancle');
  Route::get('/product/payment/notify', 'Payment\product\PaymentController@notify')->name('product.payment.notify');
  // paypal routes
  Route::post('/product/paypal/submit', 'Payment\product\PaymentController@store')->name('product.paypal.submit');
  // stripe routes
  Route::post('/product/stripe/submit', 'Payment\product\StripeController@store')->name('product.stripe.submit');
  Route::post('/product/offline/{gatewayid}/submit', 'Payment\product\OfflineController@store')->name('product.offline.submit');
  //Flutterwave Routes
  Route::post('/product/flutterwave/submit', 'Payment\product\FlutterWaveController@store')->name('product.flutterwave.submit');
  Route::post('/product/flutterwave/notify', 'Payment\product\FlutterWaveController@notify')->name('product.flutterwave.notify');
  //Paystack Routes
  Route::post('/product/paystack/submit', 'Payment\product\PaystackController@store')->name('product.paystack.submit');
  // RazorPay
  Route::post('/product/razorpay/submit', 'Payment\product\RazorpayController@store')->name('product.razorpay.submit');
  Route::post('/product/razorpay/notify', 'Payment\product\RazorpayController@notify')->name('product.razorpay.notify');
  //Instamojo Routes
  Route::post('/product/instamojo/submit', 'Payment\product\InstamojoController@store')->name('product.instamojo.submit');
  Route::get('/product/instamojo/notify', 'Payment\product\InstamojoController@notify')->name('product.instamojo.notify');
  //PayTM Routes
  Route::post('/product/paytm/submit', 'Payment\product\PaytmController@store')->name('product.paytm.submit');
  Route::post('/product/paytm/notify', 'Payment\product\PaytmController@notify')->name('product.paytm.notify');
  //Mollie Routes
  Route::post('/product/mollie/submit', 'Payment\product\MollieController@store')->name('product.mollie.submit');
  Route::get('/product/mollie/notify', 'Payment\product\MollieController@notify')->name('product.mollie.notify');
  // Mercado Pago
  Route::post('/product/mercadopago/submit', 'Payment\product\MercadopagoController@store')->name('product.mercadopago.submit');
  Route::post('/product/mercadopago/notify', 'Payment\product\MercadopagoController@notify')->name('product.mercadopago.notify');
  // PayUmoney
  Route::post('/product/payumoney/submit', 'Payment\product\PayumoneyController@store')->name('product.payumoney.submit');
  Route::post('/product/payumoney/notify', 'Payment\product\PayumoneyController@notify')->name('product.payumoney.notify');
  // CHECKOUT SECTION ENDS

  // Product

});
Route::group([ 'middleware' => ['web', 'setlang']], function () {
    Route::get('/login', 'User\LoginController@showLoginForm')->name('user.login');
    Route::post('/login', 'User\LoginController@login')->name('user.login.submit');
    Route::get('/register', 'User\RegisterController@registerPage')->name('user-register');
    Route::post('/register/submit', 'User\RegisterController@register')->name('user-register-submit');
    Route::get('/register/verify/{token}', 'User\RegisterController@token')->name('user-register-token');
    Route::get('/forgot', 'User\ForgotController@showforgotform')->name('user-forgot');
    Route::post('/forgot', 'User\ForgotController@forgot')->name('user-forgot-submit');
});


Route::group(['prefix' => 'user' , 'middleware' => ['auth','userstatus','setlang']], function () {
      // Summernote image upload
      Route::post('/summernote/upload', 'User\SummernoteController@upload')->name('user.summernote.upload');

      Route::get('/dashboard', 'User\UserController@index')->name('user-dashboard');
      Route::get('/reset', 'User\UserController@resetform')->name('user-reset');
      Route::post('/reset', 'User\UserController@reset')->name('user-reset-submit');
      Route::get('/profile', 'User\UserController@profile')->name('user-profile');
      Route::post('/profile', 'User\UserController@profileupdate')->name('user-profile-update');
      Route::get('/logout', 'User\LoginController@logout')->name('user-logout');
      Route::get('/shipping/details', 'User\UserController@shippingdetails')->name('shpping-details');
      Route::post('/shipping/details/update', 'User\UserController@shippingupdate')->name('user-shipping-update');
      Route::get('/billing/details', 'User\UserController@billingdetails')->name('billing-details');
      Route::post('/billing/details/update', 'User\UserController@billingupdate')->name('billing-update');
      Route::get('/orders', 'User\OrderController@index')->name('user-orders');
      Route::get('/order/{id}', 'User\OrderController@orderdetails')->name('user-orders-details');
      Route::get('/tickets', 'User\TicketController@index')->name('user-tickets');
      Route::get('/ticket/create', 'User\TicketController@create')->name('user-ticket-create');
      Route::get('/ticket/messages/{id}', 'User\TicketController@messages')->name('user-ticket-messages');
      Route::post('/ticket/store/', 'User\TicketController@ticketstore')->name('user.ticket.store');
      Route::post('/ticket/reply/{id}', 'User\TicketController@ticketreply')->name('user.ticket.reply');
      Route::post('/zip-file/upload', 'User\TicketController@zip_upload')->name('zip.upload');



});





/*=======================================================
******************** Admin Routes **********************
=======================================================*/

Route::group(['prefix' => 'admin', 'middleware' => 'guest:admin'], function () {
  Route::get('/', 'Admin\LoginController@login')->name('admin.login');
  Route::post('/login', 'Admin\LoginController@authenticate')->name('admin.auth');

  Route::get('/mail-form', 'Admin\ForgetController@mailForm')->name('admin.forget.form');
  Route::post('/sendmail', 'Admin\ForgetController@sendmail')->name('admin.forget.mail');
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin', 'checkstatus']], function () {

  // RTL check
  Route::get('/rtlcheck/{langid}', 'Admin\LanguageController@rtlcheck')->name('admin.rtlcheck');

  // Summernote image upload
  Route::post('/summernote/upload', 'Admin\SummernoteController@upload')->name('admin.summernote.upload');

  // Admin logout Route
  Route::get('/logout', 'Admin\LoginController@logout')->name('admin.logout');

  Route::group(['middleware' => 'checkpermission:Dashboard'], function() {
    // Admin Dashboard Routes
    Route::get('/dashboard', 'Admin\DashboardController@dashboard')->name('admin.dashboard');
  });


  // Admin Profile Routes
  Route::get('/changePassword', 'Admin\ProfileController@changePass')->name('admin.changePass');
  Route::post('/profile/updatePassword', 'Admin\ProfileController@updatePassword')->name('admin.updatePassword');
  Route::get('/profile/edit', 'Admin\ProfileController@editProfile')->name('admin.editProfile');
  Route::post('/propic/update', 'Admin\ProfileController@updatePropic')->name('admin.propic.update');
  Route::post('/profile/update', 'Admin\ProfileController@updateProfile')->name('admin.updateProfile');


  Route::group(['middleware' => 'checkpermission:Basic Settings'], function() {
    // Admin Favicon Routes
    Route::get('/favicon', 'Admin\BasicController@favicon')->name('admin.favicon');
    Route::post('/favicon/{langid}/post', 'Admin\BasicController@updatefav')->name('admin.favicon.update');


    // Admin Logo Routes
    Route::get('/logo', 'Admin\BasicController@logo')->name('admin.logo');
    Route::post('/logo/{langid}/post', 'Admin\BasicController@updatelogo')->name('admin.logo.update');


    // Admin Scripts Routes
    Route::get('/feature/settings', 'Admin\BasicController@featuresettings')->name('admin.featuresettings');
    Route::post('/feature/settings/update', 'Admin\BasicController@updatefeatrue')->name('admin.featuresettings.update');



    // Admin Theme Version Setting Routes
    Route::get('/themeversion', 'Admin\BasicController@themeversion')->name('admin.themeversion');
    Route::post('/themeversion/post', 'Admin\BasicController@updatethemeversion')->name('admin.themeversion.update');


    // Admin Home Version Setting Routes
    Route::get('/homeversion', 'Admin\BasicController@homeversion')->name('admin.homeversion');
    Route::post('/homeversion/{langid}/post', 'Admin\BasicController@updatehomeversion')->name('admin.homeversion.update');


    // Admin Basic Information Routes
    Route::get('/basicinfo', 'Admin\BasicController@basicinfo')->name('admin.basicinfo');
    Route::post('/basicinfo/{langid}/post', 'Admin\BasicController@updatebasicinfo')->name('admin.basicinfo.update');


    // Admin Email Settings Routes
    Route::get('/mail-from-admin', 'Admin\EmailController@mailFromAdmin')->name('admin.mailFromAdmin');
    Route::post('/mail-from-admin/update', 'Admin\EmailController@updateMailFromAdmin')->name('admin.mailfromadmin.update');
    Route::get('/mail-to-admin', 'Admin\EmailController@mailToAdmin')->name('admin.mailToAdmin');
    Route::post('/mail-to-admin/update', 'Admin\EmailController@updateMailToAdmin')->name('admin.mailtoadmin.update');


    // Admin Support Routes
    Route::get('/support', 'Admin\BasicController@support')->name('admin.support');
    Route::post('/support/{langid}/post', 'Admin\BasicController@updatesupport')->name('admin.support.update');

    // Admin Breadcrumb Routes
    Route::get('/breadcrumb', 'Admin\BasicController@breadcrumb')->name('admin.breadcrumb');
    Route::post('/breadcrumb/{langid}/update', 'Admin\BasicController@updatebreadcrumb')->name('admin.breadcrumb.update');


    // Admin Page Heading Routes
    Route::get('/heading', 'Admin\BasicController@heading')->name('admin.heading');
    Route::post('/heading/{langid}/update', 'Admin\BasicController@updateheading')->name('admin.heading.update');


    // Admin Scripts Routes
    Route::get('/script', 'Admin\BasicController@script')->name('admin.script');
    Route::post('/script/update', 'Admin\BasicController@updatescript')->name('admin.script.update');

    // Admin Social Routes
    Route::get('/social', 'Admin\SocialController@index')->name('admin.social.index');
    Route::post('/social/store', 'Admin\SocialController@store')->name('admin.social.store');
    Route::get('/social/{id}/edit', 'Admin\SocialController@edit')->name('admin.social.edit');
    Route::post('/social/update', 'Admin\SocialController@update')->name('admin.social.update');
    Route::post('/social/delete', 'Admin\SocialController@delete')->name('admin.social.delete');

    // Admin SEO Information Routes
    Route::get('/seo', 'Admin\BasicController@seo')->name('admin.seo');
    Route::post('/seo/{langid}/update', 'Admin\BasicController@updateseo')->name('admin.seo.update');


    // Admin Maintanance Mode Routes
    Route::get('/maintainance', 'Admin\BasicController@maintainance')->name('admin.maintainance');
    Route::post('/maintainance/update', 'Admin\BasicController@updatemaintainance')->name('admin.maintainance.update');
    Route::post('/maintainance/upload', 'Admin\BasicController@uploadmaintainance')->name('admin.maintainance.upload');


    // Admin Offer Banner Routes
    Route::get('/announcement', 'Admin\BasicController@announcement')->name('admin.announcement');
    Route::post('/announcement/{langid}/update', 'Admin\BasicController@updateannouncement')->name('admin.announcement.update');
    Route::post('/announcement/{langid}/upload', 'Admin\BasicController@uploadannouncement')->name('admin.announcement.upload');


    // Admin Section Customization Routes
    Route::get('/sections', 'Admin\BasicController@sections')->name('admin.sections.index');
    Route::post('/sections/update', 'Admin\BasicController@updatesections')->name('admin.sections.update');


    // Admin Cookie Alert Routes
    Route::get('/cookie-alert', 'Admin\BasicController@cookiealert')->name('admin.cookie.alert');
    Route::post('/cookie-alert/{langid}/update', 'Admin\BasicController@updatecookie')->name('admin.cookie.update');
  });




  Route::group(['middleware' => 'checkpermission:Subscribers'], function() {
    // Admin Subscriber Routes
    Route::get('/subscribers', 'Admin\SubscriberController@index')->name('admin.subscriber.index');
    Route::get('/mailsubscriber', 'Admin\SubscriberController@mailsubscriber')->name('admin.mailsubscriber');
    Route::post('/subscribers/sendmail', 'Admin\SubscriberController@subscsendmail')->name('admin.subscribers.sendmail');
  });


  Route::group(['middleware' => 'checkpermission:Home Page'], function() {
    // Admin Hero Section (Static Version) Routes
    Route::get('/herosection/static', 'Admin\HerosectionController@static')->name('admin.herosection.static');
    Route::post('/herosection/{langid}/upload', 'Admin\HerosectionController@upload')->name('admin.herosection.upload');
    Route::post('/herosection/{langid}/update', 'Admin\HerosectionController@update')->name('admin.herosection.update');


    // Admin Hero Section (Slider Version) Routes
    Route::get('/herosection/sliders', 'Admin\SliderController@index')->name('admin.slider.index');
    Route::post('/herosection/slider/store', 'Admin\SliderController@store')->name('admin.slider.store');
    Route::post('/herosection/sliderupload', 'Admin\SliderController@upload')->name('admin.slider.upload');
    Route::get('/herosection/slider/{id}/edit', 'Admin\SliderController@edit')->name('admin.slider.edit');
    Route::post('/herosection/sliderupdate', 'Admin\SliderController@update')->name('admin.slider.update');
    Route::post('/herosection/slider/{id}/uploadUpdate', 'Admin\SliderController@uploadUpdate')->name('admin.slider.uploadUpdate');
    Route::post('/herosection/slider/delete', 'Admin\SliderController@delete')->name('admin.slider.delete');


    // Admin Hero Section (Video Version) Routes
    Route::get('/herosection/video', 'Admin\HerosectionController@video')->name('admin.herosection.video');
    Route::post('/herosection/video/{langid}/update', 'Admin\HerosectionController@videoupdate')->name('admin.herosection.video.update');


    // Admin Hero Section (Parallax Version) Routes
    Route::get('/herosection/parallax', 'Admin\HerosectionController@parallax')->name('admin.herosection.parallax');
    Route::post('/herosection/parallax/update', 'Admin\HerosectionController@parallaxupdate')->name('admin.herosection.parallax.update');



    // Admin Partner Routes
    Route::get('/partners', 'Admin\PartnerController@index')->name('admin.partner.index');
    Route::post('/partner/store', 'Admin\PartnerController@store')->name('admin.partner.store');
    Route::post('/partner/upload', 'Admin\PartnerController@upload')->name('admin.partner.upload');
    Route::get('/partner/{id}/edit', 'Admin\PartnerController@edit')->name('admin.partner.edit');
    Route::post('/partner/update', 'Admin\PartnerController@update')->name('admin.partner.update');
    Route::post('/partner/{id}/uploadUpdate', 'Admin\PartnerController@uploadUpdate')->name('admin.partner.uploadUpdate');
    Route::post('/partner/delete', 'Admin\PartnerController@delete')->name('admin.partner.delete');



    // Admin Feature Routes
    Route::get('/features', 'Admin\FeatureController@index')->name('admin.feature.index');
    Route::post('/feature/store', 'Admin\FeatureController@store')->name('admin.feature.store');
    Route::get('/feature/{id}/edit', 'Admin\FeatureController@edit')->name('admin.feature.edit');
    Route::post('/feature/update', 'Admin\FeatureController@update')->name('admin.feature.update');
    Route::post('/feature/delete', 'Admin\FeatureController@delete')->name('admin.feature.delete');

    // Admin Intro Section Routes
    Route::get('/introsection', 'Admin\IntrosectionController@index')->name('admin.introsection.index');
    Route::post('/introsection/{langid}/upload', 'Admin\IntrosectionController@upload')->name('admin.introsection.upload');
    Route::post('/introsection/{langid}/upload2', 'Admin\IntrosectionController@upload2')->name('admin.introsection.upload2');
    Route::post('/introsection/{langid}/update', 'Admin\IntrosectionController@update')->name('admin.introsection.update');

    // Admin Service Section Routes
    Route::get('/servicesection', 'Admin\ServicesectionController@index')->name('admin.servicesection.index');
    Route::post('/servicesection/{langid}/update', 'Admin\ServicesectionController@update')->name('admin.servicesection.update');

    // Admin Approach Section Routes
    Route::get('/approach', 'Admin\ApproachController@index')->name('admin.approach.index');
    Route::post('/approach/store', 'Admin\ApproachController@store')->name('admin.approach.point.store');
    Route::get('/approach/{id}/pointedit', 'Admin\ApproachController@pointedit')->name('admin.approach.point.edit');
    Route::post('/approach/{langid}/update', 'Admin\ApproachController@update')->name('admin.approach.update');
    Route::post('/approach/pointupdate', 'Admin\ApproachController@pointupdate')->name('admin.approach.point.update');
    Route::post('/approach/pointdelete', 'Admin\ApproachController@pointdelete')->name('admin.approach.pointdelete');


    // Admin Statistic Section Routes
    Route::get('/statistics', 'Admin\StatisticsController@index')->name('admin.statistics.index');
    Route::post('/statistics/{langid}/upload', 'Admin\StatisticsController@upload')->name('admin.statistics.upload');
    Route::post('/statistics/store', 'Admin\StatisticsController@store')->name('admin.statistics.store');
    Route::get('/statistics/{id}/edit', 'Admin\StatisticsController@edit')->name('admin.statistics.edit');
    Route::post('/statistics/update', 'Admin\StatisticsController@update')->name('admin.statistics.update');
    Route::post('/statistics/delete', 'Admin\StatisticsController@delete')->name('admin.statistics.delete');


    // Admin Call to Action Section Routes
    Route::get('/cta', 'Admin\CtaController@index')->name('admin.cta.index');
    Route::post('/cta/{langid}/upload', 'Admin\CtaController@upload')->name('admin.cta.upload');
    Route::post('/cta/{langid}/update', 'Admin\CtaController@update')->name('admin.cta.update');

    // Admin Portfolio Section Routes
    Route::get('/portfoliosection', 'Admin\PortfoliosectionController@index')->name('admin.portfoliosection.index');
    Route::post('/portfoliosection/{langid}/update', 'Admin\PortfoliosectionController@update')->name('admin.portfoliosection.update');

    // Admin Testimonial Routes
    Route::get('/testimonials', 'Admin\TestimonialController@index')->name('admin.testimonial.index');
    Route::get('/testimonial/create', 'Admin\TestimonialController@create')->name('admin.testimonial.create');
    Route::post('/testimonial/upload', 'Admin\TestimonialController@upload')->name('admin.testimonial.upload');
    Route::post('/testimonial/store', 'Admin\TestimonialController@store')->name('admin.testimonial.store');
    Route::get('/testimonial/{id}/edit', 'Admin\TestimonialController@edit')->name('admin.testimonial.edit');
    Route::post('/testimonial/update', 'Admin\TestimonialController@update')->name('admin.testimonial.update');
    Route::post('/testimonial/{id}/uploadUpdate', 'Admin\TestimonialController@uploadUpdate')->name('admin.testimonial.uploadUpdate');
    Route::post('/testimonial/delete', 'Admin\TestimonialController@delete')->name('admin.testimonial.delete');
    Route::post('/testimonialtext/{langid}/update', 'Admin\TestimonialController@textupdate')->name('admin.testimonialtext.update');

    // Admin Blog Section Routes
    Route::get('/blogsection', 'Admin\BlogsectionController@index')->name('admin.blogsection.index');
    Route::post('/blogsection/{langid}/update', 'Admin\BlogsectionController@update')->name('admin.blogsection.update');

    // Admin Partner Routes
    Route::get('/partners', 'Admin\PartnerController@index')->name('admin.partner.index');
    Route::post('/partner/store', 'Admin\PartnerController@store')->name('admin.partner.store');
    Route::post('/partner/upload', 'Admin\PartnerController@upload')->name('admin.partner.upload');
    Route::get('/partner/{id}/edit', 'Admin\PartnerController@edit')->name('admin.partner.edit');
    Route::post('/partner/update', 'Admin\PartnerController@update')->name('admin.partner.update');
    Route::post('/partner/{id}/uploadUpdate', 'Admin\PartnerController@uploadUpdate')->name('admin.partner.uploadUpdate');
    Route::post('/partner/delete', 'Admin\PartnerController@delete')->name('admin.partner.delete');

    // Admin Member Routes
    Route::get('/members', 'Admin\MemberController@index')->name('admin.member.index');
    Route::post('/team/{langid}/upload', 'Admin\MemberController@teamUpload')->name('admin.team.upload');
    Route::post('/member/upload', 'Admin\MemberController@upload')->name('admin.member.upload');
    Route::get('/member/create', 'Admin\MemberController@create')->name('admin.member.create');
    Route::post('/member/store', 'Admin\MemberController@store')->name('admin.member.store');
    Route::get('/member/{id}/edit', 'Admin\MemberController@edit')->name('admin.member.edit');
    Route::post('/member/update', 'Admin\MemberController@update')->name('admin.member.update');
    Route::post('/member/{id}/uploadUpdate', 'Admin\MemberController@uploadUpdate')->name('admin.member.uploadUpdate');
    Route::post('/member/delete', 'Admin\MemberController@delete')->name('admin.member.delete');
    Route::post('/teamtext/{langid}/update', 'Admin\MemberController@textupdate')->name('admin.teamtext.update');
    Route::post('/member/feature', 'Admin\MemberController@feature')->name('admin.member.feature');


    // Admin Package Background Routes
    Route::get('/package/background', 'Admin\PackageController@background')->name('admin.package.background');
    Route::post('/package/{langid}/background-upload', 'Admin\PackageController@uploadBackground')->name('admin.package.background.upload');
  });

  Route::group(['middleware' => 'checkpermission:Menu Builder'], function () {
      Route::get('/menu-builder','Admin\MenuBuilderController@index')->name('admin.menu_builder.index');
      Route::post('/menu-builder/update','Admin\MenuBuilderController@update')->name('admin.menu_builder.update');
  });



  // Admin FAQ Routes
  Route::get('/faqs', 'Admin\FaqController@index')->name('admin.faq.index');
  Route::get('/faq/create', 'Admin\FaqController@create')->name('admin.faq.create');
  Route::post('/faq/store', 'Admin\FaqController@store')->name('admin.faq.store');
  Route::get('/faq/{id}/edit', 'Admin\FaqController@edit')->name('admin.faq.edit');
  Route::post('/faq/update', 'Admin\FaqController@update')->name('admin.faq.update');
  Route::post('/faq/delete', 'Admin\FaqController@delete')->name('admin.faq.delete');
  Route::post('/faq/bulk-delete', 'Admin\FaqController@bulkDelete')->name('admin.faq.bulk.delete');



  Route::group(['middleware' => 'checkpermission:Pages'], function() {
    // Menu Manager Routes
    Route::get('/pages', 'Admin\PageController@index')->name('admin.page.index');
    Route::get('/page/create', 'Admin\PageController@create')->name('admin.page.create');
    Route::post('/page/store', 'Admin\PageController@store')->name('admin.page.store');
    Route::get('/page/{menuID}/edit', 'Admin\PageController@edit')->name('admin.page.edit');
    Route::post('/page/update', 'Admin\PageController@update')->name('admin.page.update');
    Route::post('/page/delete', 'Admin\PageController@delete')->name('admin.page.delete');
    Route::post('/page/bulk-delete', 'Admin\PageController@bulkDelete')->name('admin.page.bulk.delete');
  });



  Route::group(['middleware' => 'checkpermission:Footer'], function() {
    // Admin Footer Logo Text Routes
    Route::get('/footers', 'Admin\FooterController@index')->name('admin.footer.index');
    Route::post('/footer/{langid}/upload', 'Admin\FooterController@upload')->name('admin.footer.upload');
    Route::post('/footer/{langid}/update', 'Admin\FooterController@update')->name('admin.footer.update');



    // Admin Ulink Routes
    Route::get('/ulinks', 'Admin\UlinkController@index')->name('admin.ulink.index');
    Route::get('/ulink/create', 'Admin\UlinkController@create')->name('admin.ulink.create');
    Route::post('/ulink/store', 'Admin\UlinkController@store')->name('admin.ulink.store');
    Route::get('/ulink/{id}/edit', 'Admin\UlinkController@edit')->name('admin.ulink.edit');
    Route::post('/ulink/update', 'Admin\UlinkController@update')->name('admin.ulink.update');
    Route::post('/ulink/delete', 'Admin\UlinkController@delete')->name('admin.ulink.delete');
  });




  Route::group(['middleware' => 'checkpermission:Service Page'], function() {
    // Admin Service Category Routes
    Route::get('/scategorys', 'Admin\ScategoryController@index')->name('admin.scategory.index');
    Route::post('/scategory/upload', 'Admin\ScategoryController@upload')->name('admin.scategory.upload');
    Route::post('/scategory/store', 'Admin\ScategoryController@store')->name('admin.scategory.store');
    Route::get('/scategory/{id}/edit', 'Admin\ScategoryController@edit')->name('admin.scategory.edit');
    Route::post('/scategory/update', 'Admin\ScategoryController@update')->name('admin.scategory.update');
    Route::post('/scategory/{id}/uploadUpdate', 'Admin\ScategoryController@uploadUpdate')->name('admin.scategory.uploadUpdate');
    Route::post('/scategory/delete', 'Admin\ScategoryController@delete')->name('admin.scategory.delete');
    Route::post('/scategory/bulk-delete', 'Admin\ScategoryController@bulkDelete')->name('admin.scategory.bulk.delete');
    Route::post('/scategory/feature', 'Admin\ScategoryController@feature')->name('admin.scategory.feature');

    // Admin Services Routes
    Route::get('/services', 'Admin\ServiceController@index')->name('admin.service.index');
    Route::post('/service/upload', 'Admin\ServiceController@upload')->name('admin.service.upload');
    Route::post('/service/{id}/uploadUpdate', 'Admin\ServiceController@uploadUpdate')->name('admin.service.uploadUpdate');
    Route::post('/service/store', 'Admin\ServiceController@store')->name('admin.service.store');
    Route::get('/service/{id}/edit', 'Admin\ServiceController@edit')->name('admin.service.edit');
    Route::post('/service/update', 'Admin\ServiceController@update')->name('admin.service.update');
    Route::post('/service/delete', 'Admin\ServiceController@delete')->name('admin.service.delete');
    Route::post('/service/bulk-delete', 'Admin\ServiceController@bulkDelete')->name('admin.service.bulk.delete');
    Route::get('/service/{langid}/getcats', 'Admin\ServiceController@getcats')->name('admin.service.getcats');
    Route::post('/service/feature', 'Admin\ServiceController@feature')->name('admin.service.feature');
  });



  Route::group(['middleware' => 'checkpermission:Product Management'], function() {
  Route::get('/category', 'Admin\ProductCategory@index')->name('admin.category.index');
  Route::post('/category/store', 'Admin\ProductCategory@store')->name('admin.category.store');
  Route::get('/category/{id}/edit', 'Admin\ProductCategory@edit')->name('admin.category.edit');
  Route::post('/category/update', 'Admin\ProductCategory@update')->name('admin.category.update');
  Route::post('/category/delete', 'Admin\ProductCategory@delete')->name('admin.category.delete');

  Route::post('/category/bulk-delete', 'Admin\ProductCategory@bulkDelete')->name('admin.pcategory.bulk.delete');

  Route::get('/shipping', 'Admin\ShopSettingController@index')->name('admin.shipping.index');
  Route::post('/shipping/store', 'Admin\ShopSettingController@store')->name('admin.shipping.store');
  Route::get('/shipping/{id}/edit', 'Admin\ShopSettingController@edit')->name('admin.shipping.edit');
  Route::post('/shipping/update', 'Admin\ShopSettingController@update')->name('admin.shipping.update');
  Route::post('/shipping/delete', 'Admin\ShopSettingController@delete')->name('admin.shipping.delete');


  Route::get('/product', 'Admin\ProductController@index')->name('admin.product.index');
  Route::get('/product/create', 'Admin\ProductController@create')->name('admin.product.create');
  Route::post('/product/store', 'Admin\ProductController@store')->name('admin.product.store');
  Route::get('/product/{id}/edit', 'Admin\ProductController@edit')->name('admin.product.edit');
  Route::post('/product/update', 'Admin\ProductController@update')->name('admin.product.update');
  Route::post('/product/delete', 'Admin\ProductController@delete')->name('admin.product.delete');
  Route::get('/product/populer/tags/', 'Admin\ProductController@populerTag')->name('admin.product.tags');
  Route::post('/product/populer/tags/update', 'Admin\ProductController@populerTagupdate')->name('admin.popular-tag.update');



  Route::post('/product/sliderstore', 'Admin\ProductController@sliderstore')->name('admin.product.sliderstore');
  Route::post('/product/sliderrmv', 'Admin\ProductController@sliderrmv')->name('admin.product.sliderrmv');
  Route::post('/product/upload', 'Admin\ProductController@upload')->name('admin.product.upload');
  Route::get('product/{id}/getcategory', 'Admin\ProductController@getCategory')->name('admin.product.getcategory');
  Route::post('/product/delete', 'Admin\ProductController@delete')->name('admin.product.delete');
  Route::post('/product/bulk-delete', 'Admin\ProductController@bulkDelete')->name('admin.product.bulk.delete');
  Route::post('/product/sliderupdate', 'Admin\ProductController@sliderupdate')->name('admin.product.sliderupdate');
  Route::post('/product/{id}/uploadUpdate', 'Admin\ProductController@uploadUpdate')->name('admin.product.uploadUpdate');
  Route::post('/product/update', 'Admin\ProductController@update')->name('admin.product.update');
  Route::get('/product/{id}/images', 'Admin\ProductController@images')->name('admin.product.images');



  // Product Order
  Route::get('/product/all/orders', 'Admin\ProductOrderController@all')->name('admin.all.product.orders');
  Route::get('/product/pending/orders', 'Admin\ProductOrderController@pending')->name('admin.pending.product.orders');
  Route::get('/product/processing/orders', 'Admin\ProductOrderController@processing')->name('admin.processing.product.orders');
  Route::get('/product/completed/orders', 'Admin\ProductOrderController@completed')->name('admin.completed.product.orders');
  Route::get('/product/rejected/orders', 'Admin\ProductOrderController@rejected')->name('admin.rejected.product.orders');
  Route::post('/product/orders/status', 'Admin\ProductOrderController@status')->name('admin.product.orders.status');
  Route::get('/product/orders/detais/{id}', 'Admin\ProductOrderController@details')->name('admin.product.details');
  Route::post('/product/order/delete', 'Admin\ProductOrderController@orderDelete')->name('admin.product.order.delete');
  Route::post('/product/order/bulk-delete', 'Admin\ProductOrderController@bulkOrderDelete')->name('admin.product.order.bulk.delete');
  // Product Order end
});




// Register User start
  Route::get('register/users','Admin\RegisterUserController@index')->name('admin.register.user');
  Route::post('register/users/ban','Admin\RegisterUserController@userban')->name('register.user.ban');
  Route::get('register/user/details/{id}','Admin\RegisterUserController@view')->name('register.user.view');
//Register User end



  Route::group(['middleware' => 'checkpermission:Portfolio Management'], function() {
    // Admin Portfolio Routes
    Route::get('/portfolios', 'Admin\PortfolioController@index')->name('admin.portfolio.index');
    Route::get('/portfolio/create', 'Admin\PortfolioController@create')->name('admin.portfolio.create');
    Route::post('/portfolio/sliderstore', 'Admin\PortfolioController@sliderstore')->name('admin.portfolio.sliderstore');
    Route::post('/portfolio/sliderrmv', 'Admin\PortfolioController@sliderrmv')->name('admin.portfolio.sliderrmv');
    Route::post('/portfolio/upload', 'Admin\PortfolioController@upload')->name('admin.portfolio.upload');
    Route::post('/portfolio/store', 'Admin\PortfolioController@store')->name('admin.portfolio.store');
    Route::get('/portfolio/{id}/edit', 'Admin\PortfolioController@edit')->name('admin.portfolio.edit');
    Route::get('/portfolio/{id}/images', 'Admin\PortfolioController@images')->name('admin.portfolio.images');
    Route::post('/portfolio/sliderupdate', 'Admin\PortfolioController@sliderupdate')->name('admin.portfolio.sliderupdate');
    Route::post('/portfolio/{id}/uploadUpdate', 'Admin\PortfolioController@uploadUpdate')->name('admin.portfolio.uploadUpdate');
    Route::post('/portfolio/update', 'Admin\PortfolioController@update')->name('admin.portfolio.update');
    Route::post('/portfolio/delete', 'Admin\PortfolioController@delete')->name('admin.portfolio.delete');
    Route::post('/portfolio/bulk-delete', 'Admin\PortfolioController@bulkDelete')->name('admin.portfolio.bulk.delete');
    Route::get('portfolio/{id}/getservices', 'Admin\PortfolioController@getservices')->name('admin.portfolio.getservices');
    Route::post('/portfolio/feature', 'Admin\PortfolioController@feature')->name('admin.portfolio.feature');
  });



  Route::group(['middleware' => 'checkpermission:Career Page'], function() {
    // Admin Job Category Routes
    Route::get('/jcategorys', 'Admin\JcategoryController@index')->name('admin.jcategory.index');
    Route::post('/jcategory/store', 'Admin\JcategoryController@store')->name('admin.jcategory.store');
    Route::get('/jcategory/{id}/edit', 'Admin\JcategoryController@edit')->name('admin.jcategory.edit');
    Route::post('/jcategory/update', 'Admin\JcategoryController@update')->name('admin.jcategory.update');
    Route::post('/jcategory/delete', 'Admin\JcategoryController@delete')->name('admin.jcategory.delete');
    Route::post('/jcategory/bulk-delete', 'Admin\JcategoryController@bulkDelete')->name('admin.jcategory.bulk.delete');

    // Admin Jobs Routes
    Route::get('/jobs', 'Admin\JobController@index')->name('admin.job.index');
    Route::get('/job/create', 'Admin\JobController@create')->name('admin.job.create');
    Route::post('/job/store', 'Admin\JobController@store')->name('admin.job.store');
    Route::get('/job/{id}/edit', 'Admin\JobController@edit')->name('admin.job.edit');
    Route::post('/job/update', 'Admin\JobController@update')->name('admin.job.update');
    Route::post('/job/delete', 'Admin\JobController@delete')->name('admin.job.delete');
    Route::post('/job/bulk-delete', 'Admin\JobController@bulkDelete')->name('admin.job.bulk.delete');
    Route::get('/job/{langid}/getcats', 'Admin\JobController@getcats')->name('admin.job.getcats');
  });



    // Admin Event Calendar Routes
    Route::group(['middleware' => 'checkpermission:Event Calendar'], function() {
        Route::get('/calendars', 'Admin\CalendarController@index')->name('admin.calendar.index');
        Route::post('/calendar/store', 'Admin\CalendarController@store')->name('admin.calendar.store');
        Route::post('/calendar/update', 'Admin\CalendarController@update')->name('admin.calendar.update');
        Route::post('/calendar/delete', 'Admin\CalendarController@delete')->name('admin.calendar.delete');
        Route::post('/calendar/bulk-delete', 'Admin\CalendarController@bulkDelete')->name('admin.calendar.bulk.delete');
    });



  Route::group(['middleware' => 'checkpermission:Gallery Management'], function() {
    // Admin Gallery Routes
    Route::get('/gallery', 'Admin\GalleryController@index')->name('admin.gallery.index');
    Route::post('/gallery/upload', 'Admin\GalleryController@upload')->name('admin.gallery.upload');
    Route::post('/gallery/store', 'Admin\GalleryController@store')->name('admin.gallery.store');
    Route::get('/gallery/{id}/edit', 'Admin\GalleryController@edit')->name('admin.gallery.edit');
    Route::post('/gallery/update', 'Admin\GalleryController@update')->name('admin.gallery.update');
    Route::post('/gallery/{id}/uploadUpdate', 'Admin\GalleryController@uploadUpdate')->name('admin.gallery.uploadUpdate');
    Route::post('/gallery/delete', 'Admin\GalleryController@delete')->name('admin.gallery.delete');
    Route::post('/gallery/bulk-delete', 'Admin\GalleryController@bulkDelete')->name('admin.gallery.bulk.delete');
  });


  Route::group(['middleware' => 'checkpermission:Blogs'], function() {
    // Admin Blog Category Routes
    Route::get('/bcategorys', 'Admin\BcategoryController@index')->name('admin.bcategory.index');
    Route::post('/bcategory/store', 'Admin\BcategoryController@store')->name('admin.bcategory.store');
    Route::post('/bcategory/update', 'Admin\BcategoryController@update')->name('admin.bcategory.update');
    Route::post('/bcategory/delete', 'Admin\BcategoryController@delete')->name('admin.bcategory.delete');
    Route::post('/bcategory/bulk-delete', 'Admin\BcategoryController@bulkDelete')->name('admin.bcategory.bulk.delete');



    // Admin Blog Routes
    Route::get('/blogs', 'Admin\BlogController@index')->name('admin.blog.index');
    Route::post('/blog/upload', 'Admin\BlogController@upload')->name('admin.blog.upload');
    Route::post('/blog/store', 'Admin\BlogController@store')->name('admin.blog.store');
    Route::get('/blog/{id}/edit', 'Admin\BlogController@edit')->name('admin.blog.edit');
    Route::post('/blog/update', 'Admin\BlogController@update')->name('admin.blog.update');
    Route::post('/blog/{id}/uploadUpdate', 'Admin\BlogController@uploadUpdate')->name('admin.blog.uploadUpdate');
    Route::post('/blog/delete', 'Admin\BlogController@delete')->name('admin.blog.delete');
    Route::post('/blog/bulk-delete', 'Admin\BlogController@bulkDelete')->name('admin.blog.bulk.delete');
    Route::get('/blog/{langid}/getcats', 'Admin\BlogController@getcats')->name('admin.blog.getcats');


    // Admin Blog Archive Routes
    Route::get('/archives', 'Admin\ArchiveController@index')->name('admin.archive.index');
    Route::post('/archive/store', 'Admin\ArchiveController@store')->name('admin.archive.store');
    Route::post('/archive/update', 'Admin\ArchiveController@update')->name('admin.archive.update');
    Route::post('/archive/delete', 'Admin\ArchiveController@delete')->name('admin.archive.delete');
  });


  Route::group(['middleware' => 'checkpermission:RSS Feeds'], function() {
    // Admin RSS feed Routes
    Route::get('/rss','Admin\RssFeedsController@index')->name('admin.rss.index');
    Route::get('/rss/feeds','Admin\RssFeedsController@feed')->name('admin.rss.feed');
    Route::get('/rss/create','Admin\RssFeedsController@create')->name('admin.rss.create');
    Route::post('/rss','Admin\RssFeedsController@store')->name('admin.rss.store');
    Route::get('/rss/edit/{id}','Admin\RssFeedsController@edit')->name('admin.rss.edit');
    Route::post('/rss/update','Admin\RssFeedsController@update')->name('admin.rss.update');
    Route::post('/rss/delete','Admin\RssFeedsController@rssdelete')->name('admin.rssfeed.delete');
    Route::post('/rss/feed/delete','Admin\RssFeedsController@delete')->name('admin.rss.delete');
    Route::post('/rss-posts/bulk/delete','Admin\RssFeedsController@bulkDelete')->name('admin.rss.bulk.delete');

    Route::get('rss-feed/update/{id}','Admin\RssFeedsController@feedUpdate')->name('admin.rss.feedUpdate');
    Route::get('rss-feed/cronJobUpdate','Admin\RssFeedsController@cronJobUpdate')->name('rss.cronJobUpdate');
  });


  Route::group(['middleware' => 'checkpermission:Sitemap'], function() {

      Route::get('/sitemap','Admin\SitemapController@index')->name('admin.sitemap.index');
      Route::post('/sitemap/store', 'Admin\SitemapController@store')->name('admin.sitemap.store');
      Route::get('/sitemap/{id}/update', 'Admin\SitemapController@update')->name('admin.sitemap.update');
      Route::post('/sitemap/{id}/delete', 'Admin\SitemapController@delete')->name('admin.sitemap.delete');
      Route::post('/sitemap/download', 'Admin\SitemapController@download')->name('admin.sitemap.download');
  });


  Route::group(['middleware' => 'checkpermission:Contact Page'], function() {
    // Admin Contact Routes
    Route::get('/contact', 'Admin\ContactController@index')->name('admin.contact.index');
    Route::post('/contact/{langid}/post', 'Admin\ContactController@update')->name('admin.contact.update');
  });


  Route::group(['middleware' => 'checkpermission:Tickets'], function() {
    // Admin Support Ticket Routes
    Route::get('/all/tickets', 'Admin\TicketController@all')->name('admin.tickets.all');
    Route::get('/pending/tickets', 'Admin\TicketController@pending')->name('admin.tickets.pending');
    Route::get('/open/tickets', 'Admin\TicketController@open')->name('admin.tickets.open');
    Route::get('/closed/tickets', 'Admin\TicketController@closed')->name('admin.tickets.closed');
    Route::get('/ticket/messages/{id}', 'Admin\TicketController@messages')->name('admin.ticket.messages');
    Route::post('/zip-file/upload/', 'Admin\TicketController@zip_file_upload')->name('admin.zip_file.upload');
    Route::post('/ticket/reply/{id}', 'Admin\TicketController@ticketReply')->name('admin.ticket.reply');
    Route::get('/ticket/close/{id}', 'Admin\TicketController@ticketclose')->name('admin.ticket.close');
    Route::post('/ticket/assign/staff', 'Admin\TicketController@ticketAssign')->name('ticket.assign.staff');
  });


  Route::group(['middleware' => 'checkpermission:Packages'], function() {

    // Admin Package Form Builder Routes
    Route::get('/package/form', 'Admin\PackageController@form')->name('admin.package.form');
    Route::post('/package/form/store', 'Admin\PackageController@formstore')->name('admin.package.form.store');
    Route::post('/package/inputDelete', 'Admin\PackageController@inputDelete')->name('admin.package.inputDelete');
    Route::get('/package/{id}/inputEdit', 'Admin\PackageController@inputEdit')->name('admin.package.inputEdit');
    Route::get('/package/{id}/options', 'Admin\PackageController@options')->name('admin.package.options');
    Route::post('/package/inputUpdate', 'Admin\PackageController@inputUpdate')->name('admin.package.inputUpdate');
    Route::post('/package/feature', 'Admin\PackageController@feature')->name('admin.package.feature');



    // Admin Packages Routes
    Route::get('/packages', 'Admin\PackageController@index')->name('admin.package.index');
    Route::post('/package/upload', 'Admin\PackageController@upload')->name('admin.package.upload');
    Route::post('/package/store', 'Admin\PackageController@store')->name('admin.package.store');
    Route::get('/package/{id}/edit', 'Admin\PackageController@edit')->name('admin.package.edit');
    Route::post('/package/update', 'Admin\PackageController@update')->name('admin.package.update');
    Route::post('/package/{id}/uploadUpdate', 'Admin\PackageController@uploadUpdate')->name('admin.package.uploadUpdate');
    Route::post('/package/delete', 'Admin\PackageController@delete')->name('admin.package.delete');
    Route::post('/package/bulk-delete', 'Admin\PackageController@bulkDelete')->name('admin.package.bulk.delete');
    Route::get('/all/orders', 'Admin\PackageController@all')->name('admin.all.orders');
    Route::get('/pending/orders', 'Admin\PackageController@pending')->name('admin.pending.orders');
    Route::get('/processing/orders', 'Admin\PackageController@processing')->name('admin.processing.orders');
    Route::get('/completed/orders', 'Admin\PackageController@completed')->name('admin.completed.orders');
    Route::get('/rejected/orders', 'Admin\PackageController@rejected')->name('admin.rejected.orders');
    Route::post('/orders/status', 'Admin\PackageController@status')->name('admin.orders.status');
    Route::post('/orders/mail', 'Admin\PackageController@mail')->name('admin.orders.mail');
    Route::post('/package/order/delete', 'Admin\PackageController@orderDelete')->name('admin.package.order.delete');
    Route::post('/order/bulk-delete', 'Admin\PackageController@bulkOrderDelete')->name('admin.order.bulk.delete');
  });



  Route::group(['middleware' => 'checkpermission:Quote Management'], function() {

    // Admin Quote Form Builder Routes
    Route::get('/quote/visibility', 'Admin\QuoteController@visibility')->name('admin.quote.visibility');
    Route::post('/quote/visibility/update', 'Admin\QuoteController@updateVisibility')->name('admin.quote.visibility.update');
    Route::get('/quote/form', 'Admin\QuoteController@form')->name('admin.quote.form');
    Route::post('/quote/form/store', 'Admin\QuoteController@formstore')->name('admin.quote.form.store');
    Route::post('/quote/inputDelete', 'Admin\QuoteController@inputDelete')->name('admin.quote.inputDelete');
    Route::get('/quote/{id}/inputEdit', 'Admin\QuoteController@inputEdit')->name('admin.quote.inputEdit');
    Route::get('/quote/{id}/options', 'Admin\QuoteController@options')->name('admin.quote.options');
    Route::post('/quote/inputUpdate', 'Admin\QuoteController@inputUpdate')->name('admin.quote.inputUpdate');
    Route::post('/quote/delete', 'Admin\QuoteController@delete')->name('admin.quote.delete');
    Route::post('/quote/bulk-delete', 'Admin\QuoteController@bulkDelete')->name('admin.quote.bulk.delete');


    // Admin Quote Routes
    Route::get('/all/quotes', 'Admin\QuoteController@all')->name('admin.all.quotes');
    Route::get('/pending/quotes', 'Admin\QuoteController@pending')->name('admin.pending.quotes');
    Route::get('/processing/quotes', 'Admin\QuoteController@processing')->name('admin.processing.quotes');
    Route::get('/completed/quotes', 'Admin\QuoteController@completed')->name('admin.completed.quotes');
    Route::get('/rejected/quotes', 'Admin\QuoteController@rejected')->name('admin.rejected.quotes');
    Route::post('/quotes/status', 'Admin\QuoteController@status')->name('admin.quotes.status');
    Route::post('/quote/mail', 'Admin\QuoteController@mail')->name('admin.quotes.mail');
  });



//   Route::group(['middleware' => 'checkpermission:Role Management'], function() {
    // Admin Roles Routes
    Route::get('/gateways', 'Admin\GatewayController@index')->name('admin.gateway.index');
    Route::post('/stripe/update', 'Admin\GatewayController@stripeUpdate')->name('admin.stripe.update');
    Route::post('/paypal/update', 'Admin\GatewayController@paypalUpdate')->name('admin.paypal.update');
    Route::post('/paystack/update', 'Admin\GatewayController@paystackUpdate')->name('admin.paystack.update');
    Route::post('/paytm/update', 'Admin\GatewayController@paytmUpdate')->name('admin.paytm.update');
    Route::post('/flutterwave/update', 'Admin\GatewayController@flutterwaveUpdate')->name('admin.flutterwave.update');
    Route::post('/instamojo/update', 'Admin\GatewayController@instamojoUpdate')->name('admin.instamojo.update');
    Route::post('/mollie/update', 'Admin\GatewayController@mollieUpdate')->name('admin.mollie.update');
    Route::post('/razorpay/update', 'Admin\GatewayController@razorpayUpdate')->name('admin.razorpay.update');
    Route::post('/mercadopago/update', 'Admin\GatewayController@mercadopagoUpdate')->name('admin.mercadopago.update');
    Route::post('/payumoney/update', 'Admin\GatewayController@payumoneyUpdate')->name('admin.payumoney.update');
    Route::get('/offline/gateways', 'Admin\GatewayController@offline')->name('admin.gateway.offline');
    Route::post('/offline/gateway/store', 'Admin\GatewayController@store')->name('admin.gateway.offline.store');
    Route::post('/offline/gateway/update', 'Admin\GatewayController@update')->name('admin.gateway.offline.update');
    Route::post('/offline/status', 'Admin\GatewayController@status')->name('admin.offline.status');
    Route::post('/offline/gateway/delete', 'Admin\GatewayController@delete')->name('admin.offline.gateway.delete');



  Route::group(['middleware' => 'checkpermission:Role Management'], function() {
    // Admin Roles Routes
    Route::get('/roles', 'Admin\RoleController@index')->name('admin.role.index');
    Route::post('/role/store', 'Admin\RoleController@store')->name('admin.role.store');
    Route::post('/role/update', 'Admin\RoleController@update')->name('admin.role.update');
    Route::post('/role/delete', 'Admin\RoleController@delete')->name('admin.role.delete');
    Route::get('role/{id}/permissions/manage', 'Admin\RoleController@managePermissions')->name('admin.role.permissions.manage');
    Route::post('role/permissions/update', 'Admin\RoleController@updatePermissions')->name('admin.role.permissions.update');
  });



  Route::group(['middleware' => 'checkpermission:Users Management'], function() {
    // Admin Users Routes
    Route::get('/users', 'Admin\UserController@index')->name('admin.user.index');
    Route::post('/user/upload', 'Admin\UserController@upload')->name('admin.user.upload');
    Route::post('/user/store', 'Admin\UserController@store')->name('admin.user.store');
    Route::get('/user/{id}/edit', 'Admin\UserController@edit')->name('admin.user.edit');
    Route::post('/user/update', 'Admin\UserController@update')->name('admin.user.update');
    Route::post('/user/{id}/uploadUpdate', 'Admin\UserController@uploadUpdate')->name('admin.user.uploadUpdate');
    Route::post('/user/delete', 'Admin\UserController@delete')->name('admin.user.delete');
  });


  Route::group(['middleware' => 'checkpermission:Language Management'], function() {
    // Admin Language Routes
    Route::get('/languages', 'Admin\LanguageController@index')->name('admin.language.index');
    Route::get('/language/{id}/edit', 'Admin\LanguageController@edit')->name('admin.language.edit');
    Route::get('/language/{id}/edit/keyword', 'Admin\LanguageController@editKeyword')->name('admin.language.editKeyword');
    Route::post('/language/store', 'Admin\LanguageController@store')->name('admin.language.store');
    Route::post('/language/upload', 'Admin\LanguageController@upload')->name('admin.language.upload');
    Route::post('/language/{id}/uploadUpdate', 'Admin\LanguageController@uploadUpdate')->name('admin.language.uploadUpdate');
    Route::post('/language/{id}/default', 'Admin\LanguageController@default')->name('admin.language.default');
    Route::post('/language/{id}/delete', 'Admin\LanguageController@delete')->name('admin.language.delete');
    Route::post('/language/update', 'Admin\LanguageController@update')->name('admin.language.update');
    Route::post('/language/{id}/update/keyword', 'Admin\LanguageController@updateKeyword')->name('admin.language.updateKeyword');
  });


  Route::group(['middleware' => 'checkpermission:Backup'], function() {
    // Admin Backup Routes
    Route::get('/backup', 'Admin\BackupController@index')->name('admin.backup.index');
    Route::post('/backup/store', 'Admin\BackupController@store')->name('admin.backup.store');
    Route::post('/backup/{id}/delete', 'Admin\BackupController@delete')->name('admin.backup.delete');
    Route::post('/backup/download', 'Admin\BackupController@download')->name('admin.backup.download');
  });


  // Admin Cache Clear Routes
  Route::get('/cache-clear', 'Admin\CacheController@clear')->name('admin.cache.clear');
});
