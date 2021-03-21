<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Portfolio;
use App\Service;
use App\Language;
use App\PortfolioImage;
use Validator;
use Session;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['portfolios'] = Portfolio::where('language_id', $lang_id)->orderBy('id', 'DESC')->paginate(10);

        $data['lang_id'] = $lang_id;

        return view('admin.portfolio.index', $data);
    }

    public function create()
    {
        $data['services'] = Service::all();
        $data['tportfolios'] = Portfolio::where('language_id', 0)->get();
        return view('admin.portfolio.create', $data);
    }

    public function edit($id)
    {
        $data['portfolio'] = Portfolio::findOrFail($id);
        $data['services'] = Service::where('language_id', $data['portfolio']->language_id)->get();
        return view('admin.portfolio.edit', $data);
    }

    public function sliderstore(Request $request)
    {
        $img = $request->file('file');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [
            'file' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    $ext = $img->getClientOriginalExtension();
                    if (!in_array($ext, $allowedExts)) {
                        return $fail("Only png, jpg, jpeg images are allowed");
                    }
                },
            ]
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $filename = uniqid() . '.jpg';

        $img->move('assets/front/img/portfolios/sliders/', $filename);

        $pi = new PortfolioImage;
        if (!empty($request->portfolio_id)) {
            $pi->portfolio_id = $request->portfolio_id;
        }
        $pi->image = $filename;
        $pi->save();

        return response()->json(['status' => 'success', 'file_id' => $pi->id]);
    }

    public function sliderrmv(Request $request)
    {
        $pi = PortfolioImage::findOrFail($request->fileid);
        @unlink('assets/front/img/portfolios/sliders/' . $pi->image);
        $pi->delete();
        return $pi->id;
    }

    public function upload(Request $request)
    {
        $img = $request->file('file');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [
            'file' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'portfolio']);
        }

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->session()->put('portfolio_image', $filename);
        $request->file('file')->move('assets/front/img/portfolios/featured/', $filename);
        return response()->json(['status' => "session_put", "image" => "featured_image", 'filename' => $filename]);
    }


    public function store(Request $request)
    {
        $slug = make_slug($request->title);

        $rules = [
            'language_id' => 'required',
            'title' => 'required|max:255',
            'client_name' => 'required|max:255',
            'service_id' => 'required',
            'start_date' => 'required|max:255',
            'submission_date' => 'nullable|max:255',
            'tags' => 'required',
            'content' => 'required',
            'featured_image' => 'required',
            'slider_images' => 'required',
            'status' => 'required',
            'serial_number' => 'required|integer',
        ];

        $messages = [
            'language_id.required' => 'The language field is required',
            'service_id.required' => 'service is required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $in = $request->all();
        $in['language_id'] = $request->language_id;
        $in['slug'] = $slug;
        $in['content'] = $request->content;
        $portfolio = Portfolio::create($in);

        $slders = $request->slider_images;
        $pis = PortfolioImage::findOrFail($slders);
        foreach ($pis as $key => $pi) {
            $pi->portfolio_id = $portfolio->id;
            $pi->save();
        }

        Session::flash('success', 'Portfolio added successfully!');
        return "success";
    }

    public function images($portid)
    {
        $images = PortfolioImage::where('portfolio_id', $portid)->get();
        return $images;
    }

    public function uploadUpdate(Request $request, $id)
    {
        $img = $request->file('file');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [
            'file' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'slider']);
        }

        $portfolio = Portfolio::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/portfolios/featured/', $filename);
            @unlink('assets/front/img/portfolios/featured/' . $portfolio->featured_image);
            $portfolio->featured_image = $filename;
            $portfolio->save();
        }

        return response()->json(['status' => "success", "image" => "Portfolio image", 'portfolio' => $portfolio]);
    }

    public function update(Request $request)
    {
        $slug = make_slug($request->title);
        $portfolio = Portfolio::findOrFail($request->portfolio_id);

        $rules = [
            'title' => 'required|max:255',
            'client_name' => 'required|max:255',
            'service_id' => 'required',
            'start_date' => 'required|max:255',
            'submission_date' => 'nullable|max:255',
            'tags' => 'required',
            'content' => 'required',
            'status' => 'required',
            'serial_number' => 'required|integer',
        ];

        $messages = [
            'service_id.required' => 'service is required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $in = $request->all();
        $portfolio = Portfolio::findOrFail($request->portfolio_id);
        $in['content'] = $request->content;
        $in['slug'] = $slug;
        $portfolio = $portfolio->fill($in)->save();

        Session::flash('success', 'Portfolio updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $portfolio = Portfolio::findOrFail($request->portfolio_id);
        foreach ($portfolio->portfolio_images as $key => $pi) {
            @unlink('assets/front/img/portfolios/sliders/' . $pi->image);
            $pi->delete();
        }
        @unlink('assets/front/img/portfolios/featured/' . $portfolio->featured_image);
        $portfolio->delete();

        Session::flash('success', 'Portfolio deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $portfolio = Portfolio::findOrFail($id);
            foreach ($portfolio->portfolio_images as $key => $pi) {
                @unlink('assets/front/img/portfolios/sliders/' . $pi->image);
                $pi->delete();
            }
        }

        foreach ($ids as $id) {
            $portfolio = Portfolio::findOrFail($id);
            @unlink('assets/front/img/portfolios/featured/' . $portfolio->featured_image);
            $portfolio->delete();
        }

        Session::flash('success', 'Portfolios deleted successfully!');
        return "success";
    }

    public function getservices($langid)
    {
        $services = Service::where('language_id', $langid)->get();

        return $services;
    }

    public function feature(Request $request)
    {
        $portfolio = Portfolio::find($request->portfolio_id);
        $portfolio->feature = $request->feature;
        $portfolio->save();

        if ($request->feature == 1) {
            Session::flash('success', 'Featured successfully!');
        } else {
            Session::flash('success', 'Unfeatured successfully!');
        }

        return back();
    }
}
