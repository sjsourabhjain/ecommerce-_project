<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ProductVariant extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'product_id',
        'variant_id'
    ];

    public function productDetails(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }

    public function variantDetails(){
        return $this->belongsTo('App\Models\Variant','variant_id','id');
    }
}
