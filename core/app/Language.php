<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['id', 'name', 'is_default', 'code', 'rtl'];

    public function basic_setting() {
        return $this->hasOne('App\BasicSetting');
    }

    public function basic_extended() {
        return $this->hasOne('App\BasicExtended', 'language_id');
    }

    public function basic_extra() {
        return $this->hasOne('App\BasicExtra', 'language_id');
    }

    public function packages() {
        return $this->hasMany('App\Package');
    }

    public function sliders() {
        return $this->hasMany('App\Slider');
    }

    public function features() {
        return $this->hasMany('App\Feature');
    }

    public function points() {
        return $this->hasMany('App\Point');
    }

    public function statistics() {
        return $this->hasMany('App\Statistic');
    }

    public function testimonials() {
        return $this->hasMany('App\Testimonial');
    }

    public function members() {
        return $this->hasMany('App\Member');
    }

    public function partners() {
        return $this->hasMany('App\Partner');
    }

    public function ulinks() {
        return $this->hasMany('App\Ulink');
    }

    public function pages() {
        return $this->hasMany('App\Page');
    }

    public function scategories() {
        return $this->hasMany('App\Scategory');
    }

    public function services() {
        return $this->hasMany('App\Service');
    }

    public function portfolios() {
        return $this->hasMany('App\Portfolio');
    }

    public function galleries() {
        return $this->hasMany('App\Gallery');
    }

    public function faqs() {
        return $this->hasMany('App\Faq');
    }

    public function bcategories() {
        return $this->hasMany('App\Bcategory');
    }

    public function blogs() {
        return $this->hasMany('App\Blog');
    }

    public function jcategories() {
        return $this->hasMany('App\Jcategory');
    }

    public function jobs() {
        return $this->hasMany('App\Job');
    }

    public function quote_inputs() {
        return $this->hasMany('App\QuoteInput');
    }

    public function package_inputs() {
        return $this->hasMany('App\PackageInput');
    }

    public function calendars() {
        return $this->hasMany('App\CalendarEvent');
    }

    public function menus() {
        return $this->hasMany('App\Menu');
    }

    public function feed(){
        return $this->hasMany('App\RssFeed');
    }

    public function sitemaps(){
        return $this->hasMany('App\Sitemap');
    }
    public function products(){
        return $this->hasMany('App\Product');
    }
    public function shippings(){
        return $this->hasMany('App\ShippingCharge');
    }
    public function pcategories(){
        return $this->hasMany('App\Pcategory');
    }

    public function offline_gateways() {
        return $this->hasMany('App\OfflineGateway');
    }
}
