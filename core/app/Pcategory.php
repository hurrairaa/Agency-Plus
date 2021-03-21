<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pcategory extends Model
{
    protected $fillable = ['name','language_id','status','slug'];

    public function products() {
        return $this->hasMany('App\Product','category_id','id');
    }

    public function language() {
        return $this->belongsTo('App\Language');
    }
}
