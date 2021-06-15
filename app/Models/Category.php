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

    public function categories()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}
