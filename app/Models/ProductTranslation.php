<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    protected $fillable = ['name', 'description', 'shor_description'];
    public $timestamps = false;
}
