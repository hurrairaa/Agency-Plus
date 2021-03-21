<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = ['product_id','user_id','review','comment'];

    public function user() {
        return $this->hasOne('App\User','id','user_id');
    }
}

