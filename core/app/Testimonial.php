<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    public $timestamps = false;

    public function language() {
        return $this->belongsTo('App\Language');
    }
}
