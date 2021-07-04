<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['photo', 'product_id'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
