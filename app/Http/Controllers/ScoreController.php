<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Score;
use App\Game;
use App\User;

use App\Repository\ScoreRepository;

class ScoreController extends Controller
{
    public function GetScoreboard(Request $request)
    {
        $data = $request->json()->all();
        $game_id = $data['game_id'];

        $scoreRepository = new ScoreRepository();

        $response = $scoreRepository->GetScoreboard($game_id);

        return $response;
    }

    public function AddScore(Request $request)
    {      
        $data = $request->json()->all();

        $game_id = $data['game_id'];
        $user_id = $data['user_id'];
        $score = $data['score'];

        $scoreRepository = new ScoreRepository();

        $response = $scoreRepository->AddScore($game_id, $user_id, $score);

        return $response;
    }

}
