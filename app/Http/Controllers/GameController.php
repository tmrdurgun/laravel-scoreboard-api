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

      $response = [];

      foreach($games as $game) {

        $gameUsers = [];

        foreach ($game->score as $score) {
          $gameUsers[] = $score->user_id;
        };

        $uniqueUsers = collect($gameUsers)->unique()->values()->all();
        $total_play_count = count($uniqueUsers);

        $response[] = [
          'id' => $game->id,
          'title' => $game->title,
          'unique_users' => $uniqueUsers,
          'total_play_count' => $total_play_count
        ];
      }

      return $response;
    }
}
