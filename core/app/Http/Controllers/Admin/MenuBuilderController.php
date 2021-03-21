<?php

namespace App\Http\Controllers\Admin;

use App\BasicSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use App\Menu;
use App\Page;
use Illuminate\Support\Facades\Session;

use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;

class MenuBuilderController extends Controller
{

    public function index(Request $request) {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;

        // set language
        app()->setLocale($lang->code);

        // get page names of selected language
        $pages = Page::where('language_id', $lang->id)->get();
        $data["pages"] = $pages;

        // get previous menus
        $menu = Menu::where('language_id', $lang->id)->first();
        $data['prevMenu'] = '';
        if (!empty($menu)) {
            $data['prevMenu'] = $menu->menus;
        }

        return view('admin.menu_builder.index', $data);
    }

    public function update(Request $request) {
        Menu::where('language_id', $request->language_id)->delete();

        $menu = new Menu;
        $menu->language_id = $request->language_id;
        $menu->menus = $request->str;
        $menu->save();

        Session::flash('success', 'Menu updated successfully!');
        return "success";
    }
}
