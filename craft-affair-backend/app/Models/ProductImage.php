<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ProductImage extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'image_name',
        'product_id',
        'is_primary',
    ];

    public function productDetails(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }
}
