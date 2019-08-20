<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Game;
use App\User;

class Score extends Model
{
    
    public function game()
    {
        return $this->hasOne('App\Game');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
