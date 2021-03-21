<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\BasicSetting as BS;
use App\BasicExtended as BE;
use App\Slider;
use App\Scategory;
use App\Jcategory;
use App\Portfolio;
use App\Feature;
use App\Point;
use App\Statistic;
use App\Testimonial;
use App\Gallery;
use App\Faq;
use App\Page;
use App\Member;
use App\Blog;
use App\Partner;
use App\Service;
use App\Job;
use App\Archive;
use App\Bcategory;
use App\Subscriber;
use App\Quote;
use App\Language;
use App\Package;
use App\PackageOrder;
use App\Admin;
use App\CalendarEvent;
use App\Mail\ContactMail;
use App\Mail\OrderPackage;
use App\Mail\OrderQuote;
use App\OfflineGateway;
use App\PackageInput;
use App\PaymentGateway;
use App\QuoteInput;
use App\RssFeed;
use App\RssPost;
use Session;
use Validator;
use Config;
use Mail;
use PDF;

class FrontendController extends Controller
{
    public function __construct()
    {
        $bs = BS::first();
        $be = BE::first();

        Config::set('captcha.sitekey', $bs->google_recaptcha_site_key);
        Config::set('captcha.secret', $bs->google_recaptcha_secret_key);
    }

    public function index()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;
        $lang_id = $currentLang->id;

        $data['sliders'] = Slider::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $data['portfolios'] = Portfolio::where('language_id', $lang_id)->where('feature', 1)->orderBy('serial_number', 'ASC')->limit(10)->get();
        $data['features'] = Feature::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $data['points'] = Point::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $data['statistics'] = Statistic::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $data['testimonials'] = Testimonial::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $data['faqs'] = Faq::orderBy('serial_number', 'ASC')->get();
        $data['members'] = Member::where('language_id', $lang_id)->where('feature', 1)->get();
        $data['blogs'] = Blog::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->limit(6)->get();
        $data['partners'] = Partner::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $data['packages'] = Package::where('language_id', $lang_id)->where('feature', 1)->orderBy('serial_number', 'ASC')->get();
        $data['scategories'] = Scategory::where('language_id', $lang_id)->where('feature', 1)->where('status', 1)->orderBy('serial_number', 'ASC')->get();
        if (!hasCategory($be->theme_version)) {
            $data['services'] = Service::where('language_id', $lang_id)->where('feature', 1)->orderBy('serial_number', 'ASC')->get();
        }

        $version = getVersion($be->theme_version);

        if ($version == 'gym') {
            return view('front.gym.index', $data);
        } elseif ($version == 'car') {
            return view('front.car.index', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.index', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.index', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.index', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.index', $data);
        } elseif ($version == 'default' || $version == 'dark') {
            return view('front.default.index', $data);
        }
    }

    public function services(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;


        $category = $request->category;
        $term = $request->term;

        if (!empty($category)) {
            $data['category'] = Scategory::findOrFail($category);
        }

        $data['services'] = Service::when($category, function ($query, $category) {
            return $query->where('scategory_id', $category);
        })->when($term, function ($query, $term) {
            return $query->where('title', 'like', '%' . $term . '%');
        })->when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC')->paginate(6);


        $version = getVersion($be->theme_version);

        if ($version == 'gym') {
            return view('front.gym.services', $data);
        } elseif ($version == 'car') {
            return view('front.car.services', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.services', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.services', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.services', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.services', $data);
        } elseif ($version == 'default' || $version == 'dark') {
            return view('front.default.services', $data);
        }

    }

    public function packages()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;

        $data['packages'] = Package::when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC')->get();

        $version = getVersion($be->theme_version);

        if ($version == 'gym') {
            return view('front.gym.packages', $data);
        } elseif ($version == 'car') {
            return view('front.car.packages', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.packages', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.packages', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.packages', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.packages', $data);
        } elseif ($version == 'default' || $version == 'dark') {
            return view('front.default.packages', $data);
        }
    }

    public function portfolios(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;

        $category = $request->category;

        if (!empty($category)) {
            $data['category'] = Scategory::findOrFail($category);
        }

        $data['portfolios'] = Portfolio::when($category, function ($query, $category) {
            $serviceIdArr = [];
            $serviceids = Service::select('id')->where('scategory_id', $category)->get();
            foreach ($serviceids as $key => $serviceid) {
                $serviceIdArr[] = $serviceid->id;
            }
            return $query->whereIn('service_id', $serviceIdArr);
        })->when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC');

        $version = getVersion($be->theme_version);

        if ($version == 'gym') {
            $data['portfolios'] = $data['portfolios']->paginate(9);
            return view('front.gym.portfolios', $data);
        } elseif ($version == 'car') {
            $data['portfolios'] = $data['portfolios']->paginate(6);
            return view('front.car.portfolios', $data);
        } elseif ($version == 'cleaning') {
            $data['portfolios'] = $data['portfolios']->paginate(6);
            return view('front.cleaning.portfolios', $data);
        } elseif ($version == 'construction') {
            $data['portfolios'] = $data['portfolios']->paginate(6);
            return view('front.construction.portfolios', $data);
        } elseif ($version == 'logistic') {
            $data['portfolios'] = $data['portfolios']->paginate(6);
            return view('front.logistic.portfolios', $data);
        } elseif ($version == 'lawyer') {
            $data['portfolios'] = $data['portfolios']->paginate(6);
            return view('front.lawyer.portfolios', $data);
        } elseif ($version == 'default' || $version == 'dark') {
            $data['portfolios'] = $data['portfolios']->paginate(9);
            return view('front.default.portfolios', $data);
        }
    }

    public function portfoliodetails($slug, $id)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['portfolio'] = Portfolio::findOrFail($id);

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.portfolio-details', $data);
    }

    public function servicedetails($slug, $id)
    {

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['service'] = Service::findOrFail($id);

        if ($data['service']->details_page_status == 0) {
            return back();
        }

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.service-details', $data);

    }

    public function careerdetails($slug, $id)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['jcats'] = $currentLang->jcategories()->where('status', 1)->orderBy('serial_number', 'ASC')->get();

        $data['job'] = Job::findOrFail($id);

        $data['jobscount'] = Job::when($currentLang, function ($query, $currentLang) {
                                    return $query->where('language_id', $currentLang->id);
                                })->count();

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;


        return view('front.career-details', $data);

    }

    public function blogs(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;

        $lang_id = $currentLang->id;
        $be = $currentLang->basic_extended;

        $category = $request->category;
        $catid = null;
        if (!empty($category)) {
            $data['category'] = Bcategory::where('slug', $category)->firstOrFail();
            $catid = $data['category']->id;
        }
        $term = $request->term;
        $tag = $request->tag;
        $month = $request->month;
        $year = $request->year;
        $data['archives'] = Archive::orderBy('id', 'DESC')->get();
        $data['bcats'] = Bcategory::where('language_id', $lang_id)->where('status', 1)->orderBy('serial_number', 'ASC')->get();
        if (!empty($month) && !empty($year)) {
            $archive = true;
        } else {
            $archive = false;
        }

        $data['blogs'] = Blog::when($catid, function ($query, $catid) {
            return $query->where('bcategory_id', $catid);
        })
        ->when($term, function ($query, $term) {
            return $query->where('title', 'like', '%' . $term . '%');
        })
        ->when($tag, function ($query, $tag) {
            return $query->where('tags', 'like', '%' . $tag . '%');
        })
        ->when($archive, function ($query) use ($month, $year) {
            return $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
        })
        ->when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC')->paginate(6);

        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;


        return view('front.blogs', $data);
    }

    public function blogdetails($slug, $id)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;


        $data['blog'] = Blog::findOrFail($id);

        $data['archives'] = Archive::orderBy('id', 'DESC')->get();
        $data['bcats'] = Bcategory::where('status', 1)->where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.blog-details', $data);
    }

    public function rss(){
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;
        $data['categories'] = RssFeed::where('language_id',$lang_id)->orderBy('id','desc')->get();
        $data['rss_posts']  = RssPost::where('language_id',$lang_id)->orderBy('id','desc')->paginate(4);

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'gym') {
            return view('front.gym.rss', $data);
        } elseif ($version == 'car') {
            return view('front.car.rss', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.rss', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.rss', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.rss', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.rss', $data);
        } elseif ($version == 'default' || $version == 'dark') {
            return view('front.default.rss', $data);
        }
    }

    public function rssdetails($slug, $id){
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;
        $data['categories'] = RssFeed::where('language_id',$lang_id)->orderBy('id','desc')->get();
        $data['post']  = RssPost::findOrFail($id);

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.rss-details', $data);
    }

    public function rcatpost($id){
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $data['cat_id'] = $id;
        $data['categories'] = RssFeed::where('language_id',$lang_id)->orderBy('id','desc')->get();
        $data['posts']  = RssFeed::findOrFail($id)->rss()->orderBy('id', 'DESC')->paginate(4);

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'gym') {
            return view('front.gym.rcatpost', $data);
        } elseif ($version == 'car') {
            return view('front.car.rcatpost', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.rcatpost', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.rcatpost', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.rcatpost', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.rcatpost', $data);
        } elseif ($version == 'default' || $version == 'dark') {
            return view('front.default.rcatpost', $data);
        }
    }

    public function contact()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        if (session()->has('lang')) {
            $data['langg'] = Language::where('code', session('lang'))->first();

            return view('front.contact', $data);
        }

        return view('front.contact', $data);
    }

    public function sendmail(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ];

        $request->validate($rules, $messages);

        $be =  BE::firstOrFail();
        $from = $request->email;
        $to = $be->to_mail;
        $subject = $request->subject;
        $message = $request->message;

        try {

            $mail = new PHPMailer(true);
            $mail->setFrom($from, $request->name);
            $mail->addAddress($to);     // Add a recipient

            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
        } catch(\Exception $e) {
            // die($e->getMessage());
        }

        Session::flash('success', 'Email sent successfully!');
        return back();
    }

    public function subscribe(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:subscribers'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $subsc = new Subscriber;
        $subsc->email = $request->email;
        $subsc->save();

        return "success";
    }

    public function quote()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;

        if ($bs->is_quote == 0) {
            return view('errors.404');
        }

        $lang_id = $currentLang->id;

        $data['services'] = Service::all();
        $data['inputs'] = QuoteInput::where('language_id', $lang_id)->get();
        $data['ndaIn'] = QuoteInput::find(10);

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.quote', $data);
    }

    public function sendquote(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;
        $quote_inputs = $currentLang->quote_inputs;

        $nda = $request->file('nda');
        $ndaIn = QuoteInput::find(10);
        $allowedExts = array('doc', 'docx', 'pdf', 'rtf', 'txt', 'zip', 'rar');

        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'nda' => [
                function ($attribute, $value, $fail) use ($nda, $allowedExts) {

                    $ext = $nda->getClientOriginalExtension();
                    if (!in_array($ext, $allowedExts)) {
                        return $fail("Only doc, docx, pdf, rtf, txt, zip, rar files are allowed");
                    }

                },

            ],
        ];


        if ($ndaIn->required == 1 && $ndaIn->active == 1) {
            if (!$request->hasFile('nda')) {
                $rules["nda"] = 'required';
            }
        }


        foreach ($quote_inputs as $input) {
            if ($input->required == 1) {
                $rules["$input->name"] = 'required';
            }
        }

        if ($bs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $request->validate($rules, $messages);

        $fields = [];
        foreach ($quote_inputs as $key => $input) {
            $in_name = $input->name;
            if ($request["$in_name"]) {
                $fields["$in_name"] = $request["$in_name"];
            }
        }
        $jsonfields = json_encode($fields);
        $jsonfields = str_replace("\/","/",$jsonfields);


        $quote = new Quote;
        $quote->name = $request->name;
        $quote->email = $request->email;
        $quote->fields = $jsonfields;

        if ($request->hasFile('nda')) {
            $filename = uniqid() . '.' . $nda->getClientOriginalExtension();
            $nda->move('assets/front/ndas/', $filename);
            $quote->nda = $filename;
        }

        $quote->save();


        // send mail to Admin
        $from = $request->email;
        $to = $be->to_mail;
        $subject = "Quote Request Received";

        $fields = json_decode($quote->fields, true);

        try {

            $mail = new PHPMailer(true);
            $mail->setFrom($from, $request->name);
            $mail->addAddress($to);     // Add a recipient

            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = 'A new quote request has been sent.<br/><strong>Client Name: </strong>' . $request->name . '<br/><strong>Client Mail: </strong>' . $request->email;

            $mail->send();
        } catch(\Exception $e) {
            // die($e->getMessage());
        }

        Session::flash('success', 'Quote request sent successfully');
        return back();
    }

    public function team()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['members'] = Member::when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->get();

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'gym') {
            return view('front.gym.team', $data);
        } elseif ($version == 'car') {
            return view('front.car.team', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.team', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.team', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.team', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.team', $data);
        } elseif ($version == 'default' || $version == 'dark') {
            return view('front.default.team', $data);
        }
    }

    public function career(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['jcats'] = $currentLang->jcategories()->where('status', 1)->orderBy('serial_number', 'ASC')->get();


        $category = $request->category;
        $term = $request->term;

        if (!empty($category)) {
            $data['category'] = Jcategory::findOrFail($category);
        }

        $data['jobs'] = Job::when($category, function ($query, $category) {
            return $query->where('jcategory_id', $category);
        })->when($term, function ($query, $term) {
            return $query->where('title', 'like', '%' . $term . '%');
        })->when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC')->paginate(4);

        $data['jobscount'] = Job::when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->count();

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.career', $data);
    }

    public function calendar() {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $events = CalendarEvent::where('language_id', $lang_id)->get();
        $formattedEvents = [];

        foreach ($events as $key => $event) {
            $formattedEvents["$key"]['title'] = $event->title;

            $startDate = strtotime($event->start_date);
            $formattedEvents["$key"]['start'] = date('Y-m-d H:i' ,$startDate);

            $endDate = strtotime($event->end_date);
            $formattedEvents["$key"]['end'] = date('Y-m-d H:i' ,$endDate);
        }

        $data["formattedEvents"] = $formattedEvents;

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.calendar', $data);
    }

    public function gallery()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $data['galleries'] = Gallery::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->paginate(12);

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.gallery', $data);
    }

    public function faq()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $data['faqs'] = Faq::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.faq', $data);
    }

    public function dynamicPage($slug, $id)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['page'] = Page::findOrFail($id);

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.dynamic', $data);
    }

    public function changeLanguage($lang)
    {
        session()->put('lang', $lang);
        app()->setLocale($lang);

        $be = be::first();
        $version = getVersion($be->theme_version);

        return redirect()->route('front.index');
    }

    public function packageorder($id)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $data['package'] = Package::findOrFail($id);

        if ($data['package']->order_status == 0) {
            return view('errors.404');
        }

        $data['inputs'] = PackageInput::where('language_id', $lang_id)->get();
        $data['gateways']  = PaymentGateway::whereStatus(1)->whereType('automatic')->get();
        $data['ogateways']  = OfflineGateway::wherePackageOrderStatus(1)->orderBy('serial_number', 'ASC')->get();
        $paystackData = PaymentGateway::whereKeyword('paystack')->first();
        $data['paystack'] = $paystackData->convertAutoData();
        $data['ndaIn'] = PackageInput::find(1);

        $be = be::first();
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.package-order', $data);
    }


    public function submitorder(Request $request)
    {

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;
        $package_inputs = $currentLang->package_inputs;

        $nda = $request->file('nda');
        $ndaIn = PackageInput::find(1);
        $allowedExts = array('doc', 'docx', 'pdf', 'rtf', 'txt', 'zip', 'rar');

        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'package_id' => 'required',
            'nda' => [
                function ($attribute, $value, $fail) use ($nda, $allowedExts) {

                    $ext = $nda->getClientOriginalExtension();
                    if (!in_array($ext, $allowedExts)) {
                        return $fail("Only doc, docx, pdf, rtf, txt, zip, rar files are allowed");
                    }

                }
            ],
        ];

        if ($ndaIn->required == 1 && $ndaIn->active == 1) {
            if (!$request->hasFile('nda')) {
                $rules["nda"] = 'required';
            }
        }

        foreach ($package_inputs as $input) {
            if ($input->required == 1) {
                $rules["$input->name"] = 'required';
            }
        }

        if ($bs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $request->validate($rules, $messages);

        $fields = [];
        foreach ($package_inputs as $key => $input) {
            $in_name = $input->name;
            if ($request["$in_name"]) {
                $fields["$in_name"] = $request["$in_name"];
            }
        }
        $jsonfields = json_encode($fields);
        $jsonfields = str_replace("\/","/",$jsonfields);

        $package = Package::findOrFail($request->package_id);

        $in = $request->all();
        $in['name'] = $request->name;
        $in['email'] = $request->email;
        $in['fields'] = $jsonfields;

        if ($request->hasFile('nda')) {
            $filename = uniqid() . '.' . $nda->getClientOriginalExtension();
            $nda->move('assets/front/ndas/', $filename);
            $in['nda'] = $filename;
        }

        $in['package_title'] = $package->title;
        $in['package_currency'] = $package->currency;
        $in['package_price'] = $package->price;
        $in['package_description'] = $package->description;
        $fileName = str_random(4).time().'.pdf';
        $in['invoice'] = $fileName;
        $po = PackageOrder::create($in);


        // saving order number
        $po->order_number = $po->id + 1000000000;
        $po->save();


        // sending datas to view to make invoice PDF
        $fields = json_decode($po->fields, true);
        $data['packageOrder'] = $po;
        $data['fields'] = $fields;


        // generate pdf from view using dynamic datas
        PDF::loadView('pdf.package', $data)->save('assets/front/invoices/' . $fileName);


        // Send Mail to Buyer
        $mail = new PHPMailer(true);

        if ($be->is_smtp == 1) {
            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = $be->smtp_host;                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = $be->smtp_username;                     // SMTP username
                $mail->Password   = $be->smtp_password;                               // SMTP password
                $mail->SMTPSecure = $be->encryption;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = $be->smtp_port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);
                $mail->addAddress($request->email, $request->name);     // Add a recipient

                // Attachments
                $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = "Order placed for " . $package->title;
                $mail->Body    = 'Hello <strong>'.$request->name.'</strong>,<br/>Your order has been placed successfully. We have attached an invoice in this mail.<br/>Thank you.';

                $mail->send();
            } catch (Exception $e) {
                // die($e->getMessage());
            }
        } else {
            try {

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);
                $mail->addAddress($request->email, $request->name);     // Add a recipient

                // Attachments
                $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = "Order placed for " . $package->title;
                $mail->Body    = 'Hello <strong>'.$request->name.'</strong>,<br/>Your order has been placed successfully. We have attached an invoice in this mail.<br/>Thank you.';

                $mail->send();
            } catch (Exception $e) {
                // die($e->getMessage());
            }
        }

        // send mail to Admin
        try {

            $mail = new PHPMailer(true);
            $mail->setFrom($po->email, $po->name);
            $mail->addAddress($be->from_mail);     // Add a recipient

            // Attachments
            $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = "Order placed for " . $package->title;
            $mail->Body    = 'A new order has been placed.<br/><strong>Order Number: </strong>' . $po->order_number;

            $mail->send();
        } catch(\Exception $e) {
            // die($e->getMessage());
        }

        Session::flash('success', 'Order placed successfully!');
        return redirect()->route('front.packageorder.confirmation', [$package->id, $po->id]);
    }


    public function orderConfirmation($packageid, $packageOrderId) {
        $data['package'] = Package::findOrFail($packageid);
        $packageOrder = PackageOrder::findOrFail($packageOrderId);

        $data['packageOrder'] = $packageOrder;
        $data['fields'] = json_decode($packageOrder->fields, true);

        $be = be::first();
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.order-confirmation', $data);
    }


    public function loadpayment($slug,$id)
    {
        $data['payment'] = $slug;
        $data['pay_id'] = $id;
        $gateway = '';
        if($data['pay_id'] != 0 && $data['payment'] != "offline" ) {
            $gateway = PaymentGateway::findOrFail($data['pay_id']);
        } else {
            $gateway = OfflineGateway::findOrFail($data['pay_id']);
        }
        $data['gateway'] = $gateway;

        return view('front.load.payment', $data);

    }    // Redirect To Checkout Page If Payment is Cancelled

    public function paycancle($packageid){
        return redirect()->route('front.packageorder.index', $packageid)->with('error',__('Payment Cancelled.'));
    }


    // Redirect To Success Page If Payment is Comleted

     public function payreturn($packageid){
        return redirect()->route('front.packageorder.index', $packageid)->with('success',__('Pament Compelted!'));
     }

}
