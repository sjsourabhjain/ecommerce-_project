<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ProductVariantCombination extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'product_id',
        'price',
        'image_name',
        'description'
    ];

    public function productDetails(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }

    public function combinationDetails(){
        return $this->hasMany('App\Models\ProductVariantCombinationDetails',"pvc_id","id");
    }

    public function variantImages(){
        return $this->hasMany('App\Models\ProductVariantImage',"comb_id","id");
    }
}
