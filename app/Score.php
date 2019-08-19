<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Game;

class Score extends Model
{
    
    public function game()
    {
        return $this->hasOne('App\Game');
    }
}
