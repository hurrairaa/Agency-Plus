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
        if (!file_exists('core/storage/installed') && !request()->is('install') && !request()->is('install/*')) {
            header("Location: install/");
            exit;
        }
    }
}
