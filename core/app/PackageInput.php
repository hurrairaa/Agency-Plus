<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageInput extends Model
{
    protected $fillable = ['language_id', 'type', 'label', 'name', 'placeholder', 'required', 'active'];

    public function package_input_options()
    {
        return $this->hasMany('App\PackageInputOption');
    }

    public function language() {
      return $this->belongsTo('App\Language');
    }
}
