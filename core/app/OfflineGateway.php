<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfflineGateway extends Model
{
    protected $fillable = ['id', 'language_id', 'name', 'short_description', 'instructions', 'serial_number', 'status', 'is_receipt', 'receipt'];

    public function offline_gateway() {
        return $this->belongsTo('App\OfflineGateway');
    }
}
