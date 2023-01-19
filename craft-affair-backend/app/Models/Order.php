<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Order extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'total_price',
        'total_discount',
        'address_id',
        'user_id'
    ];

    public function orderDetails(){
        return $this->hasMany('App\Models\OrderDetail','order_id','id');
    }

    public function userDetails(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
