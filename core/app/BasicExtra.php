<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasicExtra extends Model
{
    protected $table = 'basic_settings_extra';
    public $timestamps = false;

    public function language() {
        return $this->belongsTo('App\Language');
    }
}
