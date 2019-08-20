<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Score;

class game extends Model
{
    
    public function score()
    {
        return $this->hasMany('App\Score');
    }
}
