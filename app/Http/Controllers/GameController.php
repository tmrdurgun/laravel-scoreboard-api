<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Game;
use App\User;
use App\Http\Resources\GameResource;
use App\Http\Resources\GamesResource;


class GameController extends Controller
{

    public function show(Game $game)
    {
        GameResource::withoutWrapping();
        
        return new GameResource($game);
    }

    public function get_games()
    {
      $games = new GamesResource(Game::class);
    }
}
