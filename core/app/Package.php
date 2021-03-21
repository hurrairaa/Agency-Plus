<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = ['title', 'language_id', 'price', 'description', 'serial_number', 'meta_keywords', 'meta_description', 'color'];

    public function language() {
      return $this->belongsTo('App\Language');
    }
}
