<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use Translatable;

    protected $with = ['translations'];

    protected $translatedAttributes = ['name'];

    protected $fillable = ['is_active', 'photo'];

    protected $hidden = ['translations'];

    protected $casts = ['is_active' => 'boolean'];

    public function active()
    {
        return $this->is_active == 0 ? 'غير مفعل' : 'مفعل';
    }

    public function getPhotoAttribute($v)
    {
        return $v != '' ? asset('images/brands/' . $v) : '';
    }
}
