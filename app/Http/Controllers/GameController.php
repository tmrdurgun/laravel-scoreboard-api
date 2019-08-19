<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Game;

class GameController extends Controller
{
    public function get_games()
    {
        $gameModel = new Game();
        $games = $gameModel->get();

        $scores = [];

        foreach($games as $game) {
            $scores[] = $game->score;
        }

        return $scores;
    }
}
