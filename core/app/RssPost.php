<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RssPost extends Model
{
    protected $fillable = ['language_id','rss_feed_id','title','slug','photo','description','rss_link'];
    protected $table    = 'rss_posts';
    public $timestamps  = false;

    public function category(){
        return $this->belongsTo('App\RssFeed','rss_feed_id');
    }
}
