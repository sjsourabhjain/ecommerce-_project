<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class OrderDetail extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'quantity',
        'price'
    ];
 
    public function orderData(){
        return $this->belongsTo('App\Models\Order','order_id','id');
    }
 
    public function productDetails(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }
 
    public function productVariantCombination(){
        return $this->belongsTo('App\Models\ProductVariantCombination','variant_id','id');
    }
}