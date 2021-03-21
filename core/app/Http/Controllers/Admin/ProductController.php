<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\BasicExtended as BE;
use App\BasicExtra;
use App\Language;
use App\Pcategory;
use App\ProductImage;
use App\Product;
use Validator;
use Session;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['products'] = Product::where('language_id', $lang_id)->orderBy('id', 'DESC')->paginate(10);
        $data['lang_id'] = $lang_id;
        return view('admin.product.index',$data);
    }


    public function create(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $abx = $lang->basic_extra;
        $categories = Pcategory::where('status',1)->get();
        return view('admin.product.create',compact('categories','abx'));
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

        $img->move('assets/front/img/product/sliders/', $filename);

        $pi = new ProductImage;
        if (!empty($request->product_id)) {
            $pi->product_id = $request->product_id;
        }
        $pi->image = $filename;
        $pi->save();

        return response()->json(['status' => 'success', 'file_id' => $pi->id]);
    }

    public function sliderrmv(Request $request)
    {
        $pi = ProductImage::findOrFail($request->fileid);
        @unlink('assets/front/img/product/sliders/' . $pi->image);
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
        $request->file('file')->move('assets/front/img/product/featured/', $filename);
        return response()->json(['status' => "session_put", "image" => "featured_image", 'filename' => $filename]);
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

        $product = Product::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/product/featured/', $filename);
            @unlink('assets/front/img/product/featured/' . $product->feature_image);
            $product->feature_image = $filename;
            $product->save();
        }

        return response()->json(['status' => "success", "image" => "Product image", 'product' => $product]);
    }


    public function getCategory($langid)
    {
        $category = Pcategory::where('language_id', $langid)->get();
        return $category;
    }


    public function store(Request $request)
    {
        $slug = make_slug($request->title);

        $rules = [
            'language_id' => 'required',
            'title' => 'required|max:255',
            'category_id' => 'required',
            'tags' => 'required',
            'stock' => 'required',
            'sku' => 'required|unique:products',
            'current_price' => 'required',
            'previous_price' => 'nullable',
            'summary' => 'required',
            'description' => 'required|min:15',
            'featured_image' => 'required',
            'slider_images' => 'required',
            'status' => 'required',
        ];

        $messages = [
            'language_id.required' => 'The language field is required',
            'category_id.required' => 'Category is required',
            'description.min' => 'Description is required'
        ];


        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $in = $request->all();
        $in['language_id'] = $request->language_id;
        $in['slug'] = $slug;
        $in['feature_image'] = $request->featured_image;

        $product = Product::create($in);

        $slders = $request->slider_images;
        $pis = ProductImage::findOrFail($slders);
        foreach ($pis as $key => $pi) {
            $pi->product_id = $product->id;
            $pi->save();
        }

        Session::flash('success', 'Product added successfully!');
        return "success";
    }


    public function edit(Request $request, $id)
    {
        $lang = Language::where('code', $request->language)->first();
        $abx = $lang->basic_extra;
        $categories = $lang->pcategories()->where('status',1)->get();
        $data = Product::findOrFail($id);
        return view('admin.product.edit',compact('categories','data','abx'));
    }

    public function images($portid)
    {
        $images = ProductImage::where('product_id', $portid)->get();
        return $images;
    }

    public function update(Request $request)
    {
        $slug = make_slug($request->title);

        $rules = [

            'title' => 'required|max:255',
            'category_id' => 'required',
            'tags' => 'required',
            'stock' => 'required',
            'sku' => [
                'required',
                Rule::unique('products')->ignore($request->product_id),
            ],
            'current_price' => 'required',
            'previous_price' => 'nullable',
            'summary' => 'required',
            'description' => 'required|min:15',
            'status' => 'required',
        ];

        $messages = [
            'category_id.required' => 'Service is required',
            'description.min' => 'Description is required'
        ];



        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $in = $request->all();
        $product = Product::findOrFail($request->product_id);
        $in['slug'] = $slug;

        $product = $product->fill($in)->save();

        Session::flash('success', 'Product updated successfully!');
        return "success";
    }


    public function delete(Request $request)
    {


        $product = Product::findOrFail($request->product_id);

        foreach ($product->product_images as $key => $pi) {
            @unlink('assets/front/img/product/sliders/' . $pi->image);
            $pi->delete();
        }

        @unlink('assets/front/img/product/featured/' . $portfolio->feature_image);
        $product->delete();

        Session::flash('success', 'Product deleted successfully!');
        return back();
    }


    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $product = Product::findOrFail($id);
            foreach ($product->product_images as $key => $pi) {
                @unlink('assets/front/img/product/sliders/' . $pi->image);
                $pi->delete();
            }
        }

        foreach ($ids as $id) {
            $product = product::findOrFail($id);
            @unlink('assets/front/img/product/featured/' . $product->feature_image);
            $product->delete();
        }

        Session::flash('success', 'Product deleted successfully!');
        return "success";
    }


    public function populerTag(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $lang_id = $lang->id;
        $data = BE::where('language_id',$lang_id)->first();
        return view('admin.product.tag.index',compact('data'));
    }

    public function populerTagupdate(Request $request)
    {
        $rules = [
            'language_id' => 'required',
            'popular_tags' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $lang = Language::where('code', $request->language_id)->first();
        $be = BE::where('language_id',$lang->id)->first();
        $be->popular_tags = $request->popular_tags;
        $be->save();
        Session::flash('success', 'Populer tags update successfully!');
        return "success";
    }
}
