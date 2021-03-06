<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;

    protected $with = ['translations'];

    protected $translatedAttributes = ['name'];

    protected $fillable = ['slug', 'is_active', 'parent_id'];

    protected $hidden = ['translations'];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeParent($q)
    {
        // return $q->where('parent_id', null);
        return $q->whereNull('parent_id', null);
    }

    public function scopeChild($q)
    {
        return $q->whereNotNull('parent_id', null);
    }

    public function scopeIsactive($q)
    {
        return $q->where('is_active', 1);
    }

    public function active()
    {
        return $this->is_active == 0 ? 'غير مفعل' : 'مفعل';
    }


    public function childrens()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'product_category');
    }
}
