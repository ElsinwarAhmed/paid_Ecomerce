<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVerificationCode extends Model
{
    protected $fillable = ['code', 'user_id'];
    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
