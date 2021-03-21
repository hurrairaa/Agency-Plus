<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sitemap extends Model
{
    protected $fillable = ['sitemap_url','filename'];
    protected $table    = 'sitemaps';

    public $timestamps  = false;

}
