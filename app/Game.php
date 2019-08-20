<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Score;

class game extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    public function score()
    {
        return $this->hasMany('App\Score');
    }
}
