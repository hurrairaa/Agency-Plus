<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    protected $fillable = ['title','text','language_id','charge'];

    public function language() {
        return $this->belongsTo('App\Language');
    }
}
