<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
use App\Language;
use App\BasicSetting as BS;
use App\BasicExtended as BE;
use App\BasicExtra;
use Auth;
use Validator;
use Session;


class LanguageController extends Controller
{
    public function index($lang = false)
    {
        $data['languages'] = Language::all();
        return view('admin.language.index', $data);
    }


    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'code' => [
                'required',
                'max:255',
                'unique:languages'
            ],
            'direction' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $data = file_get_contents(resource_path('lang/') . 'default.json');
        $json_file = trim(strtolower($request->code)) . '.json';
        $path = resource_path('lang/') . $json_file;

        File::put($path, $data);

        $in['name'] = $request->name;
        $in['code'] = $request->code;
        $in['rtl'] = $request->direction;
        if (Language::where('is_default', 1)->count() > 0) {
            $in['is_default'] = 0;
        } else {
            $in['is_default'] = 1;
        }
        $lang = Language::create($in);

        // duplicate First row of basic_settings for current language
        $dbs = Language::where('is_default', 1)->first()->basic_setting;
        $cols = json_decode($dbs, true);
        $bs = new BS;
        foreach ($cols as $key => $value) {
            // if the column is 'id' [primary key] then skip it
            if ($key == 'id') {
                continue;
            }


            // create favicon image using default language image & save unique name in database
            if ($key == 'favicon') {
                // take default lang image
                $dimg = url('/assets/front/img/') .'/'. $dbs->favicon;

                // copy paste the default language image with different unique name
                $filename = uniqid();
                if (($pos = strpos($dbs->favicon, ".")) !== FALSE) {
                    $ext = substr($dbs->favicon, $pos+1);
                }
                $newImgName = $filename . '.' . $ext;

                @copy($dimg, 'assets/front/img/'.$newImgName);

                // save the unique name in database
                $bs[$key] = $newImgName;

                // continue the loop
                continue;

            }

            // create logo image using default language image & save unique name in database
            if ($key == 'logo') {
                // take default lang image
                $dimg = url('/assets/front/img/') .'/'. $dbs->logo;

                // copy paste the default language image with different unique name
                $filename = uniqid();
                if (($pos = strpos($dbs->logo, ".")) !== FALSE) {
                    $ext = substr($dbs->logo, $pos+1);
                }
                $newImgName = $filename . '.' . $ext;

                @copy($dimg, 'assets/front/img/'.$newImgName);

                // save the unique name in database
                $bs[$key] = $newImgName;

                // continue the loop
                continue;

            }

            // create breadcrumb image using default language image & save unique name in database
            if ($key == 'breadcrumb') {
                // take default lang image
                $dimg = url('/assets/front/img/') .'/'. $dbs->breadcrumb;

                // copy paste the default language image with different unique name
                $filename = uniqid();
                if (($pos = strpos($dbs->breadcrumb, ".")) !== FALSE) {
                    $ext = substr($dbs->breadcrumb, $pos+1);
                }
                $newImgName = $filename . '.' . $ext;

                @copy($dimg, 'assets/front/img/'.$newImgName);

                // save the unique name in database
                $bs[$key] = $newImgName;

                // continue the loop
                continue;

            }

            // create footer_logo image using default language image & save unique name in database
            if ($key == 'footer_logo') {
                // take default lang image
                $dimg = url('/assets/front/img/') .'/'. $dbs->footer_logo;

                // copy paste the default language image with different unique name
                $filename = uniqid();
                if (($pos = strpos($dbs->footer_logo, ".")) !== FALSE) {
                    $ext = substr($dbs->footer_logo, $pos+1);
                }
                $newImgName = $filename . '.' . $ext;

                @copy($dimg, 'assets/front/img/'.$newImgName);

                // save the unique name in database
                $bs[$key] = $newImgName;

                // continue the loop
                continue;

            }

            // create hero_bg image using default language image & save unique name in database
            if ($key == 'hero_bg') {
                // take default lang image
                $dimg = url('/assets/front/img/') .'/'. $dbs->hero_bg;

                // copy paste the default language image with different unique name
                $filename = uniqid();
                if (($pos = strpos($dbs->hero_bg, ".")) !== FALSE) {
                    $ext = substr($dbs->hero_bg, $pos+1);
                }
                $newImgName = $filename . '.' . $ext;

                @copy($dimg, 'assets/front/img/'.$newImgName);

                // save the unique name in database
                $bs[$key] = $newImgName;

                // continue the loop
                continue;

            }

            // create intro_bg image using default language image & save unique name in database
            if ($key == 'intro_bg') {
                // take default lang image
                $dimg = url('/assets/front/img/') .'/'. $dbs->intro_bg;

                // copy paste the default language image with different unique name
                $filename = uniqid();
                if (($pos = strpos($dbs->intro_bg, ".")) !== FALSE) {
                    $ext = substr($dbs->intro_bg, $pos+1);
                }
                $newImgName = $filename . '.' . $ext;

                @copy($dimg, 'assets/front/img/'.$newImgName);

                // save the unique name in database
                $bs[$key] = $newImgName;

                // continue the loop
                continue;

            }

            // create cta_bg image using default language image & save unique name in database
            if ($key == 'cta_bg') {
                // take default lang image
                $dimg = url('/assets/front/img/') .'/'. $dbs->cta_bg;

                // copy paste the default language image with different unique name
                $filename = uniqid();
                if (($pos = strpos($dbs->cta_bg, ".")) !== FALSE) {
                    $ext = substr($dbs->cta_bg, $pos+1);
                }
                $newImgName = $filename . '.' . $ext;

                @copy($dimg, 'assets/front/img/'.$newImgName);

                // save the unique name in database
                $bs[$key] = $newImgName;

                // continue the loop
                continue;

            }

            // create team_bg image using default language image & save unique name in database
            if ($key == 'team_bg') {
                // take default lang image
                $dimg = url('/assets/front/img/') .'/'. $dbs->team_bg;

                // copy paste the default language image with different unique name
                $filename = uniqid();
                if (($pos = strpos($dbs->team_bg, ".")) !== FALSE) {
                    $ext = substr($dbs->team_bg, $pos+1);
                }
                $newImgName = $filename . '.' . $ext;

                @copy($dimg, 'assets/front/img/'.$newImgName);

                // save the unique name in database
                $bs[$key] = $newImgName;

                // continue the loop
                continue;

            }

            // create announcement image using default language image & save unique name in database
            if ($key == 'announcement') {
                // take default lang image
                $dimg = url('/assets/front/img/') .'/'. $dbs->announcement;

                // copy paste the default language image with different unique name
                $filename = uniqid();
                if (($pos = strpos($dbs->announcement, ".")) !== FALSE) {
                    $ext = substr($dbs->announcement, $pos+1);
                }
                $newImgName = $filename . '.' . $ext;

                @copy($dimg, 'assets/front/img/'.$newImgName);

                // save the unique name in database
                $bs[$key] = $newImgName;

                // continue the loop
                continue;

            }

            $bs[$key] = $value;
        }
        $bs['language_id'] = $lang->id;
        $bs->save();

        // duplicate First row of basic_settings_extended for current language
        $be = BE::firstOrFail();
        $cols = json_decode($be, true);
        $be = new BE;
        foreach ($cols as $key => $value) {
            // if the column is 'id' [primary key] then skip it
            if ($key == 'id') {
                continue;
            }
            $be[$key] = $value;
        }
        $be['language_id'] = $lang->id;
        $be->save();


        // duplicate First row of basic_settings_extra for current language
        $bex = BasicExtra::firstOrFail();
        $cols = json_decode($bex, true);
        $bex = new BasicExtra;
        foreach ($cols as $key => $value) {
            // if the column is 'id' [primary key] then skip it
            if ($key == 'id') {
                continue;
            }
            $bex[$key] = $value;
        }
        $bex['language_id'] = $lang->id;
        $bex->save();


        Session::flash('success', 'Language added successfully!');
        return "success";
    }

    public function edit($id)
    {
        if ($id > 0) {
            $data['language'] = Language::findOrFail($id);
        }
        $data['id'] = $id;

        return view('admin.language.edit', $data);
    }


    public function update(Request $request)
    {
        $language = Language::findOrFail($request->language_id);

        $rules = [
            'name' => 'required|max:255',
            'code' => [
                'required',
                'max:255',
                Rule::unique('languages')->ignore($language->id),
            ],
            'direction' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $language->name = $request->name;
        $language->code = $request->code;
        $language->rtl = $request->direction;
        $language->save();

        Session::flash('success', 'Language updated successfully!');
        return "success";
    }

    public function editKeyword($id)
    {
        if ($id > 0) {
            $la = Language::findOrFail($id);
            $json = file_get_contents(resource_path('lang/') . $la->code . '.json');
            $list_lang = Language::all();

            if (empty($json)) {
                return back()->with('alert', 'File Not Found.');
            }

            return view('admin.language.edit-keyword', compact('json', 'la'));
        } elseif ($id == 0) {
            $json = file_get_contents(resource_path('lang/') . 'default.json');

            if (empty($json)) {
                return back()->with('alert', 'File Not Found.');
            }

            return view('admin.language.edit-keyword', compact('json'));
        }

    }



    public function updateKeyword(Request $request, $id)
    {
        $lang = Language::findOrFail($id);
        $content = json_encode($request->keys);
        if ($content === 'null') {
            return back()->with('alert', 'At Least One Field Should Be Fill-up');
        }
        file_put_contents(resource_path('lang/') . $lang->code . '.json', $content);
        return back()->with('success', 'Updated Successfully');
    }


    public function delete($id)
    {
        $la = Language::findOrFail($id);
        if ($la->is_default == 1) {
            return back()->with('warning', 'Default language cannot be deleted!');
        }
        @unlink('assets/front/img/languages/' . $la->icon);
        @unlink(resource_path('lang/') . $la->code . '.json');
        if (session()->get('lang') == $la->code) {
            session()->forget('lang');
        }

        // deleting basic_settings and basic_extended for corresponding language
        $bs = $la->basic_setting;
        if (!empty($bs)) {

            @unlink('assets/front/img/' . $bs->favicon);

            @unlink('assets/front/img/' . $bs->logo);

            @unlink('assets/front/img/' . $bs->breadcrumb);

            @unlink('assets/front/img/' . $bs->announcement);

            @unlink('assets/front/img/' . $bs->hero_bg);

            @unlink('assets/front/img/' . $bs->intro_bg);

            @unlink('assets/front/img/' . $bs->cta_bg);

            @unlink('assets/front/img/' . $bs->team_bg);

            @unlink('assets/front/img/' . $bs->footer_logo);

            $bs->delete();
        }
        $be = $la->basic_extended;
        if (!empty($be)) {
            $be->delete();
        }

        $bex = $la->basic_extra;
        if (!empty($bex)) {
            $bex->delete();
        }

        // deleting packages for corresponding language
        if (!empty($la->packages)) {
            $la->packages()->delete();
        }

        // deleting pages for corresponding language
        if (!empty($la->pages)) {
            $la->pages()->delete();
        }

        // deleting sliders for corresponding language
        if (!empty($la->sliders)) {
            $sliders = $la->sliders;
            foreach ($sliders as $slider) {
                @unlink('assets/front/img/sliders/'.$slider->image);
                $slider->delete();
            }
        }

        // deleting testimonials for corresponding language
        if (!empty($la->testimonials)) {
            $testimonials = $la->testimonials;
            foreach ($testimonials as $testimonial) {
                @unlink('assets/front/img/testimonials/'.$testimonial->image);
                $testimonial->delete();
            }
        }


        // deleting members for corresponding language
        if (!empty($la->members)) {
            $members = $la->members;
            foreach ($members as $member) {
                @unlink('assets/front/img/members/'.$member->image);
                $member->delete();
            }
        }

        // deleting partners for corresponding language
        if (!empty($la->partners)) {
            $partners = $la->partners;
            foreach ($partners as $partner) {
                @unlink('assets/front/img/partners/'.$partner->image);
                $partner->delete();
            }
        }

        // deleting service categories for corresponding language
        if (!empty($la->scategories)) {
            $scategories = $la->scategories;
            foreach ($scategories as $scategory) {
                @unlink('assets/front/img/service_category_icons/'.$scategory->image);
                $scategory->delete();
            }
        }

        // deleting services for corresponding language
        if (!empty($la->services)) {
            $services = $la->services;
            foreach ($services as $service) {
                @unlink('assets/front/img/services/'.$service->main_image);
                $service->delete();
            }
        }

        // deleting job categories for corresponding language
        if (!empty($la->jcategories)) {
            $jcategories = $la->jcategories;
            foreach ($jcategories as $jcategory) {
                $jcategory->delete();
            }
        }


        // deleting jobs for corresponding language
        if (!empty($la->jobs)) {
            $jobs = $la->jobs;
            foreach ($jobs as $job) {
                $job->delete();
            }
        }

        // deleting feature for corresponding language
        if (!empty($la->features)) {
            $features = $la->features;
            foreach ($features as $feature) {
                $feature->delete();
            }
        }

        // deleting gallery images for corresponding language
        if (!empty($la->galleries)) {
            $galleries = $la->galleries;
            foreach ($galleries as $gallery) {
                @unlink('assets/front/img/gallery/'.$gallery->image);
                $gallery->delete();
            }
        }

        // deleting portfolios for corresponding language
        if (!empty($la->portfolios)) {
            $portfolios = $la->portfolios;
            foreach ($portfolios as $portfolio) {
                @unlink('assets/front/img/portfolios/featured/'.$portfolio->featured_image);

                // deleting slider images of the specific portfolio
                $pis = $portfolio->portfolio_images;
                foreach ($pis as $pi) {
                    @unlink('assets/front/img/portfolios/sliders/'.$pi->image);
                    $pi->delete();
                }
                $portfolio->delete();
            }
        }


        // deleting product category for corresponding language
        if (!empty($la->pcategories)) {
            $pcat = $la->pcategories;
            foreach ($pcat as $cat) {
                $cat->delete();
            }
        }

        // deleting shipping charge for corresponding language
        if (!empty($la->shippings)) {
            $shippings = $la->shippings;
            foreach ($shippings as $shipping) {
                $shipping->delete();
            }
        }
        // deleting product for corresponding language
        if (!empty($la->products)) {
            $products = $la->products;
            foreach ($products as $product) {
                @unlink('assets/front/img/product/featured/'.$product->feature_image);

                // deleting slider images of the specific portfolio
                $product_images = $product->product_images;
                foreach ($product_images as $pimg) {
                    @unlink('assets/front/img/product/sliders/'.$pimg->image);
                    $pimg->delete();
                }
                $product->delete();
            }
        }


        // deleting services for corresponding language
        if (!empty($la->blogs)) {
            $blogs = $la->blogs;
            foreach ($blogs as $blog) {
                @unlink('assets/front/img/blogs/'.$blog->main_image);
                $blog->delete();
            }
        }

        // deleting blog categories for corresponding language
        if (!empty($la->bcategories)) {
            $bcategories = $la->bcategories;
            foreach ($bcategories as $bcat) {
                $bcat->delete();
            }
        }

        // deleting points for corresponding language
        if (!empty($la->points)) {
            $la->points()->delete();
        }

        // deleting packages for corresponding language
        if (!empty($la->statistics)) {
            $la->statistics()->delete();
        }

        // deleting useful links for corresponding language
        if (!empty($la->ulinks)) {
            $la->ulinks()->delete();
        }

        // deleting faqs for corresponding language
        if (!empty($la->faqs)) {
            $la->faqs()->delete();
        }

        // deleting inputs for corresponding language
        if (!empty($la->quote_inputs)) {
            $ins = $la->quote_inputs;
            foreach ($ins as $in) {
                if ($in->quote_input_options()->count() > 0) {
                    $in->quote_input_options()->delete();
                }
                $in->delete();
            }
        }

        // deleting event calendars for corresponding language
        if (!empty($la->calendars)) {
            $la->calendars()->delete();
        }

        // deleting menus for corresponding language
        if (!empty($la->menus)) {
            $la->menus()->delete();
        }

        // deleting offline gateways for corresponding language
        if (!empty($la->offline_gateways)) {
            $la->offline_gateways()->delete();
        }


        // if the the deletable language is the currently selected language in frontend then forget the selected language from session
        session()->forget('lang');

        $la->delete();
        return back()->with('success', 'Delete Successfully');
    }


    public function default(Request $request, $id)
    {
        Language::where('is_default', 1)->update(['is_default' => 0]);
        $lang = Language::find($id);
        $lang->is_default = 1;
        $lang->save();
        return back()->with('success', $lang->name . ' laguage is set as defualt.');
    }

    public function rtlcheck($langid) {
        if ($langid > 0) {
            $lang = Language::find($langid);
        } else {
            return 0;
        }

        return $lang->rtl;
    }
}
