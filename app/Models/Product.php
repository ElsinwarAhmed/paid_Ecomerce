<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Translatable, SoftDeletes;

    protected $with = ['translations'];

    protected $fillable = ['brand_id', 'slug', 'sku', 'price', 'special_price', 'special_price_type', 'special_price_start', 'special_price_end', 'selling_price', 'manage_stock', 'qty', 'in_stock', 'is_active'];

    protected $hidden = ['translations'];

    protected $casts = ['manage_stock' => 'boolean', 'in_stock' => 'boolean', 'is_active' => 'boolean'];

    protected $dates = ['special_price_start', 'special_price_end', 'start_date', 'end_date', 'deleted_at'];

    protected $translatedAttributes = ['name', 'description', 'short_description'];


    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }


    public function getActive()
    {
        return $this->is_active == 0 ? 'غير مفعل' : 'مفعل';
    }


    public function brand()
    {
        return $this->belongsTo('App\Models\Brand')->withDefault();
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'product_category');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'product_tag');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

    public function options()
    {
        return $this->hasMany('App\Models\Option');
    }


    public function wishlist()
    {
        return $this->belongsToMany('App\Models\User', 'wish_lists')->withTimestamps();
    }
}
