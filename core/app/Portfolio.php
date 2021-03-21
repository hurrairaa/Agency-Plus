<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = ['id', 'language_id', 'title', 'slug', 'start_date', 'submission_date', 'client_name', 'tags', 'featured_image', 'content', 'service_id', 'status', 'serial_number', 'meta_keywords', 'meta_description'];

    public function portfolio_images()
    {
        return $this->hasMany('App\PortfolioImage');
    }

    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function language()
    {
        return $this->belongsTo('App\Language');
    }
}
