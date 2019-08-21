<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repository\GameRepository;

class GameController extends Controller
{
    public function GetGames()
    {
      $gameRepository = new GameRepository();

      $games = $gameRepository->GetGames();

      return $games;
    }
}
