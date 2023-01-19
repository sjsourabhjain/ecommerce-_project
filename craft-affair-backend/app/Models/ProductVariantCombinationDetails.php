<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ProductVariantCombinationDetails extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'product_id',
        'pvc_id',
        'variant_id',
        'variant_value'
    ];

    public function productDetails(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }

    public function variantDetails(){
        return $this->belongsTo('App\Models\Variant','variant_id','id');
    }

    public function productVariantCombination(){
        return $this->belongsTo('App\Models\ProductVariantCombination','pvc_id','id');
    }
}
