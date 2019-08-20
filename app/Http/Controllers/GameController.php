<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Game;
use App\User;

class GameController extends Controller
{
    public function get_games()
    {
        $gameModel = new Game();
        $games = $gameModel->get();

        $scores = [];
        $users = [];

        foreach($games as $game) {
            $scores[] = $game->score;

            $users[] = User::with('score')->get();
        }

        return $users;
    }
}
