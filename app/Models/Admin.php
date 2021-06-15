<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable
{
    protected $table = 'admins';

    // means that all attribute is fillable
    protected $guarded = [];

    public $timestamps = true;

    // public function getPasswordAttribute($v)
    // {
    //     return $this->password == bcrypt($v);
    // }
}
