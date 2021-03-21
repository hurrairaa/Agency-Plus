<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $timestamps = false;

    public function scategory() {
      return $this->belongsTo('App\Scategory');
    }

    public function portfolios() {
      return $this->hasMany('App\Portfolio');
    }

    public function language() {
      return $this->belongsTo('App\Language');
    }
}
