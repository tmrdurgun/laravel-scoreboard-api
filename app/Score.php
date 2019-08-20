<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Game;
use App\User;

class Score extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    
    public function game()
    {
        return $this->hasOne('App\Game');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
