<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PortfolioImage extends Model
{
    public function portfolio() {
      return $this->belongsTo('App\Portfolio');
    }
}
