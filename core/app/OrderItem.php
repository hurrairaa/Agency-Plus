<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        "product_order_id",
        "product_id",
        "user_id",
        "title",
        "sku",
        "category",
        "image",
        "summary",
        "description",
        "price",
        "previous_price",

       ];

       public function product() {
           return $this->belongsTo('App\Product');
       }

}
