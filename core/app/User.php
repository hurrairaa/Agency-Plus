<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'photo',
        'username',
        'password',
        'number',
        'city',
        'state',
        'address',
        'country',
        'billing_fname',
        'billing_lname',
        'billing_email',
        'billing_photo',
        'billing_number',
        'billing_city',
        'billing_state',
        'billing_address',
        'billing_country',
        'shpping_fname',
        'shpping_lname',
        'shpping_email',
        'shpping_photo',
        'shpping_number',
        'shpping_city',
        'shpping_state',
        'shpping_address',
        'shpping_country',
        'status',
        'verification_link',
        'email_verified',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders() {
        return $this->hasMany('App\ProductOrder');
    }
}
