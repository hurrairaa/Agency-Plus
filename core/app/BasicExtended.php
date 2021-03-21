<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasicExtended extends Model
{
    protected $table = 'basic_settings_extended';
    public $timestamps = false;

    public function language() {
        return $this->belongsTo('App\Language');
    }
}
