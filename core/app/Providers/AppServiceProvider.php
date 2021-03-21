<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\BasicSetting as BS;
use App\BasicExtended as BE;
use App\Social;
use App\Ulink;
use App\Page;
use App\Scategory;
use App\Language;
use App\Menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $socials = Social::orderBy('serial_number', 'ASC')->get();
        $langs = Language::all();

        view()->composer('*', function ($view)
        {
            if (session()->has('lang')) {
                $currentLang = Language::where('code', session()->get('lang'))->first();
            } else {
                $currentLang = Language::where('is_default', 1)->first();
            }

            $bs = $currentLang->basic_setting;
            $be = $currentLang->basic_extended;
            $bex = $currentLang->basic_extra;

            $ulinks = $currentLang->ulinks;
            if (hasCategory($be->theme_version)) {
                $scats = $currentLang->scategories()->where('status', 1)->orderBy('serial_number', 'ASC')->get();
            }

            if (Menu::where('language_id', $currentLang->id)->count() > 0) {
                $menus = Menu::where('language_id', $currentLang->id)->first()->menus;
            } else {
                $menus = json_encode([]);
            }

            if ($currentLang->rtl == 1) {
                $rtl = 1;
            } else {
                $rtl = 0;
            }

            $view->with('bs', $bs );
            $view->with('be', $be );
            $view->with('bex', $bex );
            if (hasCategory($be->theme_version)) {
                $view->with('scats', $scats );
            }
            $view->with('ulinks', $ulinks );
            $view->with('menus', $menus );
            $view->with('currentLang', $currentLang );
            $view->with('rtl', $rtl );
        });

        View::share('socials', $socials);
        View::share('langs', $langs);
    }
}
