<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageOrder extends Model
{
    protected $fillable = ['order_number', 'name', 'email', 'fields', 'nda', 'package_title', 'package_price', 'status', 'package_description', 'invoice', 'method', 'receipt', 'payment_status'];
}
